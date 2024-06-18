<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService {

    /**
     * Get the currently authenticated API user.
     *
     * @return \App\Models\User|null The authenticated user instance, or null if no user is authenticated.
     */
    public function getApiUser() {
        return Auth::guard('api')->user();
    }
}
