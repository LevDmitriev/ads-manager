# Менеджер обновления объявлений на разных сайтах
## Установка
1. Выкачайте репозиторий
2. Установите [symfony](https://symfony.com/download)
3. Установите зависимости командой  
    ```bash
    symfony composer install
    ```
4. Установите базу данных следующей командой  
    ```bash
    symfony console doctrine:database:create
    ```
5. Накатите миграции  
    ```bash
    symfony console doctrine:migrations:migrate
    ```
6. Запустите сайт командой  
    ```bash
    symfony server:start
    ```
    У вас должен будет появиться URL сайта.

## Консольные команды
### yourenta:update:ads
Опции:
- period - Период обновления в секундах

## Решение различных проблем
### Ошибка "ChromeDriver only supports version ..."
Ошибка возникает, когда версия браузера слишком новая 
и драйвер её не поддерживает. Решение следующее:
1. Узнать версию браузера Google chrome на компьютере
2. Перейти на [страницу](https://chromedriver.chromium.org/downloads)
и скачать драйвер для этой версии
3. В папку vendor/symfony/panther/chromedriver-bin скопировать новый исполнительный файл драйвера.
Прошлый файл предварительно сохраните.