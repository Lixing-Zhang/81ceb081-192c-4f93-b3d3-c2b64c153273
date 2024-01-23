<?php

namespace App\Services;

use App\Enums\ReportEnum;

class ReportManager
{
    /**
     * @var array Report[]
     */
    public array $reports;

    public function __construct(Report ...$reports)
    {
        $this->reports = $reports;
    }

    public function generateReport(string $studentId, ReportEnum|string|int $reportEnum): array
    {
        foreach ($this->reports as $report) {
            if ($report->forReport($reportEnum)) {
                return $report->generateReport($studentId);
            }
        }

        return [];
    }
}
