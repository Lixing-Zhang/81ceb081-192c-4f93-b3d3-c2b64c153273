<?php

namespace App\Services;

class ProgressReport extends Report
{

    /**
     * @throws \Exception
     */
    public function generateReport(string $studentId): array
    {
        $student = $this->getStudent($studentId);

        if (!$student) {
            throw new \Exception('Student not found');
        }

        $responses = $this->dataLoader->buildResponsesForStudent($studentId)->sortBy('completed');

        $assessment = $this->getAssessment();

        if (!$assessment) {
            throw new \Exception('Assessment Response not found');
        }

        $output = [
            "Tony Stark has completed {$assessment->name} assessment {$responses->count()} times in total. Date and raw score given below:" . PHP_EOL,
        ];

        $correctCounts = [];
        foreach ($responses as $response) {
            $correctCounts[] = $response->correctCount;
            $output[] = "Date: {$response->completed->format('jS F Y')}, Raw Score: $response->correctCount out of {$response->count}";
        }

        $diff = max($correctCounts) - min($correctCounts);
        $output[] = "Tony Stark got {$diff} more correct in the recent completed assessment than the oldest";
        return $output;
    }
}
