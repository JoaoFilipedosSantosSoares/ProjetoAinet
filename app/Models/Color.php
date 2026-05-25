<?php

namespace App\Models;

use App\Models\Traits\HasSoftDeleteOnly;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['code', 'name'])]
class Color extends Model
{
    use HasSoftDeleteOnly;
}
