<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReceiveMaster extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'issue_master_id',
        'spo_id',
        'tran_type_id',
        'tran_source_type_id',
        'prod_type_id',
        'company_id',
        'branch_id',
        'store_id',
        'currency_id',
        'excg_rate',
        'supplier_id',
        'receive_date',
        'grn_number',
        'grn_date',
        'chalan_number',
        'chalan_date',
        'total_amt_trans_curr',
        'total_amt_local_curr',
        'is_paid',
        'remarks',
        'created_by',
        'updated_by',
    ];

    public function ReceiveChild()
    {
        return $this->hasMany(ReceiveChild::class, 'receive_master_id');
    }

    public function itemInfo()
    {
        return $this->belongsTo(ItemInfo::class, 'item_info_id');
    }
}
