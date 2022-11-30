# Авторизация

Для авторизации используется паке `laravel/passport`

# Модели

`User` - пользователи

`Balance` - баланс пользователя

`Product` - продукты

`Operation` - операции пользователя с продуктами

# Пошаговая инструкция

Импортировать коллекцию запросов из папки `postman`.
Если не получается, зарегистрировать пользователя:
>POST http://localhost:8080/api/v1/register

Полученный токен вставить в Headers
`Authorization`: `Bearer $token`

Можно так же через консольную команду
>php artisan register:user

Если не записались продукты, 
>php artisan db:seed

По endpoint-у `http://localhost:8080/api/v1/products` доступны CRUD операции для авторизованного пользователя.

>POST http://localhost:8080/api/v1/products/{id}/buy

Валидирует баланс пользователя и создает операцию, добавляет её в очередь. 
Далее срабатывает job, списываются деньги с баланса.
Если не обрабатываются покупки:

>php artisan queue:work redis
