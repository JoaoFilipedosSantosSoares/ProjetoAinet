<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Customer;
use App\Models\Order_item;

#[Fillable([
    'status',
    'customer_id',
    'date',
    'total_price',
    'notes',
    'reason_for_cancellation',
    'nif',
    'address',
    'payment_type',
    'payment_ref',
    'receipt_url'
])]
class Order extends Model
{

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function order_items(): HasMany
    {
        return $this->hasMany(Order_item::class, 'order_id', 'id');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }

    public function isCanceled(): bool
    {
        return $this->status === 'canceled';
    }

    public function isVisa(): bool
    {
        return $this->payment_type === 'Visa';
    }

    public function isPaypal(): bool
    {
        return $this->payment_type === 'PayPal';
    }

    public function isMbway(): bool
    {
        return $this->payment_type === 'MB WAY';
    }
}
