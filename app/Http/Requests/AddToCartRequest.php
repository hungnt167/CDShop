<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/16/2015
 * Time: 9:10 AM
 */

namespace App\Http\Requests;



class AddToCartRequest extends Request{
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
        ];
    }
}