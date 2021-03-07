terraform {
  required_version = ">= 0.14"
  required_providers {
    azurerm = {
      version = ">=2.0.0"
    }
  }

  backend "azurerm" {
  }
}

provider "azurerm" {
  features {}
}

locals {
  resource_group_name   = join("-", ["RG", var.region_acronym, var.location_acronym, var.environment, var.application])
  app_service_plan_name = join("-", ["ASP", var.region_acronym, var.location_acronym, var.environment, var.application])
  app_service_name      = join("-", ["WAS", var.region_acronym, var.location_acronym, var.environment, var.application])
  app_insights_name     = join("-", ["AIN", var.region_acronym, var.location_acronym, var.environment, var.application])
  log_analytics_name    = join("-", ["LAW", var.region_acronym, var.location_acronym, var.environment, var.application])
}

resource "azurerm_resource_group" "rg_notejam" {
  name     = local.resource_group_name
  location = var.resource_group_location
}

resource "azurerm_application_insights" "ain_notejam" {
  name                = local.app_insights_name
  location            = azurerm_resource_group.rg_notejam.location
  resource_group_name = azurerm_resource_group.rg_notejam.name
  application_type    = var.application_type
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

resource "azurerm_app_service" "was_notejam" {
  name                = local.app_service_name
  location            = azurerm_resource_group.rg_notejam.location
  resource_group_name = azurerm_resource_group.rg_notejam.name
  app_service_plan_id = azurerm_app_service_plan.asp_notejam.id

  site_config {
    always_on        = true
    http2_enabled    = true
    https_only       = true
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
