<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\api\AuthController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login endpoint.
     *
     * @return void
     */
    public function test_login()
    {
        
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('1q2w3e4r'),
        ]);

        
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => '1q2w3e4r',
        ]);
        
        $response->assertStatus(200);
        
        $response->assertJsonStructure([
            'data' => [
                'token',
            ],
            'message',
        ]);

        

        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $response['data']['token'],
        ])->get('/api/get-user');

        $response->assertStatus(200);
        $response->assertJson([
            'id',
            'name',
            'email',
        ]);
    }
}
