<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Models\Traits\HasCommonFillable\HasBaseTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Customer;
use App\Models\Order_item;


#[Fillable(['status', 'customer_id', 'date', 'total_price', 'notes', 'reason_for_cancellation', 'nif', 'address', 'payment_type', 'payment_ref', 'receipt_url'])]
class Order extends Model
{
    use HasBaseTimestamps;

    //Relação Order-Customer
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    //Relação Order-Order_item
    public function order_Items(): HasMany
    {
        return $this->hasMany(Order_item::class, 'order_id', 'id');
    }
}
