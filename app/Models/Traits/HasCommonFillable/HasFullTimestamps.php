<?php

namespace App\Models\Traits\HasCommonFillable;

use Illuminate\Database\Eloquent\Attributes\Fillable;

// Trait com todos os timestamps (created_at, updated_at, deleted_at)
#[Fillable(['created_at', 'updated_at', 'deleted_at', 'custom'])]
trait HasFullTimestamps
{

}