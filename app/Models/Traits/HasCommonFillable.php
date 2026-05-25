<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['created_at', 'updated_at', 'deleted_at', 'custom'])]
trait HasCommonFillable
{
    // Define aqui os fillables que serão compartilhados
}
