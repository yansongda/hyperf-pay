<?php

namespace Yansongda\HyperfPay;

use Psr\Container\ContainerInterface;
use Yansongda\Pay\Contract\HttpClientInterface;

class HttpClientFactory implements HttpClientFactoryInterface
{
    public function create(ContainerInterface $container, array $config): HttpClientInterface
    {
        return new HttpClient($container, $config);
    }
}
