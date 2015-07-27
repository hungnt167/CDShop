<!DOCTYPE html>
<html lang="en">

@include('layout.auth.head')

<body  style="background: #139ff7">
{{--<pre>--}}
{{--{!!    var_dump(\Illuminate\Support\Facades\Session::get('user'))!!}--}}
{{--</pre>--}}
{{--{{\Illuminate\Support\Facades\Route::getFacadeRoot()->current()->uri()}}--}}
<div id="wrapper">
    @include('layout.auth.notify')
    @yield('content')
</div>
<!-- /#wrapper -->

</body>
@include('layout.auth.footer')
@yield('script');

</html>
