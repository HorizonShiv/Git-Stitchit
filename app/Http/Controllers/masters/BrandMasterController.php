<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
// use App\Models\BrandMaster;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandMasterController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('content.brand-master.list');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('content.brand-master.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $this->validate(request(), [
      'brandName' => 'required',
    ]);

    $CategoryMaster = new Brand([
      'name' => $request->brandName,
    ]);
    if ($CategoryMaster->save()) {
      if($request->AddMore){
        return redirect()->action([BrandMasterController::class, 'create'])->withSuccess('Successfully Done');
      }else{
        return redirect()->action([BrandMasterController::class, 'index'])->withSuccess('Successfully Done');
      }

    } else {
      return redirect()->action([BrandMasterController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Request $request)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $Brand = Brand::where('id', $id)->first();
    return view('content.brand-master.edit', compact("Brand"));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $this->validate(request(), [
      'brandName' => 'required',
    ]);
    $Brand = Brand::where('id', $id)->update([
      'name' => $request->brandName,
    ]);

    if ($Brand) {
      return redirect()->action([BrandMasterController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([BrandMasterController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }
  public function delete(Request $request)
  {
    $Brand = Brand::where('id', $request->brandId)->delete();
    if ($Brand) {
      return redirect()->action([BrandMasterController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([BrandMasterController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request)
  {
    //
  }
}
