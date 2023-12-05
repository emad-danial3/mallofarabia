<?php

namespace Khaleds\Voucher\Classes;

use Khaleds\Voucher\Interfaces\Voucher;

class VoucherMinimum50 implements Voucher
{

    //make theme private
    //make it enum
    public $type;

    public $newMinimum;

    public $oldMinimum;

    public $amount;


    public function apply()
    {
      if ($this->type == 'Fixed')
          $this->newMinimum=$this->oldMinimum-$this->amount;
      else
          $this->newMinimum=$this->oldMinimum-($this->oldMinimum*($this->amount/100));

    }
}
