
<?php 
$supervisor =  $_GET['supervisor'];
$cullflag = $_GET['cull'];
$datefrom = $_GET['datefrom'];
$dateto = $_GET['dateto'];
$datefrom = date("Y-m-d",strtotime($datefrom));
$dateto = date("Y-m-d",strtotime($dateto));
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Broiler Birds Sale Graph</title>
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
      <td colspan="3">Monthly Birds Sales of Supervisor:<?php echo $supervisor; ?></td>
     </tr> 
     <tr>
      <td>
       <span style="filter:flipv fliph;writing-mode:tb-rl;"><span style="">Sales(Kgs.)</span></span>
      </td>
      <td width="5px"></td>
      <td>
        <div id="placeholder" style="width:900px;height:450px;"></div>
      </td>
     </tr>
     <tr>
      <td colspan="3" style="text-align:left;padding-left:110px"><font color="red" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Month</u></font>
        <?php
		$starttime = strtotime($datefrom);
		$endtime = strtotime($dateto);
		$differ = round((($endtime - $starttime)/(24*60*60*30)),2) ;
		$mnth = explode('-',$datefrom);
		$loop = $differ + 1;
		$month = $mnth[1];
		$year = $mnth[0];
          $i = 0;
           while($loop > 1)
           {  
		      if ( $month == 1)
			  {
			    $mon = "January-".$year;
			  }
			  else if ( $month == 2)
			  {
			    $mon = "February-".$year;
			  }
			  else if ( $month == 3)
			  {
			    $mon = "March-".$year;
			  }
			  else if ( $month == 4)
			  {
			    $mon = "April-".$year;
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
			   $mon = "August-".$year;
			  }
			  else if ( $month == 9)
			  {
			   $mon = "September-".$year;
			  }
			  else if ($month == 10)
			  {
			   $mon = "October-".$year;
			  }
			  else if ($month == 11)
			  {
			   $mon = "Novemeber-".$year;
			  }
			  else if ( $month == 12)
			  {
			   $mon = "December-".$year;
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
		  
		 
		   ?>
		   <table>
		   <?php
		  
         ?> 
		 <tr>
		 <td colspan="3" style="text-align:left;" width="50"><?php echo $i + 1; ?></td>
		<td colspan="3" style="text-align:left;" width="200"> <?php echo $mon;?></td>
		
		 </tr> 
           
           
       <?php
          $i = $i + 1; } ?> </table><?php  
       ?>

     </td>
     </tr> 
   </table>
    </center>
<script id="source" language="javascript" type="text/javascript">
$(function () {
 var d2 = [
        <?php       $starttime = strtotime($datefrom);
		$endtime = strtotime($dateto);
		$differ = round((($endtime - $starttime)/(24*60*60*30)),0) ;
		$mnth = explode('-',$datefrom);
		$curmnth = $mnth[1];
		$curyear = $mnth[0];
		$i = 1;
		$xaxis = $differ + 1;
		$loop = $differ + 1;
		while( $loop > 0)
		{
		$sumwt = 0;
		$datefrom1 = $curyear . "-" . $curmnth . "-01";
		$nxtyear = $curyear + 1;
		$nxtmnth = $curmnth + 1;
		$dateto1 = $curyear . "-" . $curmnth . "-31";
           include "config.php";
           $query3 = "SELECT SUM(weight) as totwt FROM oc_cobi where code = 'BROB101' and flock in (select distinct(flock) from broiler_daily_entry where supervisior = '$supervisor') and date >= '$datefrom1' and date <= '$dateto1' ";
           $result3 = mysql_query($query3,$conn1); 
          $cnt = mysql_num_rows($result3);
		  //echo $datefrom1;
		   
           while($row3 = mysql_fetch_assoc($result3))
           {  
		   
		   $sumwt = $row3['totwt'];
           $loop = $loop - 1;
		   if ( $curmnth == 12)
		   {
		     $curmnth = 1;
			 $curyear = $curyear + 1;
		   }
		   else
		   {
		   $curmnth = $curmnth + 1;
		   }
		   }
		   
       ?>
             [<?php echo $i; ?>,<?php echo $sumwt; ?>],
         <?php $i = $i + 1;  
		 }?>
           //[<?php echo $i; ?>, <?php echo $morper; ?>] 
		    ];
			 

   


  
    

   



  var plot =   $.plot($("#placeholder"),
           [ { data: d2, label: "Sale Wt(Kgs.) " }
             ],
           { 
             grid: { hoverable: true, clickable: true },
             bars: { show: true },
             xaxis: { min: 1, max: <?php echo $xaxis + 1; ?>,
                      tickSize: 1,
					  label: "test"
                    },
             yaxis: { min: 0, max: 100000, tickSize: 10000 },
             y2axis: { min : 0, max: 100, tickSize: 10 },
             legend: { margin: [690,375] } 
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

