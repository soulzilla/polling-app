# Запуск приложения

Клонировать репозиторий, далее пошагово запустить данные команды.

>docker-compose build

>docker-compose up -d

>cd testapp

>php artisan migrate

>php artisan passport:install

>php artisan db:seed

Если не запускаются команды

>docker exec -it polling-app-fpm /bin/bash

>php artisan migrate

>php artisan passport:install
 
>php artisan db:seed

В директории postman есть сохраненная коллекция запросов.
