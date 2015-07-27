@extends('layout.frontend.master')
@section('content')
    <div class="row">
        <div class="col-sm-10 col-md-10 col-md-offset-1 table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>
                        <a href="{{action('CartController@cancelCart')}}" class="center-block btn btn-success">
                            <span class="glyphicon glyphicon-erase"></span>
                           Cancel Cart
                        </a>
                    </th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Total</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    @if(isset($cart))
                    <?php $count = 0; ?>
                    @foreach($cart as $k=>$item)
                        {{--{{dd($item)}}--}}
                        <td class="col-sm-1 col-md-1">
                            {!!Form::open(array('action'=>'CartController@removeItem'
                            ,'method'=>'POST'))!!}
                            <input type="hidden" name="idrow" value="{{$item['rowid']}}"/>
                            <button type="submit" class="btn btn-success btn-xs">
                                <span class="glyphicon glyphicon-remove"></span> Remove
                            </button>
                        </td>
                        {!!Form::close()!!}
                        <td class="col-sm-8 col-md-6">
                            <div class="media">
                                <a class="thumbnail pull-left" href="{{action('FrontendController@detailProduct',['id'=>$item['id'],'name'=>$item['name']])}}">
                                    <img class="media-object"

                                         src="{{url().'/uploads/'.array_get($items[$count],'portal')}}"

                                         style="width: 72px; height: 72px;"> </a>

                                <div class="media-body">
                                    <h4 class="media-heading"><a href="#">{{$item['name']}}</a></h4>
                                    <h5 class="media-heading"> Singer: <a
                                                href="#">{{array_get($items[$count],'singer')}}</a></h5>
                                    <span>Format: </span><span
                                            class="text-success"><strong>{{array_get($items[$count],'format')}}</strong></span>
                                </div>
                            </div>
                        </td>
                        <td class="col-sm-1 col-md-1" style="text-align: center">
                            {!!Form::open(array('action'=>'CartController@changeQuantityItem'
                            ,'method'=>'POST'))!!}
                            <input type="qty" class="form-control" name="qty" id="qty" value="{{$item['qty']}}">
                            <input type="hidden" name="idrow" value="{{$item['rowid']}}"/>
                            <input type="hidden" name="id" value="{{$item['id']}}"/>
                            <button type="submit" class="btn btn-info btn-xs">
                                <span class="glyphicon glyphicon-circle-arrow-right"></span> Update
                            </button>
                        </td>
                        {!!Form::close()!!}
                        </td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>${{$item['price']}}</strong></td>
                        <td class="col-sm-1 col-md-1 text-right"><strong>${{$item['subtotal']}}</strong></td>

                </tr>
                <?php $count++; ?>
                @endforeach
                @endif


                <tr>
                    <td>  </td>
                    <td>  </td>
                    <td>  </td>
                    <td><h5 class="text-success">Total</h5></td>
                    <td class="text-right text-success"><h5><strong>${{$total or 0}}</strong></h5></td>
                </tr>
                {{--<tr>--}}
                    {{--<td>  </td>--}}
                    {{--<td>  </td>--}}
                    {{--<td>  </td>--}}
                    {{--<td><h5>Estimated shipping</h5></td>--}}
                    {{--<td class="text-right"><h5><strong>$6.94</strong></h5></td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<td>  </td>--}}
                    {{--<td>  </td>--}}
                    {{--<td>  </td>--}}
                    {{--<td><h3>Total</h3></td>--}}
                    {{--<td class="text-right"><h3><strong>$31.53</strong></h3></td>--}}
                {{--</tr>--}}
                <tr>
                    <td>  </td>
                    <td>  </td>
                    <td>  </td>
                    <td>
                        <a href="{{action('FrontendController@index')}}">
                            <button type="button" class="btn btn-default">
                                <span class="glyphicon glyphicon-shopping-cart"></span> Continue Shopping
                            </button>
                        </a>
                    </td>
                    <td>
                        	<a href="{{action('FrontendController@checkout')}}" class="center-block btn btn-success glyphicon glyphicon-bitcoin">
                                Checkout
                            </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
