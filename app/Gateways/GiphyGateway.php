<?php

namespace App\Gateways;

use App\Services\HttpService;


class GiphyGateway
{
    private $url;
    private $key;
    private $httpClient;

    public function __construct(HttpService $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = config('app.url_api_giphy');
        $this->apiKey = config('app.api_key_giphy');
    }


    /**
     * Searches for tags related to a given query using the Giphy API.
     *
     * @param string $query The search query.
     * @param int $limit The maximum number of results to return. Default is 25.
     * @param int $offset The offset for pagination. Default is 0.
     * @return array An array containing the search results or an error message if the request fails.
     */
    public function searchGifs(string $query, int $limit = 25, int $offset = 0): array
    {
        try {
                        
            $url = $this->baseUrl . '/v1/gifs/search?api_key=' . $this->apiKey . '&q=' . urlencode($query) . '&limit=' . $limit . '&offset=' . $offset;
            
            $response = $this->httpClient->makeRequest('GET', $url);
                        
            if (isset($response->success) && $response->success === true) {
                return $response->data;
            }
            
            return ['error' => $response->message];

        } catch (\Exception $e) {
            
            $errorMessage = 'An error occurred while communicating with the Giphy API: ' . $e->getMessage();
            return ['error' => $errorMessage];
        }
    }



   /**
     * Searches for a GIF by its unique identifier (ID) using the Giphy API.
     *
     * @param string $gifId The unique identifier (ID) of the GIF to search for.
     * @param string $rating The content rating of the GIF (optional). Default is 'pg-13'.
     * @return array An array containing the GIF data or an error message if the request fails.
     */
    public function searchById(string $gifId, string $rating = 'pg-13'): array
    {
        try {
            $url = $this->baseUrl . '/v1/gifs/' . urlencode($gifId) . '?api_key=' . $this->apiKey . '&rating=' . urlencode($rating);

            $response = $this->httpClient->makeRequest('GET', $url);

            
            if (isset($response->success) && $response->success === true) {
                return $response->data;        
            }    
            
            return ['error' => $response->message];
        
        } catch (\Exception $e) {
            
            $errorMessage = 'An error occurred while communicating with the Giphy API: ' . $e->getMessage();
            return ['error' => $errorMessage];
        }
    }


}