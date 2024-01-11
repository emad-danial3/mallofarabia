<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OracleCollectedInvoice;
class DepositeController extends Controller
{
    //
    public function index()
    {

        $invoices = OracleCollectedInvoice::orderBy('id', 'desc')
                ->paginate(config('constants.page_items_count'));
        return view('AdminPanel.PagesContent.Deposite.index',get_defined_vars());
       
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $amount = $request->amount;
        $refrence = $request->refrence;
        if(!$amount)
        {
             return response()->json(['error' => "amount is required"]);
        }
        if(!$reference)
        {
             return response()->json(['error' => "refrence is required"]);
        }
        $invoice = OracleCollectedInvoice::find($id)->first();
        if(!$invoice)
        {
             return response()->json(['error' => "invoice  not found"]);
        }
        $invoice->deposit_amount = $amount ;
        $invoice->deposit_refrence = $refrence ;
        $invoice->save();
        return response()->json(['message' => "Deposite inserted  Successfully"]);

    }
}
