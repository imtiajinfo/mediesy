<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TranType extends Model
{
    use HasFactory;

    protected $table = 'tran_type';

    protected $fillable = [
        'tran_source_type_id',
        'tran_type_name',
        'tran_type_name_bn',
        'sequence_number',
        'is_active',
        'created_by',
        'updated_by',
    ];

    // Define relationships if any
}
