<?php

declare(strict_types=1);

namespace Kafkiansky\SmsRu\Message;

final class SmsRuMessage
{
    /**
     * @var Recipient
     */
    private $recipient;

    /**
     * @var string|null
     */
    private $ip;

    /**
     * @var int|null
     */
    private $time;

    /**
     * @var int|null
     */
    private $ttl;

    /**
     * @var int|null
     */
    private $dayTime;

    /**
     * @var int|null
     */
    private $translit;

    public function __construct(Recipient $recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * @return Recipient
     */
    public function getRecipient(): Recipient
    {
        return $this->recipient;
    }

    /**
     * @param string $ip
     *
     * @return $this
     */
    public function withIp(string $ip): self
    {
        if (\filter_var($ip, \FILTER_VALIDATE_IP)) {
            $this->ip = $ip;
        }

        return $this;
    }

    /**
     * @param int $time
     *
     * @return $this
     */
    public function withTime(int $time): self
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @param int $ttl
     *
     * @return $this
     */
    public function withTtl(int $ttl): self
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * @return $this
     */
    public function enableDaytime(): self
    {
        $this->dayTime = 1;

        return $this;
    }

    /**
     * @return $this
     */
    public function enableTranslit(): self
    {
        $this->translit = 1;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $payload = [
            'ip'       => $this->ip,
            'time'     => $this->time,
            'ttl'      => $this->ttl,
            'daytime'  => $this->dayTime,
            'translit' => $this->translit,
        ];

        return \array_filter(
            \array_merge($payload, $this->recipient->buildMessage())
        );
    }
}
