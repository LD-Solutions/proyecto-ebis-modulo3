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

    protected $appends = [
        'current_value',
        'profit_loss'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function indexFund()
    {
        return $this->belongsTo(IndexFund::class, 'symbol', 'symbol');
    }

    public function getCurrentValueAttribute()
    {
        if ($this->indexFund) {
            return $this->shares * $this->indexFund->current_price;
        }
        return 0;
    }

    public function getProfitLossAttribute()
    {
        return $this->current_value - ($this->shares * $this->purchase_price);
    }
}
