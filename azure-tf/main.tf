terraform {
  required_providers {
    azurerm = {
      source  = "hashicorp/azurerm"
      version = "4.17.0"
    }
  }

  # backend "azurerm" {
  #   resource_group_name  = "estudacom"
  #   storage_account_name = "storageestudacom"
  #   container_name      = "estudacom-app"
  #   key                 = "terraform.tfstate"
  # }
}

provider "azurerm" {
  features {}
}