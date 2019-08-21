IMAGE_NAME = notejam
AWS_DEFAULT_REGION ?= us-east-1
DOCKER_TAG ?= $(shell git rev-parse --short HEAD)
ECR = $(AWS_ACCOUNT_ID).dkr.ecr.$(AWS_DEFAULT_REGION).amazonaws.com
ECR_IMAGE = $(ECR)/$(IMAGE_NAME)

###########################################################################

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) |  \
		awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: check-env
check-env: ## Checks to see if all env vars are present
	@if [ -z $(AWS_ACCOUNT_ID) ]; then \
		echo "Missing env var!"; \
		exit 1;\
	fi

.PHONY: build
build: check-env ## Builds the docker image
	@docker build -t $(ECR_IMAGE):base .

.PHONY: tests
tests: check-env ## Runs unit tests
	@docker run --rm -it $(ECR_IMAGE):$(DOCKER_TAG) python tests.py


.PHONY: push
push: check-env ## Pushes image to your ECR repo
	@docker tag $(ECR_IMAGE):base $(ECR_IMAGE):latest
	@docker tag $(ECR_IMAGE):base $(ECR_IMAGE):$(DOCKER_TAG)
	@docker push $(ECR_IMAGE):$(DOCKER_TAG)
	@docker push $(ECR_IMAGE):latest

.PHONY: deploy
deploy: check-env ## Runs blue-green deployment
	@ecs deploy toptal-demo $(ECR_IMAGE) \
		-i notejam $(ECR_IMAGE):$(DOCKER_TAG) \
		--no-deregister

.PHONY: run-local
run-local: ## use docker-compose to run local env
	@docker-compose build
	@docker-compose up

.PHONY: clean
clean: ## Cleans up images
	@docker images rm $(ECR_IMAGE):base 2>/dev/null || true
	@docker-compose down --rmi all 2>/dev/null || true
