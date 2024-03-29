<?php

namespace App\Services;

use App\Enums\ReportEnum;

abstract class Report
{
    public function __construct(protected DataLoader $dataLoader)
    {

    }

    /**
     * @throws \Exception
     */
    public function getStudent(string $studentId)
    {
        $students = $this->dataLoader->getStudents();

        $student = $students->where('id', $studentId)->first();

        if (! $student) {
            throw new \Exception('Sorry, we could not find this student ID');
        }

        return $student;
    }

    /**
     * @throws \Exception
     */
    public function getAssessment(string $assessmentId = 'assessment1')
    {
        $assessments = $this->dataLoader->getAssessments();

        $assessment = $assessments->where('id', $assessmentId)->first();

        if (! $assessment) {
            throw new \Exception('Assessment Response not found');
        }

        return $assessment;
    }

    abstract public function generateReport(string $studentId): array;

    abstract public function forReport(ReportEnum|string|int $reportEnum): bool;
}
