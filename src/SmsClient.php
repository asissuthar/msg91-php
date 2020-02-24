<?php

namespace Msg91;

use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;

final class SmsClient
{
    private const BASE_API  = 'https://api.msg91.com/api/v2/';

    private $httpClient;

    private $authKey;

    private $sender;
    private $route;
    private $country;

    private $sms;

    private $message;
    private $to;

    public function __construct(string $authKey, string $sender)
    {
        $this->httpClient = new HttpClient([
            'base_uri' => self::BASE_API
        ]);
    }

    public function send(): ResponseInterface
    {
        return $this->httpClient->post('sendsms', [
            'json' => $this->toSendParams(),
            'headers' => [
                'authkey' => $this->authKey
            ]
        ]);
    }

    public function setAuthKey(string $authKey): SmsClient
    {
        $this->authKey = $authKey;
        return $this;
    }

    public function setSender(string $sender): SmsClient
    {
        $this->sender = $sender;
        return $this;
    }

    public function setRoute(string $route): SmsClient
    {
        $this->route = $route;
        return $this;
    }

    public function setCountry(string $country): SmsClient
    {
        $this->country = $country;
        return $this;
    }

    public function setSms($sms): SmsClient
    {
        $this->sms = $sms;
        return $this;
    }

    public function setMessage($message): SmsClient
    {
        $this->message = $message;
        return $this;
    }

    public function setTo($to): SmsClient
    {
        $this->to = $to;
        return $this;
    }

    private function toSendParams(): array
    {
        $data = [];

        $data['sender'] = $this->sender;

        if (isset($this->route)) {
            $data['route'] = $this->route;
        }

        if (isset($this->country)) {
            $data['country'] = $this->country;
        } else {
            $data['country'] = '91';
        }

        if (isset($this->sms)) {
            $data['sms'] = $this->sms;
        } else {
            if (isset($this->message) && isset($this->to)) {
                $data['sms'] = [
                    [
                        'message' => $this->message,
                        'to' => is_array($this->to) ? $this->to : [$this->to]
                    ]
                ];
            }
        }

        return $data;
    }
}
