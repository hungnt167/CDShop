@extends('layout.backend.master')
@include(('catalog.product.del'))
@include(('catalog.product.edit'))
@include(('catalog.product.create'))
@section('style')
    {{--calender--}}
    <link href="{{asset('/datepicker/datepick.css')}}" rel="stylesheet" type="text/css">
@stop
@section('content')
    <div class="row">
        <div class="col-md-4 col-sm-8 col-xs-8 option-nav">
            <button data-target="#popAdd" type="button" id="" class="btn btn-success btn-sm btnAdd"><i
                        class="glyphicon glyphicon-plus"></i> Add new
            </button>
        </div>
    </div>
    <div class="portlet-body">

        <table id="grid-keep-selection" class="table table-condensed table-hover table-striped">
            <thead>
            <tr>
                <th data-column-id="id" data-type="numeric" data-identifier="true">ID</th>
                <th data-column-id="name">Name</th>
                <th data-column-id="singer">Singer</th>
                <th data-column-id="composer">Composer</th>
                <th data-column-id="status">Status</th>
                <th data-column-id="root_price">Root Price($)</th>
                <th data-column-id="price">Price($)</th>
                <th data-column-id="cost">Cost($)</th>
                <th data-column-id="quantity">Quantity</th>
                <th data-column-id="public_date">Public date</th>
                <th data-column-id="action" data-formatter="option" data-sortable="false">Option</th>
            </tr>
            </thead>

        </table>
    </div>
@stop
@section('script')
    <script src="{{asset('/js/ckeditor.js')}}"></script>
    {{--calender--}}
    <script src="{{asset('/datepicker/jquery.datepick.js')}}"></script>
    <script>


        function clearInput() {
            $('input[type=text]').val('');
        }
        /*
         $(function () {
         $(":file").change(function () {
         if (this.files && this.files[0]) {
         var reader = new FileReader();
         reader.onload = imageIsLoaded;
         reader.readAsDataURL(this.files[0]);
         }
         });
         });

         function imageIsLoaded(e) {
         $('#myImg').attr('src', e.target.result);
         $('#myImg').attr('height',100);
         };
         */
        //datepicker
        $('#public_date').datepicker();
        $('#up-public_date').datepicker();
        //select  from search
        function slSinger(id) {
            var tag = 'input.target#' + id;
            var name = $(tag).val();
            $('input#singer').val(name);
            $('input[name=singer_id]').val(id);
            $('.suggest-singer').hide();
        }
        function slComposer(id) {
            var tag = 'input.target#' + id;
            var name = $(tag).val();
            $('input#composer').val(name);
            $('input[name=composer_id]').val(id);
            $('.suggest-composer').hide();
        }
        function onGroupPrice(tag) {
            var target = $(tag).attr('to');
            var inPop = $(tag).attr('in');
            //disable other
            var tagPrice = inPop + ' ' + $(tag).attr('dismiss');
            var tagRoot = inPop + ' input#root_price';
            var tagSale = inPop + ' ' + $(tag).attr('dismisss');
            var tagGroupPrice = inPop + ' ' + 'select#price_group';
            $(tagPrice).attr('disabled', 'disabled');
            $(tagSale).attr('disabled', 'disabled');
            $(tagRoot).attr('disabled', 'disabled');
            $(tagGroupPrice).removeAttr('disabled');
            $(tagRoot).hide();
            $(tagSale).hide();
            $(tagPrice).hide();
            $(target).show();
        }

        function offGroupPrice(tag) {
            var target = $(tag).attr('to');
            var inPop = $(tag).attr('in');
            //disable other
            var tagPrice = inPop + ' ' + $(tag).attr('dismiss');
            var tagRoot = inPop + ' input#root_price';
            var tagSale = inPop + ' ' + $(tag).attr('dismisss');
            var tagGroupPrice = inPop + ' ' + 'select#price_group';
            $(tagRoot).removeAttr('disabled');
            $(tagSale).removeAttr('disabled');
            $(tagPrice).removeAttr('disabled');
            $(tagGroupPrice).attr('disabled', 'disabled');
            var sale_off = $(tagSale).val();
            var price = $(tagPrice).val();
            var cost = price - (price * sale_off * 0.01);
            $('input#cost').val(cost);
            $(tagRoot).show();
            $(tagSale).show();
            $(tagPrice).show();
            $(target).hide();
        }
        //suggest singer
        $(document).ready(function () {
            $('input#singer').keyup(function () {
                var key = $(this).val();
                var tagSelect = '.suggest-singer';
                if (key != '') {
                    $.ajax({
                        method: 'post',
                        url: '{{action('ProductController@searchSinger')}}',
                        data: {key: key, _token: '{{csrf_token()}}'},
                        dataType: 'json',
                        success: (function (data) {
                            $(tagSelect).empty();
                            if (data.length > 0) {
                                for (i = 0; i < data.length; i++) {
                                    var child = '<input readonly class="target form-control"';
                                    child += 'onclick="slSinger(' + data[i].id + ')" id=' + data[i].id + ' value="' + data[i].name + '"/>';
                                    $(tagSelect).append(child);
                                }
                                $(tagSelect).show();
                            } else {
                                $(tagSelect).hide();
                            }
                        })
                    });
                } else {
                    $(tagSelect).hide();
                }
            });
            //suggest composer
            $('input#composer').keyup(function () {
                var key = $(this).val();
                var tagSelect = '.suggest-composer';
                if (key != '') {
                    $.ajax({
                        method: 'post',
                        url: '{{action('ProductController@searchComposer')}}',
                        data: {key: key, _token: '{{csrf_token()}}'},
                        dataType: 'json',
                        success: (function (data) {
                            $(tagSelect).empty();
                            if (data.length > 0) {
                                for (i = 0; i < data.length; i++) {
                                    var child = '<input readonly class="target form-control"';
                                    child += 'onclick="slComposer(' + data[i].id + ')" id=' + data[i].id + ' value="' + data[i].name + '"/>';
                                    $(tagSelect).append(child);
                                }
                                $(tagSelect).show();
                            } else {
                                $(tagSelect).hide();
                            }
                        })
                    });
                } else {
                    $(tagSelect).hide();
                }
            });


            //progress
            //first type root price
            $('input#root_price').keyup(function () {
                var value = $(this).val();
                if (parseFloat(value)) {
                    if (value > 0) {
                        $(this).css('color', 'black');
                    } else {
                        $(this).val(0);
                    }
                } else {
                    $(this).val(0);
                }
            });

            //second
            //no group
            $('input#price').keyup(function () {
                var parent = $(this).attr('parent');
                tagRoot_price=parent+' #root_price';
                var root_price = $(tagRoot_price).val();
                if (parseFloat(root_price)) {
                    if (root_price > 0) {
                        var value = $(this).val();
                        tagSale=parent+' input#sale_off';
                        var sale_off = $(tagSale).val();
                        if (value > 0 && sale_off >= 0) {
                            tagCost=parent+'input#cost';
                            var cost = parseFloat(value) + parseFloat(value * sale_off * 0.01);
                            $(tagCost).val(cost);
                        } else {
                            $(this).val(0);
                        }
                    } else {
                        $(this).val(0);
                    }
                } else {
                    $(this).val(0);
                }

            });
            //has group price
            $('select#price_group').click(function () {
                parent=$(this).attr('parent');
                var value = $(this).find('option:selected').attr('price');
                if (value > 0) {
                    tagCost=parent+'input#cost';
                    $(tagCost).val(parseFloat(value));
                    $(this).css('color', 'black');
                } else {
                    $(this).css('color', 'red');
                }
            });
            //third sale off
            $('input#sale_off').keyup(function () {
                var inPop=$(this).attr('in');
                var from = inPop+' '+$(this).attr('from');
                var target = inPop+' '+ $(this).attr('to');
                var price =$(from).val();
                var value =$(this).val();
                if (parseFloat(value) || value <= '0') {
                    $(this).css('color', 'black');
                    if (value >= 0 && value <= 99) {
                        $(target).val((parseFloat(price) + (price) * value * 0.01));
                    } else {
                        $(target).val(0);
                    }
                } else {
                    $(target).val(0);
                }
            });


            //checkbox group price
            $('input.cb-group-price').change(function () {
                var inPop = $(this).attr('in');
                var tag = inPop + ' input.cb-group-price';
                //disable other
                var tagPrice = inPop + ' ' + $(this).attr('dismiss');
                var tagRoot = inPop + ' input#root_price';
                var tagSale = inPop + ' ' + $(this).attr('dismisss');

                if (
                        $(tagRoot).attr('disabled') != undefined &&
                        $(tagPrice).attr('disabled') != undefined &&
                        $(tagSale).attr('disabled') != undefined
                ) {
                    offGroupPrice(tag);
                } else {
                    onGroupPrice(tag);
                }


            });
            //nav layout input
            $('.btn-nav a').click(function () {
                var target = $(this).attr('href');
                var ex = 'ul.nav-tabs li a[href=' + target + ']';
                $('ul.nav-tabs li.active').removeClass('active');
                $(ex).parent().addClass('active');
            });

            $("#grid-keep-selection").bootgrid({
                ajax: true,
                post: function () {
                    /* To accumulate custom parameter with the request object */
                    return {
                        _token: '{{csrf_token()}}'
                    };
                },
                url: "{{URL::action('ProductController@getDataAjax')}}",
                formatters: {
                    "option": function (column, row) {
                        var r = '<button class="btn btn-primary glyphicon glyphicon-edit btn-sm btnEdit command-edit"';
                        r += 'data-row-id="' + row.id + '" id="' + row.id + '" data="' + row.name + '" data-toggle="modal" data-target="#popEdit"/>';
                        r += '<button class="btn btn-danger glyphicon glyphicon-remove btn-sm btnDel command-delete"';
                        r += 'data-row-id="' + row.id + '" id="' + row.id + '" data="' + row.name + '" data-toggle="modal" data-target="#popDelete"/>';

                        return r;
                    }
                }

            }).on("loaded.rs.jquery.bootgrid", function () {
                $('button.btnAdd ').click(function () {
//                    clearInput();
                    var parent = $(this).attr("data-target");
                    $(parent).modal("show");
                });
                $('button.btnDel ').click(function () {
                    $('#popDelete input#id[type="hidden"]').val($(this).attr('id'));
                    $('#popDelete input#name').val($(this).attr('data'));
                    var parent = $(this).attr("data-target");
                    $(parent).modal("show");
                });

                $('button.btnEdit ').click(function () {
                    clearInput();
                    var parent = $(this).attr("data-target");
                    var id = $(this).attr("id");
                    //set input id hidden
                    $('#popEdit input#id').val(id);
                    $.ajax({
                        url: '{{action('ProductController@getDataProduct')}}',
                        method: 'post',
                        data: {_token: '{{csrf_token()}}', id: id},
                        dataType: 'json',
                        success: function (data) {
                            //general
                            var tagStatus = '#popEdit input[type=radio][value=' + data.status + ']';
                            var tagFormat = '#popEdit select#format option[value=' + data.format_id + ']';
                            var tagType = '#popEdit select#type option[value=' + data.type_id + ']';
                            var tagDate = '#popEdit input#up-public_date';
                            var tagId = '#popEdit input#id';
                            var tagName = '#popEdit input#name';
                            var tagComposer = '#popEdit input#composer';
                            var tagComposerID = '#popEdit input[name=composer_id]';
                            var tagSinger = '#popEdit input#singer';
                            var tagSingerID = '#popEdit input[name=singer_id]';
                            var tagQuantity = '#popEdit input#quantity';
                            $(tagId).val(data.id);
                            $(tagName).val(data.name);
                            $(tagSinger).val(data.singer);
                            $(tagSingerID).val(data.singer_id);
                            $(tagComposer).val(data.composer);
                            $(tagComposerID).val(data.composer_id);
                            $(tagQuantity).val(data.quantity);
                            $(tagStatus).attr('checked', 'checked');
                            $(tagType).attr('selected', 'selected');
                            $(tagFormat).attr('selected', 'selected');
                            $(tagDate).val(data.public_date);
                            //image
                            var tagImage = '#popEdit img#old-portal';
                            $(tagImage).attr('src', '{{url().'/uploads/'}}' + data.portal);

                            //des
                            CKEDITOR.instances['up-description'].setData(data.description);
                            //price
                            var tag = '#popEdit input.cb-group-price';
                            var tagRootPrice = '#popEdit input#root_price';
                            var tagPrice = '#popEdit input#price';
                            var tagSale = '#popEdit input#sale_off';
                            var tagCost = '#popEdit input#cost';
                            var tagPriceGroup = '#popEdit select#price_group';
                            var cbPriceGroup = '#popEdit input.cb-group-price';
                            if (data.group_price_id == 0) {
                                $(tagRootPrice).val(data.root_price);
                                $(tagPrice).val(data.price);
                                $(tagSale).val(data.sale_off);
                                $(cbPriceGroup).removeAttr('checked');
                                $(tagCost).val(parseFloat(data.price*data.sale_off*0.01+data.price));
                                offGroupPrice(tag);
                            } else {
                                $(tagCost).val(parseFloat(data.price*data.sale_off*0.01+data.price));
                                var fullTagPriceGroup = tagPriceGroup + ' option[value=' + data.price_g_id + ']';
                                $(fullTagPriceGroup).attr('selected', 'selected');
                                $(cbPriceGroup).attr('checked', 'checked');
                                onGroupPrice(tag);

                            }

                        }
                    });
                    $(parent).modal("show");
                });

            });
        })

        CKEDITOR.replace('description');
        CKEDITOR.replace('up-description');
    </script>
@stop