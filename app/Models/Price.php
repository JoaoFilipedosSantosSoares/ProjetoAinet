<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

#[Fillable(['unit_price_catalog', 'unit_price_own', 'unit_price_catalog_discount', 'unit_price_own_discount', 'qty_discount'])]
class Price extends Model
{
    //
}
