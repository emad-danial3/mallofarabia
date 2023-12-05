<?php

namespace App\Http\Repositories;

use App\Models\UserNotification;
use Illuminate\Database\Eloquent\Model;

class INotificationRepository extends BaseRepository implements NotificationRepository
{
    public function __construct(UserNotification $model)
    {
        parent::__construct($model);
    }
}
