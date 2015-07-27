<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/12/2015
 * Time: 9:43 PM
 */

namespace App\Http\Controllers;


use App\Http\Requests\CreateTypeRequest;
use App\Http\Requests\DestroyTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class TypeController extends Controller
{
//================================================= GET DATA FOR TABLE AJAX ==========================================//
    public function getDataAjax(Request $request)
    {
        $dataRequest = $request->all();
        $model       = new Type();
        $result      = $model->getDataForPagination($dataRequest);
        die(json_encode($result));
    }
//================================================= CREATE NEW TYPE ==================================================//
    public function create(CreateTypeRequest $request)
    {
        //get data request
        $dataRequest = $request->all();
        $name        = $dataRequest['name'];
        $model       = new Type();
        $model->name = $name;
        if ($model->save()) {
            return redirect()->back()->with('success', 'Added');
        } else {
            return redirect_errors('Have error, try again please!');
        }
    }
//================================================= UPDATE A TYPE =====================================================//
    public function update(UpdateTypeRequest $request)
    {
        //get Data
        $dataRequest = $request->all();
        //validate
        //check has change yet?
        $model   = new Type();
        $oldName = $model->where('id', $dataRequest['id'])->first(['name']);
        if ($oldName != $dataRequest['name']) {
            if ($model->where('id', $dataRequest['id'])->update($dataRequest)) {
                return redirect()->back()->with('success', 'Update!');
            } else {
                return redirect_errors('Have error!');
            }
        } else {
            return redirect()->back()->with('success', 'Done!');
        }//end //check has change yet?
        //end validate
    }
//================================================= HIDE A TYPE =======================================================//
    public function destroy(DestroyTypeRequest $request)
    {
        //get Data
        $dataRequest = $request->all();
        $model       = new Type();
        if ($model->where('id', $dataRequest['id'])->update([
            'status'=>Type::HIDE
        ])) {
            return redirect()->back()->with('success', 'Delete!');
        } else {
            return redirect_errors('Have error, cannot delete!');
        }
    }
}