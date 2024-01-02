<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceExport;
use App\Http\Requests\ExportOracleInvoicesSheet;
use App\Http\Services\OracleInvoicesService;
use Illuminate\Http\Request;

use DB;
use Maatwebsite\Excel\Facades\Excel;

class OracleInvoicesController extends HomeController
{

    private   $OracleInvoicesService;

    public function __construct(OracleInvoicesService $OracleInvoicesService)
    {
        $this->OracleInvoicesService = $OracleInvoicesService;
    }


     public function index()
    {
        $data = $this->OracleInvoicesService->getAll(request()->all());
        $ordersCountNotSentToOracle=$this->OracleInvoicesService->getOrdersNotSentToOracle();
        $ordersCountSentToOracleNotReturn=$this->OracleInvoicesService->ordersCountSentToOracleNotReturn();
        return view('AdminPanel.PagesContent.oracleInvoices.index')->with('oracleInvoices', $data)->with('ordersCountNotSentToOracle',$ordersCountNotSentToOracle)->with('ordersCountSentToOracleNotReturn',$ordersCountSentToOracleNotReturn);
    }

    public function updateOracleInvoices()
{
    $refresh_link = config('constants.refresh_order_link') ;
    $client   = new \GuzzleHttp\Client();
    $response = $client->request('POST', $refresh_link, ['verify'      => false
]);
$invoices = $response->getBody();

if (isset($invoices)) {
$invoices = json_decode($invoices);
foreach ($invoices as $invoice) {
$this->OracleInvoicesService->createOrUpdate($invoice);
}
return redirect()->back()->with('message', "Items Updated  Successfully");
}
else {
return redirect()->back()->withErrors(['error' => "error in get Data"]);
}
}


   public function refreshOracleInvoices()
    {
        $this->OracleInvoicesService->updateInvoices();
        return redirect()->back()->with('message', "Items Invoices Updated  Successfully");
    }

    public function ExportOracleInvoicesSheet(ExportOracleInvoicesSheet $request)
    {
        $validated = $request->validated();
        try {
                return Excel::download(new InvoiceExport($validated['start_date'], $validated['end_date']), 'Invoices.xlsx');
        } catch (\Exception $exception) {

            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }


    public function updateInvoiceOraclelJob()
    {
        $this->updateOracleInvoices();
        $this->refreshOracleInvoices();
    }

}
