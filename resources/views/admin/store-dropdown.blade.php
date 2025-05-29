@php
$navbarData = showNavbarStore();
@endphp

<select class="form-select form-control" id="storeDropdown" style="min-width:250px">
    @foreach($navbarData['stores'] as $store)
    <option value="{{ $store->id ?? ""}}" {{ $store->id == Auth()->user()->store_id ? 'selected' : '' }} @if(Auth()->user()->role =='admin' || Auth()->user()->role == 'super-admin') enabled @else disabled @endif >{{ $store->name ?? "" }}{{ $store->store_type == 1 ? "  -- (Main Store)": " -- (Sub-Store)" }}</option>
    @endforeach
</select>
