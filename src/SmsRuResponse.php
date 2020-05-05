<?php

declare(strict_types=1);

namespace Kafkiansky\SmsRu;

final class SmsRuResponse
{
    use Parameterizable;

    /**
     * Arrays of existing errors code and messages.
     */
    private const ERRORS = [
        104 => 'Сообщение не может быть доставлено: время жизни истекло',
        105 => 'Сообщение не может быть доставлено: удалено оператором',
        106 => 'Сообщение не может быть доставлено: сбой в телефоне',
        107 => 'Сообщение не может быть доставлено: неизвестная причина',
        108 => 'Сообщение не может быть доставлено: отклонено',
        130 => 'Сообщение не может быть доставлено: превышено количество сообщений на этот номер в день',
        131 => 'Сообщение не может быть доставлено: превышено количество одинаковых сообщений на этот номер в минуту',
        132 => 'Сообщение не может быть доставлено: превышено количество одинаковых сообщений на этот номер в день',
        200 => 'Неправильный api_id',
        201 => 'Не хватает средств на лицевом счету',
        202 => 'Неправильно указан получатель',
        203 => 'Нет текста сообщения',
        204 => 'Имя отправителя не согласовано с администрацией',
        205 => 'Сообщение слишком длинное (превышает 8 СМС)',
        206 => 'Будет превышен или уже превышен дневной лимит на отправку сообщений',
        207 => 'На этот номер (или один из номеров) нельзя отправлять сообщения, либо указано более 100 номеров в списке получателей',
        208 => 'Параметр time указан неправильно',
        209 => 'Вы добавили этот номер (или один из номеров) в стоп-лист',
        210 => 'Используется GET, где необходимо использовать POST',
        211 => 'Метод не найден',
        212 => 'Текст сообщения необходимо передать в кодировке UTF-8 (вы передали в другой кодировке)',
        220 => 'Сервис временно недоступен, попробуйте чуть позже',
        230 => 'Превышен общий лимит количества сообщений на этот номер в день',
        231 => 'Превышен лимит одинаковых сообщений на этот номер в минуту',
        232 => 'Превышен лимит одинаковых сообщений на этот номер в день',
        300 => 'Неправильный token (возможно истек срок действия, либо ваш IP изменился)',
        301 => 'Неправильный пароль, либо пользователь не найден',
        302 => 'Пользователь авторизован, но аккаунт не подтвержден (пользователь не ввел код, присланный в регистрационной смс)',
    ];

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

    /**
     * @param int $statusCode
     *
     * @return string|null
     */
    public static function errorTextFromCode(int $statusCode): ?string
    {
        return self::ERRORS[$statusCode] ?? null;
    }
}
