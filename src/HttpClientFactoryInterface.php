<?php

namespace Yansongda\HyperfPay;

use Psr\Container\ContainerInterface;
use Yansongda\Pay\Contract\HttpClientInterface;

interface HttpClientFactoryInterface
{
    public function create(ContainerInterface $container, array $config): HttpClientInterface;
}
