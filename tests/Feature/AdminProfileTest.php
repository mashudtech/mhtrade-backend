<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class AdminProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['app.url' => 'http://localhost']);
        URL::forceRootUrl('http://localhost');
    }

    public function test_guest_cannot_access_profile_or_password_pages(): void
    {
        $this->get(route('admin.profile'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.password'))->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_profile_page(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $response = $this->actingAs($user)->get(route('admin.profile'));

        $response->assertOk()
            ->assertSee('Admin Profile')
            ->assertSee('John Doe')
            ->assertSee('john@example.com');
    }

    public function test_admin_can_update_profile_name_and_email(): void
    {
        $user = User::factory()->create([
            'name' => 'Initial Name',
            'email' => 'initial@example.com',
        ]);

        $response = $this->actingAs($user)->put(route('admin.profile.update'), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        $response->assertRedirect(route('admin.profile'))
            ->assertSessionHas('success', 'Profile details updated successfully.');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }

    public function test_admin_cannot_update_profile_with_existing_other_email(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);
        $user = User::factory()->create(['email' => 'user@example.com']);

        $response = $this->actingAs($user)->put(route('admin.profile.update'), [
            'name' => 'User Name',
            'email' => 'taken@example.com',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertEquals('user@example.com', $user->fresh()->email);
    }

    public function test_admin_can_view_change_password_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.password'));

        $response->assertOk()
            ->assertSee('Change Password')
            ->assertSee('Update Security Password');
    }

    public function test_admin_can_change_password_with_valid_current_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password-123'),
        ]);

        $response = $this->actingAs($user)->put(route('admin.password.update'), [
            'current_password' => 'old-password-123',
            'password' => 'new-secret-password',
            'password_confirmation' => 'new-secret-password',
        ]);

        $response->assertRedirect(route('admin.password'))
            ->assertSessionHas('success', 'Password updated successfully.');

        $this->assertTrue(Hash::check('new-secret-password', $user->fresh()->password));
    }

    public function test_admin_cannot_change_password_with_incorrect_current_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('real-password-123'),
        ]);

        $response = $this->actingAs($user)->put(route('admin.password.update'), [
            'current_password' => 'wrong-password',
            'password' => 'new-secret-password',
            'password_confirmation' => 'new-secret-password',
        ]);

        $response->assertSessionHasErrors(['current_password']);
        $this->assertTrue(Hash::check('real-password-123', $user->fresh()->password));
    }

    public function test_admin_cannot_change_password_with_unconfirmed_new_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('real-password-123'),
        ]);

        $response = $this->actingAs($user)->put(route('admin.password.update'), [
            'current_password' => 'real-password-123',
            'password' => 'new-secret-password',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertSessionHasErrors(['password']);
    }
}
