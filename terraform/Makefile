.PHONY: help
.DEFAULT_GOAL := help

# Self-documenting makefile compliments of François Zaninotto http://bit.ly/2PYuVj1

help:
	@echo "Make targets for NoteJam MySQL:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

build-stack-aws: test-stack-aws ## Build a complete application stack in Amazon AWS EC2/RDS using Terraform
	@terraform apply

global-clean: ## Sanitize the workspace by removing modules, temp files, etc.
	@rm -rf ./.terraform

state-clean: ## Clean existing Terraform state
	@rm -rf ./terraform.tfstate ./terraform.tfstate.backup

init: global-clean ## Initialize Terraform and dependencies
	@terraform init

rm-stack-aws: init ## Tear down the AWS stack using Terraform
	@terraform destroy

test-stack-aws: init ## Test a complete application stack in Amazon AWS EC2/RDS using Terraform
	@terraform plan
