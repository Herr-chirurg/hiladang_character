deploy: 
	composer install --optimize-autoloader
	php bin/console doctrine:database:create --if-not-exists
	php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
	php bin/console cache:clear --env=prod
	