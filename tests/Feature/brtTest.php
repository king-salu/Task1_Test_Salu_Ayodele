<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Brt;

class brtTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function retrieves_brts()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);
        $response = $this->withHeader('Authorization', "Bearer $token")->getJson("/api/brts");

        $response->assertStatus(200);
    }

    /** @test */
    public function can_create_brt()
    {
        $user = User::factory()->create();

        $token = auth()->login($user);
        $ibrt = [
            'user_id' => $user->id,
            'reserved_amount' => 1000,
            'status' => 'active'
        ];
        $response = $this->withHeader('Authorization', "Bearer $token")->postJson('/api/brts', $ibrt);

        $response->assertStatus(201);
        $this->assertDatabaseHas('brt', $ibrt);
    }

    /** @test */
    public function can_update_brt()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);

        $brt = Brt::factory()->create(['user_id' => $user->id]);
        $ibrt = [
            'reserved_amount' => 13400,
            'status' => 'active'
        ];
        $response = $this->withHeader('Authorization', "Bearer $token")->putJson("/api/brts/{$brt->id}", $ibrt);

        $response->assertStatus(200);
        $this->assertDatabaseHas('brt', $ibrt);
    }

    /** @test */
    public function can_get_a_brt()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);

        $brt = Brt::factory()->create(['user_id' => $user->id]);
        $response = $this->withHeader('Authorization', "Bearer $token")->getJson("/api/brts/{$brt->id}");

        $response->assertStatus(200);
        $response->assertJson(['id' => $brt->id, 'user_id' => $user->id]);
    }

    /** @test */
    public function can_delete_brt()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);

        $brt = Brt::factory()->create(['user_id' => $user->id]);
        $brt = Brt::factory()->create(['user_id' => $user->id]);
        $response = $this->withHeader('Authorization', "Bearer $token")->deleteJson("/api/brts/{$brt->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('brt', ['id' => $brt->id]);
    }
}
