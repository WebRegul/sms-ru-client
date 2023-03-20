<?php

declare(strict_types=1);

namespace WebRegul\SmsRu\Message;

abstract class Recipient
{
    /**
     * @return array|string
     */
    abstract public function getTo();

    /**
     * @return string
     */
    abstract public function getMessage(): string;

    /**
     * @return bool
     */
    abstract public function useIconv(): bool;

    /**
     * @return bool
     */
    abstract public function asMulti(): bool;

    /**
     * @return array
     */
    public function buildMessage(): array
    {
        $options = [];

        if ($this->asMulti()) {
            /** @var To $to */
            foreach ($this->getTo() as $to) {
                $options['multi'][$to->getTo()] = $this->defineEncoding($to->getMessage());
            }

            return $options;
        }

        $options['to'] = $this->collapseRecipients($this->getTo());
        $options['msg'] = $this->defineEncoding($this->getMessage());

        return $options;
    }

    /**
     * @param string $message
     *
     * @return bool|false|string
     */
    private function defineEncoding(string $message)
    {
        return $this->useIconv() ? $this->toIconv($message) : $message;
    }

    /**
     * @param $tos
     *
     * @return string
     */
    private function collapseRecipients($tos): string
    {
        return \is_array($tos) ? \implode(',', $tos) : $tos;
    }

    /**
     * @param string $message
     *
     * @return bool|false|string
     */
    private function toIconv(string $message)
    {
        return \iconv('windows-1251', 'utf-8', $message);
    }
}
