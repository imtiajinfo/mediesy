<?php

namespace App\Models;

use Log;
use App\Models\Size;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Category;
use App\Models\Warranty;
use Milon\Barcode\DNS1D;
use App\Models\SellsItem;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemInfo extends Model
{
    use Filterable;
    protected $guarded = [];

    protected $fillable = [
        'id', 'code', 'name',
        'name_bangla', 'slug', 'category_id', 'min_qty',
        'trans_uom', 'stock_uom', 'sales_uom', 'brand_id', 'weight', 'published_price', 'sell_price',
        'purchase_price', 'discount_type', 'discount_amount', 'color_id', 'size_id',
        'current_stock', 'thumbnail', 'attachment',
        'published', 'status', 'stock_status',
        'sub_title', 'summary', 'request_status',
        'approved',
        'whole_sale_price',
        'whole_sale_qty',
        'product_type',
        'manufacturer',
        'brand',
        'strength',
        'use_for',
        'dar',
        'description',
    ];
    protected $casts = [
        'color_id' => 'array',
        'attachment' => 'array',
    ];
    // public static function boot()
    // {
    // parent::boot();

    // static::creating(function ($product) {
    //     $product->generateAndSaveBarcode();
    // });

    // static::updating(function ($product) {
    //     $product->generateAndSaveBarcode();
    // });
    // }

    public function itemStoreMappings()
    {
        return $this->belongsToMany(ItemStoreMapping::class);
    }

    public function SellsItem()
    {
        return $this->hasMany(SellsItem::class, 'id');
    }

    // Item.php
    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function colors()
    {
        return $this->belongsTo(Color::class, 'color');
    }

    public function sizes()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function brands()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function uom()
    {
        return $this->hasOne(Uom::class, 'id', 'trans_uom');
    }


    // Item.php
    public function sales_uom()
    {
        return $this->belongsTo(Uom::class);
    }

    public function warrenty()
    {
        return $this->belongsTo(Warranty::class);
    }

    // public function stock_uom()
    // {
    //     return $this->belongsTo(Uom::class);
    // }


    // public function generateAndSaveBarcode()
    // {
    //     try {
    //         // dd($this->id);
    //         $barcodeValue = $this->id;

    //         // Instantiate an object of DNS1D
    //         $dns1d = new DNS1D();

    //         // Generate barcode
    //         $barcode = $dns1d->getBarcodeHTML($barcodeValue, 'C39');
    //         // $barcode = $dns1d->getBarcodeHTML($barcodeValue, 'PHARMA2T');

    //         // Save barcode in the "code" column
    //         $this->code = $barcode;

    //         // Save the updated model
    //         // $this->save();
    //         return $barcode;
    //     } catch (\Exception $e) {
    //         // Log or handle the exception as needed
    //         Log::error($e->getMessage());
    //     }
    // }
}
