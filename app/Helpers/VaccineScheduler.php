<?php
namespace App\Helpers;

use App\Models\Registration;
use App\Models\User;
use App\Models\VaccineCenter;
use Carbon\Carbon;

class VaccineScheduler
{

    public static function  scheduleVaccinations()
    {
        $users = User::with(['registration' => function ($query) {
                            $query->select('id', 'user_id', 'scheduled_date', 'vaccine_center_id')
                                ->whereNull('scheduled_date');
                            }, 'registration.vaccineCenter:id,daily_limit'])
                            ->whereHas('registration', function ($query) {
                                $query->whereNull('scheduled_date');
                            })
                            ->orderBy('id', 'asc')->take(2000)->get(['id']);


        foreach ($users as $user) {
            $scheduledDate = self::getNextAvailableDate($user->registration->vaccineCenter);
            if ($scheduledDate) {
                $registration = Registration::where('user_id', $user->id)->first();
                if ($registration) {
                    $registration->update(['scheduled_date' => $scheduledDate]);
                }
            }
        }

    }


    public static function getNextAvailableDate(VaccineCenter $center)
    {
        $today = Carbon::today();
        $daysChecked = 0;
        $maxDays = 30;
        while ($daysChecked < $maxDays) {
            if ($today->isWeekday()) {
                $scheduledCount = Registration::where('vaccine_center_id', $center->id)
                                              ->where('scheduled_date', $today)
                                              ->count();

                if ($scheduledCount < $center->daily_limit) {
                    return $today;
                }
            }
            $today->addDay();
            $daysChecked++;
        }
        return null;
    }

}
