<?php

namespace App\Http\Controllers\Admin;


use App\Constants\OrderTypes;
use App\Exports\OrdersExport;
use App\Exports\SalesReportSheetExport;
use App\Http\Repositories\IUserRepository;
use App\Http\Requests\ExportShippingSheetSheetRequest;
use App\Http\Services\CartService;
use App\Http\Services\OrderService;
use App\Http\Services\PaidOrderActions\SingleOrderPaidActions;
use App\Http\Services\UserService;

use App\Models\Admin;
use App\Models\OrderHeader;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Services\OrderLinesService;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use \Illuminate\Support\Facades\Auth;


class ReportsController extends HomeController
{
    private   $OrderHeaderService;
    protected $CartService;
    protected $OrderRequest;
    protected $UserService;

    public function __construct(OrderService $OrderHeaderService, IUserRepository $UserRepository, OrderLinesService $OrderLinesService, Request $OrderRequest, CartService $CartService, UserService $UserService)
    {
        $this->OrderHeaderService = $OrderHeaderService;
        $this->OrderRequest       = $OrderRequest;
        $this->CartService        = $CartService;
        $this->UserRepository     = $UserRepository;
        $this->UserService        = $UserService;
        $this->OrderLinesService  = $OrderLinesService;

    }

    public function index()
    {
        $data = $this->OrderHeaderService->getAll(request()->all());
        return view('AdminPanel.PagesContent.OrderHeaders.index')->with('orderHeaders', $data);
    }

    public function report(Request $request)
    {
        $date_to               = $request->date_to;
        $date_from             = $request->date_from;
        $ordersSalesTotalsCash = null;
        $ordersSalesTotalVisa  = null;
        if ((isset($date_to) && $date_to != '') && (isset($date_from) && $date_from != '')) {
            $ordersSalesTotalsCash = DB::table('order_headers')
                ->where('payment_status', 'PAID')->where('wallet_status', 'cash')->where('store_id', '1')
                ->whereBetween('created_at', [$date_from, $date_to])->sum('total_order');
            $ordersSalesTotalVisa  = DB::table('order_headers')
                ->where('payment_status', 'PAID')->where('wallet_status', 'visa')->where('store_id', '1')
                ->whereBetween('created_at', [$date_from, $date_to])->sum('total_order');
        }
        return view('AdminPanel.PagesContent.Reports.report', compact('ordersSalesTotalsCash', 'ordersSalesTotalVisa', 'date_to', 'date_from'));

    }

    public function todayreport(Request $request)
    {
        $date_from = $request->date_from;
        $admin_id  = $request->admin_id;
        if (!$date_from) {
            $date_from = Carbon::now()->startOfDay()->toDateTimeString();
            $date_to   = Carbon::now()->endOfDay()->toDateTimeString();
        }
        else {
            $date_from = Carbon::parse($date_from)->startOfDay()->toDateTimeString();
            $date_to   = Carbon::parse($date_from)->endOfDay()->toDateTimeString();;
        }
        $ordersSalesTotalsCash = null;
        $ordersSalesTotalVisa  = null;
        if ((isset($date_to) && $date_to != '') && (isset($date_from) && $date_from != '')) {
            $ordersSalesTotalsCash = DB::table('order_headers')
                ->where('payment_status', 'PAID')->where('wallet_status', 'cash')->where('store_id', Auth::guard('admin')->user()->store_id)->where('admin_id', isset($admin_id)&&$admin_id >0?$admin_id:Auth::guard('admin')->user()->id)
                ->whereBetween('created_at', [$date_from, $date_to])->sum('total_order');
            $ordersSalesTotalVisa  = DB::table('order_headers')
                ->where('payment_status', 'PAID')->where('wallet_status', 'visa')->where('store_id', Auth::guard('admin')->user()->store_id)->where('admin_id', isset($admin_id)&&$admin_id >0?$admin_id:Auth::guard('admin')->user()->id)
                ->whereBetween('created_at', [$date_from, $date_to])->sum('total_order');
        }
        $Admins = Admin::whereNotIn('role',['super_admin','store_manager'])->where('store_id',Auth::guard('admin')->user()->store_id)->get();
        return view('AdminPanel.PagesContent.Reports.todayreport', compact('ordersSalesTotalsCash', 'ordersSalesTotalVisa', 'date_to', 'date_from', 'Admins'));

    }

    public function logout(Request $request)
    {
        $date_from = $request->date_from;
        $admin_id  = $request->admin_id;
        if (!$date_from) {
            $date_from = Carbon::now()->startOfDay()->toDateTimeString();
            $date_to   = Carbon::now()->endOfDay()->toDateTimeString();
        }
        else {
            $date_from = Carbon::parse($date_from)->startOfDay()->toDateTimeString();
            $date_to   = Carbon::parse($date_from)->endOfDay()->toDateTimeString();;
        }
        $ordersSalesTotalsCash = null;
        $ordersSalesTotalVisa  = null;
        if ((isset($date_to) && $date_to != '') && (isset($date_from) && $date_from != '')) {
            $ordersSalesTotalsCash = DB::table('order_headers')
                ->where('payment_status', 'PAID')->where('wallet_status', 'cash')->where('store_id', Auth::guard('admin')->user()->store_id)->where('admin_id', isset($admin_id)&&$admin_id >0?$admin_id:Auth::guard('admin')->user()->id)
                ->whereBetween('created_at', [$date_from, $date_to])->sum('total_order');
            $ordersSalesTotalVisa  = DB::table('order_headers')
                ->where('payment_status', 'PAID')->where('wallet_status', 'visa')->where('store_id', Auth::guard('admin')->user()->store_id)->where('admin_id', isset($admin_id)&&$admin_id >0?$admin_id:Auth::guard('admin')->user()->id)
                ->whereBetween('created_at', [$date_from, $date_to])->sum('total_order');
            $ordersSalesTotalsCashCount = DB::table('order_headers')
                ->where('payment_status', 'PAID')->where('wallet_status', 'cash')->where('store_id', Auth::guard('admin')->user()->store_id)->where('admin_id', isset($admin_id)&&$admin_id >0?$admin_id:Auth::guard('admin')->user()->id)
                ->whereBetween('created_at', [$date_from, $date_to])->count('id');
            $ordersSalesTotalVisaCount  = DB::table('order_headers')
                ->where('payment_status', 'PAID')->where('wallet_status', 'visa')->where('store_id', Auth::guard('admin')->user()->store_id)->where('admin_id', isset($admin_id)&&$admin_id >0?$admin_id:Auth::guard('admin')->user()->id)
                ->whereBetween('created_at', [$date_from, $date_to])->count('id');
        }

        $admin=Auth::guard('admin')->user()->name;
        $total=$ordersSalesTotalsCash+$ordersSalesTotalVisa;
        $totalcount=$ordersSalesTotalsCashCount+$ordersSalesTotalVisaCount;

        return view('AdminPanel.PagesContent.Reports.logout', compact('ordersSalesTotalsCash', 'ordersSalesTotalVisa','ordersSalesTotalsCashCount', 'ordersSalesTotalVisaCount', 'date_to', 'date_from','admin','total','totalcount'));

    }

    public function reports(Request $request)
    {
        $date_to        = $request->date_to;
        $date_from      = $request->date_from;
        $id             = $request->name;
        $product_name   = $request->product_name;
        $product_code   = $request->product_code;
        $productsReport = DB::table('order_headers')
            ->leftJoin('order_lines', 'order_headers.id', '=', 'order_lines.order_id')
            ->leftJoin('products', 'products.id', '=', 'order_lines.product_id')
            ->select('order_headers.id', 'order_lines.product_id', DB::raw("sum(order_lines.quantity) AS  total_quantity"), DB::raw("sum(order_lines.price*order_lines.quantity) AS  total_sales"), 'products.oracle_short_code', 'products.name_en', 'products.full_name', 'order_headers.created_at')
            ->where('order_headers.id', '>', 0)
            ->whereNotNull('order_lines.product_id');

        if (isset($id)) {
            $productsReport->where('products.id', $id);
        }
        if (isset($product_name)) {
            $productsReport->where('products.full_name', 'like', '%' . $product_name . '%');
        }
        if (isset($product_code)) {
            $productsReport->where('products.oracle_short_code', 'like', '%' . $product_code . '%');
        }
        if ((isset($date_to) && $date_to != '') && (isset($date_from) && $date_from != '')) {
            $productsReport = $productsReport->whereBetween('order_headers.created_at', [$date_from, $date_to]);
        }
        $productsReport = $productsReport->groupBy('order_lines.product_id')
            ->orderBy('total_quantity', 'desc')
            ->paginate(30);
        return view('AdminPanel.PagesContent.Reports.reports', compact('productsReport', 'date_to', 'date_from'));
    }

    public function active_members(Request $request)
    {
        $date_from = $request->date_from;
        $date_to   = $request->date_to;
        if (!$date_to || !$date_from) {
            $date_from = Carbon::now()->startOfMonth()->toDateTimeString();
            $date_to   = Carbon::now()->endOfMonth()->toDateTimeString();
        }
        $productsReport = DB::table('users')
            ->leftJoin('order_headers', 'order_headers.user_id', '=', 'users.id')
            ->select('users.id', 'users.phone', 'users.email', 'users.full_name', 'order_headers.created_at', DB::raw("(SELECT SUM(order_headers.total_order) FROM order_headers WHERE order_headers.user_id = users.id AND order_headers.payment_status = 'PAID' AND   order_headers.created_at BETWEEN '{$date_from}' AND '{$date_to}'  ) AS  total_sales"))
            ->where('order_headers.id', '>', 0)
            ->groupBy('users.id')
            ->having('total_sales', '>', 250);
        if ((isset($date_to) && $date_to != '') && (isset($date_from) && $date_from != '')) {
            $productsReport = $productsReport->whereBetween('order_headers.created_at', [$date_from, $date_to]);
        }
        $productsReport = $productsReport->orderBy('total_sales', 'desc')->paginate(30);

        return view('AdminPanel.PagesContent.Reports.active_members', compact('productsReport', 'date_to', 'date_from'));
    }

    public function export(ExportShippingSheetSheetRequest $request)
    {
        $validated = $request->validated();
        try {
            return Excel::download(new SalesReportSheetExport($validated['start_date'], $validated['end_date']), 'salesreport.xlsx');
        }
        catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }


}
