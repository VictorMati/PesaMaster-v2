<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountsSeeder extends Seeder
{
    public function run(): void
    {
        Account::factory(100)->create(); // Creates 10 accounts
    }
}
