@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-headder')
{{-- Categories --}}
@endsection
@section('content')
<div class="row">

    <div class="col-lg-3 col-6">
        <div class="info-box bg-white">
            <span class="info-box-icon"> <i class="ion ion-pie-graph"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Sells</span>
                <span class="info-box-number">{{number_format($last_month_total_sell, 2)}}</span>

                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-desription">
                   <small>Total in Last 30 Days</small> 
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-lg-3 col-6">
        <div class="info-box bg-white">
            <span class="info-box-icon"><i class="far fa-bookmark"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Purchase Orders</span>
                <span class="info-box-number">{{number_format($last_month_total_purchase, 2)}}</span>

                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-desciption">
                   <small>Total in Last 30 Days</small> 
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="info-box bg-white">
            <span class="info-box-icon"><i class="fas fa-comments"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Expenses</span>
                <span class="info-box-number">{{number_format($last_month_total_expense, 2)}}</span>

                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-descripdtion">
                   <small>Total in Last 30 Days</small>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

   <!-- /.col -->
   <div class="col-lg-3 col-6">
       <div class="info-box bg-white">
           <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>

           <div class="info-box-content">
               <span class="info-box-text">Total Due</span>
               <span class="info-box-number">{{number_format(abs($last_month_total_due),2)}}</span>

               <div class="progress">
                   <div class="progress-bar" style="width: 70%"></div>
               </div>
               <span class="progress-descrition">
                  <small>Total Due</small>
               </span>
           </div>
           <!-- /.info-box-content -->
       </div>
       <!-- /.info-box -->
   </div>
   <!-- /.col -->

    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-white">
            <div class="inner">
                <h3>{{$total_product}}</h3>

                <p>Products</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="/admin/products" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-white">
            <div class="inner">
                <h3>{{$total_customer}}<sup style="font-size: 20px"></sup></h3>

                <p>Customers</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="/admin/customers" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-white">
            <div class="inner">
                <h3>{{$total_supplier}}</h3>

                <p>Suppliers</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="/admin/suppliers" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-white">
            <div class="inner">
                <h3>{{$sell_count}}</h3>

                <p>Today Sell Count</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="/admin/service-sales" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->

<!-- /.row (main row) -->
@endsection


@push('.js')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- ChartJS -->
<script src="{{ asset('backend/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('backend/dist/js/pages/dashboard.js') }}"></script>
<script src="{{ asset('backend/dist/js/pages/dashboard3.js') }}"></script>
@endpush
