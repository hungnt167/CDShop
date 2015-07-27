<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/6/2015
 * Time: 3:37 PM
 */

namespace App\Http\Controllers;


use App\Cd;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    public function sendmail()
    {
        $data["mail_message"] = "Hello!";

        Mail::send('auth.mail_welcome', ['name' => 'Hung'], function ($message) {
            $message
                ->to('sadautumnnth@gmail.com')
                ->from('info@otherdomain.com')
                ->subject('TEST');
        });
    }

    public function file(Request $request)
    {
//
        if (!is_null(Input::file('images'))) {
            dd($request->all());
        }
    }

    public function test(Request $request)
    {
//        $model=new User();
//        $model=autoAssignDataToProperty($model,$request->all());
//        dd($model->save());
//        dd($request->all());
//        $result = DB::table('cds')
//            ->join('artists', 'cds.singer_id', '=', 'artists.id')
//            ->get();
//        var_dump($request);
//        $cd=Cd::simplePaginate(2);
//        $cd->setPath('test');
//        return view('test.index')->with('cd',$cd);
//        $models=new Cd();
//        $offset=0;
//        $limit=6;
//        $models = $this
//            ->with('singer')
//            ->with('composer')
//            ->with('priceGroup')
//            ->with('type')
//            ->with('format')
//            ->where('status', $this::ACTIVE)
//            ->orderBy('priceGroup.price', 'des')
//            ->skip($offset)
//            ->take($limit)
//            ->get();
//        adump($models->toArray());
        dd($request->all());
    }


}