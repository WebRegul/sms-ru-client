<?php

declare(strict_types=1);

namespace Kafkiansky\SmsRu\Exceptions;

use Throwable;

final class SmsSendingFailedException extends \Exception
{
    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var string
     */
    private $statusText;

    public function __construct(int $statusCode, string $statusText, $code = 0, Throwable $previous = null)
    {
        $message = \sprintf('sms.ru responded with an error, status text: %s', $statusText);
        $this->statusCode = $statusCode;
        $this->statusText = $statusText;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getStatusText(): string
    {
        return $this->statusText;
    }
}
