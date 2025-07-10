<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndexFund extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'symbol',
        'expense_ratio',
        'aum',
        'description'
    ];

    protected $casts = [
        'expense_ratio' => 'decimal:4',
        'aum' => 'decimal:2'
    ];
}
