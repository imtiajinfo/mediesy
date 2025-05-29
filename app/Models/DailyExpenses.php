<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyExpenses extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filterable;
    protected $dates = ['deleted_at'];
    protected $primaryKey = 'id';

    protected $guarded = [];
    protected $fillable = [
        'expense_name',
        'expense_group',
        'company',
        'store',
        'expense_date',
        'approved_status',
        'amount',
        'deleted_at',
    ];

    public function hasPagination($query, $request)
    {
        return $query->paginate($request->input('per_page', 10));
    }
    public function scopeFilter($query, $request)
    {
        $query->when($request->search ?? false, function ($query, $search) {
            $query->where('expense_name', 'like', "%$search%")
                ->orWhere('expense_group', 'like', "%$search%");
        });

        return $query;
    }

    public function scopeFilterByName($query, $search)
    {
        return $query->where('expense_name', 'like', '%' . $search . '%');
    }


    public function scopeFilterByNameBangla($query, $search)
    {
        return $query->where('expense_date', 'like', '%' . $search . '%');
    }

    public function expenses()
    {
        return $this->belongsTo(Expense::class, 'expense_group');
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
