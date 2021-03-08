variable "environment" {
  description = "The acronym defining the environment"
  default     = "DEV"
}

variable "paired_regions" {
  description = "The paired regions (datacentre location, region acronym and location acronym) used in the infrastructure deployments"
  default = { 
    region1 = { 
      resource_group_location = "westeurope"
      region_acronym   = "EUR"
      location_acronym = "NL" 
    },
    region2 = { 
      resource_group_location = "northeurope"
      region_acronym   = "EUR"
      location_acronym = "IE" 
    }
  }
}

variable "app_service_plan_tier" {
  description = "The app service plan tier"
  default     = "Basic"
}

variable "app_service_plan_size" {
  description = "The app service plan size, within the selected tier"
  default     = "B1"
}
