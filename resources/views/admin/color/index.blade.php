  @extends('layouts.admin')
  @section('title', 'Admin | Color')

  @section('page-headder')
  {{-- customers --}}
  @endsection


  @section('content')
  <div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
      <div class="col-sm-6">
          <span class="my-auto h6 page-headder">@yield('page-headder')</span>
          <ol class="breadcrumb bg-white">
              <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i> </a></li>
              <li class="breadcrumb-item text-dark px-2"><a href="{{ route('admin.colors.index') }}"> Color</a>
              </li>
          </ol>
      </div>
      <div class="col-md-6">
          <ol class="float-right button">
              <a href="{{ route('admin.colors.create') }}" class="btn btn-success" rel="tooltip" id="add" title="add">
                  Add New Color
              </a>
          </ol>
      </div>
  </div>

  <div class="row">
      <div class="col-12 p-0">
          <div class="card">
              <div class="card-header justify-content-between py-3">
                  <h4 class="card-title float-left pt-2">All Color</h4>

                  <div class="float-right d-flex my-auto gap-3">

                      <form class="mb-0 pb-0" id="sort_colors" action="" method="GET">
                          <div class="input-group py-0 my-0">
                              <input type="text" name="search" class="form-control" id="inputGroupFile02" placeholder="Search">
                              <button type="submit" class="btn btn-success input-group-text" for="inputGroupFile02"> <i class="fas fa-search"></i></button>
                          </div>
                      </form>
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body card-body p-0 table-responsive">
                  <table id="example1" class="table table-hover">
                      <thead>
                          <tr>
                              <th>SL</th>
                              <th>Name_english</th>
                              <th>Name_bangla</th>
                              <th>Code</th>
                              <th>Description</th>
                              <th>Status</th>
                              <th>Actions</th>
                          </tr>
                      </thead>
                      <tbody id="datatable">
                          @if (count($query) > 0)
                          @foreach ($query as $key => $data)
                          <tr>
                              <td>{{ $key+1 }}</td>
                              <td>{{$data->name_english }}</td>
                              <td>{{$data->name_bangla }}</td>
                              <td>{{$data->code }}
                                  <span class="px-4 py-2 mx-1" style="background:{{$data->code }};width:50px"></span>
                              </td>
                              <td>{{$data->description }}</td>
                              <td>
                                  @php
                                  $badgeClass = $data->status == 1 ? 'badge badge-success' : 'badge badge-danger';
                                  $statusText = $data->status == 1 ? 'Active' : 'In-Active';
                                  @endphp
                                  <span class="{{ $badgeClass }}">{{ $statusText }}</span>
                              </td>
                              <td style="min-width:130px" class="d-flex my-4">
                                  <a href="{{ route('admin.colors.edit', $data->id) }}" class="btn btn-primary btn-sm edit text-light border-0 edit" rel="tooltip" id="edit" title="Edit" data-id="4">
                                      <i class="fa-regular fa-pen-to-square"></i>
                                  </a>
                                  <a href="{{ route('admin.colors.show', $data->id) }}" class="btn btn-info btn-sm text-light view border-0 view" id="view" rel="tooltip" title="view">
                                      <i class="fas fa-eye"></i>
                                  </a>
                                  <form action="{{ route('admin.colors.destroy', $data->id) }}" method="POST" style="display: inline;">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="btn btn-sm btn-danger delete" onclick="return confirm('Are you sure?')"> <i class="fas fa-trash-can"></i></button>
                                  </form>
                              </td>
                          </tr>
                          @endforeach
                          @else
                          <tr class="h-50">
                              <td colspan="13">
                                  <h4 class="fs-4">No data found</h4>
                              </td>
                          </tr>
                          @endif

                      </tbody>
                  </table>

                  <div class="pt-4 pb-2 px-4">
                      <div class="pagination d-flex justify-content-between">
                          <!-- ... (previous content) -->
                          <div class="d-flex">
                              <!-- Your Blade file -->
                              <label for="per_page">Entries per Page:</label>
                              <select name="per_page" id="per_page" onchange="updateQueryString()">
                                  <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                  <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                  <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                                  <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                  <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                              </select>

                              <script>
                                  function updateQueryString() {
                                      var perPage = document.getElementById('per_page').value;
                                      var currentUrl = window.location.href;
                                      var url = new URL(currentUrl);
                                      var searchParams = new URLSearchParams(url.search);
                                      // Update or add the per_page parameter
                                      searchParams.set('per_page', perPage);
                                      // Redirect to the updated URL
                                      window.location.href = url.pathname + '?' + searchParams.toString();
                                  }


                                  // Function to fetch data and update the table body
                                  function fetchDataAndPopulateTable() {
                                      document.addEventListener('DOMContentLoaded', function() {
                                          const table = document.getElementById('datatable');
                                          const tableRow = table.querySelector('tr');

                                          // Display loading animation
                                          if (tableRow) {
                                              const loadingDiv =
                                                  '<div id="loading-animation1" style="display: block; font-size: 50px; height: 100px; padding: 100px;"><i class="fas fa-spinner fa-spin"></i></div>';
                                              tableRow.appendChild(loadingDiv);
                                              setTimeout(function() {

                                              }, 2000); // Adjust the time according to your needs
                                          }
                                      });


                                  }

                                  // Call the function when the page loads
                                  fetchDataAndPopulateTable();

                              </script>

                              <!-- Information about displayed entries -->
                              <div class="dataTables_info pl-2">
                                  Showing
                                  <span id="showing-entries-from">{{ $query->firstItem() }}</span>
                                  to
                                  <span id="showing-entries-to">{{ $query->lastItem() }}</span>
                                  of
                                  <span id="total-entries">{{ $query->total() }}</span>
                                  entries
                              </div>
                          </div>
                          <!-- ... (remaining content) -->
                          {{ $query->links('components.pagination.default') }}
                          {{-- {{ $query->appends(request()->except('page'))->links() }} --}}
                      </div>
                  </div>
              </div>
              <!-- /.card-body -->

          </div>
          <!-- /.card -->


      </div>
  </div>



  </div>
  <!-- /.col -->

  </div>
  <!-- /.content -->
  @endsection
