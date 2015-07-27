<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

@include('layout.backend.head')
@yield('style')
</head>
<body>
{{--<pre>--}}
{{--{!!    var_dump(\Illuminate\Support\Facades\Session::get('user'))!!}--}}
{{--</pre>--}}
{{--{{\Illuminate\Support\Facades\Route::getFacadeRoot()->current()->uri()}}--}}

<div id="wrapper">

    <!-- Navigation -->
    @include('layout.backend.navbar')
    <div id="page-wrapper">
        @include('layout.backend.article')
        @yield('content')
    </div>
</div>
<!-- /#wrapper -->

</body>
@include('layout.backend.footer')
@yield('script');

</html>
