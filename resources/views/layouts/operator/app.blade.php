<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/png" href="/img/fav.ico">
        <title>{{ config('app.name') }}</title>

        <!-- Bootstrap -->
        <link href="{{ asset("vendors/bootstrap/dist/css/bootstrap.min.css") }}" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="{{ asset("vendors/font-awesome/css/font-awesome.min.css") }}" rel="stylesheet">
        <!-- NProgress -->
        <link href="{{ asset("vendors/nprogress/nprogress.css") }}" rel="stylesheet">

        <link href="{{ asset("css/admin/custom.css") }}" rel="stylesheet">

        <!-- jQuery -->
        <script src="{{ asset("vendors/jquery/dist/jquery.min.js") }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

        <script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-app.js"></script>
        <!-- Add additional services that you want to use -->
        <script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-auth.js"></script>
        <script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-firestore.js"></script>
        <script src="https://www.gstatic.com/firebasejs/5.7.0/firebase-database.js"></script>
        <script src="{{ asset("firebase/firestore-config.js") }}"></script>

        @isset($css)
        @foreach($css as $cs)
        <link href="{{ asset($cs) }}" rel="stylesheet">
        @endforeach
        @endisset


        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>
var site_url = "{{ url('/operator') }}";
        </script>
        <script type="text/javascript">
            var _baseUrl = "{{ URL::to('/') }}";
        </script>
    </head>

    <body class="nav-md">
        <div class="overlay">
            <div id="loading-img"></div>
        </div>
        <div class="container body">
            <div class="main_container">
                @include('layouts.operator.header')

                <!-- page content -->
                <div class="right_col" role="main">
                    @yield('header-style')

                    @yield('content')
                </div>
                <!-- /page content -->

                @include('layouts.operator.footer')

            </div>
        </div>


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
        <script src="{{ asset("js/jquery.validate.js") }}"></script>  
        <script src="{{ asset("js/additional.validate.js") }}"></script>  
        <script src="{{ asset("js/admin/bootbox.min.js") }}"></script>  

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

        @yield('script')

        <script>

            //setup CSRF token for ajax forms
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function showErrorMessage(msg) {
                $(".msg").addClass("alert-danger");
                $(".msg").html(msg);
                $(".msg").fadeIn();
                setTimeout(function () {
                    $(".msg").fadeOut();
                }, 3000);
            }
            function showSuccessMessage(msg) {
                $(".msg").addClass("alert-success");
                $(".msg").html(msg);
                $(".msg").fadeIn();
                setTimeout(function () {
                    $(".msg").fadeOut();
                }, 3000);
            }

            setTimeout(function () {
                $(".alert").fadeOut();
            }, 3000);
        </script>
    </body>
</html>