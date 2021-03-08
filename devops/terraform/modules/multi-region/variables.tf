variable "environment" { }

variable "resource_group_location" { }

variable "region_acronym" { }

variable "location_acronym" { }

variable "application" {
  description = "The application name"
  default     = "Notejam"
}

variable "application_type" {
  description = "The application type"
  default     = "Node.JS"
}

variable "app_service_plan_tier" { }

variable "app_service_plan_size" { }

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
