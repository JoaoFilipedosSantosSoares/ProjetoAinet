<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Order;
use App\Models\Tshirt_Image;

#[Fillable([
    'order_id',
    'tshirt_image_id',
    'color_code', // ADICIONADO: Faltava no teu código
    'size',
    'qty',
    'unit_price',
    'sub_total'
])]
#[Table(timestamps: false)]


class Order_item extends Model
{
    protected $casts = [
        'unit_price' => 'decimal:2',
        'sub_total' => 'decimal:2'
    ];

    //Relação Order-Order_item
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    //Relação Tshirt_Images-Order_Items
    public function tshirt_image(): BelongsTo
    {
        return $this->belongsTo(Tshirt_Image::class, 'tshirt_image_id', 'id');
    }

    //Relação Color-Order_Items
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'color_code', 'code');
    }

    public function getSizeLabel(): string
    {
        return match ($this->size) {
            'XS' => 'Extra Small',
            'S'  => 'Small',
            'M'  => 'Medium',
            'L'  => 'Large',
            'XL' => 'Extra Large',
            default => $this->size
        };
    }
}
