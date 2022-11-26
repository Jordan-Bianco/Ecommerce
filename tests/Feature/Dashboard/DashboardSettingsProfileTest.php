<?php

namespace Tests\Feature\Dashboard;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class DashboardSettingsProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_render_settings_profile_component(): void
    {
        $user = User::factory()->create(['name' => 'test']);
        $this->actingAs($user);

        $response = $this->get('/dashboard/settings/profile');

        $response
            ->assertInertia(function (AssertableInertia $page) {
                $page
                    ->component('Dashboard/Settings/Profile');
            });
    }

    public function test_user_can_update_his_name(): void
    {
        $user = User::factory()->create(['name' => 'test']);
        $this->actingAs($user);

        $this->patch('/dashboard/settings/profile', [
            'name' => 'updated'
        ]);

        $this->assertEquals('updated', $user->fresh()->name);
    }
}
