<?php
$c = $_GET['flock']; 
session_start();
$db = $_SESSION['db'];


function gettransferfemalefrom($a,$b)
{
           include "config.php";
             $q = "select * from ims_stocktransfer where cat = 'Layer Birds' and fromwarehouse = '$a' and date <= '$b'"; 
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
             $q = "select * from ims_stocktransfer where cat = 'Layer Birds' and towarehouse = '$a' and date <= '$b'"; 
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
           $query12 = "SELECT sum(num) as `num` FROM sales where flock = '$a' and type='Layer Birds' and date <= '$b' ORDER BY date DESC ";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
              //return $row12['num'];    
              return 0;  
           }
}
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
    <body onload="change('all');" >
      <center>
    <table border="0">
     <tr>
       <td colspan="3">
         Production For Flock <?php echo $c; ?>
       </td>
     </tr>
     <tr>
      <td colspan="3">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" id="all" value="all" checked="true" onclick="change(this.value);" /> All
&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" id="mortality" value="mortality" onclick="change(this.value);" /> Mortality
&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" id="eggweight" value="eggweight" onclick="change(this.value);" /> Egg Weight
&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" id="feed" value="feed" onclick="change(this.value);" /> Feed Consumed
&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" id="production" value="production" onclick="change(this.value);" /> Production
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
  document.getElementById("mortality").checked = false;
  document.getElementById("eggweight").checked = false;
  document.getElementById("feed").checked = false;
  document.getElementById("production").checked = false;
 }
 else if(ab == "mortality")
 {
  document.getElementById("all").checked = false;
  document.getElementById("eggweight").checked = false;
  document.getElementById("feed").checked = false;
  document.getElementById("production").checked = false;
 }
 else if(ab == "eggweight")
 {
  document.getElementById("all").checked = false;
  document.getElementById("mortality").checked = false;
  document.getElementById("feed").checked = false;
  document.getElementById("production").checked = false;
 }
 else if(ab == "feed")
 {
  document.getElementById("all").checked = false;
  document.getElementById("eggweight").checked = false;
  document.getElementById("mortality").checked = false;
  document.getElementById("production").checked = false;
 }
 else if(ab == "production")
 {
  document.getElementById("all").checked = false;
  document.getElementById("eggweight").checked = false;
  document.getElementById("feed").checked = false;
  document.getElementById("mortality").checked = false;
 }

$(function () {


var mortality = [
     <?php 
           include "config.php"; $w = 0;
           $querya = "SELECT * FROM layer_flock where flockcode = '$c'";
           $resulta = mysql_query($querya,$conn1); 
           while($row1a = mysql_fetch_assoc($resulta))
           {
             $age = $row1a['age']; 
             $date = $row1a['startdate'];
             $birds = $row1a['femaleopening'];
           }


           $nrSeconds = $age * 24 * 60 * 60;
           $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
           $nrWeeksPassed = floor($nrSeconds / 604800); 
           $minage = $nrWeeksPassed;
           $startage = $nrWeeksPassed;
 
           $query12 = "SELECT date2,age FROM layer_consumption where flock = '$c' GROUP BY date2,age ";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
              //$age = $age + 1; 
              $nrSeconds = $row12[age] * 24 * 60 * 60;
              $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
              $nrWeeksPassed = floor($nrSeconds / 604800); 

              if ($nrDaysPassed == 0)
              {
                  $query12a = "SELECT sum(fmort) as `fmort`,sum(mmort) as `mmort` FROM layer_consumption where flock = '$c' and date2 <= '$row12[date2]' ";
                  $result12a = mysql_query($query12a,$conn1); 
                  while($row12a = mysql_fetch_assoc($result12a))
                  {
                     $oldw = $w; 
                     $w1 = $row12a['fmort'] + $row12a['mmort'];
                     $w = ( $w1 / $birds ) * 100;
                     if($w == 0) { $w = $oldw; }
      ?>
                     [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>],                             
      <?php 
                  }                    
              }  
           } 

     ?>
 [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>]];



var feed = [
     <?php 
           include "config.php"; $w = 0;
           $querya = "SELECT * FROM layer_flock where flockcode = '$c'";
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
           $startage = $nrWeeksPassed;
 
                  $feedtype = "'dummy'";
                  $q = "select * from ims_itemcodes where cat = 'Layer Feed'"; 
      		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		      while($qr = mysql_fetch_assoc($qrs))
		      {
                     $feedtype = $feedtype . ",'" . $qr['code'] . "'";
                  } 

           $query12 = "SELECT date2,age FROM layer_consumption where flock = '$c' GROUP BY date2,age ";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
              //$age = $age + 1; 
              $nrSeconds = $row12[age] * 24 * 60 * 60;
              $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
              $nrWeeksPassed = floor($nrSeconds / 604800); 
              /* if ($nrDaysPassed == 0)
              {
                 $odate = $row12['date2'];   
              }*/
              if ($nrDaysPassed == 0)
              {

                 include "config.php"; 
                 $querya = "SELECT sum(fmort) as `fmort`,sum(fcull) as `fcull` FROM layer_consumption where flock = '$c' and date2 <= '$odate' ORDER BY date2 DESC ";
                 $resulta = mysql_query($querya,$conn1); 
                 while($row1a = mysql_fetch_assoc($resulta))
                 {
                   $mort = $row1a['fmort'] + $row1a['fcull'];
                 }

                  $femaleminus = gettransferfemalefrom($c,$odate);
                  $femaleplus = gettransferfemaleto($c,$odate);
                  $femalesale = getsalebirdsfemale($c,$odate); 

 
                  $getremainingfemale = $female + ($femaleplus - $femaleminus) - ($femalesale + $mort);


                  $query12a = "SELECT sum(quantity) as `fm` FROM layer_consumption where flock = '$c' and date2 > '$odate' and date2 <= '$row12[date2]' and itemcode in ($feedtype)";
                  $result12a = mysql_query($query12a,$conn1); 
                  while($row12a = mysql_fetch_assoc($result12a))
                  {
                     $oldw = $w; 
                     $w = (($row12a['fm']/7) / $getremainingfemale) * 1000;

                     if($w == 0) { $w = $oldw; }
      ?>
                     [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>],                             
      <?php 
                  }                    
              }
				$odate = $row12['date2'];
           } 

     ?>
 [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>]];


var ew = [
     <?php 
           include "config.php"; $w = 0;
           $querya = "SELECT * FROM layer_flock where flockcode = '$c'";
           $resulta = mysql_query($querya,$conn1); 
           while($row1a = mysql_fetch_assoc($resulta))
           {
             $age = $row1a['age']; 
             $date = $row1a['startdate'];
             $birds = $row1a['femaleopening'];
           }

           $nrSeconds = $age * 24 * 60 * 60;
           $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
           $nrWeeksPassed = floor($nrSeconds / 604800); 
           $startage = $nrWeeksPassed;
 
           $query12 = "SELECT date2,age FROM layer_consumption where flock = '$c' GROUP BY date2,age ";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
              //$age = $age + 1; 
              $nrSeconds = $row12['age'] * 24 * 60 * 60;
              $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
              $nrWeeksPassed = floor($nrSeconds / 604800); 
              /*if ($nrDaysPassed == 0)
              {
                 $odate = $row12['date'];   
              }*/
              if ($nrDaysPassed == 0)
              {
                  $query12a = "SELECT max(eggwt) as `ew` FROM layer_consumption where flock = '$c' and date2 > '$odate' and date2 <= '$row12[date2]' ";
                  $result12a = mysql_query($query12a,$conn1); 
                  while($row12a = mysql_fetch_assoc($result12a))
                  {
                     $oldw = $w; 
                     $w = $row12a['ew'];
                     if($w == 0) { $w = $oldw; }
      ?>
                     [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>],                             
      <?php 
                  }                    
              } 
				$odate = $row12['date2'];
           } 

     ?>
 [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>]];


var production = [
     <?php 
           include "config.php"; $w = 0;
           $querya = "SELECT * FROM layer_flock where flockcode = '$c'";
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
           $startage = $nrWeeksPassed;
 
           $query12 = "SELECT date2,age FROM layer_consumption where flock = '$c' GROUP BY date2,age ";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
              //$age = $age + 1; 
              $nrSeconds = $row12['age'] * 24 * 60 * 60;
              $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
              $nrWeeksPassed = floor($nrSeconds / 604800); 
              /*if ($nrDaysPassed == 0)
              {
                 $odate = $row12['date2'];   
              }*/
              if ($nrDaysPassed == 0)
              {

                 include "config.php"; 
                 $querya = "SELECT sum(fmort) as `fmort`,sum(fcull) as `fcull` FROM layer_consumption where flock = '$c' and date2 <= '$odate' ORDER BY date2 DESC ";
                 $resulta = mysql_query($querya,$conn1); 
                 while($row1a = mysql_fetch_assoc($resulta))
                 {
                   $mort = $row1a['fmort'] + $row1a['fcull'];
                 }

                  $femaleminus = gettransferfemalefrom($c,$odate);
                  $femaleplus = gettransferfemaleto($c,$odate);
                  $femalesale = getsalebirdsfemale($c,$odate); 

 
                  $getremainingfemale = $female + ($femaleplus - $femaleminus) - ($femalesale + $mort);

                  $eggtype = "'dummy'";
                  $q = "select * from ims_itemcodes where cat = 'Eggs'"; 
      		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		      while($qr = mysql_fetch_assoc($qrs))
		      {
                     $eggtype = $eggtype . ",'" . $qr['code'] . "'";
                  } 

                  $query12a = "SELECT sum(quantity) as 'totaleggs' FROM layer_production where flock = '$c' and date1 > '$odate' and date1 <= '$row12[date2]' and itemcode in ($eggtype) ";
                  $result12a = mysql_query($query12a,$conn1); 
                  while($row12a = mysql_fetch_assoc($result12a))
                  {
                     $oldw = $w; 
                     $totaleggs = $row12a['totaleggs'] / 7; 
                     $w = ($totaleggs / $getremainingfemale) * 100;
                     if($w == 0) { $w = $oldw; }
      ?>
                     [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>],                             
      <?php 
                  }                    
              } 
				$odate = $row12['date2'];
           } 

     ?>
 [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>]];




var ewstandard = [
     <?php $avgweight = 0;
       include "config.php";
       $query1 = "SELECT * FROM layer_standards ORDER BY age ASC ";
       $result1 = mysql_query($query1,$conn1);
       while($row1 = mysql_fetch_assoc($result1))
       {
         $age = $row1['age'];
         $oldavg = $avgweight;
         $avgweight = $row1['eggwt'];
         if($avgweight == 0) { $avgweight = $oldavg; }
     ?>
       [<?php echo $age; ?>,<?php echo $avgweight; ?>],
     <?php  } ?>
     [<?php echo $age; ?>,<?php echo $avgweight; ?>]];


var hdstandard = [
     <?php $avgweight = 0;
       include "config.php";
       $query1 = "SELECT * FROM layer_standards ORDER BY age ASC ";
       $result1 = mysql_query($query1,$conn1);
       while($row1 = mysql_fetch_assoc($result1))
       {
         $age = $row1['age'];
         $oldavg = $avgweight;
         $avgweight = $row1['hdp'];
         if($avgweight == 0) { $avgweight = $oldavg; }
     ?>
       [<?php echo $age; ?>,<?php echo $avgweight; ?>],
     <?php  } ?>
     [<?php echo $age; ?>,<?php echo $avgweight; ?>]];

var fm = [
     <?php $avgweight = 0;
       include "config.php";
       $query1 = "SELECT * FROM layer_standards ORDER BY age ASC ";
       $result1 = mysql_query($query1,$conn1);
       while($row1 = mysql_fetch_assoc($result1))
       {
         $age = $row1['age'];
         $oldavg = $avgweight;
         $avgweight = $row1['feedperday'];
         if($avgweight == 0) { $avgweight = $oldavg; }
     ?>
       [<?php echo $age; ?>,<?php echo $avgweight; ?>],
     <?php  } ?>
     [<?php echo $age; ?>,<?php echo $avgweight; ?>]];

var mstandard = [
     <?php $avgweight = 0;
       include "config.php";
       $query1 = "SELECT * FROM layer_standards ORDER BY age ASC ";
       $result1 = mysql_query($query1,$conn1);
       while($row1 = mysql_fetch_assoc($result1))
       {
         $age = $row1['age'];
         $oldavg = $avgweight;
         $avgweight = $row1['mortalityper'];
         if($avgweight == 0) { $avgweight = $oldavg; }
     ?>
       [<?php echo $age; ?>,<?php echo $avgweight; ?>],
     <?php  } ?>
     [<?php echo $age; ?>,<?php echo $avgweight; ?>]];
<!-- , dashes: { show: true }, hoverable: true  -->

if(document.getElementById("all").checked)
{

  var plot =   $.plot($("#placeholder"),
           [ { data: mstandard, label: "Mortality Standard", color:'#006600' },
             { data: ewstandard, label: "Egg Weight Standard", color:'#CC0000',yaxis: 2 },
             { data: fm, label: "Feed Consumed Standard", color:'#000099',yaxis: 2 },
             { data: hdstandard, label: "Production Standard", color:'#FFFF00' },
             { data: mortality, label: "Mortality Actual", color:'#00FF00' },    
             { data: ew, label: "Egg Weight Actual", color:'#FF9999',yaxis: 2 },
             { data: feed, label: "Feed Consumed Actual", color:'#9999FF', yaxis: 2 },
             { data: production, label: "Production Actual", color:'#FFFFAA' }],
           { 
             grid: { hoverable: true, clickable: true },
             xaxis: { min: <?php echo $minage; ?>,
                      tickSize: 2,
					  label: "test"
                    },
             yaxis: { min: 0, tickSize: 10, max:100 },
             y2axis: { min : 40, tickSize: 10, max:120 },
             legend: { margin: [660,280] } 
    });
}
else
{

 if(document.getElementById("mortality").checked)
 {
            var plot =   $.plot($("#placeholder"),
           [ { data: mstandard, label: "Mortality Standard", color:'#006600' },
             { data: mortality, label: "Mortality Actual", color:'#00FF00' }],
           { 
             grid: { hoverable: true, clickable: true },
             xaxis: { min: 0,
                      tickSize: 2,
					  label: "test"
                    },
             yaxis: { min: 0, tickSize: 10, max:100 },
             y2axis: { min : 40, tickSize: 10, max:140 },
             legend: { margin: [660,280] } 
    });
 }

 if(document.getElementById("eggweight").checked)
 {
            var plot =   $.plot($("#placeholder"),
           [ { data: ewstandard, label: "Egg Weight Standard", color:'#CC0000',yaxis: 2 },
             { data: ew, label: "Egg Weight Actual", color:'#FF9999',yaxis: 2 }],
           { 
             grid: { hoverable: true, clickable: true },
             xaxis: { min: 0,
                      tickSize: 2,
					  label: "test"
                    },
             yaxis: { min: 0, tickSize: 10, max:100 },
             y2axis: { min : 40, tickSize: 10, max:140 },
             legend: { margin: [660,280] } 
    });
 }

 if(document.getElementById("feed").checked)
 {
            var plot =   $.plot($("#placeholder"),
           [ { data: fm, label: "Feed Consumed Standard", color:'#000099',yaxis: 2 },
             { data: feed, label: "Feed Consumed Actual", color:'#9999FF', yaxis: 2 }],
           { 
             grid: { hoverable: true, clickable: true },
             xaxis: { min: 0,
                      tickSize: 2,
					  label: "test"
                    },
             yaxis: { min: 0, tickSize: 10, max:100 },
             y2axis: { min : 40, tickSize: 10, max:140 },
             legend: { margin: [660,280] } 
    });
 }

 if(document.getElementById("production").checked)
 {
            var plot =   $.plot($("#placeholder"),
           [ { data: hdstandard, label: "Production Standard", color:'#FFFF00' },
             { data: production, label: "Production Actual", color:'#FFFFAA' }],
           { 
             grid: { hoverable: true, clickable: true },
             xaxis: { min: 0,
                      tickSize: 2,
					  label: "test"
                    },
             yaxis: { min: 0, tickSize: 10, max:100 },
             y2axis: { min : 40, tickSize: 10, max:140 },
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



}
</script>
 </body>
</html>

