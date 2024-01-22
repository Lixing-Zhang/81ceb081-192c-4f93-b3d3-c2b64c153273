<?php

namespace App\Services;

class FeedbackReport
{

    public function generateReport(string $studentId)
    {
        $student = $this->getStudent($studentId);

        if (!$student) {
            throw new \Exception('Student not found');
        }

        return [];
    }
}
