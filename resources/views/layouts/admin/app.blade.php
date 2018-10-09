<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="/images/favicon.png">
        <title>{{ config('app.name') }}</title>

        <!-- Bootstrap -->
        <link href="{{ asset("vendors/bootstrap/dist/css/bootstrap.min.css") }}" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="{{ asset("vendors/font-awesome/css/font-awesome.min.css") }}" rel="stylesheet">
        <!-- NProgress -->
        <link href="{{ asset("vendors/nprogress/nprogress.css") }}" rel="stylesheet">
        <!-- bootstrap-daterangepicker -->
        <link href="{{ asset("vendors/bootstrap-daterangepicker/daterangepicker.css") }}" rel="stylesheet">
        <link href="{{ asset("css/admin/developer.css") }}" rel="stylesheet">
        <link href="{{ asset("vendors/switchery/dist/switchery.min.css") }}" rel="stylesheet">

        <link rel="stylesheet" href="{{ URL::asset('backend/css/croppie.min.css') }}" />

        <link href="{{ URL::asset('backend/js/jquery_ui/1.10.4/css/smoothness/jquery-ui.min.css') }}" rel='stylesheet' type='text/css'>

        <!-- Custom Theme Style -->
        <link href="{{ asset("css/custom.min.css") }}" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>
            var site_url="{{ url('/admin') }}";
        </script>
        <script type="text/javascript">
        var _baseUrl = "{{ URL::to('/') }}";</script>
    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                @include('layouts.admin.header')

                <!-- page content -->
                <div class="right_col" role="main">
                    @yield('header-style')

                    @yield('content')
                </div>
                <!-- /page content -->

                @include('layouts.admin.footer')

            </div>
        </div>

        <!-- jQuery -->
        <script src="{{ asset("vendors/jquery/dist/jquery.min.js") }}"></script>
        <!-- Bootstrap -->
        <script src="{{ asset("vendors/bootstrap/dist/js/bootstrap.min.js") }}"></script>
        <!-- FastClick -->
        <script src="{{ asset("vendors/fastclick/lib/fastclick.js") }}"></script>
        <!-- NProgress -->
        <script src="{{ asset("vendors/nprogress/nprogress.js") }}"></script>
        <!-- Chart.js -->
        <script src="{{ asset("vendors/Chart.js/dist/Chart.min.js") }}"></script>
        <!-- jQuery Sparklines -->
        <script src="{{ asset("vendors/jquery-sparkline/dist/jquery.sparkline.min.js") }}"></script>
        <!-- Flot -->
        <script src="{{ asset("vendors/Flot/jquery.flot.js") }}"></script>
        <script src="{{ asset("vendors/Flot/jquery.flot.pie.js") }}"></script>
        <script src="{{ asset("vendors/Flot/jquery.flot.time.js") }}"></script>
        <script src="{{ asset("vendors/Flot/jquery.flot.stack.js") }}"></script>
        <script src="{{ asset("vendors/Flot/jquery.flot.resize.js") }}"></script>
        <!-- Flot plugins -->
        <script src="{{ asset("vendors/flot.orderbars/js/jquery.flot.orderBars.js") }}"></script>
        <script src="{{ asset("vendors/flot-spline/js/jquery.flot.spline.min.js") }}"></script>
        <script src="{{ asset("vendors/flot.curvedlines/curvedLines.js") }}"></script>
        <!-- DateJS -->
        <script src="{{ asset("vendors/DateJS/build/date.js") }}"></script>
        <!-- bootstrap-daterangepicker -->
        <script src="{{ asset("vendors/moment/min/moment.min.js") }}"></script>
        <script src="{{ asset("vendors/bootstrap-daterangepicker/daterangepicker.js") }}"></script>

        <!-- CKEditor JS -->
        <script src="{{asset('backend/js/tinymce/tinymce.min.js')}}"></script>
        <script src="{{asset('backend/js/editor/editor.js')}}"></script>

        <script type="text/javascript">
            setTimeout(function() {
                $(".alert").fadeOut('slow');
            }, 5000);
        </script>

        <script src="{{ URL::asset('js/sweetalert.min.js') }}"></script>

        <script src="{{ URL::asset('backend/js/croppie.min.js') }}"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/css/bootstrap-colorpicker.min.css" rel="stylesheet">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.1/js/bootstrap-colorpicker.min.js"></script>  

        @yield('footer-script')

        <!-- Custom Theme Scripts -->
        <script src="{{ asset("js/custom.js") }}"></script>
        <!-- <script src="{{ asset("js/custom.min.js") }}"></script> -->
        @isset($js)
            @foreach($js as $js)
        <script src="{{ asset($js) }}"></script>
            @endforeach
        @endisset
    </body>
</html>