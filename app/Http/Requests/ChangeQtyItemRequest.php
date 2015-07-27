<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/21/2015
 * Time: 11:19 AM
 */

namespace App\Http\Requests;


class ChangeQtyItemRequest extends Request{
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
            'qty'=>'required|alpha_num|min:1',
            'id'=>'required|exists:cds',
            'idrow'=>'required',
        ];
    }
}