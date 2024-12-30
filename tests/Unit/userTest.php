<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class userTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function can_create_user()
    {
        $user = User::factory()->create([
            'name' => 'Tester One',
            'email' => 'testerone@gmail.com',
            'password' => 'test1234'
        ]);

        $this->assertDatabaseHas(
            'users',
            ['email' => 'testerone@gmail.com']
        );
    }
}
