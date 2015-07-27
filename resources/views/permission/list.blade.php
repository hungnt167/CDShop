@extends('layout.backend.master')
@include(('permission.del'))
@include(('permission.edit'))
@include(('permission.create'))
@section('content')

    <div class="portlet-body">
        <button class="btn btn-sm btn-success " data-toggle="modal" data-target="#popAdd"><i class="glyphicon glyphicon-plus"></i>Add</button>
        <hr/>
        <table id="grid-keep-selection" class="table table-condensed table-hover table-striped">
            <thead>
            <tr>
                <th data-column-id="id" data-type="numeric">ID</th>
                <th data-column-id="name">Name</th>
                @foreach($role as $aRole)
                    <th data-column-id="{{$aRole['id']}}" data-formatter="{{$aRole['name']}}">{{$aRole['name']}}</th>
                @endforeach
                <th data-column-id="action" data-formatter="option" data-sortable="false">Option</th>
            </tr>
            </thead>

        </table>
    </div>

@stop
@section('script')
    <script>
        //
        $(document).ready(function () {

//            $('.t').append('<button class="btn btn-primary glyphicon glyphicon-edit btn-sm btnEdit command-edit" data-toggle="modal" data-target="#popEdit"/> ');
            $("#grid-keep-selection").bootgrid({
                ajax: true,
                post: function () {
                    /* To accumulate custom parameter with the request object */
                    return {
                        _token: '{{csrf_token()}}'
                    };
                },
                url: "{{URL::action('PermissionController@getDataAjax')}}",
                selection: true,
                multiSelect: true,
                rowSelect: true,
                keepSelection: true,
                formatters: {
                    "option": function (column, row) {
                        var r = '<button class="btn btn-primary glyphicon glyphicon-edit btn-sm btnEdit command-edit"';
                        r += 'data-row-id="' + row.id + '" id="' + row.name + '" data-toggle="modal" data-target="#popEdit"/>';
                        r += '<button class="btn btn-danger glyphicon glyphicon-remove btn-sm btnDel command-delete"';
                        r += 'data-row-id="' + row.id + '" id="' + row.name + '" data-toggle="modal" data-target="#popDelete"/>';

                        return r;
                    }
                }

            }).on("loaded.rs.jquery.bootgrid", function () {
                /* Executes after data is loaded and rendered */
                $('input[type=checkbox]').click(function () {
                    var col = ($(this).attr('col'));
                    var path = ($(this).attr('data'));
                    $.ajax({
                        url: '{{action('PermissionController@updateByAjax')}}',
                        method: 'post',
                        data: {path: path,col:col, _token: '{{csrf_token()}}'},
                        success:function(data){
                            $("#grid-keep-selection").bootgrid('reload');
                        }
                    })
                });
                $(".command-edit").on("click", function (e) {
                    var path=$(this).attr('id');
                    $('#popEdit input#path').val(path);
                    $('#popEdit input#old_path').val(path);
                    $($(this).attr("data-target")).modal("show");
                });
                //do Add
                $("#popAdd button.btnAddFocus").on("click", function (e) {
                    var path = $('#popAdd input#path').val();
                    $.ajax({
                        url: '{{action('PermissionController@createByAjax')}}',
                        method: 'post',
                        data: {path: path, _token: '{{csrf_token()}}'},
                        success:function(data){
                            $('#popAdd').modal("hide");
                            $("#grid-keep-selection").bootgrid('reload');
                        }
                    })
                    $($(this).attr("data-target")).modal("hide");

                });
                //check path
                $('#popEdit input#path').keyup(function(){
                    var path = $('#popEdit input#path').val();
                    var old_path = $('#popEdit input#old_path').val();
                    if(path!=old_path){
                        $.ajax({
                            url: '{{action('PermissionController@checkPathByAjax')}}',
                            method: 'post',
                            data: {path: path, _token: '{{csrf_token()}}'},
                            dataType:'json',
                            success:function(data){
                                if(data.type=='s'){
                                    $("#popEdit input#path").css('border-color','#337ab7');
                                    $("#popEdit button.btnUpdateFocus").show();
                                }else{
                                    $("#popEdit input#path").css('border-color','#d9534f');
                                    $("#popEdit button.btnUpdateFocus").hide();
                                }
                            }
                        })
                    }
                });
                //do update
                $("#popEdit button.btnUpdateFocus").on("click", function (e) {
                    var path = $('#popEdit input#path').val();
                    var old_path = $('#popEdit input#old_path').val();
                    if(path!=old_path){
                        $.ajax({
                            url: '{{action('PermissionController@updatePathByAjax')}}',
                            method: 'post',
                            data: {path: path,old_path:old_path, _token: '{{csrf_token()}}'},
                            success:function(data){
                                $("#grid-keep-selection").bootgrid('reload');
                            }
                        })
                    }
                    $($(this).attr("data-target")).modal("hide");
                });
                $(".command-delete").on("click", function (e) {
                    var path=$(this).attr('id');
                    $('#popDelete input#path').val(path);
                    $($(this).attr("data-target")).modal("show");
                });
                //do delete btnDelFocus
                $("#popDelete button.btnDelFocus").on("click", function (e) {
                    var path = $('#popDelete input#path').val();
                    $.ajax({
                        url: '{{action('PermissionController@destroyByAjax')}}',
                        method: 'post',
                        data: {path: path, _token: '{{csrf_token()}}'},
//                        dataType: 'json',
                        success:function(data){
                            $("#grid-keep-selection").bootgrid('reload');
                        }
                    })
                    $($(this).attr("data-target")).modal("hide");
                });

                $('select#select_status').change(function () {
                    $('#popEdit #status').val($(this).val());
                });
                $('select#select_department').change(function () {
                    $('#popEdit #department').val($(this).val());
                });
                $('a.button').click(function () {
                    $('.alert').attr('style', 'display:none')
                });
            });

        });

    </script>
@stop