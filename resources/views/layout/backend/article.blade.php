
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">
                {{ $title or 'Admin Dashboard' }}
                <span class="other-article">{{ $other or '' }}</span>
            </h3>
        </div>
        <!-- /.col-lg-12 -->
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
@endif