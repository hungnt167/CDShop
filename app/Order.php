<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/20/2015
 * Time: 4:09 PM
 */

namespace App;


use App\Http\Requests\ChangeStatusOrderRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class Order extends Model
{
    //Status
    const CANCEL = 0;
    const PENDING = 1;
    const DELIVERING = 2;
    const DELIVERED = 3;
    const CHARGED = 4;
    //
    const DELIVERY_DETAIL = 'delivery_detail';
    const DELIVERY_DETAIL_GUEST = 'delivery_detail_of_guest';
    const DELIVERY_DETAIL_CUSTOMER = 'delivery_detail_of_customer';
    const ORDER_DETAIL = 'order_detail';
    const CUSTOMER = 'user';

    public $properties
        = [
            'customer_id', 'delivery_detail_id', 'payment_method_id', 'comment'
        ];
    protected $table = 'orders';
    protected $guarded = array('id', 'created_at', 'updated_at');
    protected $fillable
        = [
            'customer_id', 'delivery_detail_id', 'payment_method_id', 'comment'
        ];

    public function deliveryDetailOfGuest()
    {
        return $this->hasOne('\App\DeliveryDetail', 'id', 'delivery_detail_id');
    }

    public function deliveryDetailOfCustomer()
    {
        return $this->hasOne('\App\Customer', 'user_id', 'user_id');
    }

    public function OrderDetail()
    {
        return $this->hasMany('\App\OrderDetail', 'order_id', 'id');
    }

    public function status()
    {
        return $this->hasOne('\App\Status_orders', 'id', 'status');
    }


    private function suggestStatus($status)
    {
        if ($status == $this::PENDING) {
            return ['status_prev' => $this::CANCEL, 'status_next' => $this::DELIVERING];
        }
        if ($status == $this::DELIVERING) {
            return ['status_prev' => $this::CANCEL, 'status_next' => $this::DELIVERED];
        }
        if ($status == $this::DELIVERED) {
            return ['status_prev' => $this::CANCEL, 'status_next' => $this::CHARGED];
        }
        return [];
    }

    public function filterOrder()
    {

        Session::put('order_filter');
    }

    public function getDataForPagination($dataRequest)
    {
        // Config sort
        $sortBy    = 'id';
        $sortOrder = 'asc';
        if (isset($dataRequest['sort'])) {
            $sort      = $dataRequest['sort'];
            $sortColum = ['id', 'created_at'];
            $sortBy    = (in_array(key($sort), $sortColum)) ? key($sort) : 'id';
            $sortOrder = current($sort);
        }
        //search status
        $searchStatus  = Order::PENDING;
        $searchStatus  = Session::get('order_filter');
        $query         = $this
            ->with('status')
            ->with('deliveryDetailOfGuest')
            ->with('deliveryDetailOfCustomer', 'deliveryDetailOfCustomer.user')
            ->with('OrderDetail')
            ->where('status', $searchStatus)
            ->where(function () use ($dataRequest) {
                $this->where('id', 'LIKE', '%' . $dataRequest['searchPhrase'] . '%')
                    ->orWhere('created_at', 'LIKE', '%' . $dataRequest['searchPhrase'] . '%');
            });
        $queryGetTotal = $query;
        $total         = $queryGetTotal->count();
        if (intval($dataRequest['rowCount']) == -1) {
            $data = $query->orderBy($sortBy, $sortOrder)
                ->get()->toArray();
        } else {
            $data = $query->orderBy($sortBy, $sortOrder)
                ->skip($dataRequest['rowCount'] * ($dataRequest['current'] - 1))
                ->take($dataRequest['rowCount'])
                ->get()->toArray();
        }
        $rowsData             = [];
        $listAttrFromDelivery = ['email'];
//        if (Cache::has('order' . $dataRequest['current'])) {
//            $rowsData = (Cache::get('order' . $dataRequest['current']));
//        } else {
        foreach ($data as $aData) {
            $aRow = [];

            foreach ($aData as $k => $property) {
                if (is_array($property) && !empty($property)) {
                    if (preg_match('/^' . $this::DELIVERY_DETAIL . '/', $k)) {
                        foreach ($property as $keyDDPP => $DeliveryDetailPP) {
                            if ($keyDDPP == $this::CUSTOMER) {
                                $aRow['email'] = $DeliveryDetailPP['email'];
                            } elseif (in_array($keyDDPP, $listAttrFromDelivery)) {
                                $aRow[$keyDDPP] = $DeliveryDetailPP;
                            }
                        }
                    }
                    if ($k == $this::ORDER_DETAIL) {
                        $aRow['total'] = 0;
                        $aRow['item']  = 0;
                        foreach ($property as $keyOD => $OrderDetail) {
                            $subTotal = $OrderDetail['quantity'] * $OrderDetail['price'];
                            $aRow['total'] += $subTotal;
                            $aRow['item'] += $OrderDetail['quantity'];
                        }
                    }
                    if ($k == 'status') {
                        $aRow[$k]   = $property['name'];
                        $listStatus = $this->suggestStatus($property['id']);
                        if (!empty($listStatus)) {
                            $tagChange = '';
                            foreach ($listStatus as $k => $valStatus) {
                                switch ($valStatus) {
                                    case 0: {
                                        $type = 'danger';
                                    }
                                        break;
                                    case 1: {
                                        $type = 'warning';
                                    }
                                        break;
                                    case 2: {
                                        $type = 'primary';
                                    }
                                        break;
                                    case 3: {
                                        $type = 'primary';
                                    }
                                        break;
                                    default: {
                                        $type = 'success';
                                    }
                                };
                                $tagChange .= '<button value="' . $valStatus . '" id="' . $aRow['id'];
                                $tagChange .= '"  class="btnChange btn btn-xs btn-' . $type . '" >';
                                $tagChange .= Status_orders::find($valStatus)->name . '</button>';
                            }
                            $aRow['edit'] = $tagChange;
                        }
                    }
                } else {
                    $aRow[$k] = $property;
                }

            }


            $rowsData[] = $aRow;
        }
//            Cache::put('order' . $dataRequest['current'], $rowsData, 120);
//        }

        $result             = [];
        $result['current']  = intval($dataRequest['current']);
        $result['rowCount'] = intval($dataRequest['rowCount']);
        $result['_token']   = csrf_token();
        $result['total']    = intval($total);
        $result['rows']     = ($rowsData);
//        dd($rowsData);
        return $result;
    }

    public function viewOrder($id)
    {
        $order                = $this
            ->with('status')
            ->with('deliveryDetailOfGuest')
            ->with('deliveryDetailOfCustomer', 'deliveryDetailOfCustomer.user')
            ->with('OrderDetail', 'OrderDetail.product', 'OrderDetail.product.priceGroup')
            ->find($id)
            ->toArray();
        $listAttrFromDelivery = ['email', 'first_name', 'last_name', 'address1', 'address2', 'city_id', 'state_id'];
        $row                  = [];
//        dd($order);
        $row['customer_info'] = [];
        foreach ($order as $k => $property) {
            if (is_array($property) && !empty($property)) {
                if (strcmp($this::DELIVERY_DETAIL_CUSTOMER, $k) == 0) {
                    foreach ($property as $keyDDPP => $DeliveryDetailPP) {
                        if (strcmp($keyDDPP, $this::CUSTOMER) == 0) {
                            $row['customer_info']['phone'] = $DeliveryDetailPP['phone'];
                            $row['customer_info']['email'] = $DeliveryDetailPP['email'];
                        } else if (in_array($keyDDPP, $listAttrFromDelivery)) {
                            $row['customer_info'][$keyDDPP] = $DeliveryDetailPP;
                        }
                    }
                } elseif (strcmp($this::DELIVERY_DETAIL_GUEST, $k) == 0) {
                    foreach ($property as $keyDDPP => $DeliveryDetailPP) {
                        $row['customer_info'][$keyDDPP] = $DeliveryDetailPP;
                    }
                }
                if (strcmp($k, $this::ORDER_DETAIL) == 0) {

                    $row['order']          = [];
                    $row['order']['total'] = 0;
                    $row['order']['item']  = 0;

                    foreach ($property as $keyOD => $OrderDetail) {
                        $row['order']['detail'][] = $OrderDetail;
                        $subTotal                 = $OrderDetail['quantity'] * $OrderDetail['price'];
                        $row['order']['total'] += $subTotal;
                        $row['order']['item'] += $OrderDetail['quantity'];
                    }
                }
                if ($k == 'status') {
                    $row[$k] = $property['name'];
                }
            } else {
                $row[$k] = $property;
            }
        }
        $row['customer_info']['city_id']  = Address::find($row['customer_info']['city_id'])->name;
        $row['customer_info']['state_id'] = Address::find($row['customer_info']['state_id'])->name;
        return ($row);
    }

    public function listInvoice($id)
    {
        $order = $this
            ->where('user_id', $id)
            ->where('status', $this::CHARGED)
            ->get(['id', 'created_at'])
            ->toArray();
        return $order;
    }

    public function viewInvoice($id)
    {
        $order                = $this
            ->with('status')
            ->with('deliveryDetailOfCustomer', 'deliveryDetailOfCustomer.user')
            ->with('OrderDetail', 'OrderDetail.product', 'OrderDetail.product.priceGroup')
            ->where('status', $this::CHARGED)
            ->find($id)
            ->toArray();
        $listAttrFromDelivery = ['email', 'first_name', 'last_name', 'address1', 'address2', 'city_id', 'state_id'];
        $row                  = [];
        $row['customer_info'] = [];
        foreach ($order as $k => $property) {
            if (is_array($property) && !empty($property)) {

                if (strcmp($k, $this::ORDER_DETAIL) == 0) {

                    $row['order']          = [];
                    $row['order']['total'] = 0;
                    $row['order']['item']  = 0;
                    foreach ($property as $keyOD => $OrderDetail) {
                        $row['order']['detail'][] = $OrderDetail;
                        $subTotal                 = $OrderDetail['quantity'] * $OrderDetail['price'];
                        $row['order']['total'] += $subTotal;
                        $row['order']['item'] += $OrderDetail['quantity'];
                    }
                }
                if ($k == 'status') {
                    $row[$k] = $property['name'];
                }
            }
        }
        return ($row);
    }
}