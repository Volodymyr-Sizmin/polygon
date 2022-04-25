SHELL := /bin/bash

tests: export APP_ENV=test
tests:
	php bin/console doctrine:database:drop --force || true
	php bin/console doctrine:database:create
	bin/console doctrine:schema:create
	php bin/console doctrine:fixtures:load -n --append
	php bin/phpunit $(FILE)
.PHONY: tests
