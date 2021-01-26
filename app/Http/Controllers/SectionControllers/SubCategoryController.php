<?php

namespace App\Http\Controllers\SectionControllers;

use App\Category;
use App\Http\Requests\Portal\SubcategoryRequest;
use App\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class SubCategoryController extends Controller
{
    public function index()
    {
        if(request()->page){
            $subcategories = Category::sortable()->where('parent_id', '!=' , null)->orderBy('created_at', 'desc')->paginate(10);
        }else if(request()->has('status')){
            $status = request()->input('status');

            if($status == 0 || $status == 1)
                $subcategories = Category::where('parent_id', '!=', null)->whereStatus($status)->get();
            else
                $subcategories = Category::where('parent_id', '!=', null)->get();
        }else{
            $subcategories = Category::orderBy('priority')->where('parent_id', '!=' , null)->get();
        }
        return response()->json($subcategories);
    }

    public function store(SubcategoryRequest $request)
    {
        $subcategory = Category::make($request->all());
        $subcategory->icon = $request->input('image');
        $subcategory->save();
        $this->setOrder($subcategory);
       return response()->json(['message' => 'SubCategory was successfully added']);
    }
    public function show(Category $subcategory)
    {
        $subcategory->load(['Parent']);

        return response()->json($subcategory);
    }
    public function update(SubcategoryRequest $request, Category $subcategory)
    {
        $subcategory->fill($request->all());
        $subcategory->icon = $request->input('image');
        $subcategory->save();
       return response()->json(['message' => 'SubCategory was successfully updated']);
    }

    public function toggleActive(Category $subcategory)
    {
        $subcategory->status == 1 ?  $subcategory->status = 0 : $subcategory->status = 1;
        $subcategory->save();
       return response()->json(['message' => 'Status was successfully updated']);
    }
    public function destroy(Category $subcategory)
    {
        $subcategory->delete();
        session()->flash('success', 'SubCategory was deleted successfully');
       return response()->json(['message' => 'SubCategory was successfully deleted']);
    }
    public function changeOrder(Category $subcategory, $status){

        if ($status == 'up')
        {
            //Check if not first element
            if ($subcategory->priority == 1)
            {
                session()->flash('error', 'لا يمكن ان تجعل هذا المحتوى ترتيبه الأول وهو اﻷول');
                return redirect()->back();
            }
            //Get Next Element
            $next_slider = Category::where('priority', $subcategory->priority - 1)->where('parent_id', '!=' , null)->first();
            $subcategory->priority =$subcategory->priority  - 1;
            $next_slider->priority = $next_slider->priority + 1;
            $subcategory->save();
            $next_slider->save();

        } elseif ($status == 'down') {
            //Check if not last Element
            if ($subcategory->subcategoryID == (Category::orderBy('subcategoryID','desc')->where('parent_id', '!=' , null)->first()->subcategoryID)) {
                session()->flash('error', 'لا يمكن ان تجعل هذا المحتوى ترتيبه اﻷخير وهو اﻷخير');
                return redirect()->back();
            }
            //Get Next Element
            $next_slider = Category::where('priority', $subcategory->priority + 1)->where('parent_id', '!=' , null)->first();
            $subcategory->priority = $subcategory->priority + 1;
            $next_slider->priority = $next_slider->priority - 1;
            $subcategory->save();
            $next_slider->save();
        } else {
            session()->flash('error', 'Method not correct');
            return redirect()->back();
        }
        session()->flash('success', 'تم تغيير الترتيب بنجاح');
        return redirect()->back();
    }



    public function setOrder(Category $subcategory){
        $last_element = Category::where('parent_id', '!=' , null)->orderBy('priority', 'desc')->first();
        $subcategory->priority = (count($last_element) > 0) ? $last_element->priority + 1 : 1;
        $subcategory->save();
    }

    public function reorderSliderItems($priority){

        $subcategories = Category::where('parent_id', '!=' , null)->where('priority','>', $priority)->get();
        foreach ($subcategories as $subcategory){
            $subcategory->priority -= 1;
            $subcategory->save();
        }
    }
}
