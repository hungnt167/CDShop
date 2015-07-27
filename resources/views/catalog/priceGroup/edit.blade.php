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
                {!!Form::open(array('action'=>'PriceGroupController@update'
                ,'method'=>'POST','files'=>true))!!}

                <table class="table table-responsive">
                    <tbody>


                        <td>Name:</td>
                        <td>
                        <td>
                            <input type="text" name="name" id="name" class="form-control" value="" title="name" placeholder="Name Group">

                        </td>

                    </tr>
                    <tr>
                        <td>Root price:</td>
                        <td>
                        <td>
                            <input type="text" name="root_price" id="root_price" class="form-control" value="" title="" placeholder="Root Price">

                        </td>

                    </tr>
                    <tr>
                        <td>Price:</td>
                        <td>
                        <td>
                            <input type="text" name="price" id="price" class="form-control" value="" title="" placeholder="Price">

                        </td>

                    </tr><tr>
                        <td>Sale off:</td>
                        <td>
                        <td>
                            <input type="text" name="sale_off" id="sale_off" class="form-control" value="" title="" placeholder="Sale off">

                        </td>

                    </tr>
                    </tbody>
                </table>

                {{--<hr/>--}}
                <div class="modal-footer">


                    {{--</form>--}}
                    <input type="hidden" name="id" id="id">
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