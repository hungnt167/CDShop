<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/22/2015
 * Time: 11:05 PM
 */

namespace App\Http\Requests;


class ChangeStatusOrderRequest extends Request{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'=>'required|exists:orders',
            'status'=>'required|integer|min:0|max:4',
        ];
    }
}