<?php

$sExport = @$_GET["export"]; 
include "../production/reportheader.php"; 
 $date2=date("Y-m-d",strtotime(date("Y-m")));
$dateto = date("Y-m-d",strtotime($_GET['tdate']));
$datefrom=date("Y-m-d",strtotime($_GET['fdate']));
	
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php include "../production/phprptinc/ewrcfg3.php"; ?>
<?php include "../production/phprptinc/ewmysql.php"; ?>
<?php include "../production/phprptinc/ewrfn3.php"; ?>
<?php include "../production/phprptinc/header.php"; ?>
<center>
<table align="center" border="0" width="960px">
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Monthly Revenue Bar Chart</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td align="center"><strong><font color="#3e3276">From Date </font></strong><?php echo date("d.m.Y",strtotime($datefrom)); ?></td>

 <td align="center"><strong><font color="#3e3276">To Date </font></strong><?php echo date("d.m.Y",strtotime($dateto)); ?></td>
</tr> 
</table>
</center>
<?php
include "../getemployee.php";
include "../config.php";
/*$conn1=mysql_connect("localhost","root","") or die(mysql_error());
$db=mysql_select_db("mpc");*/


if($_GET['category'] == "")
 $category = "All";
else
 $category = $_GET['category'];
if($category == "All")
$cg = "<>";
else
$cg = "=";                                                        
$fd = explode("-",$datefrom); 
$fm = $fd[1];
$fy = $fd[0];
 $td = explode("-",$dateto); 
$tm = $td[1]; 
  $fy1 = $td[0];                                           
$d = ($tm - $fm-1);     
if ( $fm == 1)
			  {
			    $mon = "January-".$fy;
			  }
			  else if ( $fm == 2)
			  {
			    $mon = "February-".$fy;
			  }
			  else if ( $fm == 3)
			  {
			    $mon = "March-".$fy;
			  }
			  else if ( $fm == 4)
			  {
			    $mon = "April-".$fy;
			  }
			  else if ( $fm == 5)
			  {
			    $mon = "May-".$fy;
			  }
			  else if ( $fm == 6)
			  {
			    $mon = "June-".$fy;
			  }
			  else if ( $fm == 7)
			  {
			   $mon = "July-".$fy;
			  }
			  else if ( $fm ==  8)
			  {
			   $mon = "August-".$fy;
			  }
			  else if ( $fm == 9)
			  {
			   $mon = "September-".$fy;
			  }
			  else if ($fm == 10)
			  {
			   $mon = "October-".$fy;
			  }
			  else if ($fm == 11)
			  {
			   $mon = "Novemeber-".$fy;
			  }
			  else 
			  {
			   $mon = "December-".$fy;
}
if ( $tm == 1)
			  {
			    $mon1 = "January-".$fy1;
			  }
			  else if ( $tm == 2)
			  {
			    $mon1 = "February-".$fy1;
			  }
			  else if ( $tm == 3)
			  {
			    $mon1 = "March-".$fy1;
			  }
			  else if ( $tm == 4)
			  {
			    $mon1 = "April-".$fy1;
			  }
			  else if ( $tm == 5)
			  {
			    $mon1 = "May-".$fy1;
			  }
			  else if ( $tm == 6)
			  {
			    $mon1 = "June-".$fy1;
			  }
			  else if ( $tm == 7)
			  {
			   $mon1 = "July-".$fy1;
			  }
			  else if ( $tm ==  8)
			  {
			   $mon1 = "August-".$fy1;
			  }
			  else if ( $tm == 9)
			  {
			   $mon1 = "September-".$fy1;
			  }
			  else if ($tm == 10)
			  {
			   $mon1 = "October-".$fy1;
			  }
			  else if ($tm == 11)
			  {
			   $mon1 = "Novemeber-".$fy1;
			  }
			  else 
			  {
			   $mon1 = "December-".$fy1;
              }
			  //echo $mon,$mon1;

		$revarr = "";
		$qtyarr = "";
				$temp = 0;
				$r = $fm;
					 
					 
		$starttime = strtotime($datefrom);
		$endtime = strtotime($dateto);
		$differ = round((($endtime - $starttime)/(24*60*60*30)),2) ;
		$mnth = explode('-',$datefrom);
		$loop = $differ + 1;
		$loop1 = $differ + 1;
		$month = $mnth[1];
		$year = $mnth[0];
		$y1 = substr($year, 2);
		
          $i = 1;
		  $z=0;
           while($loop > 1)
           {  
		   $final = 0;$quant12 =0;$quant = 0;
		   $queryplc = "select distinct(invoice),finaltotal from oc_cobi where flag='1' and code in(select distinct(code) from ims_itemcodes ) and m = '$month' and y = '$y1' and party != '' ";
			
  					 $resultplc = mysql_query($queryplc,$conn) or die(mysql_error());
                     while($rowplc = mysql_fetch_assoc($resultplc))
                     {
					
					
              $final = $final + $rowplc['finaltotal'];
		 
		    }
			
			//echo $final;
			$z++;
			$quant12 = $quant;
		   $ft = round(($final/1000000),2);
		   $revarr[]= $ft;
		   
		   if($ft > $temp)
			  {
			  $temp = $ft;
			  }
			  $h = floor($temp/25);
			  $t = ($h + 1)*25;
			  
			  if(strlen($month)>1)
			  {
			  
			  }
			  else
			  {
			  $month="0".$month;
			  }
			  
		$datefrom="20".$y1."-".$month."-01";
		$dateto1="20".$y1."-".$month."-31";
			  
			  
			    $queryplc = "SELECT sum(amount) as amount FROM `ac_financialpostings` where type='RCT' and crdr='Dr' and date >= '$datefrom' and date <= '$dateto1'";
  	$resultplc = mysql_query($queryplc,$conn) or die(mysql_error());
    $rowplc = mysql_fetch_assoc($resultplc);
	$rfinal = $rowplc['amount']; 
	$rft = round(($rfinal/1000000),2);
	$rrevarr[]= $rft;
			  
			  
			  
			  
		      if ( $month == 1)
			  {
			    $mon = "Jan-".$year;
			  }
			  else if ( $month == 2)
			  {
			    $mon = "Feb-".$year;
			  }
			  else if ( $month == 3)
			  {
			    $mon = "Mar-".$year;
			  }
			  else if ( $month == 4)
			  {
			    $mon = "Apr-".$year;
			  }
			  else if ( $month == 5)
			  {
			    $mon = "May-".$year;
			  }
			  else if ( $month == 6)
			  {
			    $mon = "June-".$year;
			  }
			  else if ( $month == 7)
			  {
			   $mon = "July-".$year;
			  }
			  else if ( $month ==  8)
			  {
			   $mon = "Aug-".$year;
			  }
			  else if ( $month == 9)
			  {
			   $mon = "Sept-".$year;
			  }
			  else if ($month == 10)
			  {
			   $mon = "Oct-".$year;
			  }
			  else if ($month == 11)
			  {
			   $mon = "Nov-".$year;
			  }
			  else if ( $month == 12)
			  {
			   $mon = "Dec-".$year;
			   $year = $year + 1;
			   
			  }
		   
		   $loop = $loop - 1;
		   if ( $month == 12)
		   {
		    $month = 1;
		   }
		   else
		   {
		   $month = $month + 1;
		   }
		  $y1 = substr($year, 2);
		 
		  
		   
		   $qtyarr[] =$mon; 
		  
     $d = $i = $i + 1; $r = $r + 1;
	//print_r($qtyarr);
	
	 
	 } 
		 if($t < 25)
		   {
		   $t = 25;
		   } 
		   $j=1;
 //echo $loop1;
		 /* while($loop1 > 1)
           {  
		
		   
		   
		   $m=$loop1-2;
		   $datefrom=date("Y-m-d",strtotime(date("Y-m")." -$m month"));  
		 $dateto1 = date("Y-m-d",strtotime("+1 month -1 second",strtotime($datefrom)));
	 $queryplc = "SELECT sum(amount) as amount FROM `ac_financialpostings` where type='RCT' and crdr='Dr' and date >= '$datefrom' and date <= '$dateto1'";
  	$resultplc = mysql_query($queryplc,$conn) or die(mysql_error());
    $rowplc = mysql_fetch_assoc($resultplc);
	$rfinal = $rowplc['amount']; 
	
	$rft = round(($rfinal/1000000),2);
	if($rft > $temp)
		{
			$temp = $rft;
		}
	$h = floor($temp/25);
	$t = ($h + 1)*25;
	$rrevarr[$j]= $rft;
	 $j = $j + 1; 
	 $loop1=$loop1-1;
	 
	  
	 
	 
	 
	}*/
	
	$maxval=max($revarr);
	
	for($i=0;$i<$maxval+40;$i=$i+10)
	{
	$yaxisval[]=$i;
	}
	
	//print_r($yaxisval);
	//print_r($revarr);
	//print_r($rrevarr);
	//print_r($qtyarr);
	


?>




<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example</title>

		<script type="text/javascript" src="include/jquery.min.js"></script>
		<script type="text/javascript">
$(function () {
    $('#container').highcharts({

        chart: {
            type: 'column',
            options3d: {
                enabled: true,
                alpha: 5,
                beta: 15,
                viewDistance: 40,
                depth: 40
            },
            marginTop: 80,
            marginRight: 40
        },

        title: {
            text: 'Revenue Vs Receipts'
        },

        xAxis: {
            categories: <?php echo json_encode($qtyarr);?>
        },

        yAxis: {
            allowDecimals: true,
           min:0,
		  
            title: 
			{
                text: '<?php echo "<b>Revenue & Receipts(In Million)</b>";?>'
            }
			
        },

        tooltip: {
            headerFormat: '<b>{point.key}</b><br>',
            pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y}'
        },

        plotOptions: {
            /*column: {
                stacking: 'normal',
                depth: 40
            }*/
        },


	//print_r($revarr);
	//print_r($rrevarr);
        series: [{
            name: 'Revenue',
            data: <?php echo json_encode($revarr);?>
            
        }, {
            name: 'Receipts',
            data: <?php echo json_encode($rrevarr);?>
           
        }]
		
    });
});
    

		</script>
	</head>
	<body>

<script type="text/javascript"  src="include/js/highcharts.js"></script>

<script type="text/javascript" src="include/js/highcharts-3d.js"></script>

<div id="container" style="height: 400px"></div>
	</body>
</html>
