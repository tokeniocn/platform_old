<?php

namespace App\Gateways\Sms;

use Overtrue\EasySms\Support\Config;
use Overtrue\EasySms\Gateways\Gateway;
use Overtrue\EasySms\Traits\HasHttpRequest;
use Overtrue\EasySms\Contracts\MessageInterface;
use Overtrue\EasySms\Contracts\PhoneNumberInterface;

class DuanXinBaoGateway extends Gateway
{
    use HasHttpRequest;

    const ENDPOINT_URL = 'http://api.smsbao.com';

    /**
     * @var array
     */
    protected $statusStr = [
        "0" => "短信发送成功",
        "-1" => "参数不全",
        "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
        "30" => "密码错误",
        "40" => "账号不存在",
        "41" => "余额不足",
        "42" => "帐户已过期",
        "43" => "IP地址限制",
        "50" => "内容含有敏感词"
    ];

    public function send(PhoneNumberInterface $to, MessageInterface $message, Config $config)
    {
        $endpoint = $config->get('endpoint', static::ENDPOINT_URL);

        $result = $this->get($endpoint, [
            'u' => $config->get('user'),
            'p' =>  md5($config->get('pass')),
            'm' => $to,
            'c' => $message->getContent($this)
        ]);

        $response = [
            'status' => $result,
            'message' => $this->statusStr[$result] ?? 'error',
        ];

        return $response;
    }
}
