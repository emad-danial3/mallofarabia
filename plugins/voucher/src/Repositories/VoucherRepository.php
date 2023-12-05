<?php

namespace Khaleds\Voucher\Repositories;

use App\Http\Repositories\BaseRepository;
use Khaleds\Voucher\Models\Voucher;


class VoucherRepository extends BaseRepository
{

    public function __construct(Voucher $model)
    {
        parent::__construct($model);
    }
}
