<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReturnOrderHeader;
use App\Models\ReturnOrderLine;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ReturnOrderHeaderController extends Controller
{

    public function index(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        if(!isset($from) || !isset($to))
        {
            $from   = Carbon::now()->toDateString();
            $to   = Carbon::now()->toDateString();

        }
        $from_day =  $from  .' 00:00:00' ;
        $to_day =     $to .' 23:59:59';
        $orderHeaders  = ReturnOrderHeader::whereBetween('created_at', [$from_day, $to_day])
        ->orderBy('created_at', 'desc')
        ->get();
        return view('AdminPanel.PagesContent.ReturnOrderHeaders.index',get_defined_vars());
    }
     public function view($id)
    {

        $orderHeader = ReturnOrderHeader::where('id', $id)->first();
        $orderNumber = $orderHeader->id;
        $invoicesCount = ReturnOrderLine::select('oracle_num')->where('order_id', $orderNumber)->distinct()->count('oracle_num');
        $invoicesNumber = [];

        $invoicesLines = DB::select('SELECT ol.oracle_num ,p.price pprice,p.tax ptax,ol.price olprice,p.name_en psku,ol.quantity olquantity FROM return_order_lines ol,products p
                                where   ol.order_id =' . $orderNumber . '
                                and ol.product_id = p.id ');
        $invoicesTotalPrice = ReturnOrderLine::where('order_id', $orderNumber)->sum('quantity');
        $user = Client::where('id', $orderHeader->client_id)->first();

        return view('AdminPanel.PagesContent.ReturnOrderHeaders.view', compact('orderHeader', 'invoicesNumber', 'invoicesCount', 'invoicesLines', 'invoicesTotalPrice', 'user'));

    }

}
