<?php

namespace App\Models\Traits\HasCommonFillable;

use Illuminate\Database\Eloquent\Attributes\Fillable;

// Trait só com soft delete (deleted_at)
#[Fillable(['deleted_at', 'custom'])]
trait HasSoftDeleteOnly
{
    //
}