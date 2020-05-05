<?php

declare(strict_types=1);

namespace Kafkiansky\SmsRu\Message;

final class To extends Recipient
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $tos;

    /**
     * @var bool
     */
    private $useIconv;

    /**
     * @param string|array $tos
     * @param string       $message
     * @param bool         $useIconv
     */
    public function __construct($tos, string $message, bool $useIconv = false)
    {
        $this->message = $message;
        $this->tos = $tos;
        $this->useIconv = $useIconv;
    }

    /**
     * @return array|string
     */
    public function getTo()
    {
        return $this->tos;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * {@inheritdoc}
     */
    public function useIconv(): bool
    {
        return $this->useIconv;
    }

    /**
     * @return bool
     */
    public function asMulti(): bool
    {
        return false;
    }
}
