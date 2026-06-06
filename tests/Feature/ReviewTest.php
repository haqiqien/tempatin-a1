<?php

namespace Tests\Feature;

use App\Livewire\ReviewForm;
use App\Models\Place;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_submit_a_review(): void
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();

        Livewire::actingAs($user)
            ->test(ReviewForm::class, ['placeId' => $place->place_id])
            ->set('ratingWifi', 4)
            ->set('ratingComfort', 5)
            ->set('ratingSocket', 3)
            ->set('ratingOverall', 5)
            ->set('comment', 'Tempatnya nyaman untuk kerja.')
            ->call('submit')
            ->assertSet('submitted', true);

        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->user_id,
            'place_id' => $place->place_id,
            'rating_overall' => 5,
            'comment' => 'Tempatnya nyaman untuk kerja.',
        ]);
    }

    public function test_guest_cannot_submit_a_review(): void
    {
        $place = Place::factory()->create();

        Livewire::test(ReviewForm::class, ['placeId' => $place->place_id])
            ->set('ratingWifi', 4)
            ->set('ratingComfort', 5)
            ->set('ratingSocket', 3)
            ->set('ratingOverall', 5)
            ->call('submit')
            ->assertSet('submitted', false);

        $this->assertDatabaseMissing('reviews', [
            'place_id' => $place->place_id,
            'rating_overall' => 5,
        ]);
    }

    public function test_user_cannot_submit_duplicate_review_for_same_place(): void
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();
        Review::factory()->create([
            'user_id' => $user->user_id,
            'place_id' => $place->place_id,
        ]);

        Livewire::actingAs($user)
            ->test(ReviewForm::class, ['placeId' => $place->place_id])
            ->set('ratingWifi', 4)
            ->set('ratingComfort', 4)
            ->set('ratingSocket', 4)
            ->set('ratingOverall', 4)
            ->call('submit')
            ->assertHasErrors('general');

        $this->assertSame(1, Review::where('user_id', $user->user_id)->where('place_id', $place->place_id)->count());
    }

    public function test_review_is_created_with_is_verified_false_by_default(): void
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();

        Livewire::actingAs($user)
            ->test(ReviewForm::class, ['placeId' => $place->place_id])
            ->set('ratingWifi', 3)
            ->set('ratingComfort', 3)
            ->set('ratingSocket', 3)
            ->set('ratingOverall', 3)
            ->call('submit');

        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->user_id,
            'place_id' => $place->place_id,
            'is_verified' => false,
        ]);
    }

    public function test_review_requires_rating_overall_min_1(): void
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();

        Livewire::actingAs($user)
            ->test(ReviewForm::class, ['placeId' => $place->place_id])
            ->set('ratingWifi', 3)
            ->set('ratingComfort', 3)
            ->set('ratingSocket', 3)
            ->set('ratingOverall', 0)
            ->call('submit')
            ->assertHasErrors(['ratingOverall' => 'min']);

        $this->assertDatabaseMissing('reviews', [
            'user_id' => $user->user_id,
            'place_id' => $place->place_id,
        ]);
    }
}
