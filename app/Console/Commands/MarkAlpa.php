<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;

class MarkAlpa extends Command
{
    protected $signature = 'attendance:mark-alpa';
    protected $description = 'Tandai otomatis karyawan yang tidak absen sebagai alpa';

    public function handle()
    {
        $today = Carbon::today();
        if ($today->isWeekend()) {
            return;
        }

        $users = User::whereIn('role', ['employee', 'manager'])->get();

        foreach ($users as $user) {
            $alreadyExists = Attendance::where('user_id', $user->id)
                ->whereDate('date', $today)
                ->exists();

            if (!$alreadyExists) {
                Attendance::create([
                    'user_id' => $user->id,
                    'date' => $today,
                    'status' => 'alpa',
                ]);
            }
        }

        $this->info('Absensi alpa otomatis selesai.');
    }
}

