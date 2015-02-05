<?php 
ini_set('display_errors', 0);
ini_set('log_errors', 0);
ini_set('error_reporting', E_ALL);

$place = $_GET['place'];
$supervisor =  $_GET['supervisor'];
$farmer = $_GET['farmer'];
$flock = $_GET['flock'];
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Mortality Percentage</title>
    <link href="layout.css" rel="stylesheet" type="text/css"></link>
    <!--[if IE]><script language="javascript" type="text/javascript" src="../excanvas.min.js"></script><![endif]-->
    <script language="javascript" type="text/javascript" src="../jquery.js"></script>
    <script language="javascript" type="text/javascript" src="../jquery.flot.js"></script>
    <script language="javascript" type="text/javascript" src="../jquery.flot.dashes.js"></script>
	
      <link href="css/common.css" rel="stylesheet" type="text/css">
	<link href="css/standard.css" rel="stylesheet" type="text/css">

 </head>
    <body>
      <center>
    <table border="0">
     <tr>
	 <td colspan="4">Mortality Percentage Graph</td>
	 </tr>
	 <tr>
      <td colspan="4">Supervisor: <?php echo $supervisor; ?>   Place: <?php echo $place; ?>   Farmer: <?php echo $farmer;?>   Flock: <?php echo $flock;?></td>
     </tr> 
     <tr>
      <td>
       <span style="filter:flipv fliph;writing-mode:tb-rl;"><span style="">Mortality%</span></span>
      </td>
      <td width="5px"></td>
      <td>
        <div id="placeholder" style="width:900px;height:500px;"></div>
      </td>
     </tr>
     <tr>
      <td colspan="3">Age (Days)</td>
     </tr> 
   </table>
    </center>
<script id="source" language="javascript" type="text/javascript">
$(function () {


		  
		  var cummor = [
                      <?php include "config.php";
					  //$fcr = 0;
	                  $i = 0;
		              $j = $i + 7;
					  $b = 0;
	                  $queryn = "SELECT * FROM broiler_daily_entry WHERE place = '$place' AND farm = '$farmer' AND supervisior = '$supervisor' AND flock = '$flock' ORDER BY entrydate ASC ";
	                  $resultn = mysql_query($queryn,$conn1);
                      $numn = mysql_num_rows($resultn);
					
					  
					  $query5 = "select sum(quantity) as OB from ims_stocktransfer WHERE towarehouse = '$farmer' AND aflock = '$flock' and cat = 'Broiler Chicks' ";
					$result5 = mysql_query($query5,$conn1);
					while( $rowm = mysql_fetch_assoc($result5))
				   {
				      $b = $rowm['OB'];
				   }
				  $query5 = "select sum(receivedquantity) as OB from pp_sobi WHERE warehouse = '$farmer' AND flock = '$flock' and description = 'Broiler Chicks' ";
					$result5 = mysql_query($query5,$conn1);
					while( $rowm = mysql_fetch_assoc($result5))
				   {
				      $b = $b + $rowm['OB'];
				   }  
	                
	                $num1 = floor($numn/7);
		            $num2 = ($numn % 7);
					if($num2 == 0)
					{
		            $num3 = $num1+1;
					}
					else
					{
					$num3 =  $num1+2;
					}
					$maxww =($num3-1) *7;
					$num4 = 0;
	                while($num3 > 0)
	                 {
					  
	   
	                  $queryf = "SELECT  sum(mortality) as mor FROM broiler_daily_entry WHERE place = '$place' AND farm = '$farmer' AND supervisior = '$supervisor' AND flock = '$flock' AND age < '$j'  ";
	                  $resultf = mysql_query($queryf,$conn1);
					 
	                  while($rowf = mysql_fetch_assoc($resultf))
	                  {
					    $morper = round((($rowf['mor']/$b)*100),2);
					    
						 if ( $num4 == 0)
						 {
						   $morper = 0;
						 }
						
						//$totalfeedc = $weekfeed + $rowf['weekfeed'];
						if ( $num4 > 0)
						{
						$i = $i + 7;
		                $j = $j + 7;
						}
		                
	                ?>
           [<?php echo ($num4 * 7); ?>,<?php echo $morper; ?>],
		      <?php } $num3 = $num3 - 1; $num4 = $num4 + 1;
                        } ?>
         //[<?php echo $num4; ?>,<?php echo $morper; ?>]
		 ];
	  
       
	     var weekmor = [
                      <?php include "config.php";
					  //$fcr = 0;
	                  $i = 0;
		              $j = $i + 7;
					  $b = 0;
	                  $queryn = "SELECT * FROM broiler_daily_entry WHERE place = '$place' AND farm = '$farmer' AND supervisior = '$supervisor' AND flock = '$flock' ORDER BY entrydate ASC ";
	                  $resultn = mysql_query($queryn,$conn1);
                      $numn = mysql_num_rows($resultn);
					  
					$query5 = "select sum(quantity) as OB from ims_stocktransfer WHERE towarehouse = '$farmer' AND aflock = '$flock' and cat = 'Broiler Chicks' ";
					$result5 = mysql_query($query5,$conn1);
					while( $rowm = mysql_fetch_assoc($result5))
				   {
				      $b = $rowm['OB'];
				   }
				  $query5 = "select sum(receivedquantity) as OB from pp_sobi WHERE warehouse = '$farmer' AND flock = '$flock' and description = 'Broiler Chicks' ";
					$result5 = mysql_query($query5,$conn1);
					while( $rowm = mysql_fetch_assoc($result5))
				   {
				      $b = $b + $rowm['OB'];
				   }  
	                
	                //$num1 = round(($numn/7),0);
		            $num1 =  floor($numn/7);
					$num2 = ($numn % 7);
					if($num2 == 0)
					{
		            $num3 = $num1+1;
					}
					else
					{
					$num3 =  $num1+2;
					}
					$num4 = 0;
	                while($num3 > 0)
	                 {
					  
	   
	                  $queryf = "SELECT  SUM(mortality) as mor,MAX(entrydate) as maxdate,MIN(entrydate) as mindate FROM broiler_daily_entry WHERE place = '$place' AND farm = '$farmer' AND supervisior = '$supervisor' AND flock = '$flock' AND age >= '$i' AND age < '$j'  ";
	                  $resultf = mysql_query($queryf,$conn1);
					 
	                  while($rowf = mysql_fetch_assoc($resultf))
	                  {
					    $maxdate = $rowf['maxdate'];
						$mindate = $rowf['mindate'];
					   $querysale = "SELECT SUM(birds) as salbird FROM oc_cobi where warehouse = '$farmer' AND flock = '$flock' AND code = 'BROB101' and date >= '$mindate' AND date < '$maxdate' ";
					   $resultmor = mysql_query($querysale,$conn1);
					   while($rowmor = mysql_fetch_assoc($resultmor))
					   {
					     $salebirds = $rowmor['salbird'];
					   }
					   //$b = $b - $rowf['mor'] - $salebirds;
					    $morper = round((($rowf['mor']/$b)*100),2);
					    //$morper = $rowf['mor'];
						 if ( $num4 == 0)
						 {
						   $morper = 0;
						 }
						
						//$totalfeedc = $weekfeed + $rowf['weekfeed'];
						if ( $num4 > 0)
						{
						$i = $i + 7;
		                $j = $j + 7;
						}
		                
	                ?>
           [<?php echo ($num4 * 7); ?>,<?php echo $morper; ?>],
		      <?php } $num3 = $num3 - 1; $num4 = $num4 + 1;
                        } ?>
         //[<?php echo $num4; ?>,<?php echo $morper; ?>]
		 ];
		 
  var plot =   $.plot($("#placeholder"),
           [ 
		   { data: cummor, label: "Cum. Mortality%",color:"#00ff00" },
		   {data: weekmor, label: "Weekly Mortality%",color:"#ff9999"}		   
             ],
           { 
		     series: {
                       lines: { show: true },
					   bars: { show: false, barWidth: 0.25, align: "center" } },
             grid: { hoverable: true, clickable: true },
             xaxis: { min: 0, max:<?php echo $maxww;?>,
                      tickSize: 7
                    },
			 x2axis: { autoscaleMargin: 0.2 },
             yaxis: { min: 0, max: 16, tickSize: 2 },
             y2axis: { min : 0, max: 500, tickSize: 50 },
             legend: { margin: [600,425] } 
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
                                item.series.label +" for  flock on day " + x + " is " + y);
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

