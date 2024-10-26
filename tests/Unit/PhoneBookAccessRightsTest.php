<?php

namespace Tests\Unit;

use App\Models\PhoneEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhoneBookAccessRightsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_user_can_update_phone_entry(): void
    {
        $user = User::factory()->create();

        $phone_entry = PhoneEntry::factory()->create([
            'phone' => '+37064323577'
        ]);

        $user->phoneEntries()->attach($phone_entry, ['main' => 1]);

        $this->actingAs($user)->assertTrue($phone_entry->canUpdate());
    }

    public function test_user_can_not_update_phone_entry(): void
    {
        $user = User::factory()->create();

        $phone_entry = PhoneEntry::factory()->create([
            'phone' => '+37064323577'
        ]);

        $user->phoneEntries()->attach($phone_entry);

        $this->actingAs($user)->assertFalse($phone_entry->canUpdate());
    }

    public function test_user_have_access_to_phone_entry(): void
    {
        $user = User::factory()->create();

        $phone_entry = PhoneEntry::factory()->create([
            'phone' => '+37064323577'
        ]);

        $user->phoneEntries()->attach($phone_entry);

        $this->actingAs($user)->assertTrue($phone_entry->haveAccess());
    }

    public function test_user_have_does_not_have_access_to_phone_entry(): void
    {
        $user = User::factory()->create();
        $user_2 = User::factory()->create();

        $phone_entry = PhoneEntry::factory()->create([
            'phone' => '+37064323577'
        ]);

        $user->phoneEntries()->attach($phone_entry, ['main' => 1]);

        $this->actingAs($user_2)->assertFalse($phone_entry->haveAccess());
    }
}
