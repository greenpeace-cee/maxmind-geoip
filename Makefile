# Variables

target_container    ?= php
php_sources         ?= .
js_sources          ?= Resources/public/js
phpcs_ignored_files ?= vendor/*,app/cache/*
fix_path			?= src

# PHP commands

.PHONY: composer-add-github-token
composer-add-github-token:
	docker-compose run --rm php composer config --global github-oauth.github.com $(token)

.PHONY: composer-update
composer-update:
	docker-compose run --rm php composer update $(options)

.PHONY: composer-install
composer-install:
	docker-compose run --rm php composer install $(options)

.PHONY: phploc
phploc:
	docker run --rm -i -v `pwd`:/project jolicode/phaudit bash -c 'phploc $(php_sources); exit $$?'

.PHONY: phpcs
phpcs:
	docker run --rm -i -v `pwd`:/project jolicode/phaudit bash -c 'phpcs $(php_sources) --extensions=php --ignore=$(phpcs_ignored_files) --standard=PSR2; exit $$?'

.PHONY: phpcs-fix
phpcs-fix:
	docker run --rm -i -v `pwd`:`pwd` -w `pwd` grachev/php-cs-fixer --rules=@Symfony --verbose --cache-file=.git/.php_cs.cache fix $(fix_path)

.PHONY: phpcpd
phpcpd:
	docker run --rm -i -v `pwd`:/project jolicode/phaudit bash -c 'phpcpd $(php_sources); exit $$?'

.PHONY: phpdcd
phpdcd:
	docker run --rm -i -v `pwd`:/project jolicode/phaudit bash -c 'phpdcd $(php_sources); exit $$?'


# Symfony bundle commands

.PHONY: phpunit
phpunit: ./vendor/bin/phpunit
	docker-compose run --rm php ./vendor/bin/phpunit --verbose
