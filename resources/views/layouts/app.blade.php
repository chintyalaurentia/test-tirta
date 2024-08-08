<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}?date={{ date('Ymd') }}"></script>
    <script src="{{ asset('js/vendor.js') }}?date={{ date('Ymd') }}"></script>


    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Other meta tags and stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>


    {{-- bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Include jQuery (full version) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="vendor/select2/dist/css/select2.min.css" rel="stylesheet" />
    <script src="vendor/select2/dist/js/select2.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">

    <!-- Include DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <!-- Styles -->
    <style>
        @font-face {
            font-family: "Poppins";
            src: url("{{ asset('fonts/Poppins/Poppins-Regular.ttf') }}");
        }

        .btn-success{
            background-color: #0d8564!important;
        }

        .required {
            color: red;
        }

        .input-group .clear-button {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    cursor: pointer;
}



    </style>
    <link href="{{ asset('css/app.css') }}?date={{ date('Ymd') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor.css') }}?date={{ date('Ymd') }}" rel="stylesheet">
    @yield('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed avian">
    <div id="app" class="wrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-primary">
            <a class="navbar-brand" href="">Navbar</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto"> <!-- Items aligned to the right -->
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('master.sales.index')}}">Master Sales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content">
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->

    </div>
    <script>
        $(function () {
            bsCustomFileInput.init()

            $('.datepicker').datepicker({
                dateFormat: 'dd/mm/yy',
            });



            if ($('.numeric').length > 0) {
                let numeric = new AutoNumeric('.numeric', {
                    allowDecimalPadding: false,
                    decimalCharacter: ',',
                    digitGroupSeparator: '.',
                    decimalPlaces: 3,
                    decimalPlacesRawValue: 3,
                });
            }

            if (window.localStorage.getItem('sidebar')) {
                $('body').addClass('sidebar-collapse');

                $('.nav-item .nav-link p').removeClass('text-wrap');
            }

            $('a[data-widget=pushmenu]').on('click', function (e) {
                if (!$('body').hasClass('sidebar-collapse')) {
                    window.localStorage.setItem('sidebar', 'collapse');
                    $('.nav-item .nav-link p').removeClass('text-wrap');
                } else {
                    window.localStorage.removeItem('sidebar');
                    $('.nav-item .nav-link p').addClass('text-wrap');
                }
            });

            const updateNotificationCounter = function () {
                let unreadNotifications = parseInt(window.localStorage.getItem('unreadNotifications') || 0);
                $('.notification-unread-total').text(unreadNotifications > 9 ? '9+' : unreadNotifications);
            }

            updateNotificationCounter();

            $(window).on('storage', function () {
                updateNotificationCounter();
            });
        });
    </script>
    @yield('js')
</body>

</html>
