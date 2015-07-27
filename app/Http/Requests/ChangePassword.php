<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/25/2015
 * Time: 10:14 PM
 */

namespace App\Http\Requests;


class ChangePassword extends Request{
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
            'current_password'=>'required',
            'new_password'=>'required|min:6',
            'confirm'=>'same:new_password',
        ];
    }
}