<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">
    @stack('seo')
    <meta name="google-site-verification" content="CQ8vJq0ithCboIuHxQ7ep0Cnx7E9_MWimQqiVqwxxDU" />

    <title>BLK Surabaya {{ $title ?? '' }}</title>
    <link href="{{ asset('adminassets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    <!-- CSS
 ================================================== -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/plugins/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('adminassets/vendor/sweetalert2/sweetalert2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('dropify.') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/plugins/rating/star-rating.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/plugins/rating/krajee-fas/theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/plugins/rating/krajee-svg/theme.min.css') }}"> --}}
    @stack('css')
    
</head>

<body class="font-sans antialiased bg-light">
    <div class="Loader"></div>
    <div class="wrapper">
        @yield('navbar')

        @yield('body')

        @include('layouts.footer')
    </div>

    @include('components.modal')
    @stack('modal')
    {{-- Script --}}
    <script type="text/javascript" src="{{ asset('/assets/frontend/plugins/js/jquery.min.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('assets/plugins/js/wysihtml5-0.3.0.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('assets/extensions/tinymce/tinymce.min.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('/assets/frontend/plugins/js/viewportchecker.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('/assets/frontend/plugins/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/frontend/plugins/js/bootsnav.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/frontend/plugins/js/select2.min.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('/assets/frontend/plugins/js/sweetalert.min.js') }}"></script> --}}
    <script src="{{ asset('/adminassets/vendor/sweetalert2/sweetalert2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/frontend/plugins/js/datedropper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/frontend/plugins/js/dropzone.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/frontend/plugins/js/loader.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/frontend/plugins/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/frontend/plugins/js/slick.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/frontend/plugins/js/gmap3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/frontend/plugins/js/jquery.easy-autocomplete.min.js') }}"></script>
    <!-- Custom Js -->
    <script src="{{ asset('assets/frontend/js/custom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/frontend/plugins/js/counterup.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/plugins/rating/star-rating.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/plugins/rating/krajee-fas/theme.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/plugins/rating/krajee-svg/theme.min.js') }}"></script>

    @stack('js')

    <script>
        tinymce.init({
        selector: 'textarea',  // change this value according to your HTML
        menubar: 'file edit view'
        });
        $('#company-dob').dateDropper();
        $('#apply-job').on('show.bs.modal', function(e) {
            let button = $(e.relatedTarget)
            let slug = button.data('slug')
            let modal = $(this)
            let newURL = modal.find('form').attr('action')
            let logo = $('#logoCompany').attr('src')
            let name = $('#companyName').text()
            let title = $('#jobTitle').text()
            modal.find('form').attr('action', newURL.replace('%20', slug))
            modal.find('.apply-job-box img').attr('src', logo)
            modal.find('.apply-job-box p').text(name)
            modal.find('.apply-job-box h4').text(title)
        })
        $('#modalDelete').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var url = button.data('url') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('#formDelete').attr('action', url);
        })
        $('.dropify').dropify();
    </script>
    @if (session()->has('success'))
        <script>
            Swal.fire({
                position: 'center',
                type: 'success',
                title: 'Berhasil',
                text: "{{ session()->get('success') }}",
                // showConfirmButton: false,
                // timer: 2000,
            })
        </script>
    @endif
    @if (session()->has('errors'))
        <script>
            Swal.fire({
                position: 'center',
                type: 'error',
                title: 'Gagal',
                text: "{{ session()->get('errors') }}",
                // showConfirmButton: false,
                // timer: 2000,
            })
        </script>
    @endif
    @if (session()->has('file'))
        <script>
            Swal.fire({
                position: 'center',
                type: 'error',
                title: 'Gagal',
                text: "{{ session()->get('errors')->first() }}",
                // showConfirmButton: false,
                // timer: 2000,
            })
        </script>
    @endif
</body>

</html>