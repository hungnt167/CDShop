<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/25/2015
 * Time: 10:33 PM
 */

namespace App\Http\Requests;


class ResetPassword extends Request{
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
            'email'=>'required|exists:users,email',
        ];
    }
}