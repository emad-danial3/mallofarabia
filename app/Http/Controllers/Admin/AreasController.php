<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UpdateAreasRequest;
use App\Http\Services\AreaService;
use App\Http\Services\CityService;
use App\Models\Area;
use Illuminate\Http\Request;

class AreasController extends HomeController
{

    private  $AreaService;
    private  $CityService;

    public function __construct(AreaService $AreaService, CityService  $CityService)
    {
        $this->AreaService = $AreaService;
        $this->CityService = $CityService;
    }

    public function index()
    {
        $areas = $this->AreaService->getAllAreas(request()->all());
        return view('AdminPanel.PagesContent.Areas.index')->with('areas',$areas);
    }

    public function create()
    {
        $cities = $this->CityService->getAllCitiesWithOutPagination();
        return view('AdminPanel.PagesContent.Areas.edit',compact('cities'));
    }

    public function store(UpdateAreasRequest $request)
    {
        $validated = $request->validated();
        $this->AreaService->createAreaRow($validated);
        return redirect()->route('areas.index')->with('message','Area Created Successfully');
    }

    public function show(Area $area)
    {

    }

    public function edit(Area $area)
    {
        $cities = $this->CityService->getAllCitiesWithOutPagination();
        return view('AdminPanel.PagesContent.Areas.edit',compact('cities','area'));
    }

    public function update(UpdateAreasRequest $request, $id)
    {
        $validated = $request->validated();
        $this->AreaService->updateAreaRow($validated , $id);
        return redirect()->back()->with('message','Area Updated Successfully');
    }

    public function destroy(Area $area)
    {

    }
}
