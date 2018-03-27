

install:
	docker-compose up -d
	docker-compose exec php bin/console doctrine:database:create
	docker-compose exec php bin/console doctrine:schema:create

test:
	docker-compose exec php vendor/bin/phpunit -c phpunit.xml.dist

clear:
	docker-compose exec php bin/console cache:clear

