<?php

declare(strict_types=1);

namespace Kafkiansky\SmsRu\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Kafkiansky\SmsRu\Message\SmsRuMessage;
use Kafkiansky\SmsRu\Message\To;
use Kafkiansky\SmsRu\SmsRuApi;
use Kafkiansky\SmsRu\SmsRuConfig;
use PHPUnit\Framework\TestCase;

final class SmsRuApiTest extends TestCase
{
    /**
     * @var MockHandler
     */
    private $mockHandler;

    /**
     * @var SmsRuApi
     */
    private $smsRuApi;

    protected function setUp(): void
    {
        $this->mockHandler = new MockHandler();

        $httpClient = new Client([
            'handler' => $this->mockHandler,
        ]);

        $this->smsRuApi = new SmsRuApi(
            new SmsRuConfig([
                'api_id' => 'XXXX-XXXX-XXXX',
                'test'   => 1,
                'json'   => 1,
            ]),
            $httpClient
        );
    }

    public function testSendMessageSuccess()
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__.'/fixtures/send_message.json')));

        $response = $this->smsRuApi->send(
            new SmsRuMessage(
                new To('79991111111', 'Test')
            )
        );

        $this->assertEquals('OK', $response->getStatus());
        $this->assertEquals(100, $response->getStatusCode());
        $this->assertIsArray($response->getSms());
        $this->assertEquals(10, $response->getBalance());
    }

    public function testCostSuccess()
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__.'/fixtures/cost.json')));

        $response = $this->smsRuApi->cost(
            new SmsRuMessage(
                new To('79991111111', 'Test')
            )
        );

        $this->assertEquals('OK', $response->getStatus());
        $this->assertEquals(100, $response->getStatusCode());
        $this->assertIsArray($response->getSms());
        $this->assertEquals(10, $response->getTotalCost());
        $this->assertEquals(1, $response->getTotalSms());
    }

    public function testBalanceSuccess()
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__.'/fixtures/balance.json')));

        $response = $this->smsRuApi->balance();

        $this->assertEquals('OK', $response->getStatus());
        $this->assertEquals(100, $response->getStatusCode());
        $this->assertEquals(10, $response->getBalance());
    }

    public function testLimitSuccess()
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__.'/fixtures/limit.json')));

        $response = $this->smsRuApi->limit();

        $this->assertEquals('OK', $response->getStatus());
        $this->assertEquals(100, $response->getStatusCode());
        $this->assertEquals(10, $response->getTotalLimit());
        $this->assertEquals(0, $response->getUsedToday());
    }

    public function testSendersSuccess()
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__.'/fixtures/senders.json')));

        $response = $this->smsRuApi->senders();

        $this->assertEquals('OK', $response->getStatus());
        $this->assertEquals(100, $response->getStatusCode());
        $this->assertIsArray($response->getSenders());
        $this->assertCount(1, $response->getSenders());
    }
}
