@extends('backend.layouts.app')

@section('content')
<div class="mt-2 mb-3 text-left aiz-titlebar">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h6 class="mb-0">Payment To Publisher: (BB-13)</h6>
        </div>
        @can('view_publisher_payment_list')
        <div class="col-md-6 text-md-right">
            <a href="{{ route('admin.publisher_payment.index') }}" class="btn btn-sm btn-primary">
                <span> <i class="las la-bars"></i> List</span>
            </a>
        </div>
        @endcan
    </div>
</div>
<form action="{{ route('admin.publisher_payment.store') }}" method="post">
    @csrf
    <div class="card">
        <div class="card-header">
            <p class="mb-0">Payment to Publisher</p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="mb-3 col-md-4 col-lg-3">
                    <label for="">Payment ID</label>
                    <input type="text" class="form-control" value="<- - - - NEW - - - >" disabled>
                </div>
                <div class="mb-3 col-md-4 col-lg-3">
                    <label for="">Payment Date</label>
                    <input type="date" class="form-control" name="payment_date">
                </div>

                <div class="mb-3 col-md-4 col-lg-3">
                    <label for="">Publisher's Name</label>
                    <select name="publisher_id" id="publisher_id" class="form-control" data-live-search="true">
                        <option value="" disabled> - -select publisher - - </option>
                    </select>
                </div>


                <div class="mb-3 col-md-4 col-lg-3">
                    <label for="">Receive No</label>
                    <select name="recv_master_id" id="recv_master_id" class="form-control" onchange="fetchDataAndUpdateTable()">
                        <option value="" disabled> - -select recv - - </option>
                    </select>
                </div>

                <div class="mb-3 col-md-4 col-lg-3">
                    <label for="">Paid Amount</label>
                    <input type="number" readonly class="form-control" value="" id="paid_amount" name="paid_amount">
                </div>
                <div class="mb-3 col-md-4 col-lg-3">
                    <label for="">Remarks</label>
                    <input type="text" class="form-control" placeholder="remarks" name="remarks">
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3 card">
        <div class="card-header">
            <p class="mb-0">Receive information</p>
        </div>
        <div class="card-body">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>PO/GRN No</th>
                        <th>GRN Date</th>
                        <th>Amount(TK)</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th style="display:table-cell;vertical-align:middle" colspan="3" class="text-right"></th>

                        <th class="d-flex justify-content-between align-items-center" id="total_amount">
                            <div class="text-right">
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</form>

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function fetchPublisherData() {
        $.ajax({
            url: window.location.origin + "/admin/publisher_payment-init"
            , method: "GET"
            , dataType: "json"
            , success: function(response) {
                var selectElement = $("select[name='publisher_id']");
                selectElement.empty();
                selectElement.append($('<option>', {
                    value: ''
                    , text: ' -- Select Publisher -- '
                }));
                $.each(response, function(index, publisher) {
                    selectElement.append($('<option>', {
                        value: publisher.supplier_id
                        , text: publisher.name_bangla
                    }));
                });
            }
            , error: function(error) {
                console.error('Error fetching data: ', error);
            }
        });
    }

    function fetchDataAndUpdateTable() {
        var recvMasterId = $("select[name='recv_master_id']").val();

        if (recvMasterId) {
            $.ajax({
                url: window.location.origin + "/admin/publisher_payment-init?recv_master_id=" + recvMasterId
                , method: "GET"
                , dataType: "json"
                , success: function(response) {
                    updateTableWithData(response);
                }
                , error: function(error) {
                    console.error('Error fetching data: ', error);
                }
            });
        }
    }

    function updateTableWithData(data) {
        var tableBody = $("table.table tbody");
        tableBody.empty();

        var totalAmount = 0;
        $.each(data, function(index, rowData) {
            $.each(rowData.recv_master, function(innerIndex, innerRowData) {
                totalAmount += parseFloat(innerRowData.total_recv_amt_local_curr);
                var row = "<tr>" +
                    "<td>" + (index + 1) + "</td>" +
                    "<td>" + innerRowData.grn_number + "</td>" +
                    "<td>" + innerRowData.purchase_order_date + "</td>" +
                    "<td>" + innerRowData.total_recv_amt_local_curr + "</td>" +
                    "</tr>";
                tableBody.append(row);
            });
        });
        var paidAmount = totalAmount.toFixed(2);
        $("#paid_amount").val(paidAmount);
    }



    function fetchReceiveData(publisherId) {
        $.ajax({
            url: window.location.origin + "/admin/publisher_payment-init?publisher_id=" + publisherId
            , method: "GET"
            , dataType: "json"
            , success: function(response) {
                console.log(response[0].recv_master);
                var selectElement = $("select[name='recv_master_id']");
                selectElement.empty();
                selectElement.append($('<option>', {
                    value: ''
                    , text: ' -- Select Receive No -- '
                }));
                $.each(response[0].recv_master, function(index, receive) {
                    selectElement.append($('<option>', {
                        value: receive.recv_master_id
                        , text: receive.grn_number
                    }));
                });

                // Manually refresh the Bootstrap-select plugin
                // selectElement.selectpicker('refresh');
            }
            , error: function(error) {
                console.error('Error fetching data: ', error);
            }
        });
    }

    $(document).ready(function() {
        fetchPublisherData();
        $("select[name='publisher_id']").on('change', function() {
            var publisherId = $(this).val();
            fetchReceiveData(publisherId);
        });
    });

</script>
@endpush


@endsection
