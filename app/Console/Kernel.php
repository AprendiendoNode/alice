<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
      Commands\estadoserver::class,
      Commands\bytesxdia::class,
      Commands\usuarioxdia::class,
      Commands\mostapxdia::class,
      Commands\roguedevices::class,
      Commands\wlanxdia::class,
      Commands\terminationsurveyxnps::class,
      Commands\sentsurveyxespecial::class,
      Commands\sentsurveyxnps::class,
      Commands\ticketxmonthly::class,
      Commands\Test::class,
      Commands\ticketsxdescription::class,
      Commands\weeklyxpayments::class,
      Commands\weeklyxincome::class,
      Commands\weeklyxviatics::class,
      Commands\enchangeratefix::class,
      Commands\kickoffapprovals::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
      $schedule->command('estado:server')->dailyAt('22:00');
      $schedule->command('usuario:dia')->dailyAt('22:10');
      $schedule->command('bytes:dia')->dailyAt('22:20');
      $schedule->command('ap:dia')->dailyAt('22:30');
      $schedule->command('wlan:dia')->dailyAt('22:40');
      $schedule->command('rougue:mes')->monthly();
      // $schedule->command('survey:chunks')->monthly(1,'10:30');
      // $schedule->command('survey:nps')->monthly(1,'10:30');
      // $schedule->command('survey:especial')->monthly(1,'11:00');
      $schedule->command('termination:nps')->daily();
      //$schedule->command('ticket:desc')->twiceDaily(7, 10);
      $schedule->command('ticket:desc')->hourlyAt(10);
      //$schedule->command('ticket:desc')->twiceDaily(13, 16);
      //$schedule->command('ticket:desc')->twiceDaily(19, 23);
      $schedule->command('weekly:pay')->fridays()->at('19:00');
      $schedule->command('weekly:income')->fridays()->at('19:01');
      $schedule->command('weekly:viatic')->fridays()->at('19:02');
      $schedule->command('check:payments')->monthly(1, '4:00');
      $schedule->command('exchangerate:fix')->timezone('America/Mexico_City')->dailyAt('12:20');
      $schedule->command('kickoff:sendmails')->timezone('America/Mexico_City')->dailyAt('09:00');
      //
      // $schedule->command('ticket:monthly')->weekly()->sundays()->at('23:00');
      // $schedule->command('test:prueba')->weekly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
