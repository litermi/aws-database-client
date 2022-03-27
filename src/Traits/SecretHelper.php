<?php

namespace App\Core\Base\Traits;
use Aws\Exception\AwsException;
use Aws\SecretsManager\SecretsManagerClient;
use Illuminate\Support\Facades\Cache;

/**
 * Trait SecretHelper
 * @package App\Traits
 */
trait SecretHelper
{
    /**
     * @param $secret
     * @return mixed|void
     */
    public static function getSecret($secret)
    {
        $cacheKey = "database-config-trait-" . $secret;
        $cacheKeyBackUp = "database-config-trait-" . $secret;
        $expiresIn = now()->addSeconds(30);
        $backupExpiresIn = now()->addHours(12);

        //check if config is in cache
        if (Cache::has($cacheKey)) {
            //get from cache
            return Cache::get($cacheKey);
        }

        $client = new SecretsManagerClient(config('aws-database-client.parameters_secret_manager'));

        $secretName = config('app.env').'/'.$secret;

        try {
            //dd($client);
            $result = $client->getSecretValue([
                'SecretId' => $secretName,
            ]);

        } catch (AwsException $e) {
                $error = $e->getAwsErrorCode();
            if ($error == 'DecryptionFailureException') {
                // Secrets Manager can't decrypt the protected secret text using the provided AWS KMS key.
                // Handle the exception here, and/or rethrow as needed.
                if (!Cache::has('Notification-sent-vault' . $secret)) {
                    Cache::put('Notification-sent-vault' . $secret, 'sent', 10);
                }
                throw $e;
            }
            if ($error == 'InternalServiceErrorException') {
                // An error occurred on the server side.
                // Handle the exception here, and/or rethrow as needed.
                if (!Cache::has('Notification-sent-vault' . $secret)) {
                    Cache::put('Notification-sent-vault' . $secret, 'sent', 10);
                }
                throw $e;
            }
            if ($error == 'InvalidParameterException') {
                // You provided an invalid value for a parameter.
                // Handle the exception here, and/or rethrow as needed.
                if (!Cache::has('Notification-sent-vault' . $secret)) {
                    Cache::put('Notification-sent-vault' . $secret, 'sent', 10);
                }
                throw $e;
            }
            if ($error == 'InvalidRequestException') {
                // You provided a parameter value that is not valid for the current state of the resource.
                // Handle the exception here, and/or rethrow as needed.
                if (!Cache::has('Notification-sent-vault' . $secret)) {
                    Cache::put('Notification-sent-vault' . $secret, 'sent', 10);
                }
                throw $e;
            }
            if ($error == 'ResourceNotFoundException') {
                // We can't find the resource that you asked for.
                // Handle the exception here, and/or rethrow as needed.

                throw $e;
            }
             throw $e;
        }
        // Decrypts secret using the associated KMS CMK.
        // Depending on whether the secret is a string or binary, one of these fields will be populated.
        if (isset($result['SecretString'])) {
            $secret = $result['SecretString'];
            $configs = json_decode($result['SecretString'], true);

            if (isset($expiresIn)) {
                Cache::put($cacheKey, $configs, $expiresIn);
                //save backup
                Cache::put($cacheKeyBackUp, $configs, $backupExpiresIn);
            }
            return $configs;
        }
    }
}
