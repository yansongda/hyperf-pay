<?php

declare(strict_types=1);

namespace Yansongda\HyperfPay;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\ContainerInterface;
use Hyperf\Logger\LoggerFactory;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Yansongda\Artful\Contract\HttpClientFactoryInterface;
use Yansongda\Artful\Contract\LoggerInterface;
use Yansongda\Artful\Exception\ContainerException;
use Yansongda\Pay\Pay as BigPay;
use Yansongda\Pay\Provider\Alipay;
use Yansongda\Pay\Provider\Unipay;
use Yansongda\Pay\Provider\Wechat;

class Pay implements PayInterface
{
    protected array $config;

    protected ContainerInterface $container;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ContainerException
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
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ContainerException
     */
    protected function bootstrapHttpClient(): void
    {
        BigPay::set(HttpClientFactoryInterface::class, $this->container->get(HttpClientFactory::class));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ContainerException
     */
    protected function bootstrapLogger(): void
    {
        if (true === ($this->config['logger']['enable'] ?? false)
            && $this->container->has(LoggerFactory::class)) {
            BigPay::set(
                LoggerInterface::class,
                $this->container->get(LoggerFactory::class)->get('pay', $this->config['logger']['config'] ?? 'default')
            );
        }
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ContainerException
     */
    protected function bootstrapEvent(): void
    {
        if ($this->container->has(EventDispatcherInterface::class)) {
            BigPay::set(
                \Yansongda\Artful\Contract\EventDispatcherInterface::class,
                $this->container->get(EventDispatcherInterface::class)
            );
        }
    }
}
