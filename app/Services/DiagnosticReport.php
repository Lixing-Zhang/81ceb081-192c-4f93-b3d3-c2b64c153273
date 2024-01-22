<?php

namespace App\Services;

use App\Data\StudentResponseData;

class DiagnosticReport extends Report
{

    public function generateReport(string $studentId): array
    {
        $student = $this->getStudent($studentId);

        if (!$student) {
            throw new \Exception('Student not found');
        }

        $lastResponse = $this->dataLoader->buildResponsesForStudent($studentId)
            ->sortByDesc('completed')->first();

        if (!$lastResponse) {
            throw new \Exception('Student Response not found');
        }

        $assessment = $this->getAssessment();

        if (!$assessment) {
            throw new \Exception('Assessment Response not found');
        }

        $questionsCount = collect($lastResponse->responses)->count();
        $questionsCorrectCount = collect($lastResponse->responses)->where('is_correct', true)->count();

        $groups = collect($lastResponse->responses)->groupBy('question.strand');

        $output = [
            "{$student->firstName} {$student->lastName} recently completed {$assessment->name} assessment on {$lastResponse->completed->format('jS F Y g:i A')}",
            "He got {$questionsCorrectCount} questions right out of {$questionsCount}. Details by strand given below:" . PHP_EOL,
        ];

        foreach ($groups as $strand => $group) {
            $correctCount = $group->where('is_correct', true)->count();
            $output[] = "{$strand}: {$correctCount} out of {$group->count()} correct";
        }

        return $output;
    }
}
