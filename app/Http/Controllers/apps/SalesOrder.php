<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\StyleMaster;
use App\Models\User;
use App\Models\SalesOrders;
use App\Models\SalesOrderStyleInfo;
use App\Models\SalesOrderParameters;
use App\Models\Customer;
use App\Models\Setting;
use App\Models\Brand;
use App\Models\Po;
use App\Models\StyleCategory;
use App\Models\StyleSubCategory;
use App\Models\JobOrders;
use App\Models\PlaningOrders;
use App\Models\Season;
use App\Helpers\Helpers;
use Illuminate\Http\Request;

class SalesOrder extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $SalesOrders = SalesOrders::with('SalesOrderStyleInfo.StyleMaster.StyleCategory', 'SalesOrderParameters', 'Customer', 'Brand', 'Season')->get();

    // dd($SalesOrders->toArray());
    return view('content.sales-order.list', compact('SalesOrders'));
  }

  public function saleOrderList(Request $request)
  {
    $SalesOrders = SalesOrders::with('SalesOrderStyleInfo.StyleMaster.StyleCategory', 'SalesOrderStyleInfo', 'SalesOrderParameters', 'Customer', 'Brand', 'Season');

    if (!empty($request->company)) {
      $SalesOrders->where('customer_id', $request->company);
    }

    if (!empty($request->brand)) {
      $SalesOrders->where('brand_id', $request->brand);
    }

    if (!empty($request->styleCategory)) {
      $SalesOrders->whereHas('SalesOrderStyleInfo.StyleMaster', function ($query) use ($request) {
        $query->where('style_category_id', $request->styleCategory);
      });
    }

    if (!empty($request['startDate']) && !empty($request['endDate'])) {
      $startDate = date('Y-m-d', strtotime($request['startDate']));
      $endDate = date('Y-m-d', strtotime($request['endDate']));
      $SalesOrders->whereBetween('date', [$startDate, $endDate]);
    }
    $num = 1;
    $result = array("data" => array());
    $filteredSalesOrders = $SalesOrders->orderBy("id", "desc")->get();
    foreach ($filteredSalesOrders as $SalesOrder) {
      $SaleOrderNumber = '<span class="badge rounded bg-label-dark">' . $SalesOrder->sales_order_no . '</span>';

      $SalesOrderDate = Helpers::formateDate($SalesOrder->date);

      $companyName = 'NA';
      $personName = 'NA';
      $avatar = 'NA';


      $Customer = '<div class="d-flex justify-content-start align-items-center">
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
                        <small class="text-truncate text-muted">
                        ' . $personName . '
                        </small>
                    </div>
                </div>';

      $BrandName = '<span class="badge rounded bg-label-dark">NA</span>';

      $StyleNo = '';
      foreach ($SalesOrder->SalesOrderStyleInfo as $SalesOrderStyle) {
        $StyleNo .= '<span class="badge rounded bg-label-dark m-1">' . $SalesOrderStyle->StyleMaster->style_no . ' - ' . $SalesOrderStyle->StyleMaster->StyleCategory->name . '</span><br>';
      }

      $TotalQty = '<span class="badge rounded bg-label-dark">' . $SalesOrder->SalesOrderStyleInfo->sum('total_qty') . '</span>';
      $actionHtml = "";

      $actionHtml .= ' <a class="btn btn-icon btn-label-primary mt-1 waves-effect mx-1"
                 href="' . route('sales-order-view', $SalesOrder->id) . '"><i
                 class="ti ti-eye mx-2 ti-sm"></i></a>';

      $actionHtml .= ' <a class="btn btn-icon btn-label-primary mt-1 waves-effect mx-1"
                 href="' . route('sales-order-edit', $SalesOrder->id) . '"><i
                 class="ti ti-edit mx-2 ti-sm"></i></a>';

      $actionHtml .= ' <button type="button" class="btn btn-icon btn-label-danger mx-1"
                onclick="deleteSalesOrder(' . $SalesOrder->id . ')"><i class="ti ti-trash mx-2 ti-sm"></i></button>';

      array_push($result["data"], array($num, $SalesOrderDate, $SaleOrderNumber, $Customer, $BrandName, $StyleNo, $TotalQty, $actionHtml));
      $num++;
    }
    echo json_encode($result);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $UserData = User::where('role', '=', 'designer')->get();
    $Designer = User::where('role', '=', 'vendor')->get();
    $categoryData = StyleCategory::all();
    $SubCategoryData = StyleSubCategory::all();
    return view('content.sales-order.create', compact('UserData', 'Designer', 'categoryData', 'SubCategoryData'));
  }

  public function view($id)
  {
    $UserData = User::where('role', '=', 'designer')->get();
    $SalesOrders = SalesOrders::with('SalesOrderStyleInfo.StyleMaster.StyleCategory', 'SalesOrderParameters', 'Customer', 'Brand', 'Season')->where('id', $id)->first();
    return view('content.sales-order.view', compact('UserData', 'SalesOrders'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
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
  public function edit(string $id)
  {
    $UserData = User::where('role', '=', 'designer')->get();
    $Designer = User::where('role', '=', 'vendor')->get();
    $categoryData = StyleCategory::all();
    $SubCategoryData = StyleSubCategory::all();
    $SalesOrders = SalesOrders::with('SalesOrderStyleInfo.StyleMaster.StyleCategory', 'SalesOrderParameters', 'Customer', 'Brand', 'Season')->where('id', $id)->first();
    return view('content.sales-order.edit', compact('UserData', 'Designer', 'categoryData', 'SubCategoryData', 'SalesOrders'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request)
  {
    dd($request);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }

  public function getSalesParameterDataView(Request $request)
  {
    // print_r($request->all());
    $rawData = SalesOrderStyleInfo::with("SalesOrderParameters")->where('id', '=', $request->id)->first();
    $salesOrdersData = $rawData->toArray();

    $salesOrderParameters = SalesOrderParameters::where('sales_order_style_id', '=', $request->id)->get();
    $groupedSizes = $salesOrderParameters->groupBy('size');
    $groupedColors = $salesOrderParameters->groupBy('color');

    $htmlTable = '';

    // dd($salesOrderParameters->toArray());

    $htmlTable .= '<div>
    <table id="SizeRatios">
    <thead>
    <th><input type="text" placeholder="Color" readonly="" class="form-control" /></th>
    <th><input type="text" placeholder="Size" readonly class="form-control" /></th>';

    $sizes = [];
    foreach ($groupedSizes as $size => $groupedSize) {
      $htmlTable .= '
          <th>
            <input type="text" readonly name="Size[]" value="' . $size . '" readonly class="form-control" />
          </th>
          ';
      $sizes[] = $size;
    }

    $sizesString = implode(",", $sizes);

    $htmlTable .= '<th><input type="text" value="Total" readonly class="form-control" /></th></thead>';

    $firstIndex = 1;
    foreach ($groupedColors as $colorKey => $colorwiseData) {
      $colorwiseQtyData = $colorwiseData->sum('planned_qty');
      $htmlTable .= '<tbody>
                        <tr class="odd">
                          <td rowspan="2">
                            <input
                            readonly
                              type="text"
                              value="' . $colorKey . '"
                              name="Color[' . $firstIndex . ']"
                              class="form-control"
                              style="height: 78px"
                            />
                          </td>';
      $htmlTable .= '<td rowspan="">
                        <input type="text" placeholder="Ratio" readonly class="form-control" />
                      </td>';
      $secondIndex = 0;
      foreach ($colorwiseData as $data) {
        $htmlTable .= '
              <td rowspan="1">
                <input type="text" readonly name="Ratio[' . $firstIndex . '][' . $secondIndex . ']" value="' . $data->ratio . '" class="form-control" />
                <input type="hidden" readonly name="parameterIds[' . $firstIndex . '][' . $secondIndex . ']" value="' . $data->id . '" class="form-control" />
              </td>';
        $secondIndex++;
      }

      $htmlTable .= '
      <td rowspan="2"><input type="text" value="' . $colorwiseQtyData . '" name="Total[' . $firstIndex . ']" class="form-control" style="height: 78px;"></td></tr>';


      $htmlTable .= '<tr>';

      $htmlTable .= '<td rowspan="">
                      <input type="text" placeholder="Qty" readonly class="form-control" />
                    </td>';
      $secondIndex = 0;
      foreach ($colorwiseData as $data) {
        $htmlTable .= '
              <td rowspan="1">
                <input type="text" readonly name="Qty[' . $firstIndex . '][' . $secondIndex . ']" value="' . $data->planned_qty . '" class="form-control" />
              </td>';
        $secondIndex++;
      }

      $firstIndex++;
      $htmlTable .= '</tr>

      </tbody>';
    }

    // dd($htmlTable);

    $htmlTable .= '</table></div>';

    // print_r($salesOrdersData);
    return response()->json(['success' => true, 'id' => $request->id, 'StyleData' => $salesOrdersData, 'htmlTable' => $htmlTable, 'rowcount' => $firstIndex, 'sizesString' => $sizesString]);
  }

  public function getSalesDataEdit(Request $request)
  {
    // print_r($request->all());
    $rawData = SalesOrderStyleInfo::with("SalesOrderParameters")->where('id', '=', $request->id)->first();
    $salesOrdersData = $rawData->toArray();

    $salesOrderParameters = SalesOrderParameters::where('sales_order_style_id', '=', $request->id)->get();
    $groupedSizes = $salesOrderParameters->groupBy('size');
    $groupedColors = $salesOrderParameters->groupBy('color');

    $htmlTable = '';

    // dd($salesOrderParameters->toArray());

    $htmlTable .= '<div>
    <table id="SizeRatios">
    <thead>
    <th><input type="text" value="Color" readonly="" class="form-control" /></th>';

    $sizes = [];
    foreach ($groupedSizes as $size => $groupedSize) {
      $htmlTable .= '
          <th>
            <input type="text" name="Size[]" value="' . $size . '" readonly="" class="form-control" />
          </th>
          ';
      $sizes[] = $size;
    }

    $sizesString = implode(",", $sizes);

    $htmlTable .= '<th><input type="text" value="Total" readonly="" class="form-control" /></th></thead>';

    $firstIndex = 1;
    foreach ($groupedColors as $colorKey => $colorwiseData) {
      $colorwiseQtyData = $colorwiseData->sum('planned_qty');
      $htmlTable .= '<tbody>
                        <tr class="odd">
                          <td rowspan="2">
                            <input
                              type="text"
                              value="' . $colorKey . '"
                              name="Color[' . $firstIndex . ']"
                              class="form-control"
                              style="height: 78px"
                            />
                          </td>';
      $secondIndex = 0;
      foreach ($colorwiseData as $data) {
        $htmlTable .= '
              <td rowspan="1">
                <input type="text" name="Ratio[' . $firstIndex . '][' . $secondIndex . ']" value="' . $data->ratio . '" class="form-control" />
                <input type="hidden" name="parameterIds[' . $firstIndex . '][' . $secondIndex . ']" value="' . $data->id . '" class="form-control" />
              </td>';
        $secondIndex++;
      }
      $htmlTable .= '
      <td rowspan="2"><input type="text" value="' . $colorwiseQtyData . '" onkeyup="checkTotalQty()" name="Total[' . $firstIndex . ']" class="form-control" style="height: 78px;"></td></tr>';

      $htmlTable .= '<tr>';
      $secondIndex = 0;
      foreach ($colorwiseData as $data) {
        $htmlTable .= '
              <td rowspan="1">
              <input type="text" name="Qty[' . $firstIndex . '][' . $secondIndex . ']" value="' . $data->planned_qty . '" class="form-control" />
              </td>';
        $secondIndex++;
      }

      $firstIndex++;
      $htmlTable .= '</tr>

      </tbody>';
    }

    // dd($htmlTable);

    $htmlTable .= '</table></div>';

    // print_r($salesOrdersData);
    return response()->json(['success' => true, 'id' => $request->id, 'StyleData' => $salesOrdersData, 'htmlTable' => $htmlTable, 'rowcount' => $firstIndex, 'sizesString' => $sizesString]);
  }

  public function getSalesDataView(Request $request)
  {
    // print_r($request->all());
    $rawData = SalesOrderParameters::where('sales_order_style_id', '=', $request->id)->get();
    $salesOrdersData = $rawData->toArray();

    // print_r($salesOrdersData);
    return response()->json(['success' => true, 'id' => $request->id, 'StyleData' => $salesOrdersData]);
  }


  public function salesStyleData(Request $request)
  {

    // dd(json_decode($request->dataArray));
    $SalesOrderId = $request->salesOrderId;
    if (!empty($request->salesStyleId)) {
      // dd($request);
      $SalesOrders = SalesOrders::where('id', $SalesOrderId)->update([
        'date' => $request->saleOrderDate,
        'customer_id' => $request->customerName,
        'brand_id' => $request->brand,
        'season_id' => $request->season,
      ]);

      $SalesOrderStyleInfo = SalesOrderStyleInfo::where('id', $request->salesStyleId)->update([
        'style_master_id' => $request->styleNo,
        'customer_style_no' => $request->customerStyleNo,
        'price' => $request->price,
        'total_qty' => $request->totalQty,
        'ship_date' => $request->shipDate,
        'details' => $request->details,
      ]);

      $rawData = StyleMaster::with("StyleCategory", "Fit")->where('id', '=', $request->styleNo)->first();

      $styleMaster = $rawData->toArray();

      $parameterSizeData = explode(",", $request->parameterSizeData);
      $data = json_decode($request->dataArray, true);

      // Extract color data
      $colors = $data['tableData']['color'];

      foreach ($colors as $colorIndex => $colorValue) {

        $ratios = $data['tableData']['ratio'][$colorIndex];
        $qtyValue = $data['tableData']['qty'][$colorIndex];
        if (!empty($data['tableData']['parameterIds'][$colorIndex])) {
          $parameterIds = $data['tableData']['parameterIds'][$colorIndex];
        }

        foreach ($ratios as $ratioIndex => $ratioValue) {
          if (!empty($parameterIds[$ratioIndex])) {
            $SalesOrderStyleInfo = SalesOrderParameters::where('id', $parameterIds[$ratioIndex])->update([
              'sales_order_id' => $SalesOrderId,
              'sales_order_style_id' => $request->salesStyleId,
              'color' => $colorValue ?? NULL,
              'ratio' => $ratioValue === '' ? 0 : ($ratioValue ?? null),
              'size' => $parameterSizeData[$ratioIndex] === '' ? 0 : ($parameterSizeData[$ratioIndex] ?? null),
              'planned_qty' => $qtyValue[$ratioIndex] === '' ? 0 : ($qtyValue[$ratioIndex] ?? NUll),
            ]);
          } else {
            $SalesOrderParameters = new SalesOrderParameters([
              'sales_order_id' => $SalesOrderId,
              'sales_order_style_id' => $request->salesStyleId,
              'color' => $colorValue ?? NULL,
              'ratio' => $ratioValue === '' ? 0 : ($ratioValue ?? null),
              'size' => $parameterSizeData[$ratioIndex] === '' ? 0 : ($parameterSizeData[$ratioIndex] ?? null),
              'planned_qty' => $qtyValue[$ratioIndex] === '' ? 0 : ($qtyValue[$ratioIndex] ?? NUll),
            ]);
            $SalesOrderParameters->save();
          }
        }
      }


      // foreach (json_decode($request->dataArray) as $parameterData) {
      //   // dd($parameterData->parameter);
      //   if (!empty($parameterData->parameter)) {
      //     $SalesOrderStyleInfo = SalesOrderParameters::where('id', $parameterData->parameter)->update([
      //       'sales_order_id' => $SalesOrderId,
      //       'sales_order_style_id' => $request->salesStyleId,
      //       'color' => $parameterData->color,
      //       'size' => $parameterData->size,
      //       'ratio' => $parameterData->ratio,
      //       'planned_qty' => $parameterData->qty,
      //     ]);
      //   } else {
      //     $SalesOrderParameters = new SalesOrderParameters([
      //       'sales_order_id' => $SalesOrderId,
      //       'sales_order_style_id' => $request->salesStyleId,
      //       'color' => $parameterData->color,
      //       'size' => $parameterData->size,
      //       'ratio' => $parameterData->ratio,
      //       'planned_qty' => $parameterData->qty,
      //     ]);
      //     $SalesOrderParameters->save();
      //   }
      // }


      if ($request->redirection == 1) {
        return response()->json(['success' => true, 'redirect' => 1]);
      } else {
        return response()->json(['success' => true, 'id' => $request->salesStyleId, 'StyleData' => $styleMaster, 'SalesOrderId' => $SalesOrderId]);
      }
    } else {

      if ($request->salesOrderId) {
        $SalesOrderId = $request->salesOrderId;
      } else {
        $Setting = Setting::orderBy('id', 'desc')->first();
        $SalesOrderDetails = $Setting->toArray();


        $salesOrderCount = $SalesOrderDetails['sales_order_no_set'] + 1;
        $salesOrderNo = $SalesOrderDetails['sales_order_pre_fix'] . '' . $salesOrderCount;

        $SalesOrders = new SalesOrders([
          'date' => $request->saleOrderDate,
          'customer_id' => $request->customerName,
          'brand_id' => $request->brand,
          'season_id' => $request->season,
          'sales_order_no' => $salesOrderNo,
        ]);

        $Setting = Setting::where('id', $SalesOrderDetails['id'])->update([
          'sales_order_no_set' => $salesOrderCount,
        ]);

        $SalesOrders->save();
        $SalesOrderId = $SalesOrders->id;
      }

      if ($SalesOrderId) {

        $SalesOrderStyleInfo = new SalesOrderStyleInfo([
          'sales_order_id' => $SalesOrderId,
          'style_master_id' => $request->styleNo,
          'customer_style_no' => $request->customerStyleNo,
          'price' => $request->price,
          'total_qty' => $request->totalQty,
          'ship_date' => $request->shipDate,
          'details' => $request->details,
        ]);

        $rawData = StyleMaster::with("StyleCategory", "Fit")->where('id', '=', $request->styleNo)->first();

        $styleMaster = $rawData->toArray();

        // dd($request->dataArray);
        if ($SalesOrderStyleInfo->save()) {

          $SalesOrderStyleInfoId = $SalesOrderStyleInfo->id;

          if ($request->styleImage) {
            $this->validate(request(), [
              'styleImage.*' => 'mimes:pdf,xlsx,xls,jpg,png,jpeg|max:2048',
            ]);
            $file = $request->styleImage;
            $file_name = $file->getClientOriginalName();
            // $file_name = 'SPForAccountBlack.png';
            $new_file_name = str_replace(' ', '-', $file_name);
            $destination_path = public_path('/SalesOrderStyleImg/' . $SalesOrderStyleInfoId . '/');
            if (!is_dir(public_path('/SalesOrderStyleImg'))) {
              mkdir(public_path('/SalesOrderStyleImg'), 0755, true);
            }
            $file->move($destination_path, $new_file_name);

            SalesOrderStyleInfo::where('id', $SalesOrderStyleInfoId)->update([
              "style_image" => $new_file_name,
            ]);
          }

          $i = 0;

          $parameterSizeData = explode(",", $request->parameterSizeData);

          // Decode the JSON data into PHP arrays
          $data = json_decode($request->dataArray, true);

          // Extract color data
          $colors = $data['tableData']['color'];

          foreach ($colors as $colorIndex => $colorValue) {

            $ratios = $data['tableData']['ratio'][$colorIndex];
            $qtyValue = $data['tableData']['qty'][$colorIndex];

            foreach ($ratios as $ratioIndex => $ratioValue) {
              $SalesOrderParameters = new SalesOrderParameters([
                'sales_order_id' => $SalesOrderId,
                'sales_order_style_id' => $SalesOrderStyleInfoId,
                'color' => $colorValue ?? NULL,
                'size' => $parameterSizeData[$ratioIndex] === '' ? 0 : ($parameterSizeData[$ratioIndex] ?? null),
                'ratio' => $ratioValue === '' ? 0 : ($ratioValue ?? null),
                'planned_qty' => $qtyValue[$ratioIndex] === '' ? 0 : ($qtyValue[$ratioIndex] ?? NUll),
              ]);
              $SalesOrderParameters->save();
            }
          }

          // dd($i);
          if ($request->redirection == 1) {
            return response()->json(['success' => true, 'redirect' => 1]);
          } else {
            return response()->json(['success' => true, 'id' => $SalesOrderStyleInfoId, 'StyleData' => $styleMaster, 'SalesOrderId' => $SalesOrderId]);
          }
        }
      }
    }
  }

  public function getItemParameter(Request $request)
  {
    $StyleId = $request->StyleId;
    $html1 = '';
    if (!empty($StyleId)) {
      $rawData = StyleMaster::with("StyleCategory", "Fit", "Season")->where('id', '=', $StyleId)->first();
      // dd($rawData->toArray());
      $html1 .= ' <div>
                    <h6 class="mb-3">Style Details:</h6>
                    <p class="mb-1"> Category: ' . $rawData->StyleCategory->name . '</p>
                    <p class="mb-1"> Fit: ' . $rawData->Fit->name . '</p>
                    <p class="mb-1"> Season: ' . $rawData->Season->name . '</p>
                    <p class="mb-1"> Febric: ' . $rawData->febric . '</p>
                  </div>';
    }
    $result['styleInfo'] = $html1;
    $result['rate'] = $rawData->rate;

    // dd($html1);
    echo json_encode($result);
  }

  public function delete(Request $request)
  {
    $SalesId = $request->salesOrderId;

    // $JobOrders = JobOrders::where('sale_order_id', $SalesId)->first();
    $PlaningOrdersCheck = PlaningOrders::where('sale_order_id', $SalesId)->where('status', 'done')->first();
    // dd($JobOrders);
    if ($PlaningOrdersCheck === null) {
      $SalesOrder = SalesOrders::where('id', $SalesId)->delete();
      if ($SalesOrder) {
        $PlaningOrders = PlaningOrders::where('sale_order_id', $SalesId)->delete();
        $SalesOrderStyleInfo = SalesOrderStyleInfo::where('sales_order_id', $SalesId)->delete();
        $SalesOrderParameters = SalesOrderParameters::where('sales_order_id', $SalesId)->delete();
        return response()->json(['success' => true]);
      } else {
        return response()->json(['success' => false]);
      }
    } else {
      return response()->json(['success' => false]);
    }
  }

  // public function SelectedCompanyName(Request $request)
  // {
  //   $comapanyData = Buyer::where('id', '=', $request->customerId)->get();
  //   return response()->json($comapanyData);
  // }
}
