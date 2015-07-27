<div class="modal fade " id="popDelete" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Warnning</h4>
            </div>
            <div class="modal-body">
                Are you sure?
            </div>
            <div class="modal-footer">
                {!!Form::open(array('action'=>['AccountController@destroy']))!!}
                <input type="hidden" name="id" id="id" class="form-control" value=""/>
                <button type="button" class="btn btn-default x-modal" data-dismiss="modal">Cancel
                </button>
                <button type="submit" data-target="#popDelete" class="btn btn-primary btnDelFocus">Delete</button>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>