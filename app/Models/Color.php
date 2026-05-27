<?php

namespace App\Models;

use App\Models\Traits\HasCommonFillable\HasSoftDeleteOnly;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use App\Models\Order_item;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['code', 'name'])]
class Color extends Model
{
    use HasSoftDeleteOnly;
    
    //Relação Color-orderItems
    public function order_Items(): HasMany
    {
        return $this->hasMany(Order_item::class, 'color_code', 'code');
    }
}
