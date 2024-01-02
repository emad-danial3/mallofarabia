<?php

namespace App\Http\Controllers;


use App\Http\Services\OracleInvoicesService;
use App\Models\OrderHeader;
use App\Models\OrderLine;
use App\Models\OrderPrintHistory;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use  \Illuminate\Support\Facades\DB;


class StoreInvoicesPrintController extends HomeController
{

    private   $OracleInvoicesService;

    public function __construct(OracleInvoicesService $OracleInvoicesService)
    {
        $this->OracleInvoicesService = $OracleInvoicesService;
    }

     public function index()
    {
        $data = $this->OracleInvoicesService->getAll(request()->all());
        return view('AdminPanel.PagesContent.storeInvoicesPrint.index')->with('storeInvoicesPrint', $data);
    }


     public function printInvoice($id)
    {

        $orderHeader=OrderHeader::where('id',$id)->first();
       if(!empty($orderHeader) && $orderHeader->is_printed == '1'){
           return "this Invoice Printed before If You want please return to 4UNettingHub management ";
       }else{

        $orderHeader->is_printed='1';
        $orderHeader->save();
        OrderPrintHistory::create(['order_header_id'=>$orderHeader->id,'admin_id'=>Auth::guard('admin')->user()->id]);
        $orderNumber = $orderHeader->id;
        $invoicesCount = OrderLine::select('oracle_num')->where('order_id', $orderNumber)->distinct()->count('oracle_num');
        $invoicesNumber = OrderLine::leftJoin('oracle_invoices', function($join) {
                             $join->on('oracle_invoices.web_order_number', '=', 'order_lines.oracle_num');
                         })->select('order_lines.oracle_num','oracle_invoices.oracle_invoice_number')->where('order_lines.order_id', $orderNumber)->distinct('order_lines.oracle_num')->get();

        $invoicesLines = DB::select('SELECT ol.oracle_num ,ol.price pprice,p.tax ptax,ol.price * ol.quantity  olprice,p.name_en psku,ol.quantity olquantity FROM order_lines ol,products p
     	                        where 	ol.order_id =' . $orderNumber . '
     	                        and ol.product_id = p.id ');
        $invoicesTotalPrice = OrderLine::where('order_id', $orderNumber)->sum('quantity');
        $user = User::where('id', $orderHeader->client_id)->first();
        return view('AdminPanel.PagesContent.storeInvoicesPrint.printInvoice', compact('orderHeader', 'invoicesNumber', 'invoicesCount', 'invoicesLines', 'invoicesTotalPrice', 'user'));
       }
    }


}
