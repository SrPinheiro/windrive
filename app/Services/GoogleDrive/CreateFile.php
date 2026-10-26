<?php

namespace App\Services\GoogleDrive;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;

class CreateFile
{
    public function handle(string $accessToken, string $name, ?string $contents = null, ?string $mimeType = null, ?string $folderId = null): DriveFile
    {
        $client = new Client;
        $client->setAccessToken($accessToken);
        $drive = new Drive($client);

        $metadata = new DriveFile(array_filter([
            'name' => $name,
            'mimeType' => $mimeType,
            'parents' => $folderId ? [$folderId] : null,
        ]));

        $params = ['fields' => 'id, name, mimeType, size, parents, modifiedTime, webViewLink'];
        if ($contents !== null) {
            $params += [
                'data' => $contents,
                'mimeType' => $mimeType ?? 'application/octet-stream',
                'uploadType' => 'multipart',
            ];
        }

        return $drive->files->create($metadata, $params);
    }
}
