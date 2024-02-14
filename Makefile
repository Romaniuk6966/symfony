SHELL=/bin/bash

up:
	docker-compose up -d

down:
	docker-compose down --rmi all -v

build:
	docker-compose build --no-cache

stop:
	docker-compose stop

exec:
	docker-compose exec -it php-fpm /bin/sh
