# Exit when any command returns a failure status.
set -e

# Read arguments
environment=$1

# Initialize Terraform.
terraform init -input=false -backend-config="environments/$environment/$environment.backend.tfvars"

# Apply the Terraform plan.
terraform apply -input=false -auto-approve -var-file="environments/$environment/$environment.tfvars"

# Get the App Service name for the environment.
webAppName=$(terraform output appservice_name | tr -d '"')

# Write the webAppName variable to the pipeline.
echo "##vso[task.setvariable variable=WebAppName;isOutput=true]$webAppName"
