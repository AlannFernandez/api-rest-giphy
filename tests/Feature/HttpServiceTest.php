<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\HttpService;
use Illuminate\Support\Facades\Http;

class HttpServiceTest extends TestCase
{
    /**
     * Test HTTP GET request.
     *
     * @return void
     */
    public function test_http_get_request()
    {
        $url = 'https://jsonplaceholder.typicode.com/posts/1';
        $httpService = new HttpService();

        $response = $httpService->makeRequest('GET', $url);
        $this->assertTrue($response->success);
        $this->assertArrayHasKey('userId', $response->data);
        $this->assertEquals(1, $response->data['id']);
    }

    /**
     * Test HTTP POST request.
     *
     * @return void
     */
    public function test_http_post_request()
    {
        $url = 'https://jsonplaceholder.typicode.com/posts';
        $postData = [
            'title' => 'foo',
            'body' => 'bar',
            'userId' => 1,
        ];
        $httpService = new HttpService();

        $response = $httpService->makeRequest('POST', $url, [
            'json' => $postData,
        ]);

        $this->assertTrue($response->success);
        $this->assertArrayHasKey('id', $response->data);
    }

    /**
     * Test HTTP PUT request.
     *
     * @return void
     */
    public function test_http_put_request()
    {
        $url = 'https://jsonplaceholder.typicode.com/posts/1';
        $putData = [
            'id' => 1,
            'title' => 'foo',
            'body' => 'bar',
            'userId' => 1,
        ];
        $httpService = new HttpService();
        
        $response = $httpService->makeRequest('PUT', $url, [
            'json' => $putData,
        ]);
        
        $this->assertTrue($response->success);
        $this->assertEquals('foo', $response->data['title']);
    }

    /**
     * Test HTTP DELETE request.
     *
     * @return void
     */
    public function test_http_delete_request()
    {
        
        $url = 'https://jsonplaceholder.typicode.com/posts/1';
        $httpService = new HttpService();

        
        $response = $httpService->makeRequest('DELETE', $url);

        
        $this->assertTrue($response->success);
        
    }
}
