<?php

declare(strict_types=1);

namespace Yansongda\HyperfPay;

use Yansongda\Pay\Provider\Alipay;
use Yansongda\Pay\Provider\Unipay;
use Yansongda\Pay\Provider\Wechat;

interface PayInterface
{
    public function alipay(array $config = []): Alipay;

    public function wechat(array $config = []): Wechat;

    public function unipay(array $config = []): Unipay;
}
