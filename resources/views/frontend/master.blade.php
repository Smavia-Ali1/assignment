<!DOCTYPE html>
<html>

@include('frontend.sections.head')


<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

@include('frontend.sections.navbar')

<!-- Left side column. contains the logo and sidebar -->
@include('frontend.sections.sidebar')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

    @yield('content')

    </div>
    <!-- /.content-wrapper -->
@include('frontend.sections.footer')
<!-- Control Sidebar -->

    @include('frontend.sections.rightsidebar')

    <div class="control-sidebar-bg"></div>
</div>
@include('frontend.sections.script')

</body>
</html>
