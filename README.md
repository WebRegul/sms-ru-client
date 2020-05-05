![test](https://github.com/kafkiansky/sms-ru-client/workflows/test/badge.svg?event=push)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Quality Score](https://img.shields.io/scrutinizer/g/kafkiansky/sms-ru-client.svg?style=flat-square)](https://scrutinizer-ci.com/g/kafkiansky/sms-ru-client)
[![StyleCI](https://styleci.io/repos/261290955/shield)](https://styleci.io/repos/261290955)

### Attention:
Work in progress

### Usage

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

print_r($response);
```

2. Many clients - one message
```php
$response = $api->send(
    new \Kafkiansky\SmsRu\Message\SmsRuMessage(
        new \Kafkiansky\SmsRu\Message\To(['7909000000', '7909111111'], 'Hello')
    )
);

print_r($response);
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

print_r($response);
```