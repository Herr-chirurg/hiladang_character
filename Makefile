include .env
COMMIT_SHA := $(shell git rev-parse --short HEAD)
DEPLOY_DATE := $(shell date +'%Y-%m-%d %H:%M:%S')
 
deploy:
	echo "Déploiement sur l'environnement de $(APP_ENV)"
	
	sed -i "s/DATE_PLACEHOLDER/$(DEPLOY_DATE)/g" config/services.yaml

	sed -i "s/COMMIT_PLACEHOLDER/$(COMMIT_SHA)/g" config/services.yaml

	composer install --optimize-autoloader
	php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
	php bin/console asset-map:compil
	php bin/console cache:clear --env=$(APP_ENV)