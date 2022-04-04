<?php

namespace Yansongda\HyperfPay;

use Yansongda\Pay\Contract\ContainerInterface;
use Yansongda\Pay\Contract\HttpClientInterface;

interface HttpClientFactoryInterface
{
    public function create(ContainerInterface $container, array $config): HttpClientInterface;
}
