<?php

declare(strict_types=1);

namespace Kafkiansky\SmsRu;

use GuzzleHttp\Client as HttpClient;
use Kafkiansky\SmsRu\Message\SmsRuMessage;
use Kafkiansky\SmsRu\Exceptions\HttpClientErrorException;
use Kafkiansky\SmsRu\Exceptions\SmsSendingFailedException;
use GuzzleHttp\Exception\GuzzleException;

final class SmsRuApi
{
    private const HOST = 'https://sms.ru/sms/send';

    /**
     * @var SmsRuConfig
     */
    private $config;

    /**
     * @var HttpClient
     */
    private $client;

    public function __construct(SmsRuConfig $config, HttpClient $client)
    {
        $this->config = $config;
        $this->client = $client;
    }

    /**
     * @param SmsRuMessage $message
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     *
     * @throws HttpClientErrorException
     * @throws SmsSendingFailedException
     */
    public function send(SmsRuMessage $message)
    {
        $payload = \array_merge($this->config->toArray(), $message->toArray());

        try {
            $response = $this->client->request('POST', self::HOST, [
                'form_params' => $payload,
            ]);

            $response = \json_decode((string) $response->getBody(), true);

            if ('ERROR' === $response['status']) {
                throw new SmsSendingFailedException($response['status_code'], $response['status_text']);
            }

            return $response;
        } catch (GuzzleException $e) {
            throw new HttpClientErrorException($e->getMessage());
        }
    }
}
