<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/20/2015
 * Time: 11:47 AM
 */

namespace App\Http\Requests;


class CreateDeliverDetailRequest extends Request{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email|unique:users',
            'phone'=>'required',
            'address1'=>'required',
            'address2'=>'required',
            'city_id'=>'required',
            'state_id'=>'required',
            'check'=>'required',
            'g-recaptcha-response'=>'required'
        ];
    }
}