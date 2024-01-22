<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class ResultData extends Data
{
    public function __construct(
      public int $rawScore,
    ) {}
}
