<?php

namespace App\Models\Traits\HasCommonFillable;

use Illuminate\Database\Eloquent\Attributes\Fillable;

// Trait só com timestamps básicos (created_at, updated_at)
#[Fillable(['created_at', 'updated_at', 'custom'])]
trait HasBaseTimestamps
{
    //
}