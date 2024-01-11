<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReturnOrderHeader;
class ReturnOrderHeaderController extends Controller
{
    //

    public function index()
    {
        $orderHeaders = ReturnOrderHeader::orderBy('id', 'desc')
                ->paginate(config('constants.page_items_count'));
        return view('AdminPanel.PagesContent.OrderHeaders.index',get_defined_vars());
    }

}
