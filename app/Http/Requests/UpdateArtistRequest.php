<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/21/2015
 * Time: 12:31 PM
 */

namespace App\Http\Requests;


class UpdateArtistRequest extends Request{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'=>'required|exists:artists',
            'name'=>'required',
            'description'=>'',
            'talent'=>'alpha_num',
        ];
    }
}