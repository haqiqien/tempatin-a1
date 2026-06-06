<?php

namespace Tests\Feature;

use App\Models\Place;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_active_places_index(): void
    {
        $activePlace = Place::factory()->create(['place_name' => 'Ruang Fokus']);
        Place::factory()->inactive()->create(['place_name' => 'Ruang Tutup']);

        $response = $this->get(route('places.index'));

        $response->assertOk();
        $response->assertSee($activePlace->place_name);
        $response->assertDontSee('Ruang Tutup');
    }

    public function test_guest_can_view_active_place_detail(): void
    {
        $place = Place::factory()->create(['place_name' => 'Kopi Produktif']);

        $response = $this->get(route('places.show', $place));

        $response->assertOk();
        $response->assertSee($place->place_name);
    }

    public function test_guest_cannot_view_inactive_or_pending_place(): void
    {
        $inactive = Place::factory()->inactive()->create();
        $pending = Place::factory()->pendingReview()->create();

        $this->get(route('places.show', $inactive))->assertNotFound();
        $this->get(route('places.show', $pending))->assertNotFound();
    }

    public function test_viewing_a_place_creates_activity_log_with_view_profile_action_type(): void
    {
        $place = Place::factory()->create();

        $this->get(route('places.show', $place))->assertOk();

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => null,
            'place_id' => $place->place_id,
            'action_type' => 'view_profile',
        ]);
    }

    public function test_authenticated_user_can_log_click_route_action(): void
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();

        $response = $this->actingAs($user)->postJson(route('places.log', $place), [
            'action_type' => 'click_route',
        ]);

        $response->assertOk()->assertJson(['ok' => true]);
        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $user->user_id,
            'place_id' => $place->place_id,
            'action_type' => 'click_route',
        ]);
    }

    public function test_guest_cannot_log_actions_should_still_work_with_nullable_user_id(): void
    {
        $place = Place::factory()->create();

        $response = $this->postJson(route('places.log', $place), [
            'action_type' => 'click_route',
        ]);

        $response->assertOk()->assertJson(['ok' => true]);
        $this->assertDatabaseHas('activity_logs', [
            'user_id' => null,
            'place_id' => $place->place_id,
            'action_type' => 'click_route',
        ]);
    }
}
