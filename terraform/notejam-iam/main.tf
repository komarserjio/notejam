# Create an IAM role for for the NoteJam MySQL EC2 application

# Policy data to allow EC2 to assume the role and pass it to instances
data "aws_iam_policy_document" "notejam_app_assumerole" {
  statement = {
    effect = "Allow",
    sid = "NoteJamAppAssumeRole"
    actions = [
      "sts:AssumeRole"
    ]
    principals = {
      type = "Service",
      identifiers = [ "ec2.amazonaws.com" ]
    }
  }
}

# Create an IAM role to grant CloudWatch access to NoteJam EC2 instances
resource "aws_iam_role" "notejam_app" {
  name = "NoteJamAppEC2Role"
  assume_role_policy = "${data.aws_iam_policy_document.notejam_app_assumerole.json}"
  path = "/roles/"
  description = "NoteJam-MySQL EC2 IAM Role"
}

# Create an instance profile for attaching the NoteJam App IAM role to the NoteJam EC2 instances
resource "aws_iam_instance_profile" "notejam_app" {
  name = "NoteJamAppEC2Profile"
  path = "/profiles/"
  role = "${aws_iam_role.notejam_app.name}"
}

# Attach NoteJam App IAM policies to the NoteJam App IAM role
resource "aws_iam_role_policy_attachment" "notejam_app_cloudwatch_policy" {
  policy_arn = "arn:aws:iam::aws:policy/CloudWatchAgentServerPolicy"
  role = "${aws_iam_role.notejam_app.name}"
}

# Policy data to allow RDS to assume the role and pass it to RDS database instances
data "aws_iam_policy_document" "notejam_db_assumerole" {
  statement = {
    effect = "Allow",
    sid = "NoteJamRDSAssumeRole"
    actions = [
      "sts:AssumeRole"
    ]
    principals = {
      type = "Service",
      identifiers = [ "rds.amazonaws.com" ]
    }
  }
}

# Create an IAM role to grant CloudWatch access to NoteJam RDS instances
resource "aws_iam_role" "notejam_db" {
  name = "NoteJamRDSRole"
  assume_role_policy = "${data.aws_iam_policy_document.notejam_db_assumerole.json}"
  path = "/roles/"
  description = "NoteJam-MySQL RDS IAM Role"
}

# Create an instance profile for attaching the IAM role to instances
resource "aws_iam_instance_profile" "notejam_db" {
  name = "NoteJamRDSProfile"
  path = "/profiles/"
  role = "${aws_iam_role.notejam_db.name}"
}

# Attach IAM policies to the IAM role
resource "aws_iam_role_policy_attachment" "notejam_db_enh_monitor" {
  policy_arn = "arn:aws:iam::aws:policy/service-role/AmazonRDSEnhancedMonitoringRole"
  role = "${aws_iam_role.notejam_db.name}"
}
