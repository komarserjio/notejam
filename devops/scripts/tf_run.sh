# Exit when any command returns a failure status.
set -e

# Read arguments
environment=$1
isProd=$2

# Initialize Terraform.
terraform init -input=false -backend-config="environments/$environment/$environment.backend.tfvars"

# Apply the Terraform plan.
terraform apply -input=false -auto-approve -var-file="environments/$environment/$environment.tfvars"

# Get the West Europe App Service name for the environment.
webAppNameWestEurope=$(terraform output -json infrastructure_outputs.region1 | jq .appservice_name | tr -d '"')

# Write the West Europe webAppName variable to the pipeline.
echo "##vso[task.setvariable variable=webAppNameWestEurope;isOutput=true]$webAppNameWestEurope"

# Get the North Europe App Service name for the environment, in case it is a production like environment.
if [ $isProd == true ]
then
  webAppNameNorthEurope=$(terraform output -json infrastructure_outputs.region2 | jq .appservice_name | tr -d '"')

  # Write the North Europe webAppName variable to the pipeline.
  echo "##vso[task.setvariable variable=webAppNameNorthEurope;isOutput=true]$webAppNameNorthEurope"
fi
