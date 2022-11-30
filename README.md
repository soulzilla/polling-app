# Запуск приложения

Клонировать репозиторий, далее пошагово запустить данные команды.

>docker-compose build

>docker-compose up -d

>cd testapp

>php artisan migrate

>php artisan passport:install

>php artisan db:seed

>php artisan queue:work

Если не запускаются команды

>docker exec -it test-app-fpm /bin/bash

>php artisan migrate

>php artisan passport:install
 
>php artisan db:seed

>php artisan queue:work

В директории postman есть сохраненная коллекция запросов.

Для начисления баланса пользователю запустить команду

`php artisan balance:refill`

Указать почту и необходимую сумму в появляющихся prompt.
