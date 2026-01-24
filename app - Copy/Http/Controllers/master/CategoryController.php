<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SettingCategory;
use App\Models\SettingSubCategory;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = SettingCategory::where('status', 1)->pluck('name', 'id');
		return response()->json([
				'success' => $success,
				'data' => $category,
				'message' => 'Categories proceed successfully',
			], 200);
    }
	
	public function subCategoriesByCatId(Request $request) {
		
		$validationRules = [
			'cath_id' => 'required|integer',
		];
		$messages = [];
		$this->validate($request, $validationRules, $messages);
		$subcategory = SettingSubCategory::where('status', 1)->where('setting_category_id', $request->cath_id)->pluck('name', 'id');
		return response()->json([
				'success' => true,
				'data' => $subcategory,
				'message' => 'Sub Categories proceed successfully',
			], 200);
		
	}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
