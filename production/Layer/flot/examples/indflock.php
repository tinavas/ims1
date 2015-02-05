<?php 
ini_set('display_errors', 0);
ini_set('log_errors', 0);
ini_set('error_reporting', E_ALL);

 //include "reportheader.php"; 

$place = $_GET['place'];
$supervisor =  $_GET['supervisor'];
$farmer = $_GET['farmer'];
$flock = $_GET['flock'];
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
    <body>
    <center>
    <table border="0">
     <tr>
	 <td colspan="4" align="center">Broiler Flock Performance Graph</td>
	 </tr>
	 <tr>
      <td colspan="4" align="center">Supervisor: <?php echo $supervisor; ?>   Place: <?php echo $place; ?>   Farmer: <?php echo $farmer;?>   Flock: <?php echo $flock;?></td>
     </tr> 
     <tr>
      <td>
       <span style="filter:flipv fliph;writing-mode:tb-rl;"><span style="">FCR/Body Wt.(Kgs)</span></span>
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


 var cumfeedcons = [
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
				  $query5 = "select sum(receivedquantity) as OB from pp_sobi WHERE warehouse = '$farmer' AND flock = '$flock' and category = 'Broiler Chicks' ";
					$result5 = mysql_query($query5,$conn1);
					while( $rowm = mysql_fetch_assoc($result5))
				   {
				      $b = $b + $rowm['OB'];
				   }  
	                
	                $num1 = floor($numn/7);
		            $num2 = ($numn % 7);
		            $num3 = $num1 + 1;
					$num4 = 0;
	                while($num3 >= 0)
	                 {
					  
	   
	                  $queryf = "SELECT  sum(feedconsumed) as mor FROM broiler_daily_entry WHERE place = '$place' AND farm = '$farmer' AND supervisior = '$supervisor' AND flock = '$flock' AND age <= '$j'  ";
	                  $resultf = mysql_query($queryf,$conn1);
					 
	                  while($rowf = mysql_fetch_assoc($resultf))
	                  {
					    //echo $rowf['mor']."/".$b;
					    $morper = round((($rowf['mor']/$b)*1000),3);
					    
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
						$morper = round(($morper/1000),2);
		                
	                ?>
           [<?php echo ($num4 * 7); ?>,<?php echo $morper; ?>],
		      <?php } $num3 = $num3 - 1; $num4 = $num4 + 1;
                        } ?>
         //[<?php echo $num4; ?>,<?php echo $morper; ?>]
		 ];
		 
		 
	 var stdcumfeed = [
                      <?php include "config.php";
					  //$fcr = 0;
	                  $i = 0;
		              $j = $i + 7;
	                  $queryn = "SELECT * FROM broiler_daily_entry WHERE place = '$place' AND farm = '$farmer' AND supervisior = '$supervisor' AND flock = '$flock' ORDER BY entrydate ASC ";
	                  $resultn = mysql_query($queryn,$conn1);
                      $numn = mysql_num_rows($resultn);
	   
	                
	                $num1 = floor($numn/7);
		            $num2 = ($numn % 7);
		            $num3 = $num1 +  1;
		            $num4 = 0;
	                while($num3 >= 0)
	                 {
	   
	                  $queryf = "SELECT  MAX(cumfeed) as avw FROM broiler_allstandards WHERE age >= '$i' AND age < '$j'  ";
	                  $resultf = mysql_query($queryf,$conn1);
					 
	                  while($rowf = mysql_fetch_assoc($resultf))
	                  {
					    
					    $avw = $rowf['avw']; 
						
						//$totalfeedc = $weekfeed + $rowf['weekfeed'];
						if ( $num4 == 0)
						{
						 $avw = 0;
						}
						if ( $num4 > 0)
						{
						$i = $i + 7;
		                $j = $j + 7;
						}
		               $avw = round(($avw/1000),2); 
	                ?>
           [<?php echo ($num4 * 7); ?>,<?php echo $avw; ?>],
		      <?php } $num3 = $num3 - 1; $num4 = $num4 + 1;
                        } ?>
          //[<?php echo ($num4 * 7); ?>,<?php echo $avw; ?>]
		  ];
		  

var stdweight = [
                      <?php include "config.php";
					  //$fcr = 0;
	                  $i = 0;
		              $j = $i + 7;
	                  $queryn = "SELECT * FROM broiler_daily_entry WHERE place = '$place' AND farm = '$farmer' AND supervisior = '$supervisor' AND flock = '$flock' ORDER BY entrydate ASC ";
	                  $resultn = mysql_query($queryn,$conn1);
                      $numn = mysql_num_rows($resultn);
	   
	                  //$query2 = "SELECT SUM(mortality) as mort, SUM(feedconsumed) as feed FROM broiler_daily_entry WHERE place = '2' AND farm = '120' AND supervisior = '3' ORDER BY entrydate ASC ";
	                 // $result2 = mysql_query($query2,$conn1);
	                  //while($row2 = mysql_fetch_assoc($result2))
	                   //{
	                    // $mort = $row2['mort'];
		                //$feed = $row2['feed'];
	                   //}
	                $b = 0;
	                $query5 = "SELECT * FROM broiler_daily_entry WHERE place = '$place' AND farm = '$farmer' AND supervisior = '$supervisor' AND flock = '$flock' ORDER BY entrydate DESC ";
	                $result5 = mysql_query($query5,$conn1);
	                 while($row5 = mysql_fetch_assoc($result5))
	                  {
	                    $b = $row5['birds'];
						
	                   }
					   if ( $b == 0)
					   {
					    $querytrans = "select chicks from transferchicks WHERE  farmer = '$farmer' AND ";
					   }
					   $weekfeed = 0;
	                   $birdsold = 0;
	                $num1 = floor($numn/7);
		            $num2 = ($numn % 7);
		            $num3 = $num1 + 1;
		            $num4 = 0;
	                while($num3 >= 0)
	                 {
	                  if ( $num3 == 1)
					  {
					  $queryf = "SELECT MIN(fcr) as FCR FROM broiler_allstandards WHERE  age >= '$i' AND age <= '$j' ";
					  }
					  else
					  {
	                  $queryf = "SELECT MIN(fcr) as FCR FROM broiler_allstandards WHERE  age >= '$i' AND age < '$j' ";
					  }
	                  $resultf = mysql_query($queryf,$conn1);
					 
	                  while($rowf = mysql_fetch_assoc($resultf))
	                  {
					   
						
	                      $fcr = $rowf['FCR'];
						
						
		                //$totalfeedc = $weekfeed + $rowf['weekfeed'];
		                $i = $i + 7;
		                $j = $j + 7;
	                ?>
           [<?php echo ($num4 * 7); ?>,<?php echo $fcr; ?>],
		      <?php } $num3 = $num3 - 1; $num4 = $num4 + 1;
                        } ?>
          //[<?php echo $num4; ?>,<?php echo $fcr; ?>]
		  ];
		  



var currentweight = [
                      <?php include "config.php";
					  //$fcr = 0;
	                  $i = 0;
		              $j = $i + 7;
	                  $queryn = "SELECT * FROM broiler_daily_entry WHERE place = '$place' AND farm = '$farmer' AND supervisior = '$supervisor' AND flock = '$flock' ORDER BY entrydate ASC ";
	                  $resultn = mysql_query($queryn,$conn1);
                      $numn = mysql_num_rows($resultn);
	   
	                  //$query2 = "SELECT SUM(mortality) as mort, SUM(feedconsumed) as feed FROM broiler_daily_entry WHERE place = '2' AND farm = '120' AND supervisior = '3' ORDER BY entrydate ASC ";
	                 // $result2 = mysql_query($query2,$conn1);
	                  //while($row2 = mysql_fetch_assoc($result2))
	                   //{
	                    // $mort = $row2['mort'];
		                //$feed = $row2['feed'];
	                   //}
	                $b = 0;
					$query111 = "SELECT sum(quantity) as chicks FROM ims_stocktransfer where aflock = '$flock' and towarehouse = '$farmer' and cat = 'Broiler Chicks'   "; $result111 = mysql_query($query111,$conn1);  $rows = mysql_num_rows($result111);
 if ( $rows > 0) { while($row111 = mysql_fetch_assoc($result111)) {  $obirds = $obirds + $row111['chicks']; } }
 
 $query111 = "SELECT sum(receivedquantity) as chicks FROM pp_sobi where flock = '$flock' and warehouse = '$farmer'  and category = 'Broiler Chicks' and date <= '$fromdate'  ";  $result111 = mysql_query($query111,$conn1);   $rows = mysql_num_rows($result111);
  if ( $rows > 0) {  while($row111 = mysql_fetch_assoc($result111))  {   $obirds = $obirds + $row111['chicks'];  } }
                $b = $obirds;
	               
					   $weekfeed = 0;
	                   $birdsold = 0;
	                $num1 = floor($numn/7);
		            $num2 = ($numn % 7);
		            $num3 = $num1 +  1;
		            $num4 = 0;
	                while($num3 >= 0)
	                 {
	                   if ( $num3 == 1)
					   {
					   $queryf = "SELECT SUM(mortality) as mort, MAX(average_weight) as avw,SUM(feedconsumed) as weekfeed,sum(cull) as totcull,MAX(entrydate) as maxdate,MAX(cullflag) as cull FROM broiler_daily_entry WHERE place = '$place' AND farm = '$farmer' AND supervisior = '$supervisor' AND flock = '$flock' AND  age <= '$i' ORDER BY entrydate ASC ";
					   }
					   else
					   {
					   $queryf = "SELECT SUM(mortality) as mort, MAX(average_weight) as avw,SUM(feedconsumed) as weekfeed,sum(cull) as totcull,MAX(entrydate) as maxdate,MAX(cullflag) as cull FROM broiler_daily_entry WHERE place = '$place' AND farm = '$farmer' AND supervisior = '$supervisor' AND flock = '$flock'  AND age <= '$i' ORDER BY entrydate ASC ";
					   }
	                  
	                  $resultf = mysql_query($queryf,$conn1);
					 
	                  while($rowf = mysql_fetch_assoc($resultf))
	                  {
					    $maxdate = $rowf['maxdate'];
						
					    $querycull = "SELECT SUM(birds) as cullbirds from oc_cobi where warehouse = '$farmer' AND flock = '$flock' and code = 'BROB101' and date <= '$maxdate'";
						$resultc = mysql_query($querycull,$conn1);
						while($rowcu = mysql_fetch_assoc($resultc))
						{
						   $birdsold = $rowcu['cullbirds'];
						}
						
	                    $weekfeed =  $rowf['weekfeed'];
		                $avw = $rowf['avw']; 
						$mort = $rowf['mort'];
						$cull = $rowf['totcull'];
						$remainb = $obirds - $mort - $birdsold - $cull;
						if ( $rowf['cull'] == 1)
						{
						    $querysale = "select SUM(quantity) as totweight from oc_cobi where warehouse = '$farmer' AND flock = '$flock' and code = 'BROB101' and date <= '$maxdate' ";
							$resultsale =  mysql_query($querysale,$conn1);
							while($rowsale = mysql_fetch_assoc($resultsale))
							{
							  $salewt = $rowsale['totweight'];
							}
							if($salewt > 0)
							{
							$fcr = round(($weekfeed/$salewt),2);
							}
							else
							{
							// echo $weekfeed."/".$avw."/".$remainb."/".$i;
							// $fcr = $avw/1000;
							if(($avw >0) and ($remainb > 0))
							{
							 $fcr = round(((($weekfeed/(($avw/1000) * $remainb)))),2);
							
							 }
							 else
							 {
							  $fcr = 0;
							 }
							}						
						}
						else
						{
						if(($avw >0) and ($remainb > 0))
							{
							 $fcr = round(((($weekfeed/(($avw/1000) * $remainb)))),2);
							 }
							 else
							 {
							  $fcr = 0;
							 }
						}
						if ( $num4 == 0)
						{
						 $fcr = 0;
						}
						$b = $remainb;
		                //$totalfeedc = $weekfeed + $rowf['weekfeed'];
						
						  $i = $i + 7;
		                  $j = $j + 7;
						
		              
	                ?>
           [<?php echo ($num4 * 7); ?>,<?php echo $fcr; ?>],
		      <?php } $num3 = $num3 - 1; $num4 = $num4 + 1;
                        } ?>
          //[<?php echo $num4; ?>,<?php echo $fcr; ?>]
		  ];
		  
		  
		   var stdbodyweight = [
                      <?php include "config.php";
					  //$fcr = 0;
	                  $i = 0;
		              $j = $i + 7;
	                  $queryn = "SELECT * FROM broiler_daily_entry WHERE place = '$place' AND farm = '$farmer' AND supervisior = '$supervisor' AND flock = '$flock' ORDER BY entrydate ASC ";
	                  $resultn = mysql_query($queryn,$conn1);
                      $numn = mysql_num_rows($resultn);
	   
	                  //$query2 = "SELECT SUM(mortality) as mort, SUM(feedconsumed) as feed FROM broiler_daily_entry WHERE place = '2' AND farm = '120' AND supervisior = '3' ORDER BY entrydate ASC ";
	                 // $result2 = mysql_query($query2,$conn1);
	                  //while($row2 = mysql_fetch_assoc($result2))
	                   //{
	                    // $mort = $row2['mort'];
		                //$feed = $row2['feed'];
	                   //}
	                
	                $num1 = floor($numn/7);
		            $num2 = ($numn % 7);
		            $num3 = $num1 + 1;
		            $num4 = 0;
	                while($num3 >= 0)
	                 {
					 if($num3 == 1)
					 {
					 $queryf = "SELECT  MIN(avgweight) as avw FROM broiler_allstandards WHERE age >= '$i' AND age <= '$j'  ";
					 }
					 else
					 {
					  $queryf = "SELECT  MIN(avgweight) as avw FROM broiler_allstandards WHERE age >= '$i' AND age < '$j'  ";
					 }
	   
	                 
	                  $resultf = mysql_query($queryf,$conn1);
					 
	                  while($rowf = mysql_fetch_assoc($resultf))
	                  {
					    
					    $avw = round(($rowf['avw']/1000),2); 
						
						//$totalfeedc = $weekfeed + $rowf['weekfeed'];
		               
	                ?>
           [<?php echo ($num4 * 7); ?>,<?php echo $avw; ?>],
		      <?php }  $i = $i + 7;
		                $j = $j + 7; 
						$num3 = $num3 - 1; $num4 = $num4 + 1;
                        } ?>
          //[<?php echo $num4; ?>,<?php echo $avw; ?>]
		  ];
		  
		  
		  
		  
		  
		  
		  var currentbodyweight = [
                      <?php include "config.php";
					  //$fcr = 0;
	                  $i = 0;
		              $j = $i + 7;
	                  $queryn = "SELECT * FROM broiler_daily_entry WHERE place = '$place' AND farm = '$farmer' AND supervisior = '$supervisor' AND flock = '$flock' ORDER BY entrydate ASC ";
	                  $resultn = mysql_query($queryn,$conn1);
                      $numn = mysql_num_rows($resultn);
	   
	                  //$query2 = "SELECT SUM(mortality) as mort, SUM(feedconsumed) as feed FROM broiler_daily_entry WHERE place = '2' AND farm = '120' AND supervisior = '3' ORDER BY entrydate ASC ";
	                 // $result2 = mysql_query($query2,$conn1);
	                  //while($row2 = mysql_fetch_assoc($result2))
	                   //{
	                    // $mort = $row2['mort'];
		                //$feed = $row2['feed'];
	                   //}
	                
	                $num1 = floor($numn/7);
		            $num2 = ($numn % 7);
		            $num3 = $num1 + 1 ;
		            $num4 = 0;
	                while($num3 >= 0)
	                 {
					 
					
					
					 
	                if ($num3 == 1)
					{
					 $queryf = "SELECT  MAX(average_weight) as avw FROM broiler_daily_entry WHERE place = '$place' AND farm = '$farmer' AND supervisior = '$supervisor' AND flock = '$flock' AND  age <= '$j'  ";
					}
					else
					{
					 $queryf = "SELECT  MAX(average_weight) as avw FROM broiler_daily_entry WHERE place = '$place' AND farm = '$farmer' AND supervisior = '$supervisor' AND flock = '$flock' AND  age < '$j'  ";
					}
	   
	                 
					 $resultf = mysql_query($queryf,$conn1);
	                  while($rowf = mysql_fetch_assoc($resultf))
	                  {
					    
					    $avw = round(($rowf['avw']/1000),2); 
						//$avw = $j;
						//$totalfeedc = $weekfeed + $rowf['weekfeed'];
		                $i = $i + 7;
		                $j = $j + 7;
						
	                ?>
           [<?php echo ($num4 * 7); ?>,<?php echo $avw; ?>],
		      <?php } $num3 = $num3 - 1; $num4 = $num4 + 1;
			           
                        } ?>
          
		  ];
		  
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
				  $query5 = "select sum(receivedquantity) as OB from pp_sobi WHERE warehouse = '$farmer' AND flock = '$flock' and category = 'Broiler Chicks' ";
					$result5 = mysql_query($query5,$conn1);
					while( $rowm = mysql_fetch_assoc($result5))
				   {
				      $b = $b + $rowm['OB'];
				   }  
	                
	                $num1 = floor($numn/7);
		            $num2 = ($numn % 7);
		            $num3 = $num1 + 1;
					$num4 = 0;
	                while($num3 >= 0)
	                 {
					  
	   
	                  $queryf = "SELECT  sum(mortality) as mor FROM broiler_daily_entry WHERE place = '$place' AND farm = '$farmer' AND supervisior = '$supervisor' AND flock = '$flock' AND age <= '$j'  ";
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
		   
	   //}
	   
	   //$query3 = "SELECT COUNT(*) as c FROM broiler_daily_entry WHERE place = '2' AND farm = '120' AND supervisior = '3' AND average_weight != '' ORDER BY entrydate ASC ";
	   //$result3 = mysql_query($query3,$conn1);
	   //while($row3 = mysql_fetch_assoc($result3))
	   //{
	    // $c = $row3['c'];
	  // }
	   
	   //$query4 = "SELECT SUM(average_weight) as avgweight FROM broiler_daily_entry WHERE place = '2' AND farm = '120' AND supervisior = '3' ORDER BY entrydate ASC ";
	   //$result4 = mysql_query($query4,$conn1);
	   //while($row4 = mysql_fetch_assoc($result4))
	   //{
	     //$avgweight = $row4['avgweight'];
	   //}
	   

	   
	   //$remainingbirds = $b - $mort;
	  // $avgw = $avgweight/$c;
	   
	   //$fcr = ($feed/($remainingbirds * $avgw)) * 1000;
	   
       //$query1 = "SELECT * FROM broiler_daily_entry WHERE place = '2' AND farm = '120' AND supervisior = '3' ORDER BY entrydate ASC ";
       //$result1 = mysql_query($query1,$conn1);
       //while($row1 = mysql_fetch_assoc($result1))
      //{
 
       
   





  var plot =   $.plot($("#placeholder"),
           [ { data: stdweight, label: "Standard FCR",color:"#006600" },
		   { data: currentweight, label: "Actual FCR ",color:"#CC0000"  },
		    { data: stdbodyweight, label: "Standard Body Wt(Kgs)",color:"#000099"  },
			 { data: currentbodyweight, label: "Actual Body Wt(Kgs)",color:"#FFFF00"  },
			 { data: cumfeedcons, label: "Actual Feed Consumed(Kgs)", color:'#00FF00',yaxis: 2 },
             { data: stdcumfeed, label: "Standard Feed Consumed(Kgs)", color:'#FF9999', yaxis: 2 },
			 { data: cummor, label: "Mortality %", color:'#9999FF', yaxis: 2 }			
             ],
           { 
		     series: {
                       lines: { show: true },
					   bars: { show: false, barWidth: 0.25, align: "center" } },
             grid: { hoverable: true, clickable: true },
             xaxis: { min: 0, max:56,
                      tickSize: 7
                    },
			 x2axis: { autoscaleMargin: 0.2 },
             yaxis: { min: 0, max: 3, tickSize: 0.3 },
             y2axis: { min : 0, max: 16, tickSize: 1 },
             legend: { margin: [600,325] } 
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
