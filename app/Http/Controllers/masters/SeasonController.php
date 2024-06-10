<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Models\Season;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateSeasonRequest;
use App\Http\Controllers\apps\Master;


class SeasonController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('content.season.list');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('content.season.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $this->validate(request(), [
      'seasonName' => 'required',
    ]);

    $Season = new Season([
      'name' => $request->seasonName,
    ]);
    if ($Season->save()) {
      if ($request->AddMore) {
        return redirect()->action([SeasonController::class, 'create'])->withSuccess('Successfully Done');
      } else {
        return redirect()->action([SeasonController::class, 'index'])->withSuccess('Successfully Done');
      }
    } else {
      return redirect()->action([SeasonController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Season $season)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $Season = Season::where('id', $id)->first();
    return view('content.season.edit', compact("Season"));
  }

  public function delete(Request $request)
  {
    $Season = Season::where('id', $request->seasonId)->delete();
    if ($Season) {
      return redirect()->action([SeasonController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([SeasonController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $this->validate(request(), [
      'seasonName' => 'required',
    ]);
    $Season = Season::where('id', $id)->update([
      'name' => $request->seasonName,
    ]);

    if ($Season) {
      return redirect()->action([SeasonController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([SeasonController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Season $season)
  {
    //
  }
}
