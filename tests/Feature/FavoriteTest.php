<?php

namespace Tests\Feature;

use App\Livewire\FavoriteToggle;
use App\Models\Favorite;
use App\Models\Place;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_toggle_favorite_add(): void
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();

        Livewire::actingAs($user)
            ->test(FavoriteToggle::class, ['placeId' => $place->place_id])
            ->call('toggle')
            ->assertSet('isFavorite', true);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->user_id,
            'place_id' => $place->place_id,
        ]);
    }

    public function test_authenticated_user_can_toggle_favorite_remove(): void
    {
        $user = User::factory()->create();
        $place = Place::factory()->create();
        Favorite::create([
            'user_id' => $user->user_id,
            'place_id' => $place->place_id,
            'created_at' => now(),
        ]);

        Livewire::actingAs($user)
            ->test(FavoriteToggle::class, ['placeId' => $place->place_id])
            ->call('toggle')
            ->assertSet('isFavorite', false);

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->user_id,
            'place_id' => $place->place_id,
        ]);
    }

    public function test_guest_is_redirected_to_login_when_toggling(): void
    {
        $place = Place::factory()->create();

        Livewire::test(FavoriteToggle::class, ['placeId' => $place->place_id])
            ->call('toggle')
            ->assertRedirect(route('login'));
    }
}
