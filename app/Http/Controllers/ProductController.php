<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/12/2015
 * Time: 7:04 PM
 */

namespace App\Http\Controllers;


use App\Artist;
use App\Cd;
use App\Format_cd;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\DestroyProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Interest_rate;
use App\Price_group;
use App\Sale_off_group;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use NavigatorHelper;
use UploadImage;

class ProductController extends Controller
{
//=============================================== INDEX PRODUCT =======================================================//
    public function index()
    {
        View::share([
            'title' => 'Product management',
            'sideBar' => NavigatorHelper::getSideBarBE()
        ]);
        $type         = Type::all(['id', 'name'])->toArray();
        $format       = Format_cd::all(['id', 'name'])->toArray();
        $price_groups = Price_group::all(['id', 'name', 'root_price', 'price'])->toArray();
        return view('catalog.product.list')->with([
            'type' => $type,
            'format' => $format,
            'price_groups' => $price_groups,
        ]);
    }

//=============================================== GET DATA A PRODUCT =================================================//
    public function getDataProduct(Request $request)
    {
        //check validate
        $rules     = [
            'id' => 'required|exists:cds'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $error = ['type' => 'e', 'message' => 'Have error!'];
            return json_encode($error);
        }
        $id     = Input::get('id');
        $model  = new Cd();
        $column = [
            'cds.id', 'cds.name', 'singer_id', 'composer_id', 'artists.name as singer',
            'cds.status', 'format_id', 'type_id', 'quantity', 'public_date', 'portal', 'cds.description',
            'cds.root_price', 'cds.price', 'cds.sale_off', 'cds.group_price_id',
            'price_groups.price as price_group', 'price_groups.sale_off as sale_off_group',
            'price_groups.id as price_g_id', 'price_groups.root_price as price_group_root_price'
        ];
        return ($model->getDataAProduct($id, $column));
    }

//=========================================== GET DATA PRODUCTS FOR TABLE  ===========================================//
    public function getDataAjax(Request $request)
    {
        $dataRequest = $request->all();
        $model       = new Cd();
        $result      = $model->getDataForPagination($dataRequest);
        die(json_encode($result));
    }

//=========================================== CREATE NEW PRODUCT =====================================================//
    public function create(CreateProductRequest $request)
    {

        //getDataRequest
        $dataRequest = $request->all();
        // validate image
        $files = Input::file('image');
        //check upload
        $upload = new UploadImage();
        if ($upload->upload($files)) {
            $dataRequest['portal'] = $upload->name;
        } else {
            return redirect_errors('Have error , upload image');
        }//end check upload

        //rule if  hasn't group price
        $rulesNotGroup = [
            'root_price' => 'required|min:0',
            'price' => 'required|min:0',
            'sale_off' => 'required|min:0|max:99',
        ];
        //rules has group
        $rulesGroup             = [
            'group_price_id' => 'required|exists:price_groups,id',
        ];
        $validatorRulesGroup    = Validator::make($dataRequest, $rulesGroup);
        $validatorNotRulesGroup = Validator::make($dataRequest, $rulesNotGroup);
        if ($validatorRulesGroup->fails() and $validatorNotRulesGroup->fails()) {
            return redirect_errors('You must fill up form!');
        } else {
            $model = new Cd();
            $model = autoAssignDataToProperty($model, $dataRequest);
            if ($model->save()) {
                return redirect()->back()->with('success', 'Added!');
            } else {
                return redirect_errors('Have error, cannot Add!');
            };
        }

    }

//=========================================== UPDATE A PRODUCT =======================================================//
    public function update(UpdateProductRequest $request)
    {
        //get data
        $dataRequest = $request->all();
        $id          = Input::get('id');
        //true, check upload image
        //check has upload new image?
        if (!is_null(Input::file('image'))) {
//                        dd(Input::file('images'));
            $image  = Input::file('image');
            $upload = new UploadImage();

            if ($upload->upload($image)) {
                $dataRequest['portal'] = $upload->name;
            } else {
                return redirect_errors('Have error ,Cannot upload!');
            }
            //create Cd obj
            $cd      = new Cd();
            $newData = autoAssignDataToProperty($cd, $dataRequest);
            //check update
            if ($cd->find($id)->update($newData->toArray())) {
                return redirect()->back()->with('success', "Updated");
            } else {
                return redirect_errors('Have error ,Cannot update!');
            }//end check update

        } else {
            //create Cd obj
            $cd      = new Cd();
            $newData = autoAssignDataToProperty($cd, $dataRequest);
//            dd($cd);
            //check update
            if ($cd->find($id)->update($newData->toArray())) {
                return redirect()->back()->with('success', "Updated");
            } else {
                return redirect_errors('Have error ,Cannot update!');
            }//end check update
        }

    }

//=========================================== REMOVE A PRODUCT =======================================================//
    public function destroy(DestroyProductRequest $request)
    {
        $id = Input::get('id');
        //check delete

        if (Cd::find($id)->update([
            'status' => Cd::IN_ACTIVE
        ])
        ) {
            return redirect()->back()->with('success', 'Deleted');
        } else {
            return redirect_errors('Have error,Cannot delete');
        }//end check delete
    }

//=========================================== SEARCH COMPOSER USING AJAX ==============================================//
    public function searchSinger(Request $request)
    {
        //get data
        $dataRequest = $request->all();
        $key         = $dataRequest['key'];

        if (!is_null($key) && !empty($key)) {
            $key   = Input::get('key');
            $model = new Artist();
            return json_encode($model->searchSinger($key));
        } else {
            json_encode([]);
        }
    }

//=========================================== SEARCH COMPOSER USING AJAX ==============================================//
    public function searchComposer(Request $request)
    {
        //get data
        $dataRequest = $request->all();
        $key         = $dataRequest['key'];

        if (!is_null($key) && !empty($key)) {
            $key   = Input::get('key');
            $model = new Artist();
            return json_encode($model->searchComposer($key));
        } else {
            return json_encode([]);
        }
    }
}