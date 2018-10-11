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
        
        <link href="{{ asset("css/admin/custom.css") }}" rel="stylesheet">
        
        @isset($css)
        @foreach($css as $cs)
        <link href="{{ asset($cs) }}" rel="stylesheet">
        @endforeach
        @endisset


        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>
            var site_url = "{{ url('/admin') }}";
        </script>
        <script type="text/javascript">
            var _baseUrl = "{{ URL::to('/') }}";
        </script>
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
        
<!--         Flot 
        <script src="{{ asset("vendors/Flot/jquery.flot.js") }}"></script>
        <script src="{{ asset("vendors/Flot/jquery.flot.pie.js") }}"></script>
        <script src="{{ asset("vendors/Flot/jquery.flot.time.js") }}"></script>
        <script src="{{ asset("vendors/Flot/jquery.flot.stack.js") }}"></script>
        <script src="{{ asset("vendors/Flot/jquery.flot.resize.js") }}"></script>
         Flot plugins 
        <script src="{{ asset("vendors/flot.orderbars/js/jquery.flot.orderBars.js") }}"></script>
        <script src="{{ asset("vendors/flot-spline/js/jquery.flot.spline.min.js") }}"></script>
        <script src="{{ asset("vendors/flot.curvedlines/curvedLines.js") }}"></script>
         DateJS 
        <script src="{{ asset("vendors/DateJS/build/date.js") }}"></script>
         bootstrap-daterangepicker 
        <script src="{{ asset("vendors/moment/min/moment.min.js") }}"></script>
        <script src="{{ asset("vendors/bootstrap-daterangepicker/daterangepicker.js") }}"></script>-->

        @yield('footer-script')

        <!-- Custom Theme Scripts -->
        <script src="{{ asset("js/admin/custom.js") }}"></script>
        <!-- <script src="{{ asset("js/custom.min.js") }}"></script> -->
        @isset($js)
        @foreach($js as $js)
        <script src="{{ asset($js) }}"></script>
        @endforeach
        @endisset
    </body>
</html>