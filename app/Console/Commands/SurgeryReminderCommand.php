<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Surgery;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Carbon;

#[Signature('surgeries:remind')]
#[Description('Sends reminders for surgeries happening in 1, 2, or 3 days')]
class SurgeryReminderCommand extends Command
{
    protected $signature = 'surgery:reminder';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $daysToCheck = [1, 2, 3];

        foreach ($daysToCheck as $days) {
            $targetDate = Carbon::today()->addDays($days)->format('Y-m-d');

            $surgeries = Surgery::with(['patient', 'surgeryType'])->whereDate('surgery_date', $targetDate)->get();

            foreach ($surgeries as $surgery) {
                // Find secretaries in the same tenant to notify
                $secretaries = User::where('tenant_id', $surgery->tenant_id)
                                   ->where('role', 'secretary')
                                   ->get();

                $patientName = $surgery->patient ? $surgery->patient->name : 'مريض';

                $message = "تذكير: عملية المريض [{$patientName}] تقترب (بعد {$days} يوم)";

                foreach ($secretaries as $secretary) {
                    $secretary->notify(new GeneralNotification($message, 'warning', 'clock'));
                }
            }
        }

        $this->info('Surgery reminders sent successfully.');
    }
}
