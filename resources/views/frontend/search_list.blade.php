@extends('layout.frontend.master')
@section('content')

    </div>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">All</h3>
        </div>
        <div class="panel-body grid">
            @if(isset($products))
                @foreach($products as $k=>$product)
{{--                    {{dd($product)}}--}}
                    <div class="col-sm-3 col-lg-3 col-md-3 grid-item">
                        <div class="thumbnail ">
                            <div>
                                <a href="{{action('FrontendController@detailProduct',['id'=>$product->id,'name'=>$product->name])}}">
                                    <img src="{{url().'/uploads/'.$product->portal}}" alt="ALT NAME"
                                         class="img-responsive"/>
                                </a>
                            </div>
                            <div class="caption">

                                <h5>
                                    <a href="{{action('FrontendController@detailProduct',['id'=>$product->id,'name'=>$product->name])}}">
                                        {{$product->name}}
                                    </a>
                                </h5>

                                <p>
                                    <span class="label label-default">Singer:</span>
                                    <a class="small text-success" href="#">
                                        {{$product->singer}}
                                    </a>
                                </p>




                            </div>

                            <div class="ratings">
                                <p class="pull-right">{{$product->buy_time}} reviews</p>

                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                </p>
                            </div>
                            <div class="center-block text-left">
                                <h6>
                                    {!!Form::open(array('action'=>'CartController@addToCart'
                                    ,'method'=>'POST'))!!}

                                    <?php if($product->price<=0){
                                        $product->price=$product->price_group;
                                        $product->sale_off=$product->sale_off_group;
                                    }
                                        ?>
                                    <span class="label label-default">$
                                        {{floatval($product->price*$product->sale_off*0.01+$product->price)}}
                                        </span>
                                        <span class="label label-danger "><span
                                                    class="glyphicon glyphicon-arrow-down"></span>
                                            {{$product->sale_off}}
                                            %
                                        </span>

                                    <input type="hidden" name="id" value="{{$product->id}}"/>
                                    <button type="submit" class="btn btn-warning btn-xs">
                                        <span class="glyphicon glyphicon-shopping-cart"></span>
                                        Add Cart
                                        <span class="glyphicon glyphicon-chevron-right"></span></button>
                                    {!!Form::close()!!}
                                </h6>
                            </div>


                        </div>
                    </div>


                    <!-- /.row -->
                @endforeach
            @endif

            <hr>
                {!!$products->render()!!}
{{--            @include('layout.frontend.pagination')--}}
        </div>
    </div>
    <!-- /.row -->

    <hr>





@stop