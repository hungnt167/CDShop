<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/16/2015
 * Time: 1:44 AM
 */

namespace App\Http\Controllers;


use App\Http\Requests\CreatePriceGroupRequest;
use App\Price_group;
use Illuminate\Http\Request;

class PriceGroupController extends Controller
{
//=========================================== GET DATA PRICE GROUP FOR TABLE ==========================================//
    public function getDataAjax(Request $request)
    {
        $dataRequest = $request->all();
        $model       = new Price_group();
        $result      = $model->getDataForPagination($dataRequest);
        return (json_encode($result));
    }
//=========================================== CREATE NEW GROUP =======================================================//
    public function create(CreatePriceGroupRequest $request)
    {
        //get data request
        $dataRequest = $request->all();
        $name        = $dataRequest['name'];
        $rootPrice   = $dataRequest['root_price'];
        $price       = $dataRequest['price'];
        $saleOff     = $dataRequest['sale_off'];
        //validate
        $model             = new Price_group();
        $model->name       = $name;
        $model->root_price = $rootPrice;
        $model->price      = $price;
        $model->sale_off   = $saleOff;
        if ($model->save()) {
            return redirect()->back()->with('success', 'Added');
        } else {
            return redirect_errors('Have error, try again please!');
        }

    }
//============================================= UPDATE A GROUP =======================================================//
    public function update(CreatePriceGroupRequest $request)
    {
        //get Data
        $dataRequest = $request->all();
        $data        = [
            'id' => $dataRequest['id'],
            'name' => $dataRequest['name'],
            'root_price' => $dataRequest['root_price'],
            'price' => $dataRequest['price'],
            'sale_off' => $dataRequest['sale_off']
        ];
        //validate
        if (!is_null($data['id']) && !empty($data['id'])) {
            if (!is_null($data['name']) && !empty($data['name'])) {
                //check has change yet?
                $model = new Price_group();
                //check id exist?
                $count = $model->where('id', $dataRequest['id'])->count();
                if ($count > 0) {
                    $oldData = $model->where('id', $dataRequest['id'])->first()->toArray();
                    $cnt     = 0;
                    foreach ($data as $k => $aData) {
                        if ($k !== 'id' && $data[$k] == $oldData[$k]) {
                            unset($data[$k]);
                            $cnt++;
                        }
                    }
                    if ($cnt > 0) {
                        if ($model->where('id', $data['id'])->update($data)) {
                            return redirect()->back()->with('success', 'Update!');
                        } else {
                            return redirect_errors('Have error,cannot update!');
                        }
                    } else {
                        return redirect()->back()->with('success', 'Nothing to update!');
                    }//end //check has change yet?
                }
            } else {
                return redirect_errors('Have error, invalid name!');
            }
        } else {
            return redirect_errors('Have error, invalid id type!');
        }//end validate
    }
//============================================= REMOVE A GROUP =======================================================//
    public function destroy(Request $request)
    {
        //get Data
        $dataRequest = $request->all();
        $data        = [
            'id' => $dataRequest['id'],
            'name' => $dataRequest['name']
        ];
        //validate
        if (!is_null($data['id']) && !empty($data['id'])) {
            if (!is_null($data['name']) && !empty($data['name'])) {
                $model = new Price_group();
                if ($model->where('id', $dataRequest['id'])->delete()) {
                    return redirect()->back()->with('success', 'Delete!');
                } else {
                    return redirect_errors('Have error, cannot delete!');
                }
            } else {
                return redirect_errors('Have error, invalid name!');
            }
        } else {
            return redirect_errors('Have error, invalid id type!');
        }//end validate
    }
}