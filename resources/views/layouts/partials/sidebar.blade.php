  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="z-index:10000 !important">
      <style>
          .parent .nav-icon {
              font-size: 17px !important;
              color: #e6e6e6
          }

      </style>
      <!-- Brand Logo -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center border-bottom border-dark justify-content-center">
          <div class="image">
            <h4><span style="color:darkorange">Medicine</span>Store</h4>
          </div>
      </div>
      <!-- Sidebar -->
      <div class="sidebar mt-0">
          <div class="form-inline mb-2 mt-0">
              {{-- <div class="input-group bg-transparent" data-widget="sidebar-search">
                  <input class="form-control form-control-sidebar bg-transparent" type="search" placeholder="Search" aria-label="Search">
                  <div class="input-group-append">
                      <button class="btn btn-sidebar bg-transparent">
                          <i class="fas fa-search fa-fw"></i>
                      </button>
                  </div>
              </div> --}}
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
                          <p class="fw-bold">
                              Dashboard
                          </p>
                      </a>
                  </li>



                  <li class="nav-item @if(request()->is('admin/categories*') || request()->is('admin/brands*') || request()->is('admin/colors*') || request()->is('admin/uoms*') || request()->is('admin/sizes*') || request()->is('admin/uoms*')) menu-is-opening menu-open @endif">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-table"></i>
                          <p class="fw-bold">
                              Master Setup
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview" @if(request()->is('admin/categories*') || request()->is('admin/brands*') || request()->is('admin/colors*') || request()->is('admin/uoms*') || request()->is('admin/sizes*') || request()->is('admin/uoms*'))@else style="display: none;" @endif>

                            <li class="nav-item">
                                <a href="{{ url('admin/categories') }}" class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
                                    <i @if(request()->is('admin/categories*'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                    <p @if(request()->is('admin/categories*'))style="color:#e9a409e6"@endif>
                                        Categories List
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('admin/brands') }}" class="nav-link {{ request()->is('admin/brands*') ? 'active' : '' }}">
                                    <i @if(request()->is('admin/brands*'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                    <p @if(request()->is('admin/brands*'))style="color:#e9a409e6"@endif>
                                        Brands List
                                    </p>
                                </a>
                            </li>

                            {{-- <li class="nav-item">
                                <a href="{{ url('admin/colors') }}" class="nav-link {{ request()->is('admin/colors*') ? 'active' : '' }}">
                                    <i @if(request()->is('admin/colors*'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                    <p @if(request()->is('admin/colors*'))style="color:#e9a409e6"@endif>
                                        Colors List
                                    </p>
                                </a>
                            </li> --}}

                            {{-- <li class="nav-item">
                                <a href="{{ url('admin/sizes') }}" class="nav-link {{ request()->is('admin/sizes*') ? 'active' : '' }}">
                                    <i @if(request()->is('admin/sizes*'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                    <p @if(request()->is('admin/sizes*'))style="color:#e9a409e6"@endif>
                                        Sizes List
                                    </p>
                                </a>
                            </li> --}}

                            <li class="nav-item">
                                <a href="{{ url('admin/uoms') }}" class="nav-link {{ request()->is('admin/uoms*') ? 'active' : '' }}">
                                    <i @if(request()->is('admin/uoms*'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                    <p @if(request()->is('admin/uoms*'))style="color:#e9a409e6"@endif>
                                        Unit List
                                    </p>
                                </a>
                            </li>
    
                        </li>
                      </ul>
                  </li>

                  <li class="nav-item @if(request()->is('admin/products*')) menu-is-opening menu-open @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p class="fw-bolder">
                            Products
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" @if(request()->is('admin/products*'))@else style="display: none;"@endif>

                        <li class="nav-item">
                            <a href="{{ url('admin/products') }}" class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}">
                                <i @if(request()->is('admin/products'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                <p @if(request()->is('admin/products'))style="color:#e9a409e6"@endif>
                                    Products List
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('admin/products/create') }}" class="nav-link {{ request()->is('admin/products/create') ? 'active' : '' }}">
                                <i @if(request()->is('admin/products/create'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                <p @if(request()->is('admin/products/create'))style="color:#e9a409e6"@endif>
                                    New Products
                                </p>
                            </a>
                        </li>

                    </ul>
                </li>


                  <li class="nav-item @if(request()->is('admin/sales*') || request()->is('admin/service-sales*') || request()->is('admin/sales-return*')) menu-is-opening menu-open @endif">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-table"></i>
                          <p class="fw-bold">
                              Sales
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview" @if(request()->is('admin/sales*')  || request()->is('admin/service-sales*') || request()->is('admin/sales-return*')) menu-is-opening menu-open @else style="display: none;"  @endif>
                          {{-- <li class="nav-item">
                              <a href="{{ url('admin/sales') }}" class="nav-link {{ request()->is('admin/sales*') ? 'active' : '' }}">
                                  <i class="nav-icon fa-solid fa-angles-right"></i>
                                  <p>
                                      POS Sales List
                                  </p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ url('admin/sales/create') }}" class="nav-link {{ request()->is('admin/sales/create') ? 'active' : '' }}">
                                  <i class="nav-icon fa-solid fa-angles-right"></i>
                                  <p>
                                      New POS Sales
                                  </p>
                              </a>
                          </li> --}}

                          <li class="nav-item">
                              <a href="{{ url('admin/service-sales') }}" class="nav-link {{ request()->is('admin/service-sales*') ? 'active' : '' }}">
                                  <i @if(request()->is('admin/service-sales'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                  <p @if(request()->is('admin/service-sales'))style="color:#e9a409e6"@endif>
                                    Sales List
                                  </p>
                              </a>
                          </li>

                          <li class="nav-item">
                              <a href="{{ url('admin/service-sales/create') }}" class="nav-link {{ request()->is('admin/service-sales/create') ? 'active' : '' }}">
                                  <i @if(request()->is('admin/service-sales/create'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                  <p @if(request()->is('admin/service-sales/create'))style="color:#e9a409e6"@endif>
                                      New Sales
                                  </p>
                              </a>
                          </li>

                          <li class="nav-item">
                              <a href="{{ route('admin.sales-return.index') }}" class="nav-link {{ request()->is('admin/sales-return*') ? 'active' : '' }}">
                                  <i @if(request()->is('admin/sales-return*'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                  <p @if(request()->is('admin/sales-return*'))style="color:#e9a409e6"@endif>
                                      Sales Return
                                  </p>
                              </a>
                          </li>
                      </ul>
                  </li>


                  {{-- <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-table"></i>
                          <p class="fw-bolder">
                              Warranty
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview" style="display: none;">

                          <li class="nav-item">
                              <a href="{{ url('admin/warrantys') }}" class="nav-link {{ request()->is('admin/warrantys *') ? 'active' : '' }}">
                                  <i class="nav-icon fa-solid fa-angles-right"></i>
                                  <p>
                                      Warranty List
                                  </p>
                              </a>
                          </li>

                          <li class="nav-item">
                              <a href="{{ url('admin/warrantys/create') }}" class="nav-link {{ request()->is('admin/warrantys/create') ? 'active' : '' }}">
                                  <i class="nav-icon fa-solid fa-angles-right"></i>
                                  <p>
                                      New Warranty
                                  </p>
                              </a>
                          </li>

                      </ul>
                  </li> --}}

                  {{-- <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-table"></i>
                          <p class="fw-bolder">
                              Opening Balance
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview" style="display: none;">

                          <li class="nav-item">
                              <a href="{{ url('admin/opening-balance') }}" class="nav-link {{ request()->is('admin/opening-balance*') ? 'active' : '' }}">
                                  <i class="nav-icon fa-solid fa-angles-right"></i>
                                  <p>
                                      Opening Balance List
                                  </p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ url('admin/opening-balance/create') }}" class="nav-link {{ request()->is('admin/opening-balance/create') ? 'active' : '' }}">
                                  <i class="nav-icon fa-solid fa-angles-right"></i>
                                  <p>
                                      New Opening Balance
                                  </p>
                              </a>
                          </li>

                      </ul>
                  </li> --}}
 

                  <li class="nav-item @if(request()->is('admin/purchase-orders*') || request()->is('admin/purchase-return*')) menu-is-opening menu-open @endif">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-table"></i>
                          <p class="fw-bolder">
                              Purchase
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview" @if(request()->is('admin/purchase-orders*') || request()->is('admin/purchase-return*'))@else style="display: none;"@endif>
                          <li class="nav-item">
                              <a href="{{ url('admin/purchase-orders') }}" class="nav-link {{ request()->is('admin/purchase-orders*') ? 'active' : '' }}">
                                  <i @if(request()->is('admin/purchase-orders'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                  <p @if(request()->is('admin/purchase-orders'))style="color:#e9a409e6"@endif>
                                      Purchase List
                                  </p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ url('admin/purchase-orders/create') }}" class="nav-link {{ request()->is('admin/purchase-orders/create') ? 'active' : '' }}">
                                  <i @if(request()->is('admin/purchase-orders/create'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                  <p @if(request()->is('admin/purchase-orders/create'))style="color:#e9a409e6"@endif>
                                      New Purchase
                                  </p>
                              </a>
                          </li>

                          <li class="nav-item">
                              <a href="{{ route('admin.purchase-return.index') }}" class="nav-link {{ request()->is('admin/purchase-return*') ? 'active' : '' }}">
                                  <i @if(request()->is('admin/purchase-return*'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                  <p @if(request()->is('admin/purchase-return*'))style="color:#e9a409e6"@endif>
                                      Purchase Return
                                  </p>
                              </a>
                          </li>

                      </ul>
                  </li>

                  <li class="nav-item @if(request()->is('admin/expenses*') || request()->is('admin/daily-expenses*')) menu-is-opening menu-open @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p class="fw-bolder">
                            Expenses
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" @if(request()->is('admin/expenses*') || request()->is('admin/daily-expenses*'))@else style="display: none;" @endif>
                        <li class="nav-item">
                            <a href="{{ url('admin/expenses') }}" class="nav-link">
                                <i @if(request()->is('admin/expenses'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                <p @if(request()->is('admin/expenses'))style="color:#e9a409e6"@endif>
                                    Expenses Category List
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('admin/daily-expenses') }}" class="nav-link">
                                <i @if(request()->is('admin/daily-expenses'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                <p @if(request()->is('admin/daily-expenses'))style="color:#e9a409e6"@endif>
                                    Daily Expenses List
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('admin/daily-expenses/create') }}" class="nav-link">
                                <i @if(request()->is('admin/daily-expenses/create'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                <p @if(request()->is('admin/daily-expenses/create'))style="color:#e9a409e6"@endif>
                                    New expenses
                                </p>
                            </a>
                        </li>

                    </ul>
                </li>


                  {{-- <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-table"></i>
                          <p class="fw-bolder">
                              Stores
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview" style="display: none;">
                          <li class="nav-item">
                              <a href="{{ url('admin/stores') }}" class="nav-link {{ request()->is('admin/stores*') ? 'active' : '' }}">
                                  <i class="nav-icon fa-solid fa-angles-right"></i>
                                  <p>
                                      Stores List
                                  </p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ url('admin/stores/create') }}" class="nav-link {{ request()->is('admin/stores/create') ? 'active' : '' }}">
                                  <i class="nav-icon fa-solid fa-angles-right"></i>
                                  <p>
                                      New Store
                                  </p>
                              </a>
                          </li>

                      </ul>
                  </li> --}}

                  {{-- <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-table"></i>
                          <p class="fw-bolder">
                              Items Store Mapping
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview" style="display: none;">
                          <li class="nav-item">
                              <a href="{{ url('admin/itemsStoreMapping') }}" class="nav-link {{ request()->is('admin/itemsStoreMapping*') ? 'active' : '' }}">
                                  <i class="nav-icon fa-solid fa-angles-right"></i>
                                  <p>
                                      Items Store Mapping List
                                  </p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ url('admin/itemsStoreMapping/create') }}" class="nav-link {{ request()->is('admin/itemsStoreMapping/create') ? 'active' : '' }}">
                                  <i class="nav-icon fa-solid fa-angles-right"></i>
                                  <p>
                                      New Items Store Mapping
                                  </p>
                              </a>
                          </li>

                      </ul>
                  </li> --}}

                  {{-- <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-table"></i>
                          <p class="fw-bolder">
                              Items Store & Stock
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview" style="display: none;">
                          <li class="nav-item">
                              <a href="{{ url('admin/item-store') }}" class="nav-link {{ request()->is('admin/item-store*') ? 'active' : '' }}">
                                  <i class="nav-icon fa-solid fa-angles-right"></i>
                                  <p>
                                      Items Store & Stock
                                  </p>
                              </a>
                          </li>

                      </ul>
                  </li> --}}


                  {{-- <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-table"></i>
                          <p class="fw-bolder">
                              Employees
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview" style="display: none;">
                          <li class="nav-item">
                              <a href="{{ url('admin/employees') }}" class="nav-link {{ request()->is('admin/employees*') ? 'active' : '' }}">
                                  <i class="nav-icon fa-solid fa-angles-right"></i>
                                  <p>
                                      Employees List
                                  </p>
                              </a>
                          </li>

                          <li class="nav-item">
                              <a href="{{ url('admin/employees/create') }}" class="nav-link {{ request()->is('admin/employees/create') ? 'active' : '' }}">
                                  <i class="nav-icon fa-solid fa-angles-right"></i>
                                  <p>
                                      New Employees
                                  </p>
                              </a>
                          </li>

                      </ul>
                  </li> --}}


                  <li class="nav-item @if(request()->is('admin/suppliers*')) menu-is-opening menu-open @endif">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-table"></i>
                          <p class="fw-bolder">
                              Suppliers
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview" @if(request()->is('admin/suppliers*'))@else style="display: none;" @endif>
                          <li class="nav-item">
                              <a href="{{ url('admin/suppliers') }}" class="nav-link {{ request()->is('admin/suppliers*') ? 'active' : '' }}">
                                  <i @if(request()->is('admin/suppliers'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                  <p @if(request()->is('admin/suppliers'))style="color:#e9a409e6"@endif>
                                      Suppliers List
                                  </p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ url('admin/suppliers/create') }}" class="nav-link {{ request()->is('admin/suppliers/create') ? 'active' : '' }}">
                                  <i @if(request()->is('admin/suppliers/create'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                  <p @if(request()->is('admin/suppliers/create'))style="color:#e9a409e6"@endif>
                                      New Suppliers
                                  </p>
                              </a>
                          </li>

                      </ul>
                  </li>


                  <li class="nav-item @if(request()->is('admin/customers*')) menu-is-opening menu-open @endif">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-table"></i>
                          <p class="fw-bolder">
                              Customers
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview" @if(request()->is('admin/customers*'))@else style="display: none;" @endif>

                          <li class="nav-item">
                              <a href="{{ url('admin/customers') }}" class="nav-link {{ request()->is('admin/customers*') ? 'active' : '' }}">
                                  <i @if(request()->is('admin/customers'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                  <p @if(request()->is('admin/customers'))style="color:#e9a409e6"@endif>
                                      Customers List
                                  </p>
                              </a>
                          </li>

                          <li class="nav-item">
                              <a href="{{ url('admin/customers/create') }}" class="nav-link {{ request()->is('admin/customers/create') ? 'active' : '' }}">
                                  <i @if(request()->is('admin/customers/create'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                  <p @if(request()->is('admin/customers/create'))style="color:#e9a409e6"@endif>
                                      New Customers
                                  </p>
                              </a>
                          </li>

                      </ul>
                  </li>


                  {{-- <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-table"></i>
                          <p class="fw-bolder">
                              BankInfo
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview" style="display: none;">
                          <li class="nav-item">
                              <a href="{{ url('admin/bankInfo') }}" class="nav-link {{ request()->is('admin/bankInfo*') ? 'active' : '' }}">
                                  <i class="nav-icon fa-solid fa-angles-right"></i>
                                  <p>
                                      BankInfo List
                                  </p>
                              </a>
                          </li>


                          <li class="nav-item">
                              <a href="{{ url('admin/bankInfo/create') }}" class="nav-link {{ request()->is('admin/bankInfo/create') ? 'active' : '' }}">
                                  <i class="nav-icon fa-solid fa-angles-right"></i>
                                  <p>
                                      New BankInfo
                                  </p>
                              </a>
                          </li>


                      </ul>
                  </li> --}}

                  {{-- <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-table"></i>
                          <p class="fw-bolder">
                              Barcode
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview" style="display: none;">

                          <li class="nav-item">
                              <a href="{{ url('admin/product/barcode/create') }}" class="nav-link {{ request()->is('admin/product/barcode*') ? 'active' : '' }}">
                                  <i class="nav-icon fa-solid fa-angles-right"></i>
                                  <p>
                                      New Barcode Generate
                                  </p>
                              </a>
                          </li>


                      </ul>
                  </li> --}}

                  <li class="nav-item mb-5 @if(request()->is('admin/report*')) menu-is-opening menu-open @endif">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-table"></i>
                          <p class="fw-bolder">
                              Reports
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview" @if(request()->is('admin/report*'))@else style="display: none;" @endif>
                            {{-- 
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
                          </li> --}}

                          {{-- <li class="nav-item">
                              <a href="{{ url('admin/mothlyProfitLoss') }}" class="nav-link {{ request()->is('admin/mothlyProfitLoss*') ? 'active' : '' }}">
                                  <i class="nav-icon fa-solid fa-angles-right"></i>
                                  <p>
                                      Mothly Profit/Loss Reort
                                  </p>
                              </a>
                          </li> --}}

                          
                            <li class="nav-item">
                                <a href="{{ route('admin.reports.purchase.ledger') }}" class="nav-link {{ request()->is('admin/report/purchase-ledger*') ? 'active' : '' }}">
                                    <i @if(request()->is('admin/report/purchase-ledger*'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                    <p @if(request()->is('admin/report/purchase-ledger*'))style="color:#e9a409e6"@endif>
                                        Purchase Ledger
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.reports.sells.ledger') }}" class="nav-link {{ request()->is('admin/report/sells-ledger*') ? 'active' : '' }}">
                                    <i @if(request()->is('admin/report/sells-ledger*'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                    <p @if(request()->is('admin/report/sells-ledger*'))style="color:#e9a409e6"@endif>
                                        Sells Ledger
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.reports.stock.ledger') }}" class="nav-link {{ request()->is('admin/report/stock-ledger*') ? 'active' : '' }}">
                                    <i @if(request()->is('admin/report/stock-ledger*'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                    <p @if(request()->is('admin/report/stock-ledger*'))style="color:#e9a409e6"@endif>
                                        Stock Ledger
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.reports.expense') }}" class="nav-link {{ request()->is('admin/report/expense*') ? 'active' : '' }}">
                                    <i @if(request()->is('admin/report/expense*'))style="color:#e9a409e6"@endif class="nav-icon fa-solid fa-angles-right"></i>
                                    <p @if(request()->is('admin/report/expense*'))style="color:#e9a409e6"@endif>
                                        Expense Report
                                    </p>
                                </a>
                            </li>

                      </ul>
                  </li>



              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
