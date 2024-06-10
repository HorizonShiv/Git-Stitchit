<?php


namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;

use App\Models\ItemCategory;
use App\Models\ItemSubCategory;
use App\Models\Item;
use App\Models\User;
use App\Models\ParameterConnection;
use App\Models\ParameterMaster;
use Illuminate\Http\Request;
use App\Http\Controllers\apps\Master;

class ItemMaster extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $ItemMaster = Item::with('ItemCategory', 'ItemSubCategory')->orderBy('id', 'asc')->get();

    return view('content.item-master.list', compact('ItemMaster'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    // $UserData = User::where('role', '=', 'vendor')->get();
    $categoryData = ItemCategory::all();
    $SubCategoryData = ItemSubCategory::all();
    $Parameters = ParameterMaster::all();
    return view('content.item-master.create', compact('categoryData', 'SubCategoryData', 'Parameters'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $this->validate(request(), [
      'ItemName' => 'required',
      'Category' => 'required',
      'SubCategory' => 'required',
      'rate' => 'required',
      'GstRate' => 'required',
      'uom' => 'required',
    ]);
    // dd($request->toArray());
    if (!empty($request->issue_as_consume)) {
      $issueConsume = $request->issue_as_consume;
    } else {
      $issueConsume = 0;
    }
    $Item = new Item([
      'name' => $request->ItemName,
      'item_category_id' => $request->Category,
      'item_subcategory_id' => $request->SubCategory,
      'rate' => $request->rate,
      'short_code' => $request->item_short_code,
      'uom' => $request->uom,
      'item_description' => $request->item_description,
      'consume_status' => $issueConsume,
      'gst_rate' => $request->GstRate,
    ]);


    if ($Item->save()) {
      $ItemId = $Item->id;
      if ($request->Photo) {
        $this->validate(request(), [
          'Photo.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        $file = $request->Photo;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/itemPhoto/' . $ItemId . '/');
        if (!is_dir(public_path('/itemPhoto'))) {
          mkdir(public_path('/itemPhoto'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);

        Item::where('id', $ItemId)->update([
          "photo" => $new_file_name,
        ]);
      }

      $parameters = $request->Parameters;

      // dd($request->all());

      if (!empty($parameters)) {

        $parts = explode('_', $parameters);
        $ParameterConnection = new ParameterConnection([
          'item_master_id' => $Item->id,
          'parameter_master_id' => $parts[0],
          'parameter_master_name' => $parts[1],
        ]);
        $PrameterResult = $ParameterConnection->save();
      }

      if ($request->AddMore) {
        return redirect()->action([ItemMaster::class, 'create'])->withSuccess('Successfully Done');
      } else {
        return redirect()->action([ItemMaster::class, 'index'])->withSuccess('Successfully Done');
      }
    } else {
      return redirect()->action([ItemMaster::class, 'index'])->withErrors('Some thing is wrong');
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
  public function edit($id)
  {
    $Item = Item::with('ParameterConnection')->where('id', $id)->first();
    $categoryData = ItemCategory::all();
    $SubCategoryData = ItemSubCategory::all();
    $Parameters = ParameterMaster::all();
    return view('content.item-master.edit', compact('categoryData', 'SubCategoryData', 'Item', 'Parameters'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $this->validate(request(), [
      'ItemName' => 'required',
      'Category' => 'required',
      'SubCategory' => 'required',
      'rate' => 'required',
      'GstRate' => 'required',
    ]);
    if (!empty($request->issue_as_consume)) {
      $issueConsume = $request->issue_as_consume;
    } else {
      $issueConsume = 0;
    }

    $Item = Item::where('id', $id)->update([
      'name' => $request->ItemName,
      'item_category_id' => $request->Category,
      'item_subcategory_id' => $request->SubCategory,
      'rate' => $request->rate,
      'short_code' => $request->item_short_code,
      'item_description' => $request->item_description,
      'consume_status' => $issueConsume,
      'gst_rate' => $request->GstRate,
      'uom' => $request->uom,
    ]);

    $parameters = $request->Parameters;

    // $ParameterConnectionDelete = ParameterConnection::where('item_master_id', $id)->forceDelete();
    // if (!empty($parameters)) {
    //   foreach ($parameters as $parameter) {
    //     $parts = explode('_', $parameter);
    //     $ParameterConnectionAdd = new ParameterConnection([
    //       'item_master_id' => $id,
    //       'parameter_master_id' => $parts[0],
    //       'parameter_master_name' => $parts[1],
    //     ]);
    //     $PrameterResult = $ParameterConnectionAdd->save();
    //   }
    // }
    if (!empty($parameters)) {

      $parts = explode('_', $parameters);
      $ParameterConnection =  ParameterConnection::where('item_master_id', $id)->update([
        'parameter_master_id' => $parts[0],
        'parameter_master_name' => $parts[1],
      ]);
      // $PrameterResult = $ParameterConnection->save();
    }

    if ($Item) {
      if ($request->Photo) {
        $this->validate(request(), [
          'Photo.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        $file = $request->Photo;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/itemPhoto/' . $id . '/');
        if (!is_dir(public_path('/itemPhoto'))) {
          mkdir(public_path('/itemPhoto'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);

        Item::where('id', $id)->update([
          "photo" => $new_file_name,
        ]);
      }
      return redirect()->action([ItemMaster::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([ItemMaster::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  public function delete(Request $request)
  {
    $Item = Item::where('id', $request->itemId)->delete();
    if ($Item) {
      $ParameterConnection = ParameterConnection::where('item_master_id', $request->itemId)->delete();
      return redirect()->action([ItemMaster::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([ItemMaster::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  public function view($id)
  {
    $Item = Item::with('ItemCategory', 'ItemSubCategory', 'ParameterConnection')->where('id', $id)->first();
    return view('content.item-master.view', compact('Item'));
  }


  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
  public function fetchItemData(Request $request)
  {
    // $categoryId = $request->input('categoryId');
    // $subCategories = ItemSubCategory::where('item_category_id', $categoryId)->get();


    $parts = explode('_', $request->item_id);

    $Item = Item::where('id', $parts[0])->first();
    return response()->json($Item);
  }
  public function getSubCategories(Request $request)
  {
    $categoryId = $request->input('categoryId');
    $subCategories = ItemSubCategory::where('item_category_id', $categoryId)->get();

    return response()->json($subCategories);
  }
}
