# External Urls

Библиотека для получения всех внешних ссылок с определенной страницы сайта

## Установка

`composer require vanchelo/external-urls`

## Использование

```php
<?php
// composer autoloader
require_once 'vendor/autoload.php';

use Vanchelo\ExternalLinks\ExternalUrls;
//use Vanchelo\ExternalUrls\Transport\PhpTransport;
//use Vanchelo\ExternalUrls\Transport\CurlTransport;
//use Vanchelo\ExternalUrls\Transport\GoutteTransport;
//use Vanchelo\ExternalUrls\Transport\GuzzleTransport;

$externalLinks = new ExternalUrls();
$links = $externalLinks->go('http://www.example.com');

print_r($links->all());
```

На выходе получаем коллецию внешних ссылок с указанной страницы сайта.
```
Array
(
    [0] => http://www.iana.org/domains/example
)
```

Так же можно получить ссылки в формате JSON:
```
$links->toJson();
```

Из коллекции ссылок оставить уникальные (без дублей):
```
print_r($links->unique()->toArray());
```

Библиотека очень проста в использовании даже для не подготовленного PHP разработчика.

Доступны четыре реализации транспорта для получение содержимого страниц сайта:

1. PhpTransport
2. CurlTransport - используется по умолчанию
3. GouteeTransport
4. GuzzleTransport

Для последних двух необходимо добавить соотв. зависимости в `composer.json` или ничего не добавлять, если пакет уже установлен.
