<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Store; // Import the Store model

function hasRole($role)
{
    return Auth::user()->role === $role;
}

//check current user store and admin = all store id
if (!function_exists('userStore')) {
    function userStore()
    {
        $user = Auth::user();

        if (hasRole('admin')) {
            $stores = Store::select('id')->get();
            return $stores->pluck('id')->unique()->toArray();
        } else {
            $stores = Store::select('id')->where('stores.id', $user->store_id)->get();
            return $stores->pluck('id')->unique()->toArray();
        }
    }
}


//check item is current store 
if (!function_exists('storItem')) {
    function storItem($query)
    {
        return  $query->leftjoin('item_store_mappings', 'item_infos.id', 'item_store_mappings.item_id')
            ->leftjoin('stores', 'item_store_mappings.store_id', 'stores.id')
            ->whereIn('item_store_mappings.store_id', userStore());
    }
}

//check item is current store 
if (!function_exists('purchaseOrderItem')) {
    function purchaseOrderItem($query)
    {
        return  $query->whereIn('purchase_orders.store_id', userStore());
    }
}


//create purchase orders
if (!function_exists('createPurchaseOrderItem')) {
    function createPurchaseOrderItem($query)
    {
        $user = Auth::user();
        $stores = Store::select('id')->where('stores.id', $user->store_id)->get();
        $currentUserStore = $stores->pluck('id')->unique()->toArray();

        return  $query->leftjoin('item_store_mappings', 'item_infos.id', 'item_store_mappings.item_id')
            ->leftjoin('stores', 'item_store_mappings.store_id', 'stores.id')
            ->whereIn('item_store_mappings.store_id', $currentUserStore);
    }
}



//check sells is current store 
if (!function_exists('storeSells')) {
    function storeSells($query)
    {
        return  $query->leftjoin('sells_items', 'sells.id', 'sells_items.sell_id')
            ->whereIn('sells_items.store_id', userStore());
    }
}


//check Warranty is current store 
if (!function_exists('storeWarranty')) {
    function storeWarranty($query)
    {
        return  $query->whereIn('warranties.store_id', userStore());
    }
}

//check DailyExpense is current store 
if (!function_exists('storeDailyExpense')) {
    function storeDailyExpense($query)
    {
        return  $query->whereIn('daily_expenses.store', userStore());
    }
}



//nabvar store dropdown
if (!function_exists('showNavbarStore')) {
    function showNavbarStore()
    {
        $stores = \App\Models\Store::all();
        $defaultStore = \App\Models\Store::where('store_type', 1)->pluck('id')->first();

        return ['stores' => $stores, 'defaultStore' => $defaultStore];
    }
}
