<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/26/2015
 * Time: 6:21 PM
 */

namespace App\Http\Requests;


class DestroyFormatCDRequest extends Request{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'=>'required|exists:format_cds',
        ];
    }
}