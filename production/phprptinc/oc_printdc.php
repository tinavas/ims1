<?php
include "config.php";
$q = "select * from oc_cobi where invoice = '$_GET[id]' ";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
{
	$party = $qr['party'];
	$date = date("d.m.Y",strtotime($qr['date']));
	$vno = $qr['vno'];
	$driver = $qr['driver'];
	$finaltotal = $qr['finaltotal'];
	$discount = $qr['discountamount'];
	$freight = $qr['freightamount'];
	$freighttype = $qr['freighttype'];
	$description = $qr['description'];
	if($discount == "")
	$discount = 0;
	if($freight == "")
	$freight = 0;
	if($driver == 0)
	$driver = "";
}

$q = "select address from contactdetails where name = '$party'";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$address1 = $qr['address'];
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
<script type="text/javascript">
	entree = new Date;
	entree = entree.getTime();
function calculateloadgingtime()
	{
		fin = new Date;
		fin = fin.getTime();
		php_time=(msec*1000)+(sec*1000);
		var secondes = (fin-entree+php_time)/1000;
		secondes=Math.round(secondes*1000)/1000;
		<?php if (@$sExport == "") { ?>
		document.getElementById("loadingpage").innerHTML = "(loaded in " + secondes + " second(s).)";
		<?php } ?>
		window.status='Page loaded in ' + secondes + ' seconde(s).';
		document.getElementById("time").innerHTML = "";
	}
window.onload = calculateloadgingtime;
</script>
<center>
<script>
document.write("<input type='button' " +
"onClick='window.print()' " +
"class='printbutton' " +
"value='Print This Page'/><br class='printbutton' /><br class='printbutton' />");
</script>

<!--<fieldset style="width:700px">-->
<center><?php include "reportheader.php";?></center>

<center><strong>Sales Receipt</strong></center><br />

<table width="601" border="0">
 <tr>
   <td width="287" align="left"><b>To </b><br /><?php echo $party . "<br/>" . $address1;?> </td>
   <td width="273" align="right"></td>
 </tr>
 <tr height="20px"><td></td></tr>
 <tr>
   <td width="287" align="left"><b>DC No. </b>&nbsp;&nbsp;<input type="text" style="background:none;border:none" size="12"/> </td>
   <td width="273" align="right"><b>Date </b> &nbsp;&nbsp;<input type="text" style="background:none;border:none" size="12" value="<?php echo $date;?>"/></td>
 </tr>
</table>
<br/>
<hr style="display:none">

<table width="601" border="0">
 <tr>
   <td width="287" align="left"> <b>Driver</b> &nbsp;&nbsp;<input type="text" style="background:none;border:none" size="12" value="<?php echo $driver;?>"/></td>

   <td width="273"  align="right"><b>Vehicle No.</b> &nbsp;&nbsp;<input type="text" style="background:none;border:none" size="12" value="<?php echo $vno;?>"/></td>
 </tr>
</table>
<br/>
<hr style="display:none">

<table width="700" border="1" style="text-align:left">
<thead>
<th width="43">SI.NO</th>
<th width="90">Item Code</th>
<th width="90">Item Description</th>
<th width="91">No. Of Birds</th>
<?php if($description == "BROILER BIRDS"){ ?>
<th width="91">Weight</th>
<?php } ?>
<th width="105">Rate Per Unit</th>
<th width="172">Amount</th>
</thead>
<tbody>
<?php 
   $num = 1;
   include "config.php";
  $querya = " SELECT code, description, SUM(weight) as weight , SUM(birds) as birds, price FROM oc_cobi WHERE invoice =  '$_GET[id]' group by price,code ";
   // $querya = "SELECT * FROM oc_cobi WHERE invoice = '$_GET[id]'";
   $resulta = mysql_query($querya,$conn1);
   while($rowa = mysql_fetch_assoc($resulta))
   {
?>
<tr>
<td align="left"><?php echo $num; ?></td>
<td align="center"><?php echo $rowa['code']; ?></td>
<td align="center"><?php echo $rowa['description']; ?></td>
<?php if($description == "BROILER BIRDS") {?>
<td align="right"><?php echo $rowa['birds']; ?>&nbsp;&nbsp;</td>
<td align="right"><?php echo $rowa['weight']; ?>&nbsp;&nbsp;</td>

<?php } else { ?>
<td align="right"><?php echo $rowa['weight']; ?>&nbsp;&nbsp;</td>
<?php } ?>
<td align="right"><?php echo $rowa['price']; ?>&nbsp;&nbsp;</td>
<?php /*?><td align="right"><?php echo $rowa['price'] * $rowa['birds'] ; ?>&nbsp;&nbsp;</td><?php */?>
<td align="right"><?php echo $rowa['price'] * $rowa['weight'] ; ?>&nbsp;&nbsp;</td>

</tr>
<?php $num = $num + 1; } ?>
</tbody>
<tfoot>
 <tr>
  <td></td>
  <td></td>
  <td></td>
  <?php if($description == "BROILER BIRDS"){ ?>
  <td></td>
  <?php } ?>
  <td></td>
  <td align="center"><b>Discount</b></td>
  <td align="right"><?php echo $discount;?>&nbsp;&nbsp;</td>
 </tr>
 <tr>
  <td></td>
  <td></td>
  <td></td>
  <?php if($description == "BROILER BIRDS"){ ?>
  <td></td>
  <?php } ?>

  <td></td>
  <td align="center"><b>Freight</b></td>
  <td align="right"><?php echo $freight;?>&nbsp;&nbsp;<?php if($freighttype != "-Select-" && $freighttype != "") { ?><br />(<?php echo $freighttype;?>&nbsp;&nbsp;)<?php } ?></td>
 </tr>

 <tr>
  <td></td>
  <td></td>
  <td></td>
  <?php if($description == "BROILER BIRDS"){ ?>
  <td></td>
  <?php } ?>
  <td></td>
  <td align="center"><b>Total</b></td>
  <td align="right"><?php echo $finaltotal;?>&nbsp;&nbsp;</td>
 </tr>
</tfoot>
</table>


<table>
<tr>
<td>
<table border="0" width="227" height="60">
<tr><td>
<br /><br /><br />
<hr width="200" />
<b>For
PRAGATHI HATCHERIES
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
<b>RECEIVED BY</b> 
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
 <!--</fieldset>-->
 </center>
 <div align="center" id="loadingpage"></div>
</body>
</html>
<?php
list($time_end_msec, $time_end_sec) = explode(" ", microtime());
$diff=$time_end_sec-$time_start_sec;
$diffm=$time_end_msec-$time_start_msec;
if($diffm<0) {$diff--;  echo "<script> var sec=$diff;var msec=".substr($diffm,1).' </script>' ;}
else echo "<script> var sec=$diff;var msec=$diffm;".' </script>' ;
?>