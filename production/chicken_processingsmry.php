<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
if($_GET['date'] <> "")
 $date = date("Y-m-d",strtotime($_GET['date']));
else
 $date = date("Y-m-d");

?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php include "phprptinc/ewrcfg3.php"; ?>
<?php include "phprptinc/ewmysql.php"; ?>
<?php include "phprptinc/ewrfn3.php"; ?>
<?php include "phprptinc/header.php"; ?>
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Daily  Chicken Processing Report on <?php echo date("d.m.Y",strtotime($date)); ?></font></strong></td>
</tr>

</table>
<center><p style="padding-left:430px;color:red"> All amounts in <?php echo $_SESSION['currency'];?></p></center>

<?php
session_start();
$client = $_SESSION['client'];
?>
<?php
$sExport = @$_GET["export"]; // Load export request
if ($sExport == "html") {
	// Printer friendly
}
if ($sExport == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . EW_REPORT_TABLE_VAR .'.xls');
}
if ($sExport == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . EW_REPORT_TABLE_VAR .'.doc');
}
?>



<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0" align="center">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<?php } ?>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="chicken_processingsmry.php?export=html&date=<?php echo $date; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="chicken_processingsmry.php?export=excel&date=<?php echo $date; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="chicken_processingsmry.php?export=word&date=<?php echo $date; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="chicken_processingsmry.php?cmd=reset&date=<?php echo $date; ?>">Reset All Filters</a>
<?php } ?>
<?php } ?>
<br /><br />
<?php if (@$sExport == "") { ?>
</div></td></tr>
<!-- Top Container (End) -->
<tr>
	<!-- Left Container (Begin) -->
	<td valign="top"><div id="ewLeft" class="phpreportmaker">
	<!-- Left slot -->
	</div></td>
	<!-- Left Container (End) -->
	<!-- Center Container - Report (Begin) -->
	<td valign="top" class="ewPadding"><div id="ewCenter" class="phpreportmaker">
	<!-- center slot -->
<?php } ?>
<!-- summary report starts -->
<div id="report_summary">

<table class="ewGrid" cellspacing="0" align="center"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<table>
 <tr>
 <td>Date</td>
 <td><input type="text" name="date" id="fdate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($date)); ?>"  onchange="reloadpage();"/></td>
</tr>
</table>	  
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td colspan="4" valign="bottom" class="ewTableHeader" style="width:100px;"  align="center">
		Deboning
		</td>
<?php } else { ?>
		<td colspan="4" class="ewTableHeader"  align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Deboning</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td colspan="4" valign="bottom" class="ewTableHeader" style="width:100px;"  align="center">
		Neckcut
		</td>
<?php } else { ?>
		<td colspan="4" class="ewTableHeader"  align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Neckcut</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td colspan="4" valign="bottom" class="ewTableHeader" style="width:100px;"  align="center">
		Currycut
		</td>
<?php } else { ?>
		<td colspan="4" class="ewTableHeader"  align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Currycut</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td colspan="4" valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Lollipop
		</td>
<?php } else { ?>
		<td colspan="4" class="ewTableHeader"  align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Lollipop</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	
	<tr>
<?php if (@$sExport <> "") { ?>
		<td  valign="bottom" class="ewTableHeader" style="width:100px;">
		Name
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Name</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td  valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Weight</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Yeild%
		</td>
<?php } else { ?>
		<td  class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Yeild%</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td  valign="bottom" class="ewTableHeader" style="width:100px;">
		Name
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Name</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td  valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Weight</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Yeild%
		</td>
<?php } else { ?>
		<td  class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Yeild%</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td  valign="bottom" class="ewTableHeader" style="width:100px;">
		Name
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Name</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td  valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Weight</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Yeild%
		</td>
<?php } else { ?>
		<td  class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Yeild%</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td  valign="bottom" class="ewTableHeader" style="width:100px;">
		Name
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Name</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td  valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Weight</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Yeild%
		</td>
<?php } else { ?>
		<td  class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Yeild%</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	
	</thead>
	<tbody>
<?php 
{ ?>	
<tr  style="background-color:#D1D1E9">
		<td>
<?php echo ewrpt_ViewValue("Input") ?></td>
<?php
	 $query="SELECT sum(`birds`)  from `chicken_chickentransferdeboningip` where date='$date'";
	$result=mysql_query($query,$conn1);
	$row=mysql_fetch_array($result);
	

?>
		<td  align="right">
<?php  if($row[0]!="") echo ewrpt_ViewValue(changeprice1($row[0]));  else echo "0" ?></td>
<?php
	 $query="SELECT sum(`weight`)  from `chicken_chickentransferdeboningip` where date='$date'";
	$result=mysql_query($query,$conn1);
	$row=mysql_fetch_array($result);
	$dbwt=$row[0];
?>
	<td  align="right">
<?php  if($row[0]!="") echo ewrpt_ViewValue(changeprice($row[0])); else echo "0" ?></td>
<td  align="right">
<?php   echo  "&nbsp;" ?></td>


<td >
<?php echo ewrpt_ViewValue("Input") ?></td>
<?php
	 $query="SELECT sum(`birds`)  from `chicken_chickenneckcutip` where date='$date'";
	$result=mysql_query($query,$conn1);
	$row=mysql_fetch_array($result);

?>
		<td align="right">
<?php  if($row[0]!="") echo ewrpt_ViewValue(changeprice1($row[0])); else echo "0" ?></td>
<?php
	 $query="SELECT sum(`weight`)  from `chicken_chickenneckcutip` where date='$date'";
	$result=mysql_query($query,$conn1);
	$row=mysql_fetch_array($result);
	$neckwt=$row[0];
?>	<td  align="right">
<?php if($row[0]!="") echo  ewrpt_ViewValue($row[0]); else echo "0" ?></td>
		<td >
		<?php   echo  "&nbsp;" ?></td>
		<td >
<?php  echo ewrpt_ViewValue("Input") ?></td>
<?php
	 $query="SELECT sum(`birds`)  from `chicken_chickencurrycutip` where date='$date'";
	$result=mysql_query($query,$conn1);
	$row=mysql_fetch_array($result);
?>
	<td align="right">
<?php if($row[0]!="") echo  ewrpt_ViewValue(changeprice1($row[0])); else echo "0" ?></td>
<?php
	 $query="SELECT sum(`weight`)  from `chicken_chickencurrycutip` where date='$date'";
	$result=mysql_query($query,$conn1);
	$row=mysql_fetch_array($result);
	$currywt=$row[0];

?>
		<td  align="right">
<?php  if($row[0]!="") echo  ewrpt_ViewValue(changeprice($row[0])); else echo "0" ?></td>
<td  align="right">
<?php   echo  "&nbsp;" ?></td>
<td >
<?php echo ewrpt_ViewValue("Input") ?></td>
<?php
	 $query="SELECT sum(`birds`)  from `chicken_chickenlollipopip` where date='$date'";
	$result=mysql_query($query,$conn1);
	$row=mysql_fetch_array($result);
	

?>
	<td  align="right">
<?php if($row[0]!="")  echo  ewrpt_ViewValue(changeprice1($row[0]));else echo "0" ?></td>
<?php
	 $query="SELECT sum(`weight`)  from `chicken_chickenlollipopip` where date='$date'";
	$result=mysql_query($query,$conn1);
	$row=mysql_fetch_array($result);
	$lollipopwt=$row[0];
?>

		<td  align="right">
<?php if($row[0]!="") echo  ewrpt_ViewValue(changeprice($row[0])); else echo "0" ?></td>
<td  align="right">
<?php   echo  "&nbsp;" ?></td>


	</tr>
	<?php

	$query="SELECT `birds`, `weight`, `todescription` FROM `chicken_chickentransferdeboningop` where date='$date'";
	$result=mysql_query($query,$conn1);
	$oprows=mysql_num_rows($result);
	$query1="SELECT `birds`, `weight`, `todescription` FROM `chicken_chickenneckcutop` where date='$date'";
	$result1=mysql_query($query1,$conn1);
	$oprows1=mysql_num_rows($result1);
	$query2="SELECT `birds`, `weight`, `todescription` FROM `chicken_chickencurrycutop` where date='$date'";
	$result2=mysql_query($query2,$conn1);
	$oprows2=mysql_num_rows($result2);
	$query3="SELECT `birds`, `weight`, `todescription` FROM `chicken_chickenlollipopop` where date='$date'";
	$result3=mysql_query($query3,$conn1);
	$oprows3=mysql_num_rows($result3);
	$norows= max($oprows,$oprows1,$oprows2,$oprows3);
$i=0;

	while($row=mysql_fetch_array($result))
	{
		$deboning_name[$i]= $row['todescription'];
		$deboning_weight[$i]=$row['weight'];
		$deboning_qty[$i]=$row['birds'];
		$i++;
		if($i==$oprows)
		{
		
				while(($norows>$oprows) && ($i<$oprows))
				{
				$deboning_name[$i]="";
				$deboning_weight[$i]="";
				$deboning_qty[$i]="";
					$i++;	
				
				}
		
		}
		
	
	
	
	}
	
	
	$i=0;

	while($row=mysql_fetch_array($result1))
	{
		$neck_name[$i]= $row['todescription'];
		$neck_weight[$i]=$row['weight'];
		$neck_qty[$i]=$row['birds'];
		$i++;
		if($i==$oprows1)
		{
		
				while(($norows>$oprows1) && ($i<$oprows1))
				{
				$neck_name[$i]="";
				$neck_weight[$i]="";
				$neck_qty[$i]="";
					$i++;	
				
				}
		
		}
		
	
	
	
	}
	
	$i=0;

	while($row=mysql_fetch_array($result2))
	{
		$curry_name[$i]= $row['todescription'];
		$curry_weight[$i]=$row['weight'];
		$curry_qty[$i]=$row['birds'];
		$i++;
		if($i==$oprows1)
		{
		
				while(($norows>$oprows2) && ($i<$oprows2))
				{
				$curry_name[$i]="";
				$curry_weight[$i]="";
				$curry_qty[$i]="";
					$i++;	
				
				}
		
		}
		
	
	
	
	}
	$i=0;

	while($row=mysql_fetch_array($result3))
	{
		$lollipop_name[$i]= $row['todescription'];
		$lollipop_weight[$i]=$row['weight'];
		$lollipop_qty[$i]=$row['birds'];
		$i++;
		if($i==$oprows1)
		{
		
				while(($norows>$oprows3) && ($i<$oprows3))
				{
				$lollipop_name[$i]="";
				$lollipop_weight[$i]="";
				$lollipop_qty[$i]="";
					$i++;	
				
				}
		
		}
		
	
	
	
	}
	
	
	for($i=0;$i<$norows;$i++)
	{
	$deboning_yeild=($deboning_weight[$i]/$dbwt)*100;
	$neck_yeild=($neck_weight[$i]/$neckwt)*100;
	$curry_yeild=($curry_weight[$i]/$currywt)*100;
	$lollipop_yeild=($lollipop_weight[$i]/$lollipopwt)*100;
	$tdebqty=$tdebqty+$deboning_qty[$i];
	$tdebwt=$tdebwt+$deboning_weight[$i];
	$tneckqty=$tneckqty+$neck_qty[$i];
	$tneckwt=$tneckwt+$neck_weight[$i];
	$tcurryqty=$tcurryqty+$curry_qty[$i];
	$tcurrywt=$tcurrywt+$curry_weight[$i];
	$tlollipopqty=$tlollipopqty+$lollipop_qty[$i];
	$tlollipopwt=$tlollipopwt+$lollipop_weight[$i];

?>
	
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($deboning_name[$i]) ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(changeprice1($deboning_qty[$i])); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php if($deboning_weight[$i]!="")  echo  ewrpt_ViewValue(changeprice($deboning_weight[$i])); else echo "&nbsp;" ?></td>
<td class="ewRptGrpField1" align="right">
<?php if($deboning_weight[$i]!="")  echo ewrpt_ViewValue(changeprice($deboning_yeild)); else echo "&nbsp;" ?></td>

<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($neck_name[$i]); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(changeprice1($neck_qty[$i])); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php  if($neck_weight[$i]!="") echo ewrpt_ViewValue(changeprice($neck_weight[$i])); else echo "&nbsp;"  ?></td>
<td class="ewRptGrpField1" align="right">
<?php if($neck_weight[$i]!="") echo ewrpt_ViewValue(changeprice($neck_yeild)); else echo "&nbsp;"  ?></td>

<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($curry_name[$i]); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(changeprice1($curry_qty[$i])); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php if($curry_weight[$i]!="") echo  ewrpt_ViewValue(changeprice($curry_weight[$i]));  else echo "&nbsp;" ?></td>
<td class="ewRptGrpField1" align="right">
<?php if($curry_weight[$i]!="") echo ewrpt_ViewValue(changeprice($curry_yeild));  else echo "&nbsp;" ?></td>

<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($lollipop_name[$i]); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(changeprice1($lollipop_qty[$i])); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php if($lollipop_weight[$i]!="") echo  ewrpt_ViewValue(changeprice($lollipop_weight[$i]));  else echo "&nbsp;" ?></td>
<td class="ewRptGrpField1" align="right">
<?php if($lollipop_weight[$i]!="") echo ewrpt_ViewValue(changeprice($lollipop_yeild));  else echo "&nbsp;" ?></td>

	</tr>
	
	
	
	
	
<?php
}
$tdebyeild=($tdebwt/$dbwt)*100;
$tneckyeild=($tneckwt/$neckwt)*100;
$tcurryyeild=($tcurrywt/$currywt)*100;
$tlollipopyeild=($tlollipopwt/$lollipopwt)*100;
$totalipwt=$dbwt+$neckwt+$currywt+$lollipopwt;

?>
<tr>
<td class="ewRptGrpField2">
<b>Total</b></td>
		<td class="ewRptGrpField3" align="right"><b>
<?php if($tdebqty!="")  echo ewrpt_ViewValue(changeprice1($tdebqty)); else echo changeprice1("0"); ?></b>  </td>
		<td class="ewRptGrpField1" align="right"><b>
<?php if(tdebwt!="")  echo  ewrpt_ViewValue(changeprice($tdebwt)); else echo changeprice("0");?></b></td>
<td class="ewRptGrpField1" align="right"><b>
<?php if($tdebyeild!="")  echo ewrpt_ViewValue(changeprice($tdebyeild)); else echo changeprice("0"); ?></b></td>

<td class="ewRptGrpField2">
<b>Total</b></td>
		<td class="ewRptGrpField3" align="right"><b>
<?php if($tneckqty!="") echo ewrpt_ViewValue(changeprice1($tneckqty)); else echo changeprice1("0"); ?></b></td>
		<td class="ewRptGrpField1" align="right"><b>
<?php  if($tneckwt!="") echo ewrpt_ViewValue(changeprice($tneckwt)); else echo changeprice("0"); ?></b></td>
<td class="ewRptGrpField1" align="right"><b>
<?php if($tneckyeild!="") echo ewrpt_ViewValue(changeprice($tneckyeild)); else echo changeprice("0");  ?></b></td>

<td class="ewRptGrpField2">
<b>Total</b></td>
		<td class="ewRptGrpField3" align="right"><b>
<?php if($tcurryqty!="") echo ewrpt_ViewValue(changeprice1($tcurryqty)); else echo changeprice1("0"); ?></b></td>
		<td class="ewRptGrpField1" align="right"><b>
<?php if($tcurrywt!="") echo  ewrpt_ViewValue(changeprice($tcurrywt)); else echo changeprice("0");?></b></td>
<td class="ewRptGrpField1" align="right"><b>
<?php if($tcurryyeild!="") echo ewrpt_ViewValue(changeprice($tcurryyeild)); else echo changeprice("0"); ?></b></td>

<td class="ewRptGrpField2">
<b>Total</b></td>
		<td class="ewRptGrpField3" align="right"><b>
<?php if($tlollipopqty!="") echo ewrpt_ViewValue(changeprice1($tlollipopqty)); else echo changeprice1("0"); ?></b></td>
		<td class="ewRptGrpField1" align="right"><b>
<?php if($tlollipopwt!="") echo  ewrpt_ViewValue(changeprice($tlollipopwt)); else echo changeprice("0");?></b></td>
<td class="ewRptGrpField1" align="right"><b>
<?php if($tlollipopyeild!="") echo ewrpt_ViewValue(changeprice($tlollipopyeild)); else echo changeprice("0");?></b></td>
</tr>

	</tbody>
	<tfoot>

 </tfoot>
</table>
<div class="ewGridLowerPanel">
<br />
<br />
<br />


<table class="ewTable ewTableSeparate" cellspacing="0" align="center" style="border:inherit">
<tr style="border:none">
<td style="border:none"><b>Vhl No</b></td><td width="15px"></td>
<td style="border:none"><b>Driver Name</b></td><td width="15px"></td>
<td style="border:none"><b>Company & farm</b></td><td width="15px"></td>
 <td style="border:none"><b>Challan No</b></td><td width="15px"></td>
<td style="border:none"><b>L.Bird</b></td><td width="15px"></td>
<td style="border:none"><b>L.weight</b></td><td width="15px"></td>
<td style="border:none"><b>Avg Wt.</b></td><td width="15px"></td>
<td style="border:none"><b>RATE</b></td><td width="15px"></td>
<td style="border:none"><b>D.birds</b></td><td width="15px"></td>
<td style="border:none"><b>Net L wt.</b></td><td width="15px"></td>
<td style="border:none"><b>WT.DIFF</b></td><td width="15px"></td>
<td  style="border:none"><b>SHRINKAGE%</b></td><td width="15px"></td>
<td style="border:none"><b>D.weight</b></td><td width="15px"></td>
<td style="border:none"><b>Avg Wgt</b></td><td width="15px"></td>
	<td style="border:none"><b>YEILD%</b></td>
</tr>


<?php

$query="select * from pp_sobi where date='$date' order by vendor ASC ";
$result=mysql_query($query,$conn1);
$num=mysql_num_rows($result);
while($row=mysql_fetch_array($result))
{
$avgwt=$row['sendweight']/$row['sentquantity'];
$weightdiff=$row['sendweight']-$row['weight'];
$shrinkage=($weightdiff/$row['sendweight'])*100;
$grandsqty=$grandsqty+$row['sentquantity'];
$grandswt=$grandswt+$row['sendweight'];
$grandrqty=$grandrqty+$row['receivedquantity'];
$grandrwt=$grandrwt+$row['weight'];
$grandrate=$grandrate+$row['rateperunit'];
$twastage=$twastage+$weightdiff;

?>
<tr>
<td style="border:none"><?php echo  ewrpt_ViewValue($row['vno']);?></td><td width="15px"></td>
<td style="border:none"><?php  echo  ewrpt_ViewValue($row['driver']);?></td><td width="15px"></td>
<td style="border:none"><?php  echo  ewrpt_ViewValue($row['vendor']);?></td><td width="15px"></td>
<td style="border:none"><?php  echo  ewrpt_ViewValue($row['invoice']);?></td><td width="15px"></td>
<td align="right" style="border:none"><?php  if($row['sentquantity']!="") echo  ewrpt_ViewValue(changeprice1($row['sentquantity'])); else echo changeprice1("0");  ?></td><td width="15px"></td>
<td align="right" style="border:none"><?php if($row['sendweight']!="")  echo  ewrpt_ViewValue(changeprice($row['sendweight']));  else echo changeprice("0");?></td><td width="15px"></td>
<td align="right" style="border:none"><?php  if($avgwt!="") echo  ewrpt_ViewValue(changeprice($avgwt));  else echo changeprice("0");?></td><td width="15px"></td>
<td align="right" style="border:none"><?php  if($row['rateperunit']!="") echo  ewrpt_ViewValue(changeprice($row['rateperunit']));  else echo changeprice("0");?></td><td width="15px"></td>
<td align="right" style="border:none"><?php  if($row['receivedquantity']!="") echo  ewrpt_ViewValue(changeprice1($row['receivedquantity']));  else echo changeprice1("0");?></td><td width="15px"></td>
<td align="right" style="border:none"><?php if($row['weight']!="")  echo  ewrpt_ViewValue(changeprice($row['weight']));  else echo changeprice("0");?></td><td width="15px"></td>
<td align="right" style="border:none"><?php if($weightdiff!="")  echo  ewrpt_ViewValue(changeprice(abs($weightdiff)));  else echo changeprice("0");?></td><td width="15px"></td>
<td align="right" style="border:none"><?php if($shrinkage!="")  echo  ewrpt_ViewValue(changeprice(abs($shrinkage)));  else echo changeprice("0");?></td><td width="15px"></td>

<td style="border:none"><?php /*?><?php  echo  ewrpt_ViewValue(changeprice($row1['weight']));?><?php */?></td><td width="15px"></td>
<td style="border:none"></td><td width="15px"></td>
<td style="border:none"></td>

</tr>

<?php
}

$grandavgwt=$grandswt/$grandsqty;
$tshrinkage=($twastage/$grandswt)*100;
?>
<tr style="15px"></tr>
<tr>
<td  style="border:none" align="left" colspan="8"><b>Total</b></td>
<td align="right" style="border:none"><b><?php if($grandsqty!="")  echo  ewrpt_ViewValue(changeprice1($grandsqty)); else echo ewrpt_ViewValue(changeprice1("0"));?></b></td><td width="15px"></td>
<td align="right" style="border:none"><b><?php  if($grandswt!="") echo  ewrpt_ViewValue(changeprice($grandswt)); else echo ewrpt_ViewValue(changeprice("0"));?></b></td><td width="15px"></td>
<td align="right" style="border:none"><b><?php  if($grandavgwt!="") echo  ewrpt_ViewValue(changeprice($grandavgwt)); else echo ewrpt_ViewValue(changeprice("0"));?></td></b><td width="15px"></td>
<td align="right" style="border:none"><b><?php  if(($grandrate/$num)!="") echo  ewrpt_ViewValue(changeprice($grandrate/$num)); else echo ewrpt_ViewValue(changeprice("0"));?></b></td><td width="15px"></td>
<td align="right" style="border:none"><b><?php  if($grandrqty!="") echo  ewrpt_ViewValue(changeprice1($grandrqty)); else echo ewrpt_ViewValue(changeprice1("0"));?></b></td><td width="15px"></td>
<td align="right" style="border:none"><b><?php  if($grandrwt!="") echo  ewrpt_ViewValue(changeprice($grandrwt)); else echo ewrpt_ViewValue(changeprice("0"));?></b></td><td width="15px"></td>
<td align="right" style="border:none"><b><?php if($twastage!="") echo  ewrpt_ViewValue(changeprice(abs($twastage))); else echo ewrpt_ViewValue(changeprice("0"));?></b></td><td width="15px"></td>
<td align="right" style="border:none"><b><?php if($tshrinkage!="") echo  ewrpt_ViewValue(changeprice(abs($tshrinkage))); else echo ewrpt_ViewValue(changeprice("0"));?></b></td><td width="15px"></td>
<?php 

$query1="SELECT  sum(`weight`) as dweight FROM  `pp_sobi` WHERE code IN (SELECT code FROM ims_itemcodes WHERE cat LIKE  'Uncat%') and date='$date' ";
$result1=mysql_query($query1,$conn1) or die(mysql_error()) ;
$row1=mysql_fetch_array($result1);
 $tavgwt=$row1['dweight']/$grandrqty;
$tyeild=($row1['dweight']/$grandrwt)*100;
?>


<td style="border:none"><b><?php if($row1['dweight']!=0) echo  ewrpt_ViewValue(changeprice($row1['dweight'])); else echo ewrpt_ViewValue(changeprice("0")); ?></b></td><td width="15px"></td>
<td style="border:none"><b><?php if($tavgwt!=0) echo  ewrpt_ViewValue(changeprice($tavgwt)); else echo ewrpt_ViewValue(changeprice("0")); ?></b></td><td width="15px"></td>
<td style="border:none"><b><?php if($tyeild!=0) echo  ewrpt_ViewValue(changeprice($tyeild));else echo ewrpt_ViewValue(changeprice("0")); ?></b></td>

</table>
<br />
<br />
<br />

</div>

<?php
}


?>
<div class="ewGridLowerPanel">
<br />
<br />

<table class="ewTable ewTableSeparate" cellspacing="0" align="center" style="border:none">
<tr>
<td style="border:none" colspan="10" align="center"><b>Dressing Summary</b></td>
<td style="border:none" colspan="10" align="center"><b>Dressing Category Summary</b></td>
</tr>
<tr>
<td style="border:none"  align="left"><b>Description</b></td><td width="15px"></td>
<td style="border:none"  align="left"><b>Code</b></td><td width="15px"></td>
<td style="border:none" align="center"><b>Quantity</b></td><td width="15px"></td>
<td style="border:none" align="center"><b>Weight</b></td><td width="15px"></td>
<td style="border:none" align="center"><b>Yeild%</b></td><td width="15px"></td>
<td style="border:none"  align="left"><b>Description</b></td><td width="15px"></td>
<td style="border:none"  align="left"><b>Code</b></td><td width="15px"></td>
<td style="border:none" align="center"><b>Quantity</b></td><td width="15px"></td>
<td style="border:none" align="center"><b>Weight</b></td><td width="15px"></td>
<td style="border:none" align="center"><b>Yeild%</b></td><td width="15px"></td>



</tr>
<?php

$query="select birds as tbirds from `chicken_chickentransferdressing` where date='$date'";
$result=mysql_query($query,$conn1);
$row=mysql_fetch_array($result);

$query1="select weight as tweight from `chicken_chickentransferdressing` where date='$date'";
$result1=mysql_query($query1,$conn1);
$row1=mysql_fetch_array($result1);
$dresswt=$row1['tweight'];

$query2="select birds  as tbirds from `chicken_chickentransferdressingcategory` where date='$date'";
$result2=mysql_query($query2,$conn1);
$row2=mysql_fetch_array($result2);
$query3="select weight as tweight from `chicken_chickentransferdressingcategory` where date='$date'";
$result3=mysql_query($query3,$conn1);
$row3=mysql_fetch_array($result3);
$dresscatwt=$row3['tweight'];
?>
<tr >
<td align="left" style="border:none"><b>Input</b></td><td width="15px"></td>
<td style="border:none"  align="left"></td><td width="15px"></td>
<td align="center" style="border:none"><b><?php  echo  ewrpt_ViewValue(changeprice1($row['tbirds']));?></b></td><td width="15px"></td>
<td align="center" style="border:none"><b><?php  echo  ewrpt_ViewValue(changeprice($row1['tweight']));?></b></td><td width="15px"></td>
<td align="center" style="border:none"></td><td width="15px"></td>
<td align="left" style="border:none"><b>Input</b></td><td width="15px"></td>
<td style="border:none"  align="left"></td><td width="15px"></td>
<td align="center" style="border:none"><b><?php  echo  ewrpt_ViewValue(changeprice1($row2['tbirds']));?></b></td><td width="15px"></td>
<td align="center" style="border:none"><b><?php  echo  ewrpt_ViewValue(changeprice($row3['tweight']));?></b></td><td width="15px"></td>

<td align="center" style="border:none"></td><td width="15px"></td>
</tr>

<?php

$query="select distinct(tocode),todescription from `chicken_chickentransferdressing` where date='$date'";
$result=mysql_query($query,$conn1);
$dressing=mysql_num_rows($result);


 $query1="select distinct(tocode),todescription from `chicken_chickentransferdressingcategory`  where date='$date'";
$result1=mysql_query($query1,$conn1);
$dresscat=mysql_num_rows($result1);
$oprows=max($dressing,$dresscat);
  

$i=0;
while($row=mysql_fetch_array($result))
{
$q1="select sum(`quantity`) as quant from `chicken_chickentransferdressing`  where  date='$date' and tocode='$row[tocode]'";
$res1=mysql_query($q1,$conn1);
$r1=mysql_fetch_array($res1);

$q2="select sum(`kgs`) as wt from `chicken_chickentransferdressing`  where  date='$date' and tocode='$row[tocode]'";
$res2=mysql_query($q2,$conn1);
$r2=mysql_fetch_array($res2);


$dress_code[$i]=$row['tocode'];
$dress_name[$i]=$row['todescription'];
$dress_qty[$i]=$r1['quant'];
$dress_kgs[$i]=$r2['wt'];
$tdress_kgs=$tdress_kgs+$dress_kgs[$i];
$tdress_qty=$tdress_qty+$dress_qty[$i];
$i++;
if(($i==$dressing)&&($i<$oprows))
{
$dress_code[$i]="";
$dress_name[$i]="";
$dress_qty[$i]="";
$dress_kgs[$i]="";

}


}
$i=0;
while($row1=mysql_fetch_array($result1))
{

$q1="select sum(`quantity`) as quant from `chicken_chickentransferdressingcategory`  where  date='$date' and tocode='$row1[tocode]'";
$res1=mysql_query($q1,$conn1);
$r1=mysql_fetch_array($res1);

$q2="select sum(`kgs`) as wt from `chicken_chickentransferdressingcategory`  where  date='$date' and tocode='$row1[tocode]'";
$res2=mysql_query($q2,$conn1);
$r2=mysql_fetch_array($res2);


$dresscat_name[$i]=$row1['todescription'];
$dresscat_code[$i]=$row1['tocode'];
$dresscat_qty[$i]=$r1['quant'];
$dresscat_kgs[$i]=$r2['wt'];
$tdresscat_kgs=$tdresscat_kgs+$dresscat_kgs[$i];
$tdresscat_qty=$tdresscat_qty+$dresscat_qty[$i];
$i++;
if(($i==$dresscat)&&($i<$oprows))
{
$dresscat_code[$i]="";
$dresscat_name[$i]="";
$dresscat_qty[$i]="";
$dresscat_kgs[$i]="";

}


}

for($i=0;$i<$oprows;$i++)
{
$dress_yeild=($dress_kgs[$i]/$dresswt)*100;
$dresscat_yeild=($dresscat_kgs[$i]/$dresscatwt)*100;
?>

<tr>
<td align="left" style="border:none"><?php  if($dress_name[$i]!="") echo  ewrpt_ViewValue($dress_name[$i]); else echo "&nbsp;"?></td><td width="15px"></td>
<td align="left" style="border:none"><?php  if($dress_code[$i]!="") echo  ewrpt_ViewValue($dress_code[$i]); else echo "&nbsp;"?></td><td width="15px"></td>
<td align="center" style="border:none"><?php if($dress_qty[$i]!="")  echo  ewrpt_ViewValue(changeprice1($dress_qty[$i])); else echo "&nbsp;"?></td><td width="15px"></td>
<td align="center" style="border:none"><?php  if($dress_kgs[$i]!="") echo  ewrpt_ViewValue(changeprice($dress_kgs[$i])); else echo "&nbsp;"?></td><td width="15px"></td>
<td align="center" style="border:none"><?php if($dress_yeild!="") echo  ewrpt_ViewValue(changeprice($dress_yeild)); else echo "&nbsp;"?></td><td width="15px"></td>
<td align="left" style="border:none"><?php  if($dresscat_name[$i]!="") echo  ewrpt_ViewValue($dresscat_name[$i]); else echo "&nbsp;"?></td><td width="15px"></td>
<td align="left" style="border:none"><?php  if($dresscat_code[$i]!="") echo  ewrpt_ViewValue($dresscat_code[$i]); else echo "&nbsp;"?></td><td width="15px"></td>
<td align="center" style="border:none"><?php  if($dresscat_qty[$i]!="") echo  ewrpt_ViewValue(changeprice1($dresscat_qty[$i])); else echo "&nbsp;"?></td><td width="15px"></td>
<td align="center" style="border:none"><?php  if($dresscat_kgs[$i]!="") echo  ewrpt_ViewValue(changeprice($dresscat_kgs[$i])); else echo "&nbsp;" ?></td><td width="15px"></td>

<td align="center" style="border:none"><?php if($dresscat_yeild!="") echo  ewrpt_ViewValue(changeprice($dresscat_yeild)); else echo "&nbsp;"?></td><td width="15px"></td>
<?php
}

$tdressyeild=($tdress_kgs/$dresswt)*100;
$tdresscatyeild=($tdresscat_kgs/$dresscatwt)*100;

?>

<tr>
<td align="left" style="border:none" colspan="3"><b>Total</b></td><td width="15px"></td>
<td align="center" style="border:none"><b><?php if($tdress_qty!="")  echo  ewrpt_ViewValue(changeprice1($tdress_qty)); else echo ewrpt_ViewValue(changeprice("0"));?></b></td><td width="15px"></td>
<td align="center" style="border:none"><b><?php  if($tdress_kgs!="") echo  ewrpt_ViewValue(changeprice($tdress_kgs)); else echo ewrpt_ViewValue(changeprice1("0"));?></b></td><td width="15px"></td>
<td align="center" style="border:none"><b><?php if($tdressyeild!="") echo  ewrpt_ViewValue(changeprice($tdressyeild)); else echo ewrpt_ViewValue(changeprice1("0"));?></b></td><td width="15px"></td>
<td align="left" style="border:none" colspan="3"><b>Total</b></td><td width="15px"></td>
<td align="center" style="border:none"><b><?php  if($tdresscat_qty!="") echo  ewrpt_ViewValue(changeprice1($tdresscat_qty)); else echo ewrpt_ViewValue(changeprice("0"));?></b></td><td width="15px"></td>
<td align="center" style="border:none"><b><?php  if($tdresscat_kgs!="") echo  ewrpt_ViewValue(changeprice($tdresscat_kgs)); else echo ewrpt_ViewValue(changeprice1("0")); ?></b></td><td width="15px"></td>

<td align="center" style="border:none"><b><?php if($tdresscatyeild!="") echo  ewrpt_ViewValue(changeprice($tdresscatyeild)); else echo ewrpt_ViewValue(changeprice1("0"));?></b></td><td width="15px"></td>

</tr>
</table>
<br />
<br />
<br />

</div>

<div class="ewGridLowerPanel">
<br />
<br />

<table class="ewTable ewTableSeparate" cellspacing="0" align="center" style="border:none" >
<tr>
<td style="border:none" colspan="8" align="center"><b>Processing Summary</b></td>

</tr>
<tr>
<td style="border:none"  align="left"><b>Name</b></td><td width="15px"></td>
<td style="border:none" align="center"><b>Quantity</b></td><td width="15px"></td>
<td style="border:none" align="center"><b>Weight</b></td><td width="15px"></td>
<td style="border:none" align="center"><b>Yeild%</b></td><td width="15px"></td>

</tr>

<tr>
<td style="border:none"  align="left">Deboning</td><td width="15px"></td>

		<td style="border:none" align="center">
<?php if($tdebqty!="")  echo ewrpt_ViewValue(changeprice1($tdebqty)); else echo changeprice1("0"); ?>  </td><td width="15px"></td>
		<td style="border:none" align="center">
<?php if($tdebwt!="")  echo  ewrpt_ViewValue(changeprice($tdebwt)); else echo changeprice("0");?></td><td width="15px"></td>
<td style="border:none" align="center">
<?php if($tdebyeild!="")  echo ewrpt_ViewValue(changeprice($tdebyeild)); else echo changeprice("0"); ?></td><td width="15px"></td>
</tr>

</tr>

<tr>
<td style="border:none"  align="left">Neckcut</td><td width="15px"></td>
<td style="border:none" align="center">
<?php if($tneckqty!="") echo ewrpt_ViewValue(changeprice1($tneckqty)); else echo changeprice1("0"); ?></td><td width="15px"></td>
		<td style="border:none" align="center">
<?php  if($tneckwt!="") echo ewrpt_ViewValue(changeprice($tneckwt)); else echo changeprice("0"); ?></td><td width="15px"></td>
<td style="border:none" align="center">
<?php if($tneckyeild!="") echo ewrpt_ViewValue(changeprice($tneckyeild)); else echo changeprice("0");  ?></td><td width="15px"></td>

</tr>


<tr>
<td style="border:none"  align="left">Currycut</td><td width="15px"></td>
<td style="border:none" align="center">
<?php if($tcurryqty!="") echo ewrpt_ViewValue(changeprice1($tcurryqty)); else echo changeprice1("0"); ?></td><td width="15px"></td>
		<td style="border:none" align="center">
<?php if($tcurrywt!="") echo  ewrpt_ViewValue(changeprice($tcurrywt)); else echo changeprice("0");?></td><td width="15px"></td>
<td style="border:none" align="center">
<?php if($tcurryyeild!="") echo ewrpt_ViewValue(changeprice($tcurryyeild)); else echo changeprice("0"); ?></td><td width="15px"></td>

</tr>

<tr>
<td style="border:none"  align="left">Lollipop</td><td width="15px"></td>

<td style="border:none" align="center">
<?php if($tlollipopqty!="") echo ewrpt_ViewValue(changeprice1($tlollipopqty)); else echo changeprice1("0"); ?></td><td width="15px"></td>
		<td style="border:none" align="center">
<?php if($tlollipopwt!="") echo  ewrpt_ViewValue(changeprice($tlollipopwt)); else echo changeprice("0");?></td><td width="15px"></td>
<td style="border:none" align="center">
<?php if($tlollipopyeild!="") echo ewrpt_ViewValue(changeprice($tlollipopyeild)); else echo changeprice("0");?></td><td width="15px"></td>

</tr>
<?php
 $totalopwt=$tdebwt+$tcurrywt+$tlollipopwt+$tneckwt;
 $totalopqty=$tdebqty+$tneckqty+$tcurryqty+$tlollipopqty;
$totalopyeild=($totalopwt/$totalipwt)*100;
?>
<tr>
<td align="left" style="border:none"><b>Total</b></td><td width="15px"></td>
<td style="border:none" align="center"><b><?php if($totalopqty!="") echo ewrpt_ViewValue(changeprice1($totalopqty)); else echo changeprice1("0"); ?></b></td><td width="15px"></td>
<td style="border:none" align="center"><b><?php if($totalopwt!="") echo ewrpt_ViewValue(changeprice($totalopwt)); else echo changeprice("0"); ?></b></td><td width="15px"></td>

<td style="border:none" align="center"><b><?php if($totalopyeild!="") echo ewrpt_ViewValue(changeprice($totalopyeild)); else echo changeprice("0");?></b></td><td width="15px"></td>
</tr>

</table>
<br />
<br />

</div>



</td></tr></table>
</div>
<?php
function changeprice($num){
$pos = strpos((string)$num, ".");
if ($pos === false) { $decimalpart="00";}
else { $decimalpart= substr($num, $pos+1, 2); $num = substr($num,0,$pos); }

if(strlen($num)>3 & strlen($num) <= 12){
$last3digits = substr($num, -3 );
$numexceptlastdigits = substr($num, 0, -3 );
$formatted = makecomma($numexceptlastdigits);
$stringtoreturn = $formatted.",".$last3digits.".".$decimalpart ;
}elseif(strlen($num)<=3){
$stringtoreturn = $num.".".$decimalpart ;
}elseif(strlen($num)>12){
$stringtoreturn = number_format($num, 2);
}

if(substr($stringtoreturn,0,2)=="-,"){$stringtoreturn = "-".substr($stringtoreturn,2 );}
$a  = explode('.',$stringtoreturn);
$c = "";
if(strlen($a[1]) < 2) { $c = "0"; }
$stringtoreturn = $stringtoreturn.$c;
return $stringtoreturn;
}
	
	
function makecomma($input)
{
if(strlen($input)<=2)
{ return $input; }
$length=substr($input,0,strlen($input)-2);
$formatted_input = makecomma($length).",".substr($input,-2);
return $formatted_input;
}


function changeprice1($num){
$pos = strpos((string)$num, ".");

if(strlen($num)>3 & strlen($num) <= 12){
$last3digits = substr($num, -3 );
$numexceptlastdigits = substr($num, 0, -3 );
$formatted = makecomma1($numexceptlastdigits);
$stringtoreturn = $formatted.",".$last3digits;
}elseif(strlen($num)<=3){
$stringtoreturn = $num;
}elseif(strlen($num)>12){
$stringtoreturn = number_format($num, 2);
}


return $stringtoreturn;
}
	
	
function makecomma1($input)
{
if(strlen($input)<=3)
{ return $input; }
$length=substr($input,0,strlen($input)-2);
$formatted_input = makecomma($length).",".substr($input,-2);
return $formatted_input;
}



?>


<?php if (@$sExport == "") { ?>
	</div><br /></td>
</tr>
</table>
<?php include "phprptinc/footer.php"; ?>
<?php } ?>
<script type="text/javascript">
function reloadpage()
{
	
	var fdate = document.getElementById('fdate').value;
	
	document.location = "chicken_processingsmry.php?date=" + fdate;
}
</script>