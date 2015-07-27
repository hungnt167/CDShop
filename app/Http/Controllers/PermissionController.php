<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use NavigatorHelper;

class PermissionController extends Controller
{
//================================================= INDEX PAGE =======================================================//
    public function index()
    {
        View::share([
            'title' => 'Permission',
            'sideBar' => NavigatorHelper::getSideBarBE()
        ]);

        $user     = Session::get('user');
        $userRole = $user['role_id'];
        $role     = Role::where('id', '!=', 1)->where('id', '!=', $userRole)->get(['id', 'name'])->toArray();
        return view('permission.list')->with(['role' => $role]);
    }
//=========================================== GET DATA PER FOR TABLE ==================================================//
    function getDataAjax(Request $request)
    {

        $dataRequest = $request->all();
        $pageCurrent = $dataRequest['current'];
        $limit       = $dataRequest['rowCount'];
        $offset      = ($pageCurrent - 1) * $limit;
        $config      = array(
            'limit' => $limit,
            'offset' => $offset,
        );

        $model  = new Permission();
        $result = $model->getDataForPagination($dataRequest, $config);


        $data['current']  = $pageCurrent;
        $data['rowCount'] = $limit;
        $data['total']    = $result['total'];
        $data['rows']     = $result['rows'];
        $data['_token']   = csrf_token();
        die(json_encode($data));
    }
//=========================================== UPDATE PERMISSION FOR ROLE===============================================//
    public function updateByAjax()
    {
        $path       = Input::get('path');
        $col        = Input::get('col');
        $permission = $col . '|' . $path;
        $model      = new Permission();
        if ($model->where('name', $permission)->count() > 0) {
            $model->where('name', $permission)->delete();
        } else {
            $model->name = $permission;
            $model->save();
        }

    }
//=========================================== UPDATE PATH PERMISSION ==================================================//
    public function updatePathByAjax()
    {
        $path     = '|' . Input::get('path');
        $old_path = '|' . Input::get('old_path');
        $model    = new Permission();
        if (strcmp($path, $old_path) != 0) {
            if ($model->where('name', 'like', '%' . $old_path)->count() > 0) {
                $rows = $model->where('name', 'like', '%' . $old_path)->get(['name'])->toArray();
                foreach ($rows as $row) {
                    $newData = substr($row['name'], 0, 1) . $path;
                    $model->where('name', 'like', $row['name'])->update(['name' => $newData]);
                }

            }
        }
    }
//=========================================== REMOVE PERMISSION =======================================================//
    public function destroyByAjax()
    {
        $path  = '|' . Input::get('path');
        $model = new Permission();
        $model->where('name', 'like', '%' . $path)->delete();
    }

    public function createByAjax()
    {
        $prePath  = Input::get('path');
        $user     = Session::get('user');
        $userRole = $user['role_id'];
        $ck       = Permission::where('name', '2|' . $prePath)->orWhere('name', '1|' . $prePath)->count();
        if ($ck == 0) {
            if ($userRole == 2) {
                $model       = new Permission();
                $model->name = '2|' . $prePath;
                $model->save();
            }

            $path        = '1|' . $prePath;
            $model       = new Permission();
            $model->name = $path;
            $model->save();
        }
    }
//=========================================== CHECK PATH NEW PERMISSION ===============================================//
    public function checkPathByAjax()
    {
        $path  = '1|' . Input::get('path');
        $model = new Permission();
        if ($model->where('name', $path)->count() > 0) {
            return '{"message":"Uri existed!","type":"e"}';
        } else {
            return '{"message":"Ok!","type":"s"}';
        }
    }


}
