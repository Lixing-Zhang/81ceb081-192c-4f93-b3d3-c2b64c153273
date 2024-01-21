<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class StudentData extends Data
{
    public function __construct(
        public string $id,
        public string|Optional $firstName,
        public string|Optional $lastName,
        public int $yearLevel
    ) {}
}
