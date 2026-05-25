<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasOnlyCustom;

#[Fillable(['order_id', 'tshirt_image_id', 'size', 'qty', 'unit_price', 'sub_total'])]
class Order_item extends Model
{
    use HasOnlyCustom;
}
