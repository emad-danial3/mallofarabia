<?php

namespace App\Http\Controllers\Website;

use App\Constants\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Services\OrderTypesCommissions\CreateUserCommission;
use App\Mail\RegistrationEmail;
use App\Mail\ContactUsEmail;

use App\Models\Banner;
use App\Models\Category;
use App\Models\City;
use App\Models\Filter;
use App\Models\OrderHeadersPackup;
use App\Models\Image;

//d
use App\Models\OrderHeader;
use App\Models\OrderLine;
use App\Models\Paragraph;

//d;

use App\Models\Product;
use App\Models\RegisterLink;
use App\Models\User;
use App\Models\Area;
use App\Models\Subscriber;
use App\Models\AccountType as Accout_type;
use App\Models\AccountLevel as Account_levels;
use App\Models\NettingJoin as Nettingjoin;
use App\Models\UserCommission as User_commission;
use App\Models\UserCommission;
use App\SendMessage\SendMessage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route as FacadesRoute;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (!session()->get('locale')) {
            session()->put('locale', 'en');
            session()->save();
            app()->setLocale('en');
        }
    }

    public function forgot($id, $token)
    {
        $userCount = \App\Models\ForgotPassword::where([
            "token"   => $token,
            "user_id" => $id,
            "is_used" => 0
        ])->count();

        if ($userCount > 0)
            return view('forgot', compact('id'));

        abort(404);
    }

    public function paySuccess(Request $request)
    {

        $id                = $request->input('id');
        $statusDescription = $request->input('statusDescription');
        $statusCode        = $request->input('statusCode');
        $orderStatus       = $request->input('orderStatus');
        return view('cart.paySuccess', compact('id', 'statusDescription', 'statusCode', 'orderStatus'));
    }

    public function subscribers(Request $request)
    {
        return view('subscribers');
    }

    public function updateforgot(Request $request, $id)
    {

        $id               = $request->id;
        $password         = $request->password;
        $confirm_password = $request->confirm_password;
        $user             = User::where('id', $id)->first();

        if ($password == $confirm_password) {
            \App\Models\ForgotPassword::where([
                "user_id" => $id,
            ])->update([
                "is_used" => 1
            ]);

            User::where('id', $id)
                ->update(['password'         => Hash::make($password),
                          'initial_password' => $password]);
            return redirect('/');
        }

        else {
            return redirect()->back()->with('Error', 'Password does not match');

        }

    }

    public function addSubscriberEmail(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email:rfc,dns'
        ]);
        $data          = ['email' => $request->input('email')];
        $Subscriber    = Subscriber::create($data);
        $response      = [
            'status'  => 200,
            'message' => "Subscriber Add Success",
            'data'    => $Subscriber
        ];
        return response()->json($response);
    }

    public function sendMessageEmail(Request $request)
    {
        $validatedData = $request->validate([
            'email'      => 'required|email:rfc,dns',
            'first_name' => 'required',
            'last_name'  => 'required',
            'phone'      => 'required',
            'subject'    => 'required',
            'message'    => 'required',
        ]);

        $data = [
            'email'      => $request->input('email'),
            'first_name' => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'phone'      => $request->input('phone'),
            'subject'    => $request->input('subject'),
            'message'    => $request->input('message'),
        ];

        Mail::to(env('MAIL_FROM_ADDRESS'))->send(new ContactUsEmail($data));
        if (count(Mail::failures()) > 0) {
            return false;
        }

        $response = [
            'status'  => 200,
            'message' => "Subscriber Add Success",
            'data'    => $data
        ];
        return response()->json($response);
    }

    public function lang($locale)
    {

        session()->forget('locale');
        session()->put('locale', $locale);
        session()->save();
        app()->setLocale($locale);
//      dd(trans('auth.attributes.home'));
        return redirect()->back();
    }

    public function home()
    {
        return "Coming Soon";
//        session()->put('cart_count', '5');
//        session()->save();

//        App::setLocale(Session::get('locale'));
//        if (session()->get('locale')=='ar')
//        {
//            $sliderImages=Image::where('type','slider')->select('id','image_ar as image')->get();
//            $paragraphs=Paragraph::where('page_number',1)->select('id','value_ar as value')->get();
//        }
//        else
//        {
//            $sliderImages=Image::where('type','slider')->select('id','image_en as image')->get();
//            $paragraphs=Paragraph::where('page_number',1)->select('id','value_en  as value')->get();
//        }

//        $categories = Category::where('level', 1)->whereNull('parent_id')->with('sub')->get();
        $banners      = Banner::where('id', '>', 0)->orderBy('priority', 'ASC')->get()->toArray();
        $bannersCount = count($banners);
        $filters      = Filter::where('is_available', 1)->orderBy("sort","ASC")->take(9)->get();
        $saveProducts = Product::select('products.stock_status','products.id', 'products.flag', 'products.excluder_flag', 'products.excluder_flag', 'products.full_name', 'products.name_en', 'products.name_ar', 'products.description_en',
            'products.description_ar', 'products.image', 'products.oracle_short_code', 'products.discount_rate',
            'products.price', 'products.old_price', 'products.old_discount', 'products.price_after_discount', 'products.quantity', 'categories.name_en as category_name')
            ->leftJoin('product_categories', 'products.id', 'product_categories.product_id')
            ->leftJoin('categories', 'categories.id', 'product_categories.category_id')
            ->where('products.stock_status', 'in stock')
            ->where('products.visible_status', '1')
            ->where('products.quantity', '>', 0)->groupBy('products.id')->skip(0)->take(7)->get();

//        $bestSellerProducts = Product::select('products.id', 'products.flag', 'products.excluder_flag', 'products.full_name', 'products.name_en', 'products.name_ar', 'products.description_en',
//            'products.description_ar', 'products.image', 'products.oracle_short_code', 'products.discount_rate',
//            'products.price', 'products.old_price', 'products.old_discount', 'products.price_after_discount', 'products.quantity')
//            ->leftJoin('order_lines', 'order_lines.product_id', 'products.id')
//            ->where('products.stock_status', 'in stock')
//            ->where('products.quantity', '>', 0)->orderBy('order_lines.id', 'DESC')->groupBy('products.id')->skip(0)->take(9)->get();

        $brandsCategories = Category::where('level', 1)->whereNotNull('image')->skip(0)->take(7)->get();

        return view('welcome', compact('saveProducts', 'filters', 'brandsCategories', 'banners', 'bannersCount'));
    }


    public function free()
    {
        App::setLocale(Session::get('locale'));
        if (session()->get('locale') == 'ar') {
            $sliderImages = Image::whereIn('type', ['freePlanBanner', 'freePlanBannerLeft', 'freePlanBannerRigth'])->select('id', 'image_ar as image')->get();
            $paragraphs   = Paragraph::where('page_number', 2)->select('id', 'value_ar as value')->get();
        }
        else {
            $sliderImages = Image::whereIn('type', ['freePlanBanner', 'freePlanBannerLeft', 'freePlanBannerRigth'])->select('id', 'image_en as image')->get();
            $paragraphs   = Paragraph::where('page_number', 2)->select('id', 'value_en  as value')->get();
        }

        return view('free', compact('paragraphs', 'sliderImages'));
    }


    public function premium()
    {
        App::setLocale(Session::get('locale'));
        if (session()->get('locale') == 'ar') {
            $sliderImages = Image::whereIn('type', ['premiumBanner', 'premiumBannerleft', 'premiumBanneright'])->select('id', 'image_ar as image')->get();
            $paragraphs   = Paragraph::where('page_number', 3)->select('id', 'value_ar as value')->get();
        }
        else {
            $sliderImages = Image::whereIn('type', ['premiumBanner', 'premiumBannerleft', 'premiumBanneright'])->select('id', 'image_en as image')->get();
            $paragraphs   = Paragraph::where('page_number', 3)->select('id', 'value_en  as value')->get();
        }

        return view('premium', compact('paragraphs', 'sliderImages'));
    }

    public function about()
    {
        App::setLocale(Session::get('locale'));

        if (session()->get('locale') == 'ar') {
            $paragraphs = Paragraph::where('page_number', 4)->select('id', 'value_ar as value')->get();
            $Image      = Image::where('type', 'aboutUs')->select('id', 'image_ar as image')->first();
        }
        else {
            $paragraphs = Paragraph::where('page_number', 4)->select('id', 'value_en  as value')->get();

            $Image = Image::where('type', 'aboutUs')->select('id', 'image_en as image')->first();
        }

        return view('about', compact('paragraphs', 'Image'));
    }

    public function segment_commission()
    {
        return view('segment_commission');
    }

    public function terms()
    {
        App::setLocale(Session::get('locale'));

        if (session()->get('locale') == 'ar') {
            $paragraphs = Paragraph::where('page_number', 4)->select('id', 'value_ar as value')->get();
            $Image      = Image::where('type', 'aboutUs')->select('id', 'image_ar as image')->first();
        }
        else {
            $paragraphs = Paragraph::where('page_number', 4)->select('id', 'value_en  as value')->get();

            $Image = Image::where('type', 'aboutUs')->select('id', 'image_en as image')->first();
        }

        return view('terms', compact('paragraphs', 'Image'));
    }

    public function privacy()
    {
        App::setLocale(Session::get('locale'));

        if (session()->get('locale') == 'ar') {
            $paragraphs = Paragraph::where('page_number', 4)->select('id', 'value_ar as value')->get();
            $Image      = Image::where('type', 'aboutUs')->select('id', 'image_ar as image')->first();
        }
        else {
            $paragraphs = Paragraph::where('page_number', 4)->select('id', 'value_en  as value')->get();

            $Image = Image::where('type', 'aboutUs')->select('id', 'image_en as image')->first();
        }

        return view('privacy', compact('paragraphs', 'Image'));
    }

    public function refund()
    {
        App::setLocale(Session::get('locale'));

        if (session()->get('locale') == 'ar') {
            $paragraphs = Paragraph::where('page_number', 4)->select('id', 'value_ar as value')->get();
            $Image      = Image::where('type', 'aboutUs')->select('id', 'image_ar as image')->first();
        }
        else {
            $paragraphs = Paragraph::where('page_number', 4)->select('id', 'value_en  as value')->get();

            $Image = Image::where('type', 'aboutUs')->select('id', 'image_en as image')->first();
        }

        return view('refund', compact('paragraphs', 'Image'));
    }

    public function increaseIncome()
    {
        App::setLocale(Session::get('locale'));

        if (session()->get('locale') == 'ar') {
            $paragraphs = Paragraph::where('page_number', 4)->select('id', 'value_ar as value')->get();
            $Image      = Image::where('type', 'aboutUs')->select('id', 'image_ar as image')->first();
        }
        else {
            $paragraphs = Paragraph::where('page_number', 4)->select('id', 'value_en  as value')->get();

            $Image = Image::where('type', 'aboutUs')->select('id', 'image_en as image')->first();
        }

        return view('increase_income', compact('paragraphs', 'Image'));
    }


    public function how()
    {
        App::setLocale(Session::get('locale'));
        if (session()->get('locale') == 'ar') {
            $paragraphs = Paragraph::where('page_number', 5)->select('id', 'value_ar as value')->get();
            $Image      = Image::where('type', 'howItWork')->select('id', 'image_en as image')->first();
        }
        else {
            $paragraphs = Paragraph::where('page_number', 5)->select('id', 'value_en  as value')->get();
            $Image      = Image::where('type', 'howItWork')->select('id', 'image_en as image')->first();
        }
        return view('how', compact('paragraphs', 'Image'));
    }


    public function contact_us()
    {
        App::setLocale(Session::get('locale'));
        return view('contact');
    }

    public function wishlist()
    {
        App::setLocale(Session::get('locale'));
        return view('wishlist');
    }

    public function contactUs(Request $request)
    {

        App::setLocale(Session::get('locale'));
        $this->validate(request(), [
            'name'    => 'required|min:3|max:50',
            'phone'   => 'required|min:3|max:50',
            'email'   => 'required|email:rfc,dns',
            'message' => 'required|min:3|max:100'
        ]);


        $url      = 'https://www.google.com/recaptcha/api/siteverify';
        $secret   = '6LeOcGMgAAAAAEmfk2Qn6V6OABAL7w2ncvNOhvCG';
        $response = $request->token_generate;

        $recaptch_check = file_get_contents($url . '?secret=' . $secret . '&response=' . $response);


        $recaptch_check = json_decode($recaptch_check);

        if ($recaptch_check->success == false) {
            return redirect()->back()->with('error', 'Please Try Again Later');
        }

        $inputs     = [
            "name"    => $request->input('name'),
            "email"   => $request->input('email'),
            "message" => $request->input('message'),
            "phone"   => $request->input('phone'),
        ];
        $to_name    = "NettingHub";
        $to_email   = "info@nettinghub.com";
        $data       = array("name" => $inputs['name'], "body" => $inputs['message']);
        $from_email = $inputs['email'];

        //     Mail::send([], $data, function($message) use ($to_name, $to_email,$from_email,$inputs) {
        //     $message->to($to_email, $to_name)
        //     ->subject("Join Us");
        //   $message->from($from_email);
        //     $message->setBody('<h1>message : '.$inputs['message'].'</h1>'.'<h1>phone: '.$inputs['phone'].'</h1>', 'text/html');

        //     });
        $data = [
            "email"     => 'khaled.abodeif@atr-eg.com',
            "password"  => 'ssss',
            "full_name" => 'khaled',
            "subject"   => 'test'
        ];
        Mail::to($inputs['email'])->send(new RegistrationEmail($data));

        Nettingjoin::create(\request()->only('email', 'name', 'phone', 'message'));
        return redirect()->back()->with('message', 'Thanks for submitting your contact info');;
    }

    public function singUpFree(Request $request)
    {
        App::setLocale(Session::get('locale'));
        $user_id = $request->id;
        $token   = $request->token;
        if ($user_id == 1) {
            return view('signUpFree', compact('user_id'));
        }
//          $link ='/registrationfree/'.$user_id.'/'.$token;
//        $freecount=DB::table('register_links')->where('link',$link)->where('is_used',0)->count();
        $freecount = RegisterLink::where('user_id', $user_id)->where('is_used', 0)->count();

        if ($freecount >= 1) {
            return view('signUpFree', compact('user_id'));
        }
        else {
            abort(404);
        }

        return view('signUpFree');
    }

    public function singUpFreeHandel(Request $request)
    {

        App::setLocale(Session::get('locale'));
        $this->validate(request(), [
            'name'       => 'required',
            'firstname'  => 'required|regex:/^[a-zA-ZÑñ\s]+$/',
            'middlename' => 'required|regex:/^[a-zA-ZÑñ\s]+$/',
            'lastname'   => 'required|regex:/^[a-zA-ZÑñ\s]+$/',
            'gender'     => 'required',
            'email'      => 'required|string|email:rfc,dns|max:100|unique:users',
            'mob1'       => 'required|max:11|min:11|regex:/(01)[0-9]{9}/|unique:users,phone',
            'password'   => 'required|confirmed|min:6|max:10'
        ]);

        $firstname   = ucfirst(request()->input('firstname'));
        $middlename  = ucfirst(request()->input('middlename'));
        $lastname    = ucfirst(request()->input('lastname'));
        $email       = request()->input('email');
        $fullname    = $firstname . ' ' . ' ' . $middlename . ' ' . $lastname;
        $user_id     = request()->input('user_id');
        $mob         = request()->input('mob1');
        $gender      = request()->input('gender');
        $notionality = request()->input('notionality');
        $password    = $request->input('password');
//        $password =$password2;
        $data = [
            'email'            => $email,
            'phone'            => $mob,
            'gender'           => $gender,
            'parent_id'        => $user_id,
            'notionality'      => $notionality,
            'full_name'        => $fullname,
            'password'         => Hash::make($password),
            'initial_password' => $password,
            'stage'            => 2,
            'visability'       => 1,
            'freeaccount'      => 1,
            'account_type'     => 3];
        //address important for ahmed
        User::create($data);
        $id      = DB::getPdo()->lastInsertId();
        $userRow = User::find($id);
        Account_levels::create([
            'parent_id' => $user_id,
            'level'     => 1,
            'child_id'  => $id
        ]);
        $count = Account_levels::where('child_id', $user_id)->count();
        if ($count > 0) {

            $level2 = Account_levels::where('child_id', $user_id)->get();

            foreach ($level2 as $levels2) {

                $lv2   = $levels2->parent_id;
                $level = $levels2->level;


                Account_levels::create([
                    'parent_id' => $lv2,
                    'level'     => $level + 1,
                    'child_id'  => $id
                ]);
            }


        }
        $email   = request()->input('email');
        $subject = "Congratulation NettingHub";
        $data    = [
            "email"     => $email,
            "password"  => request()->input('password'),
            "full_name" => $fullname,
            "subject"   => $subject
        ];
        try {
            Mail::to($email)->send(new RegistrationEmail($data));

        }
        catch (Exception $ex) {

            Log::error('mail :: ' . $ex->getMessage());
        }

        if (Mail::failures()) {
            Log::error('mail :: ', Mail::failures());
        }

        $mob    = request()->input('mob1');
        $text   = 'Hello ' . $firstname . ', \n User Name:' . $email . ' \n Password:  ' . request()->input('password') . ' \n Download the Application from Google play or APP store';
        $text   = str_replace(' ', '%20', $text);
        $resalt = SendMessage::sendMessage($mob, $text);
//        $sendtext='Your free account is now run for 30 days with Mr/Mrs '.$fullname.'';
//        $text=str_replace(' ', '%20', $sendtext);
//        $resalt2=SendMessage::sendMessage($mob,$text);

        return view('thank');
    }

    public function singUpPremium(Request $request)
    {
        App::setLocale(Session::get('locale'));
        $user_id = $request->id;
        $token   = $request->token;

        if ($user_id == 1) {
            $data['cities'] = City::select(['name_en', 'id'])->distinct()->get();
            return view('signup', $data, compact('user_id'));
        }

        $link = "https://nettinghub.com/muser/public" . '/' . 'registration' . '/' . $user_id . '/' . $token;
//        $freecount=DB::table('sharelinks')->where('url',$link)->count();
        $freecount = RegisterLink::where('user_id', $user_id)->where('is_used', 0)->count();

        if ($freecount > 0) {
            $data['cities'] = City::select(['name_en', 'id'])->distinct()->get();
            return view('signup', $data, compact('user_id'));
        }
        else {
            abort(404);
        }
    }

    public function getregions(Request $request)
    {

        $data['regions'] = Area::select('region_en')->where("city", $request->city_id)->get();
        return response()->json($data);
    }

    public function singUpPremiumHandel(Request $request)
    {
        $check_names = [
            $request->get('name'),
            $request->get('firstname'),
            $request->get('lastname'),
            $request->get('middlename')
        ];

        foreach ($check_names as $value) {
            if (preg_match('/[اأإء-ي]/ui', $value)) {

                return back()->with('error', 'Please Insert Your Name in  English Format, <br> برجاء ادخال اسمك باللغة الانجليزية فقط');

            }

        }

        App::setLocale(Session::get('locale'));
        $this->validate(request(), [
            'name'             => 'required',
            'firstname'        => 'required',
            'middlename'       => 'required',
            'lastname'         => 'required',
            'email'            => 'required|string|email:rfc,dns|max:100|unique:users',
            'birthday'         => 'required',
            'address'          => 'required',
            'building_number'  => 'required',
            'floor_number'     => 'required',
            'apartment_number' => 'required',
            'landmark'         => 'required',
            'mob1'             => 'required|unique:users,phone',
            'mob2'             => 'max:11',
            'tel'              => 'max:10',
            'nationality_id'   => 'required|max:14|min:14|unique:users',
            'images'           => 'required|mimes:jpeg,jpg,png|required|max:2000',
            'images2'          => 'required|mimes:jpeg,jpg,png|required|max:2000',
            'password'         => 'required|confirmed|min:6',

        ]);


        $image_name     = $_FILES['images']['name'];
        $tmp_name       = $_FILES['images']['tmp_name'];
        $directory_name = public_path() . '/images/';     //folder where image will upload
        $file_name      = $directory_name . $image_name;
        move_uploaded_file($tmp_name, $file_name);
        $compress_file  = "1" . time() . $image_name;
        $compressed_img = $directory_name . $compress_file;
        $compress_image = $this->compressImage($file_name, $compressed_img);
        unlink($file_name);            //delete original file
        $image_name2     = $_FILES['images2']['name'];
        $tmp_name2       = $_FILES['images2']['tmp_name'];
        $directory_name2 = public_path() . '/images/';     //folder where image will upload
        $file_name2      = $directory_name2 . $image_name2;
        move_uploaded_file($tmp_name2, $file_name2);
        $compress_file2  = "2" . time() . $image_name2;
        $compressed_img2 = $directory_name2 . $compress_file2;
        $compress_image2 = $this->compressImage2($file_name2, $compressed_img2);
        unlink($file_name2);            //delete original file
        $firstname  = $request->input('firstname');
        $middlename = $request->input('middlename');
        $lastname   = $request->input('lastname');
        $fullname   = $firstname . ' ' . ' ' . $middlename . ' ' . $lastname;

        $res                     = $request->only(['name', 'email', 'gender', 'birthday', 'address', 'city',
                                                   'area', 'building_number', 'floor_number', 'apartment_number', 'landmark',
                                                   'account_type', 'nationality_id', 'user_id', 'notionality']);
        $res['phone']            = $request['mob1'];
        $res['phone2']           = $request['mob2'];
        $res['password']         = Hash::make($request->input('password'));
        $res['initial_password'] = $request->input('password');
        $res['telephone']        = $request['tel'];
        $res['stage']            = 2;
        $res['full_name']        = $firstname . ' ' . ' ' . $middlename . ' ' . $lastname;

        $res['parent_id'] = $request->input('user_id');
        $user             = User::create($res);
        $user_id          = $request->input('user_id');
        $password         = $request->input('password');
        $id               = DB::getPdo()->lastInsertId();
        $nid              = $request->input('nationality_id');
        $acc              = User::orderBy('created_at', 'desc')->skip(1)->take(1)->first();
        $accid            = $acc->account_id;
        $srtacc           = Str::substr($accid, 0, 4);
        $srt              = Str::substr($nid, -7);
        $serial           = 100;
        $nationalid       = rand(1000000000, 9999999999);
        $u                = User::where('id', $id)
            ->update(['account_id' => $nationalid, 'full_name' => $fullname, 'front_id_image' => 'https://4unettinghub.com/images/' . $compress_file, 'back_id_image' => 'https://4unettinghub.com/images/' . $compress_file2]);
        Account_levels::Create([
            'parent_id' => $user_id,
            'level'     => 1,
            'child_id'  => $id
        ]);
        $count = Account_levels::where('child_id', $user_id)->where('level', '<=', 2)->count();
        if ($count > 0) {
            $level2 = Account_levels::where('child_id', $user_id)->where('level', '<=', 2)->get();
            foreach ($level2 as $levels2) {
                $lv2   = $levels2->parent_id;
                $level = $levels2->level;
                Account_levels::Create([
                    'parent_id' => $lv2,
                    'level'     => $level + 1,
                    'child_id'  => $id
                ]);
            }
        }
        //commisionkhaled
        $u          = User::where('id', $id)->first();
        $utype      = $u->account_type;
        $ammount    = Accout_type::where('id', $utype)->first();
        $commission = DB::select('
SELECT users.account_type ,account_levels.level,account_commissions.commission,account_levels.parent_id
FROM `account_levels`,users,account_commissions
    where
 account_levels.child_id= ' . $id . '

and account_levels.parent_id = users.id

and account_commissions.level=account_levels.level

and account_commissions.account_id=users.account_type


	                      ');
        foreach ($commission as $commissions) {

            $com          = ($commissions->commission * $ammount->amount) / 100;
            $userid       = $commissions->parent_id;
            $camout       = $ammount->amount;
            $ccommissions = $commissions->commission;
            User_commission::Create([
                'commission'            => $com,
                'user_id'               => $userid,
                'id_redeem'             => 0,
                'commission_percentage' => $ccommissions,
                'commission_by'         => $id,

            ]);
        }
        $password = $request->input('password');


        $email   = request()->input('email');
        $subject = "Congratulation NettingHub";
        $data    = [
            "email"     => $email,
            "password"  => request()->input('password'),
            "full_name" => $fullname,
            "subject"   => $subject
        ];
        Mail::to($email)->send(new RegistrationEmail($data));
        $mob    = request()->input('mob1');
        $text   = 'Hello ' . $firstname . ', \n User Name:' . $email . ' \n Password:  ' . request()->input('password') . ' \n Download the Application from Google play or APP store';
        $text   = str_replace(' ', '%20', $text);
        $resalt = SendMessage::sendMessage($mob, $text);


        return view('thank');
        // auth()->login($user);
        //return redirect()->to('/shop');

    }


    private function compressImage($source_image, $compress_image)
    {
        $image_info = getimagesize($source_image);
        if ($image_info['mime'] == 'image/jpeg') {
            $source_image = imagecreatefromjpeg($source_image);
            imagejpeg($source_image, $compress_image, 35);             //for jpeg or gif, it should be 0-100
        }
        elseif ($image_info['mime'] == 'image/png') {
            $source_image = imagecreatefrompng($source_image);
            imagepng($source_image, $compress_image, 3);                //for png it should be 0 to 9
        }
        elseif ($image_info['mime'] == 'image/jpg') {
            $source_image = imagecreatefromjpeg($source_image);
            imagejpg($source_image, $compress_image, 35);             //for jpeg or gif, it should be 0-100
        }


        return $compress_image;
    }


    private function compressImage2($source_image, $compress_image)
    {
        $image_info = getimagesize($source_image);
        if ($image_info['mime'] == 'image/jpeg' or $image_info['mime'] == 'image/jpg') {
            $source_image = imagecreatefromjpeg($source_image);
            imagejpeg($source_image, $compress_image, 35);             //for jpeg or gif, it should be 0-100
        }
        elseif ($image_info['mime'] == 'image/jpg') {
            $source_image = imagecreatefromjpeg($source_image);
            imagejpg($source_image, $compress_image, 35);             //for jpeg or gif, it should be 0-100
        }
        elseif ($image_info['mime'] == 'image/png') {
            $source_image = imagecreatefrompng($source_image);
            imagepng($source_image, $compress_image, 3);                //for png it should be 0 to 9
        }
        return $compress_image;
    }

    public function category()
    {
        App::setLocale(Session::get('locale'));
        if (session()->get('locale') == 'ar') {
            $titles       = Paragraph::where('page_number', 6)->where('name', 'title')->select('id', 'value_ar as value')->get();
            $descriptions = Paragraph::where('page_number', 6)->where('name', 'description')->select('id', 'value_ar as value')->get();
        }
        else {
            $titles       = Paragraph::where('page_number', 6)->where('name', 'title')->select('id', 'value_en as value')->get();
            $descriptions = Paragraph::where('page_number', 6)->where('name', 'description')->select('id', 'value_en as value')->get();
        }
        return view('category', compact('titles', 'descriptions'));
    }

    public function deleteOldPendingOrder()
    {
// get orders that pending and not paid

        $now        = Carbon::now()->toDateTimeString();
        $nowM30days = date('Y-m-d H:i:s', strtotime('-30 day', strtotime($now)));
        $orders     = OrderHeader::where('payment_status', 'PENDING')->whereNull('payment_code')->where('created_at', '<', $nowM30days)->get();
        foreach ($orders as $order) {
            if (!empty($order)) {
                $data   = [
                    "old_id"              => $order->id,
                    "payment_code"        => (isset($order['payment_code'])) ? $order['payment_code'] : NULL,
                    "total_order"         => $order['total_order'],
                    "user_id"             => $order->user_id,
                    "created_for_user_id" => $order->created_for_user_id,
                    "order_type"          => $order->order_type,
                    "shipping_amount"     => $order->shipping_amount,
                    "address"             => $order->address,
                    "city"                => $order->city,
                    "area"                => $order->area,
                    "building_number"     => $order->building_number,
                    "landmark"            => $order->landmark,
                    "floor_number"        => $order->floor_number,
                    "apartment_number"    => $order->apartment_number,
                    "payment_status"      => $order->payment_status,
                    "order_status"        => $order->order_status,
                    "shipping_date"       => $order->shipping_date,
                    "delivery_date"       => $order->delivery_date,
                    "wallet_status"       => $order->wallet_status,
                    "payment_paid_date"   => $order->payment_paid_date,
                    "gift_category_id"    => $order->gift_category_id
                ];
                $puckup = OrderHeadersPackup::create($data);
                if ($puckup) {
                    $order->delete();
                }
            }
        }

        // make testing
//        $result=DB::select("select DISTINCT order_headers.id from order_lines ,order_headers where order_lines.order_id = order_headers.id and order_headers.payment_status='PAID' and (order_headers.updated_at > DATE_SUB(now(), INTERVAL 100 DAY))");
//        $resultArray = array_map(function ($value) {
//            return (array)$value;
//        }, $result);
//        $order_ids = array_column($resultArray, 'id');


//        dd($order_ids);
//
//dd('sasasa');

        //      Log::info('deleteOldPendingOrder method',['test deleteOldPendingOrder 3']);
        //   dd("sdsdsd");
    }


    public function changeOrderChargeStatusJob()
    {

        $now       = Carbon::now()->toDateTimeString();
        $nowM1days = date('Y-m-d H:i:s', strtotime('-30 day', strtotime($now)));
        $orders    = OrderHeader::join('rto_s_orders', 'rto_s_orders.order_header_id', '=', 'order_headers.id')->where('order_headers.payment_status', 'PAID')->where('order_headers.order_status', '!=', 'Cancelled')->where('order_headers.order_status', '!=', 'Delivered')->where('order_headers.created_at', '>', $nowM1days)->get();
        foreach ($orders as $order) {
            if (!empty($order) && isset($order->waybillNumber)) {
                $url = 'https://webservice.logixerp.com/webservice/v2/MultipleWaybillTracking?SecureKey=' . env('R2S_secureKey') . '&WaybillNumber=' . $order->waybillNumber;
                try {
                    $httpClient = new \GuzzleHttp\Client(); // guzzle 6.3
                    $response   = $httpClient->request('GET', $url);
                    $rrespose   = json_decode($response->getBody()->getContents(), true);
                    if ($rrespose && isset($rrespose['waybillTrackDetailList']) && isset($rrespose['waybillTrackDetailList'][0])) {
                        $orderHeader               = OrderHeader::where('id', $order->order_header_id)->first();
                        $orderHeader->order_status = $rrespose['waybillTrackDetailList'][0]['currentStatus'];
                        $orderHeader->save();
                    }
                }
                catch (\Exception $exception) {
                    return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
                }
            }
        }
    }

    public function thank()
    {
        App::setLocale(Session::get('locale'));
        return view('thank');
    }


    public function signIn()
    {
        App::setLocale(Session::get('locale'));
        return view('signIn');
    }

    public function signInHandel(Request $request)
    {

        App::setLocale(Session::get('locale'));
        $v = $this->validate(request(), [
            'email' => 'required|email:rfc,dns',
            'mob1'  => 'required',
        ]);

        $userRow = User::where([
            'email' => $request->input('email'),
            'phone' => $request->input('mob1')
        ])->first();

        if (!empty($userRow)) {

            if ($userRow['stage'] == 1) {
                auth()->login($userRow);
                return redirect()->to(url('shop/' . $userRow->id));
            }
            elseif ($userRow['stage'] == 2) {
                auth()->login($userRow);
                $orderHeader = OrderHeader::where('created_for_user_id', $userRow->id)->first();
                $orderLines  = OrderLine::with('Product')->where('order_id', $orderHeader->id)->get();
//                dd($orderLines/);
                foreach ($orderLines as $carts) {
                    \Cart::add(array(
                        'id'                => $carts->id,
                        'name'              => $carts->Product->name_en,
                        'oracle_short_code' => $carts->Product->oracle_short_code,
                        'price'             => $carts->price,
                        'quantity'          => $carts->quantity,
                        'attributes'        => array(
                            'image' => $carts->Product->image,
                            'sku'   => $carts->Product->sku
                        )
                    ));
                }
                return redirect('cart');
//                return  redirect()->to(url('cart/'.$userRow->id));
                // 'https://nettinghub.com/Production/public/cart/'.$userRow->id);
            }
            else {
                return redirect()->back()->with('message', trans('auth.attributes.you_are_registered_go_app'));
            }
        }
        else {
            return redirect()->back()->with('message', trans('auth.attributes.email_or_phone_wrong'));
        }
    }

    public function testorcal()
    {
        $client   = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.github.com/repos/guzzle/guzzle');

        echo $response->getStatusCode(); // 200
        echo $response->getHeaderLine('content-type'); // 'application/json; charset=utf8'
        echo $response->getBody(); // '{"id": 1420053, "name": "guzzle", ...}'

    }

    public function thanksPay()
    {
        App::setLocale(Session::get('locale'));
        return view('thanksPay');
    }
}
