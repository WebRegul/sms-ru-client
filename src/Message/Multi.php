<?php

declare(strict_types=1);

namespace WebRegul\SmsRu\Message;

final class Multi extends Recipient
{
    /**
     * @var array
     */
    private $tos;

    /**
     * @var bool
     */
    private $useIconv;

    /**
     * @var string
     */
    private $message;

    /**
     * @param array<To> $tos
     * @param bool      $useIconv
     * @param string    $message
     */
    public function __construct(array $tos, bool $useIconv = false, string $message = '')
    {
        $this->tos = $tos;
        $this->useIconv = $useIconv;
        $this->message = $message;
    }

    /**
     * @return array
     */
    public function getTo(): array
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
     * {@inheritdoc}
     */
    public function asMulti(): bool
    {
        return true;
    }
}
