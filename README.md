# damp-symfony

Клонируем репозиторий
git clone https://github.com/gottacaGitHub/damp-symfony.git

Переходим в папку проекта

Выполняем 
docker-compose build

docker-compose up -d 

docker exec -it app_php bash

composer install

php bin/console doctrine:schema:update --force     

php bin/console doctrine:fixtures:load

Переходим на 127.0.0.1:8001/admin/login


Логин и пароль:
manager@manager.ru 
manager

admin@admin.ru
admin1
