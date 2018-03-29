

install:
	docker-compose up -d
	docker-compose exec php bin/console doctrine:database:create
	docker-compose exec php bin/console doctrine:schema:create

test:
	docker-compose exec php vendor/bin/phpunit -c phpunit.xml.dist

clear:
	docker-compose exec php bin/console cache:clear --env=dev
	docker-compose exec php bin/console cache:clear --env=test
	docker-compose exec php bin/console cache:clear --env=prod


fix-permission:
	docker-compose exec php chown -R 1000:1000 src
	docker-compose exec php chown -R 1000:1000 config
	docker-compose exec php chown -R 1000:1000 vendor
