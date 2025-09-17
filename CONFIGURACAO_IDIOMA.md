# Configuração do Idioma Português

Este documento explica como configurar o idioma português para as mensagens de erro de autenticação no projeto Olympikus.

## Arquivos Criados/Modificados

### 1. Arquivos de Tradução
- `lang/pt/auth.php` - Mensagens de autenticação em português
- `lang/pt/validation.php` - Mensagens de validação em português

### 2. Configurações Atualizadas
- `config/app.php` - Idioma padrão alterado para 'pt'
- `.env.example` - Exemplo de configuração de idioma
- `app/Http/Requests/Auth/LoginRequest.php` - Mensagens personalizadas adicionadas

## Como Configurar

### 1. Arquivo .env
Crie ou atualize seu arquivo `.env` com as seguintes configurações:

```env
APP_LOCALE=pt
APP_FALLBACK_LOCALE=pt
```

### 2. Limpar Cache (se necessário)
Após fazer as alterações, execute os seguintes comandos para limpar o cache:

```bash
php artisan config:clear
php artisan cache:clear
```

## Mensagens Traduzidas

### Mensagens de Autenticação
- **Credenciais inválidas**: "Essas credenciais não correspondem aos nossos registros."
- **Senha incorreta**: "A senha fornecida está incorreta."
- **Muitas tentativas**: "Muitas tentativas de login. Tente novamente em X segundos."

### Mensagens de Validação
- **E-mail obrigatório**: "O campo e-mail é obrigatório."
- **E-mail inválido**: "O campo e-mail deve ser um endereço de e-mail válido."
- **Senha obrigatória**: "O campo senha é obrigatório."

## Testando

Para testar se as traduções estão funcionando:

1. Acesse a página de login
2. Tente fazer login com credenciais inválidas
3. Deixe os campos em branco e tente submeter
4. Verifique se as mensagens aparecem em português

## Estrutura dos Arquivos de Tradução

Os arquivos de tradução seguem a estrutura padrão do Laravel:

```
lang/
└── pt/
    ├── auth.php      # Mensagens de autenticação
    └── validation.php # Mensagens de validação
```

## Personalizações Adicionais

Para adicionar mais traduções ou personalizar mensagens:

1. Edite os arquivos em `lang/pt/`
2. Adicione novas chaves de tradução conforme necessário
3. Use a função `trans()` ou `__()` no código para acessar as traduções

Exemplo:
```php
// Usando uma tradução personalizada
$message = trans('auth.failed');
// ou
$message = __('auth.failed');
```