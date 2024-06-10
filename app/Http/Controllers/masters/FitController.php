<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Models\Fit;
use Illuminate\Http\Request;
use App\Http\Controllers\apps\Master;

class FitController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {

    return view('content.fit.list');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('content.fit.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $this->validate(request(), [
      'fitName' => 'required',
    ]);

    $Fit = new Fit([
      'name' => $request->fitName,
    ]);
    if ($Fit->save()) {
      if ($request->AddMore) {
        return redirect()->action([FitController::class, 'create'])->withSuccess('Successfully Done');
      } else {
        return redirect()->action([Master::class, 'index'])->withSuccess('Successfully Done');
      }
    } else {
      return redirect()->action([Master::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Fit $fit)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $Fit = Fit::where('id', $id)->first();
    return view('content.fit.edit', compact("Fit"));
  }


  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $this->validate(request(), [
      'fitName' => 'required',
    ]);
    $Fit = Fit::where('id', $id)->update([
      'name' => $request->fitName,
    ]);

    if ($Fit) {
      return redirect()->action([FitController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([FitController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  public function delete(Request $request)
  {
    $Fit = Fit::where('id', $request->fitId)->delete();
    if ($Fit) {
      return redirect()->action([FitController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([FitController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Fit $fit)
  {
    //
  }
}
