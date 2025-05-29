<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'name_bangla', 'descriptions', 'status'];

    public function daily_expenses()
    {
        return $this->hasMany(DailyExpenses::class);
    }
}
