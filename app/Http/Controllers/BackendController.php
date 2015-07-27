<?php

namespace App\Http\Controllers;


use App\Artist;
use App\Cd;
use App\Customer;
use App\Http\Requests;
use App\Order;
use App\Status_orders;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use NavigatorHelper;

class BackendController extends Controller
{
//================================================= BACKEND HOME =====================================================//
    public function index()
    {
        View::share([
            'sideBar' => NavigatorHelper::getSideBarBE()
        ]);
        $status = Status_orders::all(['name', 'id'])->toArray();
        $newProduct=Cd::whereIn('public_date',[Carbon::today(),Carbon::today()->subDay(3)])->count();
        $newArtist=Artist::whereIn('created_at',[Carbon::today(),Carbon::today()->subDay(3)])->count();
        $newOrder=Order::where('status',Order::PENDING)->count();
        $newCustomer=Customer::whereIn('created_at',[Carbon::today(),Carbon::today()->subDay(3)])->count();
        return view('backend.index')->with([
            'status'=> $status,
            'newProduct'=> $newProduct,
            'newArtist'=> $newArtist,
            'newOrder'=> $newOrder,
            'newCustomer'=> $newCustomer,
        ]);
    }
}