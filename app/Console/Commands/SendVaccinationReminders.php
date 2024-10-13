<?php

namespace App\Console\Commands;
use App\Mail\VaccinationReminder;
use App\Models\Registration;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;


class SendVaccinationReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-vaccination-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send vaccination reminders to users';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // $tomorrow = now()->addDay();
        // Registration::whereDate('scheduled_date', $tomorrow->toDateString())
        //     ->with('user:id,email,name', 'vaccineCenter:id,name')
        //     ->chunk(1000, function ($registrations) {
        //         foreach ($registrations as $registration) {
        //             Mail::to($registration->user->email)
        //                 ->queue(new VaccinationReminder($registration->user, $registration->vaccineCenter));
        //         }
        //     });


         $today = now();
         $tomorrow = now()->addDay();
         $registrations = Registration::whereDate('scheduled_date', $tomorrow->toDateString())
                                      ->with('user:id,email,name', 'vaccineCenter:id,name')
                                      ->get();

         foreach ($registrations as $registration) {
             Mail::to($registration->user->email)->send(new VaccinationReminder($registration->user, $registration->vaccineCenter));
         }

         $this->info('Vaccination reminders sent successfully!');
    }
}
