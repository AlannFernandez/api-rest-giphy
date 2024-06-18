<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use app\Traits\Response;


class HttpService
{
    /**
     * Make an HTTP request.
     *
     * @param string $method The HTTP method (GET, POST, PUT, DELETE).
     * @param string $url The URL to which the request will be sent.
     * @param array $options The options for the request (parameters, headers, etc.).
     * @return array The decoded response of the request.
     */
    public function makeRequest(string $method, string $url, array $options = [])
    {   
        
        $response = Http::withOptions($options)->$method($url);
        
        if ($response->successful()) {
            return (object)[
                'success' => true,
                'data' => $response->json(),
            ];
        } else {
            return (object)[
                'success' => false,
                'message' => $response->body(),
            ];
        }
    }
}
