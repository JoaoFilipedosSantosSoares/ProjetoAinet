<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Models\Traits\HasCommonFillable\HasSoftDeleteOnly;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Tshirt_image;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nif', 'address', 'default_payment_type', 'default_payment_reference'])]
class Customer extends Model
{
    use HasSoftDeleteOnly;


    //Relação User-Customer
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    //Relação Order-Customer
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    //Relação Tshirts_images-Customer
    public function tshirt_images(): HasMany
    {
        return $this->hasMany(Tshirt_image::class, 'customer_id', 'id');
    }
}
