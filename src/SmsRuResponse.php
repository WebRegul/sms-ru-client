<?php

declare(strict_types=1);

namespace Kafkiansky\SmsRu;

final class SmsRuResponse
{
    use Parameterizable;

    /**
     * @var string
     */
    private $status;

    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var array|null
     */
    private $sms;

    /**
     * @var int|null
     */
    private $balance;

    /**
     * @var int|null
     */
    private $totalCost;

    /**
     * @var int|null
     */
    private $totalSms;

    /**
     * @var int|null
     */
    private $totalLimit;

    /**
     * @var int|null
     */
    private $usedToday;

    /**
     * @var array|null
     */
    private $senders;

    public function __construct(array $payload)
    {
        $this->fillFromParameters($payload);
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array|null
     */
    public function getSms(): ?array
    {
        return $this->sms;
    }

    /**
     * @return int|null
     */
    public function getBalance(): ?int
    {
        return $this->balance;
    }

    /**
     * @return int|null
     */
    public function getTotalCost(): ?int
    {
        return $this->totalCost;
    }

    /**
     * @return int|null
     */
    public function getTotalSms(): ?int
    {
        return $this->totalSms;
    }

    /**
     * @return int|null
     */
    public function getTotalLimit(): ?int
    {
        return (int) $this->totalLimit;
    }

    /**
     * @return int|null
     */
    public function getUsedToday(): ?int
    {
        return $this->usedToday;
    }

    /**
     * @return array|null
     */
    public function getSenders(): ?array
    {
        return $this->senders;
    }

    /**
     * @return bool
     */
    public function isNonZeroBalance(): bool
    {
        return 0 < $this->balance;
    }

    public function isOk()
    {
        return 'OK' === $this->status;
    }
}
