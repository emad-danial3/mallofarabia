<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UpdateCountriesRequest;
use App\Http\Services\CountryService;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends HomeController
{
    private  $CountryService;

    public function __construct(CountryService $CountryService)
    {
        $this->CountryService = $CountryService;
    }

    public function index()
    {
        $countries = $this->CountryService->getAllCountries(request()->all());
        return view('AdminPanel.PagesContent.Countries.index')->with('countries',$countries);
    }

    public function create()
    {
        return view('AdminPanel.PagesContent.Countries.edit');
    }

    public function store(UpdateCountriesRequest $request)
    {
        $validated = $request->validated();
        $this->CountryService->createCountryRow($validated);
        return redirect()->route('countries.index')->with('message','Country Created Successfully');
    }

    public function show(Country $country)
    {

    }

    public function edit(Country $country)
    {
        return view('AdminPanel.PagesContent.Countries.edit')->with('country', $country);
    }

    public function update(UpdateCountriesRequest $request,$id)
    {
        $validated = $request->validated();
        $this->CountryService->updateCountryRow($validated , $id);
        return redirect()->back()->with('message','Country Updated Successfully');
    }

    public function destroy(Country $country)
    {

    }
}
