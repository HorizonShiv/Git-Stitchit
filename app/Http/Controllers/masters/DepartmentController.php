<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Http\Controllers\apps\Master;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('content.department.list');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('content.department.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
    $this->validate(request(), [
      'departmentName' => 'required',
      'processMaster' => 'required',
    ]);

    $Department = new Department([
      'name' => $request->departmentName,
      'process_master_id' => $request->processMaster,
    ]);
    if ($Department->save()) {
      if ($request->AddMore) {
        return redirect()->action([DepartmentController::class, 'create'])->withSuccess('Successfully Done');
      } else {
        return redirect()->action([DepartmentController::class, 'index'])->withSuccess('Successfully Done');
      }
    } else {
      return redirect()->action([DepartmentController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Request $jobCenter)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $Department = Department::where('id', $id)->first();
    return view('content.department.edit', compact("Department"));
  }



  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $this->validate(request(), [
      'departmentName' => 'required',
      'processMaster' => 'required',
    ]);
    $Department = Department::where('id', $id)->update([
      'name' => $request->departmentName,
      'process_master_id' => $request->processMaster,
    ]);

    if ($Department) {
      return redirect()->action([DepartmentController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([DepartmentController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }
  public function delete(Request $request)
  {
    $Department = Department::where('id', $request->departmentId)->delete();
    if ($Department) {
      return redirect()->action([DepartmentController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([DepartmentController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }


  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $jobCenter)
  {
    //
  }
}
