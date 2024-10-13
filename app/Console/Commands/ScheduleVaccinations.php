<?php

namespace App\Console\Commands;

use App\Helpers\VaccineScheduler;
use Illuminate\Console\Command;

class ScheduleVaccinations extends Command
{


    protected $signature = 'app:schedule-vaccinations';

    protected $description = 'Schedule vaccinations for users';


    public function handle()
    {

        VaccineScheduler::scheduleVaccinations();
        $this->info('Vaccinations have been scheduled successfully.');
    }


}
