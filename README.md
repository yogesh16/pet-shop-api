
# 🐳 PetShop Docker

Docker container for PetShop Laravel Application.

This docker configuration contains

- Nginx
- MySQL
- PHP
- Redis
- Composer
- NPM
- Artisan
- Mailhog  



### 🚨 Important
Before run create ```mysql``` directory inside ```docker``` folder to persist data


## Run Project using Docker

Clone repo using following command

```bash
  git clone https://github.com/yogesh16/pet-shop-api.git
  cd pet-shop-api
```

To start docker container

```bash
  docker-compose up -d --build petshop
```

Install dependency

```bash
  docker-compose run --rm composer install
```

Copy .env file

```bash
  cp src/.env.example src/.env
```  

Migrate database
```bash
  docker-compose run --rm artisan migrate --seed
```

 - Project URL : [```http://localhost:8088```](http://localhost:8088) 

 - Swagger API Documentation : [```http://localhost:8088/api/swagger```](http://localhost:8088/api/swagger)

 - Currency Exchange Swagger API Doc : [```http://localhost:8088/currency-exchange-rate/api/documentation```](http://localhost:8088/currency-exchange-rate/api/documentation)
 
 - Maihog : [```http://localhost:9025```](http://localhost:9025)
 
**Default Admin Credential**

```
Username: admin@petshop.com
Password: password
```

## Running Tests

To run tests

```bash
  docker-compose run --rm artisan test
```


## Useful Docker Commands

To add new composer package
```bash
  docker-compose run --rm composer require package-name
```

To install node dependency
```bash
  docker-compose run --rm npm install
```

To Run PHP Insights
```bash
docker-compose run --rm artisan insights
```

To Run Larastan
```bash
docker-compose run --rm composer run phpstant
```

To Generate Swagger 
```bash
docker-compose run --rm artisan l5-swagger:generate
```

To stop container
```bash
docker-compose down
```

## Acknowledgements

 - [Docker-Compose-Laravel](https://github.com/aschmelyun/docker-compose-laravel)

