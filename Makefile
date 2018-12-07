.PHONY: help
.DEFAULT_GOAL := help

# Self-documenting makefile compliments of François Zaninotto http://bit.ly/2PYuVj1

help:
	@echo "Make targets for NoteJam MySQL:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

build-ami: test-ami ## Build an Amazon EC2 AMI for the application
	@packer build packer-notejam-ec2.json

build-container: test-container ## Test the code needed to build a Docker images for the application
	@docker build . -t notejam-app:${NOTEJAM_VERSION} -t notejam-app:latest

build-stack-aws: test-stack-aws ## Build a complete application stack in Amazon AWS EC2/RDS using Terraform
	@cd terraform && $(MAKE) build-stack-aws

build-stack-docker: test-stack-docker ## Build a complete application stack using Docker (testing only)
	@docker-compose up -d

global-clean: ## Sanitize the workspace by removing node modules, containers, etc.
	@docker-compose stop
	@docker-compose rm -f
	@docker rmi -f notejam-app:${NOTEJAM_VERSION}
	@rm -rf ./notejam/node_modules ./notejam/wait-for-it.sh ./terraform/.terraform
	@find ./ -type f -name *.retry -exec rm -f {} \;
	for ansible_role_dir in $(find ./ansible/roles/ -maxdepth 1 -type d ! -name notejam-app | tail -n +2) ; do \
		rm -rf $$ansible_role_dir ; \
    done

global-getdeps: ## Retrieve dependencies locally
	@docker pull mysql:5.7
	@docker pull node:10.13.0
	@docker pull ubuntu:18.04
	@docker pull hadolint/hadolint
	@pip install -r requirements.txt
	@cd ./notejam && npm install
	@ansible-galaxy install -c -p ./ansible/roles -r ./ansible/requirements.yml

rm-stack-aws: ## Tear down the AWS stack using Terraform
	@cd terraform && $(MAKE) rm-stack-aws

rm-stack-docker: ## Tear down the Docker stack
	@docker-compose stop

test-ami: global-clean global-getdeps ## Test the code needed to build an EC2 AMI for the application
	@cd ./ansible/roles/notejam-app && make test-container-launch
	@packer inspect packer-notejam-ec2.json
	@packer validate packer-notejam-ec2.json

test-app: global-clean global-getdeps ## Test the application locally
	@docker-compose up -d db
	@cd notejam && ./node_modules/mocha/bin/mocha tests

test-container: global-clean global-getdeps ## Test the code needed to build a Docker images for the application
	@echo "Testing ./Dockerfile with Haldolint (no news is good news)..."
	@docker run --rm -i hadolint/hadolint < Dockerfile

test-stack-aws: ## Test a complete application stack in Amazon AWS EC2/RDS using Terraform
	@cd terraform && $(MAKE) test-stack-aws

test-stack-docker: ## Test a complete application stack using Docker
	@docker-compose config
