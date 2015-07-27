<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/7/2015
 * Time: 11:55 AM
 */

namespace App\Http\Controllers;


use App\Role;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Requests;
use NavigatorHelper;

class RoleController extends Controller
{
//================================================= INDEX PAGE =======================================================//
    public function index()
    {
        View::share([
            'title' => 'Role',
            'sideBar' => NavigatorHelper::getSideBarBE()
        ]);

        return view('role.list');
    }
//========================================= GET DATA FOR TABLE USING AJAX ============================================//
    function getDataAjax(Request $request)
    {
        $dataRequest = $request->all();
        $model       = new Role();
        $result      = $model->getDataForPagination($dataRequest);
        die(json_encode($result));
    }
//================================================= UPDATE ROLE =======================================================//
    public function updateByAjax()
    {
        $newNameRole = Input::get('newRoleName');
        $oldNameRole = Input::get('oldRoleName');
        if (strcmp($newNameRole, $oldNameRole) != 0) {
            $model = new Role();
            if ($model->where('name', $oldNameRole)->count() > 0) {
                $model->where('name', $oldNameRole)->update(['name' => $newNameRole]);
            }
        }

    }

//================================================= REMOVE ROLE =======================================================//
    public function destroyByAjax()
    {
        $nameRole = Input::get('nameRole');
        $model    = new Role();
        $roleID   = $model->where('name', 'like', $nameRole)->get(['id'])->toArray();
        if ($roleID != Role::SA_ROLE_ID) {
            $model = new Role();
            $model->where('name', 'like', $nameRole)->delete();
        }
    }
//================================================= CREATE NEW ROLE ===================================================//
    public function createByAjax()
    {
        $nameRole = Input::get('nameRole');
        $ck       = Role::where('name', $nameRole)->count();
        if ($ck == 0) {
            $model       = new Role();
            $model->name = $nameRole;
            $model->save();
        }
    }
//================================================= CHECK NAME ROLE ===================================================//
    public function checkByAjax()
    {

        $nameRole = Input::get('newRoleName');
        $model    = new Role();
        if ($model->where('name', $nameRole)->count() > 0) {
            return 0;
        } else {
            return 1;
        }
    }
}