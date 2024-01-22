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

    /**
     * @throws \Exception
     */
    public function getAssessment(string $assessmentId = 'assessment1')
    {
        $assessments = $this->dataLoader->getAssessments();

        $assessment =  $assessments->where('id', $assessmentId)->first();

        if (!$assessment) {
            throw new \Exception('Assessment Response not found');
        }

        return $assessment;
    }

    abstract function generateReport(string $studentId);
}
