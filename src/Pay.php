<?php

declare(strict_types=1);

namespace Yansongda\HyperfPay;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\ContainerInterface;
use Hyperf\Guzzle\ClientFactory;
use Hyperf\Logger\LoggerFactory;
use Psr\EventDispatcher\EventDispatcherInterface;
use Yansongda\Pay\Contract\HttpClientInterface;
use Yansongda\Pay\Contract\LoggerInterface;
use Yansongda\Pay\Pay as BigPay;
use Yansongda\Pay\Provider\Alipay;
use Yansongda\Pay\Provider\Unipay;
use Yansongda\Pay\Provider\Wechat;

class Pay implements PayInterface
{
    protected array $config;

    protected ContainerInterface $container;

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Yansongda\Pay\Exception\ContainerException
     */
    public function __construct(ContainerInterface $container)
    {
        $this->config = $container->get(ConfigInterface::class)->get('pay', []);
        $this->container = $container;

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

    public function unipay(array $config = []): Unipay
    {
        return BigPay::unipay($config);
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Yansongda\Pay\Exception\ContainerException
     */
    protected function bootstrapHttpClient(): void
    {
        if ($this->container->has(HttpClientFactoryInterface::class) && $factory = $this->container->get(HttpClientFactoryInterface::class)) {
            $client = $factory->create($this->container, $this->config);
        } else {
            $client = $this->container->get(ClientFactory::class)->create($this->config['http'] ?? []);
        }
        BigPay::set(HttpClientInterface::class, $client);
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Yansongda\Pay\Exception\ContainerException
     */
    protected function bootstrapLogger(): void
    {
        if (true === ($this->config['logger']['enable'] ?? false) &&
            $this->container->has(LoggerFactory::class)) {
            BigPay::set(
                LoggerInterface::class,
                $this->container->get(LoggerFactory::class)->get('pay', $this->config['logger']['config'] ?? 'default')
            );
        }
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Yansongda\Pay\Exception\ContainerException
     */
    protected function bootstrapEvent(): void
    {
        if ($this->container->has(EventDispatcherInterface::class)) {
            BigPay::set(
                \Yansongda\Pay\Contract\EventDispatcherInterface::class,
                $this->container->get(EventDispatcherInterface::class)
            );
        }
    }
}
