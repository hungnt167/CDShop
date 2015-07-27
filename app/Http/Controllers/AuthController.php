<?php

namespace App\Http\Controllers;

use App\Address;
use App\Customer;
use App\Permission;
use App\Role;
use App\User;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use libraries\Authen;
use Illuminate\Support\Facades\Session;
use UploadImage;
use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\ChangePassword;
use App\Http\Requests\ResetPassword;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

//================================================= LOGIN PAGE ========================================================//
    public function getLogin()
    {
        if (Authen::check()) {
            return redirect()->back();
        } else {
            return view('auth.login');
        }
    }

//================================================= SIGN IN PAGE =====================================================//
    public function getRegister()
    {
        $role = Role::all();
        return view('auth.register', compact('role', $role));
    }

//================================================= LOGOUT FUNCTION ==================================================//
    public function getLogout()
    {
        if (Authen::check()) {
            Session::flush();
            if (Cache::has('user')) {
                Cache::forget('user');
            }
        }
        return redirect('home');
    }

//================================================= LOGIN FUNCTION ====================================================//
    function postLogin(LoginRequest $request)
    {
        //get Request
        $getDataRequest = $request->all();
        $data           = array(
            'name' => $getDataRequest['name'],
            'password' => $getDataRequest['password']
        );

        $userInfo = User::where('name', $data['name'])->first()->toArray();
        //Check status?
        if ($userInfo['status'] == User::IN_ACTIVED_STATUS) {
            return redirect_errors("Account active yet!");
        }
        //Check password
        $password = md5($data['password'] . md5($userInfo['remember_token']));;

        if ($password == $userInfo['password']) {
            //Add Session
            Authen::setUser($userInfo);
            //Check remember
            if (Input::get('remember')) {
                $permissions    = Permission::where('name', 'like', $userInfo['role_id'] . '%')->get(['name']);
                $listPermission = [];
                foreach ($permissions as $per) {
                    $listPermission[] = $per['name'];
                }
                $data               = $userInfo;
                $data['permission'] = $listPermission;
                Cache::put('user', $data, 6000);
            }
            //navigator page
            if ($userInfo['role_id'] == Role::SA_ROLE_ID || $userInfo['role_id'] == Role::AD_ROLE_ID) {
                return redirect()->action('BackendController@index');
            } elseif (Cart::total() > 0 && $userInfo['role_id'] == Role::CUS_ROLE_ID) {
                Session::forget('option');
                // is customer ensure to have shipping_add already
                Session::put('option', [
                    'type' => 'logged',
                    'shi_add' => true,
                    'pay_add' => true,
                    'pay_med' => false,
                    'conf' => false,
                ]);
                return redirect()->action('FrontendController@checkout');
            } else {
                return redirect('home');
            }
        }
        return redirect_errors("Password Wrong!");

    }

//================================================= REGISTER FUNCTION ================================================//
    public function postRegister(CreateUserRequest $request)
    {
        //        getDataRequest
        $getDataRequest = $request->all();
        $ip             = $_SERVER['SERVER_ADDR'];
        $response       = $getDataRequest['g-recaptcha-response'];
        $list           = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LdkCQoTAAAAAHt8GyYu3DzOO-5ngXRKMWm8HE1A&response=' . $response . '&remoteip=' . $ip);
        $json           = json_decode($list, true);


        //check capcha
        if ($json['success'] == 1) {
            $user = new  User();
            $user = autoAssignDataToProperty($user, $getDataRequest);
            //Check is upload avatar
            if (!is_null(Input::file('image'))) {
                $upload = new UploadImage();
                $image  = Input::file('image');
                //check upload
                if ($upload->upload($image)) {
                    $user->avatar = $upload->name;
                    $this->doRegister($user);
                } else {
                    return redirect_errors('Have Error, Cannot upload image!');
                }//end check upload
            } else {
                $user->avatar = 'person.png';

            }
            $remember_token       = str_random(30);
            $key_active           = str_random(30);
            $name                 = $user->name;
            $password             = $user->password;
            $email                = $user->email;
            $data                 = [
                'name' => $name,
                'email' => $email,
            ];
            $user->remember_token = $remember_token;
            $user->created_at     = Carbon::now();
            $user->password       = md5($user->password . md5($remember_token));
            $user->key_active     = $key_active;
            //check add new
            DB::beginTransaction();
            try {

                ($user->save());
                DB::commit();
                Mail::send('auth.mail_welcome', ['name' => $data['name'], 'key' => $key_active, 'password' => $password],
                    function ($message) use ($data) {
                        $message
                            ->to($data['email'], $data['name'])
                            ->from('info@otherdomain.com')
                            ->subject('Welcome to the TopMp3!');
                    });
                return redirect_success('AuthController@getLogin', 'Check your email ' . $data['email'] . ' to active!');
            } catch (\Exception $e) {
                dd($e);
                DB::rollback();
                return redirect_errors('Have Error, Try again,please!');
            }
        } else {
            return redirect_errors('Wrong reCapcha!');
        }
    }

//================================================= REGISTER CUSTOMER FUNCTION ========================================//
    public function createCustomer(CreateCustomerRequest $request)
    {
        //        getDataRequest
        $getDataRequest = $request->all();
        $ip             = $_SERVER['SERVER_ADDR'];
        $response       = $getDataRequest['g-recaptcha-response'];
        $list           = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LdkCQoTAAAAAHt8GyYu3DzOO-5ngXRKMWm8HE1A&response=' . $response . '&remoteip=' . $ip);
        $json           = json_decode($list, true);

//        check capcha
        if ($json['success'] == 1) {
            $user         = new User();
            $customer     = new Customer();
            $customer     = autoAssignDataToProperty($customer, $getDataRequest);
            $user         = autoAssignDataToProperty($user, $getDataRequest);
            $user->avatar = 'person.png';
            $this->doRegister($user);
            $remember_token       = str_random(30);
            $key_active           = str_random(30);
            $name                 = $user->name;
            $password             = $user->password;
            $email                = $user->email;
            $data                 = [
                'name' => $name,
                'email' => $email,
            ];
            $user->remember_token = $remember_token;
            $user->created_at     = Carbon::now();
            $user->password       = md5($user->password . md5($remember_token));
            $user->key_active     = $key_active;
            //check add new
            DB::beginTransaction();
            try {

                $user->save();
                $user_Id           = User::where('email', $email)->first()->id;
                $customer->user_id = $user_Id;
                $customer->save();
                DB::commit();
                Mail::send('auth.mail_welcome', ['name' => $data['name'], 'key' => $key_active, 'password' => $password],
                    function ($message) use ($data) {
                        $message
                            ->to($data['email'], $data['name'])
                            ->from('info@otherdomain.com')
                            ->subject('Welcome to the TopMp3!');
                    });
                return redirect_success('AuthController@getLogin', 'Check your email ' . $data['email'] . ' to active!');
            } catch (\Exception $e) {
                dd($e);
                DB::rollback();
                return redirect_errors('Have Error, Try again,please!');
            }
        } else {
            return redirect_errors('Wrong reCapcha!');
        }
    }

//============================================ UPDATE ADDRESS CUSTOMER PAGE ==========================================//
    public function getUpdatePaymentAddressCustomer()
    {
        View::share([
            'navigator' => \NavigatorHelper::getNavigatorBarFE(),
            'sideBar' => \NavigatorHelper::getSideBarFE()
        ]);
        if (!Session::has('user')) {
            return redirect_errors('You login yet!');
        }
        $user = Session::get('user');
        if ($user['role_id'] != Role::CUS_ROLE_ID) {
            return redirect_errors('You are not Customer!');
        }
        $customer     = new Customer();
        $cusInfo      = $customer
            ->with('user')
            ->where('user_id', $user['id'])->first()->toArray();
        $current_City = Address::find($cusInfo['city_id'])->id;
        $cities       = Address::where('parent_id', 0)->get()->toArray();
        $state        = Address::find($cusInfo['state_id'])->toArray();
        return view('change_payment_address.index')->with(['info' => $cusInfo, 'currentCity' => $current_City, 'cities' => $cities, 'state' => $state]);
    }

//================================================= UPDATE ADDRESS CUSTOMER ==========================================//
    public function postUpdatePaymentAddressCustomer(Requests\UpdateCustomerRequest $request)
    {
        $user = Session::get('user');

        DB::beginTransaction();
        try {
            //update account
            $account = User::where('id', $user['id'])->update([
                'phone' => $request->input('phone')
            ]);
            //update customer
            $cus = Customer::where('id', $request->input('id'))->update([
                'address1' => $request->input('address1'),
                'address2' => $request->input('address2'),
                'city_id' => $request->input('city_id'),
                'state_id' => $request->input('state_id'),
            ]);
            DB::commit();
            return redirect_success('FrontendController@index', 'success', 'Your information changed!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect_errors('Cannot update information!');
        }


    }

//================================================= ACTIVE ACCOUNT FUNCTION ==========================================//
    public function doActive($nameUser, $keyActive)
    {
        //progress string
        $name = preg_replace('/[^a-zA-Z0-9\-_]/', '', $nameUser);
        $key  = preg_replace('/[^a-zA-Z0-9\-_]/', '', $keyActive);

        $user = User::where('name', $name)->where('key_active', $key);
        //do active, update key
        $user->update(['status' => User::ACTIVED_STATUS, 'key_active' => str_random(30)]);
        if (Authen::check()) {
            Session::flush();
            if (Cache::has('user')) {
                Cache::forget('user');
            }
        }//end active
        return redirect('active_success');
    }

//================================================= CHANGE PASSWORD PAGE =============================================//
    public function getChangePassword()
    {
        if (!Session::has('user')) {
            return redirect_errors('You login yet!');
        }
        return view('auth.change_password');
    }

//================================================= CHANGE PASSWORD FUNCTION =========================================//
    public function postChangePassword(ChangePassword $request)
    {
        $user     = Session::get('user');
        $userInfo = User::find($user['id']);
        $password = md5($request->get('current_password') . md5($userInfo->remember_token));
        if ($password != $userInfo->password) {
            redirect_errors('Current password wrong!');
        }
        $newPassword = md5($request->get('new_password') . md5($userInfo->remember_token));
        $userInfo    = User::find($user['id'])->update([
            'password' => $newPassword
        ]);
        if ($user['role_id'] == Role::CUS_ROLE_ID) {
            return redirect_success('FrontendController@home', 'success', 'Your password changed!');
        }
        return redirect_success('BackendController@index', 'success', 'Your password changed!');
    }

//================================================= RESET PASSWORD FUNCTION ==========================================//
    public function resetPassword(ResetPassword $request)
    {
        //getDataRequest
        $getDataRequest = $request->all();

        $ck = User::where('email', $getDataRequest['email'])->where('status', User::ACTIVED_STATUS)->count();
        //check active
        if ($ck == 0) {
            return redirect_errors('Account active yet!');

        }
        //get User data
        $user = User::where('email', $getDataRequest['email'])
            ->get(['name', 'key_active', 'remember_token'])
            ->first()
            ->toArray();
        //gen new pass
        $newPass  = str_random(8);
        $codePass = md5($newPass . md5($user['remember_token']));
        //put into array data
        $data = [
            'name' => $user['name'],
            'email' => $getDataRequest['email'],
            'password' => $newPass,
        ];
        //update User and check update
        if ($user = User::where('email', $getDataRequest['email'])
            ->update(['password' => $codePass, 'key_active' => str_random(30)])
        ) {
            Mail::send('auth.mail_repass', ['name' => $data['name'], 'password' => $newPass],
                function ($message) use ($data) {
                    $message
                        ->to($data['email'], $data['name'])
                        ->from('info@otherdomain.com')
                        ->subject('Reset Password TopMp3!');
                });
            return redirect_success('AuthController@getLogin', 'Check your email ' . $data['email'] . ' to check new password!');
        } else {
            return redirect_errors('Have error!');
        }//end check update
    }
//================================================= END ==============================================================//
}