<?php

namespace Xyu\Banks\Support;

use Xyu\Banks\Exception\AesException;

class AES
{
    const MAX_ENCRYPT_BLOCK = 117;

    const MAX_DECRYPT_BLOCK = 128;


    public static function priDecrypt($priKey, string $data)
    {
        $result = '';

        $data = str_split($data, self::MAX_DECRYPT_BLOCK);

        foreach ($data as $block) {
            openssl_private_decrypt($block,$decrypted, $priKey);
            $result .= $decrypted;
        }

        return $result ?: '';
    }

    public static function pubEncrypt(string $pubKey, string $data)
    {
        $result = '';

        $data = str_split($data, self::MAX_ENCRYPT_BLOCK);

        foreach ($data as $block) {
            openssl_public_encrypt($block,$encrypted, $pubKey);
            $result .= $encrypted;
        }

        return $result ? base64_encode($result) : '';
    }


    /**
     * 签名构造
     * @param string $data
     * @param string $privateKey
     * @return string
     */
    public static function sign(string $data, string $privateKey): string
    {
        openssl_sign($data,$signature, $privateKey);
        return base64_encode($signature);
    }

    /**
     * 验证签名
     * @param string $data
     * @param string $signString
     * @param string $pubKey
     * @return false|int
     */
    public static function verify(string $data, string $signString, string $pubKey)
    {
        $signature = base64_decode($signString);
        return openssl_verify($data, $signature, $pubKey);
    }


    // 公钥
    public static function publicKey(string $public_key_path)
    {
        try {
            $file = file_get_contents($public_key_path);
            if (!$file) {
                throw new AesException('getPublicKey::file_get_contents ERROR');
            }
            $cert   = chunk_split($file, 64, "\n");
            $cert   = "-----BEGIN CERTIFICATE-----\n" . $cert . "-----END CERTIFICATE-----\n";
            $res    = openssl_pkey_get_public($cert);
            $detail = openssl_pkey_get_details($res);
            unset($res);
            if (!$detail) {
                throw new AesException('getPublicKey::openssl_pkey_get_details ERROR');
            }
            return $detail['key'];
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    // 私钥
    public static function privateKey(string $privateKey)
    {
        try {
            $file = file_get_contents($privateKey);
            if (!$file) {
                throw new AesException('getPrivateKey::file_get_contents ERROR');
            }
            $cert   = chunk_split($file, 64, "\n");
            $cert   = "-----BEGIN PRIVATE-----\n" . $cert . "-----END PRIVATE-----\n";
            $res    = openssl_pkey_get_private($cert);
            if (! $res) {
                throw new AesException('getPrivateKey::openssl_pkey_get_details ERROR');
            }
            return $res;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

}