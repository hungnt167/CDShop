<div class="modal fade " id="popAdd" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add New Artist</h4>
            </div>
            <div class="modal-body">
                {!!Form::open(array('action'=>'ArtistController@create'
                ,'method'=>'POST','files'=>true))!!}

                <table class="table table-responsive">
                    <tbody>

                    <tr>
                        <td>Name:</td>
                        <td>
                            Avatar:
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="name" id="name" class="form-control" value="" placeholder="Name Artist" title="">
                            <p>Talent:</p>
                            <select name="talent" class="form-control" >
                                <option value="10">Singer</option>
                                <option value="01">Composer</option>
                                <option value="11">Singer&Composer</option>
                            </select>
                        </td>
                        <td>
                            <input type="file" accept="image/*" name="image" id="avatar" class="form-control" value="" title="">
                            <img src="" id="myImg" alt="Image" width="150" height="100">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <span class="label label-info">Description:</span>
                            <div>
                                <textarea name="description" id="description" cols="100" rows="10"></textarea>
                            </div>
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
