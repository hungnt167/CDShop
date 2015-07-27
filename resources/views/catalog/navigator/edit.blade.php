<div class="modal fade " id="popEdit" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit</h4>
                <p class="ck"></p>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <td>Uri:</td>
                        <td>
                            <input type="text" name="name" id="uri" class="form-control" value="" title="">
                            <input type="hidden" name="name" id="oldUri" class="form-control" value="" title="">
                        </td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <input type="hidden" name="name" id="oldNavigator" class="form-control" value="" title="">
                        <td><input type="text" name="name" id="newNavigator" class="form-control" value="" title=""></td>
                    </tr>
                    <tr>
                        <td>Position:</td>
                        <td>
                            <input type="hidden" id="oldPosition">
                            <select name="name" id="position" class="form-control" value="" title="">

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Parent:</td>
                        <td>
                            <input type="hidden" id="oldParent">
                            <select name="name" id="parent" class="form-control" value="" title="">
                            </select>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="radio">
                    <input type="hidden" id="oldStatus">
                    <label>
                        <input type="radio" name="active" class="is-active" value="1" >
                        Active
                    </label>
                    <label>
                        <input type="radio" name="active" class="is-active" value="0">
                        InActive
                    </label>
                </div>
            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default x-modal" data-dismiss="modal">Cancel
                </button>
                <button type="button" data-target="#popEdit" class="btn btn-primary Focus btnUpdateFocus">Update</button>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>