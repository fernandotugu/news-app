# news-app
App de notícias feito em laravel.

## Iniciar o projeto para rodar local

### Na primeira vez é necessario fazer o build do docker
$ docker compose up -d --build

### Nas demais vezes apenas:
$ docker compose up -d

### após os conatainer subirem popular executar migration para o banco 
docker compose exec app php artisan migrate:fresh --seed

### já rodar a migration para o banco de teste tambem
docker compose exec app php artisan migrate --env=testing

### subir aplicação dev para testar usando o vindi
docker compose exec app npm run dev

### esse ultimo irá servir o host
http://localhost:8000/

## Documentção

http://localhost:8000/api/documentation

## Testes

### Para rodar os testes
docker compose exec app php artisan test

### Para rodar os testes direto pelo pest
docker compose exec app ./vendor/bin/pest

### Para verificar o covarege
docker compose exec app ./vendor/bin/pest --coverage

### rodar e gerar html do covarage
docker compose exec app ./vendor/bin/pest --coverage-html coverage

após o comando acima, ira gerar um diretorio da raiz da pasta application chamado covarage, basta acessar essa pasta e abrir o arquivo index.html externamente no browser de preferencia


