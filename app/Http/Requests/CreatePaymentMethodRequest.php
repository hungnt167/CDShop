<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/20/2015
 * Time: 1:57 PM
 */

namespace App\Http\Requests;


class CreatePaymentMethodRequest extends Request{
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
            'payment_method'=>'required',
            'comment'=>'',
        ];
    }
}