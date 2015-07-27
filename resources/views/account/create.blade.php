@extends('layout.backend.master')
@section('content')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

        <div class="row">

            {!!Form::open(array('action'=>'AccountController@store'
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
                    {{--<tr>--}}
                    {{--<th>Department:</th>--}}
                    {{--<td><select name="role_id" id="department" class="form-control">--}}
                    {{--<option value=""> -- Select One -- </option>--}}
                    {{--@foreach(\App\Role::all() as $aRole)--}}
                    {{--<option value="{{$aRole->role_id}}"> {{$aRole->role_name}}</option>--}}
                    {{--@endforeach--}}

                    {{--</select>--}}
                    {{--</td>--}}
                    {{--</tr>--}}
                    </tbody>
                </table>
            </div>
            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                <hr/>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{Lang::get('content.avatar')}}</h3>

                    </div>
                    <div class="panel-body">
                        <p>Upload</p>
                        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                            <input type="file" accept="image/*" name="image"/>
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                            <img id="myImg" src="#" alt="your image" />
                        </div>

                    </div>
                </div>
                <table>
                    <tbody>
                    <tr>
                        <th>Department:</th>
                        <td><select name="role_id" id="department" class="form-control">
                                {{--<option value=""> -- Select One -- </option>--}}
                                @foreach($role as $aRole)
                                    <option value="{{$aRole->id}}"> {{$aRole->name}}</option>
                                @endforeach

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Active:</th>
                        <td><select name="status" id="ac" class="form-control">
                                {{--<option value=""> -- Select One -- </option>--}}
                                    <option value="0" selected>{{Lang::get('content.unactive')}}</option>
                                    <option value="1">{{Lang::get('content.active')}}</option>

                            </select>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <hr/>

            </div>
            <hr/>

        </div>
        <div class="row text-center">
            <button type="submit" class="btn btn-primary">{{Lang::get('content.register')}}</button>
        </div>
        {{--</form>--}}
        {!!Form::close()!!}
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
