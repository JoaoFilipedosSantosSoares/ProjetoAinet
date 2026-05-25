<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Attributes\Fillable;

// Trait com todos os timestamps (created_at, updated_at, deleted_at)
#[Fillable(['created_at', 'updated_at', 'deleted_at', 'custom'])]
trait HasFullTimestamps
{
    //
}

// Trait só com soft delete (deleted_at)
#[Fillable(['deleted_at', 'custom'])]
trait HasSoftDeleteOnly
{
    //
}

// Trait só com timestamps básicos (created_at, updated_at)
#[Fillable(['created_at', 'updated_at', 'custom'])]
trait HasBaseTimestamps
{
    //
}

// Trait sem timestamps, só com um campo custom
#[Fillable(['custom'])]
trait HasOnlyCustom
{
    //
}
