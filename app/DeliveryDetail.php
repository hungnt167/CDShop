<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/20/2015
 * Time: 4:52 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class DeliveryDetail extends Model
{
//    protected
    public $properties
        = [
            'first_name', 'last_name', 'email', 'phone', 'address1',
            'address2', 'city_id', 'state_id', '_token'
        ];
    public function user(){
        return $this->hasOne('\App\User', 'id', 'user_id');
    }
    public function getDeliveryDetail($condition)
    {
        return $this
            ->where('first_name', $condition['first_name'])
            ->where('last_name', $condition['last_name'])
            ->where('email', $condition['email'])
            ->where('phone', $condition['phone'])
            ->where('address1', $condition['address1'])
            ->where('address2', $condition['address2'])
            ->where('city_id', $condition['city_id'])
            ->where('state_id', $condition['state_id'])
            ->where('_token', $condition['_token'])
            ->orderBy('created_at','desc')
            ->first();
    }
}