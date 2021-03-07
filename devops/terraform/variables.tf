variable "environment" {
  description = "The acronym defining the environment"
  default     = "DEV"
}

variable "app_service_plan_tier" {
  description = "The app service plan tier"
  default     = "Basic"
}

variable "app_service_plan_size" {
  description = "The app service plan size, within the selected tier"
  default     = "B1"
}
