<?php

namespace Tests\Feature;

use App\Http\Middleware\StartAdminSession;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Mechanisms\PersistentMiddleware\PersistentMiddleware;
use Tests\TestCase;

class PublicAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_and_registration_forms_are_available_to_guests()
    {
        $this->get('/login')->assertOk()->assertSee('Masuk');
        $this->get('/register')
            ->assertOk()
            ->assertSee('Buat akun')
            ->assertDontSee('password_confirmation')
            ->assertDontSee('Ulangi kata sandi');
    }

    public function test_a_guest_can_register_as_a_customer_with_a_hashed_password()
    {
        $response = $this->post('/register', [
            'name' => 'Pelanggan Baru',
            'email' => 'pelanggan@example.com',
            'password' => 'rahasia123',
            'role' => 'admin',
        ]);

        $user = User::where('email', 'pelanggan@example.com')->firstOrFail();

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
        $this->assertSame('customer', $user->role);
        $this->assertTrue(Hash::check('rahasia123', $user->password));
        $this->assertNotSame('rahasia123', $user->password);
    }

    public function test_registration_validates_required_and_unique_input()
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $this->from('/register')->post('/register', [
            'name' => '',
            'email' => 'existing@example.com',
            'password' => 'short',
        ])->assertRedirect('/register')
            ->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function test_a_user_can_log_in_and_the_session_is_regenerated()
    {
        $user = User::factory()->create([
            'email' => 'customer@example.com',
            'password' => Hash::make('rahasia123'),
            'role' => 'customer',
        ]);
        $sessionId = session()->getId();

        $response = $this->post('/login', [
            'email' => 'customer@example.com',
            'password' => 'rahasia123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
        $this->assertNotSame($sessionId, session()->getId());
    }

    public function test_invalid_login_is_rejected()
    {
        User::factory()->create([
            'email' => 'customer@example.com',
            'password' => Hash::make('rahasia123'),
        ]);

        $this->from('/login')->post('/login', [
            'email' => 'customer@example.com',
            'password' => 'salah1234',
        ])->assertRedirect('/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_a_user_can_log_out()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/logout')->assertRedirect(route('home'));

        $this->assertGuest();
    }

    public function test_customer_dashboard_has_been_removed_and_authenticated_name_is_shown_in_the_navbar()
    {
        $this->get('/dashboard')->assertNotFound();

        $this->actingAs(User::factory()->create(['name' => 'Pelanggan Uji']))
            ->get(route('home'))
            ->assertOk()
            ->assertSee('Halo, Pelanggan Uji')
            ->assertDontSee('DASHBOARD PELANGGAN')
            ->assertDontSee('Dashboard</a>');
    }

    public function test_the_login_link_is_styled_as_a_distinct_navbar_button()
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('class="button nav-login nav-cta"', false);
    }

    public function test_public_header_uses_the_cropped_dark_mode_logo()
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('images/admin-logo-dark.png')
            ->assertDontSee('images/dkmode.png');
    }

    public function test_customer_login_does_not_authenticate_the_admin_guard()
    {
        $customer = User::factory()->create([
            'email' => 'customer@example.com',
            'password' => 'rahasia123',
        ]);

        $this->post('/login', [
            'email' => $customer->email,
            'password' => 'rahasia123',
        ])->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($customer, 'web');
        $this->assertGuest('admin');
        $this->get('/admin')->assertRedirect(route('filament.admin.auth.login'));
    }

    public function test_admin_and_customer_sessions_are_independent_and_log_out_separately()
    {
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => 'admin-password',
            'role' => 'admin',
        ]);
        $customer = User::factory()->create([
            'name' => 'Pelanggan',
            'email' => 'customer@example.com',
            'password' => 'customer-password',
        ]);

        $this->assertTrue(Auth::guard('admin')->attempt([
            'email' => 'admin@example.com',
            'password' => 'admin-password',
        ]));
        $this->assertAuthenticatedAs($admin, 'admin');
        $this->assertGuest('web');

        $this->post('/login', [
            'email' => 'customer@example.com',
            'password' => 'customer-password',
        ])->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($admin, 'admin');
        $this->assertAuthenticatedAs($customer, 'web');

        $this->post('/logout')->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($admin, 'admin');
        $this->assertGuest('web');
    }

    public function test_a_customer_cannot_access_the_admin_panel()
    {
        $customer = User::factory()->create([
            'email' => 'customer@example.com',
            'password' => 'customer-password',
        ]);

        Auth::guard('admin')->login($customer);

        $this->get('/admin')->assertForbidden();
    }

    public function test_make_filament_user_creates_an_admin_who_can_access_the_panel()
    {
        $this->artisan('make:filament-user', [
            '--name' => 'Administrator',
            '--email' => 'admin@example.com',
            '--password' => 'admin-password',
            '--panel' => 'admin',
        ])->assertExitCode(0);

        $admin = User::where('email', 'admin@example.com')->firstOrFail();

        $this->assertSame('admin', $admin->role);
        Auth::guard('admin')->login($admin);

        $this->get('/admin')->assertOk();
    }

    public function test_admin_panel_renders_matching_light_and_dark_mode_logos()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Auth::guard('admin')->login($admin);

        $this->get('/admin')
            ->assertOk()
            ->assertSee('images/admin-logo.png')
            ->assertSee('images/admin-logo-dark.png')
            ->assertSee('fi-logo-dark', false)
            ->assertSee('height: 3rem', false);
    }

    public function test_an_admin_can_access_public_website_pages()
    {
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => 'admin-password',
            'role' => 'admin',
        ]);

        Auth::guard('admin')->login($admin);

        $this->get(route('home'))->assertOk();
        $this->get(route('profile'))->assertOk();
    }

    public function test_an_admin_cannot_log_in_through_the_public_user_form()
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => 'admin-password',
            'role' => 'admin',
        ]);

        $this->from('/login')->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'admin-password',
        ])->assertRedirect('/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest('web');
    }

    public function test_customer_session_survives_visiting_the_admin_login()
    {
        $customer = User::factory()->create();

        $this->get(route('filament.admin.auth.login'))
            ->assertOk()
            ->assertCookie('laravel_session');

        $loginResponse = $this->post('/login', [
            'email' => $customer->email,
            'password' => 'password',
        ])->assertRedirect(route('home'))
            ->assertCookie('laravel_session');
        $webSessionId = $loginResponse->getCookie('laravel_session')->getValue();

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Halo, '.$customer->name);

        $this->get('/admin')
            ->assertRedirect(route('filament.admin.auth.login'))
            ->assertCookie('laravel_session');

        $this->withCookie('laravel_session', $webSessionId)
            ->get(route('home'))
            ->assertOk()
            ->assertSee('Halo, '.$customer->name);
    }

    public function test_admin_panel_request_does_not_change_the_customer_default_guard()
    {
        config(['session.driver' => 'database']);
        app('session')->forgetDrivers();
        app()->forgetInstance('session.store');

        $customer = User::factory()->create();
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => 'admin-password',
            'role' => 'admin',
        ]);

        $loginResponse = $this->post('/login', [
            'email' => $customer->email,
            'password' => 'password',
        ])->assertRedirect(route('home'));
        $webSessionId = $loginResponse->getCookie('laravel_session')->getValue();

        Auth::guard('admin')->login($admin);
        session()->save();

        $this->withCookie('laravel_session', $webSessionId)
            ->get('/admin')
            ->assertOk();

        $this->assertSame('web', config('auth.defaults.guard'));

        $this->withCookie('laravel_session', $webSessionId)
            ->get(route('home'))
            ->assertOk()
            ->assertSee('Halo, '.$customer->name);
    }

    public function test_admin_and_public_pages_use_the_same_session_cookie()
    {
        $this->get(route('filament.admin.auth.login'))
            ->assertOk()
            ->assertCookie('laravel_session');

        $this->get(route('login'))
            ->assertOk()
            ->assertCookie('laravel_session');

        $this->assertContains(
            StartAdminSession::class,
            app(PersistentMiddleware::class)->getPersistentMiddleware(),
        );
    }

    public function test_admin_logout_preserves_the_customer_session()
    {
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => 'admin-password',
            'role' => 'admin',
        ]);
        $customer = User::factory()->create();

        $this->actingAs($customer, 'web');
        Auth::guard('admin')->login($admin);

        $this->post(route('filament.admin.auth.logout'))
            ->assertRedirect(route('filament.admin.auth.login'));

        $this->assertGuest('admin');
        $this->assertAuthenticatedAs($customer, 'web');
    }
}
