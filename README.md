### Attention:
Work in progress

### Usage

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
