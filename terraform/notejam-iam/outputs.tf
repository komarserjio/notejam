output "notejam_app_iam_role" {
  value = "${aws_iam_role.notejam_app.name}"
  description = "IAM role to be used with NoteJam App EC2 instances"
}

output "notejam_db_iam_role" {
  value = "${aws_iam_role.notejam_db.name}"
  description = "IAM role to be used with NoteJam RDS database instances"
}
