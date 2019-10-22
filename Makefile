up:
	docker-compose up

down:
	docker-compose stop

migrate:
	docker-compose exec web php artisan migrate

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
	docker-compose run --rm web ./vendor/bin/codecept run

logs:
	docker-compose logs -f

docs:
	docker-compose run --rm web php artisan idoc:generate

refresh:
	docker-compose run web php artisan migrate:refresh --force --seed -v

reset:
	docker-compose run --rm web php artisan cache:clear
	docker-compose run --rm web php artisan migrate:fresh --force --seed -v
	docker-compose run --rm web php artisan passport:install --force

composer:
	docker-compose run web composer $(filter-out $@,$(MAKECMDGOALS))

bash:
	docker-compose exec web bash

