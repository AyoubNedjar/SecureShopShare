<?php

namespace App\Helpers;

use phpseclib3\Crypt\RSA;
use phpseclib3\Crypt\AES;
use phpseclib3\Crypt\Random;
use phpseclib3\Crypt\Padding;
use Exception;

class CryptoHelper
{
    public static function generateRsaKeys()
    {
        $rsa = RSA::createKey(2048);
        return [
            'private_key' => $rsa->toString('PKCS1'),
            'public_key' => $rsa->getPublicKey()->toString('PKCS1')
        ];
    }

    public static function encryptAes($data, $key)
    {
        $iv = Random::string(16);
        $aes = new AES('cbc');
        $aes->setKey($key);
        $aes->setIV($iv);
        $aes->enablePadding();
        $ciphertext = $aes->encrypt($data);
        return $iv . $ciphertext;
    }

    public static function decryptAes($encryptedData, $key)
    {
        $iv = substr($encryptedData, 0, 16);
        $ciphertext = substr($encryptedData, 16);
        $aes = new AES('cbc');
        $aes->setKey($key);
        $aes->setIV($iv);
        $aes->enablePadding();
        return $aes->decrypt($ciphertext);
    }

    public static function encryptRsa($data, $publicKey)
    {
        $rsa = RSA::load($publicKey);
        return $rsa->encrypt($data);
    }

    public static function decryptRsa($ciphertext, $privateKey)
    {
        $rsa = RSA::load($privateKey);
        return $rsa->decrypt($ciphertext);
    }
}
