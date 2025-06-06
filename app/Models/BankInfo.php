<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'name_bangla', 'account_type', 'branch', 'descriptions', 'status'
    ];
}
