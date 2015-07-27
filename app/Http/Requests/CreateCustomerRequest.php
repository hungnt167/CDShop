<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/19/2015
 * Time: 10:05 PM
 */

namespace App\Http\Requests;


class CreateCustomerRequest extends Request{
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
            'name'=>'required|unique:users',
            'email'=>'required|email|unique:users',
            'phone'=>'required',
            'password'=>'required',
            'confirmpassword'=>'required|same:password',
            'address1'=>'required',
            'address2'=>'required',
            'city_id'=>'required|exists:address,id',
            'state_id'=>'required|exists:address,id',
            'check'=>'required',
            'g-recaptcha-response'=>'required'
        ];
    }
}