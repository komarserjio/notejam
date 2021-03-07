locals {
  resource_group_name    = join("-", ["RG", var.region_acronym, var.location_acronym, var.environment, var.application])
  app_service_plan_name  = join("-", ["ASP", var.region_acronym, var.location_acronym, var.environment, var.application])
  app_service_name       = join("-", ["WAS", var.region_acronym, var.location_acronym, var.environment, var.application])
  app_insights_name      = join("-", ["AIN", var.region_acronym, var.location_acronym, var.environment, var.application])
  log_analytics_name     = join("-", ["LAW", var.region_acronym, var.location_acronym, var.environment, var.application])
  autoscale_setting_name = join("-", ["AS", var.region_acronym, var.location_acronym, var.environment, var.application])
}

resource "azurerm_resource_group" "rg_notejam" {
  name     = local.resource_group_name
  location = var.resource_group_location
}

resource "azurerm_app_service_plan" "asp_notejam" {
  name                = local.app_service_plan_name
  location            = azurerm_resource_group.rg_notejam.location
  resource_group_name = azurerm_resource_group.rg_notejam.name
  kind                = "Linux"
  reserved            = true

  sku {
    tier = var.app_service_plan_tier
    size = var.app_service_plan_size
  }
}

resource "azurerm_monitor_autoscale_setting" "asp_notejam_autoscale_rule" {
  name                = local.autoscale_setting_name
  resource_group_name = local.resource_group_name
  location            = var.resource_group_location
  target_resource_id  = azurerm_app_service_plan.asp_notejam.id
  count               = (var.environment == "TEST" || var.environment == "PROD") ? 1 : 0

  profile {
    name = "autoscaleProfile"

    capacity {
      default = 1
      minimum = 1
      maximum = 20
    }

    rule {
      metric_trigger {
        metric_name        = "CpuPercentage"
        metric_resource_id = azurerm_app_service_plan.asp_notejam.id
        statistic          = "Average"
        time_window        = "PT10M"
        time_grain         = "PT10M"
        time_aggregation   = "Average"
        operator           = "GreaterThan"
        threshold          = 70
      }

      scale_action {
        direction = "Increase"
        type      = "ChangeCount"
        value     = "1"
        cooldown  = "PT5M"
      }
    }

    rule {
      metric_trigger {
        metric_name        = "CpuPercentage"
        metric_resource_id = azurerm_app_service_plan.asp_notejam.id
        statistic          = "Average"
        time_window        = "PT10M"
        time_grain         = "PT10M"
        time_aggregation   = "Average"
        operator           = "LessThan"
        threshold          = 50
      }

      scale_action {
        direction = "Decrease"
        type      = "ChangeCount"
        value     = "1"
        cooldown  = "PT5M"
      }
    }
  }
}

resource "azurerm_application_insights" "ain_notejam" {
  name                = local.app_insights_name
  location            = azurerm_resource_group.rg_notejam.location
  resource_group_name = azurerm_resource_group.rg_notejam.name
  application_type    = var.application_type
}

resource "azurerm_app_service" "was_notejam" {
  name                = local.app_service_name
  location            = azurerm_resource_group.rg_notejam.location
  resource_group_name = azurerm_resource_group.rg_notejam.name
  app_service_plan_id = azurerm_app_service_plan.asp_notejam.id
  https_only          = true

  site_config {
    always_on        = true
    http2_enabled    = true
    min_tls_version  = 1.2
    ftps_state       = "Disabled"
    linux_fx_version = var.site_config_linux_fx_version
    app_command_line = var.site_config_app_command_line
  }

  app_settings = {
    "APPINSIGHTS_INSTRUMENTATIONKEY" = azurerm_application_insights.ain_notejam.instrumentation_key
  }
}

resource "azurerm_log_analytics_workspace" "law_notejam" {
  name                = local.log_analytics_name
  location            = var.resource_group_location
  resource_group_name = local.resource_group_name
  sku                 = "PerGB2018"  # default value, can only be changed for subscriptions created before 2018
  retention_in_days   = var.law_retention_period
}

output "appservice_name" {
  value       = azurerm_app_service.was_notejam.name
  description = "The App Service name"
}

output "website_hostname" {
  value       = azurerm_app_service.was_notejam.default_site_hostname
  description = "The hostname of the website"
}
