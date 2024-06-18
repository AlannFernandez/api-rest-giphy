<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Gateways\GiphyGateway; 
use App\Models\FavoriteGif;
use App\Services\AuthService;


class GiphyController extends Controller
{

    private $giphyGateway;     
    private $authService;

    public function __construct(GiphyGateway $giphyGateway, AuthService $authService) 
    {
        $this->giphyGateway = $giphyGateway;      
        $this->authService  = $authService;
    }


    /**
     * Search for GIFs based on query, with optional limit and offset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchGifs(Request $request)
    {
        try {
            
            $validatedData = $this->validateSearchGifsRequest($request);

            
            $query = $validatedData['query'];
            $limit = $validatedData['limit'] ?? 10; 
            $offset = $validatedData['offset'] ?? 0; 

            
            $response = $this->giphyGateway->searchGifs($query, $limit, $offset);
            
            if ($this->isValidResponse($response)) {
                
                $data = [
                    'gifs' => $response['data'],
                    'pagination' => $response['pagination']
                ];
    
               
                return $this->successResponse($data);
            }

            if($response['error']){
                
                return $this->errorResponse(json_decode($response["error"])->meta->msg, 200);
            }


            throw new \Exception("Invalid response received from API", 1);

        } catch (\Throwable $th) {
            
            return $this->errorResponse($th->getMessage(), 200);
        }
    }

    /**
     * Validate search GIFs request parameters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateSearchGifsRequest(Request $request): array
    {
        return $request->validate([
            'query' => 'required|string',
            'limit' => 'nullable|integer|min:1|max:100',
            'offset' => 'nullable|integer|min:0',
        ]);
    }

    
    /**
     * Search for a GIF by ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @param  \App\Services\GiphyGateway  $giphyGateway
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchId(Request $request, $id)
    {
        try {
            
            $this->validateId($id);
            
            $response = $this->giphyGateway->searchById($id);
            
            if ($this->isValidResponse($response)) {
                return $this->successResponse($response['data']);
            }
            
            if($response['error']){
                
                return $this->errorResponse(json_decode($response["error"])->meta->msg, 200);
            }

            throw new \Exception("Invalid response received from API", 1);
        } catch (\Exception $e) {

            return $this->errorResponse($e->getMessage(), 200);
        }
    }

    /**
     * Validate GIF ID.
     *
     * @param  int  $id
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateId($id)
    {
        $validator = validator(['id' => $id], [
            'id' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException('Invalid GIF ID');
        }
    }

    private function isValidResponse($response)
    {
        return isset($response['meta']['status']) && $response['meta']['status'] === 200 &&
            isset($response['meta']['msg']) && $response['meta']['msg'] === "OK";
    }

     /**
     * Save a favorite GIF for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveFavoriteGif(Request $request)
    {
        try {
            
            $data = $request->validate([
                'gif_id' => 'required|string',
                'alias' => 'required|string|max:255',
            ]);

            
            
            $user = $this->authService->getApiUser();
            
            $existingFavorite = FavoriteGif::where('gif_id', $data['gif_id'])
            ->where('user_id', $user->id)
            ->exists();

            if ($existingFavorite) {
                return $this->errorResponse("You have already saved this GIF.", 400);
            }

            
            $favorite = new FavoriteGif();
            $favorite->gif_id = $data['gif_id'];
            $favorite->alias = $data['alias'];
            $favorite->user_id = $user->id;

            $favorite->save();

            return $this->successResponse($favorite, "GIF saved successfully.");
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 200);
        }
    }

}
