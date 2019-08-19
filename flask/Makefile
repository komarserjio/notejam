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
build: ## Builds the docker image
	@docker build -t $(ECR_IMAGE):$(DOCKER_TAG) .

.PHONY: push
push: ## Pushes image to your ECR repo
	@docker push $(ECR_IMAGE):$(DOCKER_TAG)

.PHONY: run-local
run-local:
	@docker-compose build
	@docker-compose up

.PHONY: clean
clean:
	@docker images rm $(ECR_IMAGE):base 2>/dev/null || true
	@docker-compose down --rmi all 2>/dev/null || true
