<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/22/2015
 * Time: 3:24 PM
 */

namespace App\Http\Requests;


class OrderRequest extends Request{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'=>'required|integer|exists:orders',
        ];
    }
}