<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/12/2015
 * Time: 9:31 PM
 */


namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use NavigatorHelper;

class AttributeController extends Controller
{
//================================================= ARTIST PAGE ======================================================//
    public function artist()
    {
        View::share([
            'title' => 'Artist Management',
            'sideBar' => NavigatorHelper::getSideBarBE()
        ]);
        return view('catalog.artist.list');
    }

//================================================= TYPE PAGE ========================================================//
    public function type()
    {
        View::share([
            'title' => 'Type Management',
            'sideBar' => NavigatorHelper::getSideBarBE()
        ]);
        return view('catalog.type.list');
    }
//================================================= FORMAT CD PAGE ====================================================//
    public function formatCD()
    {
        View::share([
            'title' => 'Format CD Management',
            'sideBar' => NavigatorHelper::getSideBarBE()
        ]);
        return view('catalog.formatCD.list');
    }
//================================================= PRICE GROUP PAGE ==================================================//
    public function priceGroup()
    {
        View::share([
            'title' => 'Price Group Management',
            'sideBar' => NavigatorHelper::getSideBarBE()
        ]);
        return view('catalog.priceGroup.list');
    }
}