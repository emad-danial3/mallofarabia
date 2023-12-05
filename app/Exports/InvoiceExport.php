<?php

namespace App\Exports;

use App\Models\OracleInvoices;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvoiceExport implements FromCollection, WithHeadings
{
    private $start_date;
    private $end_date;

    public function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date   = $end_date;
    }

    public function collection()
    {
        $invices = OracleInvoices::select('order_headers.id as Order_ID', 'oracle_invoices.web_order_number', 'oracle_invoices.oracle_invoice_number', 'order_headers.wallet_status', 'order_headers.payment_code',DB::raw("(order_headers.total_order - order_headers.shipping_amount) as total_order "), 'oracle_invoices.order_amount', 'oracle_invoices.actual_amount',DB::raw("(SELECT SUM(oracle_invoices.actual_amount) FROM oracle_invoices WHERE oracle_invoices.web_order_number in(SELECT DISTINCT order_lines.oracle_num FROM order_lines  LEFT JOIN products  on(order_lines.product_id = products.id) WHERE order_lines.order_id=order_headers.id AND products.flag IN (5,7,9,23))) AS  total_order_in_oracle"),DB::raw("(SELECT SUM(order_lines.price * quantity) FROM order_lines WHERE order_lines.oracle_num in(SELECT DISTINCT order_lines.oracle_num FROM order_lines LEFT JOIN oracle_invoices on(order_lines.oracle_num = oracle_invoices.web_order_number) LEFT JOIN products  on(order_lines.product_id = products.id) WHERE order_lines.order_id=order_headers.id AND oracle_invoices.web_order_number IS NULL AND products.flag NOT IN (5,7,9,23) )) AS  total_order_out_oracle"), 'order_headers.created_at')
            ->leftJoin('order_lines', 'order_lines.oracle_num', '=', 'oracle_invoices.web_order_number')
            ->leftJoin('order_headers', 'order_lines.order_id', '=', 'order_headers.id')
            ->where('order_headers.id', '>', '0')->distinct('oracle_invoices.oracle_invoice_number')->orderBy('order_headers.id', 'DESC')
            ->whereBetween('order_headers.created_at', [$this->start_date, $this->end_date])->get();
        return $invices;
    }

    public function headings(): array
    {
        return ["Order ID 4U", "Invoice Number 4U", "Invoice Oracle Number", "Payment Type", "Payment Code", "Total Order 4U", "Total Oracle Amount", "Total Oracle Actual Amount", "General Total Oracle", "Total Order Out Oracle", "Created At"];
    }
}
