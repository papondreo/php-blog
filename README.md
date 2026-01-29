# PHP Blog

Простой блог на чистом PHP с MySQL и Smarty.

## Требования

**Для Docker:**
- Docker и Docker Compose

**Для локальной разработки:**
- PHP 8.1+
- MySQL 8.0+
- Composer
- Расширение php-mysql

## Установка и запуск

### С Docker

```bash
docker compose up -d --build && sleep 10 && docker compose exec php composer install --no-interaction && docker compose exec php chmod -R 777 templates_c cache && docker compose exec php php database/seeder.php
```

Сайт доступен: **http://localhost:8080**

#### Полезные команды Docker

```bash
# Остановить контейнеры
docker compose down

# Посмотреть логи
docker compose logs -f

# Перезапустить
docker compose restart

# Полностью удалить и пересобрать (с очисткой БД)
docker compose down -v --rmi all
docker compose up -d --build
```

---

### Без Docker (локально)

#### 1. Установка зависимостей системы

```bash
# Ubuntu/Debian
sudo apt-get install -y php-mysql
```

#### 2. Установка PHP зависимостей

```bash
composer install
```

#### 3. Настройка базы данных

```bash
# Создать базу данных
sudo mysql -e "CREATE DATABASE IF NOT EXISTS blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Создать пользователя
sudo mysql -e "CREATE USER IF NOT EXISTS 'blog_user'@'localhost' IDENTIFIED BY 'blog_password'; GRANT ALL PRIVILEGES ON blog.* TO 'blog_user'@'localhost'; FLUSH PRIVILEGES;"

# Импортировать схему
sudo mysql blog < database/schema.sql
```

#### 4. Настройка конфигурации

Отредактируйте `src/Config/config.php`:

```php
'db' => [
    'host' => 'localhost',
    'database' => 'blog',
    'username' => 'blog_user',
    'password' => 'blog_password',
    'charset' => 'utf8mb4',
],
```

#### 5. Заполнение тестовыми данными

```bash
php database/seeder.php
```

#### 6. Запуск сервера

```bash
php -S localhost:8080 -t public
```

Сайт доступен: **http://localhost:8080**

---

## Структура проекта

```
├── database/           # SQL схема и сидер
│   ├── schema.sql      # Структура БД
│   └── seeder.php      # Тестовые данные
├── docker/             # Docker конфигурация
│   ├── nginx/          # Конфиг Nginx
│   └── php/            # Dockerfile PHP
├── public/             # Публичная директория
│   ├── css/            # Стили
│   ├── uploads/        # Загруженные изображения
│   └── index.php       # Точка входа
├── scss/               # SCSS исходники
├── src/                # PHP код приложения
│   ├── Config/         # Конфигурация
│   ├── Controllers/    # Контроллеры
│   ├── Core/           # Database, Router, View
│   └── Models/         # Category, Article
├── templates/          # Smarty шаблоны
│   ├── layouts/        # Базовый layout
│   └── pages/          # Страницы
├── templates_c/        # Скомпилированные шаблоны (автогенерация)
├── cache/              # Кэш Smarty
├── docker-compose.yml
└── composer.json
```

## Функционал

- **Главная страница** — категории с 3 последними статьями, кнопка "Все статьи"
- **Страница категории** — список статей, сортировка (по дате / по просмотрам), пагинация
- **Страница статьи** — полный контент, категории, блок похожих статей
- **Счётчик просмотров** — автоматически увеличивается при открытии статьи

## Компиляция SCSS (опционально)

CSS уже скомпилирован в `public/css/style.css`. Для изменения стилей:

```bash
# Установить sass
npm install -g sass

# Скомпилировать
sass scss/style.scss public/css/style.css

# Или в watch режиме
sass --watch scss/style.scss:public/css/style.css
```
