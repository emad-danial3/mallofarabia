<?php

namespace App\Exports;


use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\RegisterLink;
class LinksExport implements FromCollection , WithHeadings
{

    private  $products_ids;
    public function __construct($products_ids)
    {
        $this->products_ids = $products_ids;
    }

    public function collection()
    {
        $data =  RegisterLink::select('users.full_name','register_links.link')
                 ->join('users','users.id','register_links.user_id')
                 ->whereIn('register_links.id',$this->products_ids)->get();
        $url=url('');
        foreach ($data as $row)
        {
            $row['link'] =$url.'/'.$row['link'];
        }
        return $data;
    }

    public function headings(): array
    {
        return  ['full_name','link'];
    }
}
