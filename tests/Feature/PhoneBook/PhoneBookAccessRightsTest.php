<?php

namespace Tests\Feature\PhoneBook;

use App\Models\PhoneEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhoneBookAccessRightsTest extends TestCase
{
    use RefreshDatabase;

    public function test_phonebook_homepage_phonebook_is_displayed(): void
    {
        $user = User::factory()->create();

        $phone_entry = PhoneEntry::factory()->create([
            'phone' => '+37064323577'
        ]);

        $user->phoneEntries()->attach($phone_entry);

        $response = $this
            ->actingAs($user)
            ->get('/');

        $response->assertSee('37064323577');
    }

    public function test_phonebook_homepage_phonebook_private_number(): void
    {
        $user_1 = User::factory()->create();

        $user_2 = User::factory()->create();

        $phone_entry_1 = PhoneEntry::factory()->create([
            'phone' => '+37064323577'
        ]);

        $phone_entry_2 = PhoneEntry::factory()->create([
            'phone' => '+37064323578'
        ]);

        $user_1->phoneEntries()->attach($phone_entry_1, ['main' => 1]);

        $user_2->phoneEntries()->attach($phone_entry_2, ['main' => 1]);

        $response = $this
            ->actingAs($user_1)
            ->get('/');

        $response->assertDontSee('+37064323578');
    }

    public function test_phonebook_homepage_phonebook_can_see_shared_phonebook(): void
    {
        $user_1 = User::factory()->create();
        $user_2 = User::factory()->create();

        $phone_entry_1 = PhoneEntry::factory()->create([
            'phone' => '+37064323577'
        ]);

        $user_1->phoneEntries()->attach($phone_entry_1, ['main' => 1]);

        $user_2->phoneEntries()->attach($phone_entry_1);

        $response = $this
            ->actingAs($user_2)
            ->get('/');

        $response->assertSee('+37064323577');
    }

    public function test_phonebook_homepage_phonebook_main_can_see_edit(): void
    {
        $user = User::factory()->create();

        $phone_entry = PhoneEntry::factory()->create([
            'phone' => '+37064323577'
        ]);

        $user->phoneEntries()->attach($phone_entry, ['main' => 1]);

        $response = $this
            ->actingAs($user)
            ->get('/');

        $response->assertSee('Edit');
    }

    public function test_phonebook_homepage_phonebook_shared_can_not_see_edit(): void
    {
        $user_1 = User::factory()->create();
        $user_2 = User::factory()->create();

        $phone_entry = PhoneEntry::factory()->create([
            'phone' => '+37064323577'
        ]);

        $user_1->phoneEntries()->attach($phone_entry, ['main' => 1]);
        $user_2->phoneEntries()->attach($phone_entry);

        $response = $this
            ->actingAs($user_2)
            ->get('/');

        $response->assertDontSee('Edit');
    }

    public function test_phonebook_homepage_phonebook_main_user_can_edit(): void
    {
        $user = User::factory()->create();

        $phone_entry = PhoneEntry::factory()->create([
            'phone' => '+37064323577'
        ]);

        $user->phoneEntries()->attach($phone_entry, ['main' => 1]);

        $this
            ->actingAs($user)
            ->put(route('phonebook.update', $phone_entry->id), [
                'name'  => $phone_entry->name,
                'phone' => '+37064323555'
            ]);

        $this->assertTrue($phone_entry->fresh()->phone === '+37064323555');
    }

    public function test_phonebook_homepage_phonebook_shared_user_can_not_edit(): void
    {
        $user_1 = User::factory()->create();
        $user_2 = User::factory()->create();

        $phone_entry = PhoneEntry::factory()->create([
            'phone' => '+37064323577'
        ]);

        $user_1->phoneEntries()->attach($phone_entry, ['main' => 1]);
        $user_2->phoneEntries()->attach($phone_entry);

        $this
            ->actingAs($user_2)
            ->put(route('phonebook.update', $phone_entry->id), [
                'name'  => $phone_entry->name,
                'phone' => '+37064323555'
            ]);

        $this->assertFalse($phone_entry->fresh()->phone === '+37064323555');
    }
}
