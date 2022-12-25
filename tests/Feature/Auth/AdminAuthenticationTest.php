<?php

namespace Tests\Feature\Auth;

use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('admin/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = Admin::factory()->create();

        $response = $this->post('admin/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertRedirect('admin/dashboard');
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = Admin::factory()->create();

        $this->post('admin/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
