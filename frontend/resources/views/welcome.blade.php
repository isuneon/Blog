<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name=“csrf-token” content=“{{ csrf_token() }}”>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Vendor styles -->
        <link rel="stylesheet" href="{{asset('plantilla/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css')}}">
        <link rel="stylesheet" href="{{asset('plantilla/vendors/bower_components/animate.css/animate.min.css')}}">
        <link rel="stylesheet" href="{{asset('plantilla/vendors/bower_components/jquery.scrollbar/jquery.scrollbar.css')}}">
        <link rel="stylesheet" href="{{asset('plantilla/vendors/bower_components/fullcalendar/dist/fullcalendar.min.css')}}">
        <link rel="stylesheet" href="{{asset('plantilla/vendors/bower_components/sweetalert2/dist/sweetalert2.min.css')}}">

        <!-- App styles -->
        <link rel="stylesheet" href="{{asset('plantilla/css/app.min.css')}}">

        <script type='text/javascript'>
             window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
    </head>
    <body data-ma-theme="green">
        <main class="main">
            <div class="page-loader">
                <div class="page-loader__spinner">
                    <svg viewBox="25 25 50 50">
                        <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                    </svg>
                </div>
            </div>
            <div id="app">
                
            </div>
        </main>
        <script src="js/app.js"></script>
        <script src="{{ asset('plantilla/vendors/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('plantilla/vendors/bower_components/popper.js/dist/umd/popper.min.js') }}"></script>
        <script src="{{ asset('plantilla/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('plantilla/vendors/bower_components/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
        <script src="{{ asset('plantilla/vendors/bower_components/jquery-scrollLock/jquery-scrollLock.min.js') }}"></script>

        <script src="{{ asset('plantilla/vendors/bower_components/flot/jquery.flot.js') }}"></script>
        <script src="{{ asset('plantilla/vendors/bower_components/flot/jquery.flot.resize.js') }}"></script>
        <script src="{{ asset('plantilla/vendors/bower_components/flot.curvedlines/curvedLines.js') }}"></script>
        <script src="{{ asset('plantilla/vendors/bower_components/jqvmap/dist/jquery.vmap.min.js') }}"></script>
        <script src="{{ asset('plantilla/vendors/bower_components/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
        <script src="{{ asset('plantilla/vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js') }}"></script>
        <script src="{{ asset('plantilla/vendors/bower_components/salvattore/dist/salvattore.min.js') }}"></script>
        <script src="{{ asset('plantilla/vendors/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
        <script src="{{ asset('plantilla/vendors/bower_components/moment/min/moment.min.js') }}"></script>
        <script src="{{ asset('plantilla/vendors/bower_components/fullcalendar/dist/fullcalendar.min.js') }}"></script>
        <script src="{{ asset('plantilla/vendors/bower_components/remarkable-bootstrap-notify/dist/bootstrap-notify.min.js') }}"></script>

        <!-- Charts and maps-->
        <!--script src="{{ asset('plantilla/demo/js/flot-charts/curved-line.js') }}"></script>
        <script src="{{ asset('plantilla/demo/js/flot-charts/dynamic.js') }}"></script>
        <script src="{{ asset('plantilla/demo/js/flot-charts/line.js') }}"></script>
        <script src="{{ asset('plantilla/demo/js/flot-charts/chart-tooltips.js') }}"></script>
        <script src="{{ asset('plantilla/demo/js/other-charts.js') }}"></script>
        <script src="{{ asset('plantilla/demo/js/jqvmap.js') }}"></script-->
        
        <script src="{{ asset('plantilla/vendors/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plantilla/vendors/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('plantilla/vendors/bower_components/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('plantilla/vendors/bower_components/jszip/dist/jszip.min.js') }}"></script>
        <script src="{{ asset('plantilla/vendors/bower_components/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>

        <!-- App functions and actions -->
        <script src="{{ asset('plantilla/js/app.min.js') }}"></script>
    </body>
</html>
