<div id="confirm" class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">
            <a data-toggle="collapse" data-parent="#checkout-page" href="#confirm-content"
               class="accordion-toggle">
                Step 6: Confirm Order
            </a>
        </h2>
    </div>
    <div id="confirm-content" class="panel-collapse collapse">
        <div class="panel-body row">
            <div class="col-md-12 clearfix">
                <div class="table-wrapper-responsive table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr>

                            <th>Product</th>
                            <th>Quantity</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php $count = 0; ?>
                            @foreach($cart as $k=>$item)
                                {{--{{dd($item)}}--}}

                                <td class="col-sm-8 col-md-6">
                                    <div class="media">
                                        <a class="thumbnail pull-left" href="#"> <img class="media-object"
                                                                                      src="{{url().'/uploads/'.array_get($items[$count],'portal')}}"
                                                                                      style="width: 72px; height: 72px;">
                                        </a>

                                        <div class="media-body">
                                            <h4 class="media-heading"><a href="#">{{$item['name']}}</a></h4>
                                            <h5 class="media-heading"> Singer: <a
                                                        href="#">{{array_get($items[$count],'singer')}}</a>
                                            </h5>
                                            <span>Format: </span><span
                                                    class="text-success"><strong>{{array_get($items[$count],'format')}}</strong></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-sm-1 col-md-1" style="text-align: center">
                                    {{$item['qty']}}
                                </td>
                                </td>
                                <td class="col-sm-1 col-md-1 text-center">
                                    <strong>${{$item['price']}}</strong></td>
                                <td class="col-sm-1 col-md-1 text-right">
                                    <strong>${{$item['subtotal']}}</strong></td>

                        </tr>
                        <?php $count++; ?>
                        @endforeach


                        <tr>

                            <td>  </td>
                            <td>  </td>
                            <td><h5>Subtotal</h5></td>
                            <td class="text-right"><h5><strong>${{$total}}</strong></h5></td>
                        </tr>
                        <tr>
                            <td>  </td>
                            <td>  </td>
                            <td><h5>Estimated shipping</h5></td>
                            <td class="text-right"><h5><strong>$0.00</strong></h5></td>
                        </tr>
                        <tr>
                            <td>  </td>
                            <td>  </td>
                            <td><h3>Total</h3></td>
                            <td class="text-right"><h3><strong>${{$total}}</strong></h3></td>
                        </tr>
                        <tr>
                            <td>  </td>
                            <td>  </td>
                            <td>
                                <a href="{{action('CartController@cancelCart')}}" class="center-block btn btn-success">
                                   Cancel Checkout <span class="glyphicon glyphicon-erase"></span>
                                </a>
                            </td>
                            <td>
                                {!!Form::open(array('action'=>'FrontendController@order'
                                ,'method'=>'POST'))!!}
                                <button type="submit" class="btn btn-success">
                                    Order <span class="glyphicon glyphicon-bitcoin"></span>
                                </button>
                                {!!Form::close()!!}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>