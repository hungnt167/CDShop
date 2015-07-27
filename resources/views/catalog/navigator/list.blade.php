@extends('layout.backend.master')
@include(('catalog.navigator.del'))
@include(('catalog.navigator.edit'))
@include(('catalog.navigator.create'))
@section('style')
    {{--//jstree--}}
    <link href="{{asset('/css/style.min.css')}}" rel="stylesheet" type="text/css">
@stop
@section('content')

    <input type="hidden" name="name" id="inPage" disabled class="form-control" value="0" title="">
    <div class="row">
        <div class="col-md-4 col-sm-8 col-xs-8 option-nav">
            <button type="button" class="btn btn-success btn-sm btnTreeFontEnd"><i
                        class="glyphicon glyphicon-arrow-left"></i> FrontEnd
            </button>
            <button type="button" class="btn btn-warning btn-sm btnTreeBackEnd"><i
                        class="glyphicon glyphicon-arrow-right"></i> Backend
            </button>
            <button type="button" class="btn btn-warning btn-sm btnRefresh"><i
                        class="glyphicon glyphicon-refresh"></i> Refresh
            </button>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-8 col-sm-8 col-xs-8 option-bar">
            <button type="button" class="btn btn-success btn-sm btnAddRoot" data-target="#popAdd"><i
                        class="glyphicon glyphicon-tower"></i> Create Root
            </button>
            <button type="button" class="btn btn-success btn-sm btnAdd" data-target="#popAdd"><i
                        class="glyphicon glyphicon-asterisk"></i> Create Sub
            </button>
            <button type="button" class="btn btn-warning btn-sm btnEdit" data-target="#popEdit"><i
                        class="glyphicon glyphicon-pencil"></i> Edit
            </button>
            <button type="button" class="btn btn-danger btn-sm btnDel" data-target="#popDelete"><i
                        class="glyphicon glyphicon-remove"></i> Delete
            </button>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-4" style="text-align:right;">

        </div>
    </div>
    <input type="hidden" value="" id="currentNavigator"/>
    <span id="event_result"></span>
    <hr/>
    <div id="jstree">

    </div>

@stop
@section('script')
    {{--//jstree--}}
    <script src="{{asset('/js/jstree.min.js')}}"></script>
    <script>

        function doAlert(data) {
            if (data.type == 'e') {
                $('.alert-notify .alert-title').html("Error!");
                $('.alert-notify .alert-content').html(data.message);
            } else if (data.type == 's') {
                $('.alert-notify .alert-title').html("Success!");
                $('.alert-notify .alert-content').html(data.message);
            }
            setTimeout(function () {
                $('.alert-notify').html("");
                $('.alert-notify').html();
            }, 5000);
        }
        ;
        function getCurrentPage() {
            var page = $('#inPage').val();
            return page;
        }
        function clearInput() {
            $('input#newNavigator').val('');
            $('input#uri').val('');
            $("#popEdit button.btnUpdateFocus,#popAdd button.btnAddFocus").show();
            $("#popEdit input,#popAdd input").css('border-color', '#f8f8f8');

        }
        function getCurrentCatalog() {
            return $('input#currentNavigator').val();
        }
        function refreshTree() {
            $('#jstree').jstree(true).refresh();
        }
        ;
        $(document).ready(function () {


            /********* CODE *********/

            $('.option-nav button.btnTreeFontEnd').click(function () {
                        $('#inPage').val(0);
                        $('span.other-article').html('Frontend');
                        $('#jstree').jstree(true).refresh();
                    }
            );
            $('.option-nav button.btnTreeBackEnd').click(function () {
                        $('#inPage').val(1);
                        $('span.other-article').html('Backend');
                        $('#jstree').jstree(true).refresh();
                    }
            );
            $('.option-nav button.btnRefresh').click(function () {
                        location.reload();
                    }
            );

            $("#jstree").jstree({
                "core": {
                    // so that create works
                    "check_callback": true,
                    'data': {
                        'url': '{{action('NavigatorController@getDataForTree')}}',
                        'method': 'post',
                        'data': function (node) {
                            return {'id': node.id, in_page: getCurrentPage(), _token: '{{csrf_token()}}'};
                        }
                    }
                },
                "plugins": ["state", "types", "wholerow", 'jsondata']

            }).on('changed.jstree', function (e, data) {
                var i, j, r = [];
                for (i = 0, j = data.selected.length; i < j; i++) {
                    r.push(data.instance.get_node(data.selected[i]).text);
                }
                $('input#currentNavigator').val(r.join(', '));
                $('#event_result').html('Selected: ' + r.join(', '));
            })
                // create the instance
                    .jstree();
            ;

            $('select').on('change', function () {
                $(this).find('option[selected=selected]').attr('selected', false);
                $(this).find(':selected').attr('selected', 'selected');
            });
            //Add Root
            $('.option-bar button.btnAddRoot').click(function () {
                clearInput();
                var current = getCurrentCatalog();
                if (current == '') {
                    $('select#parent').parent().parent().hide()
                    $.ajax({
                        url: '{{action('NavigatorController@getListPosition')}}',
                        method: 'post',
                            data: {navigator: 'root', op: 'new', in_page: getCurrentPage(), _token: '{{csrf_token()}}'}
                    }).success(function (data) {
                        $('select#position').html(data);
                    });

                    var parent = $(this).attr("data-target");
                    $(parent).modal("show");
                }
            });
            //Add sub
            $('.option-bar button.btnAdd').click(function () {
                var navigator = getCurrentCatalog();
                if (navigator.length != 0) {
                    clearInput();
                    $('select#parent').parent().parent().show()

                    if (navigator != '') {
                        $.ajax({
                            url: '{{action('NavigatorController@listForDOM')}}',
                            method: 'post',
                            data: {page: getCurrentPage(), _token: '{{csrf_token()}}'},
                            success: function (data) {
                                $('#popAdd select#parent').html(data);
                                $.ajax({
                                    url: '{{action('NavigatorController@getDataNavigator')}}',
                                    method: 'post',
                                    data: {navigator: navigator, _token: '{{csrf_token()}}'},
                                    dataType: 'json',
                                    success: function (data) {
                                        var parent = data.id;
                                        var tagParent = '#popAdd select option[value=' + parent + ']';
                                        $(tagParent).attr('selected', 'selected');
                                        $.ajax({
                                            url: '{{action('NavigatorController@getListPosition')}}',
                                            method: 'post',
                                            data: {
                                                navigator: navigator,
                                                op: 'new',
                                                in_page: getCurrentPage(),
                                                _token: '{{csrf_token()}}'
                                            }
                                        }).success(function (data) {
                                            $('select#position').html(data);
                                        });
                                    }
                                });
                            }
                        });
                    }
                    var parent = $(this).attr("data-target");
                    $(parent).modal("show");
                }
            });
            $('.option-bar button.btnEdit').click(function () {
                clearInput();

                var navigator = getCurrentCatalog();
                if (navigator.length != 0) {
                    $('input#newNavigator').val(navigator);
                    $('input#oldNavigator').val(navigator);
                    if (navigator != '') {
                        $.ajax({
                            url: '{{action('NavigatorController@listForDOM')}}',
                            method: 'post',
                            data: {in_page: getCurrentPage(), _token: '{{csrf_token()}}'},
                            success: function (data) {
                                var tagRoot = '<option value="0">-Root</option>'
                                $('#popEdit select#parent').html(tagRoot + data);

                                $.ajax({
                                    url: '{{action('NavigatorController@getListPosition')}}',
                                    method: 'post',
                                    data: {
                                        navigator: navigator, op: 'update',
                                        in_page: getCurrentPage(),
                                        _token: '{{csrf_token()}}'
                                    }
                                }).success(function (data) {
                                    $('select#position').html(data);
                                    $.ajax({
                                        url: '{{action('NavigatorController@getDataNavigator')}}',
                                        method: 'post',
                                        data: {navigator: navigator, _token: '{{csrf_token()}}'},
                                        dataType: 'json',
                                        success: function (data) {
                                            var parent = data.parent_id;
                                            var status = data.status;
                                            var position = data.position;
                                            $('#popEdit input#uri').val(data.uri);
                                            $('#popEdit input#oldUri').val(data.uri);
                                            var tagStatus = '#popEdit input[type=radio][value=' + status + ']';
                                            var tagParent = '#popEdit select#parent option[value=' + parent + ']';
                                            var tagPosition = '#popEdit select#position option[value=' + position + ']';
                                            $(tagStatus).attr('checked', 'checked');
                                            $(tagParent).attr('selected', 'selected');
                                            $(tagPosition).attr('selected', 'selected');
                                            $('input#oldPosition').val($('#popEdit select#position option[selected=selected]').val());
                                            $('input#oldStatus').val($('input.is-active[checked=checked]').val());
                                            $('input#oldParent').val($('#popEdit select#parent option[selected=selected]').val());
                                        }
                                    });
                                });
                            }
                        });
                    }

                    var parent = $(this).attr("data-target");
                    $(parent).modal("show");
                }
            });
            $('.option-bar button.btnDel').click(function () {

                var navigators = getCurrentCatalog();
                if (navigators.length != 0) {
                    $('#popDelete input#navigator').val(navigators);
                    var parent = $(this).attr("data-target");
                    $(parent).modal("show");
                }
            });


            //do Add
            $("#popAdd button.btnAddFocus").on("click", function (e) {

                var parent_id = $('#popAdd select#parent').find('option[selected=selected]').val();
                var uri = $('#popAdd input#uri').val();
                var position = $('#popAdd select#position').val();
                var nameNavigator = $('#popAdd input#newNavigator').val();
                var isActive = $('#popAdd input.is-active[checked=checked]').val();
                var inPage = $('input#inPage').val();
                if (position != '' && nameNavigator != '') {
                    $.ajax({
                        url: '{{action('NavigatorController@createByAjax')}}',
                        method: 'post',
                        data: {
                            parent_id: parent_id,
                            uri: uri,
                            position: position,
                            nameNavigator: nameNavigator,
                            status: isActive,
                            in_page: inPage,
                            _token: '{{csrf_token()}}'
                        },
                        success: function (data) {
                            refreshTree()
                        }
                    })
                }
                $($(this).attr("data-target")).modal("hide");

            });
            //check path Add
            $('#popAdd input#uri').keyup(function () {
                var path = $('#popAdd input#uri').val();
                if (path != '') {
                    $.ajax({
                        url: '{{action('NavigatorController@checkPathByAjax')}}',
                        method: 'post',
                        data: {path: path, op: 'new', _token: '{{csrf_token()}}'},
                        success: function (data) {
                            if (data.type == 's') {
                                $("#popAdd input#uri").css('border-color', '#337ab7');
                                $("#popAdd button.Focus").show();
                            } else {
                                $("#popAdd input#uri").css('border-color', '#d9534f');
                                $("#popAdd button.Focus").hide();
                            }
                            $("#popAdd p.ck").html(data.message);
                        }
                    })
                }
            });
            //check path Update
            $('#popEdit input#uri').keyup(function () {
                var path = $('#popEdit input#uri').val();
                var old_path = $('#popEdit input#oldUri').val();
                if (path != old_path && path != '') {
                    $.ajax({
                        url: '{{action('NavigatorController@checkPathByAjax')}}',
                        method: 'post',
                        data: {op: 'update', path: path, oldPath: old_path, _token: '{{csrf_token()}}'},
                        dataType: 'json',
                        success: function (data) {
                            if (data.type == 's') {
                                $("#popEdit input#uri").css('border-color', '#337ab7');
                                $("#popEdit button.btnUpdateFocus").show();
                            }
                            if (data.type == 'e') {
                                $("#popEdit input#uri").css('border-color', '#d9534f');
                                $("#popEdit button.btnUpdateFocus").hide();
                            }
                            $("#popEdit p.ck").html(data.message);

                        }
                    })
                }
            });
            //check name Update
            $('#popEdit input#newNavigator').keyup(function () {
                var name = $('#popEdit input#newNavigator').val();
                var old_name = $('#popEdit input#oldNavigator').val();
                var in_page = getCurrentPage();
                if (name != old_name) {
                    $.ajax({
                        url: '{{action('NavigatorController@checkNameByAjax')}}',
                        method: 'post',
                        data: {op: 'update', name: name, oldName: old_name, in_page: in_page, _token: '{{csrf_token()}}'},
                        dataType: 'json',
                        success: function (data) {

                            if (data.type == 's') {
                                $("#popEdit input#newNavigator").css('border-color', '#337ab7');
                                $("#popEdit button.btnUpdateFocus").show();
                            } else {
                                $("#popEdit input#newNavigator").css('border-color', '#d9534f');
                                $("#popEdit button.btnUpdateFocus").hide();
                            }
                            $("#popEdit p.ck").html(data.message);
                        }
                    })
                }
            });
            //check name Add
            $('#popAdd input#newNavigator').keyup(function () {
                var name = $('#popAdd input#newNavigator').val();
                var inPage = getCurrentPage();
                $.ajax({
                    url: '{{action('NavigatorController@checkNameByAjax')}}',
                    method: 'post',
                    data: {op: 'new', name: name, in_page: inPage, _token: '{{csrf_token()}}'},
                    dataType: 'json',
                    success: function (data) {
                        if (data.type == 's') {
                            $("#popAdd input#newNavigator").css('border-color', '#337ab7');
                            $("#popAdd button.btnAddFocus").show();
                        } else {
                            $("#popAdd input#newNavigator").css('border-color', '#d9534f');
                            $("#popAdd button.btnAddFocus").hide();
                        }
                        $("#popAdd p.ck").html(data.message);
                    }
                })
            });
            //do update
            $("#popEdit button.btnUpdateFocus").on("click", function (e) {
                var uri = $('input#uri').val();
                var oldUri = $('input#oldUri').val();
                var newNavigator = $('input#newNavigator').val();
                var oldNavigator = $('input#oldNavigator').val();
                var position = $('select#position option[selected=selected]').val();
                var oldPosition = $('input#oldPosition').val();
                var parent = $('select#parent option[selected=selected]').val();
                var oldParent = $('input#oldParent').val();
                var status = $('input.is-active[checked=checked]').val();
                var oldStatus = $('input#oldStatus').val();
                var inPage = $('input#inPage').val();
                if (position == undefined) {
                    position = '';
                }
                if ((newNavigator != '' && newNavigator != oldNavigator) ||
                        uri != oldUri || oldParent != parent ||
                        oldPosition != position || oldStatus != status) {
                    $.ajax({
                        url: '{{action('NavigatorController@updateByAjax')}}',
                        method: 'post',
                        data: {
                            navigator: newNavigator,
                            oldNavigator: oldNavigator,
                            uri: uri,
                            oldUri: oldUri,
                            parent_id: parent,
                            position: position,
                            status: status,
                            in_page: inPage,
                            _token: '{{csrf_token()}}'
                        },
                        dataType: 'json'
                    }).success(function (data) {
                        doAlert(data);
                        refreshTree();
                    });
                }

                $($(this).attr("data-target")).modal("hide");
            });

            //do delete btnDelFocus
            $("#popDelete button.btnDelFocus").click(function (e) {
                var navigator = $('input#currentNavigator').val();
                var inPage = $('input#inPage').val();
                if (navigator != '') {
                    $.ajax({
                        url: '{{action('NavigatorController@destroyByAjax')}}',
                        method: 'post',
                        data: {navigator: navigator, in_page: inPage, _token: '{{csrf_token()}}'},
                        success: function (data) {
                            refreshTree();
                        }
                    });
                }
                $($(this).attr("data-target")).modal("hide");
            });

            $('a.button').click(function () {
                $('.alert').attr('style', 'display:none')
            });
        });

    </script>
@stop