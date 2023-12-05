<?php

namespace App\Exports;

use App\Models\AccountLevel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class UsersLevelsExport implements FromCollection , WithHeadings
{
    public function collection()
    {
        $data= AccountLevel::select(
                'account_levels.parent_id',
                'parent.full_name as ParentName',
                'account_levels.id',
                'child.full_name as ChildName',
            )
            ->leftJoin('users AS parent','account_levels.parent_id','=','parent.id')
            ->leftJoin('users AS child','account_levels.child_id','=','child.id')
            ->orderBy('account_levels.updated_at','desc')->get();
        return $data;
    }

    public function headings(): array
    {
        return  [
            'ParentID',
            'ParentName',
            'Level',
            'ChildName',
        ];
    }
}
