<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="http://jenderalcorp.com/assets/iod/images/favicon.png">

    <title>Sistem Informasi Penentuan Biaya Pengembangan Perangkat Lunak</title>

    <!-- Fontfaces CSS-->
    <link href="{{ asset('/css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('/vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('/vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{ asset('/vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{ asset('/vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('/vendor/wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('/vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('/vendor/slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('/vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('/vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" integrity="sha256-JDBcnYeV19J14isGd3EtnsCQK05d8PczJ5+fvEvBJvI=" crossorigin="anonymous" />

    <!-- Main CSS-->
    <link href="{{ asset('/css/theme.css') }}" rel="stylesheet" media="all">
</head>
<body class="">
    <div class="page-wrapper">
        @yield('content')
    </div>


    <!-- Jquery JS-->
    <script src="{{ asset('/vendor/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap JS-->
    <script src="{{ asset('/vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ asset('/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <!-- Vendor JS       -->
    <script src="{{ asset('/vendor/slick/slick.min.js') }}">
    </script>
    <script src="{{ asset('/vendor/wow/wow.min.js') }}"></script>
    <script src="{{ asset('/vendor/animsition/animsition.min.js') }}"></script>
    <script src="{{ asset('/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js') }}">
    </script>
    <script src="{{ asset('/vendor/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('/vendor/counter-up/jquery.counterup.min.js') }}">
    </script>
    <script src="{{ asset('/vendor/circle-progress/circle-progress.min.js') }}"></script>
    <script src="{{ asset('/vendor/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('/vendor/chartjs/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('/vendor/select2/select2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js" integrity="sha256-tW5LzEC7QjhG0CiAvxlseMTs2qJS7u3DRPauDjFJ3zo=" crossorigin="anonymous"></script>

    <!-- Main JS-->
    // <script src="{{ asset('/js/main.js') }}"></script>

    <script>
        $('#type_parameter').on('change', function(e) {
            var value = Number($(this).val());
            $('#data_parameter').empty()
            if (value === 1) {
                $('#data_parameter').append('<option selected disabled>Pilih Data</option><option value="1">Nama</option><option value="2">Username</option><option value="3">Nomer Ponsel</option>')
            }
            if (value === 2) {
                $('#data_parameter').append('<option selected disabled>Pilih Data</option><option value="1">Judul</option><option value="2">Nama Klien</option><option value="3">Nama Instansi</option>')
            }
        });
    </script>

    @yield('modal-script')
</body>
</html>