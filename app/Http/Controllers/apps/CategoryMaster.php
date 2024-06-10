<?php

namespace App\Http\Controllers\apps;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\CategoryMasters;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class CategoryMaster extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
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
    $this->validate(request(), [
      'categoryName' => 'required',
      'SubCategoryName' => 'required|array',
    ]);

    $CategoryMaster = new CategoryMasters([
      'name' => $request->categoryName,
    ]);

    if ($CategoryMaster->save()) {
      $subCategoryNames = $request->SubCategoryName;

      foreach ($subCategoryNames as $subCategoryName) {
        $subCategory = new SubCategory([
          'category_id' => $CategoryMaster->id,
          'name' => $subCategoryName,
        ]);
        $subCategory->save();
      }
      return redirect()->action([Master::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([Master::class, 'index'])->withErrors('Some thing is wrong');
    }
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

  public function CategoryAddView()
  {
    return view('content.apps.app-category-add');
  }
}
