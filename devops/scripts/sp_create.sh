#!/bin/bash

SP_NAME=$1

# Get subscription ID
SP_SUBSCRIPTION_ID=$(az account list \
  --query "[?isDefault][id]" \
  --all \
  --output tsv)

# Create a service principal with Contributor role in the subscription identified by the previous command
SP_CLIENT_SECRET=$(az ad sp create-for-rbac \
  --name $SP_NAME \
  --role Contributor \
  --scopes "/subscriptions/$SP_SUBSCRIPTION_ID" \
  --query password \
  --output tsv)

# Get the service principal's client ID
SP_CLIENT_ID=$(az ad sp show \
  --id http://$SP_NAME \
  --query appId \
  --output tsv)

# Get the service principal's tenant ID
SP_TENANT_ID=$(az ad sp show \
  --id http://$SP_NAME \
  --query appOwnerTenantId \
  --output tsv)

# Output the service principal's details and credentials
echo "Subscription ID: $SP_SUBSCRIPTION_ID"
echo "Service principal client secret: $SP_CLIENT_SECRET"
echo "Service principal client ID: $SP_CLIENT_ID"
echo "Service principal tenant ID: $SP_TENANT_ID"
