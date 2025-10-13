include .env
 
deploy:
	echo "Déploiement sur l'environnement de $(APP_ENV)"

	COMMIT_SHA := $(shell git rev-parse --short HEAD)
	sed -i "/^APP_VERSION_DATE=/d" .env.local
	echo "APP_VERSION_DATE='$(DEPLOY_DATE)'" >> .env.local

	DEPLOY_DATE := $(shell date +'%Y-%m-%d %H:%M:%S')
	echo "APP_VERSION_COMMIT='$(COMMIT_SHA)'" >> .env.local

	composer install --optimize-autoloader
	php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
	php bin/console asset-map:compil
	php bin/console cache:clear --env=$(APP_ENV)