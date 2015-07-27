<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/14/2015
 * Time: 11:29 AM
 */
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\NavigatorController;
use App\Type;
use App\Format_cd;
class NavigatorHelper
{
    public static function getNavigatorBarFE()
    {
        if(Cache::has('navi_bar_FE')){
            $sideBar=Cache::get('navi_bar_FE');
        }else{
            $controller = new NavigatorController();
            $sideBar = $controller->listForNavFE();
            Cache::forever('navi_bar_FE',$sideBar);
        }

        return $sideBar;
    }
    public static function getSideBarBE()
    {
        if(Cache::has('side_bar_BE')){
            $sideBar=Cache::get('side_bar_BE');
        }else{
            $controller= new NavigatorController();
            $sideBar=$controller->listForSideBarBE();
            Cache::forever('side_bar_BE',$sideBar);
        }
        return $sideBar;
    }

    public static function getSideBarFE()
    {
        if(Cache::has('side_bar_FE')){
            $sideBar=Cache::get('side_bar_FE');
        }else{
            $controllerType = new Type();
            $controller4mat = new Format_cd();
            $sideBar = $controllerType->sideBar();
            $sideBar .='<li class="sidebar-brand"><a href="#">';
            $sideBar .='Format CD';
            $sideBar .='</a></li>';
            $sideBar .= $controller4mat->sideBar();
            Cache::forever('side_bar_FE',$sideBar);
        }

        return $sideBar;
    }
}