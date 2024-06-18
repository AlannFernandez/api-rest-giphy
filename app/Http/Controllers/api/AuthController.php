<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * User registration endpoint.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try {
            
            $validatedData = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required'
            ]);
            
            $validatedData['password'] = bcrypt($validatedData['password']);
            
            $user = User::create($validatedData);
            
            $tokenResult = $user->createToken('authToken');
            $token = $tokenResult->accessToken;
            
            $response = [
                'user' => $user,
                'token' => $token
            ];

            return $this->successResponse($response, "User created successfully.");

        } catch (\Throwable $th) {
            
            return $this->errorResponse($th->getMessage(), 400);
        }
    }

    /**
     * User login endpoint.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            
            $validatedData = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
            
            if (!Auth::attempt($validatedData)) {
                return $this->errorResponse('Invalid credentials', 200);
            }
            
            $user = Auth::user();
            
            $tokenResult = $user->createToken('authToken');
            $token = $tokenResult->accessToken;

            
            return $this->successResponse(['token' => $token], "User logged in successfully.");

        } catch (\Throwable $th) {
            
            return $this->errorResponse($th->getMessage(), 400);
        }
    }

    /**
     * Get information of the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userInfo(Request $request)
    {
        try {            
            $user = $this->authService->getApiUser();
            
            return $this->successResponse($user);

        } catch (\Throwable $th) {
            
            return $this->errorResponse($th->getMessage(), 400);
        }
    }
}
