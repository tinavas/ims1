<?php
ini_set('display_errors', 0);
ini_set('log_errors', 0);
ini_set('error_reporting', E_ALL);

$placeid = $_GET['placeid'];
$supervisor = $_GET['supervisor'];
$farmer = $_GET['farmer'];
$flock = $_GET['flock'];
include "config.php";
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
	

 </head>
    <body>
			<center>
    <table border="0">
     <tr>
      <td colspan="3">Mortality% & Body Weight Report For Farmer <?php echo $farmer; ?> & Flock <?php echo $flock; ?></td>
     </tr> 
     <tr>
      <td>
       <span style="filter:flipv fliph;writing-mode:tb-rl;"><span style="">Mortality% &amp; Average Weight</span></span>
      </td>
      <td width="5px"></td>
      <td>
        <div id="placeholder" style="width:900px;height:500px;"></div>
      </td>
     </tr>
     <tr>
      <td colspan="3">Age (Weeks)</td>
     </tr> 
   </table>
    </center>
    <div id="placeholder" style="width:900px;height:500px;"></div>
<script id="source" language="javascript" type="text/javascript">
$(function () {


var currentweight = [
     <?php include "config.php";
	                  $i = 1;
		              $j = $i + 7;
	                  $queryn = "SELECT * FROM broiler_daily_entry WHERE place = '$placeid' AND farm = '$farmer' AND supervisior = '$supervisor' AND flock='$flock' ORDER BY entrydate ASC ";
	                  $resultn = mysql_query($queryn,$conn1);
                      $numn = mysql_num_rows($resultn);

	   
	                $query5 = "SELECT SUM(chicks) as chicks FROM transferchicks WHERE farmer = '$farmer' AND newflock = '$flock' ORDER BY farmer ASC ";
	                $result5 = mysql_query($query5,$conn1);
	                 while($row5 = mysql_fetch_assoc($result5))
	                  {
	                    $b = $row5['chicks'];
	                   }
	   
	                $num1 = round(($numn/7),0);
		            $num2 = ($numn % 7);
		            $num3 = $num1 + $num2;
		            $num4 = 1;
	                while($num3 > 0)
	                 {
	   
	                  $queryf = "SELECT SUM(mortality) as mort, SUM(average_weight) as avw, SUM(feedconsumed) as weekfeed FROM broiler_daily_entry WHERE place = '$placeid' AND farm = '$farmer' AND supervisior = '$supervisor' AND flock = '$flock' AND age >= '$i' AND age < '$j' ORDER BY entrydate ASC ";
	                  $resultf = mysql_query($queryf,$conn1);
	                  while($rowf = mysql_fetch_assoc($resultf))
	                  {
	                    $weekfeed = $rowf['weekfeed'];
		                $avw = $rowf['avw']; 
						$mort = $rowf['mort'];
						$remainb = $b - $mort;
						//$fcr = (($weekfeed*1000)/($avw * $remainb));
						$mortper = ($mort/$remainb)*100;
						$b = $remainb;
		                //$totalfeedc = $weekfeed + $rowf['weekfeed'];
		                $i = $i + 7;
		                $j = $j + 7;
						
	                ?>
           [<?php echo $num4; ?>,<?php echo $mortper; ?>],
	              <?php } $num3 = $num3 - 1; $num4 = $num4 + 1;
                        } ?>
          [<?php echo $num4; ?>,<?php echo $mortper; ?>]];


var standardweight = [
     <?php include "config.php";
					  $avw = 0;
	                  $m = 0;
		              $n = $m + 7;
	                  $queryn = "SELECT * FROM broiler_daily_entry WHERE place = '$placeid' AND farm = '$farmer' AND supervisior = '$supervisor' AND flock = '$flock' ORDER BY entrydate ASC ";
	                  $resultn = mysql_query($queryn,$conn1);
                      $numn1 = mysql_num_rows($resultn);

	   
	                $query5 = "SELECT SUM(chicks) as chicks FROM transferchicks WHERE farmer = '$farmer' ORDER BY farmer ASC ";
	                $result5 = mysql_query($query5,$conn1);
	                 while($row5 = mysql_fetch_assoc($result5))
	                  {
	                    $b = $row5['chicks'];
	                   }
	   
	                $num11 = round(($numn1/7),0);
		            $num21 = ($numn1 % 7);
		            $num31 = $num11 + $num21;
		            $num4 = 1;
	                while($num31 > 0)
	                 {
	   
	                  $queryf = "SELECT SUM(mortality) as mort, SUM(average_weight) as avw, SUM(feedconsumed) as weekfeed FROM broiler_daily_entry WHERE place = '$placeid' AND farm = '$farmer' AND supervisior = '$supervisor' AND flock = '$flock' AND age >= '$m' AND age < '$n' ORDER BY entrydate ASC ";
	                  $resultf = mysql_query($queryf,$conn1);
	                  while($rowf = mysql_fetch_assoc($resultf))
	                  {
	                    $weekfeed = $rowf['weekfeed'];
		                $avw = $rowf['avw']; 
						$mort = $rowf['mort'];
						$remainb = $b - $mort;
						$fcr = (($weekfeed/($avw * $remainb))*100);
						$b = $remainb;
		                //$totalfeedc = $weekfeed + $rowf['weekfeed'];
		                $m = $m + 7;
		                $n = $n + 7;
						if($avw <= 0) { $avw = 0; }
	                ?>
           [<?php echo $num4; ?>,<?php echo $avw; ?>],
	              <?php } $num31 = $num31 - 1; $num4 = $num4 + 1;
                        } ?>
          [<?php echo $num4; ?>,<?php echo $avw; ?>]];


  var plot =   $.plot($("#placeholder"),
           [ { data: currentweight, label: "Mortality % " },
             { data: standardweight, label: "Average Weight ", yaxis: 2 }],
           { 
		     series: {
                       lines: { show: true },
					   bars: { show: false, barWidth: 0.25, align: "center" } },
             grid: { hoverable: true, clickable: true },
             xaxis: { min: 0, max:10,
                      tickSize: 1
                    },
			 x2axis: { autoscaleMargin: 0.2 },
             yaxis: { min: 0, max: 5.0, tickSize: 1 },
             y2axis: { min : 0, max: 3000, tickSize: 500 },
             legend: { margin: [710,425] } 
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
                    if(x == 1)
					{
                    showTooltip(item.pageX, item.pageY,
                                item.series.label +" for  flock on " + x + "st week  is " + y);
					}
					else if(x == 2) 
					{ 
					showTooltip(item.pageX, item.pageY,
                                item.series.label +" for  flock on " + x + "nd week  is " + y);
					}
					else if(x == 3) 
					{ 
					showTooltip(item.pageX, item.pageY,
                                item.series.label +" for  flock on " + x + "rd week  is " + y);
					}
					else
					{ 
					showTooltip(item.pageX, item.pageY,
                                item.series.label +" for  flock on " + x + "th week  is " + y);
					}
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

<?php

?>
 </body>
</html>
