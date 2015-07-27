<div class="modal fade " id="popAdd" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add New</h4>
            </div>
            <div class="modal-body">
                <input type="text" name="name" id="path" class="form-control" value="" title="" >
                {{--<hr/>--}}
                <div class="modal-footer">


                    {{--</form>--}}
                    <input type="hidden" name="" id="old_path" class="form-control" value=""/>
                    <button type="button" class="btn btn-default x-modal" data-dismiss="modal">Cancel
                    </button>
                    <button type="button" data-target="#popAdd" class="btn btn-primary btnAddFocus">Add</button>
                </div>
            </div>
        </div>
    </div>
</div>
