<?php

declare(strict_types=1);

namespace Yansongda\HyperfPay;

use Hyperf\Guzzle\ClientFactory;
use Psr\Container\ContainerInterface;
use Psr\Http\Client\ClientInterface;
use Yansongda\Artful\Contract\HttpClientFactoryInterface;

class HttpClientFactory implements HttpClientFactoryInterface
{
    public function __construct(protected ContainerInterface $container) {}

    public function create(array $options = []): ClientInterface
    {
        return $this->container->get(ClientFactory::class)->create($options);
    }
}
