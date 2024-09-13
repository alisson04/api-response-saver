PHP_SERVICE=www

#DOCKER COMPOSE COMMANDS
#========================================
up:
	docker compose up -d

restart:
	docker compose restart

stop:
	docker compose stop

down:
	docker compose down

build:
	docker compose build $(PHP_SERVICE)
	make up

bash:
	docker compose exec $(PHP_SERVICE) bash

#COMPOSER COMMANDS
#========================================
composer-install:
	docker compose exec $(PHP_SERVICE) sh -c "composer install"

composer-update:
	docker compose exec $(PHP_SERVICE) composer update

composer-remove:
	docker compose exec $(PHP_SERVICE) composer remove $(package)

composer-dump:
	docker compose exec $(PHP_SERVICE) sh -c "composer dumpautoload"

composer-require:
	docker compose exec $(PHP_SERVICE) composer require $(package)

composer-show:
	docker compose exec $(PHP_SERVICE) composer show $(package)

#INSIGHTS COMMANDS
#========================================
insights:
	docker compose exec $(PHP_SERVICE) ./vendor/bin/phpinsights

#TEST COMMANDS
#========================================
test-init:
	docker compose exec $(PHP_SERVICE) ./vendor/bin/pest --init

test:
	docker compose exec $(PHP_SERVICE) ./vendor/bin/pest