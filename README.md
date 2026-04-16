### news-app
App de notícias feito em laravel.

## Iniciar o projeto para rodar local

# Copiar arquivo de variáveis de ambiente
cp application/.env.example application/.env

# Na primeira vez é necessario fazer o build do docker
$ docker compose up -d --build

# Nas demais vezes apenas:
$ docker compose up -d

