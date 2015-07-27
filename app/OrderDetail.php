<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/20/2015
 * Time: 6:45 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    protected $guarded = ['id'];
    public $properties
        = [
            'order_id', 'product_id', 'quantity', 'price'
        ];
    public function product(){
        return $this->hasOne('App\Cd','id','product_id');
    }
}