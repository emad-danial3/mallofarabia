<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OracleCollectedInvoice;
class DepositeController extends Controller
{
    //
    public function index()
    {

        $invoices = OracleCollectedInvoice::orderBy('order_headers.created_at', 'desc')
                ->paginate(config('constants.page_items_count'));
        return view('AdminPanel.login',get_defined_vars());
       
    }
}
