<div class="row print-show" style="display: none">
    <div class="col-xs-12">
        <h6 class="page-header fw-bold text-center">
            <h3 class="text-center pt-2 mb-1"><span style="color:darkorange">Spa</span> Superette </h3>
        </h6>
        <p class="text-center text-md mb-2">House:1380, Tlebebe Section<br>Luka, Rustenburg<br> Phone number :0611252082
        </p>
        @if( !empty($report_name) )
            <h6 class="text-center fw-bold mt-0"  style="font-size: medium">
                {{ $report_name }}
            </h6>
        @endif
        <p class="m-0 text-center mb-4">Quarter : {{ date('F, Y', $to_date) }} ({{ date('d F, Y', $from_date) }} - {{ date('d F, Y', $to_date) }})</p>
    </div>
</div>