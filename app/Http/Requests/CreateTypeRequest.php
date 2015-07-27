<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/21/2015
 * Time: 12:54 PM
 */

namespace App\Http\Requests;


class CreateTypeRequest extends  Request{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=>'required|unique:types',
        ];
    }
}