<?php

declare(strict_types=1);

namespace Yansongda\HyperfPay;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
            ],
            'commands' => [
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'Pay 配置文件.',
                    'source' => __DIR__ . '/../publish/pay.php',
                    'destination' => BASE_PATH . '/config/autoload/pay.php',
                ],
            ],
        ];
    }
}
