# Laravel Каталог Интернет-магазина

## 📦 Описание

Проект представляет собой реализацию каталога интернет-магазина на Laravel с поддержкой:

- Вывода групп и подгрупп товаров
- Сортировки по цене и названию (вверх/вниз)
- Фильтрации по категориям с учетом вложенности
- Пагинации (AJAX)
- Изменения количества товаров на странице
- Карточки товара с хлебными крошками
- Генерации данных с помощью сидеров
- Использования Bootstrap для адаптивного дизайна

## 🚀 Быстрый старт

```bash
git clone https://github.com/your-username/laravel-catalog.git
cd laravel-catalog
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

## 🐳 Docker (если используется)

```bash
docker compose up -d --build
```

## 📁 Структура

- `routes/web.php` — маршруты
- `app/Http/Controllers/CatalogController.php` — логика отображения каталога
- `resources/views/catalog/*.blade.php` — представления
- `database/seeders/` — сидеры для генерации данных
- `app/Models/` — модели Product, Group, Price

## 📌 Принятые решения

- Хлебные крошки реализованы через рекурсивный метод `breadcrumbs()` в модели `Group`
- Используется AJAX для улучшения UX без перезагрузки страницы
- Все товары отображаются в сетке (по 3 в ряд)
- Применена сортировка и пагинация через query-параметры и JavaScript (fetch)
- Faker локализован под `ru_RU`

## ✅ Выполненные пункты

- [x] Вывод групп 1 уровня с количеством товаров (включая подгруппы)
- [x] Фильтрация товаров по категории и подкатегориям
- [x] AJAX-сортировка и пагинация
- [x] Хлебные крошки
- [x] Карточка товара
- [x] Faker и сиды
- [x] Изменение количества товаров на странице
- [x] Bootstrap-дизайн
- [ ] Docker (по желанию)
- [ ] Тесты (не реализованы)

## 📎 Контакты

> Автор: Дмитрий  
> Email: your.email@example.com  
> Telegram: @yourhandle

---

© 2025 Laravel Catalog Project