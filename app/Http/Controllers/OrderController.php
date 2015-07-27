<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/21/2015
 * Time: 2:31 PM
 */

namespace App\Http\Controllers;


use App\Cd;
use App\Http\Requests\ChangeStatusOrderRequest;
use App\Http\Requests\OrderRequest;
use App\Order;
use App\Status_orders;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use NavigatorHelper;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //Status
    const CANCEL = 0;
    const PENDING = 1;
    const DELIVERING = 2;
    const DELIVERED = 3;
    const CHARGED = 4;
//================================================= INDEX PAGE =======================================================//
    public function index()
    {
        View::share([
            'title' => 'Order Management',
            'sideBar' => NavigatorHelper::getSideBarBE()
        ]);
        $status = Status_orders::all(['name', 'id'])->toArray();

        return view('order.list')->with('status', $status);
    }
//=========================================== CHANGE STATUS ORDER =====================================================//
    public function changeStatus(ChangeStatusOrderRequest $request)
    {
        $idOrder = $request->input('id');
        //get current status
        $currentStatus = Order::find($idOrder)->status;
        $newStatus     = $request->input('status');
        if ($currentStatus == $this::CANCEL) {
            return redirect_errors('Order canceled cannot changer status!');
        }
        if ($currentStatus == $this::PENDING && $newStatus > $this::DELIVERING) {
            return redirect_errors('Order is Pending can only changer Cancel or Delivering status!');
        }
        if (
            $currentStatus == $this::DELIVERING && $newStatus > $this::DELIVERED &&
            $newStatus < $this::DELIVERING && $newStatus != $this::CANCEL
        ) {
            return redirect_errors('Order is Delivering can only changer Cancel or Delivered status!');
        }
        if (
            $currentStatus == $this::DELIVERED &&
            $newStatus < $this::DELIVERED && $newStatus != $this::CANCEL
        ) {
            return redirect_errors('Order is Delivered can only changer Cancel or Charged status!');
        }
        if ($currentStatus == $this::CHARGED) {
            return redirect_errors('Order charged cannot changer status!');
        }
        $model = new Order();
        DB::beginTransaction();
        try {
            $order         = $model->find(intval($idOrder));
            $order->status = intval($newStatus);
            $order->save();
            //if cancel then qty return
            if ($newStatus == $this::CANCEL) {
                $model   = new Order();
                $order   = $model->viewOrder($idOrder);
                $details = $order['order']['detail'];
                foreach ($details as $detail) {
                    $qtyReturn      = ($detail['quantity']);
                    $currentQty     = Cd::find($detail['product_id'])->quantity;
                    $currentBuyTime = Cd::find($detail['product_id'])->buy_time;
                    Cd::find($detail['product_id'])->update([
                        'quantity' => $currentQty + $qtyReturn,
                        'buy_time' => $currentBuyTime + $qtyReturn
                    ]);
                }
//                $customer=User::find('user_id');
//                if(is_null($customer)){
//
//                }
//                Mail::send('auth.message_order', ['name' => 'you'],
//                    function ($message) use ($data) {
//                        $message
//                            ->to($data['email'], $data['name'])
//                            ->from('info@otherdomain.com')
//                            ->subject('Your order canceled!');
//                    });
            }
            DB::commit();
            return redirect()->back()->with('success', 'Updated status');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect_errors('Updated Fails!');
        }
    }
//=========================================== FILTER STATUS ORDER =====================================================//
    public function filterStatus()
    {
        if (is_null(Input::get('id'))) {
            Session::put('order_filter', Order::PENDING);
        }
        if (Status_orders::find(Input::get('id'))->count() == 0) {
            Session::put('order_filter', Order::PENDING);
        }
        Session::put('order_filter', Input::get('id'));
    }
//============================================ GET DATA ORDERS =======================================================//
    public function getDataAjax(Request $request)
    {
        $dataRequest = $request->all();
        $model       = new Order();
        $result      = $model->getDataForPagination($dataRequest);
        die(json_encode($result));
    }
//=========================================== GET DATA A ORDER =======================================================//
    public function getDataAOrder(OrderRequest $request)
    {
        $order = new Order();
        return json_encode($order->viewOrder($request->input('id')));
    }
}