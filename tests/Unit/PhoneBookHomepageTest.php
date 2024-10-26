<?php

namespace Tests\Unit;

use App\Models\PhoneEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhoneBookHomepageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_phonebook_homepage_successful_response(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/');

        $response->assertOk();
    }
}
