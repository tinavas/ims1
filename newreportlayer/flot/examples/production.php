<?php
$c = $_GET['flock']; 
session_start();
$db = $_SESSION['db'];


function gettransferfemalefrom($a,$b)
{
           include "config.php";
             $q = "select * from ims_stocktransfer where cat like '%Male Birds%' and fromwarehouse = '$a' and date <= '$b'"; 
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
             $q = "select * from ims_stocktransfer where cat like '%Male Birds%' and towarehouse = '$a' and date <= '$b'"; 
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
           $query12 = "SELECT * from ims_itemcodes where cat like '%Male Birds%'";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
               $birdscodes =  $birdscodes . ",'" .$row12['code'] . "'";                
           }

           $query12 = "SELECT sum(quantity) as `num` FROM oc_cobi where flock='$a' and date <= '$b' and flag = 1 and code in ($birdscodes) ORDER BY date DESC ";
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
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
           $querya = "SELECT * FROM breeder_flock where flockcode = '$c'";
           $resulta = mysql_query($querya,$conn1); 
           while($row1a = mysql_fetch_assoc($resulta))
           {
             $age = $row1a['age'];  $age1 = $age;
             $date = $row1a['startdate'];
             $birds = $row1a['femaleopening'] + $row1a['maleopening'];
           }

           $query12 = "SELECT * FROM breeder_consumption where flock = '$c' GROUP BY date2 ";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
              $age1 = $age1 + 1; 
              $nrSeconds1 = $age1 * 24 * 60 * 60;
              $nrDaysPassed1 = floor($nrSeconds1 / 86400) % 7; 
              $maxage = floor($nrSeconds1 / 604800); 
           }

           $nrSeconds = $age * 24 * 60 * 60;
           $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
           $nrWeeksPassed = floor($nrSeconds / 604800); 
           $minage = $nrWeeksPassed;
           $startage = $nrWeeksPassed;
 
           $query12 = "SELECT * FROM breeder_consumption where flock = '$c' GROUP BY date2 ";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
              $age = $age + 1; 
              $nrSeconds = $age * 24 * 60 * 60;
              $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
              $nrWeeksPassed = floor($nrSeconds / 604800); 

              if ($nrDaysPassed == 6)
              {
                  $w1 = 0;
                  $query12a = "SELECT distinct(date2),mmort,fmort FROM breeder_consumption where flock = '$c' and date2 <= '$row12[date2]' ";
                  $result12a = mysql_query($query12a,$conn1); 
                  while($row12a = mysql_fetch_assoc($result12a))
                  {
                     $oldw = $w; 
                     $w1 = $w1 + $row12a['fmort'] + $row12a['mmort'];
                  }
                     $w = ( $w1 / $birds ) * 100;
                     if($w == 0) { $w = $oldw; }
      ?>
                     [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>],                             
      <?php 
                                      
              }  
           } 

     ?>
 [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>]];



var feed = [
     <?php 
           include "config.php"; $w = 0;
           $querya = "SELECT * FROM breeder_flock where flockcode = '$c'";
           $resulta = mysql_query($querya,$conn1); 
           while($row1a = mysql_fetch_assoc($resulta))
           {
             $age = $row1a['age']; 
             $date = $row1a['startdate'];
             $female = $row1a['femaleopening'] + $row1a['maleopening'];
           }

           $nrSeconds = $age * 24 * 60 * 60;
           $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
           $nrWeeksPassed = floor($nrSeconds / 604800); 
           $startage = $nrWeeksPassed;
 
                  $feedtype = "'dummy'";
                  $q = "select * from ims_itemcodes where cat like '%Male Feed%'"; 
      		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		      while($qr = mysql_fetch_assoc($qrs))
		      {
                     $feedtype = $feedtype . ",'" . $qr['code'] . "'";
                  } 

           $query12 = "SELECT * FROM breeder_consumption where flock = '$c' GROUP BY date2 ";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
              $age = $age + 1; 
              $nrSeconds = $age * 24 * 60 * 60;
              $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
              $nrWeeksPassed = floor($nrSeconds / 604800); 
              if ($nrDaysPassed == 0)
              {
                 $odate = $row12['date2'];   
              }
              if ($nrDaysPassed == 6)
              {

                 include "config.php"; 
                  $mort = 0;
                  $querya = "SELECT distinct(date2),mmort,fmort,fcull,mcull FROM breeder_consumption where flock = '$c' and date2 <= '$odate' ";
                  $resulta = mysql_query($querya,$conn1); 
                  while($row1a = mysql_fetch_assoc($resulta))
                  {
                     $mort = $mort + $row1a['fmort'] + $row1a['mmort'] + $row1a['fcull'] + $row1a['mcull'];
                  }


                  $femaleminus = gettransferfemalefrom($c,$odate);
                  $femaleplus = gettransferfemaleto($c,$odate);
                  $femalesale = getsalebirdsfemale($c,$odate); 

 
                  $getremainingfemale = $female + ($femaleplus - $femaleminus) - ($femalesale + $mort);


                  $query12a = "SELECT sum(quantity) as `fm` FROM breeder_consumption where flock = '$c' and date2 >= '$odate' and date2 <= '$row12[date2]' and itemcode in ($feedtype)";
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
           } 

     ?>
 [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>]];


var ew = [
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

           $nrSeconds = $age * 24 * 60 * 60;
           $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
           $nrWeeksPassed = floor($nrSeconds / 604800); 
           $startage = $nrWeeksPassed;
 
           $query12 = "SELECT * FROM breeder_consumption where flock = '$c' GROUP BY date2 ";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
              $age = $age + 1; 
              $nrSeconds = $age * 24 * 60 * 60;
              $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
              $nrWeeksPassed = floor($nrSeconds / 604800); 
              if ($nrDaysPassed == 0)
              {
                 $odate = $row12['date'];   
              }
              if ($nrDaysPassed == 6)
              {
                  $query12ab = "SELECT max(eggwt) as `ew` FROM breeder_consumption where flock = '$c' and date2 <= '$row12[date2]' ";
                  $result12ab = mysql_query($query12ab,$conn1); 
                  while($row12ab = mysql_fetch_assoc($result12ab))
                  {
                     $oldw = $w; 
                     $w = $row12ab['ew'];
                     if($w == 0) { $w = $oldw; }
      ?>
                     [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>],                             
      <?php 
                  }                    
              }  
           } 

     ?>
 [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>]];


var production = [
     <?php 
           include "config.php"; $w = 0;
           $querya = "SELECT * FROM breeder_flock where flockcode = '$c'";
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
 
           $query12 = "SELECT * FROM breeder_consumption where flock = '$c' GROUP BY date2 ";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
              $age = $age + 1; 
              $nrSeconds = $age * 24 * 60 * 60;
              $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
              $nrWeeksPassed = floor($nrSeconds / 604800); 
              if ($nrDaysPassed == 0)
              {
                 $odate = $row12['date2'];   
              }
              if ($nrDaysPassed == 6)
              {

                 include "config.php"; 
                  $mort = 0;
                  $querya = "SELECT distinct(date2),fmort,fcull FROM breeder_consumption where flock = '$c' and date2 <= '$odate' ";
                  $resulta = mysql_query($querya,$conn1); 
                  while($row1a = mysql_fetch_assoc($resulta))
                  {
                     $mort = $mort + $row1a['fmort'] + $row1a['fcull'];
                  }

                  $femaleminus = gettransferfemalefrom($c,$odate);
                  $femaleplus = gettransferfemaleto($c,$odate);
                  $femalesale = getsalebirdsfemale($c,$odate); 

 
                  $getremainingfemale = $female + ($femaleplus - $femaleminus) - ($femalesale + $mort);

                  $eggtype = "'dummy'";
                  $q = "select * from ims_itemcodes where cat like '%Eggs%'"; 
      		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		      while($qr = mysql_fetch_assoc($qrs))
		      {
                     $eggtype = $eggtype . ",'" . $qr['code'] . "'";
                  } 

                  $query12a = "SELECT sum(quantity) as 'totaleggs' FROM breeder_production where flock = '$c' and date1 >= '$odate' and date1 <= '$row12[date2]' and itemcode in ($eggtype) ";
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
           } 

     ?>
 [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>]];




var ewstandard = [
     <?php $avgweight = 0;
       include "config.php";
       $query1 = "SELECT * FROM tbl_allstandards ORDER BY age ASC ";
       $result1 = mysql_query($query1,$conn1);
       while($row1 = mysql_fetch_assoc($result1))
       {
         $age = $row1['age'];
         $oldavg = $avgweight;
         $avgweight = $row1['eggweight'];
         if($avgweight == 0) { $avgweight = $oldavg; }
     ?>
       [<?php echo $age; ?>,<?php echo $avgweight; ?>],
     <?php  } ?>
     [<?php echo $age; ?>,<?php echo $avgweight; ?>]];


var hdstandard = [
     <?php $avgweight = 0;
       include "config.php";
       $query1 = "SELECT * FROM tbl_allstandards ORDER BY age ASC ";
       $result1 = mysql_query($query1,$conn1);
       while($row1 = mysql_fetch_assoc($result1))
       {
         $age = $row1['age'];
         $oldavg = $avgweight;
         $avgweight = $row1['hdper'];
         if($avgweight == 0) { $avgweight = $oldavg; }
     ?>
       [<?php echo $age; ?>,<?php echo $avgweight; ?>],
     <?php  } ?>
     [<?php echo $age; ?>,<?php echo $avgweight; ?>]];

var fm = [
     <?php $avgweight = 0;
       include "config.php";
       $query1 = "SELECT * FROM tbl_allstandards ORDER BY age ASC ";
       $result1 = mysql_query($query1,$conn1);
       while($row1 = mysql_fetch_assoc($result1))
       {
         $age = $row1['age'];
         $oldavg = $avgweight;
         $avgweight = $row1['fm'];
         if($avgweight == 0) { $avgweight = $oldavg; }
     ?>
       [<?php echo $age; ?>,<?php echo $avgweight; ?>],
     <?php  } ?>
     [<?php echo $age; ?>,<?php echo $avgweight; ?>]];

var mstandard = [
     <?php $avgweight = 0;
       include "config.php";
       $query1 = "SELECT * FROM tbl_allstandards ORDER BY age ASC ";
       $result1 = mysql_query($query1,$conn1);
       while($row1 = mysql_fetch_assoc($result1))
       {
         $age = $row1['age'];
         $oldavg = $avgweight;
         $avgweight = $row1['stdmortality'];
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
             xaxis: { min: <?php echo $minage; ?>,max: <?php echo $maxage; ?>,
                      tickSize: 2,
					  label: "test"
                    },
             yaxis: { min: 0, tickSize: 10, max:100 },
             y2axis: { min : 40, tickSize: 10, max:210 },
             legend: { margin: [660,320] } 
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
             xaxis: { min: <?php echo $minage; ?>,max: <?php echo $maxage; ?>,
                      tickSize: 2,
					  label: "test"
                    },
             yaxis: { min: 0, tickSize: 10, max:100 },
             y2axis: { min : 40, tickSize: 10, max:210 },
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
             xaxis: { min: <?php echo $minage; ?>,max: <?php echo $maxage; ?>,
                      tickSize: 2,
					  label: "test"
                    },
             yaxis: { min: 0, tickSize: 10, max:100 },
             y2axis: { min : 40, tickSize: 10, max:210 },
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
             xaxis: { min: <?php echo $minage; ?>,max: <?php echo $maxage; ?>,
                      tickSize: 2,
					  label: "test"
                    },
             yaxis: { min: 0, tickSize: 10, max:100 },
             y2axis: { min : 40, tickSize: 10, max:210 },
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
             xaxis: { min: <?php echo $minage; ?>,max: <?php echo $maxage; ?>,
                      tickSize: 2,
					  label: "test"
                    },
             yaxis: { min: 0, tickSize: 10, max:100 },
             y2axis: { min : 40, tickSize: 10, max:210 },
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
       if(document.getElementById("eggweight").checked || document.getElementById("feed").checked)
        $("#y2").text(pos.y2.toFixed(2));
       else
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

