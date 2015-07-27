{{--<pre>--}}
<?php
#$u=\App\User::with('role')->get()->toArray();
#   var_dump($u);
# $routes=  \Illuminate\Support\Facades\Route::getRoutes();
//Get all routes
/*i
f ($routes == null) {
    return;
}
foreach ($routes as $value) {
    $path=$value->getPath();
    if(preg_match('/^admin/',$path)){
        $allRoutes[] = $path;
        $arr_routes = array_unique($allRoutes);
    }

}
        var_dump($arr_routes);
*/
#$user=\Illuminate\Support\Facades\Session::get('user');
#$userRole=$user['role_id'];
#$role=\App\Role::where('id','!=',1)->where('id','!=',$userRole)->get(['id','name'])->toArray();
#    var_dump($role);


//Navibar
/*
 *
 $model=new \App\Catalog();
$catalogs=$model->where('in_page',0)->get(['id','parent_id','uri','level','name'])->toArray();

$result='';
$maxLv=$model->where('in_page',0)->max('level');
$countRoot=$model->where('in_page',0)->where('level',0)->count();
echo $maxLv;
$listCatalogs=[];
for($i=0;$i<=$maxLv;$i++){
    $listCatalogs[]=$model->where('in_page',0)->where('level',$i)->get(['id','parent_id','uri','level','name'])->toArray();
}
$arrTag=[];
for($i=0;$i<$countRoot;$i++){
    $result.='<li><a href="#">';
    $result.=array_get($listCatalogs[0][$i],'name');
    if(isset($listCatalogs[1])){
        for($j=0;$j<sizeof($listCatalogs[1]);$j++){
            if(array_get($listCatalogs[1][$j],'parent_id')==array_get($listCatalogs[0][$i],'id')){
                $result.='<ul><li><a href="#">';
                $result.=array_get($listCatalogs[1][$j],'name');
                if(isset($listCatalogs[2])){
                    for($m=0;$m<sizeof($listCatalogs[2]);$m++){
                        if(array_get($listCatalogs[2][$m],'parent_id')==array_get($listCatalogs[1][$j],'id')){
                            $result.='<ul><li><a href="#">';
                            $result.=array_get($listCatalogs[2][$m],'name');
                            if(isset($listCatalogs[3])){
                                for($n=0;$n<sizeof($listCatalogs[3]);$n++){
                                    if(array_get($listCatalogs[3][$n],'parent_id')==array_get($listCatalogs[2][$m],'id')){
                                        $result.='<ul><li><a href="#">';
                                        $result.=array_get($listCatalogs[3][$n],'name');

                                        $result.='</a></li></ul>';
                                    }
                                }
                            }
                            $result.='</a></li></ul>';
                        }
                    }
                }
                $result.='</a></li></ul>';
            }
        }
    }

    $result.='</a></li>';
}
echo $result;

*/
#   var_dump(\Illuminate\Support\Facades\Cache::get('user'));
#$artists=\App\Artist::all();
#$user=\App\User::all();
#var_dump($user);
#var_dump($artists);
#dd( \Gloudemans\Shoppingcart\Facades\Cart::content());
# dd(\Illuminate\Support\Facades\Session::all());
#\Illuminate\Support\Facades\Session::flush();
#dd(Cache::pull('order1'))
#dd(\Illuminate\Support\Facades\Cache::get('user'));
?>
{!!\Collective\Html\FormFacade::open(['file='=>true,'action'=>'TestController@test'])!!}
{{--{!!\Collective\Html\FormFacade::file('image')!!}--}}
{{--<input type="text" name="name" value=""/>--}}
{{--<input type="text" name="role_id" value=""/>--}}
{{--<input type="checkbox" name="cb"/>--}}
<script src='https://www.google.com/recaptcha/api.js'></script>
<div class="g-recaptcha" data-sitekey="6LdkCQoTAAAAALNT3hXvjB3fQXX9Rc1_zmyd4LyF"></div>
<input type="submit" value="go"/>

{!!\Collective\Html\FormFacade::close()!!}
{{--</pre>--}}
{{--@include('layout.frontend.head')--}}
<?php
$c = new \App\Artist();
$c->update([
        'talent' => 11
]);
$order = new \App\Order();
$t = $order->with('deliveryDetailOfCustomer')
        ->where('id', 50)->get()->toArray();
dd($t);
$cus = new \App\Customer();
$t = $cus->with('user')->get()->toArray();
dd();
?>
#$cd->render()

{{--@include('layout.frontend.footer')--}}