<?php

declare(strict_types=1);

namespace Kafkiansky\SmsRu\Tests;

use Kafkiansky\SmsRu\SmsRuConfig;
use PHPUnit\Framework\TestCase;

final class SmsRuConfigTest extends TestCase
{
    public function testThatConfigFillCorrect()
    {
        $config = new SmsRuConfig([
            'api_id'     => 'XXXX-XXXX-XXXX',
            'json'       => 1,
            'test'       => 1,
            'partner_id' => 1111,
        ]);

        $this->assertArrayHasKey('api_id', $config->toArray());
        $this->assertArrayHasKey('json', $config->toArray());
        $this->assertArrayHasKey('test', $config->toArray());
        $this->assertArrayHasKey('partner_id', $config->toArray());
        $this->assertArrayNotHasKey('from', $config->toArray());
        $this->assertArrayNotHasKey('login', $config->toArray());
        $this->assertArrayNotHasKey('password', $config->toArray());
    }

    public function testThatConfigCannotFillWithUnknownParameters()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(\sprintf('Property %s for class %s doesn\'t exists', 'unknown', SmsRuConfig::class));
        new SmsRuConfig([
            'unknown' => 'unknown',
        ]);
    }
}
