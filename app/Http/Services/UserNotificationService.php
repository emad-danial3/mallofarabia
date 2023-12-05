<?php

namespace App\Http\Services;

use App\Http\Repositories\UserNotificationRepository;

class UserNotificationService extends BaseServiceController
{
    private  $UserNotificationRepository;

    public function __construct(UserNotificationRepository $UserNotificationRepository)
    {
        $this->UserNotificationRepository = $UserNotificationRepository;
    }

    public function hasNotification($user_id)
    {
        return $this->UserNotificationRepository->hasNotification($user_id);
    }

    public function readNotification($user_id,$offset)
    {
        return $this->UserNotificationRepository->getMyNotification($user_id,$offset);
    }

    public function getNextOffset()
    {
        return $this->UserNotificationRepository->nextOffset();
    }


    public function updateUser($id){
        $this->UserNotificationRepository->updateUser($id);
    }
}
