<?php

declare(strict_types=1);

namespace Kafkiansky\SmsRu\Tests;

use Kafkiansky\SmsRu\Message\Multi;
use Kafkiansky\SmsRu\Message\Recipient;
use Kafkiansky\SmsRu\Message\SmsRuMessage;
use Kafkiansky\SmsRu\Message\To;
use PHPUnit\Framework\TestCase;

final class SmsRuMessageTest extends TestCase
{
    public function testThatMessageInMultiModeConstructCorrect()
    {
        $multiMessage = new SmsRuMessage(
            new Multi([
                new To('111111111', 'Test'),
                new To('222222222', 'Test'),
            ])
        );

        $this->assertArrayHasKey('multi', $multiMessage->toArray());
        $this->assertArrayNotHasKey('ttl', $multiMessage->toArray());
        $this->assertArrayNotHasKey('time', $multiMessage->toArray());
        $this->assertArrayNotHasKey('daytime', $multiMessage->toArray());
        $this->assertArrayNotHasKey('translit', $multiMessage->toArray());
        $this->assertArrayNotHasKey('ip', $multiMessage->toArray());
        $this->assertCount(2, $multiMessage->toArray()['multi']);
    }

    public function testThatMessageInSingleModeConstructCorrect()
    {
        $singleMessage = new SmsRuMessage(new To('111111111', 'Test'));

        $this->assertArrayHasKey('to', $singleMessage->toArray());
        $this->assertArrayHasKey('msg', $singleMessage->toArray());
        $this->assertArrayNotHasKey('multi', $singleMessage->toArray());
        $this->assertArrayNotHasKey('ttl', $singleMessage->toArray());
        $this->assertArrayNotHasKey('time', $singleMessage->toArray());
        $this->assertArrayNotHasKey('daytime', $singleMessage->toArray());
        $this->assertArrayNotHasKey('translit', $singleMessage->toArray());
        $this->assertArrayNotHasKey('ip', $singleMessage->toArray());
    }

    public function testThatOtherMessagePropertiesExistsWhenEnabled()
    {
        $message = new SmsRuMessage(new To('', ''));

        $message
            ->enableDaytime()
            ->enableTranslit()
            ->withTtl(20)
            ->withTime(10)
            ->withIp('127.0.0.1');

        $this->assertArrayHasKey('ttl', $message->toArray());
        $this->assertArrayHasKey('time', $message->toArray());
        $this->assertArrayHasKey('daytime', $message->toArray());
        $this->assertArrayHasKey('translit', $message->toArray());
        $this->assertArrayHasKey('ip', $message->toArray());
        $this->assertInstanceOf(Recipient::class, $message->getRecipient());
    }
}
