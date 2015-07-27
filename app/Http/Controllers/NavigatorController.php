<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/3/2015
 * Time: 3:59 PM
 */

namespace App\Http\Controllers;


use App\Navigator;
use App\Permission;
use App\Role;
use App\Type;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use NavigatorHelper;
use Illuminate\Http\Request;

class NavigatorController extends Controller
{
    const FRONTEND = 0;
    const BACKEND = 1;
//================================================= INDEX PAGE =======================================================//
    public function index()
    {
        View::share([
            'other' => 'Backend',
            'title' => 'Navigator',
            'sideBar' => NavigatorHelper::getSideBarBE()
        ]);
        return view('catalog.navigator.list');
    }
//================================================= GET LIST NAVIGATOR ================================================//
    public function getListNavigator($option)
    {
        $model = new Navigator();
        return $model->listNavigator($option);
    }
//================================================= SIDEBAR BACKEND ==================================================//
    public function listForSideBarBE()
    {
        $model = new Navigator();
        return $model->sideBarBE($this->getListNavigator('BE'));

    }
//================================================= NAVIBAR FRONT END ================================================//
    public function  listForNavFE()
    {
        $model = new Navigator();
        return $model->navibarFE($this->getListNavigator('FE'));

    }
//======================================= LIST ALL NAVIGATOR IN SELECT TAG ============================================//
    public function listForDOM(Request $request)
    {
        $rules     = [
            'in_page' => 'required|min:0|max:1'
        ];
        $validator = Validator::make($request->all(), $rules);
        if (!$validator->fails()) {
            $page  = $request->get('in_page');
            $model = new Navigator();
            return $model->listDOM($page);
        } else {
            $error = ['type' => 'e', 'message' => 'Have error!'];
            return json_encode($error);
        }
    }
//========================================= LIST POSITION NAVIGATOR ===================================================//
    public function getListPosition(Request $request)
    {
        $rules = [
            'in_page' => 'required|min:0|max:1',
            'op' => 'required|in:update,new',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $error = ['type' => 'e', 'message' => 'Have error!'];
            return json_encode($error);
        }
        $inPage    = $request->get('in_page');
        $Navigator = $request->get('navigator');
        if($Navigator==''){
            $Navigator='root';
        }else{
            if(Navigator::where('name',$Navigator)->where('in_page',$inPage)->count()==0){
                $error = ['type' => 'e', 'message' => 'Have error!'];
                return json_encode($error);
            }
        }
        $optional  = $request->get('op');
        $model     = new Navigator();
        return $model->listPosition($inPage, $optional, $Navigator);

    }
//============================================= GET DATA A NAVIGATOR =================================================//
    public function getDataNavigator(Request $request)
    {
        //check has request true
        $rules = [
            'navigator' => 'required|exists:navigators,name'
        ];

        $validator = Validator::make($request->all(), $rules);
        $navigator = $request->get('navigator');
        $model     = Navigator::where('name', $navigator)
            ->first(['uri', 'status', 'parent_id', 'id', 'position'])
            ->toArray();
        if ($validator->fails()) {
            $error = ['type' => 'e', 'message' => 'Navigator name not exist!'];
            return json_encode($error);
        }
        return json_encode($model);

    }
//============================================= CREATE A NAVIGATOR ====================================================//
    public function createByAjax(Request $request)
    {
        $rules     = [
            'nameNavigator' => 'required|unique:navigators,name',
            'in_page' => 'required|in:0,1',
            'status' => 'required|in:0,1',

            'position' => 'required|integer',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return '{"type":"e","message":"Error!"}';
        }
        $navigator            = new Navigator();
        $navigator            = autoAssignDataToProperty($navigator, $request->all());
        $uri                  = $request->get('uri');
        $name                 = $request->get('nameNavigator');
        $navigator->uri       = $uri;
        $navigator->name      = $name;
        $navigator->parent_id = 0;
        $navigator->level     = 0;

        if(!is_null(Input::get('parent_id'))){
            $infoParent           = Navigator::where('id', $request->get('parent_id'))->first()->toArray();
            $navigator->level     = $infoParent['level'] + 1;
            $navigator->parent_id = $infoParent['id'];
        }
        if ($uri != '' && $request->get('in_page') == 1) {
            $model = new Navigator();
            if ($model->where('uri', $uri)->count() == 0) {
                //check save
                if ($navigator->save()) {
                    return '{"type":"s","message":"Added!"}';
                } else {
                    return '{"message":"Cannot add!","type":"e"}';
                };
            } else {
                return '{"message":"Uri Existed!","type":"e"}';
            }
        } else {
            $navigator->save();
        }
    }
//======================================= GET ALL NAVIGATOR FOR JS TREE ===============================================//
    public function getDataForTree(Request $request)
    {
        $rules     = [
            'in_page' => 'required|in:0,1',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return '{"type":"e","message":"Error!"}';
        }
        $inPage = Input::get('in_page');
        $model  = new Navigator();

        $navigators = $model->where('in_page', $inPage)->orderBy('position', 'asc')->get(['id', 'name', 'parent_id'])->toArray();
        $return     = [];
        foreach ($navigators as $Navigator) {
            $element = [
                'id' => $Navigator['id'],
                'parent' => $Navigator['parent_id'],
                'text' => $Navigator['name']
            ];
            if ($element['parent'] == 0) {
                $element['parent'] = '#';
            }
            $return[] = $element;
        }
        return ($return);
    }
//============================================ CHECK PATH NAVIGATOR ===================================================//
    public function checkPathByAjax(Request $request)
    {
        $rules     = [
            'op' => 'required|in:update,new',
            'path' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return '{"type":"e","message":"Error!"}';
        }
        $op      = Input::get('op');
        $oldPath = Input::get('oldPath');
        $path    = Input::get('path');
        if ($op == 'update') {
            if ($path != '' && $oldPath != $path) {
                $model = new Navigator();
                if ($model->where('uri', $path)->where('uri', '!=', $oldPath)->count() > 0) {
                    return '{"type":"e","message":"Existed"}';
                } else {
                    return '{"type":"s","message":"Accept ' . $path . '"}';
                }
            }
        } elseif ($op == 'new') {
            $model = new Navigator();
            if ($model->where('uri', $path)->where('uri', '!=', $oldPath)->count() > 0) {
                return '{"type":"e","message":"Existed"}';
            } else {
                return '{"type":"s","message":"Accept ' . $path . '"}';
            }
        }

    }

//============================================== CHECK NAME NAVIGATOR=================================================//
    public function checkNameByAjax(Request $request)
    {
        $rules     = [
            'op' => 'required|in:update,new',
            'name' => 'required',
            'in_page' => 'required|in:0,1',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return '{"type":"e","message":"Error!"}';
        }
        $op      = Input::get('op');
        $oldName = Input::get('oldName');
        $name    = Input::get('name');
        $inPage  = Input::get('in_page');

        if ($op == 'update') {
            if ($name != '' && $oldName != $name) {
                $model = new Navigator();
                if (Navigator::where('name', $name)->where('name', '!=', $oldName)->where('in_page', $inPage)->count() > 0) {

//                       return '{"type":"e","message":"Existed"}';
                    return json_encode(["type" => "e", "message" => "Existed"]);
                } else {
//                       return json_encode(["type"=>"s","message"=>"Existed"]);
                    return '{"type":"s","message":"Accept' . $name . '"}';
                }
            }
        } elseif ($op == 'new') {

            $model = new Navigator();

            if (Navigator::where('name', $name)->where('in_page', $inPage)->count() > 0) {

                return '{"type":"e","message":"Existed"}';
            } else {
                return '{"type":"s","message":"Accept ' . $name . '"}';
            }
        }
    }

//============================================== UPDATE A NAVIGATOR ===================================================//
    public function updateByAjax(Request $request)
    {
        $rules     = [
            'navigator' => 'required',
            'oldNavigator' => 'required|exists:navigators,name',
            'in_page' => 'required|in:0,1|integer',
            'status' => 'required|in:0,1|integer',
            'parent_id' => 'required',
            'position' => 'required|integer',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return '{"type":"e","message":"Error!"}';
        }
        $inPage    = Input::get('in_page');
        $oldName   = Input::get('oldNavigator');
        $newName   = Input::get('navigator');
        $oldUri    = Input::get('oldUri');
        $uri       = Input::get('uri');
        $position  = Input::get('position');
        $status    = Input::get('status');
        $parent_id = Input::get('parent_id');
        if ($parent_id != 0) {
            if (Navigator::where('in_page', $inPage)->where('id', $parent_id)->count() == 0 && $parent_id != 0) {
                return '{"message":"Parent not existed!","type":"e"}';
            }
            $checkLv = Navigator::where('in_page', $inPage)
                ->where('name', $oldName)
                ->first()->level;
            $newLv   = Navigator::where('in_page', $inPage)
                ->where('id', $parent_id)
                ->first()->level;
            //check parent id
            if ($checkLv < $newLv) {
                return '{"message":"Parent cannot in Child!","type":"e"}';
            }
        }
        $checkName = Navigator::where('name', $newName)->where('in_page', $inPage)->where('name', '!=', $oldName)->count();
        if ($checkName > 0) {
            return '{"message":"Name existed!","type":"e"}';
        }
        $checkUri = Navigator::where('uri', $uri)->where('in_page', $inPage)->where('uri', '!=', $oldUri)->count();
        if ($checkUri > 0) {
            return '{"message":"Uri existed!","type":"e"}';
        }
        //check update
        if (!Navigator::where('parent_id', $parent_id)->where('name', $oldName)->update([
            'name' => $newName,
            'uri' => $uri,
            'status' => $status,
            'position' => $position,
            'parent_id' => $parent_id,
        ])
        ) {
            return '{"message":"Cannot update!","type":"e"}';
        }
        return '{"message":" Updated!","type":"s"}';
    }

//=========================================== REMOVE NAVIGATOR =======================================================//
    public function destroyByAjax(Request $request)
    {
        $rules     = [
            'navigator' => 'required|exists:navigators,name',
            'in_page' => 'required|in:0,1',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return '{"type":"e","message":"Error!"}';
        }
        $inPage         = Input::get('in_page');
        $navigator      = Input::get('navigator');
        $arrayNavigator = explode(', ', $navigator);
        $model          = new Navigator();
        //true , get id current tag
        $Parent   = Navigator::where('name', 'like', $navigator)->where('in_page', $inPage)->first()->toArray();
        $idParent = $Parent['id'];
        //if current differ root tag allow delete
        if ($Parent['level'] == 0) {
            return '{"message":"Cannot delete root!","type":"e"}';
        }
        //check current tag has child yet?
        $check = Navigator::where('parent_id', 'like', $idParent)->where('in_page', $inPage)->count();
        if ($check > 0) {
            $child = Navigator::where('parent_id', 'like', $idParent)->where('in_page', $inPage)->get()->toArray();;
            //delete current tag
            Navigator::where('parent_id', 'like', $idParent)->where('in_page', $inPage)->delete();
            foreach ($child as $aChild) {
                $check = Navigator::where('parent_id', 'like', $aChild['id'])->where('in_page', $inPage)->count();
                if ($check > 0) {
                    Navigator::where('parent_id', 'like', $aChild['id'])->where('in_page', $inPage)->delete();
                }
            }
        }

        $model->where('name', 'like', $navigator)->where('in_page', $inPage)->delete();
        return '{"message":"Delete!","type":"s"}';

    }
}