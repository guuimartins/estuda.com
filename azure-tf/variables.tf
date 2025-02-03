variable "location" {
  description = "Região onde os recursos serão criados na azure."
  type        = string
  default     = "Brazil South"
}

variable "account_tier" {
  description = "Tier da storage account na Azure"
  type        = string
  default     = "Standard"
}

variable "account_replication_type" {
  description = "Tipo de replicação de dados da Storage Account"
  type        = string
  default     = "LRS"
}

variable "resource_group_name" {
  description = "Nome do Resource Group onde os recursos serão criados"
  type        = string
  default     = "estudacom"
}

variable "storage_account_name" {
  description = "Nome da Storage Account"
  type        = string
  default     = "storageestudacom"
}

variable "container_name" {
  description = "Nome do container a ser criado na Storage Account"
  type        = string
  default     = "estudacom-app"
}