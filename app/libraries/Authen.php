<?php namespace libraries;
use App\User;
use App\Role;
use App\Permission;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
class Authen{
    public static function setUser($data) {
        $user =[
            'id' =>$data['id'],
            'name' =>$data['name'],
            'email' => $data['email'],
            'avatar' => $data['avatar'],
//            'phone' => $data->phone,
            'role_id' => $data['role_id'],

        ];


        Session::put('user', $user);
    }

    public static function check() {
        if(Session::get('user')) {
            return true;
        }elseif(Cache::has('user')){
            return true;
        }
        return false;
    }

    public static function getUser() {
        return Session::get('user');
    }

    public static function checkPermission() {
        $userInfo = Session::get('user');
        $uri=new Permission();
        $currentRoute = Route::getFacadeRoot()->current()->uri();
        if(Cache::has('user')){
            $user=Cache::get('user');
            $permission=$user['permission'];
            $ck=in_array($userInfo['role_id'].'|'.$currentRoute,$permission);
        }else{
            $ck=$uri->where('name',$userInfo['role_id'].'|'.$currentRoute)->count();
        }


        if($ck>0 || $userInfo['role_id']==1) {
            return true;
        }
        return false;
    }

}