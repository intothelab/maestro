up:
	docker-compose up -d
	docker-compose run --rm web composer install
	docker-compose run --rm web php artisan config:clear
	docker-compose run --rm web php artisan migrate
	docker-compose run --rm web php artisan cache:clear
	docker-compose run --rm web php artisan view:clear
	$(MAKE) passport

down:
	docker-compose stop

clean:
	$(MAKE) down
	docker-compose rm -fv

pull:
	docker-compose pull

cache:
	docker-compose run --rm web php artisan cache:clear

passport:
	docker-compose run --rm web php artisan passport:install

unit:
	docker-compose run --rm --entrypoint=vendor/bin/phpunit artisan --testsuite=unit

integration:
	docker-compose run --rm --entrypoint=vendor/bin/phpunit artisan --testsuite=integration

test:
	docker-compose run --rm --entrypoint=vendor/bin/phpunit artisan

logs:
	docker-compose logs -f

refresh:
	docker-compose run artisan migrate:refresh --force --seed -v

reset:
	docker-compose run --rm web php artisan cache:clear
	docker-compose run --rm web php artisan migrate:fresh --force --seed -v
	docker-compose run --rm web php artisan passport:install --force

composer:
	docker-compose run web composer $(filter-out $@,$(MAKECMDGOALS))

bash:
	docker-compose exec -it web bash

