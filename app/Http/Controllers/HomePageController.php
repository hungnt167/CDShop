<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/15/2015
 * Time: 9:19 AM
 */

namespace App\Http\Controllers;


use App\Cd;

class HomePageController extends Controller
{
    public function index()
    {
        $model = new Cd();
        return view('frontend.home.index')->with(['latest' => $model->getNewProduct()]);
    }
}