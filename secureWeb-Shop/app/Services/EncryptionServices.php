<?php

namespace App\Services;

use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Crypt\RSA;
use Illuminate\Support\Facades\Crypt as LaravelCrypt;

class EncryptionService
{
    /**
     * Encrypt data using the provided public key.
     *
     * @param string $data The data to encrypt.
     * @param string $publicKey The public key in PEM format.
     * @return string The encrypted data.
     */
    public static function encryptData($data, $publicKey)
    {
        $rsa = PublicKeyLoader::load($publicKey);
        return $rsa->encrypt($data);
    }

    /**
     * Decrypt data using the encrypted private key and password.
     *
     * @param string $encryptedData The encrypted data to decrypt.
     * @param string $encryptedPrivateKey The encrypted private key.
     * @param string $password The password to decrypt the private key.
     * @return string The decrypted data.
     */
    public static function decryptData($encryptedData, $encryptedPrivateKey, $password)
    {
        // Decrypt the private key
        $privateKeyString = LaravelCrypt::decryptString($encryptedPrivateKey);

        // Load the private key
        $privateKey = PublicKeyLoader::load($privateKeyString);

        // Decrypt the data
        return $privateKey->decrypt($encryptedData);
    }
}
