<?php

namespace Database\Seeders;

use App\Models\ActionHistory;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Warranty;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Warranty::factory()->count(1)->create();

        Invoice::factory()->count(1)->create();

        ActionHistory::factory()->count(4)->create();
    }
}
