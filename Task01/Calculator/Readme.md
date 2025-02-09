# CALC Game
**CALC Game** — это консольная игра, которая показывается случайное арифметическое выражение с операциями +, -, *, содержащее четыре операнда (например 35+16*2-4), которое нужно вычислить и записать ответ. После этого программа должна вывести соответствующее сообщение и правильный ответ.
## Установка
### Локальная установка
1. Клонируйте репозиторий:
   ```bash
   git clone https://github.com/FunSkrip/Calculator_Game.git
   cd Calculator
2. Установите зависимости через Composer:
    ```bash
    composer install
- Запустите игру:
    ```bash
    php bin/calculator
### Установка через Packagist
1. Убедитесь, что Composer установлен глобально.
2. Установите игру:
    ```bash
    composer global require funskrip/calculator
3. Запустите игру из командной строки:
    ```bash
    calculator
## Используемые технологии
- PHP — основной язык разработки.
- Composer — для управления зависимостями и автозагрузки.
- wp-cli/php-cli-tools — библиотека для удобного ввода/вывода в консоли.
## Структура проекта
Task01/CALC \
├── bin/ \
│   └── calculator       # Запускной файл игры \
├── src/ \
│   ├── Controller.php        # Логика управления игрой \
│   └── View.php              # Функции отображения \
├── composer.json             # Файл конфигурации Composer \
└── README.md                 # Описание проекта 
## Ссылки
- Packagist: [Calculator Game](https://packagist.org/packages/funskrip/calculator)
- [Репозиторий на GitHub](https://github.com/FunSkrip/Calculator_Game)
- Автор: funskrip
- Лицензия: MIT