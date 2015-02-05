
<style type="text/css">
.female
{
background-color:#D5D8DB;

}
.male
{
background-color:#E7E7FF;

}

</style>
<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "config.php";
include "getemployee.php";
 
 $flock = $_GET['flock'];
$cullflock = 0;
if($flock == "")
 $flock = "live";
elseif($flock == "cull")
 $cullflock = 1;
 
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Flockwise Performance Report</font></strong></td>
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
<center>
&nbsp;&nbsp;<a href="flockwiseperformance.php?export=html&flock=<?php echo $flock; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="flockwiseperformance.php?export=excel&flock=<?php echo $flock; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="flockwiseperformance.php?export=word&flock=<?php echo $flock; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="flockwiseperformance.php?cmd=reset&flock=<?php echo $flock; ?>">Reset All Filters</a>
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
<form action="flockwiseperformance.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
	
	<table border="0" cellspacing="0" cellpadding="0"><tr>
<td>

<script type="text/javascript">
function reloadpage(a)
{
document.location="flockwiseperformance.php?flock=" + a; 
}
</script>

<span class="phpreportmaker">
Type&nbsp;&nbsp;
<select id="flock" onchange="reloadpage(this.value);">
 <option value="">-Select-</option>
 <option value="live" <?php if($flock == "live") { ?> selected="selected" <?php } ?>>Live Flocks</option>
 <option value="cull" <?php if($flock == "cull") { ?> selected="selected" <?php } ?>>Culled Flocks</option>
</select>
&nbsp;&nbsp;&nbsp;
</span>
</td>


	</tr>
</table>
</form>
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<th class="ewTableHeader">Flock</th>
         <?php 
            $f = 0;
			$q = "select distinct(flkmain) from breeder_flock where flkmain <> 'NULL' and flkmain <> ''  and flockcode in (select distinct(flock) from breeder_consumption)  order by flkmain";
			$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
			$query2 = "SELECT min(cullflag) AS mincullflag FROM breeder_flock WHERE flkmain = '$qr[flkmain]'";
			$result2 = mysql_query($query2,$conn1) or die(mysql_error());
			while($rows2 = mysql_fetch_assoc($result2))
			 $mincullflag = $rows2['mincullflag'];
			if($mincullflag == $cullflock)
			{ 
			if($_SESSION['cilent'] == "GOLDEN")
			{
              $flo[$f] = "-".$qr['flkmain'];
			}
			else
			{
			  $flo[$f] = $qr['flkmain'];
			}
			   $qbr = "select breed from breeder_flock where flockcode like '$qr[flkmain]' order by breed desc limit 1"; 
  		$qrsbr = mysql_query($qbr,$conn1) or die(mysql_error());
		while($qrbr = mysql_fetch_assoc($qrsbr))
		{
		$flkbreed[$f] = $qrbr['breed'];
		}
         ?>
	     <th class="ewTableHeader"><?php echo $qr['flkmain']; ?></th>
         <?php $f = $f + 1; } } ?>   
	<th class="ewTableHeader">Total</th>
	</thead>
	<tbody>

<tr>
	<td>Age</td>
         <?php 
            
			
			for($k = 0; $k < sizeof($flo); $k++)
			{
			$flockfinalid = "%".$flo[$k];
			$q = "select max(age) as age from breeder_consumption where flock like '$flockfinalid' "; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		if($qr = mysql_fetch_assoc($qrs))
		{
              $age = round($qr['age']);
             
            $age1[$k] = round($age / 7);
              
			  ?>
	     <td<?php echo $sItemRowClass1; ?>><?php echo $age1[$k]; ?></td>
         <?php 
		  }
		}
		 ?>   
	<td<?php echo $sItemRowClass1; ?>>&nbsp;</td>
</tr>


<tr>
	<td>Female Feed Consumed(Kgs) &nbsp;&nbsp;</td>
         <?php 
		 $totalfinalfeed = 0;
		 
for($k=0; $k <sizeof($flo); $k++)
{
$flockfinalid = "%".$flo[$k];
$query = "select ffeed as tot,fweight as femaleweight,mfeed as tot2,mweight as femaleweight from breeder_consumption where ( flock like '$flockfinalid' ) group by date2";
$totffeedd = 0;
$mfeedtott = 0;
$result = mysql_query($query,$conn1);
while($result1 = mysql_fetch_assoc($result))
{
$totffeedd +=$result1['tot'];
$mfeedtott += $result1['tot2'];
}
if($totffeedd)
$feed1[$k] = $totffeedd;
else
$feed1[$k] = 0;

if($mfeedtott)
$feed3[$k] = $mfeedtott;
else
$feed3[$k] = 0;

$query1 = "select sum(ffeedqty) as tot,sum(mfeedqty) as tot2 from breeder_initial where ( flock like '$flockfinalid' )";

$result1 = mysql_query($query1,$conn1);
$result2 = mysql_fetch_assoc($result1);
if($result2['tot'] or $result2['tot2'])
{
$feed2[$k] = $result2['tot'];
$feed4[$k] = $result2['tot2'];
}
else
{
$feed2[$k] = 0;
$feed4[$k]= 0;
}

?>
<td <?php echo $sItemRowClass; ?>><?php echo changeprice($feed1[$k]+$feed2[$k]);   $totalfinalfeed += $feed1[$k]+$feed2[$k]; ?>  </td>
<?php

}
?>
       
	<td<?php echo $sItemRowClass; ?> align="right"><?php echo changeprice($totalfinalfeed); ?></td>
</tr>

<tr>
	<td>Male Feed Consumed(Kgs) &nbsp;&nbsp;</td>
         <?php 
		 $totalfinalfeed = 0;
		 
for($k=0; $k <sizeof($flo); $k++)
{

?>
<td <?php echo $sItemRowClass; ?>><?php echo changeprice($feed3[$k]+$feed4[$k]);  $totalfinalfeed2 += $feed3[$k]+$feed4[$k]; ?>  </td>
<?php

}
?>
       
	<td<?php echo $sItemRowClass; ?> align="right"><?php echo changeprice($totalfinalfeed2); ?></td>
</tr>




<tr>
	<td class="female">Opening Female Birds</td>
      
	  <?php
$openingfemalefinal = 0;
for($k=0; $k <sizeof($flo); $k++)
{
$flockfinalid = "%".$flo[$k];
$fflloo = $flo[$k];

$flockget = $flo[$k];

$startfemale = 0;$startmale=0;
$query1 = "SELECT id FROM breeder_flock WHERE flockcode like '%$flockget' group by startdate,flockcode";
$result1 = mysql_query($query1,$conn1); 
$tcount = mysql_num_rows($result1);

if($tcount > 1)
{
  $query1 = "SELECT sum(femaleopening) as femaleopening,sum(maleopening) as maleopening,age,startdate FROM breeder_flock WHERE flockcode like '%$flockget' group by startdate,flockcode order by startdate desc";
  $result1 = mysql_query($query1,$conn1); 
  while($row11 = mysql_fetch_assoc($result1))  
  {
      $startdate = $row11['startdate'];
      $startage = $row11['age'];
      $startfemale = $startfemale + $row11['femaleopening'];
      $startmale = $startmale + $row11['maleopening'];
  }
}
else
{
  $query1 = "SELECT startdate,age,femaleopening,maleopening FROM breeder_flock WHERE flockcode like '%$flockget' order by startdate desc";
  $result1 = mysql_query($query1,$conn1); 
  while($row11 = mysql_fetch_assoc($result1))  
  {
      $startdate = $row11['startdate'];
      $startage = $row11['age'];
      $startfemale = $startfemale + $row11['femaleopening'];
      $startmale = $startmale + $row11['maleopening'];
  }
}

$querymin = "SELECT min(date2) as 'date2' FROM breeder_consumption WHERE flock like '%$flockget' ";
$resultmin = mysql_query($querymin,$conn1); 
while($row1min = mysql_fetch_assoc($resultmin))
{
 $mincmpdate = $row1min['date2'];
}

 $query1t = "SELECT sum(quantity) as quantity  FROM `ims_stocktransfer` WHERE cat ='Female Birds' AND  towarehouse like '%$flockget' and fromwarehouse not like '%$flockget' AND date < '$mincmpdate' ";
    $result1t = mysql_query($query1t,$conn1); 
  	while($row11t = mysql_fetch_assoc($result1t))  
  	{
	//echo "female tr in    ";echo 
	$startfemale = $startfemale + $row11t['quantity'];
	}
	   $query1t = "SELECT sum(quantity) as quantity  FROM `ims_stocktransfer` WHERE cat= 'Male Birds' AND  towarehouse like '%$flockget' and fromwarehouse not like '%$flockget' AND date < '$mincmpdate'  ";
    $result1t = mysql_query($query1t,$conn1); 
  	while($row11t = mysql_fetch_assoc($result1t))  
  	{
      
	  //echo "male tr in    ";echo 
	  $startmale = $startmale + $row11t['quantity'];
	  }


 $femalet = 0;$malet=0;
 $query1t = "SELECT  sum(receivedquantity) as receivedquantity FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat ='Female Birds') AND client = '$client' AND flock like '%$flockget' AND date<='$mincmpdate'";
  $result1t = mysql_query($query1t,$conn1); 
  while($row11t = mysql_fetch_assoc($result1t))  
  {
	  $femalet = $femalet + $row11t['receivedquantity'];
  }
   $query1t = "SELECT sum(receivedquantity) as receivedquantity FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat ='Male Birds') AND client = '$client' AND flock like '%$flockget' AND date<='$mincmpdate'";
  $result1t = mysql_query($query1t,$conn1); 
  while($row11t = mysql_fetch_assoc($result1t))  
  {
	  $malet = $malet + $row11t['receivedquantity'];
  }
   if($femalet > 0)
  {
  $startfemale = $startfemale +$femalet;
  }
   if($malet > 0)
  {
  $startmale = $startmale + $malet;
  }
$femaleopeningbirds[$k] = $startfemale;
$maleopenings[$k] = $startmale;

//Opening as on Production date
$query = "SELECT min(date1) as startdate FROM breeder_production WHERE flock LIKE '%$flockget' ";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$lstart = $rows['startdate'];

$lftrout = 0;
$query = "SELECT sum(quantity) as trout FROM ims_stocktransfer WHERE fromwarehouse LIKE '%$flockget' AND towarehouse NOT LIKE '%$flockget'  AND cat = 'Female Birds' and date < '$lstart' ";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$lftrout = $rows['trout'];

$lftrin = 0;
$query = "SELECT sum(quantity) as trin FROM ims_stocktransfer WHERE  fromwarehouse NOT LIKE '%$flockget'  AND towarehouse LIKE '%$flockget' AND cat = 'Female Birds' and date < '$lstart' ";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$lftrin = $rows['trin'];

$lfpur = 0;
$query = "SELECT sum(receivedquantity) as receivedquantity  FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat ='Female Birds')  AND flock like '%$flockget' AND date <= '$lstart' and  date >'$mincmpdate' ";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$lfpur  = $rows['receivedquantity'];

$lmpur = 0;
$query = "SELECT sum(receivedquantity) as receivedquantity  FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat ='Male Birds')  AND flock like '%$flockget' AND date <= '$lstart' and  date >'$mincmpdate' ";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$lmpur  = $rows['receivedquantity'];

$lfsales = 0;
$query = "SELECT sum(quantity) as sales FROM oc_cobi WHERE flock LIKE '%$flockget' AND date < '$lstart' AND code in (select distinct(code) from ims_itemcodes where cat = 'Female Birds') ";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$lfsales = $rows['sales'];

$lfmortality = 0;
$lfculls = 0;
$query = "SELECT fmort,fcull FROM breeder_consumption WHERE flock LIKE '%$flockget'  and date2 < '$lstart' group by date2,flock";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
$lfmortality = $lfmortality + $rows['fmort'];
$lfculls = $lfculls + $rows['fcull'];
}
$fmortalityi = 0;
$q = "SELECT sum(fmort) as fmorti,sum(mmort) as mmorti,sum(fcull) as fculli,sum(mcull) as mculli FROM breeder_initial WHERE flock LIKE '%$flockget'  and eggs = ''";
$r = mysql_query($q,$conn1) or die(mysql_error());
$cntrrows = mysql_num_rows($r);
if($cntrrows >0)
{
while($rows = mysql_fetch_assoc($r))
{
$fmortalityi += $rows['fmorti'];
$mmortalityi += $rows['mmorti'];
$fculli += $rows['fculli'];
$mculli += $rows['mculli'];
}
}

else
{
$fmortalityi = 0;
$mmortalityi = 0;
$fculli = 0;
$mculli = 0;
}

//echo $fopeningll."/".$lfmortality."/". $lfculls."/". $lftrout."/".$lftrin ."/".$lfpur ."/".$fmortalityi."/".$fculli;
if($_SESSION['client'] == "GOLDEN")
{

$lbirds[$k] = $startfemale - $lfmortality - $lfculls - $lftrout + $lftrin + $lfpur  - $fmortalityi - $fculli;
}
else
{
$lbirds[$k] = $startfemale - $lfmortality - $lfculls - $lftrout + $lftrin + $lfpur - $lfsales - $fmortalityi - $fculli;
}
//Production Opening Calculation ends here

$ftransferin = 0;$mtransferin = 0;
 $query1t = "SELECT sum(quantity) as quantity  FROM `ims_stocktransfer` WHERE cat ='Female Birds' AND  towarehouse like '%$flockget' and fromwarehouse not like '%$flockget' AND date >= '$mincmpdate' ";
    $result1t = mysql_query($query1t,$conn1); 
  	while($row11t = mysql_fetch_assoc($result1t))  
  	{
	//echo "female tr in    ";echo 
	$ftransferin = $ftransferin + $row11t['quantity'];
	}
	$ftrin[$k] = $ftransferin ;
	   $query1t = "SELECT sum(quantity) as quantity  FROM `ims_stocktransfer` WHERE cat= 'Male Birds' AND  towarehouse like '%$flockget' and fromwarehouse not like '%$flockget' AND date >= '$mincmpdate'  ";
    $result1t = mysql_query($query1t,$conn1); 
  	while($row11t = mysql_fetch_assoc($result1t))  
  	{
      
	  //echo "male tr in    ";echo 
	  $mtransferin = $mtransferin + $row11t['quantity'];
	  }
$mtrin[$k] = $mtransferin ;

$ftransferout = 0;$mtransferout = 0;
 $query1t = "SELECT sum(quantity) as quantity  FROM `ims_stocktransfer` WHERE cat ='Female Birds' AND  towarehouse not like '%$flockget' and fromwarehouse like '%$flockget' AND date >= '$mincmpdate' ";
    $result1t = mysql_query($query1t,$conn1); 
  	while($row11t = mysql_fetch_assoc($result1t))  
  	{
	//echo "female tr in    ";echo 
	$ftransferout = $ftransferout + $row11t['quantity'];
	}
	$ftrout[$k] = $ftransferout ;
	   $query1t = "SELECT sum(quantity) as quantity  FROM `ims_stocktransfer` WHERE cat= 'Male Birds' AND  towarehouse not like '%$flockget' and fromwarehouse like '%$flockget' AND date >= '$mincmpdate'  ";
    $result1t = mysql_query($query1t,$conn1); 
  	while($row11t = mysql_fetch_assoc($result1t))  
  	{
      
	  //echo "male tr in    ";echo 
	  $mtransferout = $mtransferout + $row11t['quantity'];
	  }
$mtrout[$k] = $mtransferout;

$fpurchase = 0;$mpurchase = 0;
 $query1t = "SELECT  sum(receivedquantity) as receivedquantity FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat ='Female Birds') AND client = '$client' AND flock like '%$flockget' AND date>'$mincmpdate'";
 
 
  $result1t = mysql_query($query1t,$conn1); 
  while($row11t = mysql_fetch_assoc($result1t))  
  {
	  $fpurchase = $fpurchase + $row11t['receivedquantity'];
  }
  
  $fpur[$k] = $fpurchase;
   $query1t = "SELECT sum(receivedquantity) as receivedquantity FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat ='Male Birds') AND client = '$client' AND flock like '%$flockget' AND date>='$mincmpdate'";
  $result1t = mysql_query($query1t,$conn1); 
  while($row11t = mysql_fetch_assoc($result1t))  
  {
	  $mpurchase = $mpurchase + $row11t['receivedquantity'];
  }
   $mpur[$k] = $mpurchase;


/*$query1 = "select female as openingbirds from breeder_initial where flock like '$flockfinalid'";

$birdsresult = mysql_query($query1,$conn1) or die(mysql_error());
if($birds = mysql_fetch_assoc($birdsresult))
$fopeningbirds = $birds['openingbirds'];

if(mysql_num_rows($birdsresult)>0)
 $femaleopeningbirds[$k] = $fopeningbirds ;
else
  {

   $query2 = "select sum(femaleopening) as fopeningbirds from breeder_flock where flkmain = '$fflloo'";
   
    $birdsresult1 = mysql_query($query2,$conn1) or die(mysql_error());
    
	if($birds2 = mysql_fetch_assoc($birdsresult1))
      $femaleopeningbirds[$k] = $birds2['fopeningbirds'];
     else 
      $femaleopeningbirds[$k] = 0;
  }
  
 $femalet = 0;$malet=0;
 $query1t = "SELECT * FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat ='Female Birds') AND client = '$client' AND flock like '%$fflloo'";
  $result1t = mysql_query($query1t,$conn1); 
  while($row11t = mysql_fetch_assoc($result1t))  
  {
	  $femalet = $femalet + $row11t['receivedquantity'];
  }
  
  $femaleopeningbirds[$k] +=  $femalet;*/
  
  ?>
  <td class = "female"><?php echo  changequantity($femaleopeningbirds[$k] + $fpur[$k]);
  		
   ?></td>
  <?php
  
}

?>   
<td class = "female"><?php echo changequantity($openingfemalefinal); ?></td>	     
       
	
</tr>


<tr>
	<td class = "female">Female Mortality</td>
       <?php 
$totalfemalemortality = 0;
$totalfemalecull = 0;
for($k = 0; $k<sizeof($flo);$k++)
{
$fmort = 0;
$fcull = 0;
$mmort = 0;
$mcull = 0;
$flockfinalid = "%".$flo[$k];
$query = "select fmort,fcull,mmort,mcull from breeder_consumption where  flock like '$flockfinalid' GROUP BY date2,flock";

$result1 = mysql_query($query,$conn1);
while($result2 = mysql_fetch_assoc($result1))
{
$fmort += $result2['fmort'];
$fcull += $result2['fcull'];
$mmort += $result2['mmort'];
$mcull += $result2['mcull'];
}
$femalemort[$k] = $fmort;
$femalecull[$k] = $fcull;
$malemort[$k] = $mmort;
$malecull[$k] = $mcull;
?>
<td class = "female"><?php echo changequantity($femalemort[$k]); $totalfemalemortality += $femalemort[$k]; $totalfemalecull += $femalecull[$k] ;?></td>
<?php
}
?> 

		
		   
	<td class = "female"><?php echo changequantity($totalfemalemortality); ?></td>
</tr>


<tr>
	<td class = "female" >Female Culls</td>
        <?php
		for($k=0;$k<sizeof($flo); $k++)
		{
		?>
		<td class = "female"><?php echo changequantity($femalecull[$k]);  ?></td>
		<?php
		}
		?>
		
		  
	<td class = "female"><?php echo changequantity($totalfemalecull); ?></td>
</tr>




<tr>
	<td class = "female">Closing Female Birds</td>
       <?php 
	    $closingbirds = 0;
	    
	   for($k=0;$k<sizeof($flo); $k++)
	   {
	    	$q12 = "SELECT sum(shortagefemale) - sum(excessfemale) AS female FROM breeder_birdsadjustment WHERE flock LIKE '%".$flo[$k]."'";
			$r12 = mysql_query($q12,$conn1) or die(mysql_error());
			$rr12 = mysql_fetch_assoc($r12);  
			$fadjust = $rr12['female'];
          $q = "select sum(quantity) as total from oc_cobi where  code in ( select distinct(code) from ims_itemcodes where description = 'Female Birds')"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
            
		   $qr = mysql_fetch_assoc($qrs);
    		   
		   if($qr['total'])
              $femaleclosing[$k] =  $qr['total'];
            else
              $femaleclosing[$k] = 0;
                       
	   
	   ?>
	   <td class = "female"><?php 
	   if($_SESSION['client'] == "GOLDEN") {
	    $closingbirds += ( $fpur[$k]+$femaleopeningbirds[$k] - $femalemort[$k] - $femalecull[$k] + $ftrin[$k] - $ftrout[$k]  );  echo changequantity($fpur[$k]+ $femaleopeningbirds[$k] - $femalemort[$k] - $femalecull[$k] + $ftrin[$k] - $ftrout[$k]+$fadjust );
		}
		else
		{
		 $closingbirds += ( $femaleopeningbirds[$k] - $femalemort[$k] - $femalecull[$k] -  $femaleclosing[$k] + $ftrin[$k] - $ftrout[$k] + $fpur[$k]);  echo changequantity( $femaleopeningbirds[$k] - $femalemort[$k] - $femalecull[$k] -  $femaleclosing[$k] + $ftrin[$k] - $ftrout[$k] + $fpur[$k]); 
		 } ?></td>
	   <?php
	  // $closingbirds = $fpur[$k]."YY".$closingbirds;
	   }
	   ?> 
	       
	<td class = "female"><?php echo changequantity($closingbirds); ?></td>
</tr>



<tr>
	<td class = "female">Female Body Weight(gms.)</td>
         <?php 
 for($k=0; $k<sizeof($flo);$k++)
 {      
    $flockfinalid = "%".$flo[$k];
$query = "select max(fweight) as femaleweight,max(mweight) as maleweight from breeder_consumption where ( flock like '$flockfinalid' )";
$result = mysql_query($query,$conn1);
$result1 = mysql_fetch_assoc($result);
$weight = $result1['femaleweight'];
$maleweight[$k] = $result1['maleweight'];
 ?>
 <td class = "female"><?php  $fbodyweight[$k] = $weight; echo changequantity($fbodyweight[$k]); ?> </td>
 <?php
  }      ?> 
	<td class = "female">&nbsp;</td>
</tr>



<tr>
	<td class = "female" title="Standard Female Body Weight">Std. Female Body Weight(gms.)</td>
      <?php
	  for($k=0;$k<sizeof($flo);$k++)
	  {
	  $sfbw = "0";
	  $smbw = 0;
			if($flkbreed[$k] != "")
			{
			$q = "select fweight,mweight from breeder_standards where age = '$age1[$k]' and breed ='$flkbreed[$k]'";
			}
			else
			{	  
			$q = "select fweight,mweight from breeder_standards where age = '$age1[$k]'";
			}
			
			$qrs = mysql_query($q,$conn1) or die(mysql_error());
			if($qr = mysql_fetch_assoc($qrs))
			{
				$sfbw = $qr['fweight'];
				$smbw = $qr['mweight'];
			}
			else
			{
			if($flkbreed[$k] != "")
			{
		$q = "select fweight,mweight from breeder_standards where age in (select max(age) from breeder_standards where breed ='$flkbreed[$k]'";
			}
			else
			{
			$q = "select fweight,mweight from breeder_standards where age in (select max(age) from breeder_standards)";
			}
			$qrs = mysql_query($q,$conn1) or die(mysql_error());
			if($qr = mysql_fetch_assoc($qrs))
			{
			$sfbw = $qr['fweight'];
			$smbw = $qr['mweight'];
			}
			
			}
	  ?>  
		<td class = "female"><?php $stdfw[$k] = $sfbw; $stdmw[$k] = $smbw; echo changequantity($stdfw[$k]); ?></td>
		<?php
		}
		?>
	<td class = "female">&nbsp;</td>
</tr>
<tr>
	<td class = "female" >Difference</td>
      <?php
	  for($k=0;$k<sizeof($flo);$k++)
	  {
	  $fdiff = round($fbodyweight[$k] - $stdfw[$k],2);
	  ?>
	  <td style="background-color:#D5D8DB; <?php if($fdiff < 0 ){ echo "color:#FF0000";} else { echo "color:Green";}?>"><?php echo changequantity($fdiff); ?> </td>
	  <?php
	  }
	  ?>
	<td class = "female">&nbsp;</td>
</tr>

<tr>
	<td class = "male">Opening Male Birds</td>
        <?php
		$totalmaleopenings = 0;
		for($k=0;$k<sizeof($flo); $k++)
		{
		$flockfinalid = "%".$flo[$k];
		$fflloo = $flo[$k];
		
/*$query1 = "select male as openingbirds from breeder_initial where flock like '$flockfinalid'";


$birdsresult = mysql_query($query1,$conn1) or die(mysql_error());
if($birds = mysql_fetch_assoc($birdsresult))
$fopeningbirds = $birds['openingbirds'];
if(mysql_num_rows($birdsresult)>0 && $fopeningbirds > 0)
 $maleopenings[$k] = $fopeningbirds ;
else
  {  
    $query2 = "select sum(maleopening) as openingbirds from breeder_flock where flkmain like '$fflloo'";
	
    $birdsresult3 = mysql_query($query2,$conn1) or die(mysql_error());
	 $birds = mysql_fetch_assoc($birdsresult3);
    if(mysql_num_rows($birdsresult3) > 0 && $birds['openingbirds'] > 0 )
	{
	    $maleopenings[$k] = $birds['openingbirds'];
      }
     else 
    
     $maleopenings[$k] = 0;
    
   }
    $query1t = "SELECT * FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat ='Male Birds') AND client = '$client' AND flock like '%$fflloo' ";
  $result1t = mysql_query($query1t,$conn1); 
  while($row11t = mysql_fetch_assoc($result1t))  
  {
	  $malet = $malet + $row11t['receivedquantity'];
  }
  $maleopenings[$k] += $malet;*/
   ?>
   
   <td class = "male"><?php echo changequantity($mpur[$k]); $totalmaleopenings +=  $mpur[$k]; ?> </td>
   <?php
   
   }
?> 
	<td class = "male"><?php echo changequantity($totalmaleopenings); ?></td>
</tr>



<tr>
	<td class = "male">Male Mortality</td>
         <?php 
		 $totalmalemortality = 0;
		 $totalmalecull = 0;
		 for($k=0;$k<sizeof($flo);$k++)
		 {
		?>
<td class = "male"><?php  echo changequantity($malemort[$k]); $totalmalemortality += $malemort[$k]; $totalmalecull += $malecull[$k] ;?> </td>
<?php } ?>
	<td class = "male"><?php echo changequantity($totalmalemortality); ?></td>
</tr>



<tr>
	<td class = "male">Male Culls</td>
         <?php 
		 for($k=0;$k<sizeof($flo);$k++)
		 {
		 ?>
		 <td class = "male"><?php echo changequantity($malecull[$k]); ?></td>
		 <?php
		 }
		 ?> 
	<td class = "male"><?php echo changequantity($totalmalecull); ?></td>
</tr>


<tr>
	<td class = "male">Closing Male Birds</td>
        <?php 
		$closingmale = 0;
		for($k=0;$k<sizeof($flo);$k++)
		{
 $q = "select sum(quantity) as total from oc_cobi where code in ( select distinct(code) from ims_itemcodes where description = 'Male Birds')"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
              $qr = mysql_fetch_assoc($qrs);
		    if($qr['total'])
               $mtransfer[$k] =  $qr['total'];
            else
              $mtransfer[$k] = 0;
			  
			$q11 = "SELECT sum(shortagemale) - sum(excessmale) AS male FROM breeder_birdsadjustment WHERE flock LIKE '%$flo[$k]'";
			$r11 = mysql_query($q11,$conn1) or die(mysql_error());
			$rr11 = mysql_fetch_assoc($r11);
			$madjust = $rr11['male'];
?>
<td class = "male"><?php
 if($_SESSION['client'] == "GOLDEN") {
  $closingmale += ($mpur[$k]+$madjust- $malemort[$k] - $malecull[$k] + $mtrin[$k] - $mtrout[$k]  );echo changequantity($mpur[$k]+$madjust- $malemort[$k] - $malecull[$k] + $mtrin[$k] - $mtrout[$k] );  } else {
  $closingmale += ($maleopenings[$k] - $malemort[$k] - $malecull[$k] - $mtransfer[$k] + $mtrin[$k] - $mtrout[$k] + $mpur[$k]);echo changequantity($maleopenings[$k] - $malemort[$k] - $malecull[$k] - $mtransfer[$k]+ $mtrin[$k] - $mtrout[$k] + $mpur[$k]); }  ?></td>
<?php
}
?> 
	<td class = "male"><?php echo changequantity($closingmale); ?></td>
</tr>


<tr>
	<td class = "male">Male Body Weight(gms.)</td>
  <?php
  for($k=0;$k<sizeof($flo);$k++)
  {
   
?>
<td class = "male"><?php echo changequantity($maleweight[$k]); ?></td>

<?php


	}	
		?>
	<td class = "male">&nbsp;</td>
</tr>


<tr>
	<td class = "male" title="Standard Male Body Weight">Std. Male Body Weight(gms.)</td>
        <?php
		for($k=0;$k<sizeof($flo);$k++)
		{
		
		?>
		<td class = "male"><?php  echo changequantity($stdmw[$k]);?></td>
		<?php
		}
		?>
	<td class = "male">&nbsp;</td>
</tr>

<tr>
	<td class = "male" >Difference</td>
      <?php
	  for($k=0;$k<sizeof($flo);$k++)
	  {
	  $mdiff = round($maleweight[$k] - $stdmw[$k],2);
	  ?>
	  <td style="background-color:#E7E7FF; <?php if($mdiff < 0 ){ echo "color:#FF0000";} else { echo "color:Green";}?>" ><?php echo $mdiff  ?></td>
	  <?php
	  }
	  ?>
	<td class = "male">&nbsp;</td>
</tr>

<tr><td <?php echo $sItemRowClass2; ?>>Hatch Eggs</td>
<?php 
$totalhatcheggsfinal = 0;
for($k=0;$k<sizeof($flo);$k++)
{
$flockfinalid = "%".$flo[$k];
$query = "select sum(quantity) as tot from breeder_production where flock like '$flockfinalid' and itemcode in (select code from ims_itemcodes where cat = 'Hatch Eggs')";
$result = mysql_query($query,$conn1);
$result = mysql_fetch_assoc($result);
if($result['tot'])
$hatchheggs = $result['tot'];
else
$hatchheggs = 0;

$index = 0;
$eggsquery = "select eggs from breeder_initial where ( flock like '$flockfinalid' and eggs <> '' and eggs <> 'NULL' ) ";
$eggsresult = mysql_query($eggsquery,$conn1) or die(mysql_error());
while($eggsmain = mysql_fetch_assoc($eggsresult))
{
$maineggs[$index] = $eggsmain['eggs'];
$index++;

}
$query = "select code from ims_itemcodes where cat = 'Hatch Eggs'";
$result = mysql_query($query,$conn1) or die(mysql_error());
if($eggcode = mysql_fetch_assoc($result)) 
   $itemcode = $eggcode['code'];
 $hatchinitial = 0;
 $tableinitial = 0;
  
for($j=0;$j<$index;$j++)
{
$sub1 = explode(',',$maineggs[$j]);
 for($l=0; $l < sizeof($sub1); $l++)
 { 
    $sub2 = explode(':',$sub1[$l]);
	if($itemcode == $sub2[0])
	 $hatchinitial +=  $sub2[1];
	 else
	 $tableinitial += $sub2[1];
	
	
 }
}

?>
<td <?php echo $sItemRowClass2; ?>><?php $counthatch[$k] = $hatchheggs + $hatchinitial; echo changequantity($counthatch[$k]); $totalhatcheggsfinal += $hatchheggs + $hatchinitial;?></td>
<?php

}
?>
	
	<td<?php echo $sItemRowClass2; ?>><?php echo changequantity($totalhatcheggsfinal); ?></td>
</tr>


<tr><td <?php echo $sItemRowClass2; ?>>Table Eggs</td>
<?php 
$totalhatcheggsfinal = 0;
for($k=0;$k<sizeof($flo);$k++)
{
$flockfinalid = "%".$flo[$k];
$query = "select sum(quantity) as tot from breeder_production where ( flock like '$flockfinalid' and itemcode not in (select code from ims_itemcodes where cat = 'Hatch Eggs') )";
$result = mysql_query($query,$conn1);
$result = mysql_fetch_assoc($result);
if($result['tot'])
$hatchheggs = $result['tot'];
else
$hatchheggs = 0;

$index = 0;
$eggsquery = "select eggs from breeder_initial where ( flock like '$flockfinalid' and eggs <> '' and eggs <> 'NULL' ) ";
$eggsresult = mysql_query($eggsquery,$conn1) or die(mysql_error());
while($eggsmain = mysql_fetch_assoc($eggsresult))
{
$maineggs[$index] = $eggsmain['eggs'];
$index++;

}
$query = "select code from ims_itemcodes where cat = 'Hatch Eggs'";
$result = mysql_query($query,$conn1) or die(mysql_error());
if($eggcode = mysql_fetch_assoc($result)) 
   $itemcode = $eggcode['code'];
 $hatchinitial = 0;
 $tableinitial = 0;
  
for($j=0;$j<$index;$j++)
{
$sub1 = explode(',',$maineggs[$j]);
 for($l=0; $l < sizeof($sub1); $l++)
 { 
    $sub2 = explode(':',$sub1[$l]);
	if($itemcode == $sub2[0])
	 $hatchinitial +=  $sub2[1];
	 else
	 $tableinitial += $sub2[1];
	
	
 }
}

?>
<td <?php echo $sItemRowClass2; ?>><?php  $counttable[$k] = $hatchheggs + $hatchinitial; echo changequantity($counttable[$k]); $totalhatcheggsfinal += $hatchheggs + $hatchinitial;?></td>
<?php

}
?>
	
	<td<?php echo $sItemRowClass2; ?>><?php echo changequantity($totalhatcheggsfinal); ?></td>
</tr>



<tr>
	<td<?php echo $sItemRowClass2; ?>>Cummulative HHP</td>
        <?php
		for($k=0;$k<sizeof($flo);$k++)
		{
		?>
		<td <?php echo $sItemRowClass2; ?>><?php echo round((($counthatch[$k]+$counttable[$k])/($femaleopeningbirds[$k]+$fpur[$k])),1) ?></td>	
		<?php }
		?>  
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>



<tr>
	<td<?php echo $sItemRowClass2; ?>>Act. Hatch Eggs Per Bird</td>
         <?php 
		 for($k=0; $k<sizeof($flo);$k++)
		 {?>
		 <td <?php echo $sItemRowClass2; ?>><?php $acthatch[$k] = round($counthatch[$k] / ($lbirds[$k]),2); echo $acthatch[$k];?></td>
		<?php }
			?>
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>


<tr>
	<td<?php echo $sItemRowClass2; ?>>Std. Hatch Eggs Per Bird</td>
         <?php 
		 $eggsquery = "select max(age) as maxage from breeder_standards  ";
$eggsresult = mysql_query($eggsquery,$conn1) or die(mysql_error());
while($eggsmain = mysql_fetch_assoc($eggsresult))
{
 $mxage = $eggsmain['maxage'];
}
		 for($k=0; $k<sizeof($flo);$k++)
		 {
		 
		   if($flkbreed[$k] != "")
			{
				 
		  if($age1[$k] <= $mxage)
		  {
		  $query = "select cumhhe from breeder_standards where age = '$age1[$k]' and  breed ='$flkbreed[$k]'";
		  }
		  else
		  {
		  $query = "select cumhhe from breeder_standards where age = '$mxage' and breed ='$flkbreed[$k]'";
		  }
		  }
		  else
		  {
		  if($age1[$k] <= $mxage)
		  {
		  $query = "select cumhhe from breeder_standards where age = '$age1[$k]'";
		  }
		  else
		  {
		  $query = "select cumhhe from breeder_standards where age = '$mxage'";
		  }
		  }
		  
		  $result = mysql_query($query,$conn1);
		  if($hatch = mysql_fetch_assoc($result))
		  $stdhat = $hatch['cumhhe'];
		  else
		  $stdhat = 0;
		 ?>
		 <td <?php echo $sItemRowClass2; ?>><?php $stdhatch[$k] = round($stdhat,2);  echo $stdhatch[$k];?> </td>
		<?php }
			?>
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>



<tr>
	<td >Difference</td>
         <?php
		 for($k=0;$k<sizeof($flo);$k++)
		 {
		  $hatchdiff = round($acthatch[$k] - $stdhatch[$k],2);
		 ?>
		 
		 <td style="<?php if($hatchdiff < 0 ){ echo "color:#FF0000";} else { echo "color:Green";}?>"><?php echo $hatchdiff; ?> </td> 
		 <?php
		 }
		 ?>
	<td>&nbsp;</td>
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
<?php include "phprptinc/footer.php"; ?>
<?php } ?>
