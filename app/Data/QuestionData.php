<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class QuestionData extends Data
{
    public function __construct(
        public string $id,
        public string $stem,
        public string $type,
        public string $strand,
        public array $config,
    ) {
    }
}
