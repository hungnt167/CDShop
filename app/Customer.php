<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/19/2015
 * Time: 10:18 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = ['id'];
    public $properties
        = [
             'first_name', 'last_name', 'address1', 'address2',
            'city_id', 'state_id',
        ];
    protected $fillable = [
        'first_name', 'last_name', 'address1', 'address2',
        'city_id', 'state_id','created_at','user_id',
    ];

    public function user(){
        return $this->hasOne('\App\User','id','user_id');
    }

}
