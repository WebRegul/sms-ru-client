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
    private const HOST = 'https://sms.ru';

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
     * @return SmsRuResponse
     *
     * @throws HttpClientErrorException
     * @throws SmsSendingFailedException
     */
    public function send(SmsRuMessage $message): SmsRuResponse
    {
        return $this->requestWithMessage($message, 'sms/send');
    }

    /**
     * @param SmsRuMessage $message
     *
     * @return SmsRuResponse
     *
     * @throws HttpClientErrorException
     * @throws SmsSendingFailedException
     */
    public function cost(SmsRuMessage $message): SmsRuResponse
    {
        return $this->requestWithMessage($message, 'sms/cost');
    }

    /**
     * @return SmsRuResponse
     *
     * @throws HttpClientErrorException
     * @throws SmsSendingFailedException
     */
    public function balance(): SmsRuResponse
    {
        return $this->emptyRequest('my/balance');
    }

    /**
     * @return SmsRuResponse
     *
     * @throws HttpClientErrorException
     * @throws SmsSendingFailedException
     */
    public function limit(): SmsRuResponse
    {
        return $this->emptyRequest('my/limit');
    }

    /**
     * @return SmsRuResponse
     *
     * @throws HttpClientErrorException
     * @throws SmsSendingFailedException
     */
    public function senders(): SmsRuResponse
    {
        return $this->emptyRequest('my/senders');
    }

    /**
     * @param SmsRuMessage $message
     * @param string $url
     *
     * @return SmsRuResponse
     *
     * @throws HttpClientErrorException
     * @throws SmsSendingFailedException
     */
    private function requestWithMessage(SmsRuMessage $message, string $url): SmsRuResponse
    {
        $payload = \array_merge($this->config->toArray(), $message->toArray());

        return $this->request($payload, $url);
    }

    /**
     * @param string $url
     *
     * @return SmsRuResponse
     *
     * @throws HttpClientErrorException
     * @throws SmsSendingFailedException
     */
    private function emptyRequest(string $url): SmsRuResponse
    {
        return $this->request($this->config->toArray(), $url);
    }

    /**
     * @param array $payload
     * @param string $endpoint
     *
     * @return SmsRuResponse
     *
     * @throws HttpClientErrorException
     * @throws SmsSendingFailedException
     */
    private function request(array $payload, string $endpoint): SmsRuResponse
    {
        try {
            $response = $this->client->request('POST', $this->endpoint($endpoint), [
                'form_params' => $payload,
            ]);

            $response = \json_decode((string) $response->getBody(), true);

            if ('ERROR' === $response['status']) {
                throw new SmsSendingFailedException($response['status_code'], $response['status_text']);
            }

            return new SmsRuResponse($response);
        } catch (GuzzleException $e) {
            throw new HttpClientErrorException($e->getMessage());
        }
    }

    /**
     * @param string $path
     *
     * @return string
     */
    private function endpoint(string $path): string
    {
        return \sprintf('%s/%s', self::HOST, $path);
    }
}
