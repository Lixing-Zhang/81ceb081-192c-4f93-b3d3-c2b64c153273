<?php

namespace App\Services;

class DiagnosticReport extends Report
{
    /**
     * @throws \Exception
     */
    public function generateReport(string $studentId): array
    {

        $student = $this->getStudent($studentId);

        $lastResponse = $this->dataLoader->buildResponsesForStudent($studentId)
            ->sortByDesc('completed')->first();

        if (! $lastResponse) {
            throw new \Exception('Student Response not found');
        }

        $assessment = $this->getAssessment();

        $groups = collect($lastResponse->responses)->groupBy('question.strand');

        $output = [
            "{$student->firstName} {$student->lastName} recently completed {$assessment->name} assessment on {$lastResponse->completed->format('jS F Y g:i A')}",
            "He got {$lastResponse->correctCount} questions right out of {$lastResponse->count}. Details by strand given below:".PHP_EOL,
        ];

        foreach ($groups as $strand => $group) {
            $correctCount = $group->where('isCorrect', true)->count();
            $output[] = "{$strand}: {$correctCount} out of {$group->count()} correct";
        }

        return $output;
    }
}
