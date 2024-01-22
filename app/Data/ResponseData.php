<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class ResponseData extends Data
{
    public function __construct(
        public string $questionId,
        public string $response,
        public ?QuestionData $question,
        public ?bool $isCorrect,
    ) {
    }
}
