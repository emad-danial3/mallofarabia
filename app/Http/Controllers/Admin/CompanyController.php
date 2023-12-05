<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\company\changeStatus;
use App\Http\Requests\CompanyRequest;
use App\Http\Services\CompanyService;
use App\Models\Company;

class CompanyController extends HomeController
{
    private $CompanyService;

    public function __construct(CompanyService $CompanyService)
    {
        $this->CompanyService = $CompanyService;
    }

    public function index()
    {
        $data = $this->CompanyService->getAll();
        return view('AdminPanel.PagesContent.Companies.index')->with('companies',$data);
    }

    public function create()
    {
        return view('AdminPanel.PagesContent.Companies.edit');
    }

    public function store(CompanyRequest $request)
    {
        $validated = $request->validated();
        $this->CompanyService->createRow($validated);
        return redirect()->route('companies.index')->with('message','Company Category Created Successfully');
    }

    public function show(Company $company)
    {

    }

    public function edit(Company $company)
    {
        return view('AdminPanel.PagesContent.Companies.edit')->with('company', $company);
    }

    public function update(CompanyRequest $request,$id)
    {
        $validated = $request->validated();
        $this->CompanyService->updateRow($validated , $id);
        return redirect()->back()->with('message','Company Updated Successfully');
    }

    public function changeStatus(changeStatus $request,$id){

        $validated = $request->validated();
        $this->CompanyService->updateRow($validated , $id);
        $this->CompanyService->updateProducts($validated , $id);
        return redirect()->back()->with('message','Company Updated Successfully');

    }
    public function destroy(Company $company)
    {

    }
}
