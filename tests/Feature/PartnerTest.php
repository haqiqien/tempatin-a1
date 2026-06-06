<?php

namespace Tests\Feature;

use App\Livewire\Partner\PlaceForm;
use App\Models\Partner;
use App\Models\Place;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PartnerTest extends TestCase
{
    use RefreshDatabase;

    public function test_partner_can_access_partner_dashboard(): void
    {
        $partner = Partner::factory()->create();

        $this->actingAs($partner->user)->get(route('partner.dashboard'))->assertOk();
    }

    public function test_non_partner_gets_403_on_partner_routes(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('partner.dashboard'))->assertForbidden();
    }

    public function test_partner_can_create_a_place_status_defaults_to_pending_review(): void
    {
        $partner = Partner::factory()->create();

        Livewire::actingAs($partner->user)
            ->test(PlaceForm::class)
            ->set('placeName', 'Tempat Kerja Nyaman')
            ->set('category', 'cafe')
            ->set('address', 'Jl. Produktif No. 1')
            ->set('city', 'Jakarta')
            ->set('latitude', '-6.20000000')
            ->set('longitude', '106.81666600')
            ->set('priceRange', '15000-50000')
            ->set('description', 'Nyaman untuk kerja dan rapat kecil.')
            ->set('noiseLevel', 'sedang')
            ->call('save')
            ->assertRedirect(route('partner.dashboard'));

        $this->assertDatabaseHas('places', [
            'partner_id' => $partner->partner_id,
            'place_name' => 'Tempat Kerja Nyaman',
            'status' => 'pending_review',
        ]);
    }

    public function test_partner_can_only_edit_their_own_place_403_for_other_partners_place(): void
    {
        $partner = Partner::factory()->create();
        $otherPartner = Partner::factory()->create();
        $ownPlace = Place::factory()->create(['partner_id' => $partner->partner_id]);
        $otherPlace = Place::factory()->create(['partner_id' => $otherPartner->partner_id]);

        $this->actingAs($partner->user)->get(route('partner.place.edit', $ownPlace))->assertOk();
        $this->actingAs($partner->user)->get(route('partner.place.edit', $otherPlace))->assertForbidden();
    }
}
