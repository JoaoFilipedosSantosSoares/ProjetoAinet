<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use App\Models\Tshirt_image;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'image_url'])]
#[Table(timestamps: false)]
class Category extends Model
{
    use SoftDeletes;

    public function tshirt_images(): HasMany
    {
        return $this->hasMany(Tshirt_image::class, 'category_id', 'id');
    }
}
