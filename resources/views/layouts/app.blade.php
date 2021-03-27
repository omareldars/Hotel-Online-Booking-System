<!-- header -->
@include('includes.dashboard.header')
<!-- /.header -->


<!-- Navbar -->
@include('includes.dashboard.navbar')
<!-- /.navbar -->

<!-- Main Sidebar Container -->
@include('includes.dashboard.sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('includes.dashboard.sub_menu')
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            @yield('content')
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
@include('includes.dashboard.side_control')
<!-- /.control-sidebar -->

<!-- Main Footer -->
@include('includes.dashboard.footer')
<!-- /.footer -->
