<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class AssessmentData extends Data
{
    public function __construct(
        public string $id,
        public string $name,
        public array $questions
    ) {
    }
}
