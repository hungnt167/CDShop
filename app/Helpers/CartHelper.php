<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/17/2015
 * Time: 5:44 PM
 */
use App\Cd;
class CartHelper {
        public  static  function getDetailItem($cart){
            $items=[];
            foreach ($cart as $item) {
                $tmp = [];
                $model = new Cd();
                $dataModel = $model->where('id', $item['id'])
                    ->with('singer')
                    ->with('format')
                    ->with('composer')
                    ->first();
//            dd($dataModel);
                $tmp['singer'] = $dataModel->singer->name;
                $tmp['format'] = $dataModel->format->name;
                $tmp['portal'] = $dataModel->portal;
                $items[] = $tmp;
            }
            return $items;
        }
}