<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_name',
        'store_email',
        'store_phone',
        'store_address',
        'currency',
        'timezone',
        'notify_new_orders',
        'notify_low_stock',
        'notify_new_customers',
    ];

    protected function casts(): array
    {
        return [
            'notify_new_orders' => 'boolean',
            'notify_low_stock' => 'boolean',
            'notify_new_customers' => 'boolean',
        ];
    }
}
