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

variable "resource_group_location" {
  description = "The location of the resource group"
}

variable "region_acronym" {
  description = "The acronym defining the region where the resources are hosted"
}

variable "location_acronym" {
  description = "The acronym defining the location where the resources are hosted"
}

variable "environment" {
  description = "The acronym defining the environment"
}

variable "application" {
  description = "The application name"
}

locals {
  resource_group_name = join("-", ["RG", var.region_acronym, var.location_acronym, var.environment, var.application])
  app_service_plan_name = join("-", ["ASP", var.region_acronym, var.location_acronym, var.environment, var.application])
  app_service_name = join("-", ["WAS", var.region_acronym, var.location_acronym, var.environment, var.application])
  app_insights_name = join("-", ["AIN", var.region_acronym, var.location_acronym, var.environment, var.application])
}

resource "azurerm_resource_group" "rg_notejam" {
  name     = local.resource_group_name
  location = var.resource_group_location
}

resource "azurerm_application_insights" "ain_notejam" {
  name                = local.app_insights_name
  location            = azurerm_resource_group.rg_notejam.location
  resource_group_name = azurerm_resource_group.rg_notejam.name
  application_type    = "Node.JS"
}

resource "azurerm_app_service_plan" "asp_notejam" {
  name                = local.app_service_plan_name
  location            = azurerm_resource_group.rg_notejam.location
  resource_group_name = azurerm_resource_group.rg_notejam.name
  kind                = "Linux"
  reserved            = true

  sku {
    tier = "Basic"
    size = "B1"
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
    linux_fx_version = "NODE|14-lts"
    app_command_line = "npm run start"
  }

  app_settings = {
    "APPINSIGHTS_INSTRUMENTATIONKEY" = azurerm_application_insights.ain_notejam.instrumentation_key
  }
}

output "appservice_name" {
  value       = azurerm_app_service.was_notejam.name
  description = "The App Service name"
}
output "website_hostname" {
  value       = azurerm_app_service.was_notejam.default_site_hostname
  description = "The hostname of the website"
}
