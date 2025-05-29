<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Lilium Pos System')</title>
    <meta name="keywords" content="@yield('meta_keywords', 'some default keywords')">
    <meta name="title" content="@yield('meta_title', 'default meta title')">
    <meta name="description" content="@yield('meta_description', 'default description')">
    <link rel="canonical" href="{{ url()->current() }}" />

    <!-- Add the link to your icon file -->
    <link rel="icon" href="{{asset('backend/dist/img/app-icon.png')}}" type="image/png">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://unpkg.com/sweetalert@1.0.1/dist/sweetalert.css" />
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('backend/dist/css/custom-style.css') }}">

    <!-- Bootstrap Select CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" />
    <!-- Bootstrap-datepicker CSS and JavaScript -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- datepicker css  --}}
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">

    @stack('.css')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        {{-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="{{asset('backend/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
    </div> --}}


    @include('layouts.partials.navbar')
    @include('layouts.partials.sidebar')
    <style>
        body {
            font-family: "Popins", sans-serif;
        }
        .breadcrumb,
        .button,
        .page-headder {
            margin: auto !important;
        }
        a#view,
        #edit,
        #delete {
            width: 29px !important;
            height: 24px !important;
            padding: 2px !important;
        }
        table tr th:last-child,
        table tr td:last-child {
            text-align: center !important;
        }
        #delete {
            margin-right: 0px !important
        }
        #loaderContent {
            z-index: 10000;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .content,
        #loaderContent {
            transition: opacity 0.5s ease;
        }
        .content {
            opacity: 0;
        }
        #loaderContent {
            opacity: 1;
        }
        section.content {
            margin-top: 20px
        }
        .modal{
            z-index: 1000000 !important;
        }
        /* select 2 css  */
        .select2-selection{
            height: auto !important;
        }
        .select2-selection__arrow{
            height: 100% !important;
            padding: 15px;
            border-left: 1px solid #adadad;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple, .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #adadad;
        }
        .select2-selection__arrow{
            height: 100%;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: inherit !important;
        }
        .input-group-text{
            margin-left: 0px !important
        }
        .select2-container--default .select2-results__option[aria-selected=true] {
            font-size: smaller !important;
        }
        .select2-results__option[aria-selected] {
            font-size: smaller;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            font-size: small;
        }
        .select2-container--default .select2-selection--single {
            padding-left: 3px !important;
        }
        .input-danger{
            border: 1px solid #f00 !important;
            color: #f00 !important;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #aaa !important;
        }
        .required{
            color: #f00;
            font-weight: 700
        }
    </style>

    <div class="content-wrapper py-3">
        <div class="px-4">

            <section class="content">
                <div id="loaderContent">
                    <div class="spinner-border text-success" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>

                <div class="container-fluid">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if(session('error'))
                    <div class=" alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    @yield('content')
                </div>
            </section>
        </div>
    </div>
    @include('layouts.partials.footer')
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    </div>
    {!! Toastr::message() !!}
    {{-- loader --}}
    <script>
        document.onreadystatechange = function() {
            if (document.readyState !== "complete") {
                document.querySelector(".content").style.opacity = "0"; // Hide content
                document.querySelector("#loaderContent").style.opacity = "1"; // Show loader
            } else {
                document.querySelector("#loaderContent").style.opacity = "0"; // Hide loader
                document.querySelector(".content").style.opacity = "1"; // Show content
            }
        };

    </script>

    <!-- jQuery -->
    <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <!-- Summernote -->
    <script src="{{ asset('backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('backend/dist/js/adminlte.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('backend/plugins/toastr/toastr.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{asset('backend/dist/js/bootstrap-multiselect.js')}}"></script>
    <!-- Include Axios via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        var toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
        var currentTheme = localStorage.getItem('theme');
        var mainHeader = document.querySelector('.main-header');

        if (currentTheme) {
            if (currentTheme === 'dark') {
                if (!document.body.classList.contains('dark-mode')) {
                    document.body.classList.add("dark-mode");
                }
                if (mainHeader.classList.contains('navbar-light')) {
                    mainHeader.classList.add('navbar-dark');
                    mainHeader.classList.remove('navbar-light');
                }
                toggleSwitch.checked = true;
            }
        }

        function switchTheme(e) {
            if (e.target.checked) {
                if (!document.body.classList.contains('dark-mode')) {
                    document.body.classList.add("dark-mode");
                }
                if (mainHeader.classList.contains('navbar-light')) {
                    mainHeader.classList.add('navbar-dark');
                    mainHeader.classList.remove('navbar-light');
                }
                localStorage.setItem('theme', 'dark');
            } else {
                if (document.body.classList.contains('dark-mode')) {
                    document.body.classList.remove("dark-mode");
                }
                if (mainHeader.classList.contains('navbar-dark')) {
                    mainHeader.classList.add('navbar-light');
                    mainHeader.classList.remove('navbar-dark');
                }
                localStorage.setItem('theme', 'light');
            }
        }



        $(function() {
            const Toast = Swal.mixin({
                toast: true
                , position: 'top-end'
                , showConfirmButton: false
                , timer: 3000
                , timerProgressBar: true
                , didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            toastr.options = {
                "closeButton": true
                , "newestOnTop": false
                , "progressBar": true
                , "positionClass": "toast-top-right"
                , "preventDuplicates": false
                , "onclick": null
                , "showDuration": "300"
                , "hideDuration": "1000"
                , "timeOut": "5000"
                , "extendedTimeOut": "1000"
                , "showEasing": "swing"
                , "hideEasing": "linear"
                , "showMethod": "fadeIn"
                , "hideMethod": "fadeOut"
            }

            $('.swalDefaultSuccess').click(function() {
                Toast.fire({
                    icon: 'success'
                    , title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultInfo').click(function() {
                Toast.fire({
                    icon: 'info'
                    , title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultError').click(function() {
                Toast.fire({
                    icon: 'error'
                    , title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultWarning').click(function() {
                Toast.fire({
                    icon: 'warning'
                    , title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.swalDefaultQuestion').click(function() {
                Toast.fire({
                    icon: 'question'
                    , title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });

            $('.toastrDefaultSuccess').click(function() {
                toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });
            $('.toastrDefaultInfo').click(function() {
                toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });
            $('.toastrDefaultError').click(function() {
                toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });
            $('.toastrDefaultWarning').click(function() {
                toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });

            $('.toastsDefaultDefault').click(function() {
                $(document).Toasts('create', {
                    title: 'Toast Title'
                    , body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultTopLeft').click(function() {
                $(document).Toasts('create', {
                    title: 'Toast Title'
                    , position: 'topLeft'
                    , body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultBottomRight').click(function() {
                $(document).Toasts('create', {
                    title: 'Toast Title'
                    , position: 'bottomRight'
                    , body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultBottomLeft').click(function() {
                $(document).Toasts('create', {
                    title: 'Toast Title'
                    , position: 'bottomLeft'
                    , body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultAutohide').click(function() {
                $(document).Toasts('create', {
                    title: 'Toast Title'
                    , autohide: true
                    , delay: 750
                    , body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultNotFixed').click(function() {
                $(document).Toasts('create', {
                    title: 'Toast Title'
                    , fixed: false
                    , body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultFull').click(function() {
                $(document).Toasts('create', {
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                    , title: 'Toast Title'
                    , subtitle: 'Subtitle'
                    , icon: 'fas fa-envelope fa-lg'
                , })
            });
            $('.toastsDefaultFullImage').click(function() {
                $(document).Toasts('create', {
                    body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                    , title: 'Toast Title'
                    , subtitle: 'Subtitle'
                    , image: '../../dist/img/user3-128x128.jpg'
                    , imageAlt: 'User Picture'
                , })
            });
            $('.toastsDefaultSuccess').click(function() {
                $(document).Toasts('create', {
                    class: 'bg-success'
                    , title: 'Toast Title'
                    , subtitle: 'Subtitle'
                    , body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultInfo').click(function() {
                $(document).Toasts('create', {
                    class: 'bg-info'
                    , title: 'Toast Title'
                    , subtitle: 'Subtitle'
                    , body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultWarning').click(function() {
                $(document).Toasts('create', {
                    class: 'bg-warning'
                    , title: 'Toast Title'
                    , subtitle: 'Subtitle'
                    , body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultDanger').click(function() {
                $(document).Toasts('create', {
                    class: 'bg-danger'
                    , title: 'Toast Title'
                    , subtitle: 'Subtitle'
                    , body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
            $('.toastsDefaultMaroon').click(function() {
                $(document).Toasts('create', {
                    class: 'bg-maroon'
                    , title: 'Toast Title'
                    , subtitle: 'Subtitle'
                    , body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });
        });

        $(document).ready(function() {
            var audio = new Audio('/backend/dist/sound/click.mp3');
            var audio2 = new Audio('/backend/dist/sound/clickUp.mp3')
            $("#edit,#view,#delete, .btn").mousedown(function() {
                audio2.load();
                audio2.play();
            });
            $("#edit,#view,#delete").mouseup(function() {
                audio.load();
                audio.play();
            });

            $('body').on('click', '#delete', function() {
                var selector = $(this);

                Swal.fire({
                    title: 'Are you sure?'
                    , text: "You won't be able to revert this!"
                    , icon: 'warning'
                    , showCancelButton: true
                    , confirmButtonColor: '#3085d6'
                    , cancelButtonColor: '#d33'
                    , confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        let id = $(this).data('id');
                        $.ajax({
                            url: $(this).attr("link")
                            , type: "GET"
                            , data: id
                            , success: function(arr) {
                                var row = $(selector).parent('td').parent('tr').hide();
                                $(row).fadeOut('slow');
                                $('.table').DataTable().ajax.reload();
                            }
                            , error: function(err) {
                                alert('error');
                            }
                        });

                        Swal.fire(
                            'confim!', 'This data has been deleted.', 'success'
                        )

                    } else {
                        Swal.fire(
                            'cancel!', 'Your imaginary file is safe!', 'cancelled'
                        )
                    }
                });
            });
        });
        $('#edit,#view,#delete, .btn').click(function() {
            var modal = $('.modal');
            modal.modal({
                backdrop: true
                , show: true
            });
            $('.modal-dialog').draggable({
                cursor: "move"
                , handle: ".modal-header"
            });
            // $modal.resizable();
        });

    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(".select2").select2({
            placeholder: "Select",
            allowClear: true
        });
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
    </script>
    @stack('.js')

    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <script>
        toastr.error('{{ $error }}');

    </script>
    @endforeach
    @endif

    
</body>

</html>



