<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/21/2015
 * Time: 11:05 PM
 */

namespace App\Http\Requests;


class UpdateProductRequest extends Request{
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
            'id'=>'required|exists:cds',
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