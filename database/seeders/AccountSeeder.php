<?php

namespace Database\Seeders;

use App\Models\Accounts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Accounts::whereId(100)->exists()) {
            Accounts::create([
                'id' => '100'
            ]);
        }

        if (!Accounts::whereId(300)->exists()) {
            Accounts::create([
                'id' => '300'
            ]);
        }
    }
}
