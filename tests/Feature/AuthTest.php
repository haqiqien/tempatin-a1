<?php

namespace Tests\Feature;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_as_user_role(): void
    {
        $response = $this->post('/daftar', [
            'full_name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'user',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'budi@example.com',
            'role' => 'user',
            'status' => 'active',
        ]);
    }

    public function test_user_can_register_as_partner_role(): void
    {
        $response = $this->post('/daftar', [
            'full_name' => 'Mitra Tempatin',
            'email' => 'mitra@example.com',
            'phone' => '081234567891',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'partner',
        ]);

        $response->assertRedirect(route('home'));
        $user = User::where('email', 'mitra@example.com')->firstOrFail();

        $this->assertAuthenticatedAs($user);
        $this->assertDatabaseHas('partners', [
            'user_id' => $user->user_id,
            'business_name' => 'Mitra Tempatin',
            'contact_name' => 'Mitra Tempatin',
            'status' => 'active',
        ]);
    }

    public function test_user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('secret-password'),
        ]);

        $response = $this->post('/masuk', [
            'email' => 'user@example.com',
            'password' => 'secret-password',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_wrong_credentials(): void
    {
        User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('secret-password'),
        ]);

        $response = $this->from('/masuk')->post('/masuk', [
            'email' => 'user@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect('/masuk');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_admin_is_redirected_to_admin_dashboard_after_login(): void
    {
        User::factory()->admin()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/masuk', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_partner_is_redirected_to_partner_dashboard_after_login(): void
    {
        $partner = Partner::factory()->create([
            'user_id' => User::factory()->partner()->create([
                'email' => 'partner@example.com',
                'password' => Hash::make('password'),
            ])->user_id,
        ]);

        $response = $this->post('/masuk', [
            'email' => $partner->user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('partner.dashboard'));
    }

    public function test_user_is_redirected_to_home_after_login(): void
    {
        User::factory()->create([
            'email' => 'regular@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/masuk', [
            'email' => 'regular@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('home'));
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
