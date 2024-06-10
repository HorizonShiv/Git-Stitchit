<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
  <title>Untitled Document</title>
</head>

<body>
<table width="890" style="border-top:2px solid; border-color: #dedede; padding-top:17px;padding-bottom: 15px"
       cellspacing="0" cellpadding="0">
  <tr>
    <th width="886" bordercolor="#dedede" scope="col"
        style="font-family: Helvetica; font-weight: 500; font-size: 14px">
      <div align="left"
           style="font-weight: 500;font-family: Helvetica;line-height: 1.5; color:#353333">
        Dear {{ $name }}, <br/>
        <h3>Note!</h3>
        <p><b>Query : {{ $query }}</b></p>
        <p>I hope this email finds you well. I wanted to bring to your attention a discrepancy that we have identified
          in our records regarding the recent Invoice.<br/>
          It appears that there is a mismatch between the quantity and the corresponding amount.<br/>
          Please let us know at your earliest convenience so that we can work together to resolve this matter
          efficiently. Thank you for your prompt attention to this issue.
        </p>

        <p>Query Date: {{ date('d-m-Y') }}</p><br>

        Best Regards,<br/>
        Zedex Group Of Companies <br/>

      </div>
    </th>
  </tr>
</table>


</body>
</html>



