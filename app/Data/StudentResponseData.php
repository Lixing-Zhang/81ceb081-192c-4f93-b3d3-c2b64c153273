<?php

namespace App\Data;

use Illuminate\Support\Carbon;
use Illuminate\Support\Optional;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\DateFormat;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

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
        #[DataCollectionOf(ResponseData::class)]
        public DataCollection $responses,
        public ResultData $results,
        public ?int $count,
        public ?int $correctCount,
    ) {}

    public function isCompleted(): bool
    {
        return !is_null($this->completed);
    }
}
