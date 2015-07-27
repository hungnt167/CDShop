@extends('layout.backend.master')
@include(('catalog.artist.del'))
@include(('catalog.artist.edit'))
@include(('catalog.artist.create'))
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
                <th data-column-id="action" data-formatter="option" data-sortable="false">Option</th>
            </tr>
            </thead>

        </table>
    </div>
@stop
@section('script')
    <script src="{{asset('/js/ckeditor.js')}}"></script>
    <script>



        function clearInput() {
            $('input#newCatalog').val('');
            $('input#uri').val('');
            $("#popEdit button.btnUpdateFocus,#popAdd button.btnAddFocus").show();
            $("#popEdit input,#popAdd input").css('border-color', '#f8f8f8');

        }
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

        $(document).ready(function () {

            $("#grid-command-buttons").bootgrid({
                ajax: true,
                post: function () {
                    /* To accumulate custom parameter with the request object */
                    return {
                        _token: '{{csrf_token()}}'
                    };
                },
                url: "{{URL::action('ArtistController@getDataAjax')}}",
                formatters: {
                    "option": function (column, row) {
                        var r = '<button class="btn btn-primary glyphicon glyphicon-edit btn-sm btnEdit command-edit"';
                        r += 'data-row-id="' + row.id + '" id="' + row.id + '" data="'+row.name+'" data-toggle="modal" data-target="#popEdit"/>';
                        r += '<button class="btn btn-danger glyphicon glyphicon-remove btn-sm btnDel command-delete"';
                        r += 'data-row-id="' + row.id + '" id="' + row.id + '" data="'+row.name+'" data-toggle="modal" data-target="#popDelete"/>';

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
                    $('#popDelete input#name').val($(this).attr('data'));
                    var parent = $(this).attr("data-target");
                    $(parent).modal("show");
                });
                $('button.btnEdit ').click(function () {
                    clearInput();
                    var parent = $(this).attr("data-target");
                    var artist = $(this).attr("id");
                    $.ajax({
                        url: '{{action('ArtistController@getDataArtist')}}',
                        method: 'post',
                        data: {id: artist, _token: '{{csrf_token()}}'},
                        dataType: 'json',
                        success: function (data) {
                            $('#popEdit input#id').val(data.id);
                            $('#popEdit input#name').val(data.name);
                            $('#popEdit img#image').attr('src', '{{url().'/uploads/'}}'+data.avatar);
                            var tagTalent = '#popEdit select#talent option[value=' + data.talent + ']';
                            $(tagTalent).attr('selected', 'selected');
                            CKEDITOR.instances['up-description'].setData(data.description);
                        }
                    });
                    $(parent).modal("show");
                });
            });
        });

        CKEDITOR.replace( 'description' );
        CKEDITOR.replace( 'up-description' );
    </script>
@stop