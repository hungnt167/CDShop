<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/13/2015
 * Time: 11:46 PM
 */

namespace App\Http\Requests;


class CreateProductRequest extends Request{
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
            'singer_id'=>'required',
            'composer_id'=>'required',
            'quantity'=>'required|integer|min:0',
            'image'=>'',
            'format_id'=>'required|exists:format_cds,id',
            'type_id'=>'required|exists:types,id',
            'public_date'=>'required|date',
            'root_price'=>'',
            'price'=>'',
            'group_price_id'=>'',
            'sale_off'=>'',
        ];
    }
}