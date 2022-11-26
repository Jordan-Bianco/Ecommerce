<?php

namespace Tests\Feature\Dashboard;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class DashboardSettingsPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_render_settings_password_component(): void
    {
        $user = User::factory()->create(['name' => 'test']);
        $this->actingAs($user);

        $response = $this->get('/dashboard/settings/password');

        $response
            ->assertInertia(function (AssertableInertia $page) {
                $page
                    ->component('Dashboard/Settings/Password');
            });
    }

    public function test_user_can_update_his_password(): void
    {
        $user = User::factory()->create(['name' => 'test']);
        $this->actingAs($user);

        $this->assertTrue(Hash::check('password', $user->password));

        $this->patch('/dashboard/settings/password', [
            'current_password' => 'password',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword'
        ]);

        $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));
    }

    public function test_error_if_current_password_dont_match(): void
    {
        $user = User::factory()->create(['name' => 'test']);
        $this->actingAs($user);

        $this->assertTrue(Hash::check('password', $user->password));

        $this->patch('/dashboard/settings/password', [
            'current_password' => 'wrongpassword',
            'password' => 'test',
            'password_confirmation' => 'test'
        ])
            ->assertSessionHasErrorsIn('current_password');
    }

    public function test_error_if_new_passwords_must_be_the_same(): void
    {
        $user = User::factory()->create(['name' => 'test']);
        $this->actingAs($user);

        $this->assertTrue(Hash::check('password', $user->password));

        $this->patch('/dashboard/settings/password', [
            'current_password' => 'password',
            'password' => 'newpassword',
            'password_confirmation' => 'wrongpassword'
        ])
            ->assertSessionHasErrorsIn('password');
    }
}
