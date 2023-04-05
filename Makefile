
.PHONY: composer-install

composer-install:
	docker run --rm -it -v $(shell pwd):/app -w /app -u 1000:1000 composer composer install

composer-update:
	docker run --rm -it -v $(shell pwd):/app -w /app -u 1000:1000 composer composer update
