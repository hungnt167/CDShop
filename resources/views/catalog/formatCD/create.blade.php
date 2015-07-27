<div class="modal fade " id="popAdd" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add New Type</h4>
            </div>
            <div class="modal-body">
                {!!Form::open(array('action'=>'FormatCDController@create'
                ,'method'=>'POST','files'=>true))!!}

                <table class="table table-responsive">
                    <tbody>

                    <tr>
                        <td>Name:</td>
                        <td>
                        <td>
                            <input type="text" name="name" id="name" class="form-control" value="" title="name type" placeholder="Name Type">

                        </td>

                    </tr>

                    </tbody>
                </table>

                {{--<hr/>--}}
                <div class="modal-footer">


                    {{--</form>--}}
                    <input type="hidden" name="" id="old_path" class="form-control" value=""/>
                    <button type="button" class="btn btn-default x-modal" data-dismiss="modal">Cancel
                    </button>
                    <button type="submit" data-target="#popAdd" class="btn btn-primary Focus btnAddFocus">Add</button>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
</div>
