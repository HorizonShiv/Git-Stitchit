<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Models\BrandMaster;
use Illuminate\Http\Request;
use App\Models\StyleCategory;
use App\Models\StyleSubCategory;
use App\Http\Controllers\apps\Master;

class StyleCategoryController extends Controller
{
  public function index()
  {
    // desc
    $StyleCategorys = StyleCategory::with("StyleSubCategory")->orderBy('id', 'asc')->get();
    return view('content.style-category-master.list', compact("StyleCategorys"));
  }

  public function create()
  {
    return view('content.style-category-master.create');
  }

  public function store(Request $request)
  {
    $this->validate(request(), [
      'categoryName' => 'required',
      'SubCategoryName' => 'required|array',
    ]);

    $StyleCategory = new StyleCategory([
      'name' => $request->categoryName,
    ]);

    if ($StyleCategory->save()) {
      $subCategoryNames = $request->SubCategoryName;
      $subCategoryCount = 1;
      if (!empty($subCategoryNames[0])) {
        foreach ($subCategoryNames as $subCategoryName) {
          $subCategory = new StyleSubCategory([
            'style_category_id' => $StyleCategory->id,
            'name' => $subCategoryName,
            'subcategory_counter' => $subCategoryCount,
          ]);
          $subCategory->save();
          $subCategoryCount++;
        }
      }
      if ($request->AddMore) {
        return redirect()->action([StyleCategoryController::class, 'create'])->withSuccess('Successfully Done');
      } else {
        return redirect()->action([StyleCategoryController::class, 'index'])->withSuccess('Successfully Done');
      }
    } else {
      return redirect()->action([StyleCategoryController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  public function edit($id)
  {
    $StyleCategorys = StyleCategory::with("StyleSubCategory")->where('id', $id)->get();
    return view('content.style-category-master.edit', compact("StyleCategorys"));
  }


  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $this->validate(request(), [
      'categoryName' => 'required',
    ]);
$counter=1;
    $SubCategoryId = $request->SubCategoryId;
    $SubCategoryCounter = $request->SubCategoryCounter;
    $SubCategoryName = $request->SubCategoryName;

    $NewSubCategoryName = $request->NewSubCategoryName;

    $StyleCategory = StyleCategory::where('id', $id)->update([
      'name' => $request->categoryName,
    ]);

    if ($StyleCategory) {
      if (!empty($SubCategoryId)) {
        for ($i = 0; $i < count($SubCategoryId); $i++) {
          $StyleSubCategory = StyleSubCategory::where('id', $SubCategoryId[$i])
            ->where('style_category_id', $id)
            ->where('subcategory_counter', $SubCategoryCounter[$i])
            ->update([
              'name' => $request->SubCategoryName[$i],
            ]);

          if ($i == (count($SubCategoryId) - 1)) {
            $counter = $SubCategoryCounter[$i] + 1;
          }
        }
      }

      if (!empty($NewSubCategoryName[0])) {
        // print_r($NewSubCategoryName);
        foreach ($NewSubCategoryName as $SubCategory) {
          $subCategory = new StyleSubCategory([
            'style_category_id' => $id,
            'name' => $SubCategory,
            'subcategory_counter' => $counter,
          ]);
          $subCategory->save();
          $counter++;
        }
      }
      // dd(count($NewSubCategoryName));

      return redirect()->action([StyleCategoryController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([StyleCategoryController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  public function delete(Request $request)
  {
    $StyleCategory = StyleCategory::where('id', $request->styleCategoryId)->delete();
    if ($StyleCategory) {
      $StyleSubCategory = StyleSubCategory::where('style_category_id', $request->styleCategoryId)->delete();
      return redirect()->action([StyleCategoryController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([StyleCategoryController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  public function subcategorydelete(Request $request)
  {
    // dd($request);
    $StyleCategoryId = StyleSubCategory::where('id', $request->subCategoryId)->first();

    $StyleSubCategory = StyleSubCategory::where('id', $request->subCategoryId)->delete();

    $StyleCategorys = StyleCategory::with("StyleSubCategory")->where('id', $StyleCategoryId->style_category_id)->get();

    if ($StyleSubCategory) {
      return redirect()->route('style-category-edit', ['id' => $StyleCategoryId->style_category_id])->withSuccess('Successfully Done')->with(compact('StyleCategorys'));
    } else {
      return redirect()->route('style-category-edit', ['id' => $StyleCategoryId->style_category_id])->withSuccess('Successfully Done')->with(compact('StyleCategorys'));
    }
  }
}
