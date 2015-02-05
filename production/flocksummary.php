<?php

include "config.php";
if($_SESSION['db'] == "albustanlayer")
{
$flkmain = $_GET['flock'];
$query = "SELECT flockcode FROM layer_flock WHERE flkmain = '$flkmain' and shedcode not in (select distinct(shedcode) from layer_shed where shedtype = 'LAYER') AND client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$flock = $rows['flockcode'];
}
else
 $flock = $_GET['flock'];
 
$url = "&flock=" . $_GET['flock'] ;

$agequery = "select max(age) as age from layer_pstandards where breed = '$breedi'";
			$resultage = mysql_query($agequery,$conn1) or die(mysql_error());
			$res = mysql_fetch_assoc($resultage);
			$maxagee = $res['age'];


session_start();$currencyunits=$_SESSION['currency'];
$client = $_SESSION['client'];
ob_start();

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
include "../getemployee.php";
?>
<?php include "reportheader.php"; ?>
<?php include "phprptinc/header.php"; ?>
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Flock Weekly Report</font></strong></td>
</tr>
<tr>
<td colspan="2" style="text-align:center" ><strong><font color="#3e3276" size="2"><?php if($_SESSION['db'] == "albustanlayer") { echo "Flock:"; } else { echo "Flock:"; } ?><?php echo $_GET['flock']; ?></font></strong></td>
</tr>
</table>
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
&nbsp;&nbsp;<a href="flocksummary.php?export=html<?php echo $url; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="flocksummary.php?export=excel<?php echo $url; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="flocksummary.php?export=word<?php echo $url; ?>">Export to Word</a><br /><br />
<?php } ?>
<?php include "phprptinc/ewrcfg3.php"; ?>
<?php include "phprptinc/ewmysql.php"; ?>
<?php include "phprptinc/ewrfn3.php";

            $agequery = "select max(age) as age from layer_pstandards";
			$resultage = mysql_query($agequery,$conn1) or die(mysql_error());
			$res = mysql_fetch_assoc($resultage);
			$maxagee = $res['age'];
//$fdatedump = $_POST['date2'];



?>
<center>
<table class="ewTable ewTableSeparate" cellspacing="0">
<thead>
	<tr>
	<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">&nbsp;
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">&nbsp;
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">&nbsp;
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">&nbsp;
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="2" align="center">
		Transfers
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td colspan="2" >Transfers</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">&nbsp;
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="2" align="center">
		Livability %
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"  ><tr>
			<td align="center" >Livability %</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="2" align="center">
		Production
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td align="center">Production</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  colspan="2" align="center">
		Production %
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"  ><tr>
			<td align="center">Production %</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="3" align="center">
		Egg/Bird
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="3" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td align="center">Egg/Bird</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="2" align="center">
		Feed/Bird
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Standard Feed/Bird" ><tr>
			<td align="center">Feed/Bird</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">&nbsp;
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">&nbsp;
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	<tr>

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
		Birds
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Birds</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Mortality
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Mortality</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Culls
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Culls</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Transfer-In">
		In
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Transfer-In">In</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Transfer-Out">
		Out
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td title="Transfer-Out">Out</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Sales
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>Sales</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Livability % Standard">
		Standard
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Livability % Standard" ><tr>
			<td>Standard</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Livability % Actual">
		Actual 
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Livability % Actual" ><tr>
			<td>Actual</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Week
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>Week</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cumulative Production">
		Cumulative
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Cumulative Production"><tr>
			<td>Cumulative</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Standard Production %">
		Standard
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Standard Production %" ><tr>
			<td>Standard</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Actual Production %">
		Actual
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Actual Production %" ><tr>
			<td>Actual</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Standard
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>Standard</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Actual
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>Actual</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Difference">
		Diff
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td title="Difference">Diff</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Standard Feed/Bird">
		Standard
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Standard Feed/Bird" ><tr>
			<td>Standard</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Actual Feed/Bird">
		Actual
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td title="Actual Feed/Bird">Actual</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Total Feed
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>Total Feed</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Feed/Egg
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>Feed/Egg</td>
			</tr></table>
		</td>
<?php } ?>
<!--<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Cost Incurred
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>Cost Incurred</td>
			</tr></table>
		</td>
<?php } ?> -->
	</tr>
	</thead>
	<tbody>

<?php
$mindatep = "";
$maxdatep = "";
$mindate = "";
$maxdate = "";
$minage = 0;
$maxage = 0;
 $query1 = "SELECT min(date1) as mindate,max(date1) as maxdate from layer_production where flock = '$flock' and client = '$client'  ";
      $result1 = mysql_query($query1,$conn1);
	  while($row2 = mysql_fetch_assoc($result1))
      {
	    $mindatep = $row2['mindate'];
		$maxdatep = $row2['maxdate'];
	  }
$mindatec = "";
$maxdatec = "";
 $query1 = "SELECT min(date2) as mindate,max(date2) as maxdate,min(age) as minage,max(age) as maxage from layer_consumption where  flock = '$flock' and client = '$client'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	    $mindatec = $row2['mindate'];
		$maxdatec = $row2['maxdate'];
		$maxage = $row2['maxage'];
		$minage = $row2['minage'];
	  }
	  if($mindatep <> "")
	  {
	  $query1 = "SELECT age from layer_consumption where date2 = '$mindatep' and flock = '$flock' and client = '$client'  ";
      $result1 = mysql_query($query1,$conn1);
	  while($row2 = mysql_fetch_assoc($result1))
      {
	    $maxage = $row2['age'];
	   }
	  }
	 $maxage = $maxage - 1;
	  $startweek = $minage/7;
	  $firstweek = $startweek;
	  $endweek = $maxage/7;
	  $endweek = $endweek + 1;
	  $span = $maxage - $minage;
	  if(($minage % 7) == 0)
	 {
	   $agefrom = $minage;
	   $ageto = $agefrom + 7;
	 } 
	 else
	 {
	   $agefrom = $minage;
	   $ageto = $minage + (8 - ($minage % 7));
	 }	 
?>
<?php
     $fopening = 0;
            $q = "select * from layer_flock where flockcode like '$flock' and client = '$client'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $fopening += $qr['femaleopening'];
             }
             
 
         $minus = 0; 
             $q = "select distinct(date2),fmort,fcull from layer_consumption where flock like '$flock' and client = '$client'  and date2 < '$mindatec' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $minus = $minus + $qr['fmort'] + $qr['fcull'];
             }

        
             $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Layer Birds' and client = '$client'  and fromwarehouse like '$flock' and date < '$mindatec'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ftransfer = $qr['quantity'];
               }
             }
             else
             {
                $ftransfer = 0;
             } 

             $q = "select sum(quantity) as 'quantity' from oc_cobi where flock like '$flock' and client = '$client'  and date < '$mindatec'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $tsale = $qr['quantity'];
               }
             }
             else
             {
                $tsale = 0;
             } 


             $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Layer Birds' and client = '$client'  and towarehouse like '$flock' and date < '$mindatec'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ttransfer = $qr['quantity'];
               }
             }
             else
             {
                $ttransfer = 0;
             } 

           $remaining = ($fopening - $minus - $ftransfer + $ttransfer) - $tsale;
			  $nxtbirds = $remaining;
?>
<?php
$minwkdate = "";
$maxwkdate = "";
$query1 = "SELECT  min(date2) as minwkdate,max(date2) as maxwkdate from layer_consumption where client = '$client' and flock like '$flock' and age >= '$agefrom' and age < '$ageto' ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	  $minwkdate = $row2['minwkdate'];
	   $maxwkdate = $row2['maxwkdate']; 
	  }
	  $toteggs = 0;
	  $totmort = 0;
	  $totcull = 0;
	  $tottrin = 0;
	  $tottrout = 0;
	  $totsale = 0;
	  $totcost = 0;
	  $totfeedstd = 0;
	  $totfeedkg = 0;
		 

while($agefrom <= $maxage )
{

  $wbdwt = 0;
  $wmort = 0;
  $wcull = 0;
  $wfeed = 0;
  $wtrin = 0;
  $wtrout = 0;
  $wsale = 0;
  $wprod = 0;
  $inccost = 0;
  $livstd = 0;
  $feedstd = 0;
  $prodstd = 0;
  $actliv = 0;
  $nxtlive = 0;
  $weggs = 0;
  $wprodper = 0;
  $hecumstd = 0;
  $hecumact = 0;
  $fperegg = 0;
  $cost = 0;
  
  $query1 = "SELECT  distinct(date2),fmort,fcull from layer_consumption where client = '$client' and flock like '$flock' and age >= '$agefrom' and age < '$ageto' ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	  
	    $wmort = $wmort + $row2['fmort'];
		$wcull = $wcull + $row2['fcull'];
	  }
	$query1 = "SELECT  sum(quantity) as quant,max(avgwt) as bdwt from layer_consumption where client = '$client' and flock like '$flock' and age >= '$agefrom' and age < '$ageto' and itemcode in (select code from ims_itemcodes where cat = 'Layer Feed' and client = '$client') ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	    $wfeed = $row2['quant'];
		$wbdwt = $row2['bdwt'];
	  }
	  
	  $totmort = $totmort + $wmort;
	  $totcull = $totcull + $wcull;
	  
	  $query1 = "SELECT  itemcode,sum(quantity) as quant,max(date2) as date from layer_consumption where client = '$client' and flock like '$flock' and age >= '$agefrom' and age < '$ageto' and itemcode in (select code from ims_itemcodes where cat = 'Layer Feed' and client = '$client') group by itemcode ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	  
	   
	//	$q = "select sum(materialcost)/sum(production) as cost from feed_productionunit where mash = '$row2[itemcode]' and client = '$client'"; 
		
    	//	 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             while($qr = mysql_fetch_assoc($qrs))
    		   {
                $cost = $cost + round(($qr['cost'] * $row2['quant']),2);
               }
	  }
	 
	    $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Layer Birds' and client = '$client'  and fromwarehouse like '$flock' and date < '$maxwkdate' and date >= '$minwkdate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             while($qr = mysql_fetch_assoc($qrs))
    		   {
                $wtrout = $qr['quantity'];
               }
          $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Layer Birds' and client = '$client'  and towarehouse like '$flock' and date < '$maxwkdate' and date >= '$minwkdate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             while($qr = mysql_fetch_assoc($qrs))
    		   {
                $wtrin = $qr['quantity'];
               }
			   
			   
            if(round(ceil(($agefrom/7)),0)==1) {  $fweekmort = $wmort;  $fweekcull = $wcull; } 
			
			   $agewk = ceil($agefrom/7);
			   $nowbirds = $nxtbirds;
			   $nxtlive = $nxtbirds - $wmort - $wcull;
			   $actliv = round((($nxtlive/$nowbirds) * 100),2);
             $nxtbirds = $nxtbirds - $wmort - $wcull - $wtrout + $wtrin - $wsale;
			
			 if($agewk > $maxagee)
			 $q = "select * from layer_pstandards  where client = '$client' and age = '$maxagee' and  breed = '$breedi' "; 
			 else
			 $q = "select * from layer_pstandards  where client = '$client' and age = '$agewk' and  breed = '$breedi' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
              while($qr = mysql_fetch_assoc($qrs))
    		   {
                $livstd = round($qr['livability'],2);
				
				$feedstd = $qr['fm'];
				$bwtstd = $qr['mweight'];
               }
			   
			   $totfeedkg = $totfeedkg + $wfeed;	
			   $totalfeed+=  $wfeed; 
			   $wfeedkg = $wfeed;
			   $wfeed = $wfeed/$nowbirds;
			   $wfeed = round((($wfeed * 1000)/7),2);
			   $tottrin = $tottrin + $wtrin;
			   $tottrout = $tottrout + $wtrout;
			   $totsale = $totsale + $wsale;
			   $totfeed = $totfeed +  $wfeed;
			   $totfeedkg = $totfeedkg + $wfeedkg;
			   $totfeedkgstd = $totfeedkgstd + round((($feedstd * $nowbirds * 7)/1000),2);
			   ?>		   
			   <tr>
			   
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(round(ceil(($agefrom/7)),0));  ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($nowbirds); ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">

<?php if($wmort > 0){ echo ewrpt_ViewValue($wmort); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($totmort > 0){ echo ewrpt_ViewValue($totmort-$fweekmort); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($wcull > 0){ echo ewrpt_ViewValue($wcull); } else { echo ewrpt_ViewValue("0");  } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($totcull > 0){ echo ewrpt_ViewValue($totcull-$fweekcull); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($actliv > 0) { echo ewrpt_ViewValue($actliv); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($feedstd > 0) {  echo ewrpt_ViewValue($feedstd); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?>  align="right"  <?php if($wfeed < $feedstd) { ?> style="color:#009900" <?php } else { ?> style="color:#FF0000" <?php } ?>>
<?php if($wfeed > 0) {  echo ewrpt_ViewValue($wfeed); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($feedstd > 0) {  echo ewrpt_ViewValue(round((($feedstd * $nowbirds * 7)/1000),2)); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass;  ?> align="right" <?php  $dummy = round((($feedstd * $nowbirds * 7)/1000),2); if($wfeedkg < $dummy ) { ?> style="color:#009900" <?php } else { ?> style="color:#FF0000" <?php } ?> >
<?php if($wfeedkg > 0) {  echo ewrpt_ViewValue($wfeedkg); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($bwtstd > 0) {  echo ewrpt_ViewValue($bwtstd); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?>  align="right" <?php if($wbdwt < $bwtstd) { ?> style="color:#009900" <?php } else { ?> style="color:#FF0000" <?php } ?> >
<?php if($wbdwt > 0) {  echo ewrpt_ViewValue($wbdwt); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<!--<td<?php echo $sItemRowClass; ?> align="right">
<?php if($cost > 0) {  echo ewrpt_ViewValue($cost); } else { echo ewrpt_ViewValue("0"); } ?>
</td>-->

			   </tr>
			   <?php
        $agefrom = $ageto;
		$ageto = $ageto + 7;
		$minwkdate = $maxwkdate;
		$temp = strtotime($maxwkdate);
		$temp = $temp + (7 * 24 * 60 * 60);
		$maxwkdate = date("Y-m-d",$temp);
		$totfeedstd = $totfeedstd + $feedstd;
		$totcost = $totcost + $cost;
		
}

$totfeedstd = $totfeedstd * 7;
$totfeed = $totfeed * 7;
$finprodper = round(((($toteggs/$remaining) * 100)/$span),2);
$finstdprodper = round((($hecumstd * 100)/$span),2);
$fineggpb = round((($totfeedkg/$toteggs)*1000),2);
$finallive = $remaining - ($totmort + $totcull);
$finallive = round((($finallive/$remaining) * 100),2);
$totfeedkg = $totfeedkg;
$totfeedkgstd = $totfeedkgstd;
?>
<tr><td colspan="20">&nbsp;</td></tr>
<?php /*if($agewk != "")
{?>	
<tr>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo "&nbsp;"; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php echo $remaining; ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totmort > 0){ echo ewrpt_ViewValue($totmort-$fweekmort); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totmort > 0){ echo ewrpt_ViewValue($totmort-$fweekmort); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totcull > 0){ echo ewrpt_ViewValue($totcull-$fweekcull); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totcull > 0){ echo ewrpt_ViewValue($totcull-$fweekcull); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($finallive > 0){ echo ewrpt_ViewValue($finallive); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totfeedstd > 0){ echo ewrpt_ViewValue($totfeedstd); } else { echo ewrpt_ViewValue("0"); }  ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totfeed > 0){ echo ewrpt_ViewValue($totfeed); } else { echo ewrpt_ViewValue("0"); }  ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totfeedkgstd > 0){ echo ewrpt_ViewValue($totfeedkgstd); } else { echo ewrpt_ViewValue("0"); }  ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totfeedkg > 0){ echo ewrpt_ViewValue($totalfeed); } else { echo ewrpt_ViewValue("0"); }  ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($finstdprodper > 0){ echo ewrpt_ViewValue($finstdprodper); } else { echo ewrpt_ViewValue("&nbsp;"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($bwstd > 0){ echo ewrpt_ViewValue($bwstd); } else { echo ewrpt_ViewValue("&nbsp;"); } ?></b>
</td>

<!--<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totcost > 0){ echo ewrpt_ViewValue($totcost); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>-->

</tr>
<?php 
}*/?>		










	
	<?php
	//production flock details starts here
	
if($_SESSION['db'] == "albustanlayer")
{
$flkmain = $_GET['flock'];
$query = "SELECT flockcode FROM layer_flock WHERE flkmain = '$flkmain' and shedcode in (select distinct(shedcode) from layer_shed where shedtype = 'LAYER') AND client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$flock = $rows['flockcode'];
}
else
 $flock = $_GET['flock'];	
	
$mindatep = "";
$maxdatep = "";
$mindate = "";
$maxdate = "";
$minage = 0;
$maxage = 0;
   $query1 = "SELECT min(date1) as mindate,max(date1) as maxdate from layer_production where flock = '$flock' and client = '$client'  ";
      $result1 = mysql_query($query1,$conn1);
	  while($row2 = mysql_fetch_assoc($result1))
      {
	   $mindatep = $row2['mindate'];
		$maxdatep = $row2['maxdate'];
	  }
$mindatec = "";
$maxdatec = "";
 $query1 = "SELECT min(date2) as mindate,max(date2) as maxdate,min(age) as minage,max(age) as maxage from layer_consumption where flock = '$flock' and client = '$client'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	    $mindatec = $row2['mindate'];
		$maxdatec = $row2['maxdate'];
		$maxage = $row2['maxage'];
		$minage = $row2['minage'];
	  }
	  
	   if($mindatec <= $mindatep)
	  {
	     
	      $query1 = "SELECT age from layer_consumption where date2 = '$mindatep' and flock = '$flock' and client = '$client'  ";
      $result1 = mysql_query($query1,$conn1);
	  while($row2 = mysql_fetch_assoc($result1))
      {
	    $minage = $row2['age'];
	   }
	 
	  $startweek = $minage/7;
	  $firstweek = $startweek;
	  $endweek = $maxage/7;
	  $endweek = $endweek + 1;
	  $span = $maxage - $minage;
	  if(($minage % 7) == 1)
	 {
	   $agefrom = $minage;
	   $ageto = $agefrom + 7;
	 } 
	 else
	 {
	   $agefrom = $minage;
	   $ageto = $minage + (8 - ($minage % 7));
	 }	 
?>
<?php
  $fopening = 0;
             $q = "select * from layer_flock where flockcode = '$flock' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $fopening = $qr['femaleopening'];
             }
             
 
             $minus = 0; 
            $q = "select distinct(date2),fmort,fcull from layer_consumption where flock = '$flock' and client = '$client'  and date2 < '$mindatep' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $minus = $minus + $qr['fmort'] + $qr['fcull'];
             }
//echo $minus;
        
             $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Layer Birds' and client = '$client'  and fromwarehouse = '$flock' and date < '$mindatep'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ftransfer = $qr['quantity'];
               }
             }
             else
             {
                $ftransfer = 0;
             } 
//echo $ftransfer ;
             $q = "select sum(quantity) as 'quantity' from oc_cobi where flock = '$flock' and client = '$client'  and date < '$mindatep'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $tsale = $qr['quantity'];
               }
             }
             else
             {
                $tsale = 0;
             } 
			//echo $tsale;

            $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Layer Birds' and client = '$client'  and towarehouse = '$flock' and date < '$mindatep'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ttransfer = $qr['quantity'];
               }
             }
             else
             {
                $ttransfer = 0;
             } 
			//echo $ttransfer;
            $remaining = ($fopening - $minus - $ftransfer + $ttransfer) - $tsale;
			 $nxtbirds = $remaining;
?>
<?php
$minwkdate = "";
$maxwkdate = "";
$query1 = "SELECT  min(date2) as minwkdate,max(date2) as maxwkdate from layer_consumption where client = '$client' and flock = '$flock' and age >= '$agefrom' and age <= '$ageto' ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	  $minwkdate = $row2['minwkdate'];
	   $maxwkdate = $row2['maxwkdate']; 
	  }
	  $toteggs = 0;
	  $totmort = 0;
	  $totcull = 0;
	  $tottrin = 0;
	  $tottrout = 0;
	  $totsale = 0;
	  $totcost = 0;
	  $totfeedstd = 0;
	  $totfeedkg = 0;
	  $totalweekfeed = 0;
while($agefrom <= $maxage )
{
  $wmort = 0;
  $wcull = 0;
  $wfeed = 0;
  $wtrin = 0;
  $wtrout = 0;
  $wsale = 0;
  $wprod = 0;
  $inccost = 0;
  $livstd = 0;
  $feedstd = 0;
  $prodstd = 0;
  $actliv = 0;
  $nxtlive = 0;
  $weggs = 0;
  $wprodper = 0;
  $hecumstd = 0;
  $hecumact = 0;
  $fperegg = 0;
  $cost = 0;
  $daycount=0;
  $query1 = "SELECT  distinct(date2),fmort,fcull from layer_consumption where client = '$client' and flock = '$flock' and age >= '$agefrom' and age < '$ageto' ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {  
	    $wmort = $wmort + $row2['fmort'];
		$wcull = $wcull + $row2['fcull'];
		$daycount++;
	  }
	 $query1 = "SELECT  sum(quantity) as quant from layer_consumption where client = '$client' and flock = '$flock' and age >= '$agefrom' and age < '$ageto' and itemcode in (select code from ims_itemcodes where cat = 'Layer Feed' and client = '$client') ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	    $wfeed = $row2['quant'];
	  }
	  $query1 = "SELECT  sum(quantity) as quant from layer_production where client = '$client' and flock = '$flock' and date1 >= '$minwkdate' and date1 < '$maxwkdate' and itemcode in (select code from ims_itemcodes where cat = 'Layer Eggs' and client = '$client') ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	    $weggs = $row2['quant'];
	  }
	  $toteggs = $toteggs + $weggs;
	  $totmort = $totmort + $wmort;
	  $totcull = $totcull + $wcull;
	  
	  $query1 = "SELECT  itemcode,sum(quantity) as quant,max(date2) as date from layer_consumption where client = '$client' and flock = '$flock' and age >= '$agefrom' and age < '$ageto' and itemcode in (select code from ims_itemcodes where cat = 'Layer Feed' and client = '$client') group by itemcode ";
	
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   
	  
	$q = "select sum(materialcost)/sum(production) as cost from feed_productionunit where mash = '$row2[itemcode]' and client = '$client'"; 
		
		
    		// $qrs = mysql_query($q,$conn1) or die(mysql_error());
             while($qr = mysql_fetch_assoc($qrs))
    		   {
                $cost = $cost + round(($qr['cost'] * $row2['quant']),2);
               }
	  }
	 
	    $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Layer Birds' and client = '$client'  and fromwarehouse = '$flock' and date < '$maxwkdate' and date >= '$minwkdate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             while($qr = mysql_fetch_assoc($qrs))
    		   {
                $wtrout = $qr['quantity'];
               }
          $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Layer Birds' and client = '$client'  and towarehouse = '$flock' and date < '$maxwkdate' and date >= '$minwkdate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             while($qr = mysql_fetch_assoc($qrs))
    		   {
                $wtrin = $qr['quantity'];
               }
             $q = "select sum(quantity) as 'quantity' from oc_cobi where flock = '$flock' and client = '$client'  and date < '$maxwkdate' and date >= '$minwkdate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
              while($qr = mysql_fetch_assoc($qrs))
    		   {
                $wsale = $qr['quantity'];
               }
			   $agewk = ceil($agefrom/7);
			   $nowbirds = $nxtbirds;
			   $nxtlive = $nxtbirds - $wmort - $wcull;
			   
			   $actliv = round((($nxtlive/$remaining) * 100),2);
             $nxtbirds = $nxtbirds - $wmort - $wcull - $wtrout + $wtrin - $wsale;
			 
			if($agewk > $maxagee)
			 $q = "select * from layer_pstandards  where client = '$client' and age = '$maxagee' "; 
			 else
			 $q = "select * from layer_pstandards  where client = '$client' and age = '$agewk' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
              while($qr = mysql_fetch_assoc($qrs))
    		   {
                $livstd = round($qr['livability'],2);
				$prodstd = $qr['henday'];
				$feedstd = $qr['fm'];
				$hecumstd = round(($qr['hecum']),2);
               }
			   $wprodper = round((($weggs/$nowbirds) * 100),2);
			   $wprodper = round(($wprodper/$daycount),2);
			   $hecumact = round(($toteggs/$remaining),2);
			   $fperegg = round((($wfeed * 1000)/$weggs),2);
			   $totfeedkg = $totfeedkg + $wfeed;
			   $weekfeed = $wfeed;
			   $wfeed = $wfeed/$nowbirds;
			   $wfeed = round((($wfeed * 1000)/$daycount),2);
			   $tottrin = $tottrin + $wtrin;
			   $tottrout = $tottrout + $wtrout;
			   $totsale = $totsale + $wsale;
			   $totfeed = $totfeed +  $wfeed;
			   ?>
			   
			   <tr>
			   
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(round(ceil(($agefrom/7)),0)); ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($nowbirds); ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($wmort > 0){ echo ewrpt_ViewValue($wmort); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($wcull > 0){ echo ewrpt_ViewValue($wcull); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($wtrin > 0){ echo ewrpt_ViewValue($wtrin); } else { echo ewrpt_ViewValue("0");  } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($wtrout > 0){ echo ewrpt_ViewValue($wtrout); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($wsale > 0) { echo ewrpt_ViewValue($wsale); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($livstd > 0) { echo ewrpt_ViewValue($livstd); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right" <?php  if($actliv < $livstd) {  ?> style="color:#FF0000" <?php } else { ?> style="color:#009900" <?php } ?> >
<?php if($actliv > 0) {  echo ewrpt_ViewValue($actliv); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($weggs > 0) {  echo ewrpt_ViewValue($weggs); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($toteggs > 0) {  echo ewrpt_ViewValue($toteggs); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($prodstd > 0) {  echo ewrpt_ViewValue($prodstd); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right"  <?php if($prodstd < $wprodper) { ?> style="color:#009900" <?php } else { ?> style="color:#FF0000" <?php } ?>>
<?php if($wprodper > 0) {  echo ewrpt_ViewValue($wprodper); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($hecumstd > 0) {  echo ewrpt_ViewValue($hecumstd); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right" <?php if($hecumstd  < $hecumact) { ?> style="color:#009900" <?php } else { ?> style="color:#FF0000" <?php } ?> >
<?php if($hecumact > 0) {  echo ewrpt_ViewValue($hecumact); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php $dum1 = $hecumact - $hecumstd;  if($hecumact >= 0) {  echo ewrpt_ViewValue(round($dum1,3)); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($feedstd > 0) {  echo ewrpt_ViewValue($feedstd); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right"  <?php if($wfeed < $feedstd) { ?> style="color:#009900" <?php } else { ?> style="color:#FF0000" <?php } ?>>
<?php if($wfeed > 0) {  echo ewrpt_ViewValue($wfeed); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($weekfeed > 0) {  echo ewrpt_ViewValue($weekfeed); $totalweekfeed +=$weekfeed; } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($fperegg > 0) {  echo ewrpt_ViewValue($fperegg); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<!--<td<?php echo $sItemRowClass; ?> align="right">
<?php if($cost > 0) {  echo ewrpt_ViewValue($cost); } else { echo ewrpt_ViewValue("0"); } ?>
</td>-->
			   </tr>
			   <?php
        $agefrom = $ageto;
		$ageto = $ageto + 7;
		$minwkdate = $maxwkdate;
		$temp = strtotime($maxwkdate);
		$temp = $temp + (7 * 24 * 60 * 60);
		$maxwkdate = date("Y-m-d",$temp);
		$totfeedstd = $totfeedstd + $feedstd;
		$totcost = $totcost + $cost;
		
}
//$totfeedstd = $totfeedstd * 7;
//$totfeed = $totfeed * 7;
$finprodper = round(((($toteggs/$remaining) * 100)/$span),2);
$finstdprodper = round((($hecumstd * 100)/$span),2);
$fineggpb = round((($totfeedkg/$toteggs)*1000),2);
?>
<tr>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo "&nbsp;"; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php echo $remaining; ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totmort > 0){ echo ewrpt_ViewValue($totmort); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totcull > 0){ echo ewrpt_ViewValue($totcull); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($tottrin > 0){ echo ewrpt_ViewValue($tottrin); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($tottrout > 0){ echo ewrpt_ViewValue($tottrout); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totsale > 0){ echo ewrpt_ViewValue($totsale); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo "&nbsp;"; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo "&nbsp;"; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($toteggs > 0){ echo ewrpt_ViewValue($toteggs); } else { echo ewrpt_ViewValue("0"); }  ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($toteggs > 0){ echo ewrpt_ViewValue($toteggs); } else { echo ewrpt_ViewValue("0"); }  ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($finstdprodper > 0){ echo ewrpt_ViewValue($finstdprodper); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($finprodper > 0){ echo ewrpt_ViewValue($finprodper); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($hecumstd > 0){ echo ewrpt_ViewValue($hecumstd); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($hecumact > 0){ echo ewrpt_ViewValue($hecumact); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($finprodper > 0){ echo ewrpt_ViewValue(round(($hecumact - $hecumstd),2)); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totfeedstd > 0){ echo ewrpt_ViewValue($totfeedstd); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totfeed > 0){ echo ewrpt_ViewValue($totfeed); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totalweekfeed > 0){ echo ewrpt_ViewValue($totalweekfeed); } else { echo ewrpt_ViewValue("0"); }  ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($fineggpb > 0){ echo ewrpt_ViewValue($fineggpb); } else { echo ewrpt_ViewValue("0"); }  ?></b>
</td>
<!--<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totcost > 0){ echo ewrpt_ViewValue($totcost); } else { echo ewrpt_ViewValue("0"); }  ?></b>
</td>-->
</tr>
			
<?php

	// Next group
	$o_type = $x_type; // Save old group value
	GetGrpRow(2);
	$nGrpCount++;

		 }
	   
	  ?>
	
	
	
	</tbody>
	</table>
	
	
	
	
<?php include "phprptinc/footer.php"; ?>	