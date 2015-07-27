<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/21/2015
 * Time: 1:50 PM
 */

namespace App\Http\Requests;


class DestroyProductRequest extends  Request{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'=>'required|exists:cds',
        ];
    }
}