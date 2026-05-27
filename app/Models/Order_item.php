<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Traits\HasCommonFillable\HasOnlyCustom;
use App\Models\Order;
use App\Models\Tshirt_Image;

#[Fillable(['order_id', 'tshirt_image_id', 'size', 'qty', 'unit_price', 'sub_total'])]
#[Table(timestamps: false)]
class Order_item extends Model
{
    use HasOnlyCustom;

    //Relação Order-Order_item
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    //Relação Tshirt_Images-Order_Items
    public function tshirt_Image(): BelongsTo
    {
        return $this->belongsTo(Tshirt_Image::class, 'tshirt_image_id', 'id');
    }
}
