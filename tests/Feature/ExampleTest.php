<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * La pantalla de login carga sin sesión.
     */
    public function test_login_page_loads(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * Las pantallas del sistema mandan al login si no hay sesión.
     */
    public function test_protected_pages_redirect_guests_to_login(): void
    {
        foreach (['/', '/productos', '/ventas', '/compras', '/users', '/roles', '/forgot/password'] as $url) {
            $this->get($url)->assertRedirect('/login');
        }
    }
}
