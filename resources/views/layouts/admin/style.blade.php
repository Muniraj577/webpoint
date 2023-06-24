<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">

<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- iCheck -->
<link rel="stylesheet"
    href="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('assets/admin/dist/css/adminlte.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/daterangepicker/daterangepicker.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/admin/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/css/media.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/jquery-confirm.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/nepali.datepicker.min.css') }}">

@vite(['resources/css/app.css'])


<style>
    .toast-top-container {
        position: absolute;
        top: 65px;
        width: 280px;
        right: 40px;
        height: auto;
    }

    .btn-red {
        color: red;
    }

    .btn-blue {
        color: blue;
    }

</style>
@yield('styles')
