🃏 Patuscada - Jogo de Cartas em Tempo Real
Patuscada é um jogo de cartas online, desenvolvido com Laravel, que permite partidas em tempo real entre usuários autenticados através de WebSockets. Ideal para se divertir com amigos ou desafiar outros jogadores!

🚀 Funcionalidades
Autenticação de usuários (login e registro)

Partidas em tempo real via WebSockets

Sistema de salas para organizar as partidas

Backend robusto com Laravel + MySQL

Integração com Pusher para comunicação em tempo real

📦 Requisitos
Antes de rodar o projeto, certifique-se de ter os seguintes softwares instalados na sua máquina:

PHP >= 8.2

Composer

MySQL

Node.js >= 16

Laravel CLI (opcional)

⚙️ Instalação
Clone o repositório:

git clone https://github.com/seu-usuario/patuscada.git
cd patuscada

Instale as dependências do PHP:

composer install

Instale as dependências do Node.js:

npm install && npm run dev

Configure o ambiente:

Copie o arquivo .env.example para .env:

cp .env.example .env

Gere a chave da aplicação:

php artisan key:generate

Execute as migrações:

php artisan migrate

Inicie o servidor:

php artisan serve

🔌 WebSockets com Pusher
Este projeto usa Pusher para permitir comunicação em tempo real entre os jogadores. Certifique-se de configurar corretamente as chaves da sua conta no .env. Você pode criar uma conta gratuita em: https://pusher.com/

🛠️ Principais Dependências
Backend (Laravel)
laravel/framework: Estrutura principal da aplicação

pusher/pusher-php-server: Integração com WebSockets

laravel/ui (ou Jetstream/Breeze): Interface de autenticação (dependendo de como você configurou)

guzzlehttp/guzzle: Requisições HTTP

Frontend
Laravel Mix / Vite: Compilação de assets

Pusher JS: Escuta dos eventos em tempo real no navegador

Axios: Requisições HTTP frontend (opcional)

📬 Contato
Caso tenha dúvidas ou sugestões, sinta-se à vontade para abrir uma issue ou entrar em contato.