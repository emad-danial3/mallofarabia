<?php

namespace App\Exports;

use App\Constants\OrderStatus;
use App\Models\OrderHeader;
use App\Models\OrderLine;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesReportSheetExport implements FromCollection, WithHeadings
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

        $productsReport = DB::table('order_headers')
            ->leftJoin('order_lines', 'order_headers.id', '=', 'order_lines.order_id')
            ->leftJoin('products', 'products.id', '=', 'order_lines.product_id')
            ->select('order_lines.product_id', 'products.oracle_short_code', 'products.name_en', DB::raw("sum(order_lines.quantity) AS  total_quantity"), DB::raw("sum(order_lines.price*order_lines.quantity) AS  total_sales"), 'order_headers.created_at')
            ->where('order_headers.id', '>', 0)
            ->whereNotNull('order_lines.product_id');
        $productsReport = $productsReport->whereBetween('order_headers.created_at', [$this->start_date, $this->end_date]);
        $productsReport = $productsReport->groupBy('order_lines.product_id')->orderBy('total_quantity', 'desc')->get();

        return $productsReport;
    }

    public function headings(): array
    {
        return ["Product ID", "Product Code	", "Product Name", "Total Quantity", "Total Sales", "Date"];
    }
}
