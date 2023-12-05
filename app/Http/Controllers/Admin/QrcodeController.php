<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Qrcode\StoreRequest;
use App\Http\Services\QrcodeService;
use Illuminate\Http\Request;

class QrcodeController extends Controller
{
    private $qrcodeService;
    public function __construct(QrcodeService $qrcodeService)
    {
        $this->qrcodeService=$qrcodeService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $qrCodes=$this->qrcodeService->QrcodeRepository->getAll();
        return view('AdminPanel.PagesContent.Qrcodes.index',compact('qrCodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $types=$this->qrcodeService->accountTypeRepository->getAll();
        return view('AdminPanel.PagesContent.Qrcodes.form',compact('types'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        //


        $validated=$request->validated();



        $data=$this->qrcodeService->QrcodeRepository->create($validated);
        if ($data['status'] === "error")
            return redirect()->back()->withErrors(['error' => $data['message']]);

        return redirect()->route('qrCodes.index')->with('message','code Created Successfully');

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
    public function edit($id)
    {
        //
        $code=$this->qrcodeService->QrcodeRepository->find($id);
        if ($code){
            $types=$this->qrcodeService->accountTypeRepository->getAll();
            return view('AdminPanel.PagesContent.Qrcodes.form',compact('types','code'));
        }

        return redirect()->back()->withErrors(['error' => "id not found"]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, $id)
    {
        //
        $validated=$request->validated();
        $data=$this->qrcodeService->QrcodeRepository->update($validated,$id);
        if ($data)
            return redirect()->route('qrCodes.index')->with('message','code Created Successfully');

        return redirect()->back()->withErrors(['error' => $data['data']]);


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

    public function changeCodeStatus(Request $request){

        $id=$request->input('id');
        $data=$this->qrcodeService->QrcodeRepository->update($request->only('is_available'),$id);

        return redirect()->route('qrCodes.index')->with('message','code updated Successfully');

    }
}
