

install:
	docker-compose up -d
	docker-compose exec php bin/console doctrine:database:create

test:
	docker-compose exec php vendor/bin/phpunit -c phpunit.xml.dist
