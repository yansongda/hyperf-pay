<?php

declare(strict_types=1);

namespace Yansongda\HyperfPay;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Guzzle\ClientFactory;
use Hyperf\Utils\ApplicationContext;
use Psr\EventDispatcher\EventDispatcherInterface;
use Yansongda\Pay\Contract\HttpClientInterface;
use Yansongda\Pay\Contract\LoggerInterface;
use Yansongda\Pay\Pay as BigPay;
use Yansongda\Pay\Provider\Alipay;
use Yansongda\Pay\Provider\Wechat;

class Pay
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var
     */
    protected $http;

    /**
     * @throws \Yansongda\Pay\Exception\ServiceNotFoundException
     * @throws \Yansongda\Pay\Exception\ContainerException
     * @throws \Yansongda\Pay\Exception\ContainerDependencyException
     */
    public function __construct(ConfigInterface $config, ClientFactory $clientFactory)
    {
        $this->config = $config->get('pay');
        $this->http = $clientFactory->create($this->config['http'] ?? []);

        BigPay::config($this->config);

        $this->bootstrapHttpClient();
        $this->bootstrapLogger();
        $this->bootstrapEvent();
    }

    public function alipay(array $config = []): Alipay
    {
        return BigPay::alipay($config);
    }

    public function wechat(array $config = []): Wechat
    {
        return BigPay::wechat($config);
    }

    /**
     * @throws \Yansongda\Pay\Exception\ContainerException
     */
    public function bootstrapHttpClient(): void
    {
        BigPay::set(HttpClientInterface::class, $this->http);
    }

    /**
     * @throws \Yansongda\Pay\Exception\ContainerException
     */
    protected function bootstrapLogger(): void
    {
        $container = ApplicationContext::getContainer();

        if ($container->has(StdoutLoggerInterface::class)) {
            BigPay::set(LoggerInterface::class, $container->get(StdoutLoggerInterface::class));
        }
    }

    /**
     * @throws \Yansongda\Pay\Exception\ContainerException
     */
    protected function bootstrapEvent(): void
    {
        $container = ApplicationContext::getContainer();

        if ($container->has(EventDispatcherInterface::class)) {
            BigPay::set(\Yansongda\Pay\Contract\EventDispatcherInterface::class, $container->get(EventDispatcherInterface::class));
        }
    }
}
