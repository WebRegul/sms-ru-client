<?php

declare(strict_types=1);

namespace Kafkiansky\SmsRu;

final class SmsRuConfig
{
    use Parameterizable;

    /**
     * @var string|null
     */
    private $apiId;

    /**
     * @var int|null
     */
    private $json;

    /**
     * @var string|null
     */
    private $login;

    /**
     * @var string|null
     */
    private $password;

    /**
     * @var int|null
     */
    private $partnerId;

    /**
     * @var int|null
     */
    private $test;

    /**
     * @var string|null
     */
    private $from;

    public function __construct(array $config)
    {
        $this->fillFromParameters($config);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return \array_filter([
            'api_id'     => $this->apiId,
            'login'      => $this->login,
            'password'   => $this->password,
            'json'       => $this->json,
            'partner_id' => $this->partnerId,
            'test'       => $this->test,
            'from'       => $this->from,
        ]);
    }
}
