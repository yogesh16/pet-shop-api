## Run PetShop Locally

Clone the project

```bash
  git clone https://github.com/yogesh16/pet-shop-api.git
```

Go to the project directory

```bash
  cd pet-shop-api/src
```

Install dependencies

```bash
  composer install
```

Copy .env file

```bash
  cp .env.example .env
```  

Update ``.env`` file  

```bash
#Update database connection
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret

#update redis connection
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

Migrate database
```bash
  php artisan migrate --seed
```

Start the server

```bash
  php artisan start
```

 - Swagger API Documentation : [```http://127.0.0.1:8000/api/swagger```](http://127.0.0.1:8000/api/swagger)

 - Currency Exchange Swagger API Doc : [```http://127.0.0.1:8000/currency-exchange-rate/api/documentation```](http://127.0.0.1:8000/currency-exchange-rate/api/documentation)
 
 
**Default Admin Credential**

```
Username: admin@petshop.com
Password: password
```


## Running Tests

To run tests

```bash
  php artisan test
```
