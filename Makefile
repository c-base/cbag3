

install:
	docker-compose up -d
	docker-compose exec php bin/console doctrine:database:create

test:
	docker-compose exec php bin/phpunit
