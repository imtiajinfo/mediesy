<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnMaster extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'master_id',
        'return_date',
        'cus_sup_id',
        'user_id',
        'invoice_no',
        'ression_type',
        'return_amount',
        'note',
    ];

    public function return_details(){
        return $this->hasMany(ReturnDetails::class, 'id', 'return_id');
    }
    public function supplier(){
        return $this->hasOne(Supplier::class, 'id', 'cus_sup_id');
    }
    public function customer(){
        return $this->hasOne(Customer::class, 'id', 'cus_sup_id');
    }
    public function ression(){
        return $this->hasOne(ReturnCategory::class, 'id', 'ression_type');
    }
}
