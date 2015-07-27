<div class="row" style="padding-top: 5px;padding-bottom: 5px;background: #72b572 ">

    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-left">
        <a class="btn btn-default btn-xs" id="menu-toggle">
            <b class="glyphicon glyphicon-resize-horizontal"></b>
        </a>
        <small>{!! $title or 'Guest' !!}</small>
    </div>

    @if(isset($hasFilter ))
        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-right">
            <form action="{{Request::url()}}" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <small>
                    <label>Price:</label>
                    <select name="price" id="inputID">
                        <option value="0">Ascending</option>
                        <option value="1">Decreasing</option>
                    </select>
                </small>
                <small>

                    <label>Public date:</label>
                    <select name="public_date" id="inputID">
                        <option value="0">Sooner</option>
                        <option value="1">Older</option>
                    </select>
                </small>
                <small>
                    <label>Name Album:</label>
                    <select name="name" id="inputID">
                        <option value="0">Ascending</option>
                        <option value="1">Decreasing</option>
                    </select>
                </small>
                <small>
                    <button type="submit" class="btn-info btn btn-xs"><b class="glyphicon glyphicon-filter"></b>Filler
                    </button>
                </small>
            </form>
        </div>
    @endif
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">&times;</button>
        @foreach($errors->all() as $error)
            <p>{{  $error}}</p>
        @endforeach
    </div>
@elseif(Session::has('success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">&times;</button>
        <strong>Success</strong> {!! Session::get('success') !!}
    </div>
@elseif(Session::has('error'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">&times;</button>
        <strong>Error</strong> {!! Session::get('error') !!}
    </div>
@endif
