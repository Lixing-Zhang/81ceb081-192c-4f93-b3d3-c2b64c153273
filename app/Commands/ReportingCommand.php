<?php

namespace App\Commands;

use App\Enums\ReportEnum;
use App\Services\ReportManager;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;

use function Termwind\{render};

class ReportingCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'reporting';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     */
    public function handle(ReportManager $reportManager): void
    {
        $this->line('Please enter the following');

        try {
            $studentId = $this->ask('Student ID');

            if (empty($studentId)) {
                $this->warn('Student ID is empty');

                return;
            }

            $report = $this->askWithCompletion('Report to generate (1 for Diagnostic, 2 for Progress, 3 for Feedback)', ReportEnum::toArray());

            if (empty($report)) {
                $this->warn('Report ID is empty');

                return;
            }

            if (! Str::startsWith($studentId, 'student')) {
                $studentId = 'student'.$studentId;
            }

            $outputs = $reportManager->generateReport($studentId, $report);

            foreach ($outputs as $output) {
                $this->info($output);
            }
        } catch (\Exception $e) {
            $this->warn($e->getMessage());
        }

    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
