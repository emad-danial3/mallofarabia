<?php

namespace App\Http\Repositories;

use App\Models\PurchaseInvoiceLines;
use App\Models\PurchaseInvoices;
use Illuminate\Support\Facades\Auth;

class IPurchaseInvoicesLineRepository extends BaseRepository implements PurchaseInvoiceLinesRepository
{
    public function __construct(PurchaseInvoiceLines $model)
    {
        parent::__construct($model);
    }


    public function createLines($invoiceLineData)
    {
        PurchaseInvoiceLines::create([
            'admin_id'             => Auth::guard('admin')->user()->id,
            'store_id'             => Auth::guard('admin')->user()->store_id,
            'oracle_short_code'    => $invoiceLineData['oracle_short_code'],
            'weight'               => $invoiceLineData['weight'],
            'price'                => $invoiceLineData['price'],
            'discount_rate'        => $invoiceLineData['discount_rate'],
            'price_after_discount' => (floatval($invoiceLineData['price']) - ((floatval($invoiceLineData['price']) * floatval($invoiceLineData['discount_rate'])) / 100)),
            'quantity'             => $invoiceLineData['quantity'],
            'flag'                 => $invoiceLineData['flag'],
        ]);
    }

    public function getInvoiceLines($invoice_id)
    {
        return PurchaseInvoiceLines::where('purchase_invoice_id', $invoice_id)->get();
    }


    public function getAllData($inputData)
    {

        $country = PurchaseInvoiceLines::leftJoin('products', function ($join) {
            $join->on('products.oracle_short_code', '=', 'purchase_invoice_lines.oracle_short_code');
        })->select('purchase_invoice_lines.*', 'products.full_name')->with('Company')->orderBy('purchase_invoice_lines.created_at', 'desc')->where('purchase_invoice_lines.admin_id', Auth::guard('admin')->user()->id);

        if (isset($inputData['name'])) {
            $country->where('purchase_invoice_lines.id', $inputData['name']);
        }
        if (isset($inputData['store_id'])) {
            $country->where('purchase_invoice_lines.store_id', $inputData['store_id']);
        }
        if (isset($inputData['product_name'])) {
            $country->where('products.full_name', 'like', '%' . $inputData['product_name'] . '%');
        }
        if (isset($inputData['product_code'])) {
            $country->where('purchase_invoice_lines.oracle_short_code', 'like', '%' . $inputData['product_code'] . '%');
        }

        if (isset($inputData['from_date']) && isset($inputData['to_date'])) {
            $country->whereBetween('purchase_invoice_lines.created_at', [$inputData['from_date'], $inputData['to_date']]);
        }

        return $country->paginate($this->defaultLimit);
    }

}
