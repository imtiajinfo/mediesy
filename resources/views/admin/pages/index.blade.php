 @extends('layouts.admin')
 @section('title', 'Admin | Pages')
 @section('content')
 <div class="aiz-titlebar text-left mt-2 mb-3">
     <div class="row align-items-center">
         <div class="col">
             <h1 class="h3"> Website Pages </h1>
         </div>
     </div>
 </div>

 <div class="card">
     <div class="card-header">
         <h6 class="mb-0 fw-600"> All Pages </h6>
         <a href="{{ route('admin.custom-pages.create') }}" class="btn btn-primary"> Add New Page </a>
     </div>
     <div class="card-body">
         <table class="table aiz-table mb-0">
             <thead>
                 <tr>
                     <th data-breakpoints="lg">#</th>
                     <th> Name </th>
                     <th data-breakpoints="md"> URL</th>
                     <th class="text-right"> Actions </th>
                 </tr>
             </thead>
             <tbody>
                 @foreach (\App\Models\Page::all() as $key => $page)
                 <tr>
                     <td>{{ $key+1 }}</td>

                     @if($page->type == 'home_page')
                     <td><a href="{{ route('admin.custom-pages.show', $page->slug) }}" class="text-reset">{{ $page->title }}</a></td>
                     <td>{{ route('admin.dashboard') }}</td>
                     @else
                     <td><a href="{{ route('admin.custom-pages.show', $page->slug) }}" class="text-reset">{{ $page->title }}</a></td>
                     <td>{{ route('admin.dashboard') }}/{{ $page->slug }}</td>
                     @endif

                     <td class="text-right">
                         @if($page->type == 'home_page')
                         <a href="{{route('admin.custom-pages.edit', $page->slug,)}}" class="btn btn-icon btn-circle btn-sm btn-soft-primary" title="Edit">
                             <i class="fas fa-pen"></i>
                         </a>
                         @else
                         <a href="{{route('admin.custom-pages.edit', $page->slug )}}" class="btn btn-icon btn-circle btn-sm btn-soft-primary" title="Edit">
                             <i class="fas fa-pen"></i>
                         </a>
                         @endif
                         @if($page->type == 'custom_page')
                         <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{ route('admin.custom-pages.destroy', $page->id)}}" title="Delete">
                             <i class="fas fa-trash"></i>
                         </a>
                         @endif
                     </td>
                 </tr>
                 @endforeach
             </tbody>
         </table>
     </div>
 </div>
 @endsection
