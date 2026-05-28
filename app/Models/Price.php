<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasOnlyCustom;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Fillable([
    'unit_price_catalog',
    'unit_price_own',
    'unit_price_catalog_discount',
    'unit_price_own_discount',
    'qty_discount'
])]
#[Table(timestamps: false)]
class Price extends Model
{
    use HasOnlyCustom;
}
