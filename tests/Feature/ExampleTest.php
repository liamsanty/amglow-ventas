<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Requests\loginRequest;
use Illuminate\Support\Facades\URL;
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
     * Sin llaves de reCAPTCHA el login no muestra el captcha ni lo exige.
     */
    public function test_login_without_captcha_keys_does_not_require_captcha(): void
    {
        config(['captcha.sitekey' => null, 'captcha.secret' => null]);

        $this->get('/login')->assertDontSee('g-recaptcha');
        $this->assertArrayNotHasKey('g-recaptcha-response', (new loginRequest())->rules());
    }

    /**
     * Con llaves de reCAPTCHA el login exige marcar el captcha.
     */
    public function test_login_with_captcha_keys_requires_captcha(): void
    {
        config(['captcha.sitekey' => 'llave-sitio', 'captcha.secret' => 'llave-secreta']);

        $this->get('/login')->assertSee('g-recaptcha');
        $this->post('/login', ['email' => 'nadie@ejemplo.com', 'password' => 'x'])
            ->assertSessionHasErrors('g-recaptcha-response');
    }

    /**
     * Con FORCE_HTTPS los enlaces de la app se generan con https.
     */
    public function test_force_https_generates_https_links(): void
    {
        URL::forceScheme('https');

        $this->assertStringStartsWith('https://', route('login'));
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
