<div class="modal fade " id="popEdit" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit</h4>

                <p class="ck"></p>
            </div>
            <div class="modal-body">
                {!!Form::open(array('action'=>'ProductController@update'
                ,'method'=>'POST','files'=>true))!!}

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <ul class="nav nav-tabs">
                        <li class="active "><a href="#up-general-tab" data-toggle="tab">General</a>
                        </li>
                        <li>
                            <a href="#up-image-tab" data-toggle="tab">Image</a>
                        </li>
                        <li><a href="#up-des-tab" data-toggle="tab">Description</a>
                        </li>
                        <li><a href="#up-price-tab" data-toggle="tab">Price</a>
                        </li>
                        <li><a href="#up-other-tab" data-toggle="tab">Other</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="up-general-tab">

                            <table class="table table-responsive table-hover">
                                <tbody>
                                <tr>
                                    <td>Name</td>
                                    <td>
                                        <input type="text" name="name" id="name" placeholder="Name CD" class="form-control" value="" title="">

                                    </td>
                                </tr>
                                <tr>
                                    <td>Singer</td>
                                    <td>
                                        <input type="hidden" name="singer_id">
                                        <input type="text" name="singer" placeholder="Singer" id="singer" class="form-control" value=""
                                               title="">
                                        <div class="suggest-singer" to="#singer" style="display: none"
                                                >

                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Composer</td>
                                    <td>
                                        <input type="hidden" name="composer_id">
                                        <input type="text" name="composer" placeholder="Composer" id="composer" class="form-control" value=""
                                               title="">

                                        <div class="suggest-composer" to="#composer" style="display: none">

                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Quantity</td>
                                    <td><input type="number" min="1" placeholder="Quantity" name="quantity" id="quantity" value="1"/></td>
                                </tr>
                                <tr>
                                    <td>Type</td>
                                    <td>
                                        <select name="type_id" id="type">
                                            @if(isset($type))
                                                @foreach($type as $aType)
                                                    <option value="{{$aType['id']}}">{{$aType['name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Format</td>
                                    <td>
                                        <select name="format_id" id="format">
                                            @if(isset($type))
                                                @foreach($format as $aFormat)
                                                    <option value="{{$aFormat['id']}}">{{$aFormat['name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="status" value=1 class="is-active" />
                                                Active
                                            </label>
                                            <label>
                                                <input type="radio" name="status"  value=0 class="is-active"/>
                                                InActive
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Public date</td>
                                    <td>
                                        <input type="text" data-date-format="yyyy/mm/dd"  placeholder="yyyy/mm/dd" name="public_date"
                                               id="up-public_date"/>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="text-center btn-nav">
                                <a href="#up-image-tab" class="btn-sm btn-info" data-toggle="tab">>>Image</a>
                            </div>
                        </div>
                        {{--image--}}
                        <div class="tab-pane fade" id="up-image-tab">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Image</h3>
                                </div>
                                <div class="panel-body">
                                    <div>
                                        <img src="#" id="old-portal" class="img-responsive" alt="Image">
                                    </div>
                                    <div>
                                        {!! Form::file('image', array('multiple'=>'true','accept'=>'image/*')) !!}
                                    </div>
                                    <hr/>
                                    <div class="text-center btn-nav">
                                        <a href="#up-general-tab" class="btn-sm btn-info" data-toggle="tab">General<<</a>
                                        <a href="#up-des-tab" class="btn-sm btn-info" data-toggle="tab">>>Description</a>
                                    </div>
                                </div>
                            </div>


                        </div>

                        {{--description--}}
                        <div class="tab-pane fade" id="up-des-tab">


                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Description</h3>
                                </div>
                                <div class="panel-body">
                                    <textarea name="description" id="up-description" cols="100" rows="10"></textarea>
                                </div>
                            </div>
                            <hr/>
                            <div class="text-center btn-nav">
                                <a href="#up-image-tab" class="btn-sm btn-info" data-toggle="tab">Image<<</a>
                                <a href="#up-price-tab" class="btn-sm btn-info" data-toggle="tab">>>Price</a>
                            </div>
                        </div>

                        {{--price--}}
                        <div class="tab-pane fade" id="up-price-tab">
                            <span class="label label">Price:</span>

                            <div>
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                    <tr>
                                        <td>Root Price
                                            <start style="color: red">*</start>
                                            (USD):
                                        </td>
                                        <td>
                                            <input type="text" name="root_price" id="root_price" class="form-control"
                                                   value="0">
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>Price
                                            <start style="color: red">*</start>
                                            (USD):
                                        </td>
                                        <td>
                                            <input type="text" name="price" parent="#popEdit" id="price" class="form-control"
                                                   value="0"
                                                   title="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input class="cb-group-price"  to="#popEdit #price_group" in="#popEdit" dismisss="input#sale_off" dismiss="input#price"
                                                   type="checkbox">
                                            Price Group:
                                        </td>
                                        <td>
                                            <select style="display: none" type="text" parent="#popEdit" name="group_price_id"
                                                    id="price_group" class="form-control">
                                                <option value="0">-------------------</option>
                                                @if(isset($price_groups))
                                                    @foreach($price_groups as $aGroup)
                                                        <option value="{{$aGroup['id']}}"
                                                                root_price="{{$aGroup['root_price']}}"
                                                                price="{{$aGroup['price']}}">
                                                            {{$aGroup['name']}}
                                                        </option>

                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sale off(%):</td>
                                        <td>
                                            <input type="text" in="#popEdit" from="input#price" to="input#cost" name="sale_off" id="sale_off" class="form-control"
                                                   value="0" title="">
                                        </td>
                                    </tr>
                                    </tr>
                                    <tr>
                                        <td>Cost:</td>
                                        <td>
                                            <input type="text" name="cost" id="cost" class="form-control" value=""
                                                   title="">
                                        </td>
                                    </tr>
                                    <tr>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center btn-nav">
                                <a href="#up-des-tab" class="btn-sm btn-info" data-toggle="tab">Description<<<</a>
                                <a href="#up-other-tab" class="btn-sm btn-info" data-toggle="tab">>>Other</a>
                            </div>
                        </div>
                        {{--other--}}
                        <div class="tab-pane fade" id="up-other-tab">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center btn-nav">
                                <a href="#up-price-tab" class="btn-sm btn-info" data-toggle="tab">Price<<<</a>
                            </div>
                            <hr/>
                                <div class="text-center">
                                    <input type="hidden" name="id" id="id">
                                    <button type="button" class="btn btn-default x-modal" data-dismiss="modal">Cancel
                                    </button>
                                    <button type="submit" data-target="#popEdit" class="btn btn-primary Focus btnEditFocus">
                                        Update
                                    </button>
                                    {!!Form::close()!!}
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal-footer">


                    </div>
                </div>
            </div>
        </div>
    </div>
