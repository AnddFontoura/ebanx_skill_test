down:
	docker compose down -v --remove-orphans

up:
	docker compose up -d

restart:
	docker compose down -v --remove-orphans
	docker compose up -d

