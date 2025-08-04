test:
	vendor/bin/phpunit

lint-fix:
	vendor/bin/php-cs-fixer fix

lint:
	vendor/bin/php-cs-fixer fix --dry-run --diff

phpstan:
	vendor/bin/phpstan

qa: test lint-fix phpstan
