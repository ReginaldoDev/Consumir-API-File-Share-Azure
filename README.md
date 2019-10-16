# Consumir-API-File-Share-Azure

Código simples para gerar assinatura e token para consumir via CURL a api REST do FILE Share da Azure.

Link API: localhost:8000/api/v1/{arquivo}

<b>Comandos</b>

- composer install
- npm install

<b> Configurar conexão com o banco </b>

- cp .enx.example .enn
- Editar <b>.env</b> com os parametros de banco
- php artisan migrate:fresh --seed

<b>Usuario do painel</b>

Usuário: admin@admin.com
Senha: lazanha@2468

<b>Parametros de configuração</b>

- Chave de acesso Key 1
- Nome do usuário do container do file share
- Nome do container
- Versão data atual File Share

<b> Final </b>

- php artisan serve
