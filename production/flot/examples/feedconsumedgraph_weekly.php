<?php
$c = $flockget = $_GET['flock']; 
$unit = $_GET['unit']; 
session_start();
$db = $_SESSION['db'];


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
var feed = [
        <?php 
           include "config.php"; $w = 0;$wi = 0;
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
            
              $nrSeconds = $row12[age] * 24 * 60 * 60;
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
					 //echo $row12a['fm']."/".$inc."/".$getremainingfemale;
					 $w = (($row12a['fm']/($inc * 7)) / $getremainingfemale) * 1000;
					 $feedar[$wi] = $w;$wi++;

                     if($w == 0) { $w = $oldw; }
      ?>
                     [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>],                             
      <?php 
	 
                  }                    
              } 
			  $age = $age +1; 
			  $odate = $row12['date2'];
           } 

     ?>
 [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>]];
 
 
 
 var feedmale = [
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
                  $q = "select * from ims_itemcodes where cat like 'Male Feed'"; 
      		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		      while($qr = mysql_fetch_assoc($qrs))
		      {
                     $feedtype = $feedtype . ",'" . $qr['code'] . "'";
                  } 
			
           $query12 = "SELECT * FROM breeder_consumption where flock = '$c' GROUP BY date2 ";
           $result12 = mysql_query($query12,$conn1); 
           while($row12 = mysql_fetch_assoc($result12))
           {
            
              $nrSeconds = $row12[age] * 24 * 60 * 60;
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
					  $mort = $mort + $row1a['mmort']  + $row1a['mcull'] ;
                  }


                  $maleminus = gettransfermalefrom($c,$odate);
                  $maleplus = gettransfermaleto($c,$odate);
                  $malesale = getsalebirdsmale($c,$odate); 
				  $malepur = getpurbirdsmale($c,$odate);

 
                  //$getremainingfemale = $female + $femalepur($femaleplus - $femaleminus) - ($femalesale + $mort);
				   $getremainingmale = $male + $malepur + ($maleplus - $maleminus) - ( $mort);
                 $query12a = "SELECT sum(quantity) as `fm` FROM breeder_consumption where flock = '$c' and date2 >= '$odate' and date2 <= '$row12[date2]' and itemcode in ($feedtype)";
                  $result12a = mysql_query($query12a,$conn1); 
                  while($row12a = mysql_fetch_assoc($result12a))
                  {
				
				  $inc = 0;
				  $queryi = "SELECT distinct(date2) FROM breeder_consumption where flock = '$c' and date2 >= '$odate' and date2 <= '$row12[date2]'";
                  $resulti = mysql_query($queryi,$conn1); 
				  $inc = mysql_num_rows($resulti);
                  				  
				     $oldw = $w; 
					 $w = (($row12a['fm']/($inc * 7)) / $getremainingmale) * 1000;
					  $feedar[$wi] = $w;$wi++;

                     if($w == 0) { $w = $oldw; }
      ?>
                     [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>],                             
      <?php 
	 
                  }                    
              } 
			  $age = $age +1; 
			  $odate = $row12['date2'];
           } 

     ?>
 [<?php echo $nrWeeksPassed; ?>,<?php echo $w; ?>]];


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
	 
var m = [
     <?php $avgweight = 0;
       include "config.php";
       $query1 = "SELECT * FROM breeder_standards ORDER BY age ASC ";
       $result1 = mysql_query($query1,$conn1);
       while($row1 = mysql_fetch_assoc($result1))
       {
         $age = $row1['age'];
         $oldavg = $avgweight;
         $avgweight = $row1['mfeed'];
         if($avgweight == 0) { $avgweight = $oldavg; }
     ?>
       [<?php echo $age; ?>,<?php echo $avgweight; ?>],
     <?php  } ?>
     [<?php echo $age; ?>,<?php echo $avgweight; ?>]];


            var plot =   $.plot($("#placeholder"),
           [ { data: fm, label: "Female Feed Consumed Standard", color:'#000099',yaxis: 2 },
			 { data: m, label: "Male Feed Consumed Standard", color:'#CC33FF',yaxis: 2 },
             { data: feed, label: "Female Feed Consumed Actual", color:'#9999FF', yaxis: 2 },
			  { data: feedmale, label: "Male Feed Consumed Actual", color:'#9900FF', yaxis: 2 }],
           { 
             grid: { hoverable: true, clickable: true },
             xaxis: { min: 0,
                      tickSize: 2,
					  label: "test"
                    },
             yaxis: { min: 0, tickSize: 10, max:100 },
             y2axis: { min : <?php echo min($feedar)-10;?>, tickSize: <?php echo ceil(max($feedar) - min($feedar))/10; ?>, max:<?php echo max($feedar)+10;?> },
             legend: { margin: [660,380] } 
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
<!--<input type="text" value="<?php echo $birds; ?>" />-->

 </body>
</html>

