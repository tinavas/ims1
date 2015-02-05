<?php
include "config.php";
$q = "select * from oc_receipt where tid = '$_GET[id]' ";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
{
	$party = $qr['party'];
	$date = date("d.m.Y",strtotime($qr['date']));
	$amount = $qr['totalamount'];
	$cco = $qr['cheque'];
	$paymentmode = $qr['paymentmode'];
	$cheque = $qr['cheque'];
	if($paymentmode == "Cash")
	$cheque = "Cash";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Tulasi Technologies - BIMS</title>
<style type="text/css" media="print">
.printbutton {
  visibility: hidden;
  display: none;
}
</style>
<style type="text/css">
body{font-family:"Lucida Sans Unicode", "Lucida Grande", Verdana, Arial, Helvetica, sans-serif; font-size:12px; color:#555555;}
div.main{margin:30px auto; overflow:auto; width:700px;}
table.sortable{border:0; padding:0; margin:0;}
table.sortable td{padding:4px; width:120px; border-bottom:solid 1px #DEDEDE;}
table.sortable th{padding:4px;}
table.sortable thead{background:#e3edef; color:#333333; text-align:left;}
table.sortable tfoot{font-weight:bold; }
table.sortable tfoot td{border:none;}
</style>
</head>
<body>
<center>
<script>
document.write("<input type='button' " +
"onClick='window.print()' " +
"class='printbutton' " +
"value='Print This Page'/><br class='printbutton' /><br class='printbutton' />");
</script>

<!--<fieldset style="width:700px">-->
<center><?php include "reportheader.php";?></center><br />
<center> <strong>Cash Receipt</strong></center><br />

<table width="601" border="0">
 <tr>
   <td width="287" align="left"><b>Payee Name </b>&nbsp;&nbsp;<?php echo $party; ?></td>
   <td width="273" align="right"><b>Amount </b> &nbsp;&nbsp;<?php echo $amount; ?></td>
 </tr>
</table>
<br/>
<hr style="display:none">

<table width="601" border="0">
 <tr>
   <td width="287" align="left"><b>Cash/Cheque/Others:  &nbsp;&nbsp;<?php echo $cheque; ?></td>
   <td width="273" align="right"><b>Date:  &nbsp;&nbsp;<?php echo $date; ?></td>
 </tr>
</table>
<br/>
<hr style="display:none">

<table>
<tr>
<td>
<table border="0" width="227" height="60">
<tr><td>
<br /><br /><br />
<hr width="200" />
<b>PARTY SIGNATURE
</b>
</td></tr>
</table>
</td>
<td>
<table border="0" width="227" height="60">
<tr><td>
<br />

<b></b>
</td></tr>
</table>
</td>
<td>
<table border="0" width="227" height="60">
<tr><td>
<br /><br /><br />
<hr width="200" />
<b>CASHIER SIGNATURE</b> 
</td></tr></table>
</td>
</tr>
</table>

<!--</fieldset>-->
</center>
<br/>
<center>
 <!--<fieldset style="width:700px">-->
  <table width="700" align="left" height="50px">
   <tr><td width="700" align="left"><b></b></td>
   </tr>
  </table>
<!-- </fieldset>-->
 </center>
</body>
</html>
