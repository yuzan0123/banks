<?php

namespace Xyu\Banks;

use Xyu\Banks\Support\AES;

class Decrypt
{
    protected $app;

    public function __construct(BankApp $app)
    {
        $this->app = $app;
    }

    public function verify(string $data, string $sign)
    {
        $publicKey = $this->app->getPublicKey();
        $key = AES::publicKey($publicKey);
        $signature = base64_decode($sign);
        return openssl_verify($data, $signature, $key);
    }

    public function sign(string $data)
    {
        $privateKey = $this->app->getPrivateKey();
        $key = AES::privateKey($privateKey);
        openssl_sign($data,$signature, $key);
        return base64_encode($signature);
    }

    /**
     * @param string $data
     * @return string
     * @throws \Throwable
     */
    public function publicEncrypt(string $data): string
    {
        try {
            $publicKey = $this->app->getPublicKey();
            $key = AES::publicKey($publicKey);
            return AES::pubEncrypt($key, $data);
        }catch (\Throwable $e) {
            throw $e;
        }
    }

    /**
     * @param string $data
     * @return string
     * @throws \Throwable
     */
    public function privateDecrypt(string $data)
    {
        try {
            $privateKey = $this->app->getPrivateKey();
            $key = AES::privateKey($privateKey);
            return AES::priDecrypt($key, $data);
        }catch (\Throwable $e) {
            throw $e;
        }
    }

}