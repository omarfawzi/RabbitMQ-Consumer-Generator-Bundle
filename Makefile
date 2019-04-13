test:
	php vendor/bin/simple-phpunit
cover:
	php vendor/bin/simple-phpunit --coverage-clover=coverage.xml