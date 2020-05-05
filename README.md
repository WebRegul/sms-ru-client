# API Client for sms.ru notification service

![test](https://github.com/kafkiansky/sms-ru-client/workflows/test/badge.svg?event=push)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Quality Score](https://img.shields.io/scrutinizer/g/kafkiansky/sms-ru-client.svg?style=flat-square)](https://scrutinizer-ci.com/g/kafkiansky/sms-ru-client)
[![StyleCI](https://styleci.io/repos/261290955/shield)](https://styleci.io/repos/261290955)
[![Total Downloads](https://img.shields.io/packagist/dt/kafkiansky/sms-ru-client.svg?style=flat-square)](https://packagist.org/packages/kafkiansky/sms-ru-client)

### Contents:
- [Installation](#installation)
- [Usage](#usage)
    - [Configuration](#configuration)
    - [Available methods](#available-methods)
        - [Send](#send)
        - [Cost](#cost)
        - [Balance](#balance)
        - [Limit](#limit)
        - [Senders](#senders)
- [Testing](#testing)
- [Licence](#licence)


## Installation

Install this package with Composer:

```bash
composer require kafkiansky/sms-ru-client
```

## Usage

### Configuration
Package provide simple configuration, just fill SmsRuConfig with follow configuration:
```php
require __DIR__ . '/vendor/autoload.php';

$api = new \Kafkiansky\SmsRu\SmsRuApi(
    new \Kafkiansky\SmsRu\SmsRuConfig(
        [
            'api_id' => 'XXXXX-XXXX-XXXXX',
            'test'   => 1,
            'json'   => 1,
        ]
    ),
    new \GuzzleHttp\Client()
);
```
Put `test` parameter to 1 to prevent real money spending in test environment.
You also can use your login/password to make requests, but it safe just when using https:

```php
$api = new \Kafkiansky\SmsRu\SmsRuApi(
    new \Kafkiansky\SmsRu\SmsRuConfig(
        [
            'login' => 'secret',
            'password' => 'secret',
            'test'   => 1,
            'json'   => 1,
        ]
    ),
    new \GuzzleHttp\Client()
);
``` 

### Available methods

#### Send
1. One client - one message
```php
require __DIR__ . '/vendor/autoload.php';

$api = new \Kafkiansky\SmsRu\SmsRuApi(
    new \Kafkiansky\SmsRu\SmsRuConfig(
        [
            'api_id' => 'XXXXX-XXXX-XXXXX',
            'test'   => 1,
            'json'   => 1,
        ]
    ),
    new \GuzzleHttp\Client()
);

$response = $api->send(
    new \Kafkiansky\SmsRu\Message\SmsRuMessage(
        new \Kafkiansky\SmsRu\Message\To('7909000000', 'Hello')
    )
);
```

2. Many clients - one message
```php
$response = $api->send(
    new \Kafkiansky\SmsRu\Message\SmsRuMessage(
        new \Kafkiansky\SmsRu\Message\To(['7909000000', '7909111111'], 'Hello')
    )
);
```

3. Many clients - many messages
```php
$response = $api->send(
    new \Kafkiansky\SmsRu\Message\SmsRuMessage(
        new \Kafkiansky\SmsRu\Message\Multi([
            new \Kafkiansky\SmsRu\Message\To('7909000000', 'Hello'),
            new \Kafkiansky\SmsRu\Message\To('7909111111', 'Bonjour'),
        ])
    )
);
```

The SmsRuMessage has many other parameters: you can specify user ip, ttl, time, daytime and translit.
Read [documentation](https://sms.ru/api/send) for a full explanation. Usage is simple:

```php
$response = $api->send(
    (new \Kafkiansky\SmsRu\Message\SmsRuMessage(
        new \Kafkiansky\SmsRu\Message\Multi([
            new \Kafkiansky\SmsRu\Message\To('7909000000', 'Hello'),
            new \Kafkiansky\SmsRu\Message\To('7909111111', 'Bonjour'),
        ])
    ))
      ->enableDaytime()
      ->enableTranslit()
      ->withTime(1000)
);
```

Or use static call:

```php
$response = $api->send(
    \Kafkiansky\SmsRu\Message\SmsRuMessage::fromRecipient(
        new \Kafkiansky\SmsRu\Message\Multi([
            new \Kafkiansky\SmsRu\Message\To('7909000000', 'Hello'),
            new \Kafkiansky\SmsRu\Message\To('7909111111', 'Bonjour'),
        ])
    )
      ->enableDaytime()
      ->enableTranslit()
      ->withTime(1000)
);
```

If need, you can use iconv to convert encoding, just put `true` as second argument in `Multi` type:

```php
new \Kafkiansky\SmsRu\Message\Multi([
     new \Kafkiansky\SmsRu\Message\To('7909000000', 'Hello'),
     new \Kafkiansky\SmsRu\Message\To('7909111111', 'Bonjour'),
], true);
```

And as third argument in `To`:

```php
new \Kafkiansky\SmsRu\Message\To('7909000000', 'Hello', true);
```

#### Cost

You can get cost for batch of messages:

```php
$response = $api->cost(
    new \Kafkiansky\SmsRu\Message\SmsRuMessage(
        new \Kafkiansky\SmsRu\Message\Multi([
            new \Kafkiansky\SmsRu\Message\To('7909000000', 'Hello'),
            new \Kafkiansky\SmsRu\Message\To('7909111111', 'Bonjour'),
        ])
    )
);

echo $response->getTotalCost();
```

#### Balance

```php
$response = $api->balance();

echo $response->getBalance();
```

#### Limit
```php
$response = $api->limit();

echo $response->getTotalLimit();
echo $response->getUsedToday();
```

#### Senders
```php
$response = $api->senders();

echo $response->getSenders();
```

## Testing

``` bash
$ composer test
```

## License

The MIT License (MIT). See [License File](LICENSE.md) for more information.