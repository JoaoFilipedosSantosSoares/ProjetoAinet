<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

#[Fillable(['order_id', 'tshirt_image_id', 'size', 'qty', 'unit_price', 'sub_total', 'custom'])]
class Order_item extends Model
{
    //
}
