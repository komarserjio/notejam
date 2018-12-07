output "notejam_app_security_group_id" {
  value = "${aws_security_group.notejam_app_instance.id}"
}

output "notejam_elb_security_group_id" {
  value = "${aws_security_group.notejam_app_alb.id}"
}

output "notejam_db_security_group_id" {
  value = "${aws_security_group.notejam_app_db.id}"
}
