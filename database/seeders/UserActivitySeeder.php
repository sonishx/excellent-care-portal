<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;

class UserActivitySeeder extends Seeder
{
    public function run(): void
    {
        // Clear old activity (optional)
        DB::table('user_activity')->truncate();

        $roles = ['clinician', 'caregiver', 'admin'];
        $users = User::all();

        foreach (range(0, 11) as $daysAgo) { // last 12 days
            $date = Carbon::now()->subDays($daysAgo)->startOfDay();
            
            foreach ($users as $user) {
                DB::table('user_activity')->insert([
                    'user_id' => $user->id,
                    'role' => $user->role, // take role from users table
                    'created_at' => $date->copy()->addMinutes(rand(0, 1440)), // random time in day
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}