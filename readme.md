# Laravel DDD Sample Application

## Installation

```
$ docker-compose up -d
$ docker-compose run web composer install
$ cp -a .env.example .env
$ docker-compose run web php artisan key:generate
$ docker-compose run web php artisan migrate
$ docker-compose run web php artisan db:seed
$ docker-compose run web ./vendor/bin/phpunit
```

## Sample API

* AddItemToCart

```
$ curl -X POST -F "item_id=3" -F "count=1" -c cookie -b cookie http://localhost:8000/api/cart | jq .

{
  "cart": {
    "elements": [
      {
        "item": {
          "id": 3,
          "name": "Laravel 5.1 Beauty: Creating Beautiful Web Apps in Laravel 5.1",
          "price": 1250
        },
        "count": 1
      }
    ],
    "totalCount": 1,
    "totalPrice": 1250
  }
}
```
