perm:
	mkdir -p api/runtime/cache
	chmod 777 api/runtime/cache
	mkdir -p common/rbac/items
	chmod 777 api/runtime/cache
init: perm
	php init
	composer install
	php yii migrate/up --interactive 0
	php yii_test migrate/up --interactive 0
	vendor/bin/codecept run -- -c api