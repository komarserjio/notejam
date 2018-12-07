variable "notejam_port" {
  default = 3000
  description = "Port used by the NoteJam app"
}

variable "notejam_vpc" {
  default = ""
  description = "VPC ID for the VPC into which NoteJam has been deployed"
}

variable "public_port" {
  default = 80
  description = "Port exposed to the public for the NoteJam app"
}

variable "mysql_tcp_port" {
  default = 3306
  description = "Port exposed by RDS MySQL to NoteJam app instances"
}
