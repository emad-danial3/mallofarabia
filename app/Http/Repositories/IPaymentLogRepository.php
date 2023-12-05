<?php

namespace App\Http\Repositories;

use App\Models\PaymentLog;

class IPaymentLogRepository extends BaseRepository implements PaymentLogRepository
{
    public function __construct(PaymentLog $model)
    {
        parent::__construct($model);
    }
}
