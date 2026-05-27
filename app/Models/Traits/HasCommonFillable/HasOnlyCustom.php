<?php

namespace App\Models\Traits\HasCommonFillable;

use Illuminate\Database\Eloquent\Attributes\Fillable;

// Trait sem timestamps, só com um campo custom
#[Fillable(['custom'])]
trait HasOnlyCustom
{
    //
}
