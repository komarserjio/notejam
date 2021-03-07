terraform {
  backend "azurerm" { }

  required_version = ">= 0.14"
  required_providers {
    azurerm = {
      source  = "hashicorp/azurerm"
      version = ">=2.50.0"
    }
  }
}

provider "azurerm" {
  features {}
}

module "westeurope_infrastructure" {
  source                  = "./modules/multi-region"
  resource_group_location = "westeurope"
  location_acronym        = "NL"
  environment             = var.environment
  app_service_plan_tier   = var.app_service_plan_tier
  app_service_plan_size   = var.app_service_plan_size
}

module "northeurope_infrastructure" {
  source                  = "./modules/multi-region"
  resource_group_location = "northeurope"
  location_acronym        = "IE"
  environment             = var.environment
  app_service_plan_tier   = var.app_service_plan_tier
  app_service_plan_size   = var.app_service_plan_size

  count                   = (var.environment == "TEST" || var.environment == "PROD") ? 1 : 0
}

output "westeurope_infrastructure_outputs" {
  value = module.westeurope_infrastructure
}

output "northeurope_infrastructure_outputs" {
  value = module.northeurope_infrastructure
}
