<?php

namespace App\Http\Controllers\Application;

use App\Events\User\GettingInfo;
use App\Exports\MemberActiveExport;

use App\Http\Services\OrderService;
use App\Http\Services\UserNotificationService;
use App\Http\Services\UserService;
use App\Libraries\ApiResponse;
use App\Libraries\ApiValidator;
use App\Models\User;

use App\ValidationClasses\UserValidation;
use JWTAuth;
use Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Libraries\UploadImagesController;
use Carbon\Carbon;


class UserDashboardController extends HomeController
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


    public function getMyDashboardInfo(Request $request)
    {
        $currentuser        = $this->UserService->getUser($request->user_id);
        $mySalesLeaderLevel = $this->getMySalesLeaderLevel($currentuser->id, $currentuser->sales_leaders_level_id);
        $data               = [
            "myTeamTotalSales"          => $mySalesLeaderLevel['myTeamTotalSales'],
            "totalSalesG1"              => $mySalesLeaderLevel['totalSalesG1'],
            "totalSalesG2"              => $mySalesLeaderLevel['totalSalesG2'],
            "myTeamMembersActivesCount" => $mySalesLeaderLevel['myTeamMembersActivesCount'],
            "myNewMembersActivesCount"  => $mySalesLeaderLevel['myNewMembersActivesCount'],
            "myNewMembersSales"         => $mySalesLeaderLevel['myNewMembersSales'],
        ];
        return $this->API_RESPONSE->data($data, 'My Dashboard Info', 200);
    }


    public function getMyCommission(Request $request)
    {
        $currentuser               = $this->UserService->getUser($request->user_id);
        $mytotalPaidOrderThisManth = $this->UserService->getMyTeamTotalSales([$currentuser->id], 'month');
        $mySalesLeaderLevel        = $this->getMySalesLeaderLevel($currentuser->id, $currentuser->sales_leaders_level_id);
//        $data                      = [
//            "type" => "Earning",
//            "mytotalPaidOrderThisManth" => $mytotalPaidOrderThisManth,
//            "myTeamMembersActivesCount" => $mySalesLeaderLevel['myTeamMembersActivesCount'],
//            "myNewMembersActivesCount"  => $mySalesLeaderLevel['myNewMembersActivesCount'],
//            "myNewMembersSales"         => $mySalesLeaderLevel['myNewMembersSales'],
//            "totalSalesG1"              => $mySalesLeaderLevel['totalSalesG1'],
//            "totalSalesG2"              => $mySalesLeaderLevel['totalSalesG2'],
//            "myTeamTotalSales"          => $mySalesLeaderLevel['myTeamTotalSales'],
//            "upLevel"                   => isset($mySalesLeaderLevel['myMonthlyEarnings']) && isset($mySalesLeaderLevel['myMonthlyEarnings']['upLevel']) && $mySalesLeaderLevel['myMonthlyEarnings']['upLevel'] > 0 ? 'Yes' : 'No',
//            "myMonthlyEarnings"         => $mySalesLeaderLevel['myMonthlyEarnings'],
//        ];
        $saleing = [
            "type"                 => "Selling",
            "personal_order"       => number_format((float)$mytotalPaidOrderThisManth, 2, '.', ''),
            "active_team"          => $mySalesLeaderLevel['myTeamMembersActivesCount'],
            "g1_new"               => $mySalesLeaderLevel['myNewMembersActivesCount'],
            "g1_new_sales"         => number_format((float)$mySalesLeaderLevel['myNewMembersSales'], 2, '.', ''),
            "total_g1_sales"       => number_format((float)$mySalesLeaderLevel['totalSalesG1'], 2, '.', ''),
            "total_g2_sales"       => number_format((float)$mySalesLeaderLevel['totalSalesG2'], 2, '.', ''),
            "total_sales_po_g1_g2" => number_format((float)$mySalesLeaderLevel['myTeamTotalSales'], 2, '.', ''),
            "upLevel"              => isset($mySalesLeaderLevel['myMonthlyEarnings']) && isset($mySalesLeaderLevel['myMonthlyEarnings']['upLevel']) && $mySalesLeaderLevel['myMonthlyEarnings']['upLevel'] > 0 ? 1 : 0,

        ];
        $earning = [
            "type"                 => "Earning",
            "personal_order"       => "0",
            "active_team"          => 0,
            "g1_new"               => 0,
            "g1_new_sales"         => isset($mySalesLeaderLevel['myMonthlyEarnings']) ? number_format((float)$mySalesLeaderLevel['myMonthlyEarnings']['earnFromNewMembersSales'], 2, '.', '') : "0",
            "total_g1_sales"       => isset($mySalesLeaderLevel['myMonthlyEarnings']) ? number_format((float)$mySalesLeaderLevel['myMonthlyEarnings']['earnFromMembersSalesG1'], 2, '.', '') : "0",
            "total_g2_sales"       => isset($mySalesLeaderLevel['myMonthlyEarnings']) ? number_format((float)$mySalesLeaderLevel['myMonthlyEarnings']['earnFromMembersSalesG2'], 2, '.', '') : "0",
            "total_sales_po_g1_g2" => "0",
            "upLevel"              => isset($mySalesLeaderLevel['myMonthlyEarnings']) ? $mySalesLeaderLevel['myMonthlyEarnings']['upLevel'] : 0,

        ];
        $data    = [
            "saleing"        => $saleing,
            "earning"        => $earning,
            "total_earnings" => isset($mySalesLeaderLevel['myMonthlyEarnings']) && isset($mySalesLeaderLevel['myMonthlyEarnings']['total']) ? number_format((float)$mySalesLeaderLevel['myMonthlyEarnings']['total'], 2, '.', '') : "0",
            "g1_count"       => count($mySalesLeaderLevel['myTeamG1Count']),
            "g1_new_count"   => $mySalesLeaderLevel['myNewMembersActivesCount'],
            "g2_count"       => count($mySalesLeaderLevel['myTeamG2Count']),
        ];


        return $this->API_RESPONSE->data($data, 'My Commission Info', 200);
    }

    public function calculateMyMonthlyCommission($user_id)
    {
        $currentuser                = $this->UserService->getUser($user_id);
        $user_id                    = $currentuser->id;
        $userIsActiveInCurrentMonth = $this->UserService->userIsActiveInCurrentMonth($user_id);
        if (!empty($userIsActiveInCurrentMonth)) {
            $mytotalPaidOrderThisManth = $userIsActiveInCurrentMonth['total'];
            $getMyTeamG1               = $this->UserService->getMyTeamGeneration($user_id, 1);
            array_push($getMyTeamG1, $user_id);
            $getMyTeamG2               = $this->UserService->getMyTeamGeneration($user_id, 2);
            $myTeamMembers             = array_merge($getMyTeamG1, $getMyTeamG2);
            $myTeamMembersActives      = $this->getMyTeamMembersActives($myTeamMembers);
            $myTeamMembersActivesG1    = $this->getMyTeamMembersActives($getMyTeamG1);
            $myTeamMembersActivesG2    = $this->getMyTeamMembersActives($getMyTeamG2);
            $myTeamMembersActivesCount = count($myTeamMembersActives);
            $getMyNewMembers           = $this->UserService->getMyTeamGeneration($user_id, 1, true);

            if ($userIsActiveInCurrentMonth['new'] > 0)
                array_push($getMyNewMembers, $user_id);

            $myNewMembersActivesCount = $this->getMyNewMembersActivesCount($getMyNewMembers);
            $myTeamTotalSales         = $this->UserService->getMyTeamTotalSales($myTeamMembersActives);
            $myTeamTotalSalesG1       = $this->UserService->getMyTeamTotalSales($myTeamMembersActivesG1);
            $myTeamTotalSalesG2       = $this->UserService->getMyTeamTotalSales($myTeamMembersActivesG2);
            $myNewMembersSales        = $this->UserService->getMyTeamTotalSales($getMyNewMembers);
            $mySalesLeaderLevel       = $this->UserService->getMySalesLeaderLevel($myTeamMembersActivesCount, $myNewMembersActivesCount, $myTeamTotalSales);
            $myMonthlyEarnings        = $this->getTotalMonthlyEarnings($mySalesLeaderLevel, $currentuser->sales_leaders_level_id, $myNewMembersSales, $myTeamTotalSalesG1, $myTeamTotalSalesG2);
            $data = [
                "user_id"              => $user_id,
                "personal_order"       => $mytotalPaidOrderThisManth >= 250 ? '1' : 0,
                "active_team"          => $myTeamMembersActivesCount,
                "g1_new"               => $myNewMembersActivesCount,
                "g1_new_sales"         => $myNewMembersSales,
                "total_g1_sales"       => $myTeamTotalSalesG1,
                "total_g2_sales"       => $myTeamTotalSalesG2,
                "total_sales_po_g1_g2" => $myTeamTotalSales,
                "upLevel"              => isset($myMonthlyEarnings) && isset($myMonthlyEarnings['upLevel']) && $myMonthlyEarnings['upLevel'] > 0 ? '1' : '0',
                "e_g1_new_sales"       => isset($myMonthlyEarnings) && isset($myMonthlyEarnings['earnFromNewMembersSales']) ? round($myMonthlyEarnings['earnFromNewMembersSales'],2) : 0,
                "e_total_g1_sales"     => isset($myMonthlyEarnings) && isset($myMonthlyEarnings['earnFromMembersSalesG1']) ?round($myMonthlyEarnings['earnFromMembersSalesG1'],2) : 0,
                "e_total_g2_sales"     => isset($myMonthlyEarnings) && isset($myMonthlyEarnings['earnFromMembersSalesG2']) ? round($myMonthlyEarnings['earnFromMembersSalesG2'],2) : 0,
                "e_upLevel"            => isset($myMonthlyEarnings) && isset($myMonthlyEarnings['upLevel']) ? $myMonthlyEarnings['upLevel'] : 0,
                "total_earnings"       => isset($myMonthlyEarnings) && isset($myMonthlyEarnings['total']) ? round($myMonthlyEarnings['total'],2) : 0,
            ];

            $myCo= $this->CommissionService->CreateOrUpdateMonthlyCommission($user_id,$data);
            return $this->API_RESPONSE->data($myCo, 'My Commission Created successfully', 200);
        }
return true;
    }
      public function calculateToMyParentMonthlyCommission($user_id)
       {
        $myParents = $this->UserService->getMyParents($user_id);
        if (!empty($myParents)) {
            foreach ($myParents as $parent) {
              $this->calculateMyMonthlyCommission($parent);
            }
        }
        return true;
       }

    public function getMyCashback(Request $request)
    {
        $currentuser                 = $this->UserService->getUser($request->user_id);
        $mytotalPaidOrderThisQuarter = $this->UserService->getMyTeamTotalSales([$currentuser->id], 'quarter');
        $mytotalPaidOrderThisYear    = $this->UserService->getMyTeamTotalSales([$currentuser->id], 'year');
        $myCashbackLevel             = $this->UserService->getMyCashbackLevel($mytotalPaidOrderThisQuarter) ?? [];
        $myNextCashbackLevel         = $this->UserService->getMyNextCashbackLevel(!empty($myCashbackLevel) ? $myCashbackLevel->id : 0);
        $myQuarterCommission         = $this->CommissionService->myCurrentCommission($request->user_id, 'quarter');
        $myYearCommission            = $this->CommissionService->myCurrentCommission($request->user_id, 'year');
        $myCCashbackLevel            = [
            "name_en"                 => !empty($myCashbackLevel) ? $myCashbackLevel['name_en'] : "",
            "name_ar"                 => !empty($myCashbackLevel) ? $myCashbackLevel['name_ar'] : "",
            "quarter_sales_amount"    => !empty($myCashbackLevel) ? $myCashbackLevel['quarter_sales_amount'] : 0,
            "quarter_sales_cash_back" => !empty($myCashbackLevel) ? $myCashbackLevel['quarter_sales_cash_back'] : 0,
            "annual_sales_amount"     => !empty($myCashbackLevel) ? $myCashbackLevel['annual_sales_amount'] : 0,
            "annual_sales_cash_back"  => !empty($myCashbackLevel) ? $myCashbackLevel['annual_sales_cash_back'] : 0
        ];

        $myNNEXCashbackLevel = [
            "name_en"                 => !empty($myNextCashbackLevel) ? $myNextCashbackLevel['name_en'] : "",
            "name_ar"                 => !empty($myNextCashbackLevel) ? $myNextCashbackLevel['name_ar'] : "",
            "quarter_sales_amount"    => !empty($myNextCashbackLevel) ? $myNextCashbackLevel['quarter_sales_amount'] : 0,
            "quarter_sales_cash_back" => !empty($myNextCashbackLevel) ? $myNextCashbackLevel['quarter_sales_cash_back'] : 0,
            "annual_sales_amount"     => !empty($myNextCashbackLevel) ? $myNextCashbackLevel['annual_sales_amount'] : 0,
            "annual_sales_cash_back"  => !empty($myNextCashbackLevel) ? $myNextCashbackLevel['annual_sales_cash_back'] : 0
        ];

        $myCashback = [
            "mytotalPaidOrderThisQuarter" => number_format((float)$mytotalPaidOrderThisQuarter, 2, '.', ''),
            "quarter_sales_cash_back"     => !empty($myQuarterCommission) ? $myQuarterCommission : 0,
            "mytotalPaidOrderThisYear"    => number_format((float)$mytotalPaidOrderThisYear, 2, '.', ''),
            "annual_sales_cash_back"      => !empty($myYearCommission) ? $myYearCommission : 0
        ];
        $data       = [
            "myCashback"          => $myCashback,
            "myCashbackLevel"     => $myCCashbackLevel,
            "myNextCashbackLevel" => $myNNEXCashbackLevel,
        ];


        return $this->API_RESPONSE->data($data, 'My Cashback Info', 200);

    }

    public function getMyReports(Request $request)
    {
        $currentuser        = $this->UserService->getUser($request->user_id);
        $mySalesLeaderLevel = $this->getMySalesLeaderLevel($currentuser->id, $currentuser->sales_leaders_level_id);
        $myTeam             = [
            "myTeamMembersActivesWithSales"    => $mySalesLeaderLevel['myTeamMembersActivesWithSales'],
            "myTeamMembersNotActivesWithSales" => $mySalesLeaderLevel['myTeamMembersNotActivesWithSales'],
        ];
        return $this->API_RESPONSE->data($myTeam, 'My Cashback Info', 200);
    }

    public function exportActiveTeamSheet(Request $request)
    {

        $getMyTeamG1   = $this->UserService->getMyTeamGeneration($request->user_id, 1);
        $getMyTeamG2   = $this->UserService->getMyTeamGeneration($request->user_id, 2);
        $myTeamMembers = array_merge($getMyTeamG1, $getMyTeamG2, [$request->user_id]);
        if (isset($request->type) && $request->type == 'active') {
            $team = $this->getMyTeamMembersActives($myTeamMembers);
        }
        else {
            $team = $this->getMyTeamMembersNotActives($myTeamMembers);
        }
        try {
            return Excel::download(new MemberActiveExport($team), 'members.csv');
        }
        catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => 'Users Error in Import']);
        }
    }

    public function splitName($name)
    {
        $parts = array();
        while (strlen(trim($name)) > 0) {
            $name    = trim($name);
            $string  = preg_replace('#.*\s([\w-]*)$#', '$1', $name);
            $parts[] = $string;
            $name    = trim(preg_replace('#' . preg_quote($string, '#') . '#', '', $name));
        }
        if (empty($parts)) {
            return false;
        }
        $parts               = array_reverse($parts);
        $name                = array();
        $name['first_name']  = $parts[0];
        $name['middle_name'] = (isset($parts[2])) ? $parts[1] : '';
        $name['last_name']   = (isset($parts[2])) ? $parts[2] : (isset($parts[1]) ? $parts[1] : '');
        return $name;
    }


    public function getMySalesLeaderLevel($user_id, $sales_leaders_level_id)
    {
        $userIsActiveInCurrentMonth = $this->UserService->userIsActiveInCurrentMonth($user_id);
        if ($userIsActiveInCurrentMonth) {
            $getMyTeamG1 = $this->UserService->getMyTeamGeneration($user_id, 1);
            array_push($getMyTeamG1, $user_id);
            $getMyTeamG2                      = $this->UserService->getMyTeamGeneration($user_id, 2);
            $myTeamMembers                    = array_merge($getMyTeamG1, $getMyTeamG2);
            $myTeamMembersActives             = $this->getMyTeamMembersActives($myTeamMembers);
            $myTeamMembersNotActives          = $this->getMyTeamMembersNotActives($myTeamMembers);
            $myTeamMembersActivesWithSales    = $this->UserService->getUsersActiveSalesTeam($myTeamMembersActives);
            $myTeamMembersNotActivesWithSales = $this->UserService->getUsersNotActiveSalesTeam($myTeamMembersNotActives);
            $myTeamMembersActivesG1           = $this->getMyTeamMembersActives($getMyTeamG1);
            $myTeamMembersActivesG2           = $this->getMyTeamMembersActives($getMyTeamG2);
            $myTeamMembersActivesCount        = count($myTeamMembersActives);
            $getMyNewMembers                  = $this->UserService->getMyTeamGeneration($user_id, 1, true);

            if ($userIsActiveInCurrentMonth['new'] > 0)
                array_push($getMyNewMembers, $user_id);

            $myNewMembersActivesCount = $this->getMyNewMembersActivesCount($getMyNewMembers);
            $myTeamTotalSales         = $this->UserService->getMyTeamTotalSales($myTeamMembersActives);
            $myTeamTotalSalesG1       = $this->UserService->getMyTeamTotalSales($myTeamMembersActivesG1);
            $myTeamTotalSalesG2       = $this->UserService->getMyTeamTotalSales($myTeamMembersActivesG2);
            $myNewMembersSales        = $this->UserService->getMyTeamTotalSales($getMyNewMembers);
            $mySalesLeaderLevel       = $this->UserService->getMySalesLeaderLevel($myTeamMembersActivesCount, $myNewMembersActivesCount, $myTeamTotalSales);
            $myMonthlyEarnings        = $this->getTotalMonthlyEarnings($mySalesLeaderLevel, $sales_leaders_level_id, $myNewMembersSales, $myTeamTotalSalesG1, $myTeamTotalSalesG2);

            $data = [
                "level"                            => $mySalesLeaderLevel,
                "myTeamTotalSales"                 => $myTeamTotalSales,
                "totalSalesG1"                     => $myTeamTotalSalesG1,
                "totalSalesG2"                     => $myTeamTotalSalesG2,
                "myTeamMembersActivesCount"        => $myTeamMembersActivesCount,
                "myTeamMembersActivesWithSales"    => $myTeamMembersActivesWithSales,
                "myTeamMembersNotActivesWithSales" => $myTeamMembersNotActivesWithSales,
                "myNewMembersActivesCount"         => $myNewMembersActivesCount,
                "myNewMembersSales"                => $myNewMembersSales,
                "myTeamG1Count"                    => $getMyTeamG1,
                "myTeamG2Count"                    => $getMyTeamG2,
                "myMonthlyEarnings"                => $myMonthlyEarnings,
            ];
            return $data;
        }
        else {
            return null;
        }
    }

    public function getMyNewMembersActivesCount($newTeam)
    {
        $count = 0;
        foreach ($newTeam as $member_id) {
            $data = $this->UserService->userIsActiveInCurrentMonth($member_id);
            if ($data['active'] == true) {
                $count++;
            }
        }
        return $count;
    }

    public function getMyTeamMembersActives($Team)
    {
        $activeMembers = [];
        foreach ($Team as $member_id) {
            $data = $this->UserService->userIsActiveInCurrentMonth($member_id);
            if ($data['active'] == true) {
                $activeMembers[] = $member_id;
            }
        }
        return $activeMembers;
    }

    public function getMyTeamMembersNotActives($Team)
    {
        $notActiveMembers = [];
        foreach ($Team as $member_id) {
            $data = $this->UserService->userIsActiveInCurrentMonth($member_id);
            if ($data['active'] == true) {
            }
            else {
                $notActiveMembers[] = $member_id;
            }
        }
        return $notActiveMembers;
    }

    public function getTotalMonthlyEarnings($mySalesLeaderLevel, $sales_leaders_level_id, $myNewMembersSales, $myTeamTotalSalesG1, $myTeamTotalSalesG2)
    {
        if (!empty($mySalesLeaderLevel)) {
            $data['upLevel']                 = $mySalesLeaderLevel->id > $sales_leaders_level_id ? $mySalesLeaderLevel->life_time_bonus : 0;
            $data['earnFromNewMembersSales'] = (float)$myNewMembersSales * ($mySalesLeaderLevel->spons_b_new_r / 100);
            $data['earnFromMembersSalesG1']  = (float)$myTeamTotalSalesG1 * ($mySalesLeaderLevel->g1_bonus / 100);
            $data['earnFromMembersSalesG2']  = (float)$myTeamTotalSalesG2 * ($mySalesLeaderLevel->g2_bonus / 100);
            $data['spons_b_new_r']           = ($mySalesLeaderLevel->spons_b_new_r / 100);
            $data['g1_bonus']                = ($mySalesLeaderLevel->g1_bonus / 100);
            $data['g2_bonus']                = ($mySalesLeaderLevel->g2_bonus / 100);
            $data['total']                   = $data['upLevel'] + $data['earnFromNewMembersSales'] + $data['earnFromMembersSalesG1'] + $data['earnFromMembersSalesG2'];
            return $data;
        }

        return null;
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
}
