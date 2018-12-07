data "aws_region" "current" {}

data "aws_caller_identity" "current" {}

data "aws_ami" "notejam_app" {
  most_recent = true

  filter {
    name = "name"
    values = ["*notejam-mysql-*"]
  }
  owners = ["${data.aws_caller_identity.current.account_id}"]
}

data "template_file" "notejam_config" {
  template = "${file("user_data.tpl")}"

  vars {
    mysql_host = "${module.rds.this_db_instance_endpoint}"
    mysql_root_password = "${var.mysql_root_password}"
    mysql_tcp_port = "${var.mysql_tcp_port}"
    node_env = "${var.node_env}"
    notejam_host = "${module.elb.this_elb_dns_name}"
    notejam_port = "${var.notejam_port}"
  }
}

data "template_cloudinit_config" "notejam_config" {
  gzip = true
  base64_encode = true

  part {
    filename = "/etc/init/notejam-mysql.conf"
    content = "${data.template_file.notejam_config.rendered}"
  }
}

locals {
  mysql_host = "${module.rds.this_db_instance_endpoint}"
  notejam_host = "${module.elb.this_elb_dns_name}"
}

variable "mysql_root_password" {
  type = "string"
}

variable "mysql_tcp_port" {
  type = "string"
  default = "3306"
}

variable "node_env" {
  type = "string"
  default = "development"
}

variable "notejam_port" {
  type = "string"
  default = "3000"
}

variable "notejam_version" {
  type = "string"
}

variable "ssh_key_name" {
  type = "string"
}
