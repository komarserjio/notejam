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

module "paired_regions_infrastructure" {
  source                  = "./modules/multi-region"
  environment             = var.environment
  resource_group_location = each.value.resource_group_location
  region_acronym          = each.value.region_acronym
  location_acronym        = each.value.location_acronym
  app_service_plan_tier   = var.app_service_plan_tier
  app_service_plan_size   = var.app_service_plan_size

  for_each = (var.environment == "TEST" || var.environment == "PROD") ? var.paired_regions : { region1 = var.paired_regions.region1 }
}

output "infrastructure_outputs" {
  value = module.paired_regions_infrastructure
}
