<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FilterRequest;
use App\Http\Services\FilterService;
use App\Libraries\UploadImagesController;
use App\Models\Filter;

use Illuminate\Http\Request;

class FiltersController extends HomeController
{
    private $FilterService;
    private $MediaController;

    public function __construct(UploadImagesController $MediaController,FilterService $FilterService)
    {
        $this->MediaController = $MediaController;
        $this->FilterService = $FilterService;
    }

    public function index()
    {
        $data = $this->FilterService->getAll();
        return view('AdminPanel.PagesContent.Filters.index')->with('filters',$data);
    }

    public function create()
    {
        return view('AdminPanel.PagesContent.Filters.edit');
    }

    public function store(FilterRequest $request)
    {
        $validated = $request->validated();
        $data                     = $request->only('name_en','name_ar','image');
         if (isset($data['image'])) {
            $data['image'] = $this->MediaController->UploadImage($data['image'], 'images/filters');
        }
        $this->FilterService->createRow($data);
        return redirect()->route('filters.index')->with('message','Filter Created Successfully');
    }

    public function show(Filter $filter)
    {

    }

    public function edit(Filter $filter)
    {
        return view('AdminPanel.PagesContent.Filters.edit')->with('filter', $filter);
    }

    public function update(FilterRequest $request,$id)
    {
        $validated = $request->validated();
        $data                     = $request->only('name_en','name_ar','image');
         if (isset($data['image'])) {
            $data['image'] = $this->MediaController->UploadImage($data['image'], 'images/filters');
        }else{
             unset($data['image']);
         }
        $this->FilterService->updateRow($data , $id);
        return redirect()->back()->with('message','Filter Updated Successfully');
    }
        public function destroy(Request $request, $id)
    {

 $delete = Filter::where('id', $id)->delete();
        // check data deleted or not
        if ($delete == 1) {
            $success = true;
            $message = 'delete Success';
        } else {
            $success = true;
            $message = 'delete Error';
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

}
