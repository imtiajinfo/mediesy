<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrdersChild extends Model
{
    use HasFactory;
    protected $fillable = [
        'po_id',
        'product_id',
        'purchase_qty',
        'purchase_price',
        'total_amount',
        'is_received',
        'sell_price',
        'whole_sale_price',
        'whole_sale_qty',
        'stock_in',
        'stock_out',
        'return_qty',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrders::class, 'po_id');
    }


    public function itemInfo()
    {
        return $this->belongsTo(ItemInfo::class, 'product_id');
    }
}
