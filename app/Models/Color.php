<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use App\Models\Order_item;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['code', 'name'])]
#[Table(key: 'code', keyType: 'string', incrementing: false, timestamps: false)]
class Color extends Model
{
    use SoftDeletes;

    //Relação Color-orderItems
    public function order_items(): HasMany
    {
        return $this->hasMany(Order_item::class, 'color_code', 'code');
    }
}
