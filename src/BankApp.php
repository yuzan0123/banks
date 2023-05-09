<?php

namespace Xyu\Banks;

use Hanson\Foundation\Foundation;
use Xyu\Banks\Ccb\LifeAccount;
use Xyu\Banks\Ccb\Order;

/**
 * Class BankApp
 * @package Xyu\Banks\SandApp
 *
 * @property-read Decrypt $decrypt
 * @property-read LifeAccount $life_account
 * @property-read Order $order
 *
 */
class BankApp extends Foundation
{
    protected $providers = [
        ServiceProvider::class
    ];

    /**
     * @var string
     */
    protected $requestId;

    public function __construct($config)
    {
        if (!isset($config['debug'])) {
            $config['debug'] = $this->config['debug'] ?? false;
        }
        parent::__construct($config);
    }

    public function getUrl()
    {
        return $this->getConfig('url') ?: '';
    }

    public function getSvcid()
    {
        return $this->getConfig('svcid') ?: '';
    }

    public function getPublicKey()
    {
        return $this->getConfig('public_key') ?: '';
    }

    public function getPrivateKey()
    {
        return $this->getConfig('private_key') ?: '';
    }

    public function getEncPub()
    {
        return $this->getConfig('enc_pub') ?: '';
    }

    public function getForMid()
    {
        return $this->getConfig('platform_id') ?: '';
    }

    public function getPlMid()
    {
        return $this->getConfig('pl_mid') ?: '';
    }

    public function getMid()
    {
        return $this->getConfig('mid') ?: '';
    }

    public function getStoreId()
    {
        return $this->getConfig('store_id') ?: '';
    }

    public function getPostId()
    {
        return $this->getConfig('post_id') ?: '';
    }

    public function getBranchId()
    {
        return $this->getConfig('branch_id') ?: '';
    }

    public function getPostId19()
    {
        return $this->getConfig('postid_19') ?: '';
    }

    public function setRequestId(string $requestId): BankApp
    {
        $this->requestId = $requestId;
        return $this;
    }

    public function getRequestId(): string
    {
        return $this->requestId ?? '';
    }

    public function rebind(string $id, $value): BankApp
    {
        $this->offsetUnset($id);
        $this->offsetSet($id, $value);

        return $this;
    }
}