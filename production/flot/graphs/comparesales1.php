
<?php 
include "getemployee.php";
 	$date2=date("Y-m-d",strtotime(date("Y-m")));
$dateto = date("Y-m-d",strtotime("+1 month -1 second",strtotime($date2)));
$datefrom=date("Y-m-d",strtotime(date("Y-m")." -5 month"));
	
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
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Month Wise Revenue Graph</title>
    <link href="layout.css" rel="stylesheet" type="text/css"></link>
    <!--[if IE]><script language="javascript" type="text/javascript" src="../excanvas.min.js"></script><![endif]-->
    <script language="javascript" type="text/javascript" src="../jquery.js"></script>
    <script language="javascript" type="text/javascript" src="../jquery.flot.js"></script>
    <script language="javascript" type="text/javascript" src="../jquery.flot.dashes.js"></script>
	
      <link href="css/common.css" rel="stylesheet" type="text/css">
	<link href="css/standard.css" rel="stylesheet" type="text/css">
	

 </head>
    <body>
	<script>
	function reloadpage(a)
	{
	
	var cat = document.getElementById('cat').value;
	var fdate = document.getElementById('fdate').value;
	var tdate = document.getElementById('tdate').value;
	document.location = "comparesales1.php?fdate="+fdate+"&tdate=" + tdate + "&category=" + cat ;
}
	
	</script>
    <table border="0">
     <tr>
      <td colspan="3" align="center"><strong><font color="#3e3276">Revenue Vs. Receipts  </font></strong></td>
  </tr>

     <tr>
      <td>
       <span style="filter:flipv fliph;writing-mode:tb-rl;"><span style="">Revenue & Receipts(In Million)</span></span>
      </td>
      <td width="1px"></td>
      <td>
        <div id="placeholder" style="width:270px;height:270px;"></div>
      </td>
    
      <td colspan="3" style="text-align:left;"><font color="red" >
        <?php
		include "getemployee.php";
		include "config.php";
		$revarr = "";$qtyarr = "";
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
			
  					 $resultplc = mysql_query($queryplc,$conn1);
                     while($rowplc = mysql_fetch_assoc($resultplc))
                     {
					
					
              $final = $final + $rowplc['finaltotal'];
		 
		    }
			
			$z++;
			$quant12 = $quant;
		   $ft = round(($final/1000000),2);
		   
		   if($ft > $temp)
			  {
			  $temp = $ft;
			  }
			  $h = floor($temp/25);
			  $t = ($h + 1)*25;
			  
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
		 
		   ?>
		   <table>
		   <?php
		   $revarr[$i]= $ft;
		   $qtyarr[$i] = $quant12;
		  
         ?> 
		 <tr>
		 <td style="text-align:left;" ><font style="color: #3399cc;"><?php echo $i." -" ; ?></font></td>
		
		<td colspan="3" style="text-align:left;"><font style="color: #3399cc;"> <?php echo $mon; ?></font></td>
		
		
		 </tr> 
           
           
       <?php
         $d = $i = $i + 1; $r = $r + 1;} 
		 if($t < 25)
		   {
		   $t = 25;
		   } 
		   $j=1;
 
		  while($loop1 > 1)
           {  $m=$loop1-2;
		   $datefrom=date("Y-m-d",strtotime(date("Y-m")." -$m month"));  
		 $dateto1 = date("Y-m-d",strtotime("+1 month -1 second",strtotime($datefrom)));
	 $queryplc = "SELECT sum(amount) as amount FROM `ac_financialpostings` where type='RCT' and crdr='Dr' and date >= '$datefrom' and date <= '$dateto1'";
  	$resultplc = mysql_query($queryplc,$conn1);
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
	}
		   ?> </table>
		  <?php  
       ?>

     </td>
     </tr> 
   </table> 
    </center>
<script id="source" language="javascript" type="text/javascript">
$(function () {

 var d2 = [
        <?php        
		include "config.php";
		$temp = 0;
		$r = $fm;
		for($i = 1; $i < $d; $i++)
			{
		?>
         [<?php echo $i; ?>,<?php echo $revarr[$i]; ?>],
         <?php 
		 }
		 ?>
         
		    ];

	 var d4 = [
        <?php        		
        include "config.php";
		$temp = 0;
		$r = $fm;
		for($i = 1; $i < $j; $i++)
		{
       ?>
        [<?php echo $i; ?>+.2,<?php echo $rrevarr[$i]; ?>],
        <?php 
		}
		?>
		    ];
  var plot =   $.plot($("#placeholder"),
           [ { data: d2, label: "Revenue",color:"#FF0000"  },
		   { data: d4, label: "Receipt",color:"#006600" }
             ],
            { 

             grid: { hoverable: true, clickable: true },

             bars: { show: true ,
					  barWidth: 0.15,
					  align: "left"
					},
             xaxis: { min: 0, max: <?php echo $d;?>,

                      tickSize: 1,

					  label: "test"

                    },

             yaxis: { min: 0, max: 100, tickSize: 10 },

             y2axis: { min : 0, max: 100, tickSize: 10 },

             legend: { margin: [-120,-10] } 

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

                                item.series.label + " is " + y);

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














