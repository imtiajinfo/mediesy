<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReceiveChild extends Model
{
    use HasFactory;
    protected $fillable = [
        'receive_master_id',
        'item_info_id',
        'uom_id',
        'payment_method_id',
        'item_cat_id',
        'recv_quantity',
        'itm_receive_rate',
        'item_value_trans_curr',
        'item_value_local_curr',
        'fixed_rate',
        'total_amt_trans_curr',
        'total_amt_local_curr',
        'gate_entry_at',
        'gate_entry_by',
        'opening_stock_remarks',
        'created_by',
        'updated_by',
    ];

    public function itemInfo()
    {
        return $this->belongsTo(ItemInfo::class, 'item_info_id');
    }
}
