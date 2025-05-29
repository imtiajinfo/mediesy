<div class="modal-body">

    <div class="text-center">
        <span class="avatar avatar-xxl mb-3">
            <img src="{{ get_correct_path($publisher->image, 'images/publisher', 'avatar.jpeg') }}"
                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
        </span>
        <h1 class="h5 mb-1">{{ $publisher->name }}</h1>
        <p class="text-sm text-muted">{{ $publisher->name }}</p>

        <div class="pad-ver btn-groups">
            <a href="{{ $publisher->facebook ?? '#' }}" class="btn btn-icon demo-pli-facebook icon-lg add-tooltip"
                data-original-title="Facebook" data-container="body"></a>
            <a href="{{ $publisher->twitter ?? '#' }}" class="btn btn-icon demo-pli-twitter icon-lg add-tooltip"
                data-original-title="Twitter" data-container="body"></a>
            <a href="{{ $publisher->google ?? '#' }}" class="btn btn-icon demo-pli-google-plus icon-lg add-tooltip"
                data-original-title="Google+" data-container="body"></a>
        </div>
    </div>
    <hr>

    <!-- Profile Details -->
    <h6 class="mb-4">{{ translate('About') }} {{ $publisher->name }}</h6>
    <p><i class="demo-pli-map-marker-2 icon-lg icon-fw mr-1"></i>{{ $publisher->address }}</p>
    <p><a href="#" class="btn-link"><i
                class="demo-pli-internet icon-lg icon-fw mr-1"></i>{{ $publisher->name }}</a></p>
    <p><i class="demo-pli-old-telephone icon-lg icon-fw mr-1"></i>{{ $publisher->phone }}</p>

    <h6 class="mb-4">{{ translate('Payout Info') }}</h6>
    <p>{{ translate('Bank Name') }} : {{ $publisher->bank_name ?? '' }}</p>
    <p>{{ translate('Bank Acc Name') }} : {{ $publisher->bank_acc_name ?? '' }}</p>
    <p>{{ translate('Bank Acc Number') }} : {{ $publisher->bank_acc_no ?? '' }}</p>
    <p>{{ translate('Bank Routing Number') }} : {{ $publisher->bank_routing_no ?? '' }}</p>

    <br>

    <div class="table-responsive">
        <table class="table table-striped mar-no">
            <tbody>
                <tr>
                    <td>{{ translate('Total Products') }}</td>
                    <td>{{ App\Models\Product::where('supplier_id', $publisher->id)->get()->count() }}</td>
                </tr>
                <tr>
                    <td>{{ translate('Total Orders') }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>{{ translate('Total Sold Amount') }}</td>

                    <td></td>
                </tr>
                <tr>
                    <td>{{ translate('Wallet Balance') }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
