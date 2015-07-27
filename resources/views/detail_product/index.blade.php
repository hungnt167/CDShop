@extends('layout.frontend.master')
@section('style')
    <!-- Custom CSS -->
    {{--<link href="css/shop-item.css" rel="stylesheet">--}}
@stop
@section('content')
    <div class="row">


        <div class="col-md-12">
            <!-- Portfolio Item Row -->
            <div class="row">

                <div class="col-md-8" style="padding: 5px">
                    <img class="img-responsive center-block media-object" src="{{url().'/uploads/'.$product->portal}}"
                         alt="">
                </div>

                <div class="col-md-4">
                    <h3>{{$product->name}}</h3>

                    <p>
                        <span class="label label-info">Singer:</span>
                        <a class="small" href="#">
                            {{$product->singer}}
                        </a>
                    </p>

                    <p>
                        <span class="label label-default">Composer:</span>
                        <a class="small" href="#">
                            {{$product->composer}}
                        </a>
                    </p>

                    <p>
                        <span class="label label-success">Price:</span>
                        ${{floatval($product->price*$product->sale_off*0.01+$product->price)}}
                    </p>

                    <p>
                        <span class="label label-danger">Sale:
                                {{$product->sale_off}}
                            </span>

                    </p>

                    <div class="ratings">
                        <p class="pull-right"> {{$product->buy_time}} reviews</p>

                        <p>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            4.0 stars
                        </p>
                    </div>
                    <div class="center-block text-center">
                        {!!Form::open(array('action'=>'CartController@addToCart'
                        ,'method'=>'POST'))!!}
                        <input type="hidden" name="id" value="{{$product->id}}"/>


                        <a href="{{action('FrontendController@index')}}" class="btn btn-primary" role="button">Continue
                            shoping</a>
                        <button type="submit" class="btn btn-warning ">
                            <span class="glyphicon glyphicon-shopping-cart"></span>
                            Add Cart
                            <span class="glyphicon glyphicon-chevron-right"></span></button>
                        {!!Form::close()!!}
                    </div>

                    {{--<a href="#" class="btn btn-success" role="button"><span class="glyphicon glyphicon-shopping-cart"></span>Add to Cart</a>--}}
                </div>

            </div>
            <hr/>
            <!-- /.row -->
            <div class="caption-full">
                <h4>Description
                </h4>

                {!!$product->description!!}

            </div>
            <div class="fb-comments" data-href="{{\Illuminate\Support\Facades\Request::url()}}" data-width="920"
                 data-numposts="5"></div>
            <div class="thumbnail">


            </div>


        </div>
        {{--<!-- Related Projects Row -->--}}
        {{--<div class="row">--}}

            {{--<div class="col-lg-12">--}}
                {{--<h3 class="page-header">Related Projects</h3>--}}
            {{--</div>--}}

            {{--<div class="col-sm-3 col-xs-6">--}}
                {{--<a href="#">--}}
                    {{--<img class="img-responsive portfolio-item" src="http://placehold.it/500x300" alt="">--}}
                {{--</a>--}}
            {{--</div>--}}

            {{--<div class="col-sm-3 col-xs-6">--}}
                {{--<a href="#">--}}
                    {{--<img class="img-responsive portfolio-item" src="http://placehold.it/500x300" alt="">--}}
                {{--</a>--}}
            {{--</div>--}}

            {{--<div class="col-sm-3 col-xs-6">--}}
                {{--<a href="#">--}}
                    {{--<img class="img-responsive portfolio-item" src="http://placehold.it/500x300" alt="">--}}
                {{--</a>--}}
            {{--</div>--}}

            {{--<div class="col-sm-3 col-xs-6">--}}
                {{--<a href="#">--}}
                    {{--<img class="img-responsive portfolio-item" src="http://placehold.it/500x300" alt="">--}}
                {{--</a>--}}
            {{--</div>--}}

        {{--</div>--}}
        {{--<!-- /.row -->--}}

        <hr>
@stop