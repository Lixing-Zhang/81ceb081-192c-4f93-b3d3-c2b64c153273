<?php

namespace App\Services;

class FeedbackReport extends Report
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

        $output = [
            "{$student->firstName} {$student->lastName} recently completed {$assessment->name} assessment on {$lastResponse->completed->format('jS F Y g:i A')}",
            "He got {$lastResponse->correctCount} questions right out of {$lastResponse->count}. Feedback for wrong answers given below:".PHP_EOL,
        ];

        foreach ($lastResponse->responses as $response) {
            if (! $response->isCorrect) {
                $rightAnswer = collect($response->question->config['options'])->where('id', $response->question->config['key'])->first();
                $yourAnswer = collect($response->question->config['options'])->where('id', $response->response)->first();
                $output[] = "Question: {$response->question->stem}";
                $output[] = "Your answer: {$yourAnswer['label']} with value {$yourAnswer['value']}";
                $output[] = "Right answer: {$rightAnswer['label']} with value {$rightAnswer['value']}";
                $output[] = "Hint: {$response->question->config['hint']}".PHP_EOL;
            }
        }

        return $output;
    }
}
