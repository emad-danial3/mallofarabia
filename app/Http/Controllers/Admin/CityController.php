<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UpdateCitiesRequest;
use App\Http\Services\CityService;
use App\Http\Services\CountryService;
use App\Models\City;

class CityController extends HomeController
{
    private  $CityService;
    private  $CountriesService;

    public function __construct(CityService $CityService , CountryService $CountriesService)
    {
        $this->CityService      = $CityService;
        $this->CountriesService = $CountriesService;
    }

    public function index()
    {
        $cities = $this->CityService->getAllCities(request()->all());
        return view('AdminPanel.PagesContent.Cities.index')->with('cities',$cities);
    }

    public function create()
    {
        $countries = $this->CountriesService->getAllCountriesWithOutPagination();
        return view('AdminPanel.PagesContent.Cities.edit',compact('countries'));
    }

    public function store(UpdateCitiesRequest $request)
    {
        $validated = $request->validated();
        $this->CityService->createCityRow($validated);
        return redirect()->route('cities.index')->with('message','City Created Successfully');
    }

    public function show(City $city)
    {

    }

    public function edit(City $city)
    {
        $countries = $this->CountriesService->getAllCountriesWithOutPagination();
        return view('AdminPanel.PagesContent.Cities.edit',compact('city', 'countries'));
    }

    public function update(UpdateCitiesRequest $request,$id)
    {
        $validated = $request->validated();
        $this->CityService->updateCityRow($validated , $id);
        return redirect()->back()->with('message','City Updated Successfully');
    }

    public function destroy(City  $city)
    {

    }
}
