<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Customer;
use App\Models\Order_item;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['customer_id', 'category_id', 'name', 'description', 'image_url'])]
class Tshirt_image extends Model
{
    use SoftDeletes;

    //Relação Tshirts_images-Customer
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    //Relação Tshirt_Images-Order_Items
    public function order_items(): HasMany
    {
        return $this->hasMany(Order_Item::class, 'tshirt_image_id', 'id');
    }

    //Relação Category-Tshirt_image
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
