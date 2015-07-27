<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/13/2015
 * Time: 11:46 PM
 */

namespace App\Http\Requests;


class CreatePriceGroupRequest extends Request{
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
            'name'=>'required',
            'root_price'=>'required|alpha_num|min:0',
            'price'=>'required|alpha_num|min:0',
            'sale_off'=>'required|alpha_num|min:0',
        ];
    }
}