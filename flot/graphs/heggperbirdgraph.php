<?php
$c = $_GET['flock']; 
session_start();
 $db = $_SESSION['db'];
if($_GET['unit'] == "all")
{
$uc = "<>";
$unit = $_GET['unit'];
}
else
{
$uc = "=";
$unit = $_GET['unit'];
}

if($_GET['type'] == "all")
{
$tc = "<>";
$type = 99;
}
else
{
$tc = "=";
$type = $_GET['type'];
}
 
 
 
 
 $client = $_SESSION['client'];
$clorarr = array("#9933FF","#999900","#33CC33","#663333","#FF9933","#669933","#CC6699","#FFFF00","#993333","#CC66FF","#333399","#FF9999","#0000FF","#33CCCC","#993399");


$i=0;$k=0;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>B.I.M.S Graphs</title>
    <link href="layout.css" rel="stylesheet" type="text/css"></link>
    <!--[if IE]><script language="javascript" type="text/javascript" src="../excanvas.min.js"></script><![endif]-->
    <script language="javascript" type="text/javascript" src="../jquery.js"></script>
    <script language="javascript" type="text/javascript" src="../jquery.flot.js"></script>
    <script language="javascript" type="text/javascript" src="../jquery.flot.dashes.js"></script>
	

 </head>
    <body>
      <center>
	  <?php include "reportheader.php"; ?><br /><br />
    <table border="0">
     <tr>
       <td colspan="3">
         Hatch Egg / Bird Graph
       </td>
     </tr>
 
     <tr>
      <td>
       <span style="filter:flipv fliph;writing-mode:tb-rl;"><span style="">Hatch Egg / Bird (%)</span></span>
      </td>
      <td width="5px"></td>
      <td>
        <div id="placeholder" style="width:900px;height:480px;text-align:left;" ></div>
      </td>
      <td width="5px"></td>
     </tr>
     <tr>
      <td colspan="3">Age (Weeks)</td>
     </tr> 
   </table>
    </center>
	<?php  
	include "config.php";
	 $eggtype = "'dummy'";
                  $q = "select * from ims_itemcodes where cat = 'Hatch Eggs' and client='$client'"; 
      		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		      while($qr = mysql_fetch_assoc($qrs))
		      {
                     $eggtype = $eggtype . ",'" . $qr['code'] . "'";
                } 
	
	$h = 1;
$hatcheggtype[0] = "dummy";
$query = "SELECT * FROM ims_itemcodes WHERE cat = 'Hatch Eggs'";
$result = mysql_query($query,$conn1); 
while($row1 = mysql_fetch_assoc($result))
{ 
  $hatcheggtype[$h] = $row1['code'];
  $h = $h + 1;
}

 
  
  /* if($malet > 0)
  {
  $startmale = $startmale - $malesale;
  }
		 
		 */
		 ?>
<script id="source" language="javascript" type="text/javascript">

$(function () {
 <?php  
 $q = "select distinct(flkmain) from breeder_flock where  client='$client' and cullflag $tc '$type' and unitcode $uc '$unit'  order by flkmain";
  //$q = "select * from breeder_flock where  client='$client'  order by flockcode"; 
  
 $qrs = mysql_query($q,$conn1) or die(mysql_error());
  while($qr = mysql_fetch_assoc($qrs))
  {
		$flockget = "";$startfemale =0;$pcount=0;$prodate ="";
		//$flockget = $qr['flockcode'];
		$flockget = $qr['flkmain'];
		 $q22 = "Select * from breeder_production where flock like '%$flockget' and  client='$client'";
		$res22 = mysql_query($q22,$conn1); 
		 $pcount = mysql_num_rows($res22);
		if($flockget!= "" && $pcount>0)
		{
		

$query1 = "SELECT min(date1) as 'date1' FROM breeder_production WHERE flock like '%$flockget' and  client='$client'";
$result1 = mysql_query($query1,$conn1); 
while($row11 = mysql_fetch_assoc($result1))
{
  $prodate = $row11['date1'];
}
$query1 = "SELECT age  FROM breeder_consumption WHERE flock like '%$flockget' and date2='$prodate' and  client='$client' group by date2";
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
$query12 = "SELECT min(age) as minage,female,classic,male from breeder_initial WHERE flock like '%$flockget' and age < '$prodage'  ";
$result12 = mysql_query($query12,$conn1); 
while($row12 = mysql_fetch_assoc($result12))
{ 
$startdummage = $row12['minage'];
$strtfemale = $row12['female']+$row12['classic'];
//$strtmale = $row12['male'];
}
$query12 = "SELECT sum(fmort) as fmort,sum(fcull) as fcull,sum(cmort) as cmort,sum(ccull) as ccull,sum(mmort) as mmort,sum(mcull) as mcull from breeder_initial WHERE flock like '%$flockget' and age < '$startdummage' ";
$result12 = mysql_query($query12,$conn1); 
while($row12 = mysql_fetch_assoc($result12))
{ 
  $fcummort = $row12['fmort']+$row12['cmort'];
 $fcumcull = $row12['fcull']+$row12['ccull'];
//$mcummort = $row12['mmort'];
//$mcumcull = $row12['mcull'];
}
//echo "start female from initial";
$fprodop = $strtfemale - $fcummort - $fcumcull;
//$mprodop = $strtmale - $mcummort - $mcumcull; 
 
 
   
$startfemale =0;
$tcount =0;

$query1 = "SELECT * FROM breeder_flock WHERE flockcode like '%$flockget' group by startdate";
$result1 = mysql_query($query1,$conn1); 
 $tcount = mysql_num_rows($result1);

if($tcount > 1)
{
  $query1 = "SELECT sum(femaleopening) as femaleopening,sum(classicopening) as classicopening,age,startdate FROM breeder_flock WHERE flockcode like '%$flockget' group by startdate order by startdate asc limit 1";
  $result1 = mysql_query($query1,$conn1); 
  while($row11 = mysql_fetch_assoc($result1))  
  {
      $startdate = $row11['startdate'];
      $startage = $row11['age'];
      $startfemale = $row11['femaleopening']+$row11['classicopening'];
      
  }
}
else
{
  $query1 = "SELECT * FROM breeder_flock WHERE flockcode like '%$flockget'";
  $result1 = mysql_query($query1,$conn1); 
  while($row11 = mysql_fetch_assoc($result1))  
  {
      $startdate = $row11['startdate'];
      $startage = $row11['age'];
      $startfemale = $startfemale + $row11['femaleopening']+$row11['classicopening'];
     
  }
}

$query1 = "SELECT * FROM breeder_consumption WHERE flock like '%$flockget' and date2 < '$prodate' and  client='$client' group by date2,flock";
$result1 = mysql_query($query1,$conn1); 
while($row11 = mysql_fetch_assoc($result1))
{
  $startfemale = $startfemale - ($row11['fmort'] + $row11['fcull']);
  //$startmale = $startmale - ($row11['mmort'] + $row11['mcull']);
}
$femalet = 0;//$malet=0;

 //$query1t = "SELECT cat,quantity FROM `ims_stocktransfer` WHERE cat IN ('Female Birds', 'Male Birds') AND client = '$client' AND towarehouse like '$flockget' AND date<='$mincmpdate'";
//$query1t = "SELECT cat,quantity FROM `ims_stocktransfer` WHERE cat IN ('Female Birds', 'Male Birds') AND client = '$client' AND towarehouse like '$flockget' AND date<'$prodate'";
$query1t = "SELECT cat,quantity FROM `ims_stocktransfer` WHERE cat = 'Female Birds' AND client = '$client' AND towarehouse like '%$flockget'  and fromwarehouse not like '%$flockget' AND date<'$prodate'";
  $result1t = mysql_query($query1t,$conn1); 
  while($row11t = mysql_fetch_assoc($result1t))  
  {
      /*if($row11t['cat'] == 'Female Birds')
	  {*/
	  $femalet = $femalet + $row11t['quantity'];
	  /*}
	 else
	  {
	  $malet = $malet + $row11t['quantity'];
	  }*/
  }
  
  if($femalet > 0)
  {
	 $startfemale = $startfemale +$femalet;
  }
 /*  if($malet > 0)
  {
 $startmale = $startmale + $malet;
  }*/
  $femaletout = 0;//$maletout=0;
 // $query1t = "SELECT cat,quantity FROM `ims_stocktransfer` WHERE cat IN ('Female Birds', 'Male Birds') AND client = '$client' AND fromwarehouse like '$flockget' AND date<'$prodate'";
  $query1t = "SELECT cat,quantity FROM `ims_stocktransfer` WHERE cat = 'Female Birds' AND client = '$client' AND fromwarehouse like '%$flockget'  AND towarehouse not like '%$flockget'  AND date<'$prodate'";
  $result1t = mysql_query($query1t,$conn1); 
  while($row11t = mysql_fetch_assoc($result1t))  
  {
      /*if($row11t['cat'] == 'Female Birds')
	  {*/
	  $femaletout = $femaletout + $row11t['quantity'];
	  /*}
	  else
	  {
	  $maletout = $maletout + $row11t['quantity'];
	  }*/
  }
  if($femaletout > 0)
  {
 $startfemale = $startfemale -$femaletout;
  }
   /*if($malet > 0)
  {
  $startmale = $startmale - $maletout;
  }*/
  
  $femalepur = 0;//$malepur=0;
/* $query1t = "SELECT * FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat ='Male Birds') AND client = '$client' AND flock like '$flockget' AND date<'$prodate'";
  $result1t = mysql_query($query1t,$conn); 
  while($row11t = mysql_fetch_assoc($result1t))  
  {
   
    	  $malepur = $malepur + $row11t['receivedquantity'];
	  
  }*/
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
   if($femalesale > 0)
  {
  $startfemale = $startfemale - $femalesale;
  }
 
  if($startdummage > 0)
  	{
	$startfemale = $fprodop; 
	}
  else
  {
	$startfemale = $startfemale ;
  }
  
  $flkarrn[$k] =  $flockget;
  ?>



var production<?php echo $k;?> = [
     <?php 
          include "config.php"; $w = 0;$female=0;$age=0;
		  
$tothe =0;	
 $query121 = "SELECT * from breeder_initial WHERE flock like '%$flockget' and age < '$prodagewk'  order by age";
$result121 = mysql_query($query12,$conn1); 
while($row121 = mysql_fetch_assoc($result12))
{ 
$totprod = 0;

 $agewk = $row121['age'];
  $prod = $row121['eggs'];
  $cat = explode(",",$prod);
  $eggcnt = count($cat) - 1;
  
	 $tothe = $tothe +$row121["classic"]+$row121["female"];
	

  //echo "stfemale  ".$startfemale;
  
  $w = ($tothe / $startfemale);
                    
      ?>
                     [<?php echo $agewk; ?>,<?php echo $w; ?>],                             
      <?php 
	  }
           /*$querya = "SELECT * FROM breeder_flock where flockcode = '$flockget' and  client='$client'";
           $resulta = mysql_query($querya,$conn1); 
           while($row1a = mysql_fetch_assoc($resulta))
           {
             $age = $row1a['age']; 
             $date = $row1a['startdate'];
             $female = $row1a['femaleopening'];
           }


           $nrSeconds = $age * 24 * 60 * 60;
           $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
           $nrWeeksPassed = floor($nrSeconds / 604800); 
           $startage = $nrWeeksPassed;*/
 
          $query12 = "SELECT * FROM breeder_consumption where flock like '%$flockget' and client='$client' GROUP BY date2 ";
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
		   
              /*$age = $age + 1; 
              $nrSeconds = $age * 24 * 60 * 60;
              $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
              $nrWeeksPassed = floor($nrSeconds / 604800); */
              if ($nrDaysPassed == 0)
              {
                 $odate = $row12['date2'];   
              }
              if ($nrDaysPassed == 7)
              {

                /* include "config.php"; 
                 $querya = "SELECT sum(fmort) as `fmort`,sum(fcull) as `fcull` FROM breeder_consumption where flock = '$flockget' and date2 <= '$odate' ORDER BY date2 DESC ";
                 $resulta = mysql_query($querya,$conn1); 
                 while($row1a = mysql_fetch_assoc($resulta))
                 {
                   $mort = $row1a['fmort'] + $row1a['fcull'];
                 }

                  $femaleminus = gettransferfemalefrom($flockget,$odate);
                  $femaleplus = gettransferfemaleto($flockget,$odate);
                  $femalesale = getsalebirdsfemale($flockget,$odate); 

 
                  $getremainingfemale = $female + ($femaleplus - $femaleminus) - ($femalesale + $mort);*/

                 

              $query12a = "SELECT sum(quantity) as 'totaleggs' FROM breeder_production where flock like '%$flockget'  and date1 <= '$row12[date2]' and client='$client' and itemcode in ($eggtype) ";
                  $result12a = mysql_query($query12a,$conn1); 
                  while($row12a = mysql_fetch_assoc($result12a))
                  {
                     $oldw = $w; 
                     //$totaleggs = $row12a['totaleggs'] / 7; 
					 /*echo "initial eggs". $tothe;
					 echo "now eggs ".$row12a['totaleggs'];
					 echo "stfemale ".$startfemale;*/
					 $totaleggs = $tothe + $row12a['totaleggs']; 
                     $w = ($totaleggs / $startfemale);
                     if($w == 0) { $w = $oldw; }
      ?>
                     [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>],                             
      <?php 
                  }                    
              }  
           } 

     ?>
 [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>]];

<?php 
$k = $k +1;
} }?>

var hdstandard = [
     <?php $avgweight = 0;
       include "config.php";
       $query1 = "SELECT * FROM breeder_standards where client='$client' ORDER BY age ASC ";
       $result1 = mysql_query($query1,$conn1);
       while($row1 = mysql_fetch_assoc($result1))
       {
         $age = $row1['age'];
         $oldavg = $avgweight;
         $avgweight = $row1['cumhhe'];
         if($avgweight == 0) { $avgweight = $oldavg; }
     ?>
       [<?php echo $age; ?>,<?php echo $avgweight; ?>],
     <?php  } ?>
     [<?php echo $age; ?>,<?php echo $avgweight; ?>]];


<!-- , dashes: { show: true }, hoverable: true  -->




            var plot =   $.plot($("#placeholder"),
           [ { data: hdstandard, label: "Hatch Egg/Bird  Standard", color:'#FF0000' },
		   <?php  for ($z=0;$z<$k;$z++)
		   {
		     if($z == $k-1){
		    ?>
             { data: production<?php echo $z;?>, label: "<?php echo "Flock ".$flkarrn[$z];?>",  color:'<?php echo $clorarr[$z];?>'  }
			 <?php } else { ?>
			 { data: production<?php echo $z;?>, label: "<?php echo "Flock ".$flkarrn[$z];?>", color:'<?php echo $clorarr[$z];?>'  },
			 <?php } }?>
			 
			 ],
           { 
             grid: { hoverable: true, clickable: true },
             xaxis: { min: 0,
                      tickSize: 4,
					  label: "test"
                    },
             yaxis: { min: 0, tickSize: 10, max:350 },
             y2axis: { min : 40, tickSize: 10, max:210 },
             legend: { margin: [660,80] } 
    });

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
        $("#y").text(pos.y.toFixed(2));

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



</script>

 </body>
</html>

