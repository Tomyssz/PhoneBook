<?php

namespace Database\Seeders;

use App\Models\PhoneEntry;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user1 = User::factory()->create([
            'email' => 'test@test.com'
        ]);

        $user2 = User::factory()->create([
            'email' => 'test2@test.com'
        ]);

        $phonebook_entries_1 = PhoneEntry::factory(5)->create();
        $phonebook_entries_2 = PhoneEntry::factory(5)->create();

        $user1->phoneEntries()->attach($phonebook_entries_1, ['main' => 1]);
        $user1->phoneEntries()->attach($phonebook_entries_2);
        $user2->phoneEntries()->attach($phonebook_entries_2, ['main' => 1]);
        $user2->phoneEntries()->attach($phonebook_entries_1);
    }
}
