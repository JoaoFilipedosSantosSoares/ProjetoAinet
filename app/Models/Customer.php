<?php

namespace App\Models;

use App\Models\Traits\HasSoftDeleteOnly;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nif', 'address', 'default_payment_type', 'default_payment_reference'])]
class Customer extends Model
{
    use HasSoftDeleteOnly;
}
