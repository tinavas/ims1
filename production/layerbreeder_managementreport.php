
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>B.I.M.S</title>
<style type="text/css">
	body {
		font-family: Helvetica;
		font-size: 12px;
		color: #000;
	}
	
	h3 {
		margin: 0px;
		padding: 0px;	
	}

	.suggestionsBox {
		position: relative;
		left: 30px;
		margin: 10px 0px 0px 0px;
		width: 200px;
		background-color: #212427;
		-moz-border-radius: 7px;
		-webkit-border-radius: 7px;
		border: 2px solid #000;	
		color: #fff;
	}
	
	.suggestionList {
		margin: 0px;
		padding: 0px;
	}
	
	.suggestionList li {
		text-align:left;
		margin: 0px 0px 3px 0px;
		padding: 3px;
		cursor: pointer;
	}
	
	.suggestionList li:hover {
		background-color: #659CD8;
	}
</style>

<style type="text/css" media="print">
.printbutton {
  visibility: hidden;
  display: none;
}
</style>
</head>
<body>
<center>
<script>
document.write("<input type='button' " +
"onClick='window.print()' " +
"class='printbutton' " +
"value='Print This Page'/><br /><br />");
</script>
<?php
include "config.php";
include "getemployee.php";
$client = $_SESSION['client'];
if($client == "GOLDEN")
{
$flock = "-".$_GET['flock'];
$salesflock = $_GET['flock'];
}
else
{
$salesflock = $flock = $_GET['flock'];
}
$displayflk = $_GET['flock'];
$ifmort = $immort = $ifcull = $imcull = $imfeed = $iffeed = 0;
$query = "SELECT count(*) as count,startdate,breed FROM Layerbreeder_flock WHERE flockcode LIKE '%$flock'  order by startdate LIMIT 1";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $cnt = $rows['count'];
 $minstdate = $rows['startdate'];
 $startdate = date($datephp,strtotime($minstdate));
 $flkbreed = $rows['breed'];
}
if($cnt == 1)
{
 $query = "SELECT femaleopening,maleopening,flockcode FROM layerbreeder_flock WHERE flockcode LIKE '%$flock'  order by startdate LIMIT 1";
}
else
{
 //$query = "SELECT sum(femaleopening) as femaleopening,sum(maleopening) as maleopening,flockcode FROM breeder_flock WHERE flockcode LIKE '%$flock'  and startdate = '$minstdate'";
  $query = "SELECT sum(femaleopening) as femaleopening,sum(maleopening) as maleopening,flockcode FROM layerbreeder_flock WHERE flockcode LIKE '%$flock' ";
}
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
$q = "SELECT female,male FROM layerbreeder_initial WHERE flock LIKE '%$flock' ORDER BY age LIMIT 1";
$r = mysql_query($q,$conn) or die(mysql_error());
$cntrrows = mysql_num_rows($r);
if($cntrrows >0)
{
while($rrows = mysql_fetch_assoc($r))
{
if($rrows['female'] > 0)
{
  $fopening += $rrows['female'];
  $fopeningll += $rrows['female'];
}
if($rrows['male'] > 0)
{
 $mopening += $rrows['male'];
}

}
}
else
{
  $fopening += $rows['femaleopening'];
 $fopeningll += $rows['femaleopening'];
 $mopening += $rows['maleopening'];
 }
}

$query = "SELECT sum(receivedquantity) as quantity FROM pp_sobi WHERE flock LIKE '%$flock' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Female Birds') AND date <= '$minstdate'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
if($rows['quantity'] <> "")
$fopening += $rows['quantity'];

$query = "SELECT sum(receivedquantity) as quantity FROM pp_sobi WHERE flock LIKE '%$flock' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Male Birds') AND date <= '$minstdate'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
if($rows['quantity'] <> "")
$mopening += $rows['quantity'];

$query = "SELECT min(date) as minsaledate FROM oc_cobi WHERE flock LIKE '%$flock' AND code in (select distinct(code) from ims_itemcodes where cat In ('Female Birds','Male Birds')) ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$minsaledate = $rows['minsaledate'];


$fmortality = $mmortality = $fcull = $mcull = 0;
$query = "SELECT fmort,mmort  FROM layerbreeder_consumption WHERE flock LIKE '%$flock'  group by date2,flock";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
$fmortality += $rows['fmort'];
$mmortality += $rows['mmort'];
}
if($_SESSION['client'] == "GOLDEN")
{
$fculls = 0;$mculls = 0;
$query = "SELECT fcull,mcull  FROM layerbreeder_consumption WHERE flock LIKE '%$flock' group by date2,flock ORDER BY updated DESC";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $fculls += $rows['fcull'];
$mculls += $rows['mcull'];
}
}
else
{
$query = "SELECT fcull,mcull  FROM layerbreeder_consumption WHERE flock LIKE '%$flock' ORDER BY updated DESC";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
$fculls += $rows['fcull'];
$mculls += $rows['mcull'];
}
}
 $query1 = "select avg(rateperunit) as price from pp_sobi where flock like '%$flock' and code in(select distinct(code) from ims_itemcodes where cat LIKE '%Female Birds' ) ";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
$n = mysql_num_rows($result1);
$rows1 = mysql_fetch_assoc($result1);
if($n > 0)
{
$rateFemale = round(($rows1['price']),2);
}
else
{
$rateFemale = "21";
}
$query1 = "select avg(rateperunit) as price from pp_sobi where flock like '%$flock' and code in(select distinct(code) from ims_itemcodes where cat LIKE '%Male Birds' ) ";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
$n = mysql_num_rows($result1);
$rows1 = mysql_fetch_assoc($result1);
if($n > 0)
{
$rateMale = round(($rows1['price']),2);
}
else
{
$rateMale = "21";
}
 

$query = "SELECT sum(fmort) as imort,sum(fcull) as icull,sum(mmort) as immort,sum(mcull) as imcull,sum(mfeedqty) as imfeed,sum(ffeedqty) as iffeed FROM layerbreeder_initial WHERE flock LIKE '%$flock' ";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
$fmortality += $rows['imort'];
$fculls += $rows['icull'];
$mmortality += $rows['immort'];
$mculls += $rows['imcull'];
$iffeed = $rows['iffeed'];
$imfeed = $rows['imfeed'];
}

$query = "SELECT sum(ffeedqty) as iffeed FROM layerbreeder_initial WHERE flock LIKE '%$flock' AND ffeed IN (SELECT code FROM ims_itemcodes WHERE description LIKE '%Layer%' AND cat = 'Female Feed') ";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
 $layer_iffeed = $rows['iffeed'];


$query = "SELECT max(age) as age,max(date2) as enddate  FROM layerbreeder_consumption WHERE flock LIKE '%$flock'  LIMIT 1";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$orgage = $age = $rows['age'];
$weeks = floor($age/7);
$days = $age % 7;
$age = $weeks.".".$days;
$enddate = date($datephp,strtotime($rows['enddate']));

$mv = 0;$totmedvaccost = 0;
$query = "SELECT distinct(itemcode) FROM layerbreeder_consumption WHERE flock LIKE '%$flock' AND itemcode IN (SELECT code FROM ims_itemcodes WHERE cat In ('Medicines','Vaccines')) ";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
$mv++;
$medvac = "";$medvacqty = 0;$medvaccost = 0;
$medvac = $rows['itemcode'];

$query1 = "SELECT sum(quantity) as medvacqty FROM layerbreeder_consumption WHERE flock LIKE '%$flock' AND itemcode = '$medvac' ";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
$rows1 = mysql_fetch_assoc($result1);
//echo "      quantity     ".
$medvacqty = $rows1['medvacqty'];

$query2 = "SELECT avg(rateperunit) as medvaccost FROM pp_sobi WHERE code = '$medvac' ";
$result2 = mysql_query($query2,$conn) or die(mysql_error());
$rows2 = mysql_fetch_assoc($result2);
//echo "      cost     ".
$medvaccost = $rows2['medvaccost'];
if($medvaccost == "") {
$query = "select sum(amount)/sum(quantity) as avgprice from ac_financialpostings where crdr = 'Dr' and itemcode = '$medvac'";
$mvresult = mysql_query($query,$conn) or die(mysql_error());
$mvres = mysql_fetch_assoc($mvresult);
 $medvaccost = $mvres['avgprice'];}

//echo "  totcost      ".
 $totmedvaccost = $totmedvaccost + round(($medvacqty*$medvaccost),3);
//echo "<br>";
}

$query = "SELECT sum(quantity) as ffeed FROM layerbreeder_consumption WHERE flock LIKE '%$flock' AND itemcode IN (SELECT code FROM ims_itemcodes WHERE cat = 'Female Feed') ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$ffeed = $rows['ffeed'];

$query = "SELECT sum(quantity) as ffeed FROM layerbreeder_consumption WHERE flock LIKE '%$flock' AND itemcode IN (SELECT code FROM ims_itemcodes WHERE cat = 'Female Feed' AND description LIKE '%Layer%') ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$layer_ffeed = $rows['ffeed'];


$query = "SELECT sum(quantity) as mfeed FROM layerbreeder_consumption  WHERE flock LIKE '%$flock' AND itemcode IN (SELECT code FROM ims_itemcodes WHERE cat = 'Male Feed') ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$mfeed = $rows['mfeed'];

$query = "SELECT sum(quantity) as trout FROM ims_stocktransfer WHERE fromwarehouse LIKE '%$flock' AND towarehouse NOT LIKE '%$flock' AND cat LIKE '%Female Birds' ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$ftrout = $rows['trout'];

 $query = "SELECT sum(quantity) as trin FROM ims_stocktransfer WHERE  fromwarehouse NOT LIKE '%$flock' AND towarehouse LIKE '%$flock' AND cat LIKE '%Female Birds' ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$ftrin  = $rows['trin'];

$query = "SELECT sum(receivedquantity) as receivedquantity FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat LIKE '%Female Birds')  AND flock like '%$flock' and date > '$minstdate'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$fpur  = $rows['receivedquantity'];

$query = "SELECT sum(receivedquantity) as receivedquantity  FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat LIKE '%Male Birds')  AND flock like '%$flock'  and date > '$minstdate'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$mpur  =  $rows['receivedquantity'];


$query = "SELECT sum(quantity) as sales FROM oc_cobi WHERE flock LIKE '%$flock' AND code in (select distinct(code) from ims_itemcodes where cat LIKE '%Female Birds') and date >= '$minsaledate'  ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$fsales = $rows['sales'];

$query = "SELECT sum(quantity) as trout FROM ims_stocktransfer WHERE fromwarehouse LIKE '%$flock' AND towarehouse NOT LIKE '%$flock'  AND cat LIKE '%LB Male Birds' ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$mtrout = $rows['trout'];

$query = "SELECT sum(quantity) as trin FROM ims_stocktransfer WHERE fromwarehouse NOT LIKE '%$flock' AND towarehouse LIKE '%$flock' AND cat LIKE '%LB Male Birds' ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$mtrin = $rows['trin'];

$query = "SELECT sum(quantity) as sales FROM oc_cobi WHERE flock LIKE '%$flock' AND code in (select distinct(code) from ims_itemcodes where cat LIKE '%LB Male Birds') and date >= '$minsaledate' ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$msales = $rows['sales'];

$query = "SELECT sum(quantity) as production,min(date1) as mindate FROM layerbreeder_production WHERE flock LIKE '%$flock'  and itemcode in (select code from ims_itemcodes where cat LIKE '%Layer Hatch Eggs' )";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$production = $rows['production'];
$mindate = $rows['mindate'];

$query = "SELECT sum(quantity) as production FROM layerbreeder_production WHERE flock LIKE '%$flock'  and itemdesc LIKE '%TABLE EGGS'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$tableeggs = $rows['production'];

if($flkbreed != "")
{
$query = "SELECT sum(ffeed) as stdffeed,sum(mfeed) as stdmfeed FROM layerbreeder_standards WHERE age<=$weeks AND breed = '$flkbreed' ";
}
else
{
$query = "SELECT sum(ffeed) as stdffeed,sum(mfeed) as stdmfeed FROM layerbreeder_standards WHERE age<=$weeks ";
}
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$stdffeed = $rows['stdffeed'];
$stdmfeed = $rows['stdmfeed'];

if($flkbreed != "")
{
$query = "SELECT cumhhe as stdprod FROM layerbreeder_standards WHERE age = '$weeks' AND breed = '$flkbreed' ";
}
else
{
$query = "SELECT cumhhe as stdprod FROM layerbreeder_standards WHERE age = '$weeks' ";
}
$result = mysql_query($query,$conn) or die(mysql_error());
$numrows = mysql_num_rows($result);
if($numrows <> 0)
{
$rows = mysql_fetch_assoc($result);
$stdproduction = round($rows['stdprod'],2);
}
else
{
if($flkbreed != "")
{
$query2 = "SELECT max(cumhhe) as stdprod FROM layerbreeder_standards WHERE breed = '$flkbreed' ";
}
else
{
$query2 = "SELECT max(cumhhe) as stdprod FROM layerbreeder_standards";
}
$result2 = mysql_query($query2,$conn) or die(mysql_error());
$rows2 = mysql_fetch_assoc($result2);
$stdproduction = round($rows2['stdprod'],2);
}
/**to find standard production**/
$query = "SELECT min(date1) as startdate FROM layerbreeder_production WHERE flock LIKE '%$flock' ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$lstart = $rows['startdate'];

$query = "SELECT sum(quantity) as trout FROM ims_stocktransfer WHERE fromwarehouse LIKE '%$flock' AND towarehouse NOT LIKE '%$flock'  AND cat = 'Female Birds' and date < '$lstart' ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$lftrout = $rows['trout'];

$query = "SELECT sum(quantity) as trin FROM ims_stocktransfer WHERE  fromwarehouse NOT LIKE '%$flock'  AND towarehouse LIKE '%$flock' AND cat = 'Female Birds' and date < '$lstart' ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$lftrin = $rows['trin'];

$lfpur = 0;
$query = "SELECT sum(receivedquantity) as receivedquantity  FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat ='Female Birds')  AND flock like '%$flock' AND date <= '$lstart' ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$lfpur  = $rows['receivedquantity'];

$lmpur = 0;
$query = "SELECT sum(receivedquantity) as receivedquantity  FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat ='Male Birds')  AND flock like '%$flock' AND date <= '$lstart' ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$lmpur  = $rows['receivedquantity'];


$query = "SELECT sum(quantity) as sales FROM oc_cobi WHERE flock LIKE '%$flock' AND date < '$lstart' AND code in (select distinct(code) from ims_itemcodes where cat = 'Female Birds') ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$lfsales = $rows['sales'];

$query = "SELECT fmort,fcull FROM layerbreeder_consumption WHERE flock LIKE '%$flock'  and date2 < '$lstart'";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
$lfmortality = $lmortality + $rows['fmort'];
$lfculls = $lfculls + $rows['fcull'];
}

$q = "SELECT sum(fmort) as fmorti,sum(mmort) as mmorti,sum(fcull) as fculli,sum(mcull) as mculli FROM layerbreeder_initial WHERE flock LIKE '%$flock'  and eggs = ''";
$r = mysql_query($q,$conn) or die(mysql_error());
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
$lbirds = $fopeningll - $lfmortality - $lfculls - $lftrout + $lftrin + $lfpur  - $fmortalityi - $fculli;
}
else
{
$lbirds = $fopeningll - $lfmortality - $lfculls - $lftrout + $lftrin + $lfpur - $lfsales - $fmortalityi - $fculli;
}

$ihatcheggs = $itableeggs = 0;
$query = "SELECT eggs FROM layerbreeder_initial WHERE flock LIKE '%$flock' ";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $data = explode(',',$rows['eggs']);
 for($i =0; $i < count($data); $i++)
 {
  if($data <> "")
  {
   $data2 = explode(':',$data[$i]);
   $cat = substr($data2[0],0,2);
   if($cat == 'HE')
    $ihatcheggs += $data2[1];
   elseif($cat == 'EG')
    $itableeggs += $data2[1];
  }
 }
}
$production += $ihatcheggs;
$tableeggs += $itableeggs;


$query = "SELECT sum(receivedquantity) as quantity FROM pp_sobi WHERE flock LIKE '%$flock' AND code IN (SELECT code FROM ims_itemcodes WHERE cat LIKE '%Female Birds')  and date > '$minstdate' ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
if($rows['quantity'] <> "")
$totfpur += $rows['quantity'];
if($totfpur == '')
{
$totfpur = 0;
}

$query = "SELECT sum(receivedquantity) as quantity FROM pp_sobi WHERE flock LIKE '%$flock' AND code IN (SELECT code FROM ims_itemcodes WHERE cat LIKE '%Male Birds')  and date > '$minstdate'  ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
if($rows['quantity'] <> "")
$totmpur += $rows['quantity'];
if($totmpur == '')
{
$totmpur = 0;
}
?>
<div style="width:700px" >

<!-- Header -->

<center>
<table border="1" style="border-color:#000000; padding-left:0px;">
 <tr height="120px">
   <td style="text-align:left; padding-left:30px;">
<?php $db = $_SESSION['db'];
$q = "select * from home_logo ";
$r = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($r))
{
$im = $qr['image'];
$add = $qr['address'];
?>
<table align="center" border="0">
<tr align="center">
<td style="vertical-align:middle"><img src="logo/thumbnails/<?php echo $im; ?>" border="0px" /></td>
<td style="vertical-align:middle"><?php echo html_entity_decode($add); ?></td>
</tr>
</table>
<?php 
}
?>
<?php
if($currencyunits == "")
{
$currencyunits = "Rs";
}
?>
</center><!-- /Header -->
<br/>

<center><p style="padding-left:430px;color:red"> All weight's in Kg's<br />

 All amounts in Rs</p></center>

<center><h3 >Individual Flock Performance Report for Flock: <?php echo $displayflk; ?> (<?php echo $startdate." - ".$enddate; ?>)  (Age:<?php echo $age; ?>)<br /><?php echo $_GET['days']; ?></h3></center><br />

<table border="0" style="text-align:left">
 
 <tr>
   <td width="200px">Female Opening Birds</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $fopening; ?></td>
   <td width="200px">Male Opening Birds</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $mopening; ?></td>
 </tr>
 
 <tr>
   <td width="200px">Female Chick Cost/Bird</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $fchickcost = $rateFemale; ?></td>
   <td width="200px">Male Chick Cost/Bird</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $mchickcost = $rateMale; ?></td>
 </tr> 

<tr>
   <td width="200px">Female Purchases</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $totfpur; ?></td>
   <td width="200px">Male Purchases</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $totmpur; ?></td>
 </tr>


 <tr>
   <td width="200px">Total Female Mortality</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $fmortality1 = $fmortality; ?></td>
   <td width="200px">Total Male Mortality</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $mmortality1 = $mmortality; ?></td>
 </tr>
 
 <tr>
   <td width="200px">Female Mortality%</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo round(($fmortality1/($fopening+$totfpur) * 100),2); ?></td>
   <td width="200px">Male Mortality%</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo round(($mmortality1/($mopening+$totmpur) * 100),2); ?></td>
 </tr> 

 <tr>
   <td width="200px"><?php if($_SESSION['client'] == "GOLDEN") {?>Female Culls/Sales<?php } else {?> Female Culls<?php }?></td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $fculls1 = $fculls; ?></td>
   <td width="200px"><?php if($_SESSION['client'] == "GOLDEN") {?>Male Culls/Sales<?php } else {?> Male Culls<?php }?></td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $mculls1 = $mculls; ?></td>
 </tr>
 
 <tr>
   <td width="200px">Female Culls/Sales %</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo round(($fculls1/$fopening * 100),2); ?></td>
   <td width="200px">Male Culls/Sales %</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo round(($mculls1/$mopening * 100),2); ?></td>
 </tr> 

 <tr>
   <td width="200px">Female Transfer In</td>
   <td width="10px">:</td>
   <td width="100px"><?php if($ftrin == "") echo "0"; else echo $ftrin; ?></td>
   <td width="200px">Male Transfer In</td>
   <td width="10px">:</td>
   <td width="100px"><?php if($mtrin == "") echo "0"; else echo $mtrin; ?></td>
 </tr> 
 
 <tr>
   <td width="200px">Female Transfer Out</td>
   <td width="10px">:</td>
   <td width="100px"><?php if($ftrout == "") echo "0"; else echo $ftrout; ?></td>
   <td width="200px">Male Transfer Out</td>
   <td width="10px">:</td>
   <td width="100px"><?php if($mtrout == "") echo "0"; else echo $mtrout; ?></td>
 </tr> 
<?php /*
$query = "SELECT * FROM breeder_finalization WHERE flock LIKE '%$flock' ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
if($rows['type'] == 'SHORTAGE')
 $quantity = -$rows['quantity'];
elseif($rows['type'] == 'EXCESS')
 $quantity = $rows['quantity']; 
$qty =  $rows['quantity']; 
$tcost = $rows['tcost'];
$ocost = $rows['ocost']; */
?>
 <tr <?php if($_SESSION['client'] == "GOLDEN"){?> style="display:none;" <?php }?> >
   <td width="200px">Female Sales</td>
   <td width="10px">:</td>
   <td width="100px"><?php if($fsales == "") echo "0"; else echo $fsales; ?></td>
   <td width="200px">Male Sales</td>
   <td width="10px">:</td>
   <td width="100px"><?php if($msales == "") echo "0"; else echo $msales; ?></td>
 </tr>
 
<!-- <tr>  
   <td width="200px"><?php echo ucfirst($rows['type']); ?></td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $qty; ?></td>
 </tr>
--> 
<?php 
//echo "fopening".$fopening."transfer in".$ftrin."purchase".$fpur."tr out".$ftrout."mort".$fmortality1."culls".$fculls1;

 $q = "SELECT sum(shortagefemale) - sum(excessfemale) AS female FROM breeder_birdsadjustment WHERE flock LIKE '%$flock'";
$r = mysql_query($q,$conn) or die(mysql_error());
$rr = mysql_fetch_assoc($r);  
$fadjust = $rr['female'];


$q = "SELECT sum(shortagemale) - sum(excessmale) AS male FROM breeder_birdsadjustment WHERE flock LIKE '%$flock'";
$r = mysql_query($q,$conn) or die(mysql_error());
$rr = mysql_fetch_assoc($r);
$madjust = $rr['male'];

?>
<?php if($_SESSION['db']=="golden") { ?>
 <tr>
   <td width="200px">Female Adjustment</td>
   <td width="10px">:</td>
   <td width="100px"><?php if($_SESSION['client'] == "GOLDEN") { echo $fadjust ; } ?></td>
   <td width="200px">Male Adjustment</td>
   <td width="10px">:</td>
   <td width="100px"><?php if($_SESSION['client'] == "GOLDEN" ) { echo  $madjust; } ?></td>
 </tr>
 <?php } ?> 
 <tr>
   <td width="200px">Female Remaining Birds</td>
   <td width="10px">:</td>
   <td width="100px"><?php if($_SESSION['client'] == "GOLDEN") { echo $fbal = (($fopening + $ftrin + $fpur + $fadjust) - ($ftrout+$fmortality1+$fculls1)); } else { echo $fbal = (($fopening + $ftrin + $fpur + $fadjust) - ($ftrout + $fsales+$fmortality1+$fculls1)); } ?></td>
   <td width="200px">Male Remaining Birds</td>
   <td width="10px">:</td>
   <td width="100px"><?php if($_SESSION['client'] == "GOLDEN" ) { echo $mbal = (($mopening + $mtrin + $mpur + $madjust) - ($mtrout+$mmortality1+$mculls1)); } else {echo $mbal = (($mopening + $mtrin + $mpur + $madjust) - ($mtrout + $msales+$mmortality1+$mculls1)); } ?></td>
 </tr> 
</table>

<h4 style="text-align:left;padding-left:20px">Feed Details</h4>
<table border="0" style="text-align:left">
 <tr>
   <td width="200px">Actual Female Feed Consumed</td>
   <td width="10px">:</td>
   <td width="100px"><?php $ffconsumed = round(($ffeed + $iffeed),2); echo changeprice($ffconsumed);?></td>
   <td width="200px">Actual Male Feed Consumed</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo changeprice(round(($mfeed + $imfeed),2)); ?></td>
 </tr>
 
 <tr>  
   <td width="200px">Standard Female Feed</td>
   <td width="10px">:</td>
   <td width="100px"><?php $stdffeed1 = round((($stdffeed * 7 * $fopening) / 1000),2); echo changeprice($stdffeed1); ?></td>
   <td width="200px">Standard Male Feed</td>
   <td width="10px">:</td>
   <td width="100px"><?php $stdmfeed1 = round((($stdmfeed * 7 * $mopening) / 1000),2); echo changeprice($stdmfeed1); ?></td>
 </tr>   

 <tr>
   <td width="200px">Actual Feed/Bird(gms)</td>
   <td width="10px">:</td>
   <td width="100px"><?php $afeedbird = round(($ffconsumed/$fopening * 1000),2); echo changeprice($afeedbird); ?></td>
   <td width="200px">Standard Feed/Bird</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo changeprice(round(($stdffeed1/$fopening * 1000),2)); ?></td>
 </tr> 

 <tr>
   <td width="200px">Feed/Egg(gms)</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo round((($layer_ffeed + $layer_iffeed) * 1000/($production + $tableeggs)),2); ?></td>
<?php
$query = "SELECT sum( materialcost ) / sum( production ) AS result FROM feed_productionunit  ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$result = $rows['result'];
if($result == 0)
{
$query = "SELECT sum( sentquantity * rateperunit ) / sum( sentquantity ) AS result FROM pp_sobi  WHERE code in (select distinct(code) from ims_itemcodes where cat LIKE '%Feed')  ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$result = $rows['result'];
}
?>
   <td width="200px">Feed Cost</td>
   <td width="10px">:</td>
   <td width="100px"><?php $feedcost = round(($result * ($ffconsumed + $ifeed + $mfeed)),2); echo changeprice($feedcost); ?></td>
 </tr>  
 
 <tr>
   <td width="200px"><a href="production/medvac.php?flock=<?php echo $flock;?>" target="_NEW">Medicine/Vaccine Cost</a></td>
   <td width="10px">:</td>
   <td width="100px"><?php echo changeprice($totmedvaccost); ?></td>
 </tr> 
</table>
<?php

$query = "SELECT sum(fmort) as mortality,sum(fcull) as culls  FROM layerbreeder_consumption WHERE flock LIKE '%$flock' AND date1 <= '$mindate' ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$bal = $opening - $rows['mortality'] - $rows['culls'];

$query = "SELECT sum(quantity) as trout FROM ims_stocktransfer WHERE fromwarehouse LIKE '%$flock' AND date <= '$mindate' ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$trout = $rows['trout'];

$query = "SELECT sum(quantity) as trin FROM ims_stocktransfer WHERE fromwarehouse NOT LIKE '%$flock' AND towarehouse LIKE '%$flock' AND date <= '$mindate' ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$trin = $rows['trin'];

$query = "SELECT sum(quantity) as sales FROM oc_cobi WHERE flock LIKE '%$flock' AND date <= '$mindate' ";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$sales = $rows['sales'];

$bal = $bal + $trin - $trout - $sales;

?>
<?php
$query4 = "SELECT description FROM ac_coa WHERE schedule = 'Indirect Expenses' ";
$result4 = mysql_query($query4,$conn) or die(mysql_error());
while($rows4 = mysql_fetch_assoc($result4))
 $iexpenses[$rows4['description']] = 0;
$query1 = "SELECT distinct(unitcode) FROM layerbreeder_flock WHERE flockcode LIKE '%$flock' ";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
 //$flock1 = $rows1['flockcode'];
 $unit1 = $rows1['unitcode'];
 $query3 = "SELECT min(date2) as startdate,max(date2) as enddate FROM layerbreeder_consumption WHERE flock IN (SELECT distinct(flockcode) FROM layerbreeder_flock WHERE flockcode LIKE '%$flock' ) ";
 $result3 = mysql_query($query3,$conn) or die(mysql_error());
 $rows3 = mysql_fetch_assoc($result3);
 $fdate = $startdate = $rows3['startdate'];
 $enddate = $rows3['enddate'];
 while($fdate <= $enddate)
 {
  $monthenddate = date("t",strtotime($fdate));
  $date1 = $fdate;
  $date2 = date("Y-m",strtotime($fdate))."-".$monthenddate;
  if($date2 > $enddate)
   $date2 = $enddate;
  $temp1 = strtotime($date2) - strtotime($date1);
  $noofdays = round( $temp1 / (24 * 60 * 60)) + 1;
  
  	 $query2 = "SELECT distinct(flock) FROM layerbreeder_consumption WHERE date2 BETWEEN '$date1' AND '$date2' AND flock IN (SELECT distinct(flockcode) FROM layerbreeder_flock WHERE unitcode = '$unit1' ) ";
	 $result2 = mysql_query($query2,$conn) or die(mysql_error());
	 $tnumflocks = mysql_num_rows($result2);
	 
	$query5= "SELECT * FROM breeder_unitwisemaintaincecost WHERE unit = '$unit1' AND (('$date1' BETWEEN fromdate AND todate) OR ('$date2' BETWEEN fromdate AND todate)) ";
	 $result5 = mysql_query($query5,$conn) or die(mysql_error());
	 while($rows5 = mysql_fetch_assoc($result5))
	 {
	  $iexpenses[$rows5['description']] += round(($rows5['amount'] / $tnumflocks),2);
	 }
	 //Increament the month
	 $m = date("m",strtotime($date1));
	 $y = date("Y",strtotime($date1));
	 $m++;
	 if($m < 10) $m = "0".$m;
	 if($m == 13) { $y++; $m = "01"; }
	 $fdate = $y."-".$m."-01";
 }
}
?>
<h4 style="text-align:left;padding-left:20px">Expenses</h4>
<table border="0" style="text-align:left">
<?php
$j = 1; $totalexpneses = 0;
$query4 = "SELECT description FROM ac_coa WHERE schedule = 'Indirect Expenses' ";
$result4 = mysql_query($query4,$conn) or die(mysql_error());
while($rows4 = mysql_fetch_assoc($result4))
{
 if($iexpenses[$rows4['description']] > 0) { $totalexpneses += $iexpenses[$rows4['description']];
 if($j == 1)
 {

?>
 <tr>
   <td width="200px"><?php echo $rows4['description']; ?></td>
   <td width="10px">:</td>
   <td width="100px"><?php echo changeprice($iexpenses[$rows4['description']]); ?></td>
<?php $j =2; } else { ?>
   <td width="200px"><?php echo $rows4['description']; ?></td>
   <td width="10px">:</td>
   <td width="100px"><?php echo changeprice($iexpenses[$rows4['description']]); ?></td>
</tr> 
<?php $j =1; } ?>  
<?php } } //end of while ?> 
<?php if($j == 2) echo "</tr>"; ?> 
 <tr>
 <td width="200px">Total Expenses</td>
   <td width="10px">:</td>
   <td width="100px"><?php  echo changeprice($totalexpneses); ?></td>
   <td width="200px">Total Cost</td>
   <td width="10px">:</td>
   <td width="100px"><?php $totalcost = $totalexpneses + $feedcost + ($mchickcost * $mopening) + ($fchickcost * $fopening) + $totmedvaccost; echo changeprice($totalcost); ?></td>
 </tr>
</table>

<h4 style="text-align:left;padding-left:20px">Production</h4>
<table border="0" style="text-align:left">
 <tr>
   <td width="200px">Actual Hatch Eggs</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $production; ?></td>
   <td width="200px">Actual Table Eggs</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $tableeggs; ?></td>
 </tr> 

 <tr>
   <td width="200px">Total Production</td>
   <td width="10px">:</td>
   <td width="100px"><?php $totalproduction = $production + $tableeggs; echo $totalproduction; ?></td>
   <td width="200px">Standard Production</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo round($stdproduction * $lbirds); ?></td>
 </tr> 
<?php
if($flkbreed != "")
{
$query = "SELECT cumhhe,cumhhp,cumchicks FROM layerbreeder_standards WHERE age = '$weeks' AND breed='$flkbreed' ";
}
else
{
$query = "SELECT cumhhe,cumhhp,cumchicks FROM layerbreeder_standards WHERE age = '$weeks' ";
}
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$cumhhe = $rows['cumhhe'];
$cumhhp = $rows['cumhhp'];
$cumchicks = $rows['cumchicks'];
?>   

 <tr>
   <td width="200px">Actual Hatch Egg/bird</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo round(($production/($fopening+$totfpur)),2); ?></td>
   <td width="200px">Standard Hatch Egg/bird</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $cumhhe; ?></td>
 </tr> 

 <tr>
   <td width="200px">Actual Production/bird</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo round(($totalproduction/$lbirds),2); ?></td>
   <td width="200px">Standard Production/bird</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $cumhhp; ?></td>
 </tr> 
<?php
$q = "select sum(quantity*price) as 'total' from oc_cobi where flock LIKE '%$salesflock' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Layer Hatch Eggs' OR cat = 'Eggs') "; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
$qr = mysql_fetch_assoc($qrs);
$revenue = $qr['total'];

$q = "select sum(quantity*price) as 'total' from oc_cobi where flock LIKE '%$flock' AND code NOT IN (SELECT code FROM ims_itemcodes WHERE cat = 'Hatch Eggs' OR cat = 'Eggs') "; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
$qr = mysql_fetch_assoc($qrs);
$orevenue = $qr['total'];


?>
 <tr>
   <td width="200px">Hatch Egg%</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo round(($production * 100 / $totalproduction),2) ?></td>
   <td width="200px">Cost/Hatch Egg</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo round((($feedcost +$totmedvaccost+ $totalexpneses)/$production),2); ?></td>
 </tr> 
<?php 
 $hquery = "select sum(noofeggsset) as senteggs,sum(totalrejections) as rejection,sum(saleablechicks) as final from hatchery_hatchrecord where flock like '%$flock'";
$hatchresult = mysql_query($hquery,$conn);


 if(mysql_num_rows($hatchresult))
{ 
$hatchres = mysql_fetch_assoc($hatchresult);
$fromdate = date("Y-m-d",strtotime($startdate));
$todate = date("Y-m-d",strtotime($enddate));

$imsqty = $hatchres['final']; 
$q = "select  avg(price) as price from ims_stocktransfer where cat = 'Broiler Chicks' "; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
$qr = mysql_fetch_assoc($qrs);
$imsprice = $qr['price'];
if($imsprice == 0)
{
$q = "select  sum(quantity * price)/sum(quantity) as price from oc_cobi where code in (select distinct(code) from ims_itemcodes where cat = 'Broiler Chicks') "; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
$qr = mysql_fetch_assoc($qrs);
$imsprice = $qr['price'];
}
$imsrevenue = round(($imsqty * $imsprice),2);

 $query = "select sum(totalsal) as salamount from hr_payment where date >= '$fromdate' and date <='$todate' and eid in ( select employeeid from hr_employee where sector in (select distinct(sector) from tbl_sector where type1 = 'Hatchery' or warehouse = 'Cold Room'))";
$result = mysql_query($query,$conn) or die(mysql_error());
$res = mysql_fetch_assoc($result);
$salamount = $res['salamount'];

 $query = "select sum(amount) as expences from ac_financialpostings where coacode in (SELECT code FROM ac_coa WHERE schedule = 'Indirect Expenses' ) and warehouse in( select distinct(sector) from tbl_sector where type1 = 'Hatchery' or warehouse = 'Cold Room') ";
$result = mysql_query($query,$conn) or die(mysql_error());
$res = mysql_fetch_assoc($result);
$expences = $res['expences'];


$amount = (($expences + $salamount)/$hatchres['senteggs'])*$hatchres['final'];
$amount = $imsrevenue;
$amount += $totalcost;

?>


 <tr>
   <td width="200px">Actual Chicks</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $hatchres['final']; ?></td>
   <td width="200px">Standard Chicks</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $cumhhe*$fopening; ?></td>
</tr> 

 <tr>
   <td width="200px">Chicks/Bird</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo round($hatchres['final']/$fopening,2); ?></td>
   <td width="100px">Standard Chicks/Bird</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $cumchicks ?></td>
 </tr>

<tr>
   <td width="200px">Cost/Chick</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo round($amount/$hatchres['final'],2) ?></td>
   <td width="200px"><?php if($imsrevenue != 0 || $imsrevenue != "") {?><a href="production/crevenue.php?flock=<?php echo $salesflock;?>&rate=<?php echo $imsprice;?>" target="_NEW">Revenue from Chicks</a><?php } else { echo "Revenue from Chicks"; }?></td>
   <td width="10px">&nbsp;</td>
   <td width="100px"><?php if($imsrevenue == "") echo "0"; else echo changeprice($imsrevenue); ?></td>
</tr>
<?php } ?>
 <tr>
   <td width="200px"><?php if($revenue != 0 || $revenue != "") {?><a href="production/revenue.php?flock=<?php echo $salesflock;?>" target="_NEW">Revenue from Eggs</a><?php } else { echo "Revenue from Eggs"; }?></td>
   <td width="10px">:</td>
   <td width="100px"><?php if($revenue == "") echo "0"; else echo changeprice($revenue); ?></td>
   <td width="200px"><?php if($revenue != 0 || $revenue != "") {?><a href="production/orevenue.php?flock=<?php echo $salesflock;?>" target="_NEW">Revenue from Other Sources</a><?php } else { echo "Revenue from Other Sources"; }?></td>
   <td width="10px">:</td>
   <td width="100px"><?php if($orevenue == "") echo "0"; else echo changeprice($orevenue); ?></td>
 </tr> 

 <tr>
   <td width="200px">Total Revenue</td>
   <td width="10px">:</td>
   <td width="100px"><?php $trevenue = $revenue + $orevenue; echo changeprice($trevenue); ?></td>
   <td width="200px">Realization</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo changeprice($trevenue - $totalcost); ?></td>
 </tr> 

</table>


<!--<table>
<tr>

<td>
<table border="0" width="337" height="60">
<tr><td>
<br />
<hr width="300" />
Company Representative
</td></tr>
</table>
</td>
<td>
<table border="0" width="337" height="60">
<tr><td>
<br />
<hr width="300" />
 ( Director )
</td></tr></table>
</td>
</tr>
</table>-->
<br /><br />
</div>
</center>
</body>
</html>