<?php

namespace Msg91;

use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;

final class OtpClient
{
    private const BASE_API  = 'https://api.msg91.com/api/v5/';

    private $httpClient;

    private $authKey;
    private $templateId;
    private $extraParams;
    private $mobile;
    private $invisible;
    private $otp;
    private $userIP;
    private $email;
    private $otpLength;
    private $otpExpiry;

    private $retryType;

    public function __construct(string $authKey, string $templateId)
    {
        $this
            ->setAuthKey($authKey)
            ->setTemplateId($templateId)
            ->setExtraParams([]);

        $this->httpClient = new HttpClient([
            'base_uri' => self::BASE_API
        ]);
    }

    public function send(): ResponseInterface
    {
        return $this->httpClient->get('otp', [
            'query' => $this->toSendParams()
        ]);
    }

    public function resend(): ResponseInterface
    {
        return $this->httpClient->post('otp/retry', [
            'query' => $this->toResendParams()
        ]);
    }

    public function verify(): ResponseInterface
    {
        return $this->httpClient->post('otp/verify', [
            'query' => $this->toVerifyParams()
        ]);
    }

    public function setAuthKey(string $authKey): OtpClient
    {
        $this->authKey = $authKey;
        return $this;
    }

    public function setTemplateId(string $templateId): OtpClient
    {
        $this->templateId = $templateId;
        return $this;
    }

    public function setExtraParams(array $extraParams): OtpClient
    {
        $this->extraParams = json_encode($extraParams);
        return $this;
    }

    public function setMobile(int $mobile): OtpClient
    {
        $this->mobile = $mobile;
        return $this;
    }

    public function setInvisible(bool $invisible): OtpClient
    {
        $this->invisible = $invisible ? 1 : 0;
        return $this;
    }

    public function setOTP(int $otp): OtpClient
    {
        $this->otp = $otp;
        return $this;
    }

    public function setUserIP(string $userIP): OtpClient
    {
        $this->userIP = $userIP;
        return $this;
    }

    public function setEmail(string $email): OtpClient
    {
        $this->email = $email;
        return $this;
    }

    public function setOTPLength(int $otpLength): OtpClient
    {
        $this->otpLength = $otpLength;
        return $this;
    }

    public function setOTPExpiry(int $otpExpiry): OtpClient
    {
        $this->otpExpiry = $otpExpiry;
        return $this;
    }

    public function setRetryType(string $retryType): OtpClient
    {
        $this->retryType = $retryType;
        return $this;
    }

    private function toSendParams(): array
    {
        $data = [];

        $data['authkey'] = $this->authKey;
        $data['template_id'] = $this->templateId;
        $data['extra_param'] = $this->extraParams;
        $data['mobile'] = $this->mobile;

        if (isset($this->invisible)) {
            $data['invisible'] = $this->invisible;
        }
        
        if (isset($this->otp)) {
            $data['otp'] = $this->otp;
        }

        if (isset($this->userIP)) {
            $data['userip'] = $this->userIP;
        }

        if (isset($this->email)) {
            $data['email'] = $this->email;
        }
        
        if (isset($this->otpLength)) {
            $data['otp_length'] = $this->otpLength;
        }
        
        if (isset($this->otpExpiry)) {
            $data['otp_expiry'] = $this->otpExpiry;
        }
        
        return $data;
    }

    private function toResendParams(): array
    {
        $data = [];

        $data['authkey'] = $this->authKey;
        $data['mobile'] = $this->mobile;

        if (isset($this->retryType)) {
            $data['retrytype'] = $this->retryType;
        }
        
        return $data;
    }

    private function toVerifyParams(): array
    {
        $data = [];

        $data['authkey'] = $this->authKey;
        $data['mobile'] = $this->mobile;
        $data['otp'] = $this->otp;
        
        return $data;
    }
}
