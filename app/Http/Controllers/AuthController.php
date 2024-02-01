<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Admin;
use App\Models\Pc;
use App\Models\Product;
use App\Models\SiteSetting;
use Auth;
use Carbon\Carbon;

class AuthController extends Controller
{

    protected $redirectTo = '/';

    public function __construct()
    {

        $this->middleware('guest:admin')->except('logout','login');
    }

    public function login()
    {


        if (Auth::guard('admin')->check()) {
            if(
                session('current_user_role') == 'accountant')
            {
                return redirect()->route('sale_item_report_data');
            }
            return redirect()->route('adminDashboard');
        }
        $pcs = Pc::where('is_active',1)
        ->where('is_closed',0)->get();
        return view('AdminPanel.login',get_defined_vars());
    }

    public function handleLogin(Request $request)
    {

        $email = $request->email;
        $password = $request->password;
        $pc_id = $request->pc;
        $ip = $request->ip;
        $pc = Pc::where('is_active',1)
        ->where('is_closed',0)
        ->where('id',$pc_id)
        ->first();
        $admin = Admin::where('email',$email)->first();
        $user_role = $admin->role ;

        if(!$pc)
        {
            if( $user_role == 'super_admin')
            {
                $pc_id = 1;
                $pc = Pc::where('id',$pc_id)
                ->first();

            }
            else
            {

                return redirect()->back()
                ->with('status', 'login_error')
                ->with('message', "choose correct pc");

            }
        }
        $data = ['email' => $email, 'password' => $password];

        if (Auth::guard('admin')->attempt($data)) 
        {
            $current_user = Auth::guard('admin')->user() ;
            $current_user_id = $current_user->id ;
            $current_user_role = $current_user->role ;
           
            $shift_id = Shift::get_user_shift($pc_id);
            $lastUpdatedTime = SiteSetting::where('name','products_last_updated')->first()->value;


            $isUpdatedToday = Carbon::parse($lastUpdatedTime)->isToday();
            if(!$isUpdatedToday)
            {
                //update
                $OracleProductsController = app()->make('App\Http\Controllers\OracleProductsController');
                $OracleProductsController->update_all();

            }
            $lastUpdatedTime = SiteSetting::where('name','products_last_updated')->first()->value;
            $isUpdatedToday = Carbon::parse($lastUpdatedTime)->isToday();
            $is_tester = false ;
            if($current_user_id == 10)$is_tester = true ;
            session([
                'user_id' => $current_user_id,
                'shift_id' => $shift_id ,
                'current_user_name' => $current_user->name ,
                'products_updated_today' => $isUpdatedToday ,
                'products_last_updated' => $lastUpdatedTime ,
                'current_user_role' => $current_user_role ,
                'current_pc' => $pc->id ,
                'current_pc_name' => $pc->name ,
                'is_tester' => $is_tester ,
            ]);
            return redirect()->intended(route('adminDashboard'));
        } else {
            return redirect()->back()
                ->with('status', 'login_error')
                ->with('message', "Email Or Password Wrong");
        }
    }

    public function profile()
    {
        return view('AdminPanel.profile');
    }
    public function EditProfile(Request $request)
    {

        $inputs=$request->only('email');
        if ($request->input('password'))
        {
            $inputs['password'] =bcrypt($request->input('password'));
        }
        User::find(Auth::guard('admin')->user()->id)->update($inputs);
       return redirect()->back()->with('message','Edit Successfully');
    }

    public function adminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }
    public function change_password()
    {
        $user_id = $_GET['user_id'];
        $new_password = $_GET['new_password'];
        $admin = Admin::where('id',$user_id)->first();
        if($admin)
        {
         $admin->password = Hash::make($new_password);
         $admin->save();
         echo 'done';
        }
    }
}
