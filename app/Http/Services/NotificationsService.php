<?php

namespace App\Http\Services;

use App\Http\Repositories\NotificationRepository;

class NotificationsService extends BaseServiceController
{

    private  $NotificationRepository;

    public function __construct(NotificationRepository  $NotificationRepository)
    {
        $this->NotificationRepository = $NotificationRepository;
    }

    public function create($notification)
    {
        return $this->NotificationRepository->create($notification);
    }
}
