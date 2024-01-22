<?php

namespace App\Services;

use App\Data\AssessmentData;
use App\Data\QuestionData;
use App\Data\StudentData;
use App\Data\StudentResponseData;
use Illuminate\Support\Enumerable;
use Spatie\LaravelData\DataCollection;

class DataLoader
{
    public string $dataPath;

    public function __construct()
    {
        $this->dataPath = base_path('seeds');
    }

    /**
     * @throws \Exception
     */
    public function getAssessments(): DataCollection
    {
        $assessmentsFilePath = $this->dataPath . '/assessments.json';

        if (!file_exists($assessmentsFilePath)) {
            throw new \Exception('Assessments file not found');
        }

        $assessments = json_decode(file_get_contents($assessmentsFilePath), true);

        return AssessmentData::collection($assessments);
    }

    /**
     * @throws \Exception
     */
    public function getStudents(): DataCollection
    {
        $studentsFilePath = $this->dataPath . '/students.json';

        if (!file_exists($studentsFilePath)) {
            throw new \Exception('Students file not found');
        }

        $students = json_decode(file_get_contents($studentsFilePath), true);

        return StudentData::collection($students);
    }

    public function getQuestions(): DataCollection
    {
        $questionsFilePath = $this->dataPath . '/questions.json';

        if (!file_exists($questionsFilePath)) {
            throw new \Exception('Questions file not found');
        }

        $questions = json_decode(file_get_contents($questionsFilePath), true);

        return QuestionData::collection($questions);
    }

    public function getStudentResponses(): DataCollection
    {
        $responsesFilePath = $this->dataPath . '/student-responses.json';

        if (!file_exists($responsesFilePath)) {
            throw new \Exception('Student Responses file not found');
        }

        $responses = json_decode(file_get_contents($responsesFilePath), true);

        return StudentResponseData::collection($responses);
    }

    /**
     * @throws \Exception
     */
    public function buildResponsesForStudent(string $studentId): Enumerable
    {
        $studentResponses = $this->getStudentResponses();

        $questions = $this->getQuestions();

        return $studentResponses->filter(function (StudentResponseData $data) use ($studentId, $questions){
            return $data->student->id == $studentId && $data->isCompleted();

        })->map(function (StudentResponseData $data) use ($questions) {

            foreach ($data->responses as &$response) {

                $question = $questions->where('id', $response->questionId)->first();

                $response->question = $question;

                $response->isCorrect = $response->response == $question->config['key'];
            }

            $data->count = $data->responses->count();

            $data->correctCount = $data->responses->where('isCorrect', true)->count();

            return $data;

        })->toCollection();
    }

}
