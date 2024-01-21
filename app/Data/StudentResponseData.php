<?php

namespace App\Data;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\Validation\DateFormat;
use Spatie\LaravelData\Data;

class StudentResponseData extends Data
{
    public function __construct(
        public string $id,
        public string $assessmentId,
        #[DateFormat('d/m/Y H:i:s')]
        public Carbon $assigned,
        #[DateFormat('d/m/Y H:i:s')]
        public Carbon $started,
        #[DateFormat('d/m/Y H:i:s')]
        public ?Carbon $completed,
        public StudentData $student,
        public array $responses,
        public array $results,
    ) {}

    public function isCompleted(): bool
    {
        return !is_null($this->completed);
    }
}
