<?php

namespace Yansongda\HyperfPay;

use GuzzleHttp\Client;
use Hyperf\Contract\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Yansongda\Pay\Contract\HttpClientInterface;

class HttpClient implements HttpClientInterface
{
    protected ContainerInterface $container;

    protected array $config;

    public function __construct(ContainerInterface $container, array $config)
    {
        $this->container = $container;
        $this->config = $config;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $client = new Client($this->config['http'] ?? []);

        return $client->sendRequest($request);
    }
}
