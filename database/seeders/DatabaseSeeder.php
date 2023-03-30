<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'email' => 'info@favin.ir',
            'password' => bcrypt(123456),
            'national_code' => '1234567890',
            'first_name' => 'Moshen',
            'last_name' => 'Behroozi',
            'slug' => 'mohsen-behroozi',
            'email_verified_at' => Carbon::now(),
            'activation' => '1',
            'user_type' => '1',
            'created_at' => Carbon::now(),
        ]);
        
        User::factory(10)->has(Wallet::factory()->has(Transaction::factory()->count(3))->count(3))->create();
    }
}
