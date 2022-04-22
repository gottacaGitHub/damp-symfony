# damp-symfony

Клонируем репозиторий
git clone https://github.com/gottacaGitHub/damp-symfony.git

Переходим в папку проекта

Выполняем 
docker-compose build

docker-compose up -d 

cd .App

composer install

Скачиваем с https://symfony.com/download версию symfony-cli под свою систему 

Загружаем в папку .App

.\symfony server:start -d 

php bin/console doctrine:schema:update --force     

php bin/console doctrine:fixtures:load

Переходим на 127.0.0.1:8000/admin/login


Логин и пароль:
manager@manager.ru 
manager

admin@admin.ru
admin1
