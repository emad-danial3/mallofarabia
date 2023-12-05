<?php

namespace Khaleds\Voucher\Listeners;

use App\Events\FreeAccountPaid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Khaleds\Voucher\Services\VoucherService;

class ChangeVoucherStatus
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\FreeAccountPaid  $event
     * @return void
     */
    public function handle(FreeAccountPaid $event)
    {
        //
        VoucherService::changeStatus('Used',$event->user_id);
    }
}
