<?php

namespace App\Http\Repositories;

interface UserNotificationRepository
{
    public function hasNotification($user_id);
    public function readNotification($user_id);
    public function getMyNotification($user_id,$offset);
}
