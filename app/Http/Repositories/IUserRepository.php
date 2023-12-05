<?php

namespace App\Http\Repositories;

use App\Models\User;
use App\Models\UserAddress;
use App\Models\OrderHeader;
use App\Models\AccountLevel;
use App\Models\AccountType;
use App\Models\UserFavourites;
use App\Models\SalesLeaderLevels;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class IUserRepository extends BaseRepository implements UserRepository
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function isFreeUser($id)
    {
        $user=User::select('freeaccount')->find($id);
        return $user->freeaccount;
    }

    public function getUserAdress($id)
    {
        return User::select("address","city","area","building_number","floor_number","apartment_number","landmark")->find($id);
    }

    public function updateUser($id ,$data)
    {
        return User::where(['id'=>$id])->update($data);
    }
    public function UserAddressUpdate($id ,$data)
    {
        return UserAddress::where(['id'=>$id])->update($data);
    }

    public function findUserByEmail($email)
    {
        return User::select('id','stage')->where('email',$email)->first();
    }
 public function findUserByEmailOrPhone($emailorphone)
    {
        return User::select('id','stage','email')->where('email',$emailorphone)->orWhere('phone',$emailorphone)->first();
    }

    public function getAccountParent($id)
    {
        return	DB::select(  'SELECT
                                    account_levels.level,
                                    account_commissions.commission,
                                    account_levels.parent_id,
                                    users.full_name,
                                    users.email,
                                    users.device_id,
                                    users.phone,
                                           users.id

                                    FROM
                                    account_levels,
                                    users,
                                    account_commissions
                                    where
                                    account_levels.child_id            =  '.$id.'
                                    and account_levels.parent_id       =  users.id
                                    and account_commissions.level      =  account_levels.level
                                    and account_commissions.account_id =  users.account_type
                                    and account_levels.level           <= 3');

    }

    public function getAccountTypeAndName($user_id)
    {
       return User::select('users.full_name as child_full_name' , 'account_types.name_en AS child_type','users.id AS child_id','users.email','users.phone')
                    ->join('account_types','account_types.id','users.account_type')
                    ->where('users.id',$user_id)->first();
    }

    public function getMyNetwork($user_id)
    {
        return DB::table('users')->select('users.id','users.phone as mobile','account_types.name_en as account_type',
            'users.email','users.stage','users.full_name','users.freeaccount',
            DB::raw('(CASE WHEN (order_headers.created_for_user_id > 1) THEN 0 ELSE 1 END) AS is_new_user'))
                    ->join('account_levels','account_levels.child_id','users.id')
                    ->join('account_types','account_types.id','users.account_type')
                    ->leftJoin('order_headers','order_headers.created_for_user_id','users.id')
                    ->where('account_levels.level',1)
                    ->where('account_levels.parent_id',$user_id)
                    ->distinct()
                    ->get();
    }
    public function getMyTeamGeneration($user_id,$generation=1,$new=false)
    {
         $startMonth  = Carbon::now()->startOfMonth()->toDateTimeString();
         $endMonth    = Carbon::now()->endOfMonth()->toDateTimeString();

         if($new)
             return AccountLevel::where('parent_id',$user_id)->where('level',$generation)->whereBetween('created_at', [$startMonth, $endMonth])->distinct()->get()->pluck('child_id')->toArray();

        return AccountLevel::where('parent_id',$user_id)->where('level',$generation)->distinct()->get()->pluck('child_id')->toArray();
    }

    public function getMyParents($user_id)
    {
        return AccountLevel::where('child_id',$user_id)->whereIn('level',['1','2'])->distinct()->get()->pluck('parent_id')->toArray();
    }
    public function checkINewOrNot($user_id)
    {
         $startMonth  = Carbon::now()->startOfMonth()->toDateTimeString();
         $endMonth    = Carbon::now()->endOfMonth()->toDateTimeString();

        return User::where('id',$user_id)->whereBetween('created_at', [$startMonth, $endMonth])->distinct()->get()->pluck('child_id')->toArray();
    }
    public function getMySalesLeaderLevel($myTeamMembersActivesCount,$myNewMembersActivesCount,$myTeamTotalSales)
    {
        return SalesLeaderLevels::where('total_team_sales','<=',$myTeamTotalSales)->where('total_actives_team','<=',$myTeamMembersActivesCount)->where('g1_new_recruits','<=',$myNewMembersActivesCount)->orderBy('id','DESC')->first();
    }
    public function getMyNextSalesLeaderLevel($level_id)
    {
        return SalesLeaderLevels::where('id','>',$level_id)->first();
    }
    public function getMyNextCashbackLevel($level_id)
    {
        return AccountType::where('id',5)->first();
    }

    public function getMyAddresses($conditions)
    {
        return DB::table('user_addresses')->select('user_addresses.id','user_addresses.country_id','user_addresses.city_id','user_addresses.area_id','user_addresses.receiver_name','user_addresses.receiver_phone','user_addresses.user_id','countries.name_en as country_name','cities.name_en as city_name','areas.region_en as area_name','user_addresses.floor_number','user_addresses.apartment_number','user_addresses.address','user_addresses.landmark','user_addresses.prime')
                    ->join('countries','countries.id','user_addresses.country_id')
                    ->join('cities','cities.id','user_addresses.city_id')
                    ->join('areas','areas.id','user_addresses.area_id')
                    ->where([$conditions])
                    ->get();
    }
    public function getUserFavourites($conditions)
    {
        return DB::table('user_favourites')->select('user_favourites.id','user_favourites.product_id','products.name_ar','products.name_en','products.price','products.discount_rate','products.price_after_discount','products.image','products.flag','products.excluder_flag', 'products.old_price', 'products.old_discount')
                    ->join('products','user_favourites.product_id','products.id')
                    ->where([$conditions])
                    ->get();
    }

      public function addProductToFavourites($product,$add=false)
    {

        if($add=='false'){
            return UserFavourites::where('user_id',$product['user_id'])->where('product_id',$product['product_id'])->delete();
        }
        $checkExist=UserFavourites::where('user_id',$product['user_id'])->where('product_id',$product['product_id'])->first();
        if(empty($checkExist)){
             UserFavourites::create($product);
        }

        return DB::table('products')->select('name_ar','name_en','price','discount_rate','price_after_discount','image','flag','excluder_flag', 'old_price', 'old_discount')
                    ->where('id',$product['product_id'])
                    ->first();

    }
    public function addUserAddress($address,$add=false)
    {
        $data1 = [
            'prime'            => '0',
        ];
        UserAddress::where(['user_id'=>$address['user_id']])->update($data1);
        return  UserAddress::create($address);
    }
    public function getMyMainAddresse($conditions)
    {
        return DB::table('user_addresses')->select('user_addresses.id','user_addresses.country_id','user_addresses.city_id','user_addresses.area_id','user_addresses.receiver_name','user_addresses.receiver_phone','user_addresses.user_id','countries.name_en as country_name','cities.name_en as city_name','areas.region_en as area_name','user_addresses.floor_number','user_addresses.apartment_number','user_addresses.address','user_addresses.landmark','user_addresses.prime')
                    ->join('countries','countries.id','user_addresses.country_id')
                    ->join('cities','cities.id','user_addresses.city_id')
                    ->join('areas','areas.id','user_addresses.area_id')
                    ->where([$conditions])->where('user_addresses.prime','1')
                    ->first();
    }
    public function getMyCashbackLevel($mytotalPaidOrderThisQuarter)
    {
         return AccountType::where('quarter_sales_amount','<',$mytotalPaidOrderThisQuarter)->where('quarter_sales_amount_to','>',$mytotalPaidOrderThisQuarter)->orderBy('id','DESC')->first();
    }
    public function getUserTotalOrders($conditions)
    {
        return  OrderHeader::where($conditions)->sum('total_order');
    }

    public function deleteUserAddress($conditions)
    {
        return DB::table('user_addresses')->where([$conditions])->delete();
    }



    public function getAllUsers($inputData)
    {

        $user = User::orderBy('id','desc');
            if (isset($inputData['name']))
            {
                $user->where('full_name','like','%'.$inputData['name'].'%')->orWhere('phone','like','%'.$inputData['name'].'%');
            }
            if (isset($inputData['has_credit_cart']))
            {
                $user->where('has_credit_cart',$inputData['has_credit_cart']);
            }
           return  $user->paginate($this->defaultLimit);


    }
}
