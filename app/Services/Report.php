<?php

namespace App\Services;

abstract class Report
{
    public function __construct(protected DataLoader $dataLoader)
    {

    }

    public function getStudent(string $studentId)
    {
        $students = $this->dataLoader->getStudents();

        return $students->where('id', $studentId)->first();
    }

    public function getAssessment(string $assessmentId = 'assessment1')
    {
        $assessments = $this->dataLoader->getAssessments();

        return $assessments->where('id', $assessmentId)->first();
    }

    abstract function generateReport(string $studentId);
}
