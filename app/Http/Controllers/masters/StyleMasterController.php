<?php

namespace App\Http\Controllers\masters;

use App\Http\Controllers\Controller;
use App\Models\StyleCategory;
use App\Models\StyleMasterMaterials;
use App\Models\StyleMasterProcesses;
use App\Models\StyleSubCategory;
use App\Models\Customer;
use App\Models\StyleMaster;
use App\Models\User;
use App\Http\Controllers\apps\Master;
use App\Models\SalesOrderStyleInfo;
use Illuminate\Http\Request;
use App\Models\ProcessMaster;
use App\Models\CategoryMasters;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ItemSubCategory;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\File;


class StyleMasterController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $StyleMaster = StyleMaster::with('StyleCategory', 'StyleSubCategory', 'Customer')->orderBy('id', 'asc')->get();
    return view('content.style-master.list', compact("StyleMaster"));
  }

  public function styleImageDelete(Request $request)
  {
    $directory = public_path('/samplePhoto/' . $request->styleId . '/');

    // Construct the full path to the image file
    $filePath = $directory . '/' . $request->imageName;

    // Check if the file exists
    if (File::exists($filePath)) {
      // Delete the file
      File::delete($filePath);

      // Return a success response
      return redirect()->action([SeasonController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      // Return an error response if the file doesn't exist
      return redirect()->action([SeasonController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  /**
   * Show the form for creating a new resource.
   */
  public function styleMasterList(Request $request)
  {
    $StyleMaster = StyleMaster::with('StyleCategory', 'StyleSubCategory', 'Customer', 'User', 'Demographic', 'Brand');

    // dd($request->company);
    if (!empty($request->company)) {
      $StyleMaster->where('customer_id', $request->company);
    }

    if (!empty($request->brand)) {

      $StyleMaster->where('brand_id', $request->brand);
    }

    if (!empty($request->designer)) {
      $StyleMaster->where('designer_id', $request->designer);
    }

    if (!empty($request['startDate']) && !empty($request['endDate'])) {
      $startDate = date('Y-m-d', strtotime($request['startDate']));
      $endDate = date('Y-m-d', strtotime($request['endDate']));
      $StyleMaster->whereBetween('style_date', [$startDate, $endDate]);
    }

    if (!empty($request->category)) {
      $StyleMaster->whereHas('StyleCategory', function ($query) use ($request) {
        $query->where('id', $request->category);
      });
    }

    if (!empty($request->subcategory)) {
      $StyleMaster->whereHas('StyleSubCategory', function ($query) use ($request) {
        $query->where('id', $request->subcategory);
      });
    }

    $filteredStyleMaster = $StyleMaster->get();

    $num = 1;
    $result = array("data" => array());
    foreach ($filteredStyleMaster as $styleMasterData) {
      $StyleDate = Helpers::formateDate($styleMasterData->style_date);
      // $CompanyName = $StyleMaster->Customer->company_name ?? '';


      if (!empty($styleMasterData->customer_id)) {
        $companyName = $styleMasterData->Customer->company_name;
        $avatar = substr($styleMasterData->Customer->company_name, 0, 2);
      } else {
        $companyName = 'NA';
        $avatar = 'NA';
      }

      $Company = '<div class="d-flex justify-content-start align-items-center">
                    <div class="avatar-wrapper">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded-circle bg-label-info">
                            ' . $avatar . '
                            </span>
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                        <span class="fw-medium">
                        ' . $companyName . '
                        </span>
                    </div>
                </div>';


      if (!empty($styleMasterData->brand_id)) {
        $brandName = $styleMasterData->Brand->name;
      } else {
        $brandName = 'NA';
      }



      $Brand = '<span class="badge rounded bg-label-dark">' . $brandName . '</span>';


      if (!empty($styleMasterData->designer_id) && !empty($styleMasterData->User)) {
        $designerName = $styleMasterData->User->company_name;
        $designerAvatar = substr($styleMasterData->User->company_name, 0, 2);
      } else {
        $designerName = 'NA';
        $designerAvatar = 'NA';
      }

      $Designer = '<div class="d-flex justify-content-start align-items-center">
                      <div class="avatar-wrapper">
                          <div class="avatar me-2">
                              <span class="avatar-initial rounded-circle bg-label-info">
                              ' . $designerAvatar . '
                              </span>
                          </div>
                      </div>
                      <div class="d-flex flex-column">
                          <span class="fw-medium">
                          ' . $designerName . '
                          </span>
                      </div>
                  </div>';
      $styleNumber = '<span class="badge rounded bg-label-primary">' . $styleMasterData->style_no . '</span>';

      $categoryData = $styleMasterData->StyleCategory->name . ' - ' . $styleMasterData->StyleSubCategory->name;
      $fileHtml = '';
      if (!empty($styleMasterData->sample_photo)) {
        $fileHtml .= '<a class="btn btn-icon btn-label-success mt-1 mx-1 waves-effect"
                 href="' . Helpers::getSamplePhoto($styleMasterData->id, $styleMasterData->sample_photo) . '"
                 target="_blank" title="Sample Photo">
              <i class="ti ti-camera mx-2 ti-sm"></i></a>';
      }
      if (!empty($styleMasterData->tech_pack)) {

        $fileHtml .= '<a class="btn btn-icon btn-label-info mt-1 mx-1 waves-effect"
               href="' . Helpers::getTechPack($styleMasterData->id, $styleMasterData->tech_pack) . '"
               target="_blank" title="Tech Pack">
              <i class="ti ti-ruler mx-2 ti-sm"></i></a>';
      }
      if (!empty($StyleMaster->trim_card)) {
        $fileHtml .= '<a class="btn btn-icon btn-label-dark mt-1 mx-1 waves-effect"
               href="' . Helpers::getTrimCard($styleMasterData->id, $styleMasterData->trim_card) . '"
               target="_blank" title="Trim Card"><i class="ti ti-cut mx-2 ti-sm"></i></a>';
      }

      $actionHtml = "";

      $actionHtml .= ' <a class="btn btn-icon btn-label-primary mt-1 waves-effect mx-1"
                 href="' . route('style-master-view', $styleMasterData->id) . '"><i
                 class="ti ti-eye mx-2 ti-sm"></i></a>';

      $actionHtml .= ' <a class="btn btn-icon btn-label-primary mt-1 waves-effect mx-1"
                 href="' . route('style-master-edit', $styleMasterData->id) . '"><i
                 class="ti ti-edit mx-2 ti-sm"></i></a>';

      $actionHtml .= ' <button type="button" class="btn btn-icon btn-label-danger mx-1"
                onclick="deleteStyleMaster(' . $styleMasterData->id . ')"><i class="ti ti-trash mx-2 ti-sm"></i></button>';

      array_push($result["data"], array($num, $StyleDate, $Company, $Brand, $Designer, $styleNumber, $categoryData, $fileHtml, $actionHtml));
      $num++;
    }
    echo json_encode($result);
  }
  public function create()
  {
    $Designer = User::where('role', '=', 'vendor')->get();
    $categorys = StyleCategory::all();
    $SubCategoryData = StyleSubCategory::all();
    // $SubCategoryData = StyleSubCategory::all();
    $processMasters = ProcessMaster::all();

    $categoryData = CategoryMasters::all();

    $itemMasters = Item::all();
    $categoryMasters = ItemCategory::all();
    $subcategoryMasters = ItemSubCategory::all();
    return view('content.style-master.create', compact('Designer', 'categoryData', 'SubCategoryData', 'itemMasters', 'categorys', 'processMasters', 'categoryMasters', 'subcategoryMasters'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $this->validate(request(), [
      'Style_date' => 'required',
      'Style_No' => 'required',
      'Brand' => 'required',
      'Customer' => 'required',
      'Category' => 'required',
      'SubCategory' => 'required',
      'Demographic' => 'required',
      'Fit' => 'required',
      'Season' => 'required',
    ]);

    $StyleMaster = new StyleMaster([
      'style_no' => $request->Style_No,
      'style_date' => $request->Style_date,
      'brand_id' => $request->Brand,
      'customer_id' => $request->Customer,
      'style_category_id' => $request->Category,
      'style_subcategory_id' => $request->SubCategory,
      'demographic_master_id' => $request->Demographic,
      'febric' => $request->Febric,
      'fit_id' => $request->Fit,
      'season_id' => $request->Season,
      'designer_id' => $request->Designer,
      'merchant_id' => $request->Merchant,
      'color' => $request->Color,
      'designer_name' => $request->DesignerName,
      'rate' => $request->rate,
      'sample' => $request->SampleWeight,
      'production' => $request->ProductionWeight,
    ]);
    $StyleMaster->save();

    $StyleId = $StyleMaster->id;
    if (!empty($request->processData)) {
      $totalProcessDataArray = count($request->processData);
    } else {
      $totalProcessDataArray = 0;
    }
    if ($totalProcessDataArray > 0) {
      $processDatas = $request->processData;

      foreach ($processDatas as $processData) {
        if (!empty($processData['processItem'])) {

          $StyleMasterProcesses = new StyleMasterProcesses([
            'rate' => $processData['processRate'],
            'duration' => $processData['processDuration'],
            'sr_no' => $processData['srNo'],
            'qty' => $processData['processQty'],
            'value' => $processData['processValue'],
            'process_master_id' => $processData['processItem'],
            'style_master_id' => $StyleId
          ]);
          $StyleMasterProcesses->save();
        }
      }
    }

    if (!empty($request->bomListData)) {
      $totalBomListDataArray = count($request->bomListData);
    } else {
      $totalBomListDataArray = 0;
    }

    if ($totalBomListDataArray > 0) {
      $bomListDatas = $request->bomListData;

      foreach ($bomListDatas as $bomListData) {
        if (!empty($bomListData['rawItem'])) {
          $StyleMasterMaterials = new StyleMasterMaterials([
            'item_id' => $bomListData['rawItem'],
            'available_qty' => $bomListData['rawAvailableQty'],
            'rate' => $bomListData['rawRate'],
            'style_master_id' => $StyleId
          ]);
          $StyleMasterMaterials->save();
        }
      }
    }

    if ($request->spec_sheet) {
      $this->validate(request(), [
        'spec_sheet.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
      ]);
      $file = $request->spec_sheet;
      $file_name = $file->getClientOriginalName();
      $new_file_name = str_replace(' ', '-', $file_name);
      $destination_path = public_path('/specsSheet/' . $StyleId . '/');
      if (!is_dir(public_path('/specsSheet'))) {
        mkdir(public_path('/specsSheet'), 0755, true);
      }
      $file->move($destination_path, $new_file_name);

      StyleMaster::where('id', $StyleId)->update([
        "specs_sheet" => $new_file_name,
      ]);
    }

    if ($request->bom_sheet) {
      $this->validate(request(), [
        'bom_sheet.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
      ]);
      $file = $request->bom_sheet;
      $file_name = $file->getClientOriginalName();
      $new_file_name = str_replace(' ', '-', $file_name);
      $destination_path = public_path('/bomSheet/' . $StyleId . '/');
      if (!is_dir(public_path('/bomSheet'))) {
        mkdir(public_path('/bomSheet'), 0755, true);
      }
      $file->move($destination_path, $new_file_name);

      StyleMaster::where('id', $StyleId)->update([
        "bom_sheet" => $new_file_name,
      ]);
    }

    if (!empty($request->sample_photo)) {
      foreach ($request->sample_photo as $SamplePhoto) {
        $this->validate(request(), [
          'sample_photo.*' => 'mimes:xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        $file = $SamplePhoto;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/samplePhoto/' . $StyleId . '/');
        if (!is_dir(public_path('/samplePhoto'))) {
          mkdir(public_path('/samplePhoto'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);

        StyleMaster::where('id', $StyleId)->update([
          "sample_photo" => $new_file_name,
        ]);
      }
    }

    if ($request->tech_pack) {
      $this->validate(request(), [
        'tech_pack.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
      ]);
      $file = $request->tech_pack;
      $file_name = $file->getClientOriginalName();
      $new_file_name = str_replace(' ', '-', $file_name);
      $destination_path = public_path('/techPack/' . $StyleId . '/');
      if (!is_dir(public_path('/techPack'))) {
        mkdir(public_path('/techPack'), 0755, true);
      }
      $file->move($destination_path, $new_file_name);

      StyleMaster::where('id', $StyleId)->update([
        "tech_pack" => $new_file_name,
      ]);
    }

    if ($request->trim_card) {
      $this->validate(request(), [
        'trim_card.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
      ]);
      $file = $request->trim_card;
      $file_name = $file->getClientOriginalName();
      $new_file_name = str_replace(' ', '-', $file_name);
      $destination_path = public_path('/trimCard/' . $StyleId . '/');
      if (!is_dir(public_path('/trimCard'))) {
        mkdir(public_path('/trimCard'), 0755, true);
      }
      $file->move($destination_path, $new_file_name);

      StyleMaster::where('id', $StyleId)->update([
        "trim_card" => $new_file_name,
      ]);
    }
    if ($request->final_image) {
      $this->validate(request(), [
        'final_image.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
      ]);
      $file = $request->final_image;
      $file_name = $file->getClientOriginalName();
      $new_file_name = str_replace(' ', '-', $file_name);
      $destination_path = public_path('/finalImage/' . $StyleId . '/');
      if (!is_dir(public_path('/finalImage'))) {
        mkdir(public_path('/finalImage'), 0755, true);
      }
      $file->move($destination_path, $new_file_name);

      StyleMaster::where('id', $StyleId)->update([
        "final_image" => $new_file_name,
      ]);
    }

    if ($StyleMaster) {
      if ($request->AddMore) {
        return redirect()->action([StyleMasterController::class, 'create'])->withSuccess('Successfully Done');
      } else {
        return redirect()->action([StyleMasterController::class, 'index'])->withSuccess('Successfully Done');
      }
    } else {
      return redirect()->action([StyleMasterController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  public function delete(Request $request)
  {

    $SalesOrderStyleInfo = SalesOrderStyleInfo::where('style_master_id', $request->styleMasterId)->first();

    if ($SalesOrderStyleInfo === null) {
      $StyleMaster = StyleMaster::where('id', $request->styleMasterId)->delete();
      if ($StyleMaster) {
        return response()->json(['success' => true]);
      } else {
        return response()->json(['success' => false]);
      }
    } else {
      return response()->json(['success' => false]);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Request $styleMaster)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $StyleMaster = StyleMaster::where('id', $id)->first();
    $Designer = User::where('role', '=', 'vendor')->get();
    $categoryData = StyleCategory::all();
    $SubCategoryData = StyleSubCategory::all();

    $processMasters = ProcessMaster::all();
    $itemMasters = Item::all();
    $categoryMasters = ItemCategory::all();
    $subcategoryMasters = ItemSubCategory::all();
    $htmlProcess = '';
    if (!empty($StyleMaster)) {
      $num = 0;
      foreach ($StyleMaster->StyleMasterProcesses as $OrderProcess) {
        $htmlProcess .= '<div class="row g-3">';
        $htmlProcess .= '<div class="col-md-2">';
        $htmlProcess .= '<label class="form-label">SR No.</label>';
        $htmlProcess .= '<input type="text" id="srNo' . $num . '" name="processData[' . $num . '][srNo]" class="form-control" placeholder="Sr NO." value="' . $OrderProcess->sr_no . '" />';
        $htmlProcess .= '<input type="hidden" id="StyleMasterProcessesId' . $num . '" name="processData[' . $num . '][planingOrderProcessesId]" value="' . $OrderProcess->id . '">';
        $htmlProcess .= '</div>';
        $htmlProcess .= '<div class="col-md-2">';
        $htmlProcess .= '<label class="form-label">Process List</label>';
        $htmlProcess .= '<select id="processItem' . $num . '" name="processData[' . $num . '][processItem]" class="select2 form-select" data-allow-clear="true">';
        $htmlProcess .= '<option value="">Select</option>';
        foreach ($processMasters as $processMaster) {
          $selected = ($OrderProcess->process_master_id == $processMaster->id) ? 'selected' : '';
          $htmlProcess .= '<option ' . $selected . ' value="' . $processMaster->id . '">' . $processMaster->name . '</option>';
        }
        $htmlProcess .= '</select>';
        $htmlProcess .= '</div>';
        $htmlProcess .= '<div class="col-md-2">';
        $htmlProcess .= '<label class="form-label">Qty</label>';
        $htmlProcess .= '<input type="text" onkeyup="processCalculateValue(' . $num . ')" id="processQty' . $num . '" name="processData[' . $num . '][processQty]" class="form-control" value="' . $OrderProcess->qty . '" placeholder="Quantity" />';
        $htmlProcess .= '</div>';
        $htmlProcess .= '<div class="col-md-2">';
        $htmlProcess .= '<label class="form-label">Rate</label>';
        $htmlProcess .= '<input type="text" onkeyup="processCalculateValue(' . $num . ')" id="processRate' . $num . '" name="processData[' . $num . '][processRate]" class="form-control" value="' . $OrderProcess->rate . '" placeholder="Rate" />';
        $htmlProcess .= '</div>';
        $htmlProcess .= '<div class="col-md-2">';
        $htmlProcess .= '<label class="form-label">Qty</label>';
        $htmlProcess .= '<input type="text" onkeyup="processCalculateValue(' . $num . ')" id="processValue' . $num . '" name="processData[' . $num . '][processValue]" class="form-control" value="' . $OrderProcess->value . '" placeholder="Value" />';
        $htmlProcess .= '</div>';
        $htmlProcess .= '<div class="col-md-2">';
        $htmlProcess .= '<label class="form-label">Qty</label>';
        $htmlProcess .= '<input type="text" onkeyup="processCalculateValue(' . $num . ')" id="processDuration' . $num . '" name="processData[' . $num . '][processDuration]" class="form-control" value="' . $OrderProcess->duration . '" placeholder="duration" />';
        $htmlProcess .= '</div>';
        $num++;
        $htmlProcess .= '</div>';
      }
    }


    $htmlRawMaterial = '';
    if (!empty($StyleMaster)) {
      $num = 0;
      foreach ($StyleMaster->StyleMasterMaterials as $OrderMaterials) {
        $htmlRawMaterial .= '<div class="row g-3">';

        $htmlRawMaterial .= '<div class="col-md-2">
                               <label class="form-label">Category</label>
                               <select id="rawCategoryId' . $num . '" name="bomListData[' . $num . '][category_id]" onchange="getCategoryDetails(' . $num . ')" class="select2 form-select" data-allow-clear="true">
                               <option value="">Select</option>';
        foreach ($categoryMasters as $categoryMaster) {
          $selected = ($OrderMaterials->Item->item_category_id == $categoryMaster->id) ? 'selected' : '';
          $htmlRawMaterial .= '<option ' . $selected . ' value="' . $categoryMaster->id . '">' . $categoryMaster->name . '</option>';
        }
        $htmlRawMaterial .= '</select></div>';

        $htmlRawMaterial .= '<div class="col-md-2">
                               <label class="form-label">Sub Category</label>
                               <select id="rawSubcategoryId' . $num . '" name="bomListData[' . $num . '][subcategory_id]" onchange="getSubCategoryDetails(' . $num . ')" class="select2 form-select" data-allow-clear="true">
                               <option value="">Select</option>';
        foreach ($subcategoryMasters as $subcategoryMaster) {
          $selected = ($OrderMaterials->Item->item_subcategory_id == $subcategoryMaster->id) ? 'selected' : '';
          $htmlRawMaterial .= '<option ' . $selected . ' value="' . $subcategoryMaster->id . '">' . $subcategoryMaster->name . '</option>';
        }
        $htmlRawMaterial .= '</select></div>';

        $htmlRawMaterial .= '<div class="col-md-2">
                               <label class="form-label">Item</label>
                               <select id="rawItem' . $num . '" name="bomListData[' . $num . '][rawItem]" onchange="getItemDetails(' . $num . ')" class="select2 form-select" data-allow-clear="true">
                               <option value="">Select</option>';
        foreach ($itemMasters as $itemMaster) {
          $selected = ($OrderMaterials->Item->id == $itemMaster->id) ? 'selected' : '';
          $htmlRawMaterial .= '<option ' . $selected . ' value="' . $itemMaster->id . '">' . $itemMaster->name . '</option>';
        }
        $htmlRawMaterial .= '</select>
                             <input type="hidden" id="StyleMasterMaterialsId' . $num . '" name="bomListData[' . $num . '][planingOrderMaterialsId]" value="' . $OrderMaterials->id . '">
                             </div>';

        // Per Pc Qty column
        $htmlRawMaterial .= '<div class="col-md-2 col-lg-1">';
        $htmlRawMaterial .= '<label class="form-label">Per Pc Qty</label>';
        $htmlRawMaterial .= '<input type="number" step="any" onkeyup="bomCalculateValue(' . $num . ')" id="rawPerPcQty' . $num . '" name="bomListData[' . $num . '][rawPerPcQty]" class="form-control" placeholder="Per Pc Qty" value="' . $OrderMaterials->per_pc_qty . '" />';
        $htmlRawMaterial .= '</div>';

        // Order Qty column
        $htmlRawMaterial .= '<div class="col-md-2 col-lg-1">';
        $htmlRawMaterial .= '<label class="form-label">Order Qty</label>';
        $htmlRawMaterial .= '<input type="number" step="any" onkeyup="bomCalculateValue(' . $num . ')" id="rawOrderQty' . $num . '" name="bomListData[' . $num . '][rawOrderQty]" class="form-control" placeholder="Order Qty" value="' . $OrderMaterials->order_qty . '" />';
        $htmlRawMaterial .= '</div>';

        // Required Qty column
        $htmlRawMaterial .= '<div class="col-md-2 col-lg-1">';
        $htmlRawMaterial .= '<label class="form-label">Required Qty</label>';
        $htmlRawMaterial .= '<input type="number" step="any" onkeyup="bomCalculateValue(' . $num . ')" id="rawRequiredQty' . $num . '" name="bomListData[' . $num . '][rawRequiredQty]" class="form-control" placeholder="Qty" value="' . $OrderMaterials->required_qty . '" />';
        $htmlRawMaterial .= '</div>';


        // Available Qty column
        $htmlRawMaterial .= '<div class="col-md-2 col-lg-1">';
        $htmlRawMaterial .= '<label class="form-label">Available Qty</label>';
        $htmlRawMaterial .= '<input type="number" step="any" id="rawAvailableQty' . $num . '" name="bomListData[' . $num . '][rawAvailableQty]" class="form-control" placeholder="Qty" value="' . $OrderMaterials->available_qty . '" />';
        $htmlRawMaterial .= '</div>';

        // Rate column
        $htmlRawMaterial .= '<div class="col-md-2 col-lg-1" style="float: right">';
        $htmlRawMaterial .= '<label class="form-label">Rate</label>';
        $htmlRawMaterial .= '<input type="number" step="any" id="rawRate' . $num . '" name="bomListData[' . $num . '][rawRate]" class="form-control" onkeyup="bomCalculateValue(' . $num . ')" placeholder="Total Rate" value="' . $OrderMaterials->rate . '" />';
        $htmlRawMaterial .= '</div>';

        // Total column
        $htmlRawMaterial .= '<div class="col-md-2 col-lg-1">';
        $htmlRawMaterial .= '<label class="form-label">Total</label>';
        $htmlRawMaterial .= '<input type="number" step="any" id="rawTotal' . $num . '" name="bomListData[' . $num . '][rawTotal]" class="form-control" placeholder="Total" value="' . $OrderMaterials->total . '" />';
        $htmlRawMaterial .= '</div>';

        // Similar conversion can be done for remaining fields...

        $htmlRawMaterial .= '</div>';
        $num++;
      }
    }
    $result['showHtmlRawMaterials'] = $htmlRawMaterial;
    $result['showHtmlProcess'] = $htmlProcess;

    $directory = public_path('/samplePhoto/' . $StyleMaster->id . '/');
    $SamplePhotos = [];
    // if (is_dir(public_path($directory))) {

    if (file_exists($directory)) {

      $files = File::files($directory);
      foreach ($files as $file) {
        $SamplePhotos[$file->getFilename()] = asset('/samplePhoto/' . $StyleMaster->id . '/' . $file->getFilename());
      }
    }


    return view('content.style-master.edit', compact('Designer', 'categoryData', 'SubCategoryData', 'StyleMaster', 'result', 'processMasters', 'itemMasters', 'categoryMasters', 'subcategoryMasters', 'SamplePhotos'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $this->validate(request(), [
      'Style_date' => 'required',
      'Style_No' => 'required',
      'Brand' => 'required',
      'Customer' => 'required',
      'Category' => 'required',
      'SubCategory' => 'required',
      'Demographic' => 'required',
      'Fit' => 'required',
      'Season' => 'required',
    ]);

    $StyleMaster = StyleMaster::where('id', $id)->update([
      'style_no' => $request->Style_No,
      'style_date' => $request->Style_date,
      'brand_id' => $request->Brand,
      'customer_id' => $request->Customer,
      'style_category_id' => $request->Category,
      'style_subcategory_id' => $request->SubCategory,
      'demographic_master_id' => $request->Demographic,
      'febric' => $request->Febric,
      'fit_id' => $request->Fit,
      'season_id' => $request->Season,
      'designer_id' => $request->Designer,
      'merchant_id' => $request->Merchant,
      'color' => $request->Color,
      'designer_name' => $request->DesignerName,
      'rate' => $request->rate,
      'sample' => $request->SampleWeight,
      'production' => $request->ProductionWeight,

    ]);

    if ($StyleMaster) {

      if (!empty($request->processData)) {
        $totalProcessDataArray = count($request->processData);
      } else {
        $totalProcessDataArray = 0;
      }
      if ($totalProcessDataArray > 0) {
        $processDatas = $request->processData;

        foreach ($processDatas as $processData) {
          if (!empty($processData['processItem'])) {
            if (!empty($processData['planingOrderProcessesId'])) {
              StyleMasterProcesses::where('id', $processData['planingOrderProcessesId'])->update([
                'rate' => $processData['processRate'],
                'duration' => $processData['processDuration'],
                'sr_no' => $processData['srNo'],
                'qty' => $processData['processQty'],
                'value' => $processData['processValue'],
                'process_master_id' => $processData['processItem'],
              ]);
            } else {
              $StyleMasterProcesses = new StyleMasterProcesses([
                'rate' => $processData['processRate'],
                'duration' => $processData['processDuration'],
                'sr_no' => $processData['srNo'],
                'qty' => $processData['processQty'],
                'value' => $processData['processValue'],
                'process_master_id' => $processData['processItem'],
                'style_master_id' => $id,
              ]);
              $StyleMasterProcesses->save();
            }
          }
        }
      }

      if (!empty($request->bomListData)) {
        $totalBomListDataArray = count($request->bomListData);
      } else {
        $totalBomListDataArray = 0;
      }

      if ($totalBomListDataArray > 0) {
        $bomListDatas = $request->bomListData;

        foreach ($bomListDatas as $bomListData) {
          if (!empty($bomListData['rawItem'])) {
            if (!empty($bomListData['planingOrderMaterialsId'])) {
              StyleMasterMaterials::where('id', $bomListData['planingOrderMaterialsId'])->update([
                'item_id' => $bomListData['rawItem'],
                'available_qty' => $bomListData['rawAvailableQty'],
                'rate' => $bomListData['rawRate'],
              ]);
            } else {
              $StyleMasterMaterials = new StyleMasterMaterials([
                'item_id' => $bomListData['rawItem'],
                'available_qty' => $bomListData['rawAvailableQty'],
                'rate' => $bomListData['rawRate'],
                'style_master_id' => $id,
              ]);
              $StyleMasterMaterials->save();
            }
          }
        }
      }



      if ($request->spec_sheet) {
        $this->validate(request(), [
          'spec_sheet.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        $file = $request->spec_sheet;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/specsSheet/' . $id . '/');
        if (!is_dir(public_path('/specsSheet'))) {
          mkdir(public_path('/specsSheet'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);

        StyleMaster::where('id', $id)->update([
          "specs_sheet" => $new_file_name,
        ]);
      }
      if ($request->bom_sheet) {
        $this->validate(request(), [
          'bom_sheet.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        $file = $request->bom_sheet;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/bomSheet/' . $id . '/');
        if (!is_dir(public_path('/bomSheet'))) {
          mkdir(public_path('/bomSheet'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);

        StyleMaster::where('id', $id)->update([
          "bom_sheet" => $new_file_name,
        ]);
      }

      if (!empty($request->sample_photo)) {
        foreach ($request->sample_photo as $SamplePhoto) {
          $this->validate(request(), [
            'sample_photo.*' => 'mimes:xlsx,xls,jpg,png,jpeg|max:2048',
          ]);
          $file = $SamplePhoto;
          $file_name = $file->getClientOriginalName();
          $new_file_name = str_replace(' ', '-', $file_name);
          $destination_path = public_path('/samplePhoto/' . $id . '/');
          if (!is_dir(public_path('/samplePhoto'))) {
            mkdir(public_path('/samplePhoto'), 0755, true);
          }
          $file->move($destination_path, $new_file_name);

          StyleMaster::where('id', $id)->update([
            "sample_photo" => $new_file_name,
          ]);
        }
      }

      if ($request->tech_pack) {
        $this->validate(request(), [
          'tech_pack.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        $file = $request->tech_pack;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/techPack/' . $id . '/');
        if (!is_dir(public_path('/techPack'))) {
          mkdir(public_path('/techPack'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);

        StyleMaster::where('id', $id)->update([
          "tech_pack" => $new_file_name,
        ]);
      }

      if ($request->trim_card) {
        $this->validate(request(), [
          'trim_card.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        $file = $request->trim_card;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/trimCard/' . $id . '/');
        if (!is_dir(public_path('/trimCard'))) {
          mkdir(public_path('/trimCard'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);

        StyleMaster::where('id', $id)->update([
          "trim_card" => $new_file_name,
        ]);
      }

      if ($request->final_image) {
        $this->validate(request(), [
          'final_image.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
        ]);
        $file = $request->final_image;
        $file_name = $file->getClientOriginalName();
        $new_file_name = str_replace(' ', '-', $file_name);
        $destination_path = public_path('/finalImage/' . $id . '/');
        if (!is_dir(public_path('/finalImage'))) {
          mkdir(public_path('/finalImage'), 0755, true);
        }
        $file->move($destination_path, $new_file_name);

        StyleMaster::where('id', $id)->update([
          "final_image" => $new_file_name,
        ]);
      }


      return redirect()->action([StyleMasterController::class, 'index'])->withSuccess('Successfully Done');
    } else {
      return redirect()->action([StyleMasterController::class, 'index'])->withErrors('Some thing is wrong');
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $styleMaster)
  {
    //
  }

  public function SelectedSubCategory(Request $request)
  {

    // $SubCategoryData = StyleCategory::all();
    $SubCategoryData = StyleSubCategory::where('category_id', '=', $request->categoryId)->get();

    // $SubCategoryData=$request->categoryId;


    // echo $SubCategoryData;
    return response()->json($SubCategoryData);
  }

  public function view($id)
  {
    $StyleMaster = StyleMaster::with('StyleMasterMaterials.Item.ItemSubCategory', 'StyleMasterMaterials.Item.ItemCategory', 'StyleMasterProcesses.ProcessMaster', 'Fit', 'Customer', 'StyleCategory', 'StyleSubCategory', 'Season', 'User', 'Demographic', 'Brand')->where('id', $id)->first();
    $directory = public_path('/samplePhoto/' . $StyleMaster->id . '/');
    $SamplePhotos = [];
    // if (is_dir(public_path($directory))) {

    if (file_exists($directory)) {

      $files = File::files($directory);
      foreach ($files as $file) {
        $SamplePhotos[$file->getFilename()] = asset('/samplePhoto/' . $StyleMaster->id . '/' . $file->getFilename());
      }
    }

    return view('content.style-master.view', compact('StyleMaster', 'SamplePhotos'));
  }


  public function getSubCategories(Request $request)
  {
    $categoryId = $request->input('categoryId');
    $subCategories = StyleSubCategory::where('style_category_id', $categoryId)->get();

    return response()->json($subCategories);
  }

  public function addNewStyleSalesOrder(Request $request)
  {
    // dd($request);

    $StyleMaster = new StyleMaster([
      'style_date' => $request->modelDate,
      'style_no' => $request->modelStyleNo,
      'customer_id' => $request->modelCustomer,
      'febric' => $request->modelFebric,
      'style_category_id' => $request->modelStyleCategory,
      'style_subcategory_id' => $request->modelStyleSubCategory,
      'fit_id' => $request->modelFit,
      'season_id' => $request->modelSeason,
      'designer_id' => $request->modelDesigner,
      'rate' => $request->modelRate,
    ]);

    if ($StyleMaster->save()) {
      $rawData = StyleMaster::all();
      $StyleDate = $rawData->toArray();
      return response()->json(['success' => true, 'StyleData' => $StyleDate]);
    } else {
      return response()->json(['success' => false]);
    }
  }

  public function getStyleDetails(Request $request)
  {
    $styleId = $request->styleId;
    if (!empty($styleId)) {
      $rawData = StyleMaster::where('id', '=', $styleId)->first();
      $StyleData = $rawData->toArray();
    }
    $result['StyleData'] = $StyleData;

    // dd($html1);
    echo json_encode($result);
  }
}
