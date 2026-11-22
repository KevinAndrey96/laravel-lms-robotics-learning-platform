.PHONY: up down restart build logs test migrate seed bash verify clean

up:
	docker compose up -d

down:
	docker compose down

restart:
	docker compose restart

build:
	docker compose build --no-cache

logs:
	docker compose logs -f

test:
	docker compose exec app php artisan test

migrate:
	docker compose exec app php artisan migrate

seed:
	docker compose exec app php artisan db:seed

bash:
	docker compose exec app sh

verify:
	docker compose exec app php database/verify_database.php

clean:
	docker compose down -v --remove-orphans
