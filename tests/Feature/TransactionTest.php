<?php

// tests/Feature/TransactionTest.php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_deposit_is_correctly_added_to_balance()
    {
        $user = User::factory()->create(['balance' => 0]);

        $response = $this->actingAs($user)->post('/deposit', [
            'amount' => 1000
        ]);

        $response->assertSessionHas('success', 'Deposit successful.');
        $this->assertEquals(1000, $user->fresh()->balance);
    }

    public function test_withdrawal_is_correctly_deducted_and_fees_applied()
    {
        $user = User::factory()->create(['balance' => 5000]);

        $response = $this->actingAs($user)->post('/withdraw', [
            'amount' => 1500
        ]);

        $response->assertSessionHas('success', 'Withdrawal successful.');
        $this->assertEquals(5000 - 1500 - (1500 * 0.02), $user->fresh()->balance);
    }

    public function test_validation_for_insufficient_balance()
    {
        $user = User::factory()->create(['balance' => 100]);

        $response = $this->actingAs($user)->post('/withdraw', [
            'amount' => 200
        ]);

        $response->assertSessionHasErrors(['amount']);
        $this->assertEquals(100, $user->fresh()->balance);
    }
}
