@extends('layout.auth.master')
@section('content')
    <div class="row">
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">

        </div>
        <div class="col-md-8">
            <div class=" panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Register</h3>
                </div>
                <div class="panel-body">
                    <div class="panel-body text-center">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">


                            {!!Form::open(array('action'=>'AuthController@postRegister'
                            ,'method'=>'POST','files'=>true))!!}

                            <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                                <table class="table table-hover">
                                    <tbody>
                                    <tr>
                                        <th>{{Lang::get('content.name user')}}:</th>
                                        <td><input type="text" name="name" id="name" class="form-control"
                                                   value="{{old('name')}}" title="{{Lang::get('content.name user')}}"
                                                   required="required">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{Lang::get('content.password')}}:</th>
                                        <td><input type="password" name="password" id="password"
                                                   class="form-control" value="" title="password"
                                                   required="required">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{Lang::get('content.confirm password')}}:</th>
                                        <td><input type="password" name="cpassword" id="password"
                                                   class="form-control" value="{{old('password')}}"
                                                   title="password"
                                                   required="required">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{Lang::get('content.phone')}}:</th>
                                        <td><input type="tel" name="phone" id="Phone"
                                                   class="form-control" value="{{old('phone')}}" title="Phone"
                                                   required="required">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{Lang::get('content.email')}}:</th>
                                        <td><input type="email" name="email" id="email" class="form-control"
                                                   value="{{old('email')}}" title="email" required="required">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">{{Lang::get('content.avatar')}}</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div>Upload</div>
                                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                                            <input type="file"  accept="image/*" name="image"/>
                                        </div><hr/>
                                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                            <img id="myImg" src="#" alt="your image" />
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <script src='https://www.google.com/recaptcha/api.js'></script>
                                <div class="g-recaptcha" data-sitekey="6LdkCQoTAAAAALNT3hXvjB3fQXX9Rc1_zmyd4LyF"></div>
                            </div>
                            <hr/>
                            <div class="row">
                                <button type="submit" class="btn btn-primary">{{Lang::get('content.register')}}</button>
                            </div>
                            {{--</form>--}}
                            {!!Form::close()!!}
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">

    </div>
</div>

    @section('script')
        <script>
            $(function () {
                $(":file").change(function () {
                    if (this.files && this.files[0]) {
                        var reader = new FileReader();
                        reader.onload = imageIsLoaded;
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            });

            function imageIsLoaded(e) {
                $('#myImg').attr('src', e.target.result);
                $('#myImg').attr('height',100);
            };
        </script>
        @stop
@stop