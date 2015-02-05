<?php
$c = $flockget = $_GET['flock']; 
$unit = $_GET['unit']; 
session_start();
$db = $_SESSION['db'];


function gettransferfemalefrom($a,$b,$unit1)
{
           include "config.php";
           $query13 = "SELECT * FROM transferflock where fromunit = '$unit1' and fromflock = '$a' and date <= '$b' ORDER BY date DESC ";
           $result13 = mysql_query($query13,$conn1);
           $r = mysql_num_rows($result13);
           if ( $r == "0") 
           {
                $fromlessfemales = "0";
           }
           else
           {      
              $fromlessfemales = "0";
              $fromlessmales = "0";
              while($row13 = mysql_fetch_assoc($result13))
              { 
                 $fromlessfemales = $fromlessfemales + $row13['females'];
              } 
           }
      return $fromlessfemales;  
}


function gettransferfemaleto($a,$b,$unit1)
{
           include "config.php";
           $query14 = "SELECT * FROM transferflock where fromunit = '$unit1' and toflock = '$a' and date <= '$b' ORDER BY date DESC ";
           $result14 = mysql_query($query14,$conn1);
           $r1 = mysql_num_rows($result14);
           if ( $r1 == "0") 
           {
                $toplusfemales = "0";
           }
           else
           {      
              $toplusfemales = "0";
              $toplusmales = "0"; 
              while($row14 = mysql_fetch_assoc($result14))
              { 
                 $toplusfemales = $toplusfemales + $row14['females'];
              } 
           }

       return  $toplusfemales;  
}

function getsalebirdsfemale($a,$b,$unit1)
{
           include "config.php";
           $query12 = "SELECT sum(num) as `num` FROM sales where unit = '$unit1' and flock = '$a' and type='Breeder Birds' and date <= '$b' ORDER BY date DESC ";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
              return $row12['num'];
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
    <body>
      <center>
    <table border="0">
     <tr>
       <td colspan="3">
         Feed Consumed For Flock <?php echo $c; ?>
       </td>
     </tr>
 
     <tr>
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

$(function () {


var mortality = [
     <?php 
           include "config.php"; $w = 0;
		   
		   $query1 = "SELECT * FROM breeder_flock WHERE flockcode = '$flockget'";
$result1 = mysql_query($query1,$conn1); 
while($row11 = mysql_fetch_assoc($result1))
{
       $startdate = $row11['startdate'];
      $startage = $row11['age'];
      $startfemale = $row11['femaleopening'];
	  $startmale = $row11['maleopening'];
      
}
$querymin = "SELECT min(date2) as 'date2' FROM breeder_consumption WHERE flock like '$flockget' ";
$resultmin = mysql_query($querymin,$conn1); 
while($row1min = mysql_fetch_assoc($resultmin))
{
$mincmpdate = $row1min['date2'];
}
 $femalet = 0;$malet=0;
 $query1t = "SELECT cat,quantity FROM `ims_stocktransfer` WHERE cat IN ('Female Birds', 'Male Birds') AND client = '$client' AND towarehouse like '$flockget' AND date<'$mincmpdate'";
  $result1t = mysql_query($query1t,$conn1); 
  while($row11t = mysql_fetch_assoc($result1t))  
  {
      if($row11t['cat'] == 'Female Birds')
	  {
	  $femalet = $femalet + $row11t['quantity'];
	  }
	  else
	  {
	  $malet = $malet + $row11t['quantity'];
	  }
  }
   if($femalet > 0)
  {
  $startfemale = $startfemale +$femalet;
  }
   if($malet > 0)
  {
  $startmale = $startmale + $malet;
  }

 $femalet = 0;$malet=0;
 $query1t = "SELECT * FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat ='Male Birds') AND client = '$client' AND flock like '$flockget' AND date<'$mincmpdate'";
  $result1t = mysql_query($query1t,$conn1); 
  while($row11t = mysql_fetch_assoc($result1t))  
  {
    	  $malet = $malet + $row11t['receivedquantity'];  
  }
  $query1t = "SELECT * FROM `pp_sobi` WHERE code in (select distinct(code) from ims_itemcodes where cat ='Female Birds') AND client = '$client' AND flock like '$flockget' AND date<'$mincmpdate'";
  $result1t = mysql_query($query1t,$conn1); 
  while($row11t = mysql_fetch_assoc($result1t))  
  { 
   	  $femalet = $femalet + $row11t['receivedquantity'];  
  }
   if($femalet > 0)
  {
  $startfemale = $startfemale +$femalet;
  }
   if($malet > 0)
  {
  $startmale = $startmale + $malet;
  }
			   
	$age = $startage;
	$date = $startdate;
	$birds = $startfemale + $startmale;  
	 
           $nrSeconds = $age * 24 * 60 * 60;
           $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
           $nrWeeksPassed = floor($nrSeconds / 604800); 
           $startage = $nrWeeksPassed;
 
           $query12 = "SELECT * FROM breeder_consumption where flock like '$flockget' GROUP BY date2 ";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
              $age = $age + 1; 
              $nrSeconds = $age * 24 * 60 * 60;
              $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
              $nrWeeksPassed = floor($nrSeconds / 604800); 

              if ($nrDaysPassed == 7)
              {
                  $query12a = "SELECT sum(fmort) as `fmort`,sum(mmort) as `mmort` FROM breeder_consumption where flock  like '$flockget' and date2 <= '$row12[date2]' ";
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
           include "config.php"; $w = 0;$wi = 0;
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
					 $feedar[$wi] = $w;$wi++;
					 
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
           $querya = "SELECT * FROM mastersheet where unit = '$unit' and flock = '$c' ORDER BY date DESC ";
           $resulta = mysql_query($querya,$conn1); 
           while($row1a = mysql_fetch_assoc($resulta))
           {
             $age = $row1a['age']; 
             $date = $row1a['date'];
           }
           $nrSeconds = $age * 24 * 60 * 60;
           $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
           $nrWeeksPassed = floor($nrSeconds / 604800); 
           $startage = $nrWeeksPassed;
 
           $query12 = "SELECT * FROM mastersheet where unit = '$unit' and flock = '$c' GROUP BY date ";
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
                  $query12a = "SELECT max(ew) as `ew` FROM mastersheet where unit = '$unit' and flock = '$c' and date >= '$odate' and date <= '$row12[date]' ";
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
           } 

     ?>
 [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>]];


var production = [
     <?php 
           include "config.php"; $w = 0;
           $querya = "SELECT * FROM mastersheet where unit = '$unit' and flock = '$c' ORDER BY date DESC ";
           $resulta = mysql_query($querya,$conn1); 
           while($row1a = mysql_fetch_assoc($resulta))
           {
             $age = $row1a['age']; 
             $date = $row1a['date'];
             $female = $row1a['female'];
           }
           $nrSeconds = $age * 24 * 60 * 60;
           $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
           $nrWeeksPassed = floor($nrSeconds / 604800); 
           $startage = $nrWeeksPassed;
 
           $query12 = "SELECT * FROM mastersheet where unit = '$unit' and flock = '$c' GROUP BY date ";
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

                 include "config.php"; 
                 $querya = "SELECT sum(fmort) as `fmort`,sum(fcull) as `fcull` FROM mastersheet where unit = '$unit' and flock = '$c' and date <= '$odate' ORDER BY date DESC ";
                 $resulta = mysql_query($querya,$conn1); 
                 while($row1a = mysql_fetch_assoc($resulta))
                 {
                   $mort = $row1a['fmort'] + $row1a['fcull'];
                 }

                  $femaleminus = gettransferfemalefrom($c,$odate);
                  $femaleplus = gettransferfemaleto($c,$odate);
                  $femalesale = getsalebirdsfemale($c,$odate); 

 
                  $getremainingfemale = $female + ($femaleplus - $femaleminus) - ($femalesale + $mort);


                  $query12a = "SELECT sum(he) as `he`, sum(te) as `te`, sum(je) as `je`, sum(we) as `we`, sum(ce) as `ce`, sum(n) as `n`, sum(f) as `f`, sum(s) as `s`, sum(me) as `me`, sum(ss) as `ss`, sum(le) as `le`, sum(p) as `p` FROM mastersheet where unit = '$unit' and flock = '$c' and date >= '$odate' and date <= '$row12[date]' ";
                  $result12a = mysql_query($query12a,$conn1); 
                  while($row12a = mysql_fetch_assoc($result12a))
                  {
                     $oldw = $w; 
                     $totaleggs = ($row12a['he'] + $row12a['te'] + $row12a['je'] + $row12a['we'] + $row12a['ce'] + $row12a['n'] + $row12a['f'] + $row12a['s'] + $row12a['me'] + $row12a['ss'] + $row12a['le'] + $row12a['p']) / 7; 
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

            var plot =   $.plot($("#placeholder"),
           [ { data: fm, label: "Feed Consumed Standard", color:'#FF0000',yaxis: 2 },
             { data: feed, label: "Feed Consumed Actual", color:'#9999FF', yaxis: 2 }],
           { 
             grid: { hoverable: true, clickable: true },
             xaxis: { min: 0,
                      tickSize: 2,
					  label: "test"
                    },
             yaxis: { min: 0, tickSize: 10, max:100 },
             y2axis: { min : <?php echo min($feedar)-10;?>, tickSize: <?php echo ceil(max($feedar) - min($feedar))/10; ?>, max:<?php echo max($feedar)+10;?> },
             legend: { margin: [660,280] } 
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
        $("#y2").text(pos.y2.toFixed(2));

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
<input type="text" value="<?php echo $birds; ?>" />

 </body>
</html>

