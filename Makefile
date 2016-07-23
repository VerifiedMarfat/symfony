init:
	composer install
	cp .env.sample .env

run:
	vendor/bin/phpunit
