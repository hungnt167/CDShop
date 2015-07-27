<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/25/2015
 * Time: 11:01 PM
 */

namespace App\Http\Requests;


class UpdateCustomerRequest extends Request{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'=>'required|exists:customers',
            'phone'=>'required',
            'address1'=>'required',
            'address2'=>'required',
            'check'=>'required',
            'city_id'=>'required|exists:address,id',
            'state_id'=>'required|exists:address,id',
        ];
    }
}