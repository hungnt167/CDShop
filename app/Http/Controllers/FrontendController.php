<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/7/2015
 * Time: 11:45 PM
 */

namespace App\Http\Controllers;


use App\Address;
use App\Cd;
use App\DeliverDetail;
use App\DeliveryDetail;
use App\Http\Requests\CreateDeliverDetailRequest;
use App\Http\Requests\CreatePaymentMethodRequest;
use App\Http\Requests\DetailProductRequest;
use App\Http\Requests\FilterRequest;
use App\Http\Requests\OptionCheckoutRequest;
use App\Http\Requests\OrderRequest;
use App\Order;
use App\OrderDetail;
use App\Role;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use CartHelper;
use Mockery\CountValidator\Exception;
use NavigatorHelper;

class FrontendController extends Controller
{
    const ASCENDING = 0;
    const DECREASING = 1;

    public function __construct()
    {
        $share = [
            'navigator' => NavigatorHelper::getNavigatorBarFE(),
            'sideBar' => NavigatorHelper::getSideBarFE()
        ];
        View::share($share);
    }
//================================================= INDEX PAGE =======================================================//
    //news page
    public function index(Request $request)
    {
        View::share([
            'title' => 'Home',
        ]);
        $offset = 0;
        $limit  = 4;
        $model  = new Cd();
        return view('frontend.index')->with([
            'listProduct' => [
                'latest' => $model->getNewProduct($offset, $limit),
                'bestseller' => $model->getBestSellerProduct($offset, $limit)
            ],
        ]);
    }
//================================================== CART PAGE =======================================================//
    public function cart()
    {
        View::share([
            'title' => 'Cart'
        ]);
        $cart  = Cart::content();
        $total = Cart::total();
        $items = CartHelper::getDetailItem($cart);

        return view('cart.index')->with(['cart' => $cart, 'total' => $total, 'items' => $items]);
    }
//================================================= KINGDOM MUSIC PAGE ===============================================//
    public function musicKingdom($page, Request $request)
    {
        View::share([
            'title' => 'Music Kingdom',
            'hasFilter' => true
        ]);
//        dd($request->all());

        $this->filter($request);
        $model = new Cd();
        $limit = 8;
        $start = ($page - 1) * $limit;
        $rows  = $model->allProduct($start, $limit);
        $path  = '/music-kingdom/page/';
        return view('frontend.list')->with($this->doPagination($path, $rows, $page, $start, $limit));
    }
//================================================= LATEST PAGE =======================================================//
    public function latest($page)
    {
        View::share([
            'title' => 'Latest'
        ]);
        $limit = 8;
        $start = ($page - 1) * $limit;
        $path  = '/latest/page/';
        $model = new Cd();
        $rows  = $model->getNewProduct($start, $limit);
        return view('frontend.end')->with($this->doPagination($path, $rows, $page, $start, $limit));
    }
//================================================= BEST SELLER PAGE =================================================//
    public function bestSeller($page, Request $request)
    {
        View::share([
            'title' => 'Best seller'
        ]);
        $limit = 8;
        $start = ($page - 1) * $limit;
        $path  = '/bestseller/page/';
        $model = new Cd();
        $rows  = $model->getBestSellerProduct($start, $limit);
        return view('frontend.list')->with($this->doPagination($path, $rows, $page, $start, $limit));
    }
//================================================= TYPE PAGE ========================================================//
    public function type($id, $name = 'page', $page = 1, Request $request)
    {
        View::share([
            'title' => 'Type>' . $name,
            'hasFilter' => true
        ]);
        $this->filter($request);
        $model = new Cd();
        $limit = 8;
        $start = ($page - 1) * $limit;
        $path  = '/product/type/' . $id . '/' . $name . '/';
        $rows  = $model->getProductByType($id, $start, $limit);
        return view('frontend.list')->with($this->doPagination($path, $rows, $page, $start, $limit));

    }
//================================================= FORMAT PAGE =======================================================//
    public function format($id, $name = 'format', $page = 1, Request $request)
    {
        View::share([
            'title' => 'Format>' . $name,
            'hasFilter' => true
        ]);
        $this->filter($request);
        $model = new Cd();
        $limit = 8;
        $start = ($page - 1) * $limit;
        $path  = '/product/format/' . $id . '/' . $name . '/';
        $rows  = $model->getProductByFormat($id, $start, $limit);
        return view('frontend.list')->with($this->doPagination($path, $rows, $page, $start, $limit));
    }
//================================================= PAGINATION FUNCTION ==============================================//
    private function doPagination($path, $rows, $page, $start, $limit)
    {
        $total_record = array_get($rows, 'count');
        $total_page   = ceil($total_record / $limit);
        if ($page < 1) {
            $page = 1;
        }
        if ($page > $total_record) {
            $page = $total_page;
        }
        return [
            'path' => $path,
            'start' => $start,
            'limit' => $limit,
            'current_page' => $page,
            'total_page' => $total_page,
            'total_record' => $total_record,
            'products' => array_get($rows, 'cds')
        ];
    }
//================================================= SEARCH PAGE =======================================================//
    public function search()
    {
        $column=['cds.id', 'cds.name', 'singer_id', 'composer_id', 'artists.name as singer',
            'cds.status', 'format_id', 'type_id', 'quantity', 'public_date', 'portal', 'buy_time',
            'cds.price', 'cds.sale_off', 'cds.group_price_id',
            'price_groups.price as price_group', 'price_groups.sale_off as sale_off_group',];
        $keyword = Input::get('keyword');
        $query = DB::table('cds')
            ->where('cds.status',Cd::ACTIVE)
            ->join('artists', 'cds.singer_id', '=', 'artists.id')
            ->join('format_cds', 'cds.format_id', '=', 'format_cds.id')
            ->join('types', 'cds.type_id', '=', 'types.id')
            ->leftJoin('price_groups', 'cds.group_price_id', '=', 'price_groups.id')
            ->where('cds.name', 'LIKE', '%' . trim($keyword) . '%')
            ->orWhere('artists.name', 'LIKE', '%' . trim($keyword) . '%')
            ->select(Cd::$columnForPage)
            ->paginate(8);
        $query->setPath('search');
        return view('frontend.search_list')->with(['products'=>$query]);
    }
//================================================= FILTER FUNCTION ===================================================//
    public function filter($request)
    {
        $filter = [
            'name' => false,
            'public_date' => false,
            'price' => false,
        ];
        Session::put('filter', $filter);
        if ($request->input('name') == $this::DECREASING) {
            $filter['name'] = true;
        }
        if ($request->input('public_date') == $this::DECREASING) {
            $filter['public_date'] = true;
        }
        if ($request->input('price') == $this::DECREASING) {
            $filter['price'] = true;
        }
        Session::put('filter', $filter);
    }
//================================================= DETAIL PRODUCT PAGE ===============================================//
    public function detailProduct($id, $name)
    {
        View::share([
            'title' => 'Detail Product',
        ]);


        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:cds',
        ]);
        if ($validator->fails()) {
            return redirect_errors('Not found product.');
        }
        $model   = new Cd();
        $product = $model->getDataAProduct($id, ['cds.id', 'cds.name', 'singer_id', 'composer_id', 'artists.name as singer',
            'cds.status', 'format_id', 'type_id', 'quantity', 'public_date', 'portal', 'buy_time', 'cds.description',
            'cds.price', 'cds.sale_off', 'cds.group_price_id',
            'price_groups.price as price_group', 'price_groups.sale_off as sale_off_group',]);
        return view('detail_product.index')->with(['product' => json_decode($product)]);

    }
//============================================== SELECT OPTION CHECKOUT ===============================================//
    public function selectOptionCheckout(OptionCheckoutRequest $request)
    {
        $dataRequest = $request->all();
        $option      = $dataRequest['account'];
        //if select register so human must sign up -> active->login->payment_med->order
        if ($option == 'register') {
            Session::forget('option');
            Session::put('option', [
                'type' => 'register',
                'pay_add' => false,
            ]);
            return redirect()->action('FrontendController@checkout');
        }//if select register so human must -> ship_add->payment_med->order
        elseif ($option == 'guest') {
            Session::forget('option');
            Session::put('option', [
                'type' => 'guest',
                'shi_add' => false,
                'pay_med' => false,
                'conf' => false
            ]);
            return redirect()->action('FrontendController@checkout');
        } else {
            return redirect('error');
        }
    }
//============================================ CREATE DELIVERY DETAIL ================================================//
    public function createDeliverDetail(CreateDeliverDetailRequest $request)
    {
//        dd($request->all());
        Session::put('shi_add', $request->all());
        $dataOption            = Session::get('option');
        $dataOption['shi_add'] = true;
        Session::put('option', $dataOption);
        return redirect()->back();
    }

//========================================== CREATE PAYMENT METHOD ===================================================//
    public function createPaymentMethod(CreatePaymentMethodRequest $request)
    {
        //put
        Session::put('pay_med', $request->all());
        $dataOption            = Session::get('option');
        $dataOption['pay_med'] = true;
        //check fill up all yet
        if (
            $dataOption['shi_add'] == true
        ) {
            $dataOption['conf'] = true;
        }
        Session::put('option', $dataOption);
        return redirect()->back();
    }
//============================================== CHECKOUT PAGE =======================================================//
    public function checkout()
    {
        View::share([
            'title' => 'Checkout',
        ]);
        $cart  = Cart::content();
        $total = Cart::total();
        $items = CartHelper::getDetailItem($cart);
        $city  = Address::where('parent_id', 0)->get()->toArray();
        if ($total > 0) {
            return view('checkout.index')->with(['cart' => $cart, 'total' => $total, 'items' => $items, 'cities' => $city]);
        } else return redirect()->action('FrontendController@index')->with('error', 'Nothing to checkout!');
    }
//========================================== LIST STATE/REGIOUS AJAX =================================================//
    public function listState(Request $request)
    {
        $rules     = [
            'id' => 'required|exists:address'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return json_encode([]);
        }
        $listState = Address::where('parent_id', $request->input('id'))->get()->toArray();
        return $listState;
    }
//================================================= INVOICE PAGE =====================================================//
    public function viewInvoicePage()
    {

        if (!Session::has('user')) {
            return redirect_errors('You login yet!');
        }
        $user = Session::get('user');
        if ($user['role_id'] != Role::CUS_ROLE_ID) {
            return redirect_errors('You are not Customer!');
        }
        $model= new Order();
        $invoices=$model->listInvoice($user['id']);
        return view('frontend.view_invoice')->with('invoices',$invoices);
    }
//================================================= VIEW INVOICE  ====================================================//
    public function viewInvoice($id){
        if(Order::find($id)->count()<=0){
            return redirect_errors('Invoice not exist!');
        }
        $model=new Order();
        $invoice=array_get($model->viewInvoice($id),'order');
        return view('frontend.invoice')->with(['invoice'=>$invoice,'id'=>$id]);
    }
//================================================= ORDER FUNCTION ===================================================//
    public function order()
    {
        //get Session option
        $option = Session::get('option');
        //get Cart
        $cart = Cart::content();
        //get type order
        $type = $option['type'];
        //payment method
        $payMethod = Session::get('pay_med');

        if ($option['type'] == 'logged') {

            $order = new Order();
            DB::beginTransaction();
            try {
                $idUser                    = array_get(session('user'), 'id');
                $order->user_id            = $idUser;
                $order->delivery_detail_id = 0;
                $order->comment            = $payMethod['comment'];
                $order->save();

                $idOrder = Order::where('user_id', $idUser)->orderBy('id', 'desc')->first()->id;

                //add order detail and sub amount of product

                foreach ($cart as $item) {
                    $root_price                       = Cd::find($item['id'])->root_price;
                    $modelOrderDetail             = new OrderDetail();
                    $modelOrderDetail->order_id   = $idOrder;
                    $modelOrderDetail->product_id = $item['id'];
                    $modelOrderDetail->quantity   = $item['qty'];
                    $modelOrderDetail->root_price = $root_price;
                    $modelOrderDetail->price      = $item->price;
                    $modelOrderDetail->save();
                    //sub qty product
                    $cd = Cd::find($item['id']);
                    if ($cd->quantity - $item['qty'] <= 0) {
                        throw new QtyCDException();
                    }
                    $cd->quantity = $cd->quantity - $item['qty'];
                    $cd->buy_time = $cd->buy_time + $item['qty'];
                    $cd->save();

                }
                DB::commit();
                $this->clear();
                return redirect_success('FrontendController@index', 'Ordered, Check your email to check detail');
            } catch (QtyCDException  $e) {
                DB::rollback();
                return redirect_errors($e->notify());
            } catch (\Exception $e) {
                DB::rollback();
                return redirect_errors("Sorry cannot to this deal!");
            }
        } else {
            $deliveryDetail = Session::get('shi_add');
            $order          = new Order();

            $modelDeliverDetail = new DeliveryDetail();
            $modelDeliverDetail = autoAssignDataToProperty($modelDeliverDetail, $deliveryDetail);
//            dd($modelDeliverDetail);


            DB::beginTransaction();
            try {
                $orderHuman = $modelDeliverDetail;
                $modelDeliverDetail->save();
                $newDeliverDetail = new DeliveryDetail();
                $delivery         = $newDeliverDetail->getDeliveryDetail($deliveryDetail);

                $order->user_id            = 0;
                $order->delivery_detail_id = $delivery->id;
                $order->comment            = $payMethod['comment'];
                $order->save();

                $idOrder = Order::where('delivery_detail_id', $delivery->id)->first()->id;

                //add order detail and sub amount of product

                foreach ($cart as $item) {

                    $modelOrderDetail             = new OrderDetail();
                    $modelOrderDetail->order_id   = $idOrder;
                    $modelOrderDetail->product_id = $item['id'];
                    $modelOrderDetail->quantity   = $item['qty'];
                    $modelOrderDetail->price      = $item['price'];
                    $modelOrderDetail->save();
                    //
                    $cd = Cd::find($item['id']);
                    if ($cd->quantity - $item['qty'] <= 0) {
                        throw new QtyCDException();
                    } else {
                        $cd->quantity = $cd->quantity - $item['qty'];
                    }
                }
                DB::commit();
                $this->clear();
                //send
//                Mail::send('auth.mail_welcome', ['last_name' => $orderHuman->lastname, 'key' => $key_active, 'password' => $pass], function ($message) use ($data) {
//                    $message
//                        ->to($data['email'], $data['name'])
//                        ->from('info@otherdomain.com')
//                        ->subject('Thank you for your buying!');
//                });
                return redirect_success('FrontendController@index', 'Ordered, Check your email to check detail');
            } catch (QtyCDException  $e) {
                DB::rollback();
                return redirect_errors($e->notify());
            } catch (\Exception $e) {
                DB::rollback();
                return redirect_errors("Sorry cannot to this deal!");
            }


        }

    }
//================================================= CLEAR ORDER =======================================================//
    private function clear()
    {
        //clear cart
        Cart::destroy();
        //clear option
        $currentOption            = Session::get('option');
        $currentOption['shi_add'] = false;
        $currentOption['pay_add'] = false;
        $currentOption['pay_med'] = false;
        $currentOption['conf']    = false;
        Session::forget('option');
        Session::put($currentOption);
        //clear pay_med
        Session::forget('pay_med');
    }

}

class QtyCDException extends Exception
{
    function notify()
    {
        return "Sorry we aren't Cd for You";
    }
}

class SendMailException extends Exception
{
    function notify()
    {
        return "Sorry we cannot send mail for You, let try again!";
    }
}