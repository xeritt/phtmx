project_name:=phtmx
COMPOSE=docker-compose -p $(project_name) -f docker-compose.yml

#PHP_VERSION=""
# default php version 7.4 
# PHP_VERSION="php/php8.1.3/"
#PHP_VERSION="php/php8.2.10/"
# PHP_VERSION="php/yii2php8.2.4/"
# PHP_VERSION="php/dwchiang-nginx-php8.2.9-fpm/"

create: docker.install install.logs
#	composer install
#	php bin/doctrine orm:schema-tool:create
#	composer create-project luyadev/luya-kickstarter:^1.0 $(project_name)
#	cp Makefile $(project_name)
#	cp -f $(PHP_VERSION)docker-compose.yml $(project_name)
#	cp -r -f $(PHP_VERSION)docker $(project_name)
#	cp -r -f bin/ $(project_name)
#	@echo "Project create success. Go to project dir and run [make install]. After run [make setup]."
	@echo "Enter make shell.php!"
	@echo "composer install"
	@echo "php bin/doctrine orm:schema-tool:create"

orm.create:
	php bin/doctrine orm:schema-tool:create

orm.update:
	php bin/doctrine orm:schema-tool:update --force

orm.sql:
	php bin/doctrine orm:schema-tool:update --dump-sql

install: install.logs copy_env docker.install
	@echo "Install success. Run command [make setup]"

setup: docker.setup
	@echo "Setup success. Go to [https://localhost:8080/]"
	@echo "User admin@admin.com and password admin"

install.logs:
	mkdir logs
	touch logs/error.log
	touch logs/access.log
	touch logs/php-fpm.log

copy_env:
	cp configs/env.php.dist configs/env.php

docker.install:
	$(COMPOSE) up -d

docker.setup:
	$(COMPOSE) exec luya_web setup

docker.restart: docker.stop docker.start

docker.start:
	$(COMPOSE) up -d

docker.stop:
	$(COMPOSE) down

module:
	./vendor/bin/luya module/create

test:
	@echo "Test done."

shell.php:
	$(COMPOSE) exec php_web bash

shell.composer:
	$(COMPOSE) exec php_composer bash
