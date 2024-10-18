<?php


namespace App\Services;

use Aws\Kms\KmsClient;
use Aws\Exception\AwsException;

class KmsService
{
    protected $kmsClient;
    protected $keyId;

    public function __construct()
    {
        $this->kmsClient = new KmsClient([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        // Replace with your KMS Key ID
        $this->keyId = env('AWS_KMS_KEY_ID');
    }

    public function encrypt($plaintext)
    {
        try {
            $result = $this->kmsClient->encrypt([
                'KeyId' => $this->keyId,
                'Plaintext' => $plaintext,
            ]);

            return base64_encode($result['CiphertextBlob']);
        } catch (AwsException $e) {
            // Handle exception
            return null;
        }
    }

    public function decrypt($ciphertext)
    {
        try {
            $result = $this->kmsClient->decrypt([
                'CiphertextBlob' => base64_decode($ciphertext),
            ]);

            return $result['Plaintext'];
        } catch (AwsException $e) {
            // Handle exception
            return null;
        }
    }
}
