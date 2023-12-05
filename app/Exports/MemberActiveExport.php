<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MemberActiveExport implements FromCollection , WithHeadings
{
    private  $team;
    public function __construct($team)
    {
        $this->team = $team;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select(["id","full_name","email","phone"])->whereIn('id',$this->team)->get();
    }

    public function headings() :array
    {
        return ["id","full_name","email","phone"];
    }
}
