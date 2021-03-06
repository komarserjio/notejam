variable "resource_group_location" {
  description = "The location of the resource group"
  default     = "westeurope"
}

variable "region_acronym" {
  description = "The acronym defining the region where the resources are hosted"
  default     = "EUR"
}

variable "location_acronym" {
  description = "The acronym defining the location where the resources are hosted"
  default     = "NL"
}

variable "environment" {
  description = "The acronym defining the environment"
  default     = "DEV"
}

variable "application" {
  description = "The application name"
  default     = "Notejam"
}

variable "application_type" {
  description = "The application type"
  default     = "Node.JS"
}

variable "app_service_plan_tier" {
  description = "The app service plan tier"
  default     = "Basic"
}

variable "app_service_plan_size" {
  description = "The app service plan size, within the selected tier"
  default     = "B1"
}

variable "site_config_linux_fx_version" {
  description = "The version of the programming framework used"
  default     = "NODE|14-lts"
}

variable "site_config_app_command_line" {
  description = "The command to start the web application"
  default     = "npm run start"
}

variable "law_retention_period" {
  description = "The number of days to retain logs in Log Analytics Workspace"
  default     = 30
}
