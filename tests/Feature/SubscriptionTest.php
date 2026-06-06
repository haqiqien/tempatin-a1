<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_activate_premium_sets_premium_ends_at_plus_1_month(): void
    {
        $this->travelTo(now()->startOfSecond());
        $user = User::factory()->create(['premium_ends_at' => null]);

        $response = $this->actingAs($user)->post(route('subscriptions.activate'));

        $response->assertRedirect(route('subscriptions.index'));
        $this->assertTrue($user->fresh()->premium_ends_at->equalTo(now()->addMonth()));
    }

    public function test_extending_premium_adds_1_month_from_current_premium_ends_at(): void
    {
        $this->travelTo(now()->startOfSecond());
        $currentEnd = now()->addDays(10);
        $user = User::factory()->create(['premium_ends_at' => $currentEnd]);

        $this->actingAs($user)->post(route('subscriptions.activate'))->assertRedirect(route('subscriptions.index'));

        $this->assertTrue($user->fresh()->premium_ends_at->equalTo($currentEnd->copy()->addMonth()));
    }

    public function test_user_can_cancel_premium_sets_premium_ends_at_to_null(): void
    {
        $user = User::factory()->create(['premium_ends_at' => now()->addMonth()]);

        $this->actingAs($user)->delete(route('subscriptions.cancel'))->assertRedirect(route('subscriptions.index'));

        $this->assertNull($user->fresh()->premium_ends_at);
    }

    public function test_is_premium_returns_true_when_premium_ends_at_is_future(): void
    {
        $user = User::factory()->create(['premium_ends_at' => now()->addDay()]);

        $this->assertTrue($user->isPremium());
    }

    public function test_is_premium_returns_false_when_premium_ends_at_is_past_or_null(): void
    {
        $pastUser = User::factory()->create(['premium_ends_at' => now()->subDay()]);
        $nullUser = User::factory()->create(['premium_ends_at' => null]);

        $this->assertFalse($pastUser->isPremium());
        $this->assertFalse($nullUser->isPremium());
    }
}
