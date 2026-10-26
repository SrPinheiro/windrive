<?php

namespace App\Services\GoogleDrive;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;

class DeleteFile
{
    public function handle(string $accessToken, string $fileId, bool $permanent = false): void
    {
        $client = new Client;
        $client->setAccessToken($accessToken);
        $drive = new Drive($client);

        if ($permanent) {
            $drive->files->delete($fileId);
        } else {
            $drive->files->update($fileId, new DriveFile(['trashed' => true]));
        }
    }
}
