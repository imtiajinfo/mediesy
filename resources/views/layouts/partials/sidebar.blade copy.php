  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="z-index:10000 !important">
      <style>
          .parent .nav-icon {
              font-size: 17px !important;
              color: #e6e6e6
          }

      </style>
      <!-- Brand Logo -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center border-bottom border-dark">
          <div class="image">

              <img src="{{ asset('backend/dist/img/dms.png') }}" class="img" alt="User Image" style="height: 44px; width:auto;">
          </div>
      </div>
      <!-- Sidebar -->
      <div class="sidebar mt-0">
          <div class="form-inline mb-4 mt-0">
              <div class="input-group bg-transparent" data-widget="sidebar-search">
                  <input class="form-control form-control-sidebar bg-transparent" type="search" placeholder="Search" aria-label="Search">
                  <div class="input-group-append">
                      <button class="btn btn-sidebar bg-transparent">
                          <i class="fas fa-search fa-fw"></i>
                      </button>
                  </div>
              </div>
              <div class="sidebar-search-results">
                  <div class="list-group"><a href="#" class="list-group-item">
                          <div class="search-title"><strong class="text-light">
                              </strong>N<strong class="text-light"></strong>
                              o<strong class="text-light"></strong> <strong class="text-light"></strong>e
                              <strong class="text-light"></strong>l<strong class="text-light"></strong>e<strong class="text-light">
                              </strong>m<strong class="text-light"></strong>e<strong class="text-light"></strong>n
                              <strong class="text-light"></strong>t<strong class="text-light"></strong>
                              <strong class="text-light"></strong>f<strong class="text-light"></strong>o
                              <strong class="text-light"></strong>u<strong class="text-light"></strong>n
                              <strong class="text-light"></strong>d<strong class="text-light"></strong>
                              !<strong class="text-light"></strong>
                          </div>
                          <div class="search-path"></div>
                      </a></div>
              </div>
          </div>
          <style>
              .nav-item a p {
                  font-size: 13px !important;
                  color: #f6f6f6;
              }

          </style>
          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column nav-collapse-hide-child nav-child-indent nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
                  <li class="nav-item">
                      <a href="{{ url('admin/dashboard') }}" class="parent nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Dashboard
                          </p>
                      </a>
                  </li>




                  {{-- inventory --}}
                  <li class="nav-item">
                      <a href="#" class="nav-link parent">
                          <i class="nav-icon fa-solid fa-warehouse"></i>
                          <p class="fw-bold">
                              Inventoty
                              <i class="fa-solid fa-arrow-turn-down right"></i>
                          </p>
                      </a>
                  </li>
                  <hr class="mt-1">



                  <li class="nav-item">
                      <a href="{{ url('admin/sales') }}" class="nav-link {{ request()->is('admin/sales*') ? 'active' : '' }}">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              Product Sales
                          </p>
                      </a>
                  </li>


                  <li class="nav-item">
                      <a href="{{ url('admin/service-sales') }}" class="nav-link {{ request()->is('admin/service-sales*') ? 'active' : '' }}">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              Service Sales
                          </p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="{{ url('admin/warrantys ') }}" class="nav-link {{ request()->is('admin/warrantys *') ? 'active' : '' }}">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              Warranty
                          </p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="{{ url('admin/opening-balance') }}" class="nav-link {{ request()->is('admin/opening-balance*') ? 'active' : '' }}">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              Opening Balance
                          </p>
                      </a>
                  </li>


                  <li class="nav-item">
                      <a href="{{ url('admin/daily-expenses') }}" class="nav-link">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              daily-expenses
                          </p>
                      </a>
                  </li>





                  <li class="nav-item">
                      <a href="#" class="nav-link parent">
                          <i class="nav-icon  fa-solid fa-arrow-trend-up"></i>
                          <p class="fw-bold">
                              Manage Purchase Order
                              <i class="fa-solid fa-arrow-turn-down right"></i>
                          </p>
                      </a>
                  </li>
                  <hr class="mt-1">

                  <li class="nav-item">
                      <a href="{{ url('admin/purchase-orders') }}" class="nav-link {{ request()->is('admin/purchase-orders*') ? 'active' : '' }}">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              Purchase Orders
                          </p>
                      </a>
                  </li>








                  {{-- company setup --}}
                  <li class="nav-item mt-3">
                      <a href="#" class="nav-link parent">
                          <i class="nav-icon fa-solid fa-screwdriver-wrench"></i>
                          <p class="fw-bold">
                              Company Setup
                              <i class="fa-solid fa-arrow-turn-down right"></i>
                          </p>
                      </a>
                  </li>
                  <hr class="mt-1">


                  <li class="nav-item">
                      <a href="{{ url('admin/stores') }}" class="nav-link {{ request()->is('admin/stores*') ? 'active' : '' }}">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              Manage Stores
                          </p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="{{ url('admin/itemsStoreMapping') }}" class="nav-link {{ request()->is('admin/itemsStoreMapping*') ? 'active' : '' }}">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              Items Store Mapping
                          </p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="{{ url('admin/item-store') }}" class="nav-link {{ request()->is('admin/item-store*') ? 'active' : '' }}">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              Items Store & Stock
                          </p>
                      </a>
                  </li>


                  <li class="nav-item">
                      <a href="{{ url('admin/employees') }}" class="nav-link {{ request()->is('admin/employees*') ? 'active' : '' }}">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              Manage Employees
                          </p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="{{ url('admin/suppliers') }}" class="nav-link {{ request()->is('admin/suppliers*') ? 'active' : '' }}">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              Manage Suppliers
                          </p>
                      </a>
                  </li>




                  <li class="nav-item">
                      <a href="{{ url('admin/customers') }}" class="nav-link {{ request()->is('admin/customers*') ? 'active' : '' }}">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              Manage Customers
                          </p>
                      </a>
                  </li>


                  <li class="nav-item">
                      <a href="{{ url('admin/bankInfo') }}" class="nav-link {{ request()->is('admin/bankInfo*') ? 'active' : '' }}">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              BankInfo
                          </p>
                      </a>
                  </li>

                  {{-- <li class="nav-item">
                          <a href="{{ url('admin/store') }}" class="nav-link">
                  <i class="fa-solid fa-list-check"></i>
                  <p>
                      Manage Store
                  </p>
                  </a>
                  </li>

                  <li class="nav-item">
                      <a href="{{ url('admin/discount-decleare') }}" class="nav-link">
                          <i class="fa-solid fa-list-check"></i>
                          <p>
                              Discount Declearations
                          </p>
                      </a>
                  </li> --}}

                  {{-- <li class="nav-item">
                          <a href="{{ url('admin/employee') }}" class="nav-link">
                  <i class="fa-solid fa-list-check"></i>
                  <p>
                      Manage Employee
                  </p>
                  </a>
                  </li> --}}


                  <li class="nav-item">
                      <a href="{{ url('admin/expenses') }}" class="nav-link">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              Manage Expenses
                          </p>
                      </a>
                  </li>


                  {{-- <li class="nav-item">
                  <a href="{{ url('admin/users') }}" class="nav-link">
                  <i class="nav-icon fa-solid fa-angles-right"></i>
                  <p>
                      Users
                  </p>
                  </a>
                  </li>

                  <li class="nav-item">
                      <a href="{{ url('admin/roles') }}" class="nav-link">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              Roles
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ url('admin/permissions') }}" class="nav-link">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              Permissions
                          </p>
                      </a>
                  </li> --}}











                  {{-- housekeeping --}}
                  <li class="nav-item mt-3">
                      <a href="#" class="nav-link parent">
                          <i class="nav-icon fa-solid fa-house-laptop"></i>
                          <p class="fw-bold">
                              House keeping
                              <i class="fa-solid fa-arrow-turn-down right"></i>
                          </p>
                      </a>

                  </li>
                  <hr class="mt-1">

                  <li class="nav-item">
                      <a href="{{ url('admin/categories') }}" class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
                          {{-- <i class="nav-icon fa-solid fa-angles-right"></i> --}}
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              Manage Categories
                          </p>
                      </a>
                  </li>


                  <li class="nav-item">
                      <a href="{{ url('admin/brands') }}" class="nav-link {{ request()->is('admin/brands*') ? 'active' : '' }}">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              Manage Brands
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ url('admin/uoms') }}" class="nav-link {{ request()->is('admin/uoms*') ? 'active' : '' }}">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              Manage UOM
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ url('admin/sizes') }}" class="nav-link {{ request()->is('admin/sizes*') ? 'active' : '' }}">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              Manage Sizes
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ url('admin/colors') }}" class="nav-link {{ request()->is('admin/colors*') ? 'active' : '' }}">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              Manage Colors
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ url('admin/products') }}" class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              Manage Products
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ url('admin/product/barcode/create') }}" class="nav-link {{ request()->is('admin/product/barcode*') ? 'active' : '' }}">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              Barcode Generate
                          </p>
                      </a>
                  </li>








                  {{-- <li class="nav-item">
                              <a href="{{ url('admin/categories') }}"
                  class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
                  <i class="fa-solid fa-list-check"></i>
                  <p>
                      Product Category
                  </p>
                  </a>
                  </li> --}}

                  {{-- <li class="nav-item">
                              <a href="{{ url('admin/brand') }}" class="nav-link">
                  <i class="fa-solid fa-list-check"></i>
                  <p>
                      Product Brand
                  </p>
                  </a>
                  </li> --}}
                  {{-- <li class="nav-item">
                              <a href="{{ url('admin/color') }}" class="nav-link">
                  <i class="fa-solid fa-list-check"></i>
                  <p>
                      Product Color
                  </p>
                  </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ url('admin/size') }}" class="nav-link">
                          <i class="fa-solid fa-list-check"></i>
                          <p>
                              Product Size
                          </p>
                      </a>
                  </li> --}}


                  {{-- <li class="nav-item">
                              <a href="{{ url('admin/uom/set') }}" class="nav-link">
                  <i class="fa-solid fa-list-check"></i>
                  <p>
                      Product Unit Set
                  </p>
                  </a>
                  </li> --}}

                  {{-- <li class="nav-item">
                              <a href="{{ url('admin/uom') }}" class="nav-link">
                  <i class="fa-solid fa-list-check"></i>
                  <p>
                      Product Unit
                  </p>
                  </a>
                  </li> --}}

                  {{--
                          <li class="nav-item">
                              <a href="{{ url('admin/products') }}" class="nav-link">
                  <i class="fa-solid fa-list-check"></i>
                  <p>
                      Manage Products
                  </p>
                  </a>
                  </li> --}}

















                  <li class="nav-item">
                      <a href="#" class="nav-link parent">
                          <i class="nav-icon fa-solid fa-calculator"></i>
                          <p class="fw-bold">
                              Reports
                              <i class="fa-solid fa-arrow-turn-down right"></i>
                          </p>
                      </a>
                  </li>
                  <hr class="mt-1">

                  <li class="nav-item">
                      <a href="{{ url('admin/transactions-detailed-by-customer') }}" class="nav-link {{ request()->is('admin/transactions-detailed-by-customer*') ? 'active' : '' }}">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              transactions-detailed-by-customer
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ url('admin/transactions-detailed-by-supplier') }}" class="nav-link {{ request()->is('admin/transactions-detailed-by-supplier*') ? 'active' : '' }}">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              transactions-detailed-by-supplier
                          </p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="{{ url('admin/mothlyProfitLoss') }}" class="nav-link {{ request()->is('admin/mothlyProfitLoss*') ? 'active' : '' }}">
                          <i class="nav-icon fa-solid fa-angles-right"></i>
                          <p>
                              Mothly Profit/Loss Reort
                          </p>
                      </a>
                  </li>

                  {{-- <li class="nav-item">
                  <a href="{{ url('admin/moneyLending') }}" class="nav-link {{ request()->is('admin/moneyLending*') ? 'active' : '' }}">
                  <i class="nav-icon fa-solid fa-angles-right"></i>
                  <p>
                      Money Lending Report
                  </p>
                  </a>
                  </li> --}}




              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
