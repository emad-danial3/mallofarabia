<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VoucherRequest;
use App\Http\Requests\VoucherUpdateRequest;
use App\Http\Services\VoucherService;
use Illuminate\Http\Request;
use Khaleds\Voucher\Models\Voucher;

class VouchersController extends Controller
{
    private $voucherService;

    public function __construct(VoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }

    public function index()
    {

        $data = $this->voucherService->getAll();
        return view('AdminPanel.PagesContent.Vouchers.index')->with('vouchers',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('AdminPanel.PagesContent.Vouchers.edit');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VoucherRequest $request)
    {
        //
        $validated = $request->validated();
        $this->voucherService->createRow($validated);
        return redirect()->route('vouchers.index')->with('message','Voucher  Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Voucher $voucher)
    {
        //

        return view('AdminPanel.PagesContent.Vouchers.edit',compact('voucher'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VoucherUpdateRequest $request, $id)
    {
        //
        $validated = $request->validated();
        $this->voucherService->updateRow($validated,$id);
        return redirect()->route('vouchers.index')->with('message','Voucher  Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
