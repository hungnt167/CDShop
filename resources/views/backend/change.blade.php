<div class="modal fade " id="popChange" tabindex="-1" role="dialog"
<div class="modal fade " id="popChange" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Warnning</h4>
            </div>
            <div class="modal-body">
                Are you sure change this status?
            </div>
            {!!Form::open(array('action'=>'OrderController@changeStatus'
            ,'method'=>'POST','files'=>true))!!}
            <div class="modal-footer">
                <input type="hidden" name="id" id="id"  >
                <input type="hidden" name="status" id="status"  >
                <hr/>
                <button type="button" class="btn btn-default x-modal" data-dismiss="modal">Cancel
                </button>
                <button type="submit" data-target="#popChange" class="btn btn-primary btnChangeFocus">Change</button>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>