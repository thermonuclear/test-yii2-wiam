В папке, где развертываем проект создаем папку app и папку, куда клонируем репозиторий с конфигом докера docker_wiam

Т.е. структура будет выглядеть к примеру так:

	папка test-smilik-wiam:
		папка app
		папка docker_wiam

в файле hosts (для win10 c:\Windows\System32\drivers\etc\hosts) прописываем:
    127.0.0.1 test-yii2-wiam

клонируем в папку app/test-yii2-wiam проект:
    git clone https://github.com/test-yii2-wiam

В папке docker_wiam выполняем команду создания тома для работы postgresql
    docker volume create —-name pgdata1

клонируем в папку docker_wiam конфиг докера:
    git clone https://github.com/docker_wiam
в папке docker_wiam в консоли выполняем:
	docker-compose up -d

заходим в папку app и клонируем репозиторий проекта test-yii2-wiam:

заходим в контейнер php-fpm83 в папку с проектом /var/www/app/test-yii2-wiam
устанавливаем пакеты через 
    composer install
прогоняем миграции 
    php yii migrate

В браузере сайт будет доступен по https://test-yii2-wiam
