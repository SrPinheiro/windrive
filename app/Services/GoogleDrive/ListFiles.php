<?php

namespace App\Services\GoogleDrive;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\FileList;

class ListFiles
{
    public function handle(string $accessToken, ?string $folderId = null, int $pageSize = 100, ?string $pageToken = null): FileList
    {
        $client = new Client;
        $client->setAccessToken($accessToken);
        $drive = new Drive($client);

        $conditions = ['trashed = false'];
        if ($folderId) {
            $conditions[] = "'{$folderId}' in parents";
        }

        return $drive->files->listFiles(array_filter([
            'q' => implode(' and ', $conditions),
            'pageSize' => $pageSize,
            'pageToken' => $pageToken,
            'fields' => 'nextPageToken, files(id, name, mimeType, size, parents, modifiedTime, webViewLink)',
        ]));
    }
}
