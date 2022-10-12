# Radar – отслеживает изменения на страницах
Radar поможет автоматизировать нахождение актуальной информации и следить за страницами конкурентов.

![Скриншот функционала](screen.png)

## Возможности
- Регистрация, авторизация
- Добавление страниц для парсинга
- Фильтр контента по css селектору
- Создание проектов для группировки разных типов отслеживаемых страниц
- Парсинг страниц по расписанию или в ручном режиме. Парсер работает в фоне, через очереди
- Уведомления в телеграм

## Установка
```
composer create-project yourkey/radar
```
Установить зависимости
```
composer update
```

Переименуйте .env.example в .env и укажите настройки для соединения с базой данных а также APP_URL (host:port)

Запустить миграции
```
php artisan migrate
```
Для заполнения тестовыми данными:
```
php artisan migrate --seed
```
demo user
```email: demo@demo.com, password: password```

Запустить локальный сервер:
```
php artisan serve
```
Запустить слушатель очередей:
```
php artisan queue:listen
```

Чтобы работали уведомления в телеграм, нужно создать собственного бота и указать в .env файле bot token и chat id:
```
TELEGRAM_TOKEN=
TELEGRAM_CHAT_ID=
```

Чтобы парсинг работал по расписанию, нужно настроить cron на запуск schedule:
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### Roadmap
- Подключение альтернативного парсера (Selenium)

## Uses
- Laravel 8
- Auth: Laravel Fortify, Laravel Sanctum
- Frontend: Tailwind, DaisyUI, VueJS 3

## Tests
Перед запуском тестов укажите данные для тестовой базы данных в файле .env или phpunit.xml.
```
php artisan test
```
