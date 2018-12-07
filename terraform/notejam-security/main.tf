resource "aws_security_group" "notejam_app_instance" {
  name = "notejam-app-ec2"
  description = "NoteJam-MySQL App on EC2"
  ingress = {
    from_port = "${var.notejam_port}"
    protocol = "TCP"
    security_groups = [ "${aws_security_group.notejam_app_alb.id}" ]
    to_port = "${var.notejam_port}"
    description = "Allows HTTP traffic to NoteJam-MySQL App for EC2"
  }
  egress = {
    from_port = 0
    protocol = "-1"
    self = true
    to_port = 0
    description = "Allows HTTP traffic from the ELB to NoteJam-MySQL App for EC2 instances"
  }
  revoke_rules_on_delete = true
  vpc_id = "${var.notejam_vpc}"
}

resource "aws_security_group" "notejam_app_alb" {
  name = "notejam-app-alb"
  description = "NoteJam-MySQL App on EC2"
  ingress = {
    cidr_blocks = [ "0.0.0.0/0" ]
    from_port = "${var.public_port}"
    protocol = "TCP"
    to_port = "${var.public_port}"
    description = "Allows Load Balancer traffic to the ELB NoteJam-MySQL App for EC2"
  }
  egress = {
    from_port = 0
    protocol = "-1"
    self = true
    to_port = 0
    description = "Allows Load Balancer traffic to NoteJam-MySQL App for EC2"
  }
  revoke_rules_on_delete = true
  vpc_id = "${var.notejam_vpc}"
}

resource "aws_security_group" "notejam_app_db" {
  name = "notejam-db"
  description = "NoteJam-MySQL Database on RDS"
  ingress = {
    from_port = "${var.mysql_tcp_port}"
    protocol = "TCP"
    security_groups = [
      "${aws_security_group.notejam_app_instance.id}"
    ]
    to_port = "${var.mysql_tcp_port}"
    description = "Allows MySQL traffic to NoteJam-MySQL App for EC2"
  }
  egress = {
    from_port = 0
    protocol = "-1"
    self = true
    to_port = 0
    description = "Allows MySQL traffic to NoteJam-MySQL App for EC2"
  }
  revoke_rules_on_delete = true
  vpc_id = "${var.notejam_vpc}"
}
