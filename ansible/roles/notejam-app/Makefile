.PHONY: help
.DEFAULT_GOAL := help

# Self-documenting makefile compliments of François Zaninotto http://bit.ly/2PYuVj1

help:
	@echo "Make targets for NoteJam MySQL:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

get-dep-images: ## Retrieve dependent Docker containers before containerized testing
	@docker pull gtrummell/iac-testkit-ubuntu:18.04

get-dep-notejam: ## Package the NoteJam node.js repo for deployment
	@tar czf ./files/notejam-mysql.tgz ../../../notejam

get-dep-roles: ## Retrieve dependent Ansible roles for local or in-container testing
	@ansible-galaxy install -c -r ./requirements.yml

global-clean: ## Sanitize the workspace by removing node modules, containers, etc.
	@rm -rf ./notejam-mysql.tgz

test-container-launch: global-clean get-dep-notejam get-dep-images  ## Test the code needed to build a Docker images for the application
	@docker run -it -v $(shell pwd):/etc/ansible/roles/notejam-app --rm gtrummell/iac-testkit-ubuntu:18.04 "cd /etc/ansible/roles/notejam-app; make test-in-container"

test-in-container: get-dep-roles # Test scripts to be run in the container when it launches
	@yamllint .yamllint
	@ansible-lint ./tests/test.yml --exclude=${HOME}/.ansible/roles/geerlingguy.nodejs
	@ansible-playbook -i ./tests/inventory --skip-tags=notest ./tests/test.yml --syntax-check
	@ansible-playbook -i ./tests/inventory --skip-tags=notest ./tests/test.yml --skip-tags "notest"
	@ansible-playbook -i ./tests/inventory --skip-tags=notest ./tests/test.yml --skip-tags "notest"
	@rm -f ./tests/test.retry
