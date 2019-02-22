# Yii2 RESTfull Notes #

Чтобы развернуть проект нужно выполнить команды

* `docker-compose up -d --build`
* `docker-compose exec api make init`

При этом произойдет следующее

* В докере запустится веб окружение
* Выставятся нужные права на дирекории
* Подтянутся все зависимости из композера
* Применятся миграции
* Запустятся тесты для API

Веб сервер будет доступен по адресу http://localhost:22080

Доступные узлы

```php
'rules' => [
    '/' => 'site/index',
    'site/login' => 'site/login',
    'GET notes' => 'note/index',
    'GET notes/<id:\d+>' => 'note/show',
    'POST notes' => 'note/create',
    'PUT,PATCH notes/<id:\d+>' => 'note/update',
    'DELETE notes/<id:\d+>' => 'note/delete',
],
```
