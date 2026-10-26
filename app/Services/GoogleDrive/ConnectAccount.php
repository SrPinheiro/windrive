<?php

namespace App\Services\GoogleDrive;

use App\Models\DriveAccount;
use App\Models\GoogleCredential;
use Google\Client;
use Google\Service\Drive;
use RuntimeException;

class ConnectAccount
{
    public function handle(GoogleCredential $credential, string $redirectUri, string $code): DriveAccount
    {
        $client = new Client;
        $client->setClientId($credential->client_id);
        $client->setClientSecret($credential->client_secret);
        $client->setRedirectUri($redirectUri);

        $token = $client->fetchAccessTokenWithAuthCode($code);
        if (isset($token['error'])) {
            throw new RuntimeException($token['error_description'] ?? $token['error']);
        }

        $about = (new Drive($client))->about->get(['fields' => 'user(emailAddress)']);
        $account = $credential->accounts()->firstOrNew(['email' => $about->getUser()->getEmailAddress()]);

        $account->fill([
            'access_token' => $token['access_token'],
            'refresh_token' => $token['refresh_token'] ?? $account->refresh_token,
            'expires_at' => now()->addSeconds($token['expires_in']),
        ])->save();

        return $account;
    }
}
