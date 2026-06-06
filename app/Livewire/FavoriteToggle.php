<?php

namespace App\Livewire;

use App\Models\Favorite;
use Livewire\Component;

class FavoriteToggle extends Component
{
    public int $placeId;

    public bool $isFavorite = false;

    public function mount(): void
    {
        if (auth()->check()) {
            $this->isFavorite = Favorite::where('user_id', auth()->id())
                ->where('place_id', $this->placeId)
                ->exists();
        }
    }

    public function toggle(): void
    {
        if (! auth()->check()) {
            $this->redirect(route('login'), navigate: true);

            return;
        }

        $existing = Favorite::where('user_id', auth()->id())
            ->where('place_id', $this->placeId)
            ->first();

        if ($existing) {
            $existing->delete();
            $this->isFavorite = false;
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                'place_id' => $this->placeId,
                'created_at' => now(),
            ]);
            $this->isFavorite = true;
        }
    }

    public function render()
    {
        return view('livewire.favorite-toggle');
    }
}
