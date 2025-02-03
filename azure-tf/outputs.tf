output "storage_account_name" {
  description = "ID da Storage Account criada"
  value       = azurerm_storage_account.storage_account.id
}

output "sa_primary_access_key" {
  description = "Chave de acesso primária da Storage Account"
  value       = azurerm_storage_account.storage_account.primary_access_key
  sensitive   = true
}