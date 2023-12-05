<?php

namespace App\Http\Repositories;

use App\Models\UserNotification;

class IUserNotificationRepository extends BaseRepository implements UserNotificationRepository
{
    public function __construct(UserNotification $model)
    {
        parent::__construct($model);
    }
    public function hasNotification($user_id):int
    {
        $numberOfNotification = UserNotification::where('user_id',$user_id)->count();

        return ($numberOfNotification) ? 1 :0;
    }

    public function readNotification($user_id)
    {
       return UserNotification::where('user_id',$user_id)->update([
            'is_read' => 1
        ]);
    }

    public function getMyNotification($user_id,$offset)
    {

        return UserNotification::where('user_id',$user_id)->orderBy('id','DESC')->skip($this->getOffset())
            ->take($this->getLimit())->get();
    }
    public function updateUser($id){

        UserNotification::where('user_id',$id)->update(['is_read'=>1]);

    }
}
