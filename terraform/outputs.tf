output "mysql_host" {
  value = "${module.rds.this_db_instance_endpoint}"
}

output "mysql_root_password" {
  value = "${module.rds.this_db_instance_password}"
}

output "mysql_tcp_port" {
  value = "${module.rds.this_db_instance_port}"
}

output "node_env" {
  value = "${var.node_env}"
}

output "notejam_host" {
  value = "${module.elb.this_elb_dns_name}"
}

output "notejam_port" {
  value = "${var.notejam_port}"
}

output "notejam_version" {
  value = "${var.notejam_version}"
}
