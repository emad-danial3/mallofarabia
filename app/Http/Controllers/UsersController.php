<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Requests\ExportUserSheet;
use App\Http\Requests\importUsersRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Services\UserService;
use App\Imports\UsersImport;
use App\Models\City;
use App\Models\User;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends  HomeController
{

    private  $UserService;
    private  $AccountLevelService;

    public function __construct(UserService  $UserService)
    {
        $this->UserService = $UserService;
    }

    public function index()
    {

        $users = Admin::orderBy('id','desc')->get();
        return view('AdminPanel.PagesContent.Users.index')->with('users',$users);
    } 
   /* public function index()
    {

        if (empty(request()->all()))
            $users = $this->UserService->getAllUsersWithOutPagination();
        else
            $users = $this->UserService->getAllUsers(request()->all());
        return view('AdminPanel.PagesContent.Users.index')->with('users',$users);
    }
*/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $types=AccountType::all();
        $cities =City::select(['name_en','id']) ->distinct()->get();

        return view('AdminPanel.PagesContent.Users.form',compact('types','cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {

        $validated = $request->validated();
        if(isset($validated['full_name']) && $validated['full_name'] !=''){
            $validated['full_name']=trim($validated['full_name']);
        }
        $userRow  = $this->UserService->createUser($validated);
        $this->AccountLevelService->createLevels($userRow['id'], $userRow['parent_id']);
        $this->UserService->sendRegistrationEmail($userRow);
        $this->UserService->sendRegistrationMessage($userRow);
        return redirect()->back()->with('message','User Added Successfully');

    }


    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('AdminPanel.PagesContent.Users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User  $user)
    {
        return view('AdminPanel.PagesContent.Users.edit')->with('user',$user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateUserRequest $request,$id)
    {
        $validated = $request->validated();
        if(isset($validated['full_name']) && $validated['full_name'] !=''){
            $validated['full_name']=trim($validated['full_name']);
        }
        $this->UserService->updateUserRow($validated , $id);
        return redirect()->back()->with('message','User Updated Successfully');
    }
    public function makeUserNewRecruit(Request $request)
    {
        $now=Carbon::now()->toDateTimeString();
        $inputs=$request->only('user_id');
        if(isset($inputs) &&isset($inputs['user_id']) && $inputs['user_id'] >0){
            $data=['created_at'=>$now];
           $this->UserService->updateUserRow($data , $inputs['user_id']);
        }
        return redirect()->back()->with('message','User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $blog)
    {

    }

    public function importUserSheet(importUsersRequest $request)
    {
        $validated = $request->validated();
        try {
            Excel::import(new UsersImport(),request()->file('file'));
            return redirect()->back()->with('message','Users Updated Successfully');
        }
        catch (\Exception $exception)
        {
            return redirect()->back()->withErrors(['error' => 'Users Error in Export']);
        }
    }

    public function ExportUserSheet(ExportUserSheet $request)
    {
        $validated = $request->validated();
        try {
            return Excel::download(new UsersExport($validated['start_date'],$validated['end_date']), 'users.csv');
        }
        catch (\Exception $exception)
        {

            return redirect()->back()->withErrors(['error' => 'Users Error in Import']);
        }
    }
}
