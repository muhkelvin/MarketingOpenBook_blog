<?php

namespace App\Filament\Resources;

use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;

class ImgurService
{
    protected $client;
    protected $clientId;

    public function __construct()
    {
        $this->client = new Client();
        $this->clientId = config('services.imgur.client_id');
    }

    public function upload(UploadedFile $file)
    {
        // Create temp file for upload
        $tempPath = $file->getRealPath();

        // Upload to Imgur directly
        $response = $this->client->post('https://api.imgur.com/3/image', [
            'headers' => [
                'Authorization' => 'Client-ID ' . $this->clientId,
            ],
            'multipart' => [
                [
                    'name' => 'image',
                    'contents' => fopen($tempPath, 'r'),
                    'filename' => $file->getClientOriginalName()
                ],
            ],
        ]);

        // Return the URL
        $responseData = json_decode($response->getBody()->getContents(), true);

        if (!isset($responseData['data']['link'])) {
            throw new \Exception('Failed to upload image to Imgur');
        }

        return $responseData['data']['link'];
    }
}
