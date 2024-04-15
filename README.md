## Установка

Скопировать .env и подключить бд
```bash
php -r "file_exists('.env') || copy('.env.example', '.env');"
```
Выполнить команды

```bash
composer install;php artisan migrate --seed;php artisan key:generate;npm i;npm run build;
```
Данные тестового пользователя
```
login: admin
password: password
```
