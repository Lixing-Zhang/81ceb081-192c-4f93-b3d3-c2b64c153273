<?php

namespace App\Commands;

use App\Enums\Report;
use App\Services\DataLoader;
use App\Services\DiagnosticReport;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

use function Termwind\{render};

class InspireCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'inspire';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->line('Please enter the following');

        try {
            $studentId = $this->ask('Student ID');

            $report = $this->askWithCompletion('Report to generate (1 for Diagnostic, 2 for Progress, 3 for Feedback)', Report::toArray());

            if (is_numeric($report)) {
                $report = Report::tryFrom($report)?->name;
            }

            switch ($report) {
                case Report::Diagnostic->name:
                    $outputs = (app(DiagnosticReport::class)->generateReport($studentId));
                    break;
                case Report::Progress->name:
                    $outputs = (app(DiagnosticReport::class)->generateReport($studentId));
                    break;
                case Report::Feedback->name:
                    $outputs = (app(DiagnosticReport::class)->generateReport($studentId));
                    break;
                default:
                    $this->warn('Invalid report number');
                    $outputs = [];

            }

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
