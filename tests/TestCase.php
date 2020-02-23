<?php

namespace Msg91\Tests;

use Msg91\OTPClient;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    private $otpClient;

    protected function setUp(): void
    {
        $authKey = "";
        $templateId = "";
        $this->otpClient = new OTPClient($authKey, $templateId);
    }

    public function testClient(): void
    {
        $response = $this->otpClient->send();
        $this->assertSame(200, $response->getStatusCode());
    }
}
?>