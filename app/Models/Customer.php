<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Tshirt_image;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['id', 'nif', 'address', 'default_payment_type', 'default_payment_ref','photo_url'])]
#[Table(keyType: 'int', incrementing: false, timestamps: false)]
class Customer extends Model
{
    use SoftDeletes;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function tshirt_images(): HasMany
    {
        return $this->hasMany(Tshirt_image::class, 'customer_id', 'id');
    }
}
