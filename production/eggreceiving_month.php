<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "getemployee.php";
 if($_GET['hatchery'] <> "")
 $hatchery = $_GET['hatchery'];
 else
 $hatchery ='Hatchery';
 
 if($_GET['year'] <> "")
 $year = $_GET['year'];
 else
 $year =date("Y");
 
 if($_GET['flock'] <> "" && $_GET['flock']!='All')
 $cond = "and flock ='".$_GET[flock]."'";
 else
 $cond ='';
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
 <td align="center"><strong><font color="#3e3276">Hatching Eggs Details of <?php echo $year ?></font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td align="center"><strong><font color="#3e3276">Flock : <?php if($_GET[flock] <> '') echo $_GET[flock]; else echo 'All' ?></font></strong></td>
</tr>
</table>

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
&nbsp;&nbsp;<a href="eggreceiving_month.php?export=html&year=<?php echo $year; ?>&flock=<?php echo $_GET[flock]; ?>&hatchery=<?php echo $hatchery; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="eggreceiving_month.php?export=excel&year=<?php echo $year; ?>&flock=<?php echo $_GET[flock]; ?>&hatchery=<?php echo $hatchery; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="eggreceiving_month.php?export=word&year=<?php echo $year; ?>&flock=<?php echo $_GET[flock]; ?>&hatchery=<?php echo $hatchery; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="eggreceiving_month.php?cmd=reset&year=<?php echo $year; ?>&flock=<?php echo $_GET[flock]; ?>&hatchery=<?php echo $hatchery; ?>">Reset All Filters</a>
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
 
 <td> Year </td>
 <td><select onchange="reloadpage()" id="year">
 
 <option <?php if($year=='2011') echo 'selected="selected"' ?> value="2011" >2011</option>
  <option <?php if($year=='2012') echo 'selected="selected"' ?> value="2012" >2012</option>
   <option <?php if($year=='2013') echo 'selected="selected"' ?> value="2013" >2013</option>
    <option <?php if($year=='2014') echo 'selected="selected"' ?> value="2014" >2014</option>
	 <option <?php if($year=='2015') echo 'selected="selected"' ?> value="2015" >2015</option>
	  <option <?php if($year=='2016') echo 'selected="selected"' ?> value="2016" >2016</option>
	   <option <?php if($year=='2017') echo 'selected="selected"' ?> value="2017" >2017</option>

 </select></td>
 
 <td> Hatchery </td>
 <td><select onchange="reloadpage()" id="hatchery">
 <?php
 include 'config.php';
 $q="select sector from tbl_sector where type1='Hatchery'";
 $r=mysql_query($q);
 while($a=mysql_fetch_array($r)) {
 ?>
 <option value="<?php echo $a[sector] ?>" ><?php echo $a[sector] ?></option>
 <?php } ?>
 </select></td>
 <td>&nbsp;&nbsp;</td>
 <td> Flock </td>
 <td><select onchange="reloadpage()" id="flock">
 <option <?Php if($_GET['flock']=='All') echo 'selected="selected"'; ?> value="All" >All</option>
 <?php
 echo $q="select distinct(flkmain) as flkmain from breeder_flock order by flkmain";
 $r=mysql_query($q);
 while($a=mysql_fetch_array($r)) {
 ?>
 <option  <?Php if($_GET['flock']==$a[flkmain]) echo 'selected="selected"'; ?> value="<?php echo $a[flkmain] ?>" ><?php echo $a[flkmain] ?></option>
 <?php } ?>
 </select></td>
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Month
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Month</td>
			</tr></table>
		</td>
<?php } ?>
	
<?php  /*if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Hatchery
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Hatchery</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		From Warehouse
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">From Warehouse</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
	To Warehouse
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">To Warehouse</td>
			</tr></table>
		</td>
<?php } */ ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Opening Balance
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Opening Balance</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Receipt
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Receipt</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Hatch Eggs
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Hatch Eggs</td>
			</tr></table>
		</td>
<?php } ?>
<?php
$query="select code from ims_itemcodes where cat='Hatch Eggs'";
$result=mysql_query($query);
$i=-1;
while($array=mysql_fetch_assoc($result))
 {
 $hatcheggcode[++$i]=$array[code];
 }
 $query="SELECT distinct(tocode),lower(todescription) as todescription FROM ims_eggreceiving where client = '$client'  and date like '$year-%' and tocode not in (select code from ims_itemcodes where cat='Hatch Eggs') order by tocode";
$result=mysql_query($query);
$eggcodecount=-1;
while($array=mysql_fetch_assoc($result))
 {
 $eggcodecount++;
 $eggcode[$eggcodecount]=$array[tocode];
 $eggdescription[$eggcodecount]=$array[todescription];
 $eggqnty[$eggcodecount]=0;
 if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		<?php echo ucfirst($array[todescription]); ?>
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center"><?php echo ucfirst($array[todescription]); ?></td>
			</tr></table>
		</td>
<?php } } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Shortage Eggs
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Shortage Eggs</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Loading
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Loading</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Sale
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Sale</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Closing <br />
 Balance
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Closing <br />
 Balance</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php 

//opening calculation start

         $query1 = "SELECT sum(toeggs) as hatcheggs,sum(shortage) FROM ims_eggreceiving where tocode in (select code from ims_itemcodes where cat='hatch eggs') and date < '$year-01-01%' $cond";
           $result1 = mysql_query($query1,$conn1); 
		   if($array1=mysql_fetch_assoc($result1))
		    $totaleggs+=$hatcheggs=$array1[hatcheggs];

		  
		   for($i=0;$i<count($eggcode);$i++)
		   {
		   $query1 = "SELECT sum(toeggs) as eggs FROM ims_eggreceiving where tocode ='$eggcode[$i]' $cond and date < '$year-01-01%'";
           $result1 = mysql_query($query1,$conn1) or die(mysql_error()); 
		   if($array1=mysql_fetch_assoc($result1))
		     $eggqnty[$i]=$array1[eggs];
		   /*$query1 = "SELECT sum(quantity) as ir FROM ims_intermediatereceipt where date < '$year-01-01%' and code ='$eggcode[$i]' and riflag='R' $cond";
           $result1 = mysql_query($query1,$conn1) or die(mysql_error()); 
		   if($array1=mysql_fetch_assoc($result1))
		      $ir=$array1[ir]; if($ir=='') $ir=0;
			  
			  $query1 = "SELECT sum(quantity) as iss FROM ims_intermediatereceipt where date < '$year-01-01%' and code ='$eggcode[$i]' and riflag='I' $cond";
           $result1 = mysql_query($query1,$conn1) or die(mysql_error()); 
		   if($array1=mysql_fetch_assoc($result1))
		      $is=$array1[iss]; if($is=='') $is=0;
			  
			  $query1 = "SELECT sum(quantity) as stadd FROM ims_stockadjustment where date < '$year-01-01%' and code ='$eggcode[$i]' and type='Add' $cond";
           $result1 = mysql_query($query1,$conn1) or die(mysql_error()); 
		   if($array1=mysql_fetch_assoc($result1))
		      $stadd=$array1[stadd]; if($stadd=='') $stadd=0;
			  
			  $query1 = "SELECT sum(quantity) as stsub FROM ims_stockadjustment where date < '$year-01-01%' and code ='$eggcode[$i]' and type='Deduct' $cond";
           $result1 = mysql_query($query1,$conn1) or die(mysql_error()); 
		   if($array1=mysql_fetch_assoc($result1))
		      $stsub=$array1[stsub]; if($stsub=='') $stsub=0;*/
		   
		   // $eggqnty[$i]=$eggs+$stadd-$stsub+$ir-$is;		
		   
			if($eggqnty[$i]=='') $eggqnty[$i]=0; $totaleggs+=$eggqnty[$i];
		   } 
		  
        $query1 = "SELECT shortage as shortage FROM ims_eggreceiving where date < '$year-01-01%' $cond group by tid";
           $result1 = mysql_query($query1,$conn1); 
		   while($array1=mysql_fetch_assoc($result1))
		    $shortage+=$array1[shortage];
		   
		   
		 if($shortage=='') $shortage=0;  $totaleggs+=$shortage;
		   
		   $query1 = "SELECT sum(eggsset) as eggset FROM hatchery_traysetting where settingdate < '$year-01-01%' $cond";
           $result1 = mysql_query($query1,$conn1); 
		   if($array1=mysql_fetch_assoc($result1))
		      $trayseteggs+=$array1[eggset];
		   
		   $query1 = "SELECT sum(quantity) as ir FROM ims_intermediatereceipt where date < '$year-01-01%' and code in (select code from ims_itemcodes where cat='Hatch Eggs') and riflag='R' $cond";
           $result1 = mysql_query($query1,$conn1); 
		   if($array1=mysql_fetch_assoc($result1))
		      $ireceipt+=$array1[ir];
			  
			  $query1 = "SELECT sum(quantity) as packslip FROM oc_packslip where date < '$year-01-01%' and itemcode in (select code from ims_itemcodes where cat='Hatch Eggs') $cond";
           $result1 = mysql_query($query1,$conn1); 
		   if($array1=mysql_fetch_assoc($result1))
		      $packslip+=$array1[packslip];
			  
			  $query1 = "SELECT sum(quantity) as issue FROM ims_intermediatereceipt where date < '$year-01-01%' and code in (select code from ims_itemcodes where cat='Hatch Eggs') and riflag='I' $cond";
           $result1 = mysql_query($query1,$conn1); 
		   if($array1=mysql_fetch_assoc($result1))
		      $iissue+=$array1[issue];
			  
			  $query1 = "SELECT sum(quantity) as sales FROM oc_cobi where date < '$year-01-01%' and dflag=0 and code in (select code from ims_itemcodes where cat='Hatch Eggs') $cond";
           $result1 = mysql_query($query1,$conn1); 
		   if($array1=mysql_fetch_assoc($result1))
		      $sales+=$array1[sales];
			  
	$opbalance=$totaleggs-$sales- $trayseteggs-$packslip+$ireceipt-$iissue;
			  
// opening calculation endhomo




$month=0;
           while($month<12)
           {  
		  $ireceipt=$iissue=$totaleggs=$sales=$shortage=$trayseteggs=$packslip=0;
		   $month++;
		   if($month<10)
		    $month_q='0'.$month;
		   else
		    $month_q=$month;
			
           $query1 = "SELECT sum(toeggs) as hatcheggs,sum(shortage) FROM ims_eggreceiving where tocode in (select code from ims_itemcodes where cat='hatch eggs') and date like '$year-$month_q%' $cond";
           $result1 = mysql_query($query1,$conn1); 
		   if($array1=mysql_fetch_assoc($result1))
		    $totaleggs+=$hatcheggs=$array1[hatcheggs];

		  
		   for($i=0;$i<count($eggcode);$i++)
		   {
		   $query1 = "SELECT sum(toeggs) as eggs FROM ims_eggreceiving where tocode ='$eggcode[$i]' $cond and date like '$year-$month_q%'";
           $result1 = mysql_query($query1,$conn1); 
		   if($array1=mysql_fetch_assoc($result1))
		    $eggqnty[$i]=$array1[eggs];		
			
			$query1 = "SELECT sum(quantity) as ir FROM ims_intermediatereceipt where date like '$year-$month_q%' and code ='$eggcode[$i]' and riflag='R' $cond";
           $result1 = mysql_query($query1,$conn1) or die(mysql_error()); 
		   if($array1=mysql_fetch_assoc($result1))
		      $ir=$array1[ir]; if($ir=='') $ir=0;
			  
			  $query1 = "SELECT sum(quantity) as iss FROM ims_intermediatereceipt where date like '$year-$month_q%' and code ='$eggcode[$i]' and riflag='I' $cond";
           $result1 = mysql_query($query1,$conn1) or die(mysql_error()); 
		   if($array1=mysql_fetch_assoc($result1))
		      $is=$array1[iss]; if($is=='') $is=0;
			  
			  $query1 = "SELECT sum(quantity) as stadd FROM ims_stockadjustment where date like '$year-$month_q%' and code ='$eggcode[$i]' and type='Add' $cond";
           $result1 = mysql_query($query1,$conn1) or die(mysql_error()); 
		   if($array1=mysql_fetch_assoc($result1))
		      $stadd=$array1[stadd]; if($stadd=='') $stadd=0;
			  
			  $query1 = "SELECT sum(quantity) as stsub FROM ims_stockadjustment where date like '$year-$month_q%' and code ='$eggcode[$i]' and type='Deduct' $cond";
           $result1 = mysql_query($query1,$conn1) or die(mysql_error()); 
		   if($array1=mysql_fetch_assoc($result1))
		      $stsub=$array1[stsub]; if($stsub=='') $stsub=0;
			  
			  $eggqnty[$i]+=($stadd-$stsub+$ir-$is);	
			  
			if($eggqnty[$i]=='') $eggqnty[$i]=0; $totaleggs+=$eggqnty[$i];
		   } 
		  
        $query1 = "SELECT shortage as shortage FROM ims_eggreceiving where date like '$year-$month_q%' $cond group by tid ";
           $result1 = mysql_query($query1,$conn1); 
		   while($array1=mysql_fetch_assoc($result1))
		    $shortage+=$array1[shortage];
		   
		   
		 if($shortage=='') $shortage=0;  $totaleggs+=$shortage;
		   
		   $query1 = "SELECT sum(eggsset) as eggset FROM hatchery_traysetting where settingdate like '$year-$month_q%' $cond";
           $result1 = mysql_query($query1,$conn1); 
		   if($array1=mysql_fetch_assoc($result1))
		      $trayseteggs+=$array1[eggset];
		   
		    $query1 = "SELECT sum(quantity) as ir FROM ims_intermediatereceipt where date like '$year-$month_q%' and code in (select code from ims_itemcodes where cat='Hatch Eggs') and riflag='R' $cond";
           $result1 = mysql_query($query1,$conn1); 
		   if($array1=mysql_fetch_assoc($result1))
		      $ireceipt+=$array1[ir];
		   if($ireceipt==0) $ireceipt=0; 
		   
			  $query1 = "SELECT sum(quantity) as packslip FROM oc_packslip where date like '$year-$month_q%' and itemcode in (select code from ims_itemcodes where cat='Hatch Eggs') $cond";
           $result1 = mysql_query($query1,$conn1); 
		   if($array1=mysql_fetch_assoc($result1))
		      $sales+=$array1[packslip];
			  
			  $query1 = "SELECT sum(quantity) as issue FROM ims_intermediatereceipt where date like '$year-$month_q%' and code in (select code from ims_itemcodes where cat='Hatch Eggs') and riflag='I' $cond";
           $result1 = mysql_query($query1,$conn1); 
		   if($array1=mysql_fetch_assoc($result1))
		      $iissue+=$array1[issue];
			if($iissue=='') $iissue=0;  
			
			  $query1 = "SELECT sum(quantity) as sales FROM oc_cobi where date like '$year-$month_q%' and dflag=0 and code in (select code from ims_itemcodes where cat='Hatch Eggs') $cond";
           $result1 = mysql_query($query1,$conn1); 
		   if($array1=mysql_fetch_assoc($result1))
		      $sales+=$array1[sales];
		   if($sales=='') $sales=0;
?>
	<tr>
	<td class="ewRptGrpField2">
<?php  echo date("F",strtotime($year.'-'.$month_q.'-01')); ?></td>
<td class="ewRptGrpField2" align="right" style="padding-right:15px;">
<?php echo $opbalance; ?></td>
<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php echo changeprice1($totaleggs); $total+=$totaleggs; ?></td>
<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php if($hatcheggs=='') $hatcheggs=0; echo changeprice1($hatcheggs); $total_hatcheggs+=$hatcheggs;  ?></td>
<?php for($i=0;$i<count($eggcode);$i++) { ?>
<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php  if($eggqnty[$i]=='') $eggqnty[$i]=0;	 echo changeprice1($eggqnty[$i]); $$eggcode[$i]+=$eggqnty[$i];   $eggqnty[$i]=0;  ?></td><?php } ?>
<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php   echo changeprice1($shortage); $total_waste+=$shortage;  ?></td> 
<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php if($trayseteggs=='') $trayseteggs=0; echo changeprice1($trayseteggs);  $totaltrayseteggs+=$trayseteggs;?></td>
<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php  echo changeprice1($sales); $totalsales+=$sales; ?></td>
<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php $balance= $opbalance+$totaleggs-$trayseteggs-$sales+($ireceipt-$isssue); echo $balance; ?></td>
	</tr>
<?php
 $opbalance=$balance;}
?>
<tr>
		<td colspan="2" align="right" class="ewRptGrpField2">
<?php echo ewrpt_ViewValue(Total) ?></td>
<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php echo changeprice1($total); ?></td>
<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php echo changeprice1($total_hatcheggs);?></td>
<?php for($i=0;$i<count($eggcode);$i++) { ?>
<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php echo changeprice1($$eggcode[$i]); ?></td><?php } ?>
<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php echo changeprice1($total_waste); ?></td>
<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php echo changeprice1($totaltrayseteggs); ?></td>
<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php echo changeprice1($totalsales); ?></td>
<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php echo '&nbsp;' ?></td>
	</tr>
	</tbody>
	<tfoot>

 </tfoot>
</table>
</div>
</td></tr></table>
</div>
<?php if (@$sExport == "") { ?>
	</div><br /></td>
</tr>
</table>
<?php } include "phprptinc/footer.php"; ?>
<script type="text/javascript">
function reloadpage()
{
	var year=document.getElementById('year').value;
	var hatchery = document.getElementById('hatchery').value;
    var flock = document.getElementById('flock').value;
	document.location = "eggreceiving_month.php?year="+year+'&hatchery=' + hatchery+'&flock=' + flock;
}
</script>
