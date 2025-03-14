<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImgurUploadTest extends TestCase
{
    /** @test */
    public function test_imgur_image_upload()
    {
        // 1. Persiapkan file test
        Storage::disk('public')->put('test.jpg', file_get_contents('https://picsum.photos/200'));
        $filePath = storage_path('app/public/test.jpg');

        // 2. Inisialisasi client
        $client = new Client();

        // 3. Eksekusi request ke Imgur
        $response = $client->post('https://api.imgur.com/3/image', [
            'headers' => [
                'Authorization' => 'Client-ID ' . env('IMGUR_CLIENT_ID')
            ],
            'form_params' => [
                'image' => base64_encode(file_get_contents($filePath)),
                'type' => 'base64'
            ]
        ]);

        // 4. Assert hasil
        $responseData = json_decode($response->getBody(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($responseData['success']);
        $this->assertStringContainsString('i.imgur.com', $responseData['data']['link']);

        // 5. Bersihkan file test
        Storage::disk('public')->delete('test.jpg');
    }

    /** @test */
    public function test_invalid_client_id()
    {
        $client = new Client();

        $this->expectException(\GuzzleHttp\Exception\ClientException::class);

        $client->post('https://api.imgur.com/3/image', [
            'headers' => [
                'Authorization' => 'Client-ID invalid_client_id'
            ],
            'form_params' => [
                'image' => base64_encode('invalid_content')
            ]
        ]);
    }
}
