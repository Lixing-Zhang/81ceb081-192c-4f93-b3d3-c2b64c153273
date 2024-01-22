<?php

namespace App\Commands;

use App\Enums\Report;
use App\Services\DiagnosticReport;
use App\Services\FeedbackReport;
use App\Services\ProgressReport;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;

use function Laravel\Prompts\text;
use function Laravel\Prompts\suggest;
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
    public function handle(
        DiagnosticReport $diagnosticReport,
        ProgressReport $progressReport,
        FeedbackReport $feedbackReport
    ): void {
        $this->line('Please enter the following');

        try {
            $studentId = text('Student ID', required: true);

            $report = suggest(
                label: 'Report to generate (1 for Diagnostic, 2 for Progress, 3 for Feedback)',
                options: Report::toArray(), required: true,
                validate: fn (string $value) => match (true) {
                    !in_array($value, Report::values()) && !in_array($value, Report::names()) => 'The report must be either Diagnostic, Progress or Feedback ',
                    default => null
                });

            if (is_numeric($report)) {
                $report = Report::tryFrom($report)?->name;
            }

            if (!Str::startsWith($studentId, 'student')) {
                $studentId = 'student'. $studentId;
            }

            switch ($report) {
                case Report::Diagnostic->name:
                    $outputs = $diagnosticReport->generateReport($studentId);
                    break;
                case Report::Progress->name:
                    $outputs = $progressReport->generateReport($studentId);
                    break;
                case Report::Feedback->name:
                    $outputs = $feedbackReport->generateReport($studentId);
                    break;
                default:
                    $this->warn('Sorry, you have provided invalid report number!');
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
