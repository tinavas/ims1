<?php
$flockget = $c = $_GET['flock']; 

session_start();
$client = $_SESSION['client'];
$db = $_SESSION['db'];

include "config.php";
	 $eggtype = "'dummy'";
                  $q = "select * from ims_itemcodes where cat like '%Eggs%' and client='$client'"; 
      		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		      while($qr = mysql_fetch_assoc($qrs))
		      {
                     $eggtype = $eggtype . ",'" . $qr['code'] . "'";
                } 
function gettransferfemalefrom($a,$b)
{
           include "config.php";
             $q = "select * from ims_stocktransfer where cat like 'Female Birds' and fromwarehouse = '$a' and date < '$b'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
               $fromlessfemales = "0";
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                 $fromlessfemales = $fromlessfemales + $qr['quantity'];
               }
             }
             else
             {
                $fromlessfemales = 0;
             } 

      return $fromlessfemales;  
}


function gettransferfemaleto($a,$b)
{
           include "config.php";
             $q = "select * from ims_stocktransfer where cat like 'Female Birds' and towarehouse = '$a' and date < '$b'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
               $toplusfemales = "0";
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                 $toplusfemales = $toplusfemales + $qr['quantity'];
               }
             }
             else
             {
                $toplusfemales = 0;
             } 

       return  $toplusfemales;  
}

function getsalebirdsfemale($a,$b)
{
           include "config.php";
           $birdscodes = "''";
           $query12 = "SELECT * from ims_itemcodes where cat like 'Female Birds'";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
               $birdscodes =  $birdscodes . ",'" .$row12['code'] . "'";                
           }

           $query12 = "SELECT sum(quantity) as `num` FROM oc_cobi where flock='$a' and date < '$b' and flag = 1 and code in ($birdscodes) ORDER BY date DESC ";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
              return $row12['num'];    
              //return 0;  
           }
}

function getpurbirdsfemale($a,$b)
{
           include "config.php";
           $birdscodes = "''";
           $query12 = "SELECT * from ims_itemcodes where cat like 'Female Birds'";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
               $birdscodes =  $birdscodes . ",'" .$row12['code'] . "'";                
           }

           $query12 = "SELECT sum(receivedquantity) as `num` FROM pp_sobi where flock='$a' and date < '$b'  and code in ($birdscodes) ORDER BY date DESC ";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
              return $row12['num'];    
              //return 0;  
           }
}

function gettransfermalefrom($a,$b)
{
           include "config.php";
             $q = "select * from ims_stocktransfer where cat like 'Male Birds' and fromwarehouse = '$a' and date < '$b'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
               $fromlessfemales = "0";
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                 $fromlessfemales = $fromlessfemales + $qr['quantity'];
               }
             }
             else
             {
                $fromlessfemales = 0;
             } 

      return $fromlessfemales;  
}


function gettransfermaleto($a,$b)
{
           include "config.php";
             $q = "select * from ims_stocktransfer where cat like 'Male Birds' and towarehouse = '$a' and date < '$b'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
               $toplusfemales = "0";
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                 $toplusfemales = $toplusfemales + $qr['quantity'];
               }

             }
             else
             {
                $toplusfemales = 0;
             } 

       return  $toplusfemales;  
}

function getsalebirdsmale($a,$b)
{
           include "config.php";
           $birdscodes = "''";
           $query12 = "SELECT * from ims_itemcodes where cat like 'Male Birds'";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
               $birdscodes =  $birdscodes . ",'" .$row12['code'] . "'";                
           }

           $query12 = "SELECT sum(quantity) as `num` FROM oc_cobi where flock='$a' and date < '$b' and flag = 1 and code in ($birdscodes) ORDER BY date DESC ";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
              return $row12['num'];    
              //return 0;  
           }
}

function getpurbirdsmale($a,$b)
{
           include "config.php";
           $birdscodes = "''";
           $query12 = "SELECT * from ims_itemcodes where cat like 'Male Birds'";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
               $birdscodes =  $birdscodes . ",'" .$row12['code'] . "'";                
           }

           $query12 = "SELECT sum(receivedquantity) as `num` FROM pp_sobi where flock='$a' and date < '$b'  and code in ($birdscodes) ORDER BY date DESC ";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
              return $row12['num'];    
              //return 0;  
           }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Performance Graphs</title>
    <link href="layout.css" rel="stylesheet" type="text/css"></link>
    <!--[if IE]><script language="javascript" type="text/javascript" src="../excanvas.min.js"></script><![endif]-->
    <script language="javascript" type="text/javascript" src="../jquery.js"></script>
    <script language="javascript" type="text/javascript" src="../jquery.flot.js"></script>
    <script language="javascript" type="text/javascript" src="../jquery.flot.dashes.js"></script>
	
      <link href="css/common.css" rel="stylesheet" type="text/css">
	<link href="css/standard.css" rel="stylesheet" type="text/css">


 </head>
    <body onload="change('all');" >
      <center>
   <?php include "reportheader.php"; ?><br /><br />
    <table border="0">
     <tr>
       <td colspan="3">
         Performance Summary For Flock <?php echo $c; ?>
       </td>
     </tr>
     <tr>
      <td colspan="3">
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" id="all" value="all" checked="true" onclick="change(this.value);" /> All
&nbsp;&nbsp;&nbsp;&nbsp;
       <input type="checkbox" id="weights" value="weights" onclick="change(this.value);" /> Body Weights
&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" id="feedperbird" value="feedperbird" onclick="change(this.value);" /> Feed/Bird
&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" id="eggperbird" value="eggperbird" onclick="change(this.value);" /> Egg/Bird
&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" value="Print" onclick="window.print();" />
      </td>
     </tr> 
     <tr>
      <td>
       <span style="filter:flipv fliph;writing-mode:tb-rl;"><span style="">Percentage (%)</span></span>
      </td>
      <td width="5px"></td>
      <td>
        <div id="placeholder" style="width:900px;height:480px;text-align:left"></div>
      </td>
      <td width="5px"></td>
      <td>
       <span style="filter:flipv fliph;writing-mode:tb-rl;"><span style="">Grams (grm)</span></span>
      </td>
     </tr>
     <tr>
      <td colspan="3">Age (Weeks)</td>
     </tr> 
   </table>
    </center>
<script id="source" language="javascript" type="text/javascript">

function change(ab)
{

  if(ab == "all")
 {
  
  document.getElementById("weights").checked = false;
  document.getElementById("feedperbird").checked = false;
  document.getElementById("eggperbird").checked = false;
 }
 else if(ab == "weights")
 {
  document.getElementById("all").checked = false;
  document.getElementById("feedperbird").checked = false;
  document.getElementById("eggperbird").checked = false;
 }
 else if(ab == "feedperbird")
 {
  document.getElementById("all").checked = false;
  document.getElementById("weights").checked = false;
  document.getElementById("eggperbird").checked = false;
 }
  else if(ab == "eggperbird")
 {
  document.getElementById("all").checked = false;
  document.getElementById("weights").checked = false;
  document.getElementById("feedperbird").checked = false;
 }

$(function () {

var fweight = [
     <?php 
           include "config.php"; $w = 0;
           $querya = "SELECT * FROM breeder_flock where flockcode = '$c'";
           $resulta = mysql_query($querya,$conn1); 
           while($row1a = mysql_fetch_assoc($resulta))
           {
             $age = $row1a['age']; 
             $date = $row1a['startdate'];
             $birds = $row1a['femaleopening'];
           }
		   $odate = $date;

           $nrSeconds = $age * 24 * 60 * 60;
           $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
           $nrWeeksPassed = floor($nrSeconds / 604800); 
           $startage = $nrWeeksPassed;
 
           $query12 = "SELECT * FROM breeder_consumption where flock = '$c' GROUP BY date2 ";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
              
              $nrSeconds = $age * 24 * 60 * 60;
              $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
              $nrWeeksPassed = floor($nrSeconds / 604800); 
              if ($nrDaysPassed == 1)
              {
                 $odate = $row12['date'];   
              }
              if ($nrDaysPassed == 0)
              {
                $query12ab = "SELECT max(fweight) as `fw` FROM breeder_consumption where flock = '$c' and date2 <= '$row12[date2]' ";
                  $result12ab = mysql_query($query12ab,$conn1); 
                  while($row12ab = mysql_fetch_assoc($result12ab))
                  {
                     $oldw = $w; 
                     $w = $row12ab['fw'];
                     if($w == 0) { $w = $oldw; }
      ?>
                     [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>],                             
      <?php 
                  }                    
              }  
			  $age = $age + 1; 
           } 

     ?>
 [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>]];
 
 var mweight = [
     <?php 
           include "config.php"; $w = 0;
           $querya = "SELECT * FROM breeder_flock where flockcode = '$c'";
           $resulta = mysql_query($querya,$conn1); 
           while($row1a = mysql_fetch_assoc($resulta))
           {
             $age = $row1a['age']; 
             $date = $row1a['startdate'];
             $birds = $row1a['maleopening'];
           }
		   $odate = $date;

           $nrSeconds = $age * 24 * 60 * 60;
           $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
           $nrWeeksPassed = floor($nrSeconds / 604800); 
           $startage = $nrWeeksPassed;
		   $minage = $nrWeeksPassed;
 
           $query12 = "SELECT * FROM breeder_consumption where flock = '$c' GROUP BY date2 ";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
              
              $nrSeconds = $age * 24 * 60 * 60;
              $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
              $nrWeeksPassed = floor($nrSeconds / 604800);
			  $maxage =  $nrWeeksPassed;
              if ($nrDaysPassed == 1)
              {
                 $odate = $row12['date'];   
              }
              if ($nrDaysPassed == 0)
              {
                $query12ab = "SELECT max(mweight) as `mw` FROM breeder_consumption where flock = '$c' and date2 <= '$row12[date2]' ";
                  $result12ab = mysql_query($query12ab,$conn1); 
                  while($row12ab = mysql_fetch_assoc($result12ab))
                  {
                     $oldw = $w; 
                     $w = $row12ab['mw'];
                     if($w == 0) { $w = $oldw; }
      ?>
                     [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>],                             
      <?php 
                  }                    
              }  
			  $age = $age + 1; 
           } 

     ?>
 [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>]];


 
 var feedperbird = [
     <?php 
           include "config.php"; $w = 0;
           $querya = "SELECT * FROM breeder_flock where flockcode = '$c'";
           $resulta = mysql_query($querya,$conn1); 
           while($row1a = mysql_fetch_assoc($resulta))
           {
             $age = $row1a['age']; 
             $date = $row1a['startdate'];
             $female = $row1a['femaleopening'];
			 $male = $row1a['maleopening'];
           }
 $odate = $date;
           $nrSeconds = $age * 24 * 60 * 60;
           $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
           $nrWeeksPassed = floor($nrSeconds / 604800); 
           $startage = $nrWeeksPassed;
 
                  $feedtype = "'dummy'";
                  $q = "select * from ims_itemcodes where cat like 'Female Feed'"; 
      		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		      while($qr = mysql_fetch_assoc($qrs))
		      {
                     $feedtype = $feedtype . ",'" . $qr['code'] . "'";
                  } 
			
           $query12 = "SELECT * FROM breeder_consumption where flock = '$c' GROUP BY date2 ";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
            
              $nrSeconds = $age * 24 * 60 * 60;
              $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
              $nrWeeksPassed = floor($nrSeconds / 604800); 
              if ($nrDaysPassed == 1)
              {
                 $odate = $row12['date2'];   
              }
			 
              if ($nrDaysPassed == 0)
              {

                 include "config.php"; 
                  $mort = 0;
                    $querya = "SELECT distinct(date2),mmort,fmort,fcull,mcull FROM breeder_consumption where flock = '$c' and date2 < '$odate' ";
                  $resulta = mysql_query($querya,$conn1); 
                  while($row1a = mysql_fetch_assoc($resulta))
                  {
                     //$mort = $mort + $row1a['fmort'] + $row1a['mmort'] + $row1a['fcull'] + $row1a['mcull'];
					  $mort = $mort + $row1a['fmort']  + $row1a['fcull'] ;
                  }


                  $femaleminus = gettransferfemalefrom($c,$odate);
                  $femaleplus = gettransferfemaleto($c,$odate);
                  $femalesale = getsalebirdsfemale($c,$odate); 
				  $femalepur = getpurbirdsfemale($c,$odate);

 
                  //$getremainingfemale = $female + $femalepur($femaleplus - $femaleminus) - ($femalesale + $mort);
				   $getremainingfemale = $female + $femalepur + ($femaleplus - $femaleminus) - ( $mort);
                 $query12a = "SELECT sum(quantity) as `fm` FROM breeder_consumption where flock = '$c' and date2 >= '$odate' and date2 <= '$row12[date2]' and itemcode in ($feedtype)";
                  $result12a = mysql_query($query12a,$conn1); 
                  while($row12a = mysql_fetch_assoc($result12a))
                  {
				
				  $inc = 0;
				  $queryi = "SELECT distinct(date2) FROM breeder_consumption where flock = '$c' and date2 >= '$odate' and date2 <= '$row12[date2]'";
                  $resulti = mysql_query($queryi,$conn1); 
				  $inc = mysql_num_rows($resulti);
                  				  
				     $oldw = $w; 
					 $w = (($row12a['fm']/$inc) / $getremainingfemale) * 1000;

                     if($w == 0) { $w = $oldw; }
      ?>
                     [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>],                             
      <?php 
	 
                  }                    
              } 
			  $age = $age +1; 
           } 

     ?>
 [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>]];


var eggperbird = [
     <?php 
           $startfemale =0;$pcount=0;$prodate ="";
		   include "config.php"; 
		  $q22 = "Select * from breeder_production where flock like '$flockget' and  client='$client'";
		$res22 = mysql_query($q22,$conn1); 
		 $pcount = mysql_num_rows($res22);
		 if($flockget!= "" && $pcount>0)
		{
		$query1 = "SELECT min(date1) as 'date1' FROM breeder_production WHERE flock like '$flockget' and  client='$client'";
		$result1 = mysql_query($query1,$conn1); 
		while($row11 = mysql_fetch_assoc($result1))
		{
   		$prodate = $row11['date1'];
		}
		$query1 = "SELECT age  FROM breeder_consumption WHERE flock like '$flockget' and date2='$prodate' and  client='$client' group by date2";
$result1 = mysql_query($query1,$conn1); 
while($row11 = mysql_fetch_assoc($result1))
{
  $prodage = $row11['age'];
}

if($prodate)
{
$prodate = $prodate;
$prodagewk = ceil($prodage/7);
}
else
{
$prodate = "2020-01-01";
$prodage = 999999;
}
$startdummage = 0;
$query12 = "SELECT min(age) as minage,female,male from breeder_initial WHERE flock like '$flockget' and age < '$prodage' and eggs <> '' ";
$result12 = mysql_query($query12,$conn1); 
while($row12 = mysql_fetch_assoc($result12))
{ 
$startdummage = $row12['minage'];
$strtfemale = $row12['female'];
}
$query12 = "SELECT sum(fmort) as fmort,sum(fcull) as fcull,sum(mmort) as mmort,sum(mcull) as mcull from breeder_initial WHERE flock like '$flockget' and age < '$startdummage' ";
$result12 = mysql_query($query12,$conn1); 
while($row12 = mysql_fetch_assoc($result12))
{ 
  $fcummort = $row12['fmort'];
 $fcumcull = $row12['fcull'];
}

$fprodop = $strtfemale - $fcummort - $fcumcull;
$startfemale =0;
$tcount =0;

$query1 = "SELECT * FROM breeder_flock WHERE flockcode like '$flockget' group by startdate";
$result1 = mysql_query($query1,$conn1); 
 $tcount = mysql_num_rows($result1);

if($tcount > 1)
{
  $query1 = "SELECT sum(femaleopening) as femaleopening,age,startdate FROM breeder_flock WHERE flockcode like '%flockget' group by startdate order by startdate asc limit 1";
  $result1 = mysql_query($query1,$conn1); 
  while($row11 = mysql_fetch_assoc($result1))  
  {
      $startdate = $row11['startdate'];
      $startage = $row11['age'];
      $startfemale = $row11['femaleopening'];
      
  }
}
else
{
  $query1 = "SELECT * FROM breeder_flock WHERE flockcode like '$flockget'";
  $result1 = mysql_query($query1,$conn1); 
  while($row11 = mysql_fetch_assoc($result1))  
  {
      $startdate = $row11['startdate'];
      $startage = $row11['age'];
      $startfemale = $startfemale + $row11['femaleopening'];
     
  }
}

$query1 = "SELECT * FROM breeder_consumption WHERE flock like '$flockget' and date2 < '$prodate' and  client='$client' group by date2,flock";
$result1 = mysql_query($query1,$conn1); 
while($row11 = mysql_fetch_assoc($result1))
{
  $startfemale = $startfemale - ($row11['fmort'] + $row11['fcull']);
  //$startmale = $startmale - ($row11['mmort'] + $row11['mcull']);
}
$femalet = 0;
$query1t = "SELECT cat,quantity FROM `ims_stocktransfer` WHERE cat = 'Female Birds' AND client = '$client' AND towarehouse like '$flockget'  and fromwarehouse not like '$flockget' AND date<'$prodate'";
  $result1t = mysql_query($query1t,$conn1); 
  while($row11t = mysql_fetch_assoc($result1t))  
  {
      $femalet = $femalet + $row11t['quantity'];
  }
  
  if($femalet > 0)
  {
	 $startfemale = $startfemale +$femalet;
  }

  $femaletout = 0;
  $query1t = "SELECT cat,quantity FROM `ims_stocktransfer` WHERE cat = 'Female Birds' AND client = '$client' AND fromwarehouse like '$flockget'  AND towarehouse not like '$flockget'  AND date<'$prodate'";
  $result1t = mysql_query($query1t,$conn1); 
  while($row11t = mysql_fetch_assoc($result1t))  
  {
	  $femaletout = $femaletout + $row11t['quantity'];
  }
  if($femaletout > 0)
  {
 $startfemale = $startfemale -$femaletout;
  }
  
  $femalepur = 0;
  $query1t = "SELECT * FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat ='Female Birds') AND client = '$client' AND flock like '%$flockget' AND date<'$prodate'";
  $result1t = mysql_query($query1t,$conn1); 
  while($row11t = mysql_fetch_assoc($result1t))  
  {
   
     	  $femalepur = $femalepur + $row11t['receivedquantity'];
	  
  }
   if($femalepur > 0)
  {
  $startfemale = $startfemale +$femalepur;
  }
  
   $femalesale = 0;

  $query1t = "SELECT * FROM `oc_cobi` WHERE code in (select distinct(code) from ims_itemcodes where cat ='Female Birds') AND client = '$client' AND flock like '%$flockget' AND date<'$prodate'";
  $result1t = mysql_query($query1t,$conn1); 
  while($row11t = mysql_fetch_assoc($result1t))  
  {
   
     	  $femalesale = $femalesale + $row11t['quantity'];
  }
    
  if($startdummage > 0)
  	{
	$startfemale = $fprodop; 
	}
  else
  {
	$startfemale = $startfemale ;
  }
 $w = 0;$female=0;$age=0;
		  
$tothe =0;		  
 $query121 = "SELECT * from breeder_initial WHERE flock like '$flockget' and age < '$prodagewk' and eggs <> '' order by age";
$result121 = mysql_query($query12,$conn1); 
while($row121 = mysql_fetch_assoc($result12))
{ 
$totprod = 0;
$tothe = 0;
 $agewk = $row121['age'];
  $prod = $row121['eggs'];
  $cat = explode(",",$prod);
  $eggcnt = count($cat) - 1;
  for($d = 0;$d < $eggcnt;$d++)
  {
    $eggs = explode(":",$cat[$d]);
	if(in_array($eggs[0],$eggtype))
     {
	 $tothe = $tothe + $eggs[1];
	}
  }
  
  $w = ($tothe / $startfemale);
                    
      ?>
                     [<?php echo $agewk; ?>,<?php echo $w; ?>],                             
      <?php 
	  }
	 
	  $query12 = "SELECT * FROM breeder_consumption where flock like '$flockget' and client='$client' GROUP BY date2 ";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
		    
		   $diffdate = strtotime($row12['date2']) - strtotime($startdate);
 		 $diffdate = $diffdate/(24*60*60);   
  $newage = $startage + $diffdate;
  $nrSeconds = $newage * 24 * 60 * 60;
  $nrDaysPassed = floor($nrSeconds / 86400) % 7;  
  $nrWeeksPassed = floor($nrSeconds / 604800); 
  if($nrDaysPassed) { $nrDaysPassed = $nrDaysPassed; $nrWeeksPassed = $nrWeeksPassed; } else { $nrDaysPassed = 7; $nrWeeksPassed = $nrWeeksPassed - 1; }
		   
           
              if ($nrDaysPassed == 0)
              {
                 $odate = $row12['date2'];   
              }
              if ($nrDaysPassed == 7)
              {
            $query12a = "SELECT sum(quantity) as 'totaleggs' FROM breeder_production where flock like '$flockget'  and date1 <= '$row12[date2]' and client='$client' and itemcode in ($eggtype) ";
                  $result12a = mysql_query($query12a,$conn1); 
                  while($row12a = mysql_fetch_assoc($result12a))
                  {
                     $oldw = $w; 
                     $totaleggs = $tothe + $row12a['totaleggs']; 
                     $w = ($totaleggs / $startfemale);
                     if($w == 0) { $w = $oldw; }
      ?>
                     [<?php echo $nrWeeksPassed+1; ?>,<?php echo $w; ?>],                             
      <?php 
                  }                    
              }  
           } 
		   }
     ?>
 [<?php echo $nrWeeksPassed+1; ?>,<?php echo $w; ?>]];


var fwstandard = [
     <?php $avgweight = 0;
       include "config.php";
       $query1 = "SELECT * FROM breeder_standards ORDER BY age ASC ";
       $result1 = mysql_query($query1,$conn1);
       while($row1 = mysql_fetch_assoc($result1))
       {
         $age = $row1['age'];
         $oldavg = $avgweight;
         $avgweight = $row1['fweight'];
         if($avgweight == 0) { $avgweight = $oldavg; }
     ?>
       [<?php echo $age; ?>,<?php echo $avgweight; ?>],
     <?php  } ?>
     [<?php echo $age; ?>,<?php echo $avgweight; ?>]];
	 
var mwstandard = [
     <?php $avgweight = 0;
       include "config.php";
       $query1 = "SELECT * FROM breeder_standards ORDER BY age ASC ";
       $result1 = mysql_query($query1,$conn1);
       while($row1 = mysql_fetch_assoc($result1))
       {
         $age = $row1['age'];
         $oldavg = $avgweight;
         $avgweight = $row1['mweight'];
		 $maxweight = $avgweight;
         if($avgweight == 0) { $avgweight = $oldavg; }
     ?>
       [<?php echo $age; ?>,<?php echo $avgweight; ?>],
     <?php  } ?>
     [<?php echo $age; ?>,<?php echo $avgweight; ?>]];
	 


var eggbirdstandard = [
     <?php $avgweight = 0;
       include "config.php";
       $query1 = "SELECT * FROM breeder_standards ORDER BY age ASC ";
       $result1 = mysql_query($query1,$conn1);
       while($row1 = mysql_fetch_assoc($result1))
       {
         $age = $row1['age'];
         $oldavg = $avgweight;
         $avgweight = $row1['cumhhp'];
         if($avgweight == 0) { $avgweight = $oldavg; }
     ?>
       [<?php echo $age; ?>,<?php echo $avgweight; ?>],
     <?php  } ?>
     [<?php echo $age; ?>,<?php echo $avgweight; ?>]];

var fm = [
     <?php $avgweight = 0;
       include "config.php";
       $query1 = "SELECT * FROM breeder_standards ORDER BY age ASC ";
       $result1 = mysql_query($query1,$conn1);
       while($row1 = mysql_fetch_assoc($result1))
       {
         $age = $row1['age'];
         $oldavg = $avgweight;
         $avgweight = $row1['ffeed'];
         if($avgweight == 0) { $avgweight = $oldavg; }
     ?>
       [<?php echo $age; ?>,<?php echo $avgweight; ?>],
     <?php  } ?>
     [<?php echo $age; ?>,<?php echo $avgweight; ?>]];	

<!-- , dashes: { show: true }, hoverable: true  -->
if(document.getElementById("all").checked)
{

  var plot =   $.plot($("#placeholder"),
           [
             { data: fwstandard, label: "Female B.Wt. Standard", color:'#FFFF00',yaxis: 2 },
             { data: mwstandard, label: "Male B.Wt. Standard", color:'#006600',yaxis: 2 },
			 { data: eggbirdstandard, label: "Egg/Bird Standard", color:'#CC0000' },
			 { data: fm, label: "Feed/Bird Standard", color:'#000099' },
			 { data: fweight, label: "Female B.Wt. Actual", color:'#FFFFAA',yaxis: 2 },
             { data: mweight, label: "Male B.Wt. Actual", color:'#00FF00',yaxis: 2 },
			 { data: eggperbird, label: "Egg/Bird Actual", color:'#FF9999' },
			 { data: feedperbird, label: "Feed/Bird Actual", color:'#9999FF' }],
             
           { 
             grid: { hoverable: true, clickable: true },
             xaxis: { min: <?php echo $minage; ?>,max: <?php echo $maxage; ?>,
                      tickSize: 2,
					  label: "test"
                    },
             yaxis: { min: 0, tickSize: 20, max:400 },
             y2axis: { min : 0, tickSize: 250, max:<?php echo $maxweight; ?> },
             legend: { margin: [660,320] } 
    });
}
else
{
  if(document.getElementById("weights").checked)
 {
            var plot =   $.plot($("#placeholder"),
           [ { data: fwstandard, label: "Female B.Wt. Standard", color:'#FFFF00',yaxis: 2 },
             { data: mwstandard, label: "Male B.Wt. Standard", color:'#006600',yaxis: 2 },
			 { data: fweight, label: "Female B.Wt. Actual", color:'#FFFFAA',yaxis: 2 },
             { data: mweight, label: "Male B.Wt. Actual", color:'#00FF00',yaxis: 2 }],
           { 
             grid: { hoverable: true, clickable: true },
             xaxis: {min: <?php echo $minage; ?>,max: <?php echo $maxage; ?>,
                      tickSize: 2,
					  label: "test"
                    },
             yaxis: { min: 0, tickSize: 20, max:400 },
             y2axis: { min : 0, tickSize: 250, max:<?php echo $maxweight; ?> },
             legend: { margin: [660,280] } 
    });
 }

 if(document.getElementById("feedperbird").checked)
 {
            var plot =   $.plot($("#placeholder"),
           [ 
			 { data: fm, label: "Feed/Bird Standard", color:'#000099' },
			 { data: feedperbird, label: "Feed/Bird Actual", color:'#9999FF' }],
           { 
             grid: { hoverable: true, clickable: true },
             xaxis: { min: <?php echo $minage; ?>,max: <?php echo $maxage; ?>,
                      tickSize: 2,
					  label: "test"
                    },
             yaxis: { min: 0, tickSize: 20, max:400 },
             y2axis: { min : 0, tickSize: 250, max:<?php echo $maxweight; ?> },
             legend: { margin: [660,280] } 
    });
 }

 if(document.getElementById("eggperbird").checked)
 {
            var plot =   $.plot($("#placeholder"),
           [ 
			 { data: eggbirdstandard, label: "Egg/Bird Standard", color:'#CC0000' },
			 { data: eggperbird, label: "Egg/Bird Actual", color:'#FF9999' }],
           { 
             grid: { hoverable: true, clickable: true },
             xaxis: { min: <?php echo $minage; ?>,max: <?php echo $maxage; ?>,
                      tickSize: 2,
					  label: "test"
                    },
             yaxis: { min: 0, tickSize: 20, max:400 },
             y2axis: { min : 0, tickSize: 250, max:<?php echo $maxweight; ?> },
             legend: { margin: [660,280] } 
    });
 }
}
    function showTooltip(x, y, contents) {
        $('<div id="tooltip">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #fdd',
            padding: '2px',
            'background-color': '#fee',
            opacity: 0.80
        }).appendTo("body").fadeIn(200);
    }

    var previousPoint = null;
    $("#placeholder").bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
       if(document.getElementById("weights").checked)
	   {
        $("#y2").text(pos.y2.toFixed(2));
		}
       /*else
        $("#y").text(pos.y.toFixed(2));*/

        if (1) {
            if (item) {
                if (previousPoint != item.datapoint) {
                    previousPoint = item.datapoint;
                    
                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(0),
                        y = item.datapoint[1].toFixed(2);
                    
                    showTooltip(item.pageX, item.pageY,
                                item.series.label +" for " + x + " Weeks " + " is " + y);
                }
            }
            else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
        }
    });

    $("#placeholder").bind("plotclick", function (event, pos, item) {
        if (item) {
            $("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");
            plot.highlight(item.series, item.datapoint);
        }
    });
});



}
</script>
 </body>
</html>

