#-----------------------------------------------------------
# Basic Commands
#-----------------------------------------------------------

start:
	sudo systemctl stop apache2.service  nginx.service mysql.service && docker-compose up -d

up:
	docker-compose up -d

down:
	docker-compose down

build:
	docker-compose up -d --build

#-----------------------------------------------------------
# Initial installation
#-----------------------------------------------------------

init: build laravel-env laravel-composer-install laravel-key laravel-migrate laravel-optimize

#-----------------------------------------------------------
# Laravel Commands
#-----------------------------------------------------------

nginx:
	docker-compose exec nginx bash
php-fpm:
	docker-compose exec php-fpm bash
mysql:
	docker-compose exec mysql bash

laravel-env:
	cp .env.example .env

laravel-composer-install:
	docker-compose exec php-fpm composer install

laravel-key:
	docker-compose exec php-fpm php artisan key:generate

laravel-migrate:
	docker-compose exec php-fpm php artisan migrate --seed

laravel-optimize:
	docker-compose exec php-fpm php artisan storage:link

laravel-optimize:
	docker-compose exec php-fpm php artisan optimize:clear
