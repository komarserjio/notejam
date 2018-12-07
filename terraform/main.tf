module "iam" {
  source = "notejam-iam"
}

module "vpc" {
  source = "terraform-aws-modules/vpc/aws"
  version = "1.46.0"

  azs = [
    "us-west-2a",
    "us-west-2b",
    "us-west-2c"
  ]
  cidr = "172.16.0.0/16"
  create_database_subnet_group = true
  create_database_subnet_route_table = true
  create_vpc = true
  database_subnets = [
    "172.16.201.0/24",
    "172.16.202.0/24",
    "172.16.203.0/24"
  ]
  enable_dns_hostnames = true
  enable_dns_support = true
  enable_nat_gateway = true
  map_public_ip_on_launch = false
  name = "notejam"
  one_nat_gateway_per_az = false
  private_subnets = [
    "172.16.1.0/24",
    "172.16.2.0/24",
    "172.16.3.0/24",
  ]
  public_subnets = [
    "172.16.101.0/24",
    "172.16.102.0/24",
    "172.16.103.0/24",
  ]
  single_nat_gateway = false
}

module "security" {
  source = "notejam-security"

  mysql_tcp_port = "${var.mysql_tcp_port}"
  notejam_port = "${var.notejam_port}"
  notejam_vpc = "${module.vpc.vpc_id}"
  public_port = 80
}

module "rds" {
  source = "terraform-aws-modules/rds/aws"
  version = "1.22.0"

  allocated_storage = 5
  backup_window = "04:00-06:00"
  engine = "mysql"
  engine_version = "5.7.23"
  family = "mysql5.7"
  final_snapshot_identifier = "Notejam${replace(var.notejam_version, ".", "")}DBFinal"
  iam_database_authentication_enabled = true
  identifier = "notejam"
  instance_class = "db.t2.micro"
  maintenance_window = "Sat:00:01-Sat:03:00"
  major_engine_version = "5.7"
  name = "notejam"
  password = "${var.mysql_root_password}"
  port = "${var.mysql_tcp_port}"
  # Remove public IP access for secure operation
  publicly_accessible = true
  subnet_ids = "${module.vpc.database_subnets}"
  username = "root"
  vpc_security_group_ids = [
    "${module.security.notejam_db_security_group_id}"
  ]

  parameters = [
    {
      name = "character_set_client"
      value = "utf8"
    },
    {
      name = "character_set_server"
      value = "utf8"
    }
  ]
}

module "asg" {
  source = "terraform-aws-modules/autoscaling/aws"

  # Remove public IP addresses for secure operation
  associate_public_ip_address = true
  asg_name = "notejam"
  create_lc = true
  desired_capacity = 1
  health_check_type = "ELB"
  image_id = "${data.aws_ami.notejam_app.id}"
  instance_type = "t2.micro"
  key_name = "${var.ssh_key_name}"
  lc_name = "notejam-app-${var.notejam_version}"
  load_balancers = [
    "${module.elb.this_elb_id}"
  ]
  max_size = 3
  min_size = 1
  name = "notejam"
  security_groups = [
    "${module.security.notejam_app_security_group_id}"
  ]
  user_data = "${data.template_cloudinit_config.notejam_config.rendered}"
  vpc_zone_identifier = "${module.vpc.public_subnets}"
  wait_for_capacity_timeout = 0
}

module "elb" {
  source = "terraform-aws-modules/elb/aws"

  name = "notejam"
  subnets = "${module.vpc.public_subnets}"
  security_groups = [
    "${module.security.notejam_elb_security_group_id}"
  ]
  internal = false

  listener = [
    {
      instance_port = "${var.notejam_port}"
      instance_protocol = "HTTP"
      lb_port = "80"
      lb_protocol = "HTTP"
    },
  ]

  health_check = [
    {
      target = "HTTP:${var.notejam_port}/"
      interval = 30
      healthy_threshold = 2
      unhealthy_threshold = 2
      timeout = 5
    },
  ]
}
