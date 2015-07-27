@extends('layout.backend.master')
@include(('account.del'))
@include(('account.edit'))
@section('content')
    <div class="row">
        <div class="col-md-8 col-sm-8 col-xs-8 filter">
            @foreach($role as $k=> $aRole)
                <button type="button" class=" btn btn-info btn-sm btnRole"
                        value="{{$aRole['id']}}" id=""  >
                    <i class="glyphicon glyphicon-user"></i> {{$aRole['name']}}
                </button>
            @endforeach
        </div>
    </div>
    <div class="portlet-body">

        <table id="grid-command-buttons" class="table table-condensed table-hover table-striped">
            <thead>
            <tr>
                <th data-column-id="id" data-type="numeric">ID</th>
                <th data-column-id="name">Name</th>
                <th data-column-id="role">Role</th>
                <th data-column-id="email">Email</th>
                <th data-column-id="phone">Phone</th>
                <th data-column-id="status" data-formatter="status">Status</th>
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
            $('.btn-toggle-pop-add').click(function () {
                $('#add').slideToggle('slow');
            });
//            $('.t').append('<button class="btn btn-primary glyphicon glyphicon-edit btn-sm btnEdit command-edit" data-toggle="modal" data-target="#popEdit"/> ');
            $("#grid-command-buttons").bootgrid({
                ajax: true,
                post: function () {
                    /* To accumulate custom parameter with the request object */
                    return {
                        _token: '{{csrf_token()}}'
                    };
                },
                url: "{{URL::action('AccountController@getDataAjax')}}",
                formatters: {
                    "option": function (column, row) {
                        var r = '<button class="btn btn-primary glyphicon glyphicon-edit btn-sm btnEdit command-edit"';
                        r += 'data-row-id="' + row.id + '" id="' + row.id + '" data-toggle="modal" data-target="#popEdit"/>';
                        r += '<button class="btn btn-danger glyphicon glyphicon-remove btn-sm btnDel command-delete"';
                        r += 'data-row-id="' + row.id + '" id="' + row.id + '" data-toggle="modal" data-target="#popDelete"/>';

                        return r;
                    },
                    "status": function (column, row) {
                        var status = 'Pending Active';
                        if (row.status == '1') {
                            status = 'Actived'
                        }

                        return status;
                    }


                }

            }).on("loaded.rs.jquery.bootgrid", function () {
                /* Executes after data is loaded and rendered */
                $(".command-edit").on("click", function (e) {
                    var id = $(this).attr('id');
                    $('#popEdit input#id[type="hidden"]').val(id);

//            var data={_token:$(this).data('token'),'id':id};
                    $.ajax({
                        url: '{{action('AccountController@getDataUser')}}',
                        method: 'post',
                        data: {id: id, _token: '{{csrf_token()}}'},
                        dataType: 'json',
                        success: function (data) {
                            var status = data.status;
                            $('#popEdit th#name').text(data.name);
                            $('#popEdit img#old_avatar').attr('src', '{{url().'/uploads/'}}' + data.image);
                            $('#popEdit input#phone').attr('value', data.phone);
                            $('#popEdit input#email').attr('value', data.email);
                            $('#popEdit #select_department').attr('value', data.role_id);
                            $('#popEdit a.department').html(data.role);
                            var tagRadio = '#popEdit input[type=radio][value=' + status + ']';
                            var tagSelect = '#popEdit option[value=' + data.role_id + ']';
                            $(tagRadio).attr('checked', 'checked');
                            $(tagSelect).attr('selected', 'selected');
                        }
                    });
                    $($(this).attr("data-target")).modal("show");
                });
                $(".command-delete").on("click", function (e) {
                    $('#popDelete input#id[type="hidden"]').val($(this).attr('id'));
                    $($(this).attr("data-target")).modal("show");

                });
                $('#popEdit button.close,#popEdit button.x-modal').on("click", function (e) {
                    $($(this).attr("data-target")).modal("hide");
                });
                $('#popDelete button.close,#popDelete button.x-modal').on("click", function (e) {
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
        $('.filter .btnRole').click(function(){
            value=$(this).attr('value');
            $.ajax({
                method:'post',
                url:'{{action('AccountController@filterRole')}}',
                data:{_token:'{{csrf_token()}}',id:value}
            }).success(function(data){
                $("#grid-command-buttons").bootgrid('reload');
            });
        });
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
            $('#myImg').attr('height', 100);
        }
        ;
    </script>
@stop