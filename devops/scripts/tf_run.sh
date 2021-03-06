# Exit when any command returns a failure status.
set -e

# Initialize Terraform.
terraform init -input=false -backend-config="terraform/environments/$(environment)/$(environment).backend.tfvars"
# Apply the Terraform plan.
terraform apply -input=false -auto-approve

# Get the App Service name for the environment.
WebAppName=$(terraform output appservice_name)

# Write the WebAppName variable to the pipeline.
echo "##vso[task.setvariable variable=WebAppName;isOutput=true]$WebAppName" | tr -d '"'
