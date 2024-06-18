<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\api\AuthController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;

class AuthControllerUnitTest extends TestCase
{
    use RefreshDatabase; // Utiliza esta trait para asegurarte de que las pruebas no afecten la base de datos de producción

    /**
     * Test login endpoint.
     *
     * @return void
     */
    public function test_login()
    {
        // Resto del contenido de la prueba...
    }
}
