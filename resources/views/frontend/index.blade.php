@extends('layout.frontend.master')
@section('content')
    @include('layout.frontend.slide')
    <div class="row">

        @if(isset($listProduct))
            @foreach($listProduct as $key=> $products)
            <div class="panel panel-info">
                    <div class="panel-heading">
                        <a href="{{action('FrontendController@latest',['page'=>'start'])}}"><h3 class="panel-title"
                                                                                                style="text-transform: capitalize">{{$key}}</h3>
                        </a>
                    </div>
                    <div class="panel-body">
                        @foreach($products['cds'] as $k=>$product)
                            <div class="col-sm-3 col-lg-3 col-md-3">
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

                                        <p>
                                            <span class="label label-default">Composer:</span>
                                            <a class="small text-success" href="#">
                                                {{$product->composer}}
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


                        <hr>
                    </div>
                </div>
                <!-- /.row -->
                @endforeach
                @endif
                        <!-- /.row -->

                <hr>
    </div>




    <!-- /.row -->






@stop