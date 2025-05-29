<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'return_id',
        'product_id',
        'pur_sale_detials_id',
        'quantity',
        'amount',
    ];

    public function itemInfo()
    {
        return $this->belongsTo(ItemInfo::class, 'product_id');
    }
}
