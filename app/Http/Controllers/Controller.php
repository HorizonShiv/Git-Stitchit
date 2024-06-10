<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
  use AuthorizesRequests, ValidatesRequests;


  public static function getIndianCurrency($number)
  {
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'One', 2 => 'Two',
      3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
      7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
      10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
      13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
      16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
      19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
      40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
      70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($i < $digits_length) {
      $divider = ($i == 2) ? 10 : 100;
      $number = floor($no % $divider);
      $no = floor($no / $divider);
      $i += $divider == 10 ? 1 : 2;
      if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
      } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
  }

  public function getDeniMaxToken()
  {
//    $postFields = [
//      "orderStatusDesc" => "history",
//      "fromDate" => "2023-11-30T18:30:00.000Z",
//      "toDate" => "2023-12-24T18:30:00.000Z"
//    ];
//    $headers = [
//      'System' => 'Denimax9.0',
//      'Content-Type' => 'application/json',
//      'Authorization' => 'Bearer FyQiAOT6nCbsrgQJBAlGzGenO1xhTlYTgLVkVd6bq5z83zqbf6l4fz_Q_-5LPs3KfRIO_qcXv0FdbEsyhTUqJ0GPFNnYRNY4-E4BArSXgXaQgWZevlzh9DP1cnRDzVZ_M65cW75829QY3XhiS4-akEZbmSZQksD2arLAb6xEzpcLLT0D1KbBerg77jHBoyQNyYMzKn8z-19cdH7z4kh0uwoxAx27-0plhiuCrhc-PwgkuQZ85m1SdOXP3TTp0H7dECeHTj6DImTsjSOj274yhiWz9AgExTGdBLtaUlwqjcAO3zDY_M7KqdTEyR0Q4M_Wp0SBvKNu4WxQA2ReCw1iAk8eVnx5mHsu1kxD8bc-wFAFXnlfBcm0_on6mp6kmBw0_u5Dg0ISZl8xnQPx1oKgIji0jbiQPGYFuCKoDrmLzmlecUOTWA6XoUfVOOjlgvBxxxdgJrMOAl73U45zLMwPFLVlG73kRhNirKmB0D96_dqVl9jY-_iPpiRtsGf6ZxvtBWws2k-gB8WA8SRv2Vs2L9V7oMqDpPsTOCJFmLEkqHfuv91a3k6fC1zjflXCppK1'
//    ];

    $client = new \GuzzleHttp\Client();
    $responseDataResult = $client->post(
      'http://103.92.122.78:8080/enterpriseconfig/Token',
      [
        'form_params' => [
          'username' => 'finserve@karan.com',
          'password' => 'SGVsbG9AMDEwM0A=',
          'grant_type' => 'password'
        ],
      ]
    );
    $responseDatas = json_decode($responseDataResult->getBody()->getContents());
    if (!empty($responseDatas)) {
      return $responseDatas->access_token;
    } else {
      return back()->withError('oops! token not generated!')->withInput();
    }
  }
}
