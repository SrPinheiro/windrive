<?php

namespace App\Services\GoogleDrive;

use App\Models\DriveAccount;
use Google\Client;
use RuntimeException;

class AccessToken
{
    public function handle(DriveAccount $account): string
    {
        if ($account->expires_at->isAfter(now()->addMinute())) {
            return $account->access_token;
        }

        $client = new Client;
        $client->setClientId($account->credential->client_id);
        $client->setClientSecret($account->credential->client_secret);

        $token = $client->fetchAccessTokenWithRefreshToken($account->refresh_token);
        if (isset($token['error'])) {
            throw new RuntimeException($token['error_description'] ?? $token['error']);
        }

        $account->update([
            'access_token' => $token['access_token'],
            'expires_at' => now()->addSeconds($token['expires_in']),
        ]);

        return $account->access_token;
    }
}
