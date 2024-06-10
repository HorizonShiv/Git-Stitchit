<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Models\ParameterMaster;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\apps\Master;

class ParameterMasterController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('content.parameter-master.list');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('content.parameter-master.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $this->validate(request(), [
      'ParameterName' => 'required',
    ]);
    $Parameter = new ParameterMaster([
      'name' => $request->ParameterName,
    ]);
    if ($Parameter->save()) {
      if ($request->AddMore) {
        return redirect()->action([ParameterMasterController::class, 'create'])->withSuccess('Successfully Done');
      } else {
        return redirect()->action([ParameterMasterController::class, 'index'])->withSuccess('Successfully Done');
      }
    } else {
      return redirect()->action([ParameterMasterController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(ParameterMaster $parameterMaster)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $ParameterMaster = ParameterMaster::where('id', $id)->first();
    return view('content.parameter-master.edit', compact("ParameterMaster"));
  }

  public function delete(Request $request)
  {
    $ParameterMaster = ParameterMaster::where('id', $request->parameterId)->delete();
    if ($ParameterMaster) {
      return redirect()->action([ParameterMasterController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([ParameterMasterController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }
  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $this->validate(request(), [
      'ParameterName' => 'required',
    ]);
    $ParameterMaster = ParameterMaster::where('id', $id)->update([
      'name' => $request->ParameterName,
    ]);

    if ($ParameterMaster) {
      return redirect()->action([ParameterMasterController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([ParameterMasterController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(ParameterMaster $parameterMaster)
  {
    //
  }
}
