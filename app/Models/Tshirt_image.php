<?php

namespace App\Models;

use App\Models\Traits\HasFullTimestamps;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['customer_id', 'category_id', 'name', 'description', 'image_url'])]
class Tshirt_image extends Model
{
    use HasFullTimestamps;
}
