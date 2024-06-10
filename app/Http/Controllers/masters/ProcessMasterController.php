<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Models\ProcessMaster;
use App\Http\Controllers\apps\Master;
use Illuminate\Http\Request;


class ProcessMasterController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('content.process-master.list');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('content.process-master.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $this->validate(request(), [
      'processName' => 'required',
    ]);

    $Process = new ProcessMaster([
      'name' => $request->processName,
      'type' => $request->processConnect,
    ]);
    if ($Process->save()) {
      if ($request->AddMore) {
        return redirect()->action([ProcessMasterController::class, 'create'])->withSuccess('Successfully Done');
      } else {
        return redirect()->action([ProcessMasterController::class, 'index'])->withSuccess('Successfully Done');
      }
    } else {
      return redirect()->action([ProcessMasterController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(ProcessMaster $processMaster)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $Process = ProcessMaster::where('id', $id)->first();
    return view('content.process-master.edit', compact("Process"));
  }


  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $this->validate(request(), [
      'processName' => 'required',
    ]);
    $Process = ProcessMaster::where('id', $id)->update([
      'name' => $request->processName,
      'type' => $request->processConnect,
    ]);

    if ($Process) {
      return redirect()->action([ProcessMasterController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([ProcessMasterController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }
  public function delete(Request $request)
  {
    $ProcessMaster = ProcessMaster::where('id', $request->processId)->delete();
    if ($ProcessMaster) {
      return redirect()->action([ProcessMasterController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([ProcessMasterController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }
  /**
   * Remove the specified resource from storage.
   */
  public function destroy(ProcessMaster $processMaster)
  {
    //
  }
}
