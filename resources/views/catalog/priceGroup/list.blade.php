@extends('layout.backend.master')
@include(('catalog.priceGroup.del'))
@include(('catalog.priceGroup.edit'))
@include(('catalog.priceGroup.create'))
@section('content')
    <div class="row">
        <div class="col-md-4 col-sm-8 col-xs-8 option-nav">
            <button data-target="#popAdd" type="button" id="" class="btn btn-success btn-sm btnAdd"><i
                        class="glyphicon glyphicon-plus"></i> Add new
            </button>
        </div>
    </div>
    <div class="portlet-body">

        <table id="grid-command-buttons" class="table table-condensed table-hover table-striped">
            <thead>
            <tr>
                <th data-column-id="id" data-type="numeric">ID</th>
                <th data-column-id="name">Name</th>
                <th data-column-id="root_price">Root Price</th>
                <th data-column-id="price">Price</th>
                <th data-column-id="sale_off">Sale off</th>
                <th data-column-id="action" data-formatter="option" data-sortable="false">Option</th>
            </tr>
            </thead>

        </table>
    </div>
@stop
@section('script')
    <script>


        function clearInput() {
            $('input#newCatalog').val('');
            $('input#uri').val('');
            $("#popEdit button.btnUpdateFocus,#popAdd button.btnAddFocus").show();
            $("#popEdit input,#popAdd input").css('border-color', '#f8f8f8');

        }

        $(document).ready(function () {

            $("#grid-command-buttons").bootgrid({
                ajax: true,
                post: function () {
                    /* To accumulate custom parameter with the request object */
                    return {
                        _token: '{{csrf_token()}}'
                    };
                },
                url: "{{URL::action('PriceGroupController@getDataAjax')}}",
                formatters: {
                    "option": function (column, row) {
                        var r = '<button ' +
                                'class="btn btn-primary glyphicon glyphicon-edit btn-sm btnEdit command-edit"' +
                                ' root_price="' + row.root_price +
                                '" price="'+row.price +
                                '" sale_off="'+row.sale_off;
                        r += '" data-row-id="' + row.id +
                        '" id="' + row.id +
                        '" name="' + row.name + '" ' +
                        'data-toggle="modal" ' +
                        'data-target="#popEdit"/>';
                        r += '<button class="btn btn-danger glyphicon glyphicon-remove btn-sm btnDel command-delete"';
                        r += 'data-row-id="' + row.id + '" id="' + row.id + '" name="' + row.name + '" data-toggle="modal" data-target="#popDelete"/>';

                        return r;
                    }
                }

            }).on("loaded.rs.jquery.bootgrid", function () {
                $('button.btnAdd ').click(function () {
                    clearInput();
                    var parent = $(this).attr("data-target");
                    $(parent).modal("show");
                });
                $('button.btnDel ').click(function () {
                    $('#popDelete input#id[type="hidden"]').val($(this).attr('id'));
                    $('#popDelete input#name').val($(this).attr('name'));
                    var parent = $(this).attr("data-target");
                    $(parent).modal("show");
                });
                $('button.btnEdit ').click(function () {
                    clearInput();
                    var id=$(this).attr('id');
                    var name=$(this).attr('name');
                    var root_price=$(this).attr('root_price');
                    var price=$(this).attr('price');
                    var sale_off=$(this).attr('sale_off');
                    $('#popEdit input#id[type="hidden"]').val(id);
                    $('#popEdit input#name').val(name);
                    $('#popEdit input#root_price').val(root_price);
                    $('#popEdit input#price').val(price);
                    $('#popEdit input#sale_off').val(sale_off);
                    var parent = $(this).attr("data-target");
                    $(parent).modal("show");
                });
            });
        });

        CKEDITOR.replace('description');
    </script>
@stop