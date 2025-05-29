<?php

namespace App\Models;

use App\Models\Store;
use App\Models\ItemInfo;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemStoreMapping extends Model
{
    use HasFactory;
    use Filterable;
    protected $guarded = [];
    protected $fillable = ['item_id', 'store_id', 'descriptions', 'status'];

    public function items()
    {
        return $this->belongsToMany(ItemInfo::class, 'item_infos');
    }

    public function stores()
    {
        return $this->belongsTo(Store::class);
    }


    public function scopeFilter($query, $request)
    {
        $query->when($request->search ?? false, function ($query, $search) {
            $query->where('name_english', 'like', "%$search%")
                ->orWhere('parent_id', 'like', "%$search%");
        });

        return $query;
    }

    public function scopeFilterByName($query, $search)
    {
        return $query->where('name_english', 'like', '%' . $search . '%');
    }


    public function scopeFilterByNameBangla($query, $search)
    {
        return $query->where('name_bangla', 'like', '%' . $search . '%');
    }
}
