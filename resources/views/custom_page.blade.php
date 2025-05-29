<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- @section('title', 'Home page') --}}

</head>
<body>
    {{-- @push('style') --}}
    {{-- <style>
        .book-list-wrapper {
            padding: 0px !important;
            position: relative;
        }

        .slick-prev:hover,
        .slick-prev:focus,
        .slick-next:hover,
        .slick-next:focus {
            color: black;
            outline: none;
            background: #cd5050c2;
        }

        .slick-dots li button::before {
            color: #777;
            font: 30px/1 "ionicons";
            content: "\F3A6";
            opacity: 0.7;
        }

        .slick-dots li.slick-active button:before {
            color: red !important
        }

    </style> --}}
    {{-- @endpush --}}


    <section class="card my-4" id="{{ $page->slug }}">
        <h4 class="card-header bg-light border-0">{{ $widget->title ?? '' }}
            {{ $page->title }}
        </h4>

        <div class="card-body py-2" style="overflow: hidden" lgs-count="6" mds-count="6" sms-count="4">
            {{-- <p>{{ strip_tags($page->content) }}</p> --}}
            <p>
                {!! html_entity_decode($page->content) !!}
            </p>
        </div>
    </section>

    {{-- @push('script') --}}
    <script>
        $("form#subscribe").submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            let url = $(this).attr("action");
            axios.post(url, formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    , }
                , })
                .then((response) => {
                    this.reset();
                    toastr.success(response.data);
                })
                .catch((error) => {
                    console.log(error.response);
                    toastr.error(error.response.data.errors.email[0]);
                });


        })

    </script>
    {{-- @endpush --}}
    {{-- @endsection --}}
</body>
</html>
