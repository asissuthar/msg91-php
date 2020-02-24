<?php

namespace Msg91\Tests;

use Msg91\OtpClient;
use Msg91\SmsClient;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    private $otpClient;
    private $smsClient;

    protected function setUp(): void
    {
        $authKey = "";

        $templateId = "";
        $this->otpClient = new OtpClient($authKey, $templateId);

        $sender = "";
        $this->smsClient = new SmsClient($authKey, $sender);

    }

    public function testOtpClient(): void
    {
        $response = $this->otpClient->send();
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testSmsClient(): void
    {
        $response = $this->smsClient
            ->setCountry("")
            ->setRoute("")
            ->setTo("")
            ->setMessage("")
            ->send();
        $this->assertSame(200, $response->getStatusCode());
    }
}
?>