<?php

namespace Khaleds\Voucher\Listeners;

use App\Events\User\GettingInfo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Khaleds\Voucher\Services\VoucherService;

class CheckAndApplyVoucher
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
     * @param  \App\Events\User\GettingInfo  $event
     * @return void
     */
    public function handle(GettingInfo $event)
    {
        //
        VoucherService::check($event->user_info,$event->user_id);
    }
}
