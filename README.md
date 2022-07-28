
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


## Run Docker

```bash
  docker-compose up -d --build petshop
```

To start docker container

```bash
  docker-compose up -d --build petshop
```

To install composer dependancy
```bash
  docker-compose run --rm composer install
```

To add new composer package
```bash
  docker-compose run --rm composer require package-name
```

To install node dependancy
```bash
  docker-compose run --rm npm install
```

To migrate database
```bash
docker-compose run --rm artisan migrate
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

