<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/21/2015
 * Time: 12:55 PM
 */

namespace App\Http\Requests;


class UpdateTypeRequest extends Request{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'=>'required|exists:types',
            'name'=>'required|unique:types',
        ];
    }
}