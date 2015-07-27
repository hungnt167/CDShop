<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/19/2015
 * Time: 7:00 PM
 */

namespace App\Http\Requests;


class OptionCheckoutRequest extends Request{
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
            'account'=>'required',
        ];
    }
}