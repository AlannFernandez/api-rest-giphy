<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\RequestLog;
use App\Services\AuthService;


class LogRequests
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {    

                
        $user = $this->authService->getApiUser();
        $userId = $user ? $user->id : null;
        $response = $next($request);
        $service = $request->path();
        $requestBody = $request->except(['password']);
        $statusCode = $response->getStatusCode();
        $responseBody = json_encode($response->getContent());
        $ip = $request->ip();

        
        RequestLog::create([
            'user_id' => $userId,
            'service' => $service,
            'request_body' => $requestBody,
            'status_code' => $statusCode,
            'response_body' => $responseBody,
            'ip' => $ip,
        ]);

        return $response;
    }
           
}
