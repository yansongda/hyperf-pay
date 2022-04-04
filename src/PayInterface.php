<?php

namespace Yansongda\HyperfPay;

use Yansongda\Pay\Provider\Alipay;
use Yansongda\Pay\Provider\Wechat;

interface PayInterface
{
    public function alipay(array $config = []): Alipay;

    public function wechat(array $config = []): Wechat;
}
