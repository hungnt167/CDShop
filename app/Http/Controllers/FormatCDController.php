<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/16/2015
 * Time: 1:26 AM
 */

namespace App\Http\Controllers;


use App\Format_cd;
use App\Http\Requests\CreateFormatCDRequest;
use App\Http\Requests\DestroyFormatCDRequest;
use Illuminate\Http\Request;

class FormatCDController extends Controller
{
//========================================= GET DATA FOR TABLE USING AJAX FUNCTION ====================================//
    public function getDataAjax(Request $request)
    {
        $dataRequest = $request->all();
        $model       = new Format_cd();
        $result      = $model->getDataForPagination($dataRequest);
        return (json_encode($result));
    }

//================================================= CREATE A FORMAT FUNCTION =========================================//
    public function create(CreateFormatCDRequest $request)
    {
        //get data request
        $dataRequest = $request->all();
        $name        = $dataRequest['name'];
            $model       = new Format_cd();
            $model->name = $name;
            if ($model->save()) {
                return redirect()->back()->with('success', 'Added');
            } else {
                return redirect_errors('Have error, try again please!');
            }
    }

//================================================= UPDATE A FORMAT FUNCTION ========================================//
    public function update(DestroyFormatCDRequest $request)
    {
        //get Data
        $dataRequest = $request->all();
        $data        = [
            'name' => $dataRequest['name']
        ];
        //check has change yet?
        $model   = new Format_cd();
            if ($model->where('id', $dataRequest['id'])->update($data)) {
                return redirect()->back()->with('success', 'Update!');
            } else {
                return redirect_errors('Have error!');
            }
    }

//================================================= HIDE A FORMAT FUNCTION ===========================================//
    public function destroy(DestroyFormatCDRequest $request)
    {
        //get Data
        $dataRequest = $request->all();
        $model       = new Format_cd();
        if ($model->where('id', $dataRequest['id'])->update([
            'status' => Format_cd::HIDE
        ])
        ) {
            return redirect()->back()->with('success', 'Delete!');
        } else {
            return redirect_errors('Have error, cannot delete!');
        }
    }
}