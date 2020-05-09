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