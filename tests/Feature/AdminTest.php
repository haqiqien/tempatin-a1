<?php

namespace Tests\Feature;

use App\Livewire\Admin\PlaceModeration;
use App\Livewire\Admin\ReviewModeration;
use App\Models\Place;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
    }

    public function test_non_admin_gets_403_on_admin_routes(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_admin_can_approve_a_pending_place(): void
    {
        $admin = User::factory()->admin()->create();
        $place = Place::factory()->pendingReview()->create();

        Livewire::actingAs($admin)
            ->test(PlaceModeration::class)
            ->call('approve', $place->place_id);

        $this->assertDatabaseHas('places', [
            'place_id' => $place->place_id,
            'status' => 'active',
        ]);
    }

    public function test_admin_can_reject_a_place(): void
    {
        $admin = User::factory()->admin()->create();
        $place = Place::factory()->pendingReview()->create();

        Livewire::actingAs($admin)
            ->test(PlaceModeration::class)
            ->call('reject', $place->place_id);

        $this->assertDatabaseHas('places', [
            'place_id' => $place->place_id,
            'status' => 'inactive',
        ]);
    }

    public function test_admin_can_approve_a_review(): void
    {
        $admin = User::factory()->admin()->create();
        $review = Review::factory()->create(['is_verified' => false]);

        Livewire::actingAs($admin)
            ->test(ReviewModeration::class)
            ->call('approve', $review->review_id);

        $this->assertDatabaseHas('reviews', [
            'review_id' => $review->review_id,
            'is_verified' => true,
        ]);
    }

    public function test_admin_can_delete_a_review(): void
    {
        $admin = User::factory()->admin()->create();
        $review = Review::factory()->create();

        Livewire::actingAs($admin)
            ->test(ReviewModeration::class)
            ->call('reject', $review->review_id);

        $this->assertDatabaseMissing('reviews', [
            'review_id' => $review->review_id,
        ]);
    }
}
