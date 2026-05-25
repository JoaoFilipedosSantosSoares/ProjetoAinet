<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

#[Fillable(['status', 'customer_id', 'date', 'total_price', 'notes', 'reason_for_cancellation', 'nif', 'address', 'payment_type', 'payment_ref', 'receipt_url'])]
class Order extends Model
{
    //
}
