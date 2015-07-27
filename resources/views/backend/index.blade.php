@extends('layout.backend.master')
@include('backend.change')
@include('backend.view')
@section('content')

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-cube fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$newProduct}}</div>
                            <div>New Products!</div>
                        </div>
                    </div>
                </div>
                <a href="{{action('ProductController@index')}}">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$newArtist}}</div>
                            <div>New Artist!</div>
                        </div>
                    </div>
                </div>
                <a href="{{action('AttributeController@artist')}}">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-shopping-cart fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$newOrder}}</div>
                            <div>New Orders!</div>
                        </div>
                    </div>
                </div>
                <a href="{{action('OrderController@index')}}">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$newCustomer}}</div>
                            <div>New customer!</div>
                        </div>
                    </div>
                </div>
                <a href="{{action('AccountController@index')}}">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-8 filter">
                @foreach($status as $k=> $aStatus)
                    <button type="button" class=" btn
                 @if($k==1)
                 btn-warning
                 @elseif($k==2||$k==3)
                 btn-info
                 @elseif($k==4)
                 btn-success
                 @else
                            btn-danger
                        @endif
                            btn-sm btnStatus"
                            value="{{$aStatus['id']}}" id="">
                        <i class="glyphicon glyphicon-arrow-right"></i> {{$aStatus['name']}}
                    </button>
                @endforeach
            </div>
        </div>
        <hr/>
        <div class="portlet-body table-responsive">

            <table id="grid-command-buttons" class="table table-condensed table-hover table-striped">
                <thead>
                <tr>
                    <th data-column-id="id" data-type="numeric">ID</th>
                    <th data-column-id="created_at">Time</th>
                    <th data-column-id="email">Email Customer</th>
                    <th data-column-id="item">Item</th>
                    <th data-column-id="total">Total</th>
                    <th data-column-id="status">Status</th>
                    <th data-column-id="action" data-formatter="view" data-sortable="false"></th>
                    <th data-column-id="edit" data-formatter="edit" data-sortable="false"></th>
                </tr>
                </thead>

            </table>
        </div>
    </div>
    <!-- /.row -->
@stop
@section('script')
    <script>


        function clearInput() {
            $('input#newCatalog').val('');
            $('input#uri').val('');
            $("#popEdit button.btnUpdateFocus").show();
            $("#popEdit input").css('border-color', '#f8f8f8');

        }
        //nav layout input
        $('.btn-nav a').click(function () {
            var target = $(this).attr('href');
            var ex = 'ul.nav-tabs li a[href=' + target + ']';
            $('ul.nav-tabs li.active').removeClass('active');
            $(ex).parent().addClass('active');
        });

        $(document).ready(function () {

            $("#grid-command-buttons").bootgrid({
                ajax: true,
                post: function () {
                    /* To accumulate custom parameter with the request object */
                    return {
                        _token: '{{csrf_token()}}'
                    };
                },
                url: "{{URL::action('OrderController@getDataAjax')}}",
                formatters: {
                    "view": function (column, row) {
                        var r = '<button class="btn btn-success glyphicon glyphicon-eye-open btn-sm btnView command-view"';
                        r += 'data-row-id="' + row.id + '" id="' + row.id + '" data-toggle="modal" data-target="#popView"/>';
                        return r;
                    }
                }

            }).on("loaded.rs.jquery.bootgrid", function () {

                $(function () {
                    fakewaffle.responsiveTabs(['xs', 'sm']);
                });
                $('.btnView ').click(function () {

                    clearInput();
                    var id = $(this).attr('id');
                    var parent = $(this).attr("data-target");
                    $(parent).modal("show");
                    $.ajax({
                        url: '{{action('OrderController@getDataAOrder')}}',
                        method: 'post',
                        data: {_token: '{{csrf_token()}}', id: id},
                        dataType: 'json'
                    }).success(function (data) {
                        //Order
                        var tagID = '#popView #id';
                        var tagName = '#popView #name_customer';
                        var tagEmail = '#popView #email';
                        var tagItem = '#popView #item';
                        var tagComment = '#popView #comment';
                        var tagTotal = '#popView #total';
                        var tagStatus = '#popView #status';
                        var tagTime = '#popView #time';
                        $(tagID).text(data.id);
                        $(tagName).text(data.customer_info.first_name + ' ' + data.customer_info.last_name);
                        $(tagEmail).text(data.customer_info.email);
                        $(tagItem).text(data.order.item);
                        $(tagTotal).text(data.order.total + '$');
                        $(tagComment).text(data.comment);
                        $(tagStatus).text(data.status);
                        $(tagTime).text(data.created_at);

                        //Detail
                        var tagOTR = '<tr>';
                        var tagCTR = '</tr>';
                        var tagOTD = '<td>';
                        var tagCTD = '</td>';

                        var result = ''
                        for (i = 0; i < data.order.detail.length; i++) {
                            result += tagOTR;
                            result += tagOTD;
                            result += data.order.detail[i].product_id;
                            result += tagCTD;
                            result += tagOTD;
                            result += data.order.detail[i].product.name;
                            result += tagCTD;
                            result += tagOTD;
                            result += data.order.detail[i].root_price;
                            result += tagCTD;
                            result += tagOTD;
                            result += data.order.detail[i].price;
                            result += tagCTD;
                            result += tagOTD;
                            result += data.order.detail[i].quantity;
                            result += tagCTD;
                            result += tagOTD;
                            var subTotal = eval(data.order.detail[i].price * data.order.detail[i].quantity);
                            result += subTotal;
                            result += tagCTD;
                            result += tagCTR;
                        }
                        $('#order_detail_row').html(result);

                        //Delivery detail
                        var tagPhone = '#popView #phone';
                        var tagAdd1 = '#popView #address1';
                        var tagAdd2 = '#popView #address2';
                        var tagCity = '#popView #city';
                        var tagState = '#popView #state';

                        $(tagPhone).text(data.customer_info.phone);
                        $(tagAdd1).text(data.customer_info.address1);
                        $(tagAdd2).text(data.customer_info.address1);
                        $(tagCity).text(data.customer_info.city_id);
                        $(tagState).text(data.customer_info.state_id);
                    });
                });
                $('button.btnChange').click(function () {
                    $('#popChange input#status[type="hidden"]').val($(this).val());
                    $('#popChange input#id').val($(this).attr('id'));
                    $('#popChange').modal("show");
                });

            }).on("loaded.rs.jquery.bootstrap", function () {

            });
            $('.filter .btnStatus').click(function () {
                value = $(this).attr('value');
                $.ajax({
                    method: 'post',
                    url: '{{action('OrderController@filterStatus')}}',
                    data: {_token: '{{csrf_token()}}', id: value}
                }).success(function (data) {
                    $("#grid-command-buttons").bootgrid('reload');
                });
            });
        });

    </script>
@stop
