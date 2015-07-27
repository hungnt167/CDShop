<div class="modal fade " id="popAdd" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add New Navigator</h4>
            </div>
            <div class="modal-body">

                <table class="table table-hover">
                    <tbody>

                    <tr>
                        <td>Parent:</td>


                        <td>
                            <select name="name" id="parent" class="form-control" value="" title="">
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Uri:</td>
                        <td><input type="text" name="name" id="uri" class="form-control" value="" title=""></td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td><input type="text" name="name" id="newNavigator" class="form-control" value="" title=""></td>
                    </tr>

                    <tr>
                        <td>Position:</td>
                        <td>
                            <select name="name" id="position" class="form-control" value="" title="">

                            </select>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div class="radio">
                    <label>
                        <input type="radio" name="active" class="is-active" value="1" checked="checked">
                        Active
                    </label>
                    <label>
                        <input type="radio" name="active" class="is-active" value="0">
                        InActive
                    </label>
                </div>

                {{--<hr/>--}}
                <div class="modal-footer">


                    {{--</form>--}}
                    <input type="hidden" name="" id="old_path" class="form-control" value=""/>
                    <button type="button" class="btn btn-default x-modal" data-dismiss="modal">Cancel
                    </button>
                    <button type="button" data-target="#popAdd" class="btn btn-primary Focus btnAddFocus">Add</button>
                </div>
            </div>
        </div>
    </div>
</div>
