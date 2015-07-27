<!DOCTYPE html>
<html lang="en">
@include('layout.frontend.head')
@yield('style')

<body style="padding-top:0">
<!-- Navigation -->
@include('layout.frontend.navbar')
<!-- Page Content -->
<div id="wrapper">
    <!--/span-->


    <div id="page-content-wrapper" style="padding-top:0 ">
        <div class="container-fluid">


            @include('layout.frontend.left_sidebar')
            <div class="row">
                @include('layout.frontend.article')
                @yield('content')

            </div>

            <footer>
                <div class="row text-center">
                    <div class="col-lg-12">
                        <p>Copyright &copy; TopMusic</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>
<!-- /.container -->

<!-- Footer -->
@include('layout.frontend.footer')
<script>
    $("#menu-toggle").click(function (e) {
        $("#wrapper").toggleClass("toggled");
    });
</script>

</body>
@yield('script');

</html>