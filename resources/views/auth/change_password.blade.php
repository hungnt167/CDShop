@extends('layout.auth.master')
@section('content')
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

    </div>
    <div class="row">
        <div class="panel panel-info col-lg-4 col-md-4 col-sm-4">
            <div class="panel-heading">
                <h3 class="panel-title">Change your password</h3>
            </div>
            <div class="panel-body responsive">
                <form method="post" action="{{action('AuthController@postChangePassword')}}">
                    <input type="hidden" value="{{csrf_token()}}" name="_token">
                    <table class="table table-bordered table-hover">
                        <tbody>
                        <tr>
                            <td>Current password</td>
                            <td><input name="current_password" type="password"></td>
                        </tr>
                        <tr>
                            <td>New password</td>
                            <td><input name="new_password" type="password"></td>
                        </tr>
                        <tr>
                            <td>Confirm new password</td>
                            <td><input name="confirm" type="password"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="" class="text-center">
                                <button type="submit"> Change</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

    </div>
@stop