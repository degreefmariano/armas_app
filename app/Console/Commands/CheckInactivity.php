<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class CheckInactivity extends Command
{
    protected $signature = 'check:inactivity';
    protected $description = 'Check user inactivity and logout if necessary';

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            $lastActivity = $user->last_activity;

            if ($lastActivity && Carbon::now()->diffInMinutes($lastActivity) > config('auth.inactivity_timeout')) {
                $user->logout(); // Implementa el método logout en tu modelo User
            }
        }
    }
}