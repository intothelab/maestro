up:
	docker-compose up -d

down:
	docker-compose down

setup:
	docker-compose exec web composer install
	docker-compose exec web cp .env.example .env
	docker-compose exec web php artisan key:generate

migrate:
	docker-compose exec web php artisan migrate

test:
	docker-compose exec web ./vendor/bin/codecept run

lint:
	docker-compose exec web ./vendor/bin/php-cs-fixer fix

build:
	docker-compose exec web ./vendor/bin/codecept build

cache:
	docker-compose run --rm web php artisan cache:clear

reset:
	docker-compose run --rm web php artisan cache:clear
	docker-compose run --rm web php artisan migrate:fresh --force --seed -v

composer:
	docker-compose exec web composer $(filter-out $@,$(MAKECMDGOALS))

bash:
	docker-compose exec web bash

