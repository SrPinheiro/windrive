<?php

namespace App\Services\GoogleDrive;

use App\Models\GoogleCredential;
use Google\Client;
use Google\Service\Drive;

class AuthorizationUrl
{
    public function handle(GoogleCredential $credential, string $redirectUri, string $state): string
    {
        $client = new Client;
        $client->setClientId($credential->client_id);
        $client->setClientSecret($credential->client_secret);
        $client->setRedirectUri($redirectUri);
        $client->setScopes([Drive::DRIVE]);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
        $client->setState($state);

        return $client->createAuthUrl();
    }
}
