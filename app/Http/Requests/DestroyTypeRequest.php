<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/21/2015
 * Time: 12:58 PM
 */

namespace App\Http\Requests;


class DestroyTypeRequest extends Request{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'=>'required|exists:types',
        ];
    }
}