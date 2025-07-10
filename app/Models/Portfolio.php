<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'symbol',
        'shares',
        'purchase_price',
        'id_usuario'
    ];

    protected $casts = [
        'shares' => 'decimal:2',
        'purchase_price' => 'decimal:2'
    ];
}
