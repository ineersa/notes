.DEFAULT_GOAL := help

logs: ## Show logs
	tail -n 30 -f ./storage/logs/laravel.log

helper: ## run ide helper
	php artisan ide-helper:generate
	php artisan ide-helper:meta
	php artisan ide-helper:models --nowrite

helper-install: ## install ide helper
	composer require --dev barryvdh/laravel-ide-helper

cc: ## clear cache related things
	php artisan route:clear
	php artisan view:clear
	php artisan optimize:clear
	php artisan clear-compiled
	php artisan config:clear
	php artisan event:clear
	php artisan optimize
	php artisan icons:cache
	php artisan filament:cache-components

rights: ## set rights for storage directory
	sudo chmod -R 777 ./storage
	sudo chmod -R g+w ./
	sudo chmod -R 777 ./database/users_databases

storage: ## link storage
	php artisan storage:unlink
	php artisan storage:link

.PHONY: help logs helper helper-install storage rights
help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
