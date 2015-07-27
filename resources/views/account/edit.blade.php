<div class="modal fade " id="popEdit" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit</h4>
            </div>
            <div class="modal-body">
                Are you sure?
            </div>
            <div class="modal-footer">

                {!!Form::open(array('action'=>'AccountController@update',
                'method'=>'POST','files'=>true))!!}
                <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>{{Lang::get('content.name user')}}:</th>
                            <th id="name"></th>
                        </tr>
                        <tr>
                            <th>{{Lang::get('content.phone')}}:</th>
                            <td><input type="text" name="phone" id="phone"
                                       class="form-control"
                                       value="" title="phone" required="required">
                            </td>
                        </tr>
                        <tr>
                            <th>{{Lang::get('content.email')}}:</th>
                            <td><input type="text" name="email" id="email"
                                       class="form-control"
                                       value="" title="email" required="required">
                            </td>
                        </tr>
                        <tr>
                            <th>Department: &nbsp;&nbsp;&nbsp;<a class="department"></a></th>
                            <td><select name="" id="select_department" class="form-control">
                                    {{--<option value=""> -- Select One -- </option>--}}
                                    @foreach($role as $aRole)
                                        <option value="{{$aRole->id}}">{{$aRole->name}}</option>
                                    @endforeach

                                </select>
                                <input type="hidden" name="role_id" id="department" />
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="radio">
                        <label>
                            <input type="radio" name="status" class="is-active" value="1" >
                            Active
                        </label>
                        <label>
                            <input type="radio" name="status" class="is-active" value="0">
                            InActive
                        </label>
                    </div>
                </div>
                <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Avatar</h3>
                        </div>
                        <div class="panel-body">

                            <hr/>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <img src="#" class="img-responsive" id="old_avatar" alt="Image">
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <img id="myImg" src="#" alt="your image" />
                            </div>
                            <hr/>

                            <p class="text-center">Upload</p>
                            <input type="file" accept="image/*" name="image"/>
                            <p class="errors">{!!$errors->first('image')!!}</p>
                            @if(Session::has('error'))
                                <p class="errors">{!! Session::get('error') !!}</p>
                            @endif
                        </div>
                    </div>

                    <hr/>
                </div>
                <hr/>
                {{--</form>--}}
                <input type="hidden" name="id" id="id" class="form-control" value=""/>
                <button type="button" class="btn btn-default x-modal" data-dismiss="modal">Cancel
                </button>
                <button type="submit" data-target="#popEdit" class="btn btn-primary btnUpdateFocus">Update</button>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>