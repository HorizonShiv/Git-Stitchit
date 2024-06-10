<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Models\Demographic;
use Illuminate\Http\Request;
use App\Http\Controllers\apps\Master;

class DemographicController extends Controller
{
  public function index()
  {

    return view('content.demographic-master.list');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('content.demographic-master.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $this->validate(request(), [
      'demographicName' => 'required',
    ]);

    $Demographic = new Demographic([
      'name' => $request->demographicName,
    ]);
    if ($Demographic->save()) {
      if ($request->AddMore) {
        return redirect()->action([DemographicController::class, 'create'])->withSuccess('Successfully Done');
      } else {
        return redirect()->action([DemographicController::class, 'index'])->withSuccess('Successfully Done');
      }
    } else {
      return redirect()->action([DemographicController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }
  public function edit($id)
  {
    $Demographic = Demographic::where('id', $id)->first();
    return view('content.demographic-master.edit', compact("Demographic"));
  }

  public function delete(Request $request)
  {
    $Demographic = Demographic::where('id', $request->DemographicId)->delete();
    if ($Demographic) {
      return redirect()->action([DemographicController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([DemographicController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $this->validate(request(), [
      'demographicName' => 'required',
    ]);
    $Demographic = Demographic::where('id', $id)->update([
      'name' => $request->demographicName,
    ]);

    if ($Demographic) {
      return redirect()->action([DemographicController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([DemographicController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }
}
