<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/16/2015
 * Time: 9:07 AM
 */

namespace App\Http\Controllers;


use App\Cd;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\ChangeQtyItemRequest;
use App\Http\Requests\RemoveItemRequest;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use CartHelper;

class CartController extends Controller
{
//=========================================== ADD QTY PRODUCT TO CART FUNCTION ========================================//
    public function addToCart(AddToCartRequest $request)
    {
        //get Data
        $data  = $request->all();
        $model = new Cd();

        $info = json_decode($model->getDataAProduct($data['id'],Cd::$columnForPage));
        if ($info->quantity - 1 >= 0) {
            Cart::add([
                'id' => $info->id,
                'name' => $info->name,
                'qty' => 1,
                'price' => $info->sale_off*$info->price*0.01+$info->price,
            ]);
            return redirect()->back()->with('success', 'Added item!');
        } else {
            return redirect_errors("Sorry we aren't Cd for You");
        }
    }
//================================================= CHANGE QUANTITY FUNCTION ========================================//
    public function changeQuantityItem(ChangeQtyItemRequest $request)
    {
        $dataRequest = $request->all();
        //check exist
        if (is_object(Cart::get(Input::get('idrow')))) {
            if (((Cd::find($dataRequest['id'])->quantity) - $dataRequest['qty']) >= 0) {
                Cart::update($dataRequest['idrow'], ['qty' => $dataRequest['qty']]);
                return redirect()->back()->with('success', 'Updated item!');
            } else {
                return redirect_errors("Sorry we aren't Cd for You");
            }
        } else {
            return redirect_errors('You haven"t this Item!');
        }
    }
//================================================= EMPTY A PRODUCT FUNCTION ========================================//
    public function removeItem(RemoveItemRequest $request)
    {
        $idRow = Input::get('idrow');
        //check exist
        if (is_object(Cart::get($idRow))) {
            Cart::remove($idRow);
            return redirect()->back()->with('success', 'Removed item!');
        } else {
            return redirect_errors('You haven"t this Item!');
        }
    }
//================================================= CANCEL CART FUNCTION ============================================//
    public function cancelCart()
    {
        Cart::destroy();
        return redirect('home')->with('success', 'Removed Cart!');

    }
}