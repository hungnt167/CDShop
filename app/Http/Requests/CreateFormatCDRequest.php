<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/26/2015
 * Time: 6:27 PM
 */

namespace App\Http\Requests;


class CreateFormatCDRequest extends Request{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=>'required|unique:format_cds',
        ];
    }
}