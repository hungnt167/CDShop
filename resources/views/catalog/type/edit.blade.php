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
                {!!Form::open(array('action'=>'TypeController@update'
                ,'method'=>'POST','files'=>true))!!}

                <table class="table table-responsive">
                    <tbody>

                    <tr>
                        <td>Name:</td>

                        <td>
                            <input type="text" name="name" id="name" class="form-control" value="" title="">
                            <input type="hidden" name="id" id="id">

                        </td>
                    </tr>

                    </tbody>
                </table>

                {{--<hr/>--}}
                <div class="modal-footer">


                    {{--</form>--}}
                    <button type="button" class="btn btn-default x-modal" data-dismiss="modal">Cancel
                    </button>
                    <button type="submit" data-target="#popEdit" class="btn btn-primary Focus btnEditFocus">Update
                    </button>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
</div>