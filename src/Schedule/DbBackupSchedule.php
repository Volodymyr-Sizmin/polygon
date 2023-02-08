<?php

namespace App\Schedule;

use App\Command\BackupDbCommand;
use Zenstruck\ScheduleBundle\Schedule;

class DbBackupSchedule implements \Zenstruck\ScheduleBundle\Schedule\ScheduleBuilder
{

    public function buildSchedule(Schedule $schedule): void
    {
        $schedule->timezone('UTC');
        $schedule->addCommand(BackupDbCommand::class)->dailyAt(6);
    }
}