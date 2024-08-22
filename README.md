# yzan/banks
bank sdk

* 支持`建行生活`相关API
* 支持 `composer` 安装
* 支持 hyperf、laravel/lumen、tp 等框架

## 安装 - install

```bash
composer require yzan/banks
```

发布配置 vendor:publish
```bash
Hyperf
php bin/hyperf.php vendor:publish yzan/banks
```

```php
Hyperf调用：
$app = ccb()->life_account->occJumpUrl([]);
其它调用：
$app = (new \Xyu\Banks\BankApp($config))->life_account->occJumpUrl([]);
```