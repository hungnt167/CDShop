<div class="modal fade " id="popEdit" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit</h4>
            </div>
            <div class="modal-body">
                Are you sure?
            </div>
            <div class="modal-footer">

                {!!Form::open(array('method'=>'POST','files'=>true))!!}
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <input type="text" name="name" id="path" class="form-control" value="" title="" >
                    <hr/>
                </div>

                {{--</form>--}}
                <input type="hidden" name="" id="old_path" class="form-control" value=""/>
                <button type="button" class="btn btn-default x-modal" data-dismiss="modal">Cancel
                </button>
                <button type="button" data-target="#popEdit" class="btn btn-primary btnUpdateFocus">Update</button>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>