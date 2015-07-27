<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/10/2015
 * Time: 11:40 AM
 */

namespace App\Http\Controllers;


use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\DestroyAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use UploadImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use NavigatorHelper;

class AccountController extends Controller
{
    const ROLE_ID_SA = 1;
    const DEFAULT_IMAGE_PERSON = 'person.png';

//================================================= INDEX ============================================================//
    public function index()
    {

        View::share([
            'title' => Lang::get('List Account'),
            'sideBar' => NavigatorHelper::getSideBarBE()
        ]);
        $model = new Role();
        //Not display SA
        $role = $model->where('id', '!=', self::ROLE_ID_SA)->get();
        return view('account.list', compact('role', $role));
    }

//================================================= CREATE PAGE ======================================================//
    public function create()
    {
        View::share([
            'title' => Lang::get('content.create account'),
            'sideBar' => NavigatorHelper::getSideBarBE()
        ]);
        $model = new Role();
        //Not display SA
        $role = $model->where('id', '!=', 1)->get();
        return view('account.create', compact('role', $role));
    }

//=============================================== STORE USER FUNCTION ================================================//
    public function store(CreateUserRequest $request)
    {
//        dataRequest
        $dataRequest = $request->all();

        $model = new User();
        $model = autoAssignDataToProperty($model, $dataRequest);
//        $data=autoAssignDataToProperty($model,$request);
//        check level create
        if ($model->role_id == $this::ROLE_ID_SA) {
            return redirect_errors('Have Error, Cannot create Super Admin!');
        }
//        Check is upload avatar
        if (!is_null(Input::file('image'))) {
            $image  = Input::file('image');
            $upload = new UploadImage();

//            check upload
            if ($upload->upload($image)) {
                $model->avatar = $upload->name;
            } else {
                return redirect_errors('Have Error, Cannot upload image!');
            }//end check upload
//            check success add yet?
            if ($this->doStore($model)) {
                return redirect()->back()->with('success', 'Check  email ' . $model->email . ' to check new password!');
            } else {
                return redirect_errors('Have Error, Try again,please!');
            }
        } else {
            $email         = $model->email;
            $model->avatar = 'person.png';
            if ($this->doStore($model)) {
                return redirect()->back()->with('success', 'Check  email ' . $email . ' to check new password!');
            } else {
                return redirect_errors('Have Error, Try again,please!');
            };
        }
    }

//================================================= DO STORE ==========================================================//
    public function doStore($model)
    {

        $remember_token = str_random(30);
        $key_active     = str_random(30);
        $password       = md5($model->password . md5($remember_token));
        $name           = $model->name;
        $pass           = $model->password;
        $email          = $model->email;
        $data           = [
            'name' => $name,
            'email' => $email,
        ];

        $model->remember_token = $remember_token;
        $model->created_at     = Carbon::now();
        $model->password       = $password;
        $model->key_active     = $key_active;


        //check add new
        if ($model->save()) {
            Mail::send('auth.mail_welcome', ['name' => $name, 'key' => $key_active, 'password' => $pass],
                function ($message) use ($data) {
                    $message
                        ->to($data['email'], $data['name'])
                        ->from('info@otherdomain.com')
                        ->subject('Welcome to the TopMp3!');
                });
            return true;
        } else {
            return false;
        }//end check add new
    }

//================================================= UPDATE USER FUNCTION ==============================================//
    public function update(UpdateAccountRequest $request)
    {
        //dataRequest
        $dataRequest = $request->all();

        //check upload Image
        if (!is_null(Input::file('image'))) {
            $upload = new UploadImage();
            //get old avt
            $oldAvatar = User::where('id', Input::get('id'))->first();
            $image     = Input::file('image');
            if ($upload->_upload($oldAvatar->avatar, $image)) {

            } else {
                return redirect_errors('Error upload image!');
            }

            $user             = User::find(Input::get('id'));
            $user             = autoAssignDataToProperty($user, $dataRequest);
            $user->updated_at = Carbon::now();
            //check update
            if ($user->save()) {
                return redirect()->back()->with('success', "Update Success!");
            } else {
                return redirect_errors('Error cannot update!');
            }
        } else {
            //get old Avt
            $oldAvatar = User::where('id', Input::get('id'))->first();
            //check has image
            if ($oldAvatar->avatar != $this::DEFAULT_IMAGE_PERSON) {
                //delete old image
                File::delete($oldAvatar->avatar);
            }
            $user = User::find(Input::get('id'));
            //check update
            $user             = autoAssignDataToProperty($user, $dataRequest);
            $user->updated_at = Carbon::now();
            if ($user->save()) {
                return redirect()->back()->with('success', "Update Success!");
            } else {
                return redirect_errors('Error cannot update!');
            };
        }//end check update
    }

//========================================= GET DATA USER FOR TABLE USING AJAX =======================================//
    public function getDataAjax(Request $request)
    {
        //get Data Request
        $dataRequest = $request->all();
        $model       = new User;
        //pass to Model
        $result = $model->getDataForPagination($dataRequest);

        die(json_encode($result));
    }
//=========================================== FILTER ROLE USER =====================================================//
    public function filterRole()
    {
        if (is_null(Input::get('id'))) {
            Session::put('role_filter', Role::AD_ROLE_ID);
        }
        if (Role::find(Input::get('id'))->count() == 0) {
            Session::put('role_filter', Role::AD_ROLE_ID);
        }
        Session::put('role_filter', Input::get('id'));
    }
//================================================= GET DATA A USER ===================================================//
    public function getDataUser()
    {
        //check has post id
        if (Input::get('id')) {
            $id = intval(Input::get('id'));
            //check exist account
            if ($userData = User::where('id', $id)->where('role_id', '!=', 0)->count() > 0) {
                $userData = User::with('role')->where('id', $id)->first();
                $data     = array(
                    'id' => $userData->id,
                    'name' => $userData->name,
                    'phone' => $userData->phone,
                    'email' => $userData->email,
                    'role_id' => $userData->role_id,
                    'role' => $userData->role->name,
                    'image' => $userData->avatar,
                    'status' => $userData->status,
                );
                return json_encode($data);
            }
        } else {
            $error = ['type' => 'e', 'message' => 'Have error!'];
            return json_encode($error);
        }

    }

//================================================= REMOVE USER =======================================================//
    public
    function destroy(DestroyAccountRequest $request)
    {
        $id    = Input::get('id');
        $model = new User();
        $model->where('role_id', '!=', Role::SA_ROLE_ID)
            ->where('role_id', '!=', Role::CUS_ROLE_ID)
            ->where('id', $id)->first();
        if ($model
                ->where('role_id', '!=', Role::SA_ROLE_ID)
                ->where('role_id', '!=', Role::CUS_ROLE_ID)
                ->where('id', $id)->count() > 0
        ) {
            UploadImage::removeImage(
                $model->where('id', $id)->first()->avatar);
            $model->where('id', $id)->delete();
            return redirect()->back()->with('success', "Deleted!");
        } else {
            return redirect_errors('Cannot remove Super Admin');
        }
    }
}