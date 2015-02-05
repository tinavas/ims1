<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "config.php";
function makecomma($input)
{
if(strlen($input)<=2)
{ return $input; }
$length=substr($input,0,strlen($input)-2);
$formatted_input = makecomma($length).",".substr($input,-2);
return $formatted_input;
}

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

if($_GET['fromdate'])
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
{
$result = mysql_query("select fdate,tdate from ac_definefy where client = '$client' order by id desc limit 0,1",$conn1) or die(mysql_error());
$res = mysql_fetch_assoc($result);
$fromdate = $res['fdate'];
$todate = $res['tdate'];
} 
if($_GET['todate'])
 $todate = date("Y-m-d",strtotime($_GET['todate']));
 
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
    <td colspan="2" align="center"><strong><font color="#3e3276">Yearly Average Production</font></strong></td>
  </tr>
  <tr height="5px"></tr>
  <tr>
    <td><strong>From </strong><?php echo date("d.m.Y",strtotime($fromdate)); ?> <strong>To</strong> <?php echo date("d.m.Y",strtotime($todate)); ?> </td>
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
  <tr>
    <td colspan="3"><div id="ewTop" class="phpreportmaker">
        <!-- top slot -->
        <?php } ?>
        <?php if (@$sExport == "") { ?>
        &nbsp;&nbsp;<a href="yearlyaverageproduction.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate;?>">Printer Friendly</a> &nbsp;&nbsp;<a href="yearlyaverageproduction.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate;?>">Export to Excel</a> &nbsp;&nbsp;<a href="yearlyaverageproduction.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate;?>">Export to Word</a>
        <?php if ($bFilterApplied) { ?>
        &nbsp;&nbsp;<a href="yearlyaverageproduction.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate;?>">Reset All Filters</a>
        <?php } ?>
        <?php } ?>
        <br />
        <br />
        <?php if (@$sExport == "") { ?>
      </div></td>
  </tr>
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
          <table class="ewGrid" cellspacing="0" align="center">
            <tr>
              <td class="ewGridContent"><?php if (@$sExport == "") { ?>
                <div class="ewGridUpperPanel">
                  <table>
                    <tr>
                      <td>From Date </td>
                      <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>"  onchange="reloadpage();"/></td>
                      <td>&nbsp;&nbsp;&nbsp;&nbsp;To Date </td>
                      <td><input type="text" name="todate" id="todate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($todate)); ?>"  onchange="reloadpage();"/></td>
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
                        <td valign="bottom" class="ewTableHeader" >&nbsp;</td>
                        <?php } else { ?>
                        <td class="ewTableHeader"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                              <td  align="center">&nbsp;</td>
                            </tr>
                          </table></td>
                        <?php } ?>
                        <?php if (@$sExport <> "") { ?>
                        <td valign="bottom" class="ewTableHeader" > Hatch Eggs </td>
                        <?php } else { ?>
                        <td class="ewTableHeader"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                              <td  align="center">Hatch Eggs</td>
                            </tr>
                          </table></td>
                        <?php } ?>
						<?php if (@$sExport <> "") { ?>
                        <td valign="bottom" class="ewTableHeader" > Table Eggs </td>
                        <?php } else { ?>
                        <td class="ewTableHeader"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                              <td  align="center">Table Eggs</td>
                            </tr>
                          </table></td>
                        <?php } ?>
                        <?php if (@$sExport <> "") { ?>
                        <td valign="bottom" class="ewTableHeader"  align="center"> Total Eggs </td>
                        <?php } else { ?>
                        <td class="ewTableHeader"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                              <td  align="center">Total Eggs</td>
                            </tr>
                          </table></td>
                        <?php } ?>
                        <?php if (@$sExport <> "") { ?>
                        <td valign="bottom" class="ewTableHeader"  align="center"> Book% </td>
                        <?php } else { ?>
                        <td class="ewTableHeader"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                              <td  align="center">Book%</td>
                            </tr>
                          </table></td>
                        <?php } ?>
                        <?php if (@$sExport <> "") { ?>
                        <td valign="bottom" class="ewTableHeader"  align="center"> Farm% </td>
                        <?php } else { ?>
                        <td class="ewTableHeader"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                              <td  align="center">Farm%</td>
                            </tr>
                          </table></td>
                        <?php } ?>
                        <?php if (@$sExport <> "") { ?>
                        <td valign="bottom" class="ewTableHeader"  align="center"> Mortality </td>
                        <?php } else { ?>
                        <td class="ewTableHeader"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                              <td  align="center">Mortality</td>
                            </tr>
                          </table></td>
                        <?php } ?>
                        <?php if (@$sExport <> "") { ?>
                        <td valign="bottom" class="ewTableHeader"  align="center"> Feed Consumed </td>
                        <?php } else { ?>
                        <td class="ewTableHeader"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                              <td  align="center">Feed Consumed</td>
                            </tr>
                          </table></td>
                        <?php } ?>
                        <?php if (@$sExport <> "") { ?>
                        <td valign="bottom" class="ewTableHeader"  align="center"> Feed/Bird </td>
                        <?php } else { ?>
                        <td class="ewTableHeader"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                              <td  align="center">Feed/Bird</td>
                            </tr>
                          </table></td>
                        <?php } ?>
                        <?php if (@$sExport <> "") { ?>
                        <td valign="bottom" class="ewTableHeader"  align="center" title="Chicks and Grower Mortality"> Mortality(C & G) </td>
                        <?php } else { ?>
                        <td class="ewTableHeader"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                              <td  align="center" title="Chicks and Grower Mortality">Mortality(C & G)</td>
                            </tr>
                          </table></td>
                        <?php } ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
/*$result = mysql_query("select HDpercent,age from breed_standards order by age",$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
$agearr[$res['age']] = $res['HDpercent']; */

$result = mysql_query("select productionper,age from breeder_standards order by age",$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
$agearr[$res['age']] = $res['productionper'];  

// retreiving all flocks opening birds
$result = mysql_query("select distinct(flockcode),femaleopening from breeder_flock where client = '$client'",$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
$oldflock[$res['flockcode']]=$res['femaleopening'];



$finalopenings = 0;
$toteggsbroken = 0;
$toteggs = 0;
$fromtime = $starttime = strtotime($fromdate);
$totime = strtotime($todate);
$totalfeed=0;
$totalmortality = 0;
$cgmort =0;
$hdpercent =0;
$totalcgmortality = 0;
$totalculls =0;
$totalcgculls = 0;

while($fromtime<=$totime)
{
$totflockeggs =0;
if($fromtime == $starttime) 
$startdate = $fromdate;
else
{ 
 $startdate = date("Y-m",$fromtime);
  $startdate = $startdate."-01";
 }
?>
                      <tr>
                        <td><?php echo date("F",$fromtime); $tempyear = date("Y",$fromtime); $tempmonth = date("m",$fromtime); $tdate = $tempyear."-".$tempmonth; ?></td>
                        <?php
//calculating eggs

$eggs = 0;
$heggs = 0;
if(strlen(strstr($fromdate,$tdate))>0)
$query ="select sum(quantity) as total,itemcode from breeder_production where  date1 >= '$fromdate' and date1 <= '$tdate-31'  and client = '$client' group by itemcode"; 
else if(strlen(strstr($todate,$tdate))>0)
$query ="select sum(quantity) as total,itemcode from breeder_production where  date1 >= '$tdate-01' and date1 <= '$todate' and client = '$client' group by itemcode"; 
else
$query ="select sum(quantity) as total,itemcode from breeder_production where  date1 like '$tdate%'  and client = '$client' group by itemcode"; 
$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
{
if(strlen(strstr($res['itemcode'],"EG"))>0)
$eggs+=$res['total'];
else if(strlen(strstr($res['itemcode'],"HE"))>0)
$heggs+=$res['total'];
} 

?>
                        
      <td align="right"><?php if($heggs){ $toteggsbroken+=$heggs;  echo $heggs;} else echo $heggs="0";  ?></td>
	  <td align="right"><?php  if($eggs){ $toteggs+=$eggs; echo $eggs;} else echo $eggs="0";?></td>
                        <td align="right"><?php echo $production=$eggs+$heggs; ?> </td>
                        <?php 
$openingbirds = 0;
$alleggs = 0;
$temppercentage =0;
$count =0;
$hdpercent =0;
$transferin = 0;
$transferout = 0;
$sales = 0;
$flockopenings = 0;
$finalopenings =0;

  $query = "select distinct(flock),min(date1) as date,max(date1) as mdate from breeder_production  where date1 >= '$startdate' and date1 <= '$tdate-31' and  client = '$client' group by flock order by flock";

 $result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
{

// calculating total eggs and opening birds for all flocks and for month

$days = (strtotime($res['mdate'])-strtotime($res['date']))/86400;
if(strlen(strstr($fromdate,$tdate))>0)
$query = "select sum(quantity) as total from breeder_production where itemcode in (select distinct(code) from ims_itemcodes where cat = 'Eggs' or cat = 'Hatch Eggs') and date1 >= '$fromdate' and date1 <= '$tdate-31'  and flock = '$res[flock]' and client = '$client'"; 
else if(strlen(strstr($todate,$tdate))>0)
$query = "select sum(quantity) as total from breeder_production where itemcode in (select distinct(code) from ims_itemcodes where cat = 'Eggs' or cat = 'Hatch Eggs') and date1 >= '$tdate-01' and date1 <= '$todate' and flock = '$res[flock]' and client = '$client'"; 
else
$query = "select sum(quantity) as total from breeder_production where itemcode in (select distinct(code) from ims_itemcodes where cat = 'Eggs' or cat = 'Hatch Eggs') and date1 like '$tdate%'  and flock = '$res[flock]' and client = '$client'"; 
 $result3 = mysql_query($query,$conn1) or die(mysql_error());
 $res3 = mysql_fetch_assoc($result3);
 $alleggs +=$flockeggs=$res3['total'];
 
if($oldflock[$res['flock']])
{
$openingbirds += $flockbirds= $oldflock[$res['flock']];
$flockopenings = $oldflock[$res['flock']];
}
else
{
$flockbirds=0;
$flockopenings =0;
}

//calculating transferin, transfer out,mortality and culls

//transfer in birds

if($res['date'] <= $startdate)
$query8 = "SELECT sum(quantity) as quantity,towarehouse as flk FROM ims_stocktransfer WHERE towarehouse = '$res[flock]' and date < '$startdate'  AND cat = 'Female Birds' AND client = '$client'";
else if($res['date'] > $startdate)
$query8 = "SELECT sum(quantity) as quantity,towarehouse as flk FROM ims_stocktransfer WHERE towarehouse = '$res[flock]' and date <  '$res[date]' AND cat = 'Female Birds' AND client = '$client'";
 $result8 = mysql_query($query8,$conn1) or die(mysql_error());
 
 while($rows8 = mysql_fetch_assoc($result8))
 {
  $transferin += $rows8['quantity'];
  $flockopenings += $rows8['quantity'];
}
 //transfer out birds  
 if($res['date'] <= $startdate)
  $query9 = "SELECT sum(quantity) as quantity,fromwarehouse as flk FROM ims_stocktransfer WHERE fromwarehouse = '$res[flock]' and date < '$startdate' AND cat = 'Female Birds' AND client = '$client' ";
 else if($res['date'] > $startdate)
  $query9 = "SELECT sum(quantity) as quantity,fromwarehouse as flk FROM ims_stocktransfer WHERE fromwarehouse = '$res[flock]' and date <  '$res[date]' AND cat = 'Female Birds' AND client = '$client' ";
 $result9 = mysql_query($query9,$conn1) or die(mysql_error());
 while($rows9 = mysql_fetch_assoc($result9))
 {
  $transferout += $rows9['quantity'];
  $flockopenings -= $rows9['quantity'];
 }
  
  //sales birds
  if($res['date'] <= $startdate)
   $query10 = "SELECT sum(quantity) as quantity,flock as flk FROM oc_cobi WHERE flock = '$res[flock]' and date < '$startdate' AND code IN (SELECT distinct(code) FROM ims_itemcodes WHERE cat = 'Female Birds' AND client = '$client') AND client = '$client' ";  
   else if($res['date'] > $startdate)
    $query10 = "SELECT sum(quantity) as quantity,flock as flk FROM oc_cobi WHERE flock = '$res[flock]' and date <  '$res[date]' AND code IN (SELECT distinct(code) FROM ims_itemcodes WHERE cat = 'Female Birds' AND client = '$client') AND client = '$client' ";
   $result10 = mysql_query($query10,$conn1) or die(mysql_error());
  while($rows10 = mysql_fetch_assoc($result10))
  {
  $sales += $rows10['quantity'];
  $flockopenings -= $rows10['quantity'];
  }
  
  /// mortality calculation
   $minus = 0; 
     $q = "select distinct(date2),fmort,fcull from breeder_consumption where flock = '$res[flock]' and client = '$client'  and date2 < '$startdate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $minus = $minus + $qr['fmort'] + $qr['fcull'];
             }
			
       $totalminus += $minus;
   $flockopenings -= $minus;
  
  
 
  

//calculating standatd Average production percentage

$flockaverage = 0;
$agecount =0;
  if(strlen(strstr($fromdate,$tdate))>0)
  $query = "select min(age) as min,max(age) as max from breeder_consumption where flock = '$res[flock]' and date2 >= '$fromdate' and date2 <= '$tdate-31' and client = '$client'";
  else if(strlen(strstr($todate,$tdate))>0)
  $query = "select min(age) as min,max(age) as max from breeder_consumption where flock = '$res[flock]' and date2 >= '$tdate-01' and date2 <= '$todate' and client = '$client'";
  else
$query = "select min(age) as min,max(age) as max from breeder_consumption where flock = '$res[flock]' and date2 like '$tdate%' and client = '$client'";
$result4 = mysql_query($query,$conn1) or die(mysql_error());
$res4 = mysql_fetch_assoc($result4);
  $min = round($res4['min']/7);
  $max = round($res4['max']/7);

for($i = $min; $i <= $max; $i++)
{
if($agearr[$i])
$flockaverage+=$agearr[$i];
else
$flockaverage+=$agearr[sizeof($agearr)];
$agecount++;

}
 $hdpercent += round($flockaverage/$agecount,2);

$totflockeggs += $flockeggs;
$temppercentage += $temp=round(($flockeggs/$flockopenings*100)/$days,2);
$count++;

/*echo $res['flock']." = ".$flockopenings;
echo "<br>";*/
$finalopenings += $flockopenings;
}

/*echo "total openings = ".$finalopenings;*/


?>
                        <td align="right"><?php echo changeprice(round($hdpercent/$count,2)); ?></td>
                        <td align="right"><?php echo changeprice(round(($temppercentage/$count),2));  ?></td>
                        <?php 
//Breeder mortality and culls
$mort =0;
if(strlen(strstr($todate,$tdate))>0)
$query = "select distinct(date2),fmort,fcull from breeder_consumption where date2 >= '$tdate-01' and date2 <= '$todate' and flock in (select distinct(flockcode) from breeder_flock f,breeder_shed s where  f.shedcode=s.shedcode and s.shedtype = 'Breeder' and f.client = '$client')  and client = '$client' ";
else if(strlen(strstr($fromdate,$tdate))>0)
$query = "select distinct(date2),fmort,fcull from breeder_consumption where date2 >= '$fromdate' and date2 <= '$tdate-31' and flock in (select distinct(flockcode) from breeder_flock f,breeder_shed s where  f.shedcode=s.shedcode and s.shedtype = 'Breeder' and f.client = '$client')  and client = '$client' ";
else
$query = "select distinct(date2),fmort,fcull from breeder_consumption where date2 like '$tdate%' and flock in (select distinct(flockcode) from breeder_flock f,breeder_shed s where  f.shedcode=s.shedcode and s.shedtype = 'Breeder' and f.client = '$client')  and client = '$client' ";

$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
{
$mort+=$res['fmort'];
$totalculls += $res['fcull'];
}

?>
                        <td align="right"><?php echo $mort; $totalmortality+=$mort; ?></td>
                        <?php
//chick and grower mortality and culls
$mort =0;
if(strlen(strstr($todate,$tdate))>0)
$query = "select distinct(date2),fmort,fcull from breeder_consumption where date2 >= '$tdate-01' and date2 <= '$todate' and flock in (select distinct(flockcode) from breeder_flock f,breeder_shed s where  f.shedcode=s.shedcode and s.shedtype <> 'Breeder' and f.client = '$client')  and client = '$client' ";
else if(strlen(strstr($fromdate,$tdate))>0)
$query = "select distinct(date2),fmort,fcull from breeder_consumption where date2 >= '$fromdate' and date2 <= '$tdate-31' and flock in (select distinct(flockcode) from breeder_flock f,breeder_shed s where  f.shedcode=s.shedcode and s.shedtype <> 'Breeder' and f.client = '$client')  and client = '$client' ";
else
 $query = "select distinct(date2),fmort,fcull from breeder_consumption where date2 like '$tdate%' and flock in (select distinct(flockcode) from breeder_flock f,breeder_shed s where  f.shedcode=s.shedcode and s.shedtype <> 'Breeder' and f.client = '$client')  and client = '$client'";
// $query = "select fmort from breeder_consumption where date2 like '$tdate%' group by date2";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
{
$mort+=$res['fmort'];
$totalcgculls += $res['fcull'];
}
$totalcgmortality+=$mort;


//echo $qm776 = "select sum(quantity) as quantity from breeder_consumption where date2 like '$tdate%' and itemcode LIKE ''FD% and client = '$client'";
if(strlen(strstr($todate,$tdate))>0)
$query = "select sum(quantity) as quantity from breeder_consumption where date2 >= '$tdate-01' and date2 <= '$todate' and itemcode in (select distinct(code) from ims_itemcodes where cat = 'Female Feed') and client = '$client'";
else if(strlen(strstr($fromdate,$tdate))>0)
$query = "select sum(quantity) as quantity from breeder_consumption where date2 >= '$fromdate' and date2 <= '$tdate-31' and itemcode in (select distinct(code) from ims_itemcodes where cat = 'Female Feed') and client = '$client'";
else
$query = "select sum(quantity) as quantity from breeder_consumption where date2 like '$tdate%' and itemcode in (select distinct(code) from ims_itemcodes where cat = 'Female Feed') and client = '$client'";
$result = mysql_query($query,$conn1); 
$res = mysql_fetch_assoc($result);

?>
  <td align="right"><?php if($res['quantity']){ $totalfeed+=$feed = $res['quantity']; echo changeprice($feed);} else echo $feed = "0.00"; ?></td>
                        <?php /*echo "finalopenings=".$finalopenings;*/ ?>
                        <td align="right"><?php echo changeprice(round(($feed/$finalopenings)*1000,2)); ?></td>
                        <td align="right"><?php echo $mort; $cgmort+=$mort; ?></td>
                      </tr>
                      <?php
//calculating next month first date
$previousdays = date("d",$fromtime);
$previoustime = $previousdays * 86400;
$ndays = date("t",$fromtime);
$monthtime = $ndays*86400;
$remaining = $monthtime - $previoustime;
$fromtime+=$remaining+86400;

}
?>
                      <tr>
                        <td>Total</td>
						<td align="right"><?php echo $toteggsbroken; ?></td>
                        <td align="right"><?php echo $toteggs; ?></td>
                        <td align="right"><?php echo $toteggs+$toteggsbroken; ?></td>
                        <td>&nbsp;</td>
                        <td align="right">&nbsp;</td>
                        <td align="right"><?php echo $totalmortality; ?></td>
                        <td align="right"><?php echo changeprice($totalfeed);?></td>
                        <td>&nbsp;</td>
                        <td align="right"><?php echo $cgmort; ?></td>
                      </tr>
                    </tbody>
                    <tfoot>
                    </tfoot>
                  </table>
                </div></td>
            </tr>
          </table>
        </div>
        <?php if (@$sExport == "") { ?>
      </div>
      <br /></td>
  </tr>
</table>
<?php } ?>
<?php include "phprptinc/footer.php"; ?>
<script type="text/javascript">
function reloadpage()
{
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	document.location = "yearlyaverageproduction.php?fromdate=" + fdate + "&todate=" +tdate;
}
</script>
