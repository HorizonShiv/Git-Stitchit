<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\GrnItem;
use App\Models\Po;
use App\Models\PoItem;
use App\Models\QcItem;
use Illuminate\Http\Request;

class QcManage extends Controller
{
  public function index()
  {
    $qcItems = QcItem::all();
    return view('content.apps.app-qc-list', compact("qcItems"));
  }


  public function getPODetailForQC(Request $request)
  {
    if (!empty($request->poNo)) {
      $poItems = PoItem::where('po_id', $request->poNo)->get();
      $check_num = 1;
      $html = "";
      foreach ($poItems as $poItem) {
        $grnQty = GrnItem::where('po_item_id', $poItem->id)->sum('qty');
        $qcQty = qcItem::where('po_item_id', $poItem->id)->sum('qty');
        $pendingDispatch = ($poItem->qty - $qcQty);
        $html .= '<tr id="option-value-row' . $check_num . '">';
        $html .= '  <td>' . $check_num . '</td>';
        $html .= '  <td>';
        $html .= '    <div class="input-group">';
        $html .= '      <input type="text" readonly name="option_value[' . $check_num . '][item]" value="' . $poItem->item_name . '" placeholder="SKU NO" class="form-control" />';
        $html .= '      <input type="hidden" readonly name="option_value[' . $check_num . '][id]" value="' . $poItem->id . '" />';
        $html .= '    </div>';
        $html .= '  </td>';
        $html .= '  <td>';
        $html .= '    <div class="input-group">';
        $html .= '      <input type="text" name="option_value[' . $check_num . '][poQty]"  placeholder="Po Number" value="' . $poItem->qty . '" class="form-control" readonly />';
        $html .= '    </div>';
        $html .= '  </td>';
        $html .= '  <td>';
        $html .= '    <div class="input-group">';
        $html .= '      <input type="text" name="option_value[' . $check_num . '][grnQty]"  placeholder="grnQty" value="' . $grnQty . '" class="form-control" readonly />';
        $html .= '    </div>';
        $html .= '  </td>';
        $html .= '  <td>';
        $html .= '    <div class="input-group">';
        $html .= '      <input type="text" name="option_value[' . $check_num . '][recQty]"  placeholder="recQty" value="' . $qcQty . '" class="form-control" readonly />';
        $html .= '    </div>';
        $html .= '  </td>';
        $html .= '  <td>';
        $html .= '    <div class="input-group">';
        $html .= '      <input type="text" name="option_value[' . $check_num . '][rQty]"  placeholder="rQty" value="' . $pendingDispatch . '" class="form-control" readonly />';
        $html .= '    </div>';
        $html .= '  </td>';
        $html .= '  <td>';
        $html .= '    <div class="input-group">';
        $html .= '      <input type="text" name="option_value[' . $check_num . '][g_qty]" id="g_qty' . $check_num . '" onkeyup="goodBadCheck(' . $pendingDispatch . ',' . $check_num . ')"  placeholder="good qty" class="form-control" required />';
        $html .= '    </div>';
        $html .= '  </td>';
        $html .= '  <td>';
        $html .= '    <div class="input-group">';
        $html .= '      <input type="text" name="option_value[' . $check_num . '][b_qty]" id="b_qty' . $check_num . '" onkeyup="goodBadCheck(' . $pendingDispatch . ',' . $check_num . ')"  placeholder="Bad Qty" class="form-control" required />';
        $html .= '    </div>';
        $html .= '  </td>';
        $html .= '  <td>';
        $html .= '    <div class="input-group">';
        $html .= '      <input type="text" name="option_value[' . $check_num . '][qty]" id="qty' . $check_num . '"  placeholder="Qty" readonly class="form-control" required />';
        $html .= '    </div>';
        $html .= '  </td>';
        $html .= '</tr>';
        $check_num++;
      }
      echo json_encode($html);
    }
  }

  public function qcAddView()
  {
    $pos = Po::all();
    return view('content.apps.app-qc-add', compact("pos"));
  }

  public function qcAddStore(Request $request)
  {
    $request->validate([
      'poNo' => 'required|string|max:250',
      'date' => 'required',
    ]);


    if (empty($request['option_value'][1]['qty'])) {
      return redirect()->action([QcManage::class, 'qcAddView'])->withErrors('you are not add any items!');
    }
    $date = $_REQUEST['date'];
    $remark = $_REQUEST['remark'];
    $option_values = $_REQUEST['option_value'];
    if (count($option_values) > 0) {
      foreach ($option_values as $option_value) {
        if ($option_value['qty'] > 0) {
          $qcItem = new QcItem([
            'po_item_id' => $option_value['id'],
            'item_name' => $option_value['item'],
            'qty' => $option_value['qty'],
            'g_qty' => $option_value['g_qty'],
            'b_qty' => $option_value['b_qty'],
            'date' => $date,
            'remark' => $remark,
          ]);
          $qcItem->save();
        }
      }
    } else {
      return redirect()->action([QcManage::class, 'index'])->withErrors('Error Occurred!');
    }
    return redirect()->action([QcManage::class, 'index'])->withSuccess('Done Successfully!');
  }

  public function getGRNQty()
  {
    $poNo = "33027";
    $token = Controller::getDeniMaxToken();
    $client = new \GuzzleHttp\Client();
    $responseDataResult = $client->get(
      "http://103.92.122.78:8080/denimaxone/api/order/getorder/{$poNo}",
      [
        'headers' => [
          'Authorization' => 'Bearer ' . $token . ''
        ],
      ]
    );
    $responseDatas = json_decode($responseDataResult->getBody()->getContents());
    dd($responseDatas);
    if (!empty($responseDatas)) {
      if (isset($responseDatas->inwardOutwards)) {
        foreach ($responseDatas->inwardOutwards as $responseData) {
          $checkGrn = GrnItem::where('printNumber', $responseData->printNumber)->first();
          if (!$checkGrn) {
            $grn = new GrnItem([
              'printNumber' => $responseData->printNumber,
              'qty' => $responseData->quantity,
              'remark' => 'eventType : ' . $responseData->eventType . ' by : ' . $responseData->by . ' challanNumber : ' . $responseData->challanNumber,
              'date' => date('Y-m-d', strtotime($responseData->date)),
              'po_id' => $poNo
            ]);
            $grn->save();
          }
        }
      }
      //return back()->with('success', __('Your Data Saved Successfully!!!'));
    } else {
      //return back()->withError('Data Not Found OR Data is Uptodate')->withInput();
    }
  }

}
