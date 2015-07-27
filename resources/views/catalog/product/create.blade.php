<div class="modal fade " id="popAdd" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add New Artist</h4>
            </div>
            <div class="modal-body">
                {!!Form::open(array('action'=>'ProductController@create'
                ,'method'=>'POST','files'=>true))!!}

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <ul class="nav nav-tabs">
                        <li class="active "><a href="#general-tab" data-toggle="tab">General</a>
                        </li>
                        <li>
                            <a href="#image-tab" data-toggle="tab">Image</a>
                        </li>
                        <li><a href="#des-tab" data-toggle="tab">Description</a>
                        </li>
                        <li><a href="#price-tab" data-toggle="tab">Price</a>
                        </li>
                        <li><a href="#other-tab" data-toggle="tab">Other</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="general-tab">

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
                                        <input name="singer_id" type="hidden"/>
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
                                        <input name="composer_id" type="hidden"/>
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
                                        <select name="type_id">
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
                                        <select name="format_id">
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
                                                <input type="radio" name="status" class="is-active" value="1"
                                                       checked="checked">
                                                Active
                                            </label>
                                            <label>
                                                <input type="radio" name="status" class="is-active" value="0">
                                                InActive
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Public date</td>
                                    <td>
                                        <input type="text" data-date-format="yyyy/mm/dd"  placeholder="yyyy/mm/dd" name="public_date" id="public_date"/>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="text-center btn-nav">
                                <a href="#image-tab" class="btn-sm btn-info" data-toggle="tab">>>Image</a>
                            </div>
                        </div>
                        {{--image--}}
                        <div class="tab-pane fade" id="image-tab">
                           <div class="panel panel-default">
                           	  <div class="panel-heading">
                           			<h3 class="panel-title">Image</h3>
                           	  </div>
                           	  <div class="panel-body">
                                  <div>
                                      {!! Form::file('image', array('multiple'=>'true','accept'=>'image/*')) !!}
                                  </div>
                                  <hr/>
                                  <div class="text-center btn-nav">
                                      <a href="#general-tab" class="btn-sm btn-info" data-toggle="tab">General<<</a>
                                      <a href="#des-tab" class="btn-sm btn-info" data-toggle="tab">>>Description</a>
                                  </div>
                           	  </div>
                           </div>


                        </div>

                        {{--description--}}
                        <div class="tab-pane fade" id="des-tab">


                            <div class="panel panel-default">
                            	  <div class="panel-heading">
                            			<h3 class="panel-title">Description</h3>
                            	  </div>
                            	  <div class="panel-body">
                                      <textarea name="description" id="description" cols="100" rows="10"></textarea>
                            	  </div>
                            </div>
                            <hr/>
                            <div class="text-center btn-nav">
                                <a href="#image-tab" class="btn-sm btn-info" data-toggle="tab">Image<<</a>
                                <a href="#price-tab" class="btn-sm btn-info" data-toggle="tab">>>Price</a>
                            </div>
                        </div>

                        {{--price--}}
                        <div class="tab-pane fade" id="price-tab">
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
                                            <input type="text" name="price" parent="#popAdd" id="price" class="form-control"
                                                   value="0"
                                                   title="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input class="cb-group-price" to="#popAdd #price_group" in="#popAdd" dismisss="input#sale_off" dismiss="input#price"
                                                   type="checkbox">
                                            Price Group:
                                        </td>
                                        <td>
                                            <select style="display: none" type="text" parent="#popAdd" name="group_price_id"
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
                                            <input type="text" in="#popAdd"; from="input#price" to="input#cost" name="sale_off" id="sale_off" class="form-control"
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
                                <a href="#des-tab" class="btn-sm btn-info" data-toggle="tab">Description<<<</a>
                                <a href="#other-tab" class="btn-sm btn-info" data-toggle="tab">>>Other</a>
                            </div>
                        </div>
                        {{--other--}}
                        <div class="tab-pane fade" id="other-tab">
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
                                <a href="#price-tab" class="btn-sm btn-info" data-toggle="tab">Price<<<</a>
                            </div>
                            <hr/>
                            <div class="text-center">
                                <button type="button" class="btn btn-default x-modal" data-dismiss="modal">Cancel
                                </button>
                                <button type="submit" data-target="#popAdd" class="btn btn-primary Focus btnAddFocus">
                                    Add
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
