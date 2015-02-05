 <html>
<head>
</head>
<body onLoad="loadfunctions();">
<?php
include "config.php";
$q = "select * from pp_payment where tid = '$_GET[id]'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
  $edate = $qr['date'];
  $edate = date("d.m.Y",strtotime($edate));
  $evendor = $qr['vendor'];
  $epaymentmethod = $qr['paymentmethod'];
  $etds = $qr['tds'];
  $echoice = $qr['choice'];
  $epaymentmode = $qr['paymentmode'];
  $ecode = $qr['code'];
  $ecode1 = $qr['code1'];
  $eamount = $qr['amount'];
  $echeque = $qr['cheque'];
  $ecdate = $qr['cdate'];
  $ecdate = date("d.m.Y",strtotime($ecdate));
  $doc_no=$qr['doc_no'];
  $description = $qr['description'];
  $remarks=$qr['remarks'];
  $flag = $qr['flag'];
 if($_SESSION['db'] == 'central') 
 { 
  $conversion = $qr['camount'];
  $eamount = $eamount / $conversion; 
 }    
}
?>
<script type="text/javascript">
var validate = 0;
var vendor = Array();
