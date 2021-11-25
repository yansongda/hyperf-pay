<p align="center">
<a href="https://pay.yansongda.cn" target="_blank" rel="noopener noreferrer"><img width="200" src="https://cdn.jsdelivr.net/gh/yansongda/pay-site/.vuepress/public/images/logo.png" alt="Logo"></a>
</p>

## 运行环境

- php >= 7.3
- composer
- hyperf >= 2.1

## 安装

```shell
composer require yansongda/hyperf-pay:~1.0.0
```

## 说明

### 发布配置文件

```shell
php bin/hyperf.php vendor:publish yansongda/hyperf-pay
```

### 使用

```php
<?php

declare(strict_types=1);

namespace App\Controller;

use Yansongda\HyperfPay\Pay;
use Hyperf\HttpServer\Annotation\AutoController;

/**
 * @AutoController()
 */
class IndexController extends AbstractController
{
    public function index(Pay $pay)
    {
        return $pay->alipay()->web([
            'out_trade_no' => ''.time(),
            'total_amount' => '0.01',
            'subject' => 'yansongda 测试 - 1',
        ]);
    }
}

```

## 详细文档

[https://pay.yansongda.cn](https://pay.yansongda.cn)
