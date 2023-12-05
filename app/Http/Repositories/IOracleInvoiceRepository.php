<?php

namespace App\Http\Repositories;

use App\Models\OracleInvoices;
use App\Models\OrderHeader;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\returnArgument;

class IOracleInvoiceRepository extends BaseRepository implements OracleInvoiceRepository
{
    public function __construct(OracleInvoices $model)
    {
        parent::__construct($model);
    }

    public function updateOrCreate($invoice)
    {
        if (isset($invoice->oracle_invoice_number))
            return (OracleInvoices::where('oracle_invoice_number', $invoice->oracle_invoice_number)->count()) ? OracleInvoices::where('oracle_invoice_number', $invoice->oracle_invoice_number)->update([
                "web_order_number" => $invoice->web_order_number,
                "order_amount"     => $invoice->order_amount,
                "actual_amount"    => $invoice->actual_amount,
            ]) : OracleInvoices::create([
                "oracle_invoice_number" => $invoice->oracle_invoice_number,
                "web_order_number"      => $invoice->web_order_number,
                "order_amount"          => $invoice->order_amount,
                "actual_amount"         => $invoice->actual_amount,
            ]);
    }

    public function updateInvoices()
    {
        $invices = OracleInvoices::select('order_headers.id as Order_ID', 'oracle_invoices.web_order_number', 'oracle_invoices.oracle_invoice_number', 'order_headers.payment_code', 'order_headers.wallet_status', DB::raw("(order_headers.total_order - order_headers.shipping_amount) as total_order "), 'oracle_invoices.order_amount', 'oracle_invoices.actual_amount', 'order_headers.created_at', DB::raw("(SELECT SUM(oracle_invoices.actual_amount) FROM oracle_invoices WHERE oracle_invoices.web_order_number in(SELECT DISTINCT order_lines.oracle_num FROM order_lines  LEFT JOIN products  on(order_lines.product_id = products.id) WHERE order_lines.order_id=order_headers.id AND products.flag IN (5,7,9,23))) AS  total_order_in_oracle"), DB::raw("(SELECT SUM(order_lines.price * quantity) FROM order_lines WHERE order_lines.oracle_num in(SELECT DISTINCT order_lines.oracle_num FROM order_lines LEFT JOIN oracle_invoices on(order_lines.oracle_num = oracle_invoices.web_order_number) LEFT JOIN products  on(order_lines.product_id = products.id) WHERE order_lines.order_id=order_headers.id AND oracle_invoices.web_order_number IS NULL AND products.flag NOT IN (5,7,9,23) )) AS  total_order_out_oracle"))
            ->leftJoin('order_lines', 'order_lines.oracle_num', '=', 'oracle_invoices.web_order_number')
            ->leftJoin('order_headers', 'order_lines.order_id', '=', 'order_headers.id')
            ->where('order_headers.id', '>', '0')->distinct('oracle_invoices.oracle_invoice_number')->orderBy('order_headers.id', 'DESC');
        $invices = $invices->get();
        foreach ($invices as $invice) {

            if (isset($invice) && isset($invice->web_order_number) && isset($invice->oracle_invoice_number)) {
                $orinvice = OracleInvoices::where('web_order_number', $invice->web_order_number)->where('oracle_invoice_number', $invice->oracle_invoice_number)->first();
                if (!empty($orinvice)) {
                    if ((($invice->total_order - ($invice->total_order_in_oracle + $invice->total_order_out_oracle)) >= -1) && (($invice->total_order - ($invice->total_order_in_oracle + $invice->total_order_out_oracle)) <= 2)) {
                        $check_valid = 'valid';
                    }
                    else {
                        $check_valid = 'notvalid';
                    }
                    $newData = [
                        "total_order_in_oracle"  => $invice->total_order_in_oracle,
                        "total_order_out_oracle" => $invice->total_order_out_oracle,
                        "check_valid"            => $check_valid,
                    ];
                    $orinvice->update($newData);
                }
            }
        }

        return true;
    }

    public function getAllData($inputData)
    {
        $invices = OracleInvoices::select('order_headers.id as Order_ID', 'oracle_invoices.web_order_number', 'oracle_invoices.oracle_invoice_number', DB::raw("(order_headers.total_order - order_headers.shipping_amount) as total_order "), 'order_headers.payment_code', 'order_headers.wallet_status', 'oracle_invoices.order_amount', 'oracle_invoices.actual_amount', 'order_headers.created_at', DB::raw("(SELECT SUM(oracle_invoices.actual_amount) FROM oracle_invoices WHERE oracle_invoices.web_order_number in(SELECT DISTINCT order_lines.oracle_num FROM order_lines  LEFT JOIN products  on(order_lines.product_id = products.id) WHERE order_lines.order_id=order_headers.id AND products.flag IN (5,7,9,23))) AS  total_order_in_oracle"), DB::raw("(SELECT SUM(order_lines.price * quantity) FROM order_lines WHERE order_lines.oracle_num in(SELECT DISTINCT order_lines.oracle_num FROM order_lines LEFT JOIN oracle_invoices on(order_lines.oracle_num = oracle_invoices.web_order_number) LEFT JOIN products  on(order_lines.product_id = products.id) WHERE order_lines.order_id=order_headers.id AND oracle_invoices.web_order_number IS NULL AND products.flag NOT IN (5,7,9,23) )) AS  total_order_out_oracle"), DB::raw("((IF((order_headers.total_order - order_headers.shipping_amount) > 0,(order_headers.total_order - order_headers.shipping_amount),0)) -  ((IF(total_order_in_oracle > 0,total_order_in_oracle,0)) + (IF(total_order_out_oracle > 0,total_order_out_oracle,0)))) as total_4u_min_oracle"))
            ->leftJoin('order_lines', 'order_lines.oracle_num', '=', 'oracle_invoices.web_order_number')
            ->leftJoin('order_headers', 'order_lines.order_id', '=', 'order_headers.id')
            ->where('order_headers.id', '>', '0')->distinct('oracle_invoices.oracle_invoice_number')->orderBy('order_headers.id', 'DESC');
        if (Auth::guard('admin')->user()->id == 24) {
            $invices->where('order_headers.is_printed', '0');
            $invices->havingRaw("total_4u_min_oracle > -1 AND total_4u_min_oracle < 2");
        }
        if (isset($inputData['Order_ID']) && $inputData['Order_ID'] != '') {
            $invices->where('order_headers.id', $inputData['Order_ID']);
        }
        if (isset($inputData['Order_ID']) && $inputData['Order_ID'] != '') {
            $invices->where('order_headers.id', $inputData['Order_ID']);
        }
        if (isset($inputData['wallet_status']) && $inputData['wallet_status'] != '') {
            $invices->where('order_headers.wallet_status', $inputData['wallet_status']);
        }
        if (isset($inputData['check_valid']) && $inputData['check_valid'] != '') {
            $invices->where('oracle_invoices.check_valid', $inputData['check_valid'])->where('oracle_invoices.actual_amount', '>', 0);
        }
        if (isset($inputData['web_order_number']) && $inputData['web_order_number'] != '') {
            $invices->where('oracle_invoices.web_order_number', $inputData['web_order_number']);
        }
        if (isset($inputData['oracle_invoice_number']) && $inputData['oracle_invoice_number'] != '') {
            $invices->where('oracle_invoices.oracle_invoice_number', $inputData['oracle_invoice_number']);
        }
        if (isset($inputData['start_date']) && $inputData['start_date'] != '') {
            $invices->where('order_headers.created_at', '>=', $inputData['start_date']);
        }
        if (isset($inputData['end_date']) && $inputData['end_date'] != '') {
            $invices->where('order_headers.created_at', '<=', $inputData['end_date']);
        }
        $invices = $invices->paginate($this->defaultLimit);
        return $invices;
    }

    public function getOrdersNotSentToOracle()
    {
        return OrderHeader::where(function ($query) {
//            $query->where('payment_status', 'PAID')->orWhere('wallet_status', 'cash');
            $query->where('payment_status', 'PAID')->where('wallet_status', 'only_fawry');
        })->where('user_id', '!=', '1')->where('send_t_o', '0')->where('created_at', '>', Carbon::now()->subDays(2))->pluck('id')->count();
    }

    public function ordersCountSentToOracleNotReturn()
    {
        return OrderHeader::leftJoin('order_lines', 'order_lines.order_id', '=', 'order_headers.id')
                ->leftJoin('products', 'products.id', '=', 'order_lines.product_id')
                ->leftJoin('oracle_invoices', 'oracle_invoices.web_order_number', '=', 'order_lines.oracle_num')
                ->whereIn('products.flag', [5,7,9,23])
                ->where('order_headers.send_t_o', '1')->where('order_headers.user_id','!=', '1')->whereNotNull('order_headers.id')->whereNull('oracle_invoices.id')
                ->where('order_headers.created_at', '>', Carbon::parse('1-08-2023'))
                ->groupBy('order_headers.id')->where('order_headers.order_status','!=', 'Cancelled')
                ->pluck('order_headers.id')->count();
    }

    public function insertProductsNotExist()
    {
        $products = DB::table('oracle_products')
            ->leftJoin('products', function ($join) {
                $join->on('oracle_products.item_code', '=', 'products.oracle_short_code');
            })->whereIn('oracle_products.company_name', ['Cosmetics', 'Food', 'MoreByEva'])->whereNull('products.id')->select('oracle_products.*')->get();
        foreach ($products as $product) {
            $newData = [
                "full_name"            => $product->description,
                "flag"                 => $product->company_name == 'Cosmetics' ? 5 : 9,
                "name_ar"              => $product->description,
                "name_en"              => $product->description,
                "price"                => $product->cust_price,
                "tax"                  => $product->percentage_rate,
                "discount_rate"        => $product->discount_rate,
                "excluder_flag"        => $product->excluder_flag,
                "price_after_discount" => $product->cust_price - (($product->cust_price * $product->discount_rate) / 100),
                "quantity"             => $product->quantity,
                "description_ar"       => $product->description,
                "description_en"       => $product->description,
                "oracle_short_code"    => $product->item_code,
                "image"                => '',
                "filter_id"            => 1,
                "old_price"            => $product->cust_price,
                "old_discount"         => 0,
            ];

            Product::create($newData);
        }

        return true;
    }

    public function truncateModel()
    {
        return OracleInvoices::truncate();
    }

}
