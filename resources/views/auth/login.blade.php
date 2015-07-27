@extends('layout.auth.master')
@section('content')
    <div class="row">

    </div>
    <div class="row">
        <div class="modal fade " id="fgpw" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Let type your email.</h4>
                    </div>
                    <div class="modal-body">
                        {{----}}
                        <form action="{{action('AuthController@resetPassword')}}" method="POST" class="form-horizontal" role="form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td>Email:</td>
                                <td><input type="email" name="email" id="" class="form-control" value="" title=""></td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel
                            </button>
                            <input type="submit" data-target="#pgpw" class="btn btn-primary Focus btnAddFocus" value="Send">
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please Sign In</h3>

                </div>
                <div class="panel-body">
                    {{--{!!Form::open(array('url'=>'auth/login','method'=>'POST')   )!!}--}}
                    <form url="auth/login" method="POST" class="form-horizontal" role="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table class="table table-hover">
                        	<tbody>
                        		<tr>
                        			<td>User Name:</td>
                                    <td>
                                        <input class="form-control" placeholder="name" name="name" type="name" autofocus>
                                    </td>
                        		</tr>
                                <tr>
                        			<td>Password:</td>
                                    <td>
                                        <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                    </td>
                        		</tr>
                                <tr>
                        			<td>
                                        <a  href="{{action('AuthController@getRegister')}}"><i class="glyphicon glyphicon-baby-formula"></i>Register now</a>
                                    </td>
                                    <td>
                                        <a class="btfg" data="#fgpw" href="#">
                                            <i class="glyphicon glyphicon-bell"></i>
                                            Forget password
                                        </a>
                                    </td>
                        		</tr>
                                <tr>
                        			<td>
                                        <div class="checkbox">
                                            <label>
                                                <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                            </label>
                                        </div>

                                    </td>
                                    <th>
                                        <button type="submit"  class="btn btn-lg btn-success btn-block">Login</button>
                                    </th>
                        		</tr>
                        	</tbody>
                        </table>

                        </form>
                    {{--{!!Form::close()!!}--}}
                </div>
            </div>
        </div>
    </div>
    </div>

@stop
@section('script')
<script>
    $(document).ready(function(){
        $('a.btfg').click(function(){
            var parent = $(this).attr("data");
            $(parent).modal("show");
        });
    });
</script>
@stop