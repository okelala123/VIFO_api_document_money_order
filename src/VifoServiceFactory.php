<?php

namespace App\Services;


class VifoServiceFactory
{
    private $env;
    public $login;
    private $sendRequest;
    private $bank;
    private $transfer_Money;
    private $approve_Transfer_Money;
    private $other_Request;
    public $headersLogin = [
        'Accept' => 'application/json, text/plain, */*',
        'Accept-Encoding' => 'gzip, deflate',
        'Accept-Language' => '*/*',
    ];
    public $headers = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];
    public function __construct($env = 'dev')
    {
        $this->env = $env;
        $this->login = new VifoAuthenticate();
        $this->sendRequest = new VifoSendRequest($this->env);
    }

    public function login($username, $password)
    {
        $endpoint = '/v1/clients/web/admin/login';
        $body = $this->login->login($username, $password);
        $response = $this->sendRequest->sendRequest('POST', $endpoint, $this->headersLogin, $body);

        if ($response && isset($response['body']['access_token'])) {
            $this->headers['Authorization'] = 'Bearer ' . $response['body']['access_token'];
            $this->headersLogin['Authorization'] = 'Bearer ' . $response['body']['access_token'];
        }
        return $response;
    }

    public function getHeaderBank()
    {
        return $this->bank  = new VifoBank($this->headers);
    }

    public function getHeadereTransferMoney()
    {
        return $this->transfer_Money  = new VifoTransferMoney($this->headers);
    }

    public function ApproveTransferMoney()
    {
        return $this->approve_Transfer_Money  = new VifoApproveTransferMoney($this->headersLogin);
    }

    public function OtherRequest()
    {
        return $this->other_Request  = new VIfoOtherRequest($this->headers);
    }
}
