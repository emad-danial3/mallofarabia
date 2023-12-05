<?php

namespace App\Http\Controllers\Application;

use App\Events\User\GettingInfo;

use App\Http\Services\OrderService;

use App\Http\Services\UserNotificationService;
use App\Http\Services\UserService;

use App\Libraries\ApiResponse;
use App\Libraries\ApiValidator;
use App\Mail\ContactUsEmail;
use App\Models\User;
use App\Models\UserAddress;

use App\ValidationClasses\UserValidation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use JWTAuth;
use Auth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\App;
use Exception;
use App\Libraries\UploadImagesController;
use Carbon\Carbon;


class UserController extends HomeController
{
    protected $API_VALIDATOR;
    protected $API_RESPONSE;
    protected $UserValidation;
    protected $UserService;
    protected $UserNotificationService;
    protected $RegisterLinksService;
    protected $CommissionService;
    protected $AccountLevelService;
    protected $JWTAuth;
    protected $UserWalletService;
    protected $AcceptedVersionService;
    private   $MediaController;


    public function __construct(UploadImagesController  $MediaController, UserService $UserService, ApiValidator $apiValidator,
                                ApiResponse             $API_RESPONSE,
                                UserValidation          $UserValidation,
                                JWTAuth                 $JWTAuth,
                                UserNotificationService $UserNotificationService,
                                OrderService $order)
    {
        $this->API_VALIDATOR           = $apiValidator;
        $this->API_RESPONSE            = $API_RESPONSE;
        $this->UserValidation          = $UserValidation;
        $this->UserService             = $UserService;
        $this->JWTAuth                 = $JWTAuth;
        $this->UserNotificationService = $UserNotificationService;
        $this->order                   = $order;
        $this->MediaController         = $MediaController;
    }

    public function login(Request $request)
    {
        $validator = $this->API_VALIDATOR->validateWithNoToken($this->UserValidation->loginRules());
        App::setLocale($request->language);
        if ($validator) {
            $errorMessages = [];
            foreach ($validator->messages() as $key => $value) {
                $errorMessages[$key] = ['isError' => true, 'message' => $value[0]];
            }
            foreach (array_keys($this->UserValidation->loginRules()) as $input) {
                if (!in_array($input, array_keys($errorMessages))) {
                    $errorMessages[$input] = ['isError' => false, 'message' => ''];
                }
            }
            return $this->API_RESPONSE->errors($errorMessages, 400);
        }
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = $this->JWTAuth::attempt($credentials)) {
                $errorMessages = [];
                $errorMessages['password']=['isError' => true, 'message' => 'Password not valid'];
                return $this->API_RESPONSE->errors($errorMessages, 400);
            }
        }
        catch (JWTException $e) {
            return $this->API_RESPONSE->errors([trans('validation.encode_fail')], 400);
        }

        $id = Auth::User()->id;
        User::where('id', $id)->update([
            'version'   => $request->input('version'),
            'platform'  => $request->input('platform'),
            'device_id' => $request->input('device_id'),
        ]);
        $loginData['user']            = [
            "id"                     => Auth::User()->id,
            "nationality"            => Auth::User()->nationality,
            "full_name"              => Auth::User()->full_name,
            "email"                  => Auth::User()->email,
            "user_type"              => Auth::User()->user_type,
            "gender"                 => Auth::User()->gender,
            "country_id"             => Auth::User()->country_id,
            "city_id"                => Auth::User()->city_id,
            "area_id"                => Auth::User()->area_id,
            "phone"                  => Auth::User()->phone,
            "phone2"                 => Auth::User()->phone2,
            "telephone"              => Auth::User()->telephone,
            "birthday"               => Auth::User()->birthday,
            "profile_photo"          => Auth::User()->profile_photo,
            "front_id_image"         => Auth::User()->front_id_image,
            "back_id_image"          => Auth::User()->back_id_image,
            "is_active"              => Auth::User()->is_active,
            "device_id"              => Auth::User()->device_id,
            "nickname"               => Auth::User()->nickname,
            "marital_status"         => Auth::User()->marital_status,
            "stage"                  => Auth::User()->stage,
            "sales_leaders_level_id" => Auth::User()->sales_leaders_level_id,

        ];
        $loginData['token']           = $token;
        $loginData['account_deleted'] = false;

        $loginData['services'] = [
            "min_required"              => $this->calculateMinRequired(Auth::User()),
            "notification_unread_count" => (Auth::User()->notificationUnReadCount) ? Auth::User()->notificationUnReadCount->where('is_read', 0)->count() : 0,
        ];
        $mmship                = UserMembership::where('user_id', Auth::User()->id)->first();
        if ($mmship) {
            $loginData['membership'] = $mmship->id;
        }
        else {
            $loginData['membership'] = null;
        }
        $loginData['commission'] = $this->CommissionService->getTotalCommissionAndRedeem(Auth::User()->id, []);

        return $this->API_RESPONSE->data($loginData, trans('auth.login_success'), 200);
    }

    public function userInfo(Request $request)
    {

        $userInfo['membership'] = UserMembership::where('user_id', $request->user_id)->select('id')->first();
        $userInfo['commission'] = $this->CommissionService->getTotalCommissionAndRedeem($request->user_id, []);
        $user                   = $this->UserService->getUser($request->user_id);
        $userInfo['services']   = [
            "min_required"              => $this->calculateMinRequired($user),
            "notification_unread_count" => ($user->notificationUnReadCount) ? $user->notificationUnReadCount->where('is_read', 0)->count() : 0,
        ];
        $userInfo["info"]       = User::select('user_type', 'stage', 'profile_photo')->where('id', $request->user_id)->first();
        return $this->API_RESPONSE->data($userInfo, trans('auth.login_success'), 200);

    }

    public function getUserFavourites(Request $request)
    {
        $myFavourites = $this->UserService->getUserFavourites(['user_id', $request->user_id]);
        return $this->API_RESPONSE->data($myFavourites, "all my favourite products", 200);
    }

    public function addProductToFavourites(Request $request)
    {
        $product    = [
            'user_id'    => $request->user_id,
            'product_id' => $request->product_id,
        ];
        $newProduct = $this->UserService->addProductToFavourites($product, $request->add);
        return $this->API_RESPONSE->data(['product' => $newProduct], $request->add =='false'? 'Deleted Product from Favourites': 'add product to favourites', 200);
    }


    public function addUserAddress(Request $request)
    {

        $validator = $this->API_VALIDATOR->validateWithNoToken($this->UserValidation->addressRules());
        App::setLocale($request->language);
        if ($validator) {
            $errorMessages = [];
            foreach ($validator->messages() as $key => $value) {
                $errorMessages[$key] = ['isError' => true, 'message' => $value[0]];
            }
            foreach (array_keys($this->UserValidation->addressRules()) as $input) {
                if (!in_array($input, array_keys($errorMessages))) {
                    $errorMessages[$input] = ['isError' => false, 'message' => ''];
                }
            }
            return $this->API_RESPONSE->errors($errorMessages, 400);
        }
        $address = [
            'user_id'          => $request->user_id,
            'address'          => $request->address,
            'landmark'         => $request->landmark,
            'receiver_name'    => $request->receiver_name,
            'receiver_phone'   => $request->receiver_phone,
            'floor_number'     => $request->floor_number,
            'apartment_number' => $request->apartment_number,
            'city_id'          => $request->city_id,
            'country_id'       => $request->country_id,
            'area_id'          => $request->area_id,
            'prime'            => 1,
        ];
        $address = $this->UserService->addUserAddress($address, $request->add);
        return $this->API_RESPONSE->data(['address' => $address], trans('auth.addAddress'), 200);
    }



  public function makeAddressPrime(Request $request)
    {
       $data1 = [
            'prime'            => '0',
        ];
        UserAddress::where(['user_id'=>$request->user_id])->update($data1);
        $data = [
            'prime'            => '1',
        ];
      $address=   UserAddress::where(['id'=>$request->address_id])->update($data);
        return $this->API_RESPONSE->data(['address' => $address], trans('auth.addAddress'), 200);
    }





    public function getMyAddresses(Request $request)
    {
            $conditions = ['user_addresses.user_id', '=', $request->user_id];
            $addresses  = $this->UserService->getUserAddress($conditions);
        return $this->API_RESPONSE->data(['addresses' => $addresses], 'My Addresses', 200);
    }


    private function calculateMinRequired($user)
    {
        return 50;
    }

    public function refreshToken(Request $request)
    {

        try {
            $token = JWTAuth::getToken();
            JWTAuth::decode($token);
            $tokkennew['token'] = JWTAuth::parseToken()->refresh();
            return $this->API_RESPONSE->data($tokkennew, trans('auth.token_created'), 201);
        }
        catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this->API_RESPONSE->errors([trans('auth.token_invalid')], 401);
            }
            else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                $tokkennew['token'] = JWTAuth::parseToken()->refresh();
                return $this->API_RESPONSE->data($tokkennew, trans('auth.token_created'), 201);
            }
            else {
                return $this->API_RESPONSE->errors([trans('auth.token_not_found')], 401);
            }
        }
    }

    public function forgotPassword(Request $request)
    {

        $validator = $this->API_VALIDATOR->validateWithNoToken($this->UserValidation->restPasswordRules());
        App::setLocale($request->language);
        if ($validator) {
            $errorMessages = [];
            foreach ($validator->messages() as $key => $value) {
                $errorMessages[$key] = ['isError' => true, 'message' => $value[0]];
            }
            foreach (array_keys($this->UserValidation->restPasswordRules()) as $input) {
                if (!in_array($input, array_keys($errorMessages))) {
                    $errorMessages[$input] = ['isError' => false, 'message' => ''];
                }
            }
            return $this->API_RESPONSE->errors($errorMessages, 400);
        }
        $response = $this->UserService->resetPassword($request->input('emailorphone'));
        if ($response) {
            $response['email'] = $this->getHashEmail($response['email']);
            return $this->API_RESPONSE->data($response, trans('auth.check_email'), 200);
        }

        return $this->API_RESPONSE->errors([trans('auth.email_not_found')], 400);
    }

    public function getHashEmail($email)
    {
        $array        = explode('@', $email);
        $emaillenth   = strlen($array[0]);
        $numlastchars = ($emaillenth - 4);
        $first4char   = substr($email, 0, 4);
        for ($i = 0; $i < $numlastchars; $i++) {
            $first4char = $first4char . "*";
        }
        $lastEmail = $first4char . '@' . $array[1];
        return $lastEmail;
    }

    public function SetNewPassword(Request $request)
    {
        $validator = $this->API_VALIDATOR->validateWithNoToken($this->UserValidation->setNewPasswordRules());
        App::setLocale($request->language);
        if ($validator) {
            $errorMessages = [];
            foreach ($validator->messages() as $key => $value) {
                $errorMessages[$key] = ['isError' => true, 'message' => $value[0]];
            }
            foreach (array_keys($this->UserValidation->setNewPasswordRules()) as $input) {
                if (!in_array($input, array_keys($errorMessages))) {
                    $errorMessages[$input] = ['isError' => false, 'message' => ''];
                }
            }
            return $this->API_RESPONSE->errors($errorMessages, 400);
        }
        $response = $this->UserService->setNewPasswor($request->input('emailorphone'), $request->input('new_password'));
        if ($response)
            return $this->API_RESPONSE->success(trans('auth.set_successful'), 201);

        return $this->API_RESPONSE->errors([trans('auth.wrong_password')], 400);
    }

    public function CheckValidationCode(Request $request)
    {
        $validator = $this->API_VALIDATOR->validateWithNoToken($this->UserValidation->checkCodeRules());
        App::setLocale($request->language);
        if ($validator) {
            $errorMessages = [];
            foreach ($validator->messages() as $key => $value) {
                $errorMessages[$key] = ['isError' => true, 'message' => $value[0]];
            }
            foreach (array_keys($this->UserValidation->checkCodeRules()) as $input) {
                if (!in_array($input, array_keys($errorMessages))) {
                    $errorMessages[$input] = ['isError' => false, 'message' => ''];
                }
            }
            return $this->API_RESPONSE->errors($errorMessages, 400);
        }

        $response = $this->UserService->checkValidateCode($request->input('emailorphone'), $request->input('code'));
        if ($response)
            return $this->API_RESPONSE->success(trans('auth.valid_code'), 201);

        return $this->API_RESPONSE->errors([trans('auth.wrong_validate_code')], 400);
    }

    public function updateProfile(Request $request)
    {
        $user_id  = $request->user_id;
        $userData = $request->only('full_name', 'profile_photo', 'nickname', 'marital_status');
        if (isset($userData['full_name']) && $userData['full_name'] != '') {
            $userData['full_name'] = trim($userData['full_name']);
            $userData['full_name'] = preg_replace('/\s{2}/s', ' ', $userData['full_name']);
        }
        $response = $this->UserService->updateUserProfile($userData, $user_id);
        if ($response)
            return $this->API_RESPONSE->success(trans('auth.sucessfully'), 201);
        return $this->API_RESPONSE->errors([trans('auth.error_inserted')], 400);
    }

    public function getMyShareLinks(Request $request)
    {
        $validator = $this->API_VALIDATOR->validateWithNoToken($this->UserValidation->GetLinkRules());
        if ($validator) {
            $errorMessages = [];
            foreach ($validator->messages() as $key => $value) {
                $errorMessages[$key] = ['isError' => true, 'message' => $value[0]];
            }
            foreach (array_keys($this->UserValidation->GetLinkRules()) as $input) {
                if (!in_array($input, array_keys($errorMessages))) {
                    $errorMessages[$input] = ['isError' => false, 'message' => ''];
                }
            }
            return $this->API_RESPONSE->errors($errorMessages, 400);
        }

        $user_id = $request->user_id;
        $links   = [];

        //refactor
        if ($this->UserService->isFreeUser($user_id) && $request->input('is_free_link'))
            return $this->API_RESPONSE->errors(['Sorry ,You can not create a link .'], 400);
        if ($request->input('is_free_link')) {
            $links = $this->RegisterLinksService->getOrCreateMyLink($user_id, 1);
        }
        else {
            $links = $this->RegisterLinksService->getOrCreateMyLink($user_id, 0);
        }
        return $this->API_RESPONSE->data(['my_links' => $links], 'My Links', 200);
    }

    public function getMyNotification(Request $request)
    {
        $user_id          = $request->user_id;
        $offset           = (!empty($request->input('offset'))) ? $request->input('offset') : 0;
        $has_notification = $this->UserNotificationService->hasNotification($user_id);
        $myNotification   = $this->UserNotificationService->readNotification($user_id, $offset);
        $this->UserNotificationService->updateUser($user_id);
        return $this->API_RESPONSE->data(['my_notification' => $myNotification, 'has_notification' => $has_notification, 'NextOffset' => $this->UserNotificationService->getNextOffset()], 'My Notification', 200);
    }

    public function myNetwork(Request $request)
    {
        $validator = $this->API_VALIDATOR->validateWithNoToken($this->UserValidation->UserId());
        if ($validator) {
            $errorMessages = [];
            foreach ($validator->messages() as $key => $value) {
                $errorMessages[$key] = ['isError' => true, 'message' => $value[0]];
            }
            foreach (array_keys($this->UserValidation->UserId()) as $input) {
                if (!in_array($input, array_keys($errorMessages))) {
                    $errorMessages[$input] = ['isError' => false, 'message' => ''];
                }
            }
            return $this->API_RESPONSE->errors($errorMessages, 400);
        }
        $my_network = $this->UserService->getMyNetwork($request->input('user_id'));
        return $this->API_RESPONSE->data(['my_network' => $my_network], 'My Network', 200);
    }

    public function myCommission(Request $request)
    {
        $validator = $this->API_VALIDATOR->validateWithNoToken($this->UserValidation->myCommissionPeriod());
        if ($validator) {
            $errorMessages = [];
            foreach ($validator->messages() as $key => $value) {
                $errorMessages[$key] = ['isError' => true, 'message' => $value[0]];
            }
            foreach (array_keys($this->UserValidation->myCommissionPeriod()) as $input) {
                if (!in_array($input, array_keys($errorMessages))) {
                    $errorMessages[$input] = ['isError' => false, 'message' => ''];
                }
            }
            return $this->API_RESPONSE->errors($errorMessages, 400);
        }
        $user_id          = $request->user_id;
        $my_commission    = $this->CommissionService->myCommission($user_id, $request->only('start_date', 'end_date'));
        $total_Commission = $this->CommissionService->getTotalCommissionAndRedeem($user_id);
        return $this->API_RESPONSE->data(['my_network' => $my_commission, 'total' => $total_Commission], 'My Network', 200);
    }

    public function RegisterAsCustomer(Request $request)
    {
        $validator = $this->API_VALIDATOR->validateWithNoToken($this->UserValidation->registerCustomerRules());
        if ($validator) {
            $errorMessages = [];
            foreach ($validator->messages() as $key => $value) {
                $errorMessages[$key] = ['isError' => true, 'message' => $value[0]];
            }
            foreach (array_keys($this->UserValidation->registerCustomerRules()) as $input) {
                if (!in_array($input, array_keys($errorMessages))) {
                    $errorMessages[$input] = ['isError' => false, 'message' => ''];
                }
            }
            return $this->API_RESPONSE->errors($errorMessages, 400);
        }
        $userData              = $request->all();
        $userData['parent_id'] = (isset($request->user_id)) ? $request->user_id : 1;
        $userData['stage']     =  1;
        $userData['user_type'] = 'normal_user';
        $userData['full_name'] = $this->getFullName($request->get('first_name'), $request->get('last_name'), $request->get('middle_name'));
        $userData['platform']  = 'mobile';
        $userData['device_id']  = $request->get('device_id')??null;
        $userData['version']  = $request->get('version')??null;
        $userRow               = $this->UserService->createUser($userData);

        $credentials = $request->only('email', 'password');
        $token       = $this->JWTAuth::attempt($credentials);
        $this->UserService->sendRegistrationEmail($userRow);
//        $this->UserService->sendRegistrationMessage($userRow);
        if(isset($userRow['id'])&&$userRow['id'] >0){
            try {
                $client = new \GuzzleHttp\Client();
                $data=[
                    'account_id'      => $userRow->account_id,
                    'full_name'       =>  $userRow->full_name,
                    'mobile'          =>  $userRow->phone,
                    'nationality_id'  =>  $userRow->nationality_id,
                    'address'         =>  $this->faTOen($userRow->address)??"9 El sharekat, Opera",
                ];
                $this->response=  $client->request('POST','https://sales.atr-eg.com/api/save_user_nettinghub_4u.php',['form_params'=>$data ,'verify' => false])->getBody()->getContents();
//                Log::info($this->response);
            }catch (\Exception $e){
                $this->catch=$e->getMessage();
//                Log::error('sending USER to oracle Register USER_ID :: '.$userRow['id'].' ERROR::'.$e->getMessage());
            }
        }
        return $this->API_RESPONSE->data(['user' => $userRow, 'token' => $token], 'Register Account', 200);
    }

    public function RegisterAsMember(Request $request)
    {
        $validator = $this->API_VALIDATOR->validateWithNoToken($this->UserValidation->registerRules());
        if ($validator) {
            $errorMessages = [];
            foreach ($validator->messages() as $key => $value) {
                $errorMessages[$key] = ['isError' => true, 'message' => $value[0]];
            }
            foreach (array_keys($this->UserValidation->registerRules()) as $input) {
                if (!in_array($input, array_keys($errorMessages))) {
                    $errorMessages[$input] = ['isError' => false, 'message' => ''];
                }
            }
//            foreach ($validator->keys() as $error) {
//                $errorMessages[] = trans('validation.' . $error);
//            }
            return $this->API_RESPONSE->errors($errorMessages, 400);
        }

        $data               = $request->all();
        $data['stage']      = 2;
        $data['address']    = $request->input('address');
        $data['user_type']  = 'member';
        $data['account_id'] = rand(1000000000, 9999999999);
        $data['full_name']  = $this->getFullName($request->get('first_name'), $request->get('last_name'), $request->get('middle_name'));
        if (isset($data['front_id_image'])) {
            $data['front_id_image'] = $this->MediaController->UploadImage($data['front_id_image'], 'images/users');
        }
        if (isset($data['back_id_image'])) {
            $data['back_id_image'] = $this->MediaController->UploadImage($data['back_id_image'], 'images/users');
        }
        $data['platform'] = 'mobile';
        $userData['device_id']  = $request->get('device_id')??null;
        $userData['version']  = $request->get('version')??null;
        $userRow          = $this->UserService->createUser($data);
        $membership       = null;
        if ($userRow) {
            $membership = $this->addUserMembership($userRow->id, isset($data['parent_membership_id']) && $data['parent_membership_id'] > 0 ?$data['parent_membership_id']:0);
        }
        $this->UserService->sendRegistrationEmail($userRow);
        $credentials = $request->only('email', 'password');
        $token       = $this->JWTAuth::attempt($credentials);
        if(isset($userRow['id'])&&$userRow['id'] >0){
            try {
                $client = new \GuzzleHttp\Client();
                $data=[
                    'account_id'      => $userRow->account_id,
                    'full_name'       =>  $userRow->full_name,
                    'mobile'          =>  $userRow->phone,
                    'nationality_id'  =>  $userRow->nationality_id,
                    'address'         =>  $this->faTOen($userRow->address)??"9 El sharekat, Opera",
                ];
                $this->response=  $client->request('POST','https://sales.atr-eg.com/api/save_user_nettinghub_4u.php',['form_params'=>$data ,'verify' => false])->getBody()->getContents();
//                Log::info($this->response);
            }catch (\Exception $e){
                $this->catch=$e->getMessage();
//                Log::error('sending USER to oracle Register USER_ID :: '.$userRow['id'].' ERROR::'.$e->getMessage());
            }
        }
        return $this->API_RESPONSE->data(['user' => $userRow, 'token' => $token, 'membership' => $membership], 'Register Account', 200);
    }

    public function upgradeCustomerToMember(Request $request)
    {
        $validator = $this->API_VALIDATOR->validateWithNoToken($this->UserValidation->upgradeCustomerToMemberRules());
        if ($validator) {
            $errorMessages = [];
            foreach ($validator->messages() as $key => $value) {
                $errorMessages[$key] = ['isError' => true, 'message' => $value[0]];
            }
            foreach (array_keys($this->UserValidation->upgradeCustomerToMemberRules()) as $input) {
                if (!in_array($input, array_keys($errorMessages))) {
                    $errorMessages[$input] = ['isError' => false, 'message' => ''];
                }
            }
            return $this->API_RESPONSE->errors($errorMessages, 400);
        }

        $data              = $request->only(['nationality_id', 'country_id', 'city_id', 'area_id',  'front_id_image', 'back_id_image']);
        $data['stage']      = 2;
        $data['user_type']  = 'member';
        $data['platform'] = 'mobile';
        $this->UserService->updateUserRow($data,$request->user_id);
        $userRow = $this->UserService->getUser($request->user_id);
        $membership       = null;
        if ($userRow) {
            $membership = $this->addUserMembership($userRow->id, isset($data['parent_membership_id']) && $data['parent_membership_id'] > 0 ?$data['parent_membership_id']:0);
        }



        return $this->API_RESPONSE->data(['user' => $userRow, 'membership' => $membership], 'upgrade Account Successfully', 200);
    }

    public function sendContactUsMessageToEmail(Request $request)
    {
        $validator = $this->API_VALIDATOR->validateWithNoToken($this->UserValidation->sendContactUsRules());
        if ($validator) {
            $errorMessages = [];
            foreach ($validator->messages() as $key => $value) {
                $errorMessages[$key] = ['isError' => true, 'message' => $value[0]];
            }
            foreach (array_keys($this->UserValidation->sendContactUsRules()) as $input) {
                if (!in_array($input, array_keys($errorMessages))) {
                    $errorMessages[$input] = ['isError' => false, 'message' => ''];
                }
            }
            return $this->API_RESPONSE->errors($errorMessages, 400);
        }
         $currentuser      = $this->UserService->getUser($request->user_id);
        $data = [
            'email'      => $currentuser->email,
            'first_name' => $currentuser->email,
            'last_name'  => "",
            'phone'      => $request->input('phone'),
            'subject'    => $request->input('subject'),
            'message'    => $request->input('message'),
        ];

        Mail::to(env('MAIL_FROM_ADDRESS'))->send(new ContactUsEmail($data));
        if (count(Mail::failures()) > 0) {
            $errorMessages = [];
             $errorMessages['email'] = ['isError' => true, 'message' => 'error in email server'];
            return $this->API_RESPONSE->errors($errorMessages, 400);
        }

        $response = [
            'status'  => 200,
            'message' => "Subscriber Add Success",

        ];

        return $this->API_RESPONSE->data($response, 'Mail Send Successful', 200);
    }


    public function addUserMembership($user_id, $parent_membership_id = 0)
    {
        $membership = UserMembership::create(['user_id' => $user_id]);
        if (isset($parent_membership_id) && $parent_membership_id > 0) {
            $parentID    = UserMembership::find($parent_membership_id)['user_id'];
            $grandParent = AccountLevel::where(['child_id' => $parentID, 'level' => '1'])->first();
            if (!empty($grandParent)) {
                $levels = [
                    ['parent_id' => $parentID, 'child_id' => $user_id, 'level' => '1', 'created_at' => now(), 'updated_at' => now()],
                    ['parent_id' => $grandParent->parent_id, 'child_id' => $user_id, 'level' => '2', 'created_at' => now(), 'updated_at' => now()],
                ];
            }
            else {
                $levels = [
                    ['parent_id' => $parentID, 'child_id' => $user_id, 'level' => '1', 'created_at' => now(), 'updated_at' => now()],
                ];
            }
            AccountLevel::insert($levels);
        }
        return $membership->id;
    }


    public function accountTracking(Request $request)
    {
        $user_id = $request->user_id;
        $logs    = $this->AccountLevelService->getAccountTracking($user_id);
        return $this->API_RESPONSE->data(['logs' => $logs], 'Account Tracking', 200);
    }

    public function getMyWallet(Request $request)
    {
        $user_id  = $request->user_id;
        $myWallet = $this->UserWalletService->getMyWallet($user_id);
        return $this->API_RESPONSE->data($myWallet, 'Account Wallet', 200);
    }

    public function checkMyVersion(Request $request)
    {
        $validator = $this->API_VALIDATOR->validateWithNoToken($this->UserValidation->checkVersion());
        if ($validator) {
            $errorMessages = [];
            foreach ($validator->messages() as $key => $value) {
                $errorMessages[$key] = ['isError' => true, 'message' => $value[0]];
            }
            foreach (array_keys($this->UserValidation->checkVersion()) as $input) {
                if (!in_array($input, array_keys($errorMessages))) {
                    $errorMessages[$input] = ['isError' => false, 'message' => ''];
                }
            }
            return $this->API_RESPONSE->errors($errorMessages, 400);
        }
        $data        = [
            "version"  => $request->input('version'),
            "platform" => $request->input('platform'),
        ];
        $is_accepted = $this->AcceptedVersionService->checkVersion($data['platform'], $data['version']);
        return $this->API_RESPONSE->data(["is_accepted" => $is_accepted], 'Version', 200);
    }

    public function changePassword(Request $request)
    {
        $validator = $this->API_VALIDATOR->validateWithNoToken($this->UserValidation->changePassword());
        if ($validator) {
            $errorMessages = [];
            foreach ($validator->messages() as $key => $value) {
                $errorMessages[$key] = ['isError' => true, 'message' => $value[0]];
            }
            foreach (array_keys($this->UserValidation->changePassword()) as $input) {
                if (!in_array($input, array_keys($errorMessages))) {
                    $errorMessages[$input] = ['isError' => false, 'message' => ''];
                }
            }
            return $this->API_RESPONSE->errors($errorMessages, 400);
        }
        $user = User::find($request->user_id);
        if (Hash::check($request->old_password, $user->password)) {
            $password = bcrypt(request()->password);
            $user->update(['password' => $password]);
            return $this->API_RESPONSE->success(trans('auth.change_successfully'), 201);
        }
        else {
            return $this->API_RESPONSE->errors(trans('auth.wrong_password'), 400);
        }
    }

    public function logOut(Request $request)
    {
        $response = $this->UserService->updateUserProfile(['device_id' => ''], $request->user_id);
        if ($response)
            return $this->API_RESPONSE->success(trans('auth.sucessfully'), 201);
        return $this->API_RESPONSE->errors([trans('auth.error_inserted')], 400);

    }


    public function getFullName($fname, $lname, $mname)
    {
        $check_names = [
            $fname,
            $lname,
            $mname,
        ];
        foreach ($check_names as $value) {
            if (preg_match('/[اأإء-ي]/ui', $value)) {
                return back()->with('error', 'Please Insert Your Name in  English Format, <br> برجاء ادخال اسمك باللغة الانجليزية فقط');
            }
        }
        $full_name = trim($fname) . " " . trim($mname) . " " . trim($lname);
        $full_name = preg_replace('/\s{2}/s', ' ', $full_name);
        $full_name = ucfirst($full_name);
        return $full_name;
    }


    public function upgradeAccount(Request $request)
    {

        $validator2 = $this->API_VALIDATOR->validateWithNoToken([
            'account_type' => 'required|exists:account_types,id',
        ]);

        if ($validator2) {
            $errorMessages = [];
            foreach ($validator2->keys() as $error) {
                $errorMessages[] = trans('validation.' . $error);
            }
            return $this->API_RESPONSE->errors($errorMessages, 400);
        }

        if ($this->UserService->upgradeUser($request->user_id, $request->get('account_type')))
            return $this->API_RESPONSE->success(trans('auth.sucessfully'), 201);

        return $this->API_RESPONSE->errors(["not from here"], 400);

    }
public function faTOen($string)
    {
        return strtr($string, array('۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'));
    }

}
