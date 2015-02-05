<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "config.php"; 
include "getemployee.php";
/*if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d");
if($_GET['todate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate = date("Y-m-d"); 
 */
 $cond3 = "where pen <> '' ";
  if($_GET['flock'] <> "")
 {
  $flock=$_GET["flock"];
  $cond3=$cond3." and flock = '".$flock."'";
   //$cond4=" flockcode = '".$flock."'";
  }
else
{
 $flock = ""; 
 $pen = "";
 }
 
 
 if($_GET['pen'] <> "")
 {
  $pen=$_GET["pen"];
  $cond2=" and pen = '".$pen."'";
  
  }
else
 $pen = ""; 

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
 <td colspan="2" align="center"><strong><font color="#3e3276">PenWise Feed Per Egg/Bird Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<?php if($flock<>"")
{?>
<tr>
 <td><strong><font color="#3e3276">Flock </font></strong>&nbsp;&nbsp;<?php echo $flock; ?>
</td></tr>
 <?php if($pen<>"") { ?>
 <tr>
 <td>
 <strong><font color="#3e3276">Pen </font></strong>&nbsp;&nbsp;<?php echo $pen; ?>
 </td>
 </tr>
<?php } } ?>

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
&nbsp;&nbsp;<a href="penwisefeedeggbird1.php?export=html&flock=<?php echo $flock; ?>&pen=<?php echo $pen; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="penwisefeedeggbird1.php?export=excel&flock=<?php echo $flock; ?>&pen=<?php echo $pen; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="penwisefeedeggbird1.php?export=word&flock=<?php echo $flock; ?>&pen=<?php echo $pen; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="penwisefeedeggbird1.php?cmd=reset&flock=<?php echo $flock; ?>&pen=<?php echo $pen; ?>">Reset All Filters</a>
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
 <td>Flock</td>
 <td><select name="flock" id="flock" style="width:100px;" onChange="reloadpage();">
     <option value="">-Select-</option>
	 <?php 
	 include "config.php";
	 $query = "select distinct(flock) from breeder_production order by flock";
	 $result = mysql_query($query,$conn1) or die(mysql_error());
	 while($rows = mysql_fetch_assoc($result))
	 {
	 ?>
	 <option value="<?php echo $rows['flock']; ?>" <?php if($flock == $rows['flock']) { ?> selected="selected" <?php } ?>><?php echo $rows['flock']; ?></option>
	 <?php } ?>
	 </select>	 </td>
	  <td>Pen</td>
 <td>
 <select id="pen" name="pen" onChange="reloadpage();">
 <option value="">All</option>
 <?php
 $query56 = "(SELECT Distinct(pen) as area FROM breeder_production  where flock='$flock'  and pen <>'' ) union (SELECT Distinct(pen) as area FROM breeder_consumption  where flock='$flock'  and pen <>'' ) ORDER BY 1,1 DESC;";
              $result = mysql_query($query56); 
              while($row = mysql_fetch_array($result))
              {  ?>
 <option value="<?php echo $row['area'] ?>" <?php if($row['area']==$pen) { ?> selected="selected" <?php } ?>><?php echo $row['area'] ?></option>
 <?php
 }
 ?>
 </select>
 </td>
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
		Flock
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Flock</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		Pen

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Pen</td>

			</tr></table>

		</td>

<?php } ?>

<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		Date

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Date</td>

			</tr></table>

		</td>

<?php } ?>

<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		Age

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Age</td>

			</tr></table>

		</td>

<?php } ?>



<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		F15 Opening

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>F15 Opening</td>

			</tr></table>

		</td>

<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		Classic Opening

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Classic Opening</td>

			</tr></table>

		</td>

<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		Male Opening

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Male Opening</td>

			</tr></table>

		</td>

<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		F15 Feed<br />(Kgs)

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>F15 Feed<br />(Kgs)</td>

			</tr></table>

		</td>

<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		Classic Feed<br />(Kgs)

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Classic Feed<br />(Kgs)</td>

			</tr></table>

		</td>

<?php } ?>

<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		F15 Eggs

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>F15 Eggs</td>

			</tr></table>

		</td>

<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		Classic Eggs

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Classic Eggs</td>

			</tr></table>

		</td>

<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		Table Eggs

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Table Eggs</td>

			</tr></table>

		</td>

<?php } ?>

<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		Total Eggs

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Total Eggs</td>

			</tr></table>

		</td>

<?php } ?>



<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		F15 Feed/Egg<br />(gms)

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>F15 Feed/Egg<br />(gms)</td>

			</tr></table>

		</td>

<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		Classic Feed/Egg<br />(gms)

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Classic Feed/Egg<br />(gms)</td>

			</tr></table>

		</td>

<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		Feed/Egg<br />(gms)

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Feed/Egg<br />(gms)</td>

			</tr></table>

		</td>

<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader" title="Cumulative Feed/Bird">

		C.Feed/Bird<br />(gms)

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td title="Cumulative Feed/Bird">C.Feed/Bird<br />(gms)</td>

			</tr></table>

		</td>

<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php 
$same='';
 $q0786="(SELECT Distinct(flock),pen FROM breeder_production  $cond3 $cond2  and pen <>'' ) union (SELECT Distinct(flock),pen FROM breeder_consumption  $cond3 $cond2  and pen <>'' ) ORDER BY 2,2 DESC;  "; 
$r0786=mysql_query($q0786);
while($row786=mysql_fetch_array($r0786))
{
$x_flock=$row786[0];

?>
<td class="ewRptGrpField1">

		<?php
		if($same<>$x_flock)
		{
		 echo ewrpt_ViewValue($x_flock); 
		 $same=$x_flock;
		 }
		 else
		 echo "&nbsp;"
		 ?>
		 

		</td>
		<td

		<td class="ewRptGrpField1">

		<?php echo ewrpt_ViewValue($row786['pen']); ?>

		</td>
<?php

            $q = "(select max(age) as age,max(date2) from breeder_consumption where flock = '$x_flock' and pen='$row786[pen]' order by date2 DESC)"; 

  		$qrs = mysql_query($q,$conn1) or die(mysql_error());

		while($qr = mysql_fetch_assoc($qrs))

		{

            $age = $qr['age'];

              //$age1 = $age % 7; 

              //$age = round($age / 7);

              $nrSeconds = $age * 24 * 60 * 60;

              $nrDaysPassed = floor($nrSeconds / 86400) % 7; 

              $nrWeeksPassed = floor($nrSeconds / 604800); 

              $nrYearsPassed = floor($nrSeconds / 31536000); 

			  

		 }

		  $mindate = "";

		  $maxdate = "";

	          $query14 = "(SELECT min(date1) as mindate,max(date2) as maxdate FROM breeder_consumption where flock = '$x_flock' and pen='$row786[pen]' and date1<>'' and date2<>'')";

              $result14 = mysql_query($query14,$conn1);  

              while($row14 = mysql_fetch_assoc($result14)) 

              {
			  if($row14['mindate']<>'')
			  {

                 $mindate = $row14['mindate'];

				 $maxdate = $row14['maxdate'];
				 }

              }

			  $flockdate1 = date('d-m-Y',strtotime($maxdate));
			  $flockdate=$maxdate;

         ?>

		<td class="ewRptGrpField1">

		<?php echo ewrpt_ViewValue($flockdate1); ?>

		</td>
		

		<td class="ewRptGrpField1">

		<?php echo $nrWeeksPassed; ?>.<?php echo $nrDaysPassed; ?>

		</td>

<?php

              //include "config.php";

              $feedtypes = "''";

              $eggtypes = "''";

			  $hatchegg = "''";



              $query14 = "SELECT * FROM breeder_flock where flockcode = '$x_flock'";

              $result14 = mysql_query($query14,$conn1);  

              while($row14 = mysql_fetch_assoc($result14)) 

              {

                 $femaleopening = $row14['femaleopening'];
                 $cfemaleopening = $row14['classicopening'];
             $maleopening = $row14['maleopening'];

              }
			  
			  		$copening2 = $fopening2 = $mopening2 = 0;
		
         $qj = "select sum(quantity) as quantity,code from breeder_flockdistribution where flock = '$x_flock'  and area='$row786[pen]'   group by code"; 
    	 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
		 while($qrj = mysql_fetch_assoc($qrsj))
               {
			    if($qrj['code'] == "FB101")
				{
				$copening2 = $qrj['quantity'];
				}
				else if($qrj['code'] == "FB102")
				{
				$fopening2 = $qrj['quantity'];
				}
				else if($qrj['code'] == "BREMB101")
				{
				$mopening2 = $qrj['quantity'];
				}
			   }

             $minus2 = 0; 
			 $minus12 = 0;
			 $cminus2 = 0; 
			 $cminus12 = 0;
			 $mminus2 = 0;
			
          $qj = "select sum(fmort) as fmort,sum(cmort) as cmort,sum(mmort) as mmort,flock,date from breeder_mortality where flock = '$x_flock' and date<'$flockdate'  and areacode='$row786[pen]'"; 
    	 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
		 while($qrj = mysql_fetch_assoc($qrsj))
         {
         $minus2 =  $qrj['fmort'];
		 $cminus2 =  $qrj['cmort'];
		 $mminus2 = $qrj['mmort'];
		 }
		 $m2 = $m2 + $mminus2;
		 $c2 = $c2 + $cminus2;
		 $f2 = $f2 + $minus2;
		 

            $fminus2 = $minus2;
			
            $ftransfer2 = 0;
			$cftransfer2 = 0;
			$cf2 = 0;
			$ft2 = 0;

             $qj = "select code,quantity from ims_stocktransfer where cat = 'Female Birds' and fromwarehouse = '$x_flock' and date<'$flockdate' and frompen='$row786[pen]'"; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrsj))
             {
		   while($qrj = mysql_fetch_assoc($qrsj))
    		   {
                 if($qrj['code'] == "FB101")
			     $cftransfer2 +=   $qrj['quantity'];
				 else
				 $ftransfer2 =   $qrj['quantity'];
				 
				 
				 $cf2 = $cf2 + $cftransfer2;
				 $ft2 = $ft2 + $ftransfer2;
               }
             }
            
			$ttransfer2 = 0;
			$cttransfer2 = 0;
			$ct2 = 0;
			$ftt2 = 0;

            $qj = "select code,quantity from ims_stocktransfer where cat = 'Female Birds' and towarehouse = '$x_flock' and date<'$flockdate'  and topen='$row786[pen]'"; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrsj))
             {
		   while($qrj = mysql_fetch_assoc($qrsj))
    		   {
                if($qrj['code'] == "FB101" )
                $cttransfer2 =  $qrj['quantity'];
				else
				$ttransfer2 =  $qrj['quantity'];
				
				
				$ct2 = $ct2 + $cttransfer2;
				$ftt2 = $ftt2 + $ttransfer2;
               }
             }

    $transfer2 = $cttransfer2 + $ttransfer2;
	$trans2 = $ftransfer2 + $cftransfer2;
	
	
			 $fquantfc2 = 0;
			 $cfquantfc2 = 0;

			 $q = "SELECT sum(receivedquantity) as quant,code FROM pp_sobi WHERE flock = '$x_flock' AND date<'$flockdate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Female Birds') group by code";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
                 if($qr['code'] == "FB101")
				 $cfquantfc2 =  $qr['quant'];
				 else
				 $fquantfc2 =  $qr['quant'];
               }
             }
			 

			 $fquantso2 = 0;
			 $cfquantso2 = 0;
			 $cfq2 = 0;
			 $fq2= 0;

			 $q = "SELECT sum(quantity) as quant,code FROM breeder_penwiselftdetails WHERE flock = '$x_flock' AND date<'$flockdate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Female Birds') and area='$row786[pen]' group by code";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
             if($qr['code']=="FB101")
			 $cfquantso2 =  $qr['quant'];
			 else
			 $fquantso2 =  $qr['quant'];
			 
			 
			 $cfq2 = $cfq2 + $cfquantso2;
			 $fq2 = $fq2 + $fquantso2;
               }
             }
	 

			 $q = "SELECT sum(shortagefemale) - sum(excessfemale) AS female,sum(shortageclassic) - sum(excessclassic) AS classic FROM breeder_birdsadjustment WHERE flock = '$x_flock' AND date<'$flockdate'  and area='$row786[pen]'";
			 $r = mysql_query($q,$conn1) or die(mysql_error());
			 $rr = mysql_fetch_assoc($r);
			 $fadjust2 = $rr['female'];
			 $cfadjust2 = $rr['female'];

			 

             $remaining2 = 0;
			 $cremaining2 = 0;

			 $remaining2 = $fopening2;
			 $cremaining2 = $copening2;

			 $ftot2 = $ftot2 + $remaining2;
			 $ctot2 = $ctot2 + $cremaining2;
             $classicbirds2[$x_flock] = $cremaining2;
			 $femalebirds2[$x_flock] = $remaining2;
             
			
		//Birds Calculation Ends
        //Male Birds
            $minus2 = $mminus2;
             $ftransfer12 = 0;
			 $mt2 = 0;
			 
             $qj = "select quantity from ims_stocktransfer where cat = 'Male Birds' and fromwarehouse = '$x_flock' and date<'$flockdate' and frompen='$row786[pen]'"; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrsj))
             {
		   while($qrj = mysql_fetch_assoc($qrsj))
    		   {
                $ftransfer12 =  $qrj['quantity'];
				$mt2 = $mt2 + $ftransfer12;
               }
             }
             $mtransfer2 = $ftransfer12;
             
             $tttransfer2 = 0;
			 $mtt2 = 0;
			 
             $qj = "select quantity from ims_stocktransfer where cat = 'Male Birds' and towarehouse = '$x_flock' and date<'$flockdate'  and topen='$row786[pen]'"; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrsj))
             {
		   while($qrj = mysql_fetch_assoc($qrsj))
    		   {
                $tttransfer2 =  $qrj['quantity'];
				$mtt2 = $mtt2 + $ttransfer2;
               }
             }
            $mttransfer2 = $tttransfer2;
		 $mquantfc2 = 0;
$q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$x_flock' AND date<'$flockdate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Male Birds')";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $mquantfc2 =  $qr['quant'];
               }
             }

			 

			  $mquantso2 = 0;
			  $mq2 = 0;
			 $q1 = "SELECT sum(quantity) as quant,code FROM breeder_penwiselftdetails WHERE flock = '$x_flock' AND date<'$flockdate'  AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Male Birds') and area='$row786[pen]' group by code";
             $r1 = mysql_query($q1,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r1))
             {
		   while($qr1 = mysql_fetch_assoc($r1))
    		   {
			 $mquantso2 =  $qr1['quant'];
			 $mq2 = $mq2 + $mquantso2;
               }
             }
						
			 $q = "SELECT sum(shortagemale) - sum(excessmale) AS male FROM breeder_birdsadjustment WHERE flock = '$x_flock' AND date<'$flockdate'  and area='$row786[pen]' ";
			 $r = mysql_query($q,$conn1) or die(mysql_error());
			 $rr = mysql_fetch_assoc($r);
			 $madjust2 = $rr['male'];
			 $mremaining2 = 0;

             $mremaining2 = $mopening2;
			 $mtot2 = $mtot2 + $mremaining2;
			 $malebirds2[$x_flock] = $mremaining2;
			 
			 $classic2 = $classicbirds2[$x_flock];
			 $f152 = $femalebirds2[$x_flock];
			 $male2 = $malebirds2[$x_flock];
	         
			// $openingbal = changequantity($classic2).'/'.changequantity($f152).'/'.changequantity($male2);
		
			 $tranin2 = $transfer2 + $ttransfer2 + $cfquantfc2 + $fquantfc2;
			 $tranout2 = $trans2 + $ftransfer2 + $mquantfc2;
			  $classic1=$flo=$ml=0; 
			 
			 
			
		
			 
		 $classic1=$flo=$ml=0; 
			 $fr1="select classic,f15,male from  breeder_finalization where  type='EXCESS' and flock = '$x_flock' AND date<'$flockdate'  and area='$row786[pen]'";
			 $res11= mysql_query($fr1,$conn1) or die(mysql_error());
			  
			 while($rw1=mysql_fetch_array($res11))
			 {
			 $classic1+=$rw1[0];
			 $flo+=$rw1[1];
			 $ml+=$rw1[2];
			 }
			 
			$cs=$fs=0;
			  $msh=0;  
		  $sh1="select classic,f15,male from  breeder_finalization where  type='SHORTAGE' and flock = '$x_flock' AND date<'$flockdate' and area='$row786[pen]'";
			 $ress=mysql_query($sh1,$conn1) or die(mysql_error());
			 while($rs1= mysql_fetch_array($ress))
			 {
			   $cs+=$rs1[0];
			   $fs+=$rs1[1];
			   $msh=$msh+$rs1[2];
			} 
		
			 $tranin2 = $transfer2 + $ttransfer2 + $cfquantfc2 + $fquantfc2;
			 $tranout2 = $trans2 + $ftransfer2 + $mquantfc2;
		//Male Birds Ends
//echo "</br>";		    echo $f152."/".$fminus2."/".$ttransfer2."/".$ftransfer2."/".$fs."/".$flo;echo "</br>";
			 $cob2 = $classic2 - $cminus2 + $cttransfer2+$cs - $cftransfer2 - $cfquantso2-$classic1;
			 $fob2 = $f152 - $fminus2 + $ttransfer2 - $ftransfer2+$fs - $fquantso2-$flo;
			 $mob2 = $male2 - $mminus2 - $mtransfer2 + $mttransfer2+$msh - $mquantso2-$ml;
			 
			// $ob = changequantity($cob2).'/'.changequantity($fob2).'/'.changequantity($mob2);
			 
//-------------------------End of Opening balance------------------------------------------			 


             

			  $ftin = $cftin=$ftout = $cftout = $ttin = $cttin = $ttout = $cttout = $fpur = $cfput= $mpur = 0;

			  $query14 = "SELECT sum(quantity) as ftin from ims_stocktransfer where towarehouse = '$x_flock' and date <= '$mindate' and cat = 'Female Birds'  and topen='row786[pen]' group by code";

              $result14 = mysql_query($query14,$conn1);  

              while($row14 = mysql_fetch_assoc($result14)) 

              {
			  if($row14['code'] == "FB101")
    			$cftin = $row14['ftin'];
				 else		  
			      $ftin = $row14['ftin'];

              }

			  $q = "SELECT sum(receivedquantity) as quant,code FROM pp_sobi WHERE flock = '$x_flock' AND date <= '$mindate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Female Birds') group by code";  

             $r = mysql_query($q,$conn1) or die(mysql_error());

			 if(mysql_num_rows($r))

             {

		   while($qr = mysql_fetch_assoc($r))

    		   {

			  if($qr['code'] == "FB101")
			$cfpur = $fpur + $qr['quant'];
             else
			 $fpur = $cfpur + $qr['quant'];

               }

             }

             else

             {

                $fpur = 0;
				$cfpur = 0;

             } 

			  

			  $query14 = "SELECT sum(quantity) as mtin from ims_stocktransfer where towarehouse = '$x_flock' and date <= '$mindate' and cat = 'Male Birds' and topen='row786[pen]' ";

              $result14 = mysql_query($query14,$conn1);  

              while($row14 = mysql_fetch_assoc($result14)) 

              {

                 $mtin = $row14['mtin'];

              }

			   $q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$x_flock' AND date <= '$mindate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Male Birds')";  

             $r = mysql_query($q,$conn1) or die(mysql_error());

			 if(mysql_num_rows($r))

             {

		   while($qr = mysql_fetch_assoc($r))

    		   {

			 $mpur = $mpur + $qr['quant'];

               }

             }

             else

             {

                $mpur = 0;

             } 


			  

              /*$query14 = "SELECT * FROM ims_itemcodes where cat = 'Female Feed'";

              $result14 = mysql_query($query14,$conn1);  

              while($row14 = mysql_fetch_assoc($result14)) 

              {

                 $feedtypes = $feedtypes . ",'" . $row14['code'] . "'";

              }



              $query14 = "SELECT * FROM ims_itemcodes where cat = 'Male Feed'";

              $result14 = mysql_query($query14,$conn1);  

              while($row14 = mysql_fetch_assoc($result14)) 

              {

                 $feedtypes = $feedtypes . ",'" . $row14['code'] . "'";

              }
*/


              $query14 = "SELECT * FROM ims_itemcodes where cat = 'Eggs'";

              $result14 = mysql_query($query14,$conn1);  

              while($row14 = mysql_fetch_assoc($result14)) 

              {

                 $eggtypes = $eggtypes . ",'" . $row14['code'] . "'";

              }



              $query14 = "SELECT * FROM ims_itemcodes where cat = 'Hatch Eggs'";

              $result14 = mysql_query($query14,$conn1);  

              while($row14 = mysql_fetch_assoc($result14)) 

              {

                 $hatchegg = $hatchegg . ",'" .$row14['code']."'";

              }

              

              $totalfeed=$ctotalfeed=$totalfeedm = 0;

             

              $query14 = "SELECT sum(ffeed) as feed,sum(cfeed) as cfeed,sum(mfeed) as mfeed FROM breeder_consumption where flock = '$x_flock' and pen='$row786[pen]'";

              $result14 = mysql_query($query14,$conn1);  

              while($row14 = mysql_fetch_assoc($result14)) 

              {

                 $totalfeed = $row14['feed'];
				 $ctotalfeed = $row14['cfeed'];
				 $totalfeedm = $row14['mfeed'];

              }




              $totaleggs = 0;

              $query14 = "SELECT sum(quantity) as 'eggs' FROM breeder_production where flock = '$x_flock' and pen='$row786[pen]' and itemcode in ($eggtypes)";

              $result14 = mysql_query($query14,$conn1);  

              while($row14 = mysql_fetch_assoc($result14)) 

              {

                 $totaleggs = $row14['eggs'];

              }



              $f15eggs = $classiceggs=$totalhatcheggs = 0;

            $query14 = "SELECT sum(quantity) as 'hatcheggs',itemcode FROM breeder_production where flock = '$x_flock' and pen='$row786[pen]' and itemcode in ($hatchegg) group by itemcode";

              $result14 = mysql_query($query14,$conn1);  

              while($row14 = mysql_fetch_assoc($result14)) 

              {
               if($row14['itemcode'] == "HE102" or $row14['itemcode'] == "F15")
                $f15eggs = $row14['hatcheggs'];
               else if($row14['itemcode'] == "HE101" or $row14['itemcode'] == "CLA")
                $classiceggs = $row14['hatcheggs'];
                 $totalhatcheggs += $row14['hatcheggs'];

              } 



              if($totalhatcheggs == '') { $totalhatcheggs = 0;}

			  if($totaleggs == '') { $totaleggs = 0;}

?>

		<td class="ewRptGrpField2" align="right" >

<?php  //echo ($cob2 + $ftin + $fpur); 
echo changequantity($fob2); ?>

<td class="ewRptGrpField2" align="right" >

<?php  //echo (($cfemaleopening + $cftin + $cfpur)); 
echo changequantity($cob2);
?>

</td>

		<td class="ewRptGrpField2" align="right" >

<?php  //echo (($mob2 + $mtin + $mpur)); 
echo changequantity($mob2); ?>

</td>

		<td class="ewRptGrpField2" align="right" >

<?php echo changequantity(round($totalfeed,2)); ?>

<td class="ewRptGrpField2" align="right" >

<?php echo changequantity(round($ctotalfeed,2)); ?>

</td>

		<td class="ewRptGrpField2" align="right" >

<?php echo changequantity($f15eggs); ?>

</td>
		<td class="ewRptGrpField2" align="right" >

<?php echo changequantity($classiceggs); ?>

</td>
		<td class="ewRptGrpField2"  align="right" >

<?php echo changequantity($totaleggs); ?>

</td>

		<td class="ewRptGrpField2" align="right" >

<?php echo changequantity($totaleggs + $totalhatcheggs); ?>

</td>

	

<?php

$q1 = "SELECT min(date1) as mindate FROM breeder_production WHERE flock = '$x_flock' AND itemcode in (select distinct(code) from ims_itemcodes where cat LIKE '%Eggs%') AND client = '$client' and pen='$row786[pen]'";

$r1 = mysql_query($q1,$conn1) or die(mysql_error());

$rows1 = mysql_fetch_assoc($r1);

$mindate = $rows1['mindate'];



$q2 = "SELECT SUM(ffeed) as quantity,sum(cfeed) as classic FROM breeder_consumption WHERE flock = '$x_flock' AND date2 >= '$mindate' and pen='$row786[pen]'";
$r2 = mysql_query($q2,$conn1) or die(mysql_error());
$rows2 = mysql_fetch_assoc($r2);
$totalfeed2 = $rows2['quantity'];
$ctotalfeed2 = $rows2['classic'];



if($mindate == "")
{
$totalfeed2 = 0;
$ctotalfeed2 = 0;
}

//echo $totalfeed."/".$ctotalfeed."/".$totalfeedm."/".$cob2."/".$mob2."/".$fob2;

?>

		<td class="ewRptGrpField2" align="right" >

<?php echo changequantity(round(($totalfeed2 * 1000)/$f15eggs,2)); ?>

</td>
<td class="ewRptGrpField2" align="right" >

<?php echo (round(($ctotalfeed2 * 1000)/$classiceggs,2)); ?>

</td>
		<td class="ewRptGrpField2" align="right" >

<?php echo (round((($totalfeed2 + $ctotalfeed2) * 1000)/($totaleggs + $totalhatcheggs),2)); ?>

</td>

	<td class="ewRptGrpField2" align="right" >

<?php echo (round((($totalfeed + $ctotalfeed + $totalfeedm) * 1000)/($cob2 + $mob2+ $fob2),2)); ?>

</td>





	</tr>
<?php }
?>
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
<?php include "phprptinc/footer.php"; ?>
<?php } ?>
<script type="text/javascript">
function reloadpage()
{

	var flock = document.getElementById('flock').value;
	var pen = document.getElementById('pen').value;
	if(flock=="")
	pen="";
	document.location = "penwisefeedeggbird1.php?flock=" + flock+ "&pen=" + pen;
	//document.location = "templet.php?fromdate=" + fdate + "&todate=" + tdate;
}
</script>