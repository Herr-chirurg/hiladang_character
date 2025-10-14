include .env
include .env.local

DEPLOY_DATE := $(shell TZ='Europe/Paris' date +'%Y-%m-%d %H:%M:%S')
COMMIT_SHA := $(shell git rev-parse --short HEAD)
 
deploy:
	echo "Déploiement sur l'environnement de $(APP_ENV)"

	sed -i "/^APP_VERSION_DATE=/d" .env.local
	echo "\nAPP_VERSION_DATE='$(DEPLOY_DATE)'" >> .env.local

	sed -i "/^APP_VERSION_COMMIT=/d" .env.local
	echo "\nAPP_VERSION_COMMIT='$(COMMIT_SHA)'" >> .env.local

	composer install --optimize-autoloader
	php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
	php bin/console asset-map:compil
	php bin/console cache:clear --env=$(APP_ENV)

permissionfix:
	HTTPDUSER=$$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d' ' -f1)
	
	sudo setfacl -dR -m u:"$$HTTPDUSER":rwX -m u:$$(whoami):rwX var
	sudo setfacl -R -m u:"$$HTTPDUSER":rwX -m u:$$(whoami):rwX var
