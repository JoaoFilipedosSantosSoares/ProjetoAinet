<?php

namespace App\Models;

use App\Models\Traits\HasCommonFillable\HasSoftDeleteOnly;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use App\Models\Tshirt_image;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'image_url'])]
class Category extends Model
{
    use HasSoftDeleteOnly;

    //Relação Category-Tshirt_Images
    public function tshirt_Images(): HasMany
    {
        return $this->hasMany(Tshirt_image::class, 'category_id', 'id');
    }
}
