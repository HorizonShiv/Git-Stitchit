<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Models\BrandMaster;
use Illuminate\Http\Request;
use App\Models\ItemCategory;
use App\Models\ItemSubCategory;
use App\Http\Controllers\apps\Master;

class ItemCategoryController extends Controller
{
  public function index()
  {
    $ItemCategorys = ItemCategory::with("ItemSubCategory")->orderBy('id', 'asc')->get();
    return view('content.item-category-master.list', compact("ItemCategorys"));
  }

  public function create()
  {
    return view('content.item-category-master.create');
  }
  public function store(Request $request)
  {
    $this->validate(request(), [
      'categoryName' => 'required',
      'SubCategoryName' => 'required|array',
    ]);

    $StyleCategory = new ItemCategory([
      'name' => $request->categoryName,
    ]);

    if ($StyleCategory->save()) {

      $subCategoryNames = $request->SubCategoryName;
      $subCategoryCount = 1;
      if (!empty($subCategoryNames[0])) {
        foreach ($subCategoryNames as $subCategoryName) {
          $subCategory = new ItemSubCategory([
            'item_category_id' => $StyleCategory->id,
            'name' => $subCategoryName,
            'subcategory_counter' => $subCategoryCount,
          ]);
          $subCategory->save();
          $subCategoryCount++;
        }
      }

      if ($request->AddMore) {
			return redirect()->action([ItemCategoryController::class, 'create'])->withSuccess('Successfully Done');
      } else {
			return redirect()->action([ItemCategoryController::class, 'index'])->withSuccess('Successfully Done');
      }
    } else {
		return redirect()->action([ItemCategoryController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  public function edit($id)
  {
    $ItemCategorys = ItemCategory::with("ItemSubCategory")->where('id', $id)->get();
    return view('content.item-category-master.edit', compact("ItemCategorys"));
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

    $ItemCategory = ItemCategory::where('id', $id)->update([
      'name' => $request->categoryName,
    ]);

    if ($ItemCategory) {
      if (!empty($SubCategoryId)) {
        for ($i = 0; $i < count($SubCategoryId); $i++) {
          $ItemSubCategory = ItemSubCategory::where('id', $SubCategoryId[$i])
            ->where('item_category_id', $id)
            ->where('subcategory_counter', $SubCategoryCounter[$i])
            ->update([
              'name' => $request->SubCategoryName[$i],
            ]);

          if ($i == (count($SubCategoryId) - 1)) {
            $counter = $SubCategoryCounter[$i] + 1;
          }
        }
      }

      // if ($request->AddItemStatus == 1) {
      if (!empty($NewSubCategoryName[0])) {
        foreach ($NewSubCategoryName as $SubCategory) {
          $subCategory = new ItemSubCategory([
            'item_category_id' => $id,
            'name' => $SubCategory,
            'subcategory_counter' => $counter,
          ]);
          $subCategory->save();
          $counter++;
        }
      }
      return redirect()->action([ItemCategoryController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([ItemCategoryController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }


  public function delete(Request $request)
  {
    $ItemCategory = ItemCategory::where('id', $request->itemCategoryId)->delete();
    if ($ItemCategory) {
      $ItemSubCategory = ItemSubCategory::where('item_category_id', $request->itemCategoryId)->delete();
      return redirect()->action([ItemCategoryController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([ItemCategoryController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }


  public function subcategorydelete(Request $request)
  {
    $ItemCategoryId = ItemSubCategory::where('id', $request->subCategoryId)->first();
    $ItemSubCategory = ItemSubCategory::where('id', $request->subCategoryId)->delete();
    $ItemCategorys = ItemCategory::with("ItemSubCategory")->where('id', $ItemCategoryId->item_category_id)->get();

    if ($ItemSubCategory) {
      return redirect()->route('item-category-edit', ['id' => $ItemCategoryId->item_category_id])->withSuccess('Successfully Done')->with(compact('ItemCategorys'));
    } else {
      return redirect()->route('item-category-edit', ['id' => $ItemCategoryId->item_category_id])->withSuccess('Successfully Done')->with(compact('ItemCategorys'));
    }
  }
}
