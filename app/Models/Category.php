<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasSoftDeleteOnly;

#[Fillable(['name', 'image_url'])]
class Category extends Model
{
    use HasSoftDeleteOnly;
}
