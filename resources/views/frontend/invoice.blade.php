@extends('layout.frontend.master')
@section('content')
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">Invoice {{$id}}</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Count</th>
                        <th class="col-md-2">ID product</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoice['detail'] as $k=>$product)
                        <tr>
                            <td>{{$k+1}}</td>
                            <td>{{$product['id']}}</td>
                            <td>
                                <div class="media">
                                    <a class="thumbnail pull-left" href="{{action('FrontendController@detailProduct',
                                    ['id'=>$product['product']['id'],'name'=>$product['product']['name']])}}">
                                        <img class="media-object"
                                             src="{{url().'/uploads/'.array_get($product['product'],'portal')}}"
                                             style="width: 72px; height: 72px;"> </a>

                                    <div class="media-body">
                                        <h4 class="media-heading"><a href="{{action('FrontendController@detailProduct',
                                    ['id'=>$product['product']['id'],'name'=>$product['product']['name']])}}">
                                                 {{$product['product']['name']}}</a></h4>
                                    </div>
                                </div>
                            </td>
                            <td class="text-right">${{$product['price']}}</td>
                            <td class="text-right">{{$product['quantity']}}</td>
                            <td class="text-right">${{$product['quantity']*$product['price']}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><label>Total</label></td>
                        <td class="text-right">{{$invoice['item']}}</td>
                        <td class="text-right">${{$invoice['total']}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop