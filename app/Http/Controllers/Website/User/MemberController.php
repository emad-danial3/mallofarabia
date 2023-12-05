<?php

namespace App\Http\Controllers\Website\User;

use App\Exports\MemberActiveExport;
use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use App\Models\City;
use App\Models\Country;
use App\Models\OrderHeader;
use App\Models\UserMembership;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Maatwebsite\Excel\Facades\Excel;

class MemberController extends Controller
{
    protected $UserService;

    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }

    public function index()
    {
        $addresses   = null;
        $currentuser = Auth::user();

        if (!empty($currentuser)) {
            $conditions = ['user_addresses.user_id', '=', $currentuser->id];
            $addresses  = $this->UserService->getUserAddress($conditions);
            $countries  = Country::all();
            $cities     = null;
            if (!empty($countries)) {
                $cities = City::where('country_id', $countries[0]->id)->get();
            }
            $totalPaidOrder              = $this->UserService->getUserTotalOrders([['payment_status', '=', 'PAID'], ['user_id', '=', $currentuser->id]]);
            $mytotalPaidOrderThisManth   = $this->UserService->getMyTeamTotalSales([$currentuser->id], 'month');
            $mytotalPaidOrderThisQuarter = $this->UserService->getMyTeamTotalSales([$currentuser->id], 'quarter');
            $mytotalPaidOrderThisYear    = $this->UserService->getMyTeamTotalSales([$currentuser->id], 'year');
            $myCashbackLevel             = $this->UserService->getMyCashbackLevel($mytotalPaidOrderThisQuarter);

            $myNextCashbackLevel = null;
            if (!empty($myCashbackLevel)) {
                $myNextCashbackLevel = $this->UserService->getMyNextCashbackLevel($myCashbackLevel->id);
            }
            $totalPendingOrder = $this->UserService->getUserTotalOrders([['payment_status', '=', 'PENDING'], ['user_id', '=', $currentuser->id]]);
            $myOrders          = $this->UserService->getMyOrders($currentuser->id);
            $fullName          = $this->splitName($currentuser->full_name);

            $mySalesLeaderLevel = $this->getMySalesLeaderLevel($currentuser->id, $currentuser->sales_leaders_level_id);

            $myNextSalesLeaderLevel = null;
            if (!empty($mySalesLeaderLevel['level'])) {
                $myNextSalesLeaderLevel = $this->UserService->getMyNextSalesLeaderLevel($mySalesLeaderLevel['level']->id);
            }
            $membership = UserMembership::where('user_id', Auth::user()->id)->select('id')->first();
            return view('user.memberProfile', compact('addresses', 'membership', 'countries', 'cities', 'totalPaidOrder', 'totalPendingOrder', 'fullName', 'myOrders', 'mySalesLeaderLevel', 'myNextSalesLeaderLevel', 'mytotalPaidOrderThisManth', 'myCashbackLevel', 'mytotalPaidOrderThisQuarter', 'mytotalPaidOrderThisYear', 'myNextCashbackLevel'));
        }
        return Redirect('/login');
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

            $mySalesLeaderLevel = $this->UserService->getMySalesLeaderLevel($myTeamMembersActivesCount, $myNewMembersActivesCount, $myTeamTotalSales);
            $myMonthlyEarnings  = $this->getTotalMonthlyEarnings($mySalesLeaderLevel, $sales_leaders_level_id, $myNewMembersSales, $myTeamTotalSalesG1, $myTeamTotalSalesG2);

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
//          dd($data['earnFromNewMembersSales']);
            return $data;
        }

        return null;
    }

    public function cancelMemberOrder(Request $request)
    {
        $data = $request->only('order_id', 'canceled_reason');
        if (isset($data['order_id']) && $data['order_id'] > 0) {
            $orderHeader                  = OrderHeader::where('id', $request->order_id)->first();
            $orderHeader->order_status    = 'Cancelled';
            $orderHeader->payment_status  = 'CANCELED';
            $orderHeader->canceled_reason = $data['canceled_reason'];
            $orderHeader->save();
            return redirect()->back()->with('message', 'Order Cancel success');
        }
        return redirect()->back()->withErrors(['error' => 'no order To cancel']);
    }

    public function ExportActiveTeamSheet(Request $request)
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

}
