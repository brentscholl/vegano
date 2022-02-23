<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>
        Vegano Admin |
        @yield('title', '')
    </title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('styles')
</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="app">
{{--    @if (isset($component))--}}
{{--        <component v-bind:is={{ $component }} inline-template>--}}
{{--            <div>--}}
{{--    @endif--}}

    <div id="wrapper">

    @include('admin.layouts.sidebar', ['page' => $page])

    <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

            @include('admin.layouts.topbar')

            <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
        @include('admin.layouts.footer')
        <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @foreach (session('flash_notification', collect())->toArray() as $message)
        @if ($message['overlay'])
            <flashoverlay modalclass="flash-modal" title="{{ $message['title'] }}" message="{{ $message['message'] }}"></flashoverlay>
        @else
            <flash message="{{ $message['message'] }}" level="{{ $message['level'] }}" important="{{ $message['important'] }}"></flash>
        @endif
    @endforeach

    {{ session()->forget('flash_notification') }}

    @include('admin.modals.all')
{{--    @if (isset($component))--}}
{{--            </div>--}}
{{--        </component>--}}
{{--    @endif--}}
</div><!-- #app -->

@yield('scripts.vue-variables')
<!-- Bootstrap core JavaScript-->
<script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>


<!-- Scripts -->
<script src="{{ asset('js/adminapp.js') }}" defer></script>

@yield('scripts.footer')

</body>

</html>
