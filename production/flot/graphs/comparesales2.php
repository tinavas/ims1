
<?php 
include "getemployee.php";
$datefrom = date("Y-m-d",strtotime($_GET['fdate']));
$dateto = date("Y-m-d",strtotime($_GET['tdate']));
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
$d = ($tm - $fm);     
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
	document.location = "comparesales.php?fdate="+fdate+"&tdate=" + tdate + "&category=" + cat ;
}
	
	</script>
	<center>
	<table border="0">
     <tr>
	 <input type = "hidden" id = "fdate" name = "fdate" value = "<?php echo $datefrom;?>"/>
	 <input type  = "hidden" id = "tdate" name = "tdate" value = "<?php echo $dateto;?>"/>
	 <td ><strong>Category:</strong></td>
 
	 <td>
	 <select id= "cat" name = "cat" onchange = "reloadpage(this.id);">

	 <option value="All" <?php if($category == "All") { ?> selected="selected"<?php } ?>>All</option>
	
	 <?php
	 include "config.php";
	 $q = "SELECT DISTINCT(cat) FROM ims_itemcodes WHERE code IN (SELECT code FROM oc_cobi)ORDER BY cat ASC"; 
$r = mysql_query($q,$conn1);
	 while($qr = mysql_fetch_assoc($r))
	 {
	 $code1 = $qr['code'];
	 $cat1 = $qr['cat'];
	 ?>
	 <option value="<?php echo $qr['cat'];?>" <?php if($qr['cat'] == $category) { ?> selected="selected"<?php } ?>><?php echo $qr['cat'];?></option>
	
	 <?php } ?>
	 </select>
	 </tr>
	 </table>
    <center>
    <table border="0">
     <tr>
      <td colspan="3"><strong><font color="#3e3276">Month Wise Revenue  from :  <?php echo $mon;?>   to   <?php echo $mon1;?></font></strong></td>
  </tr>

     <tr>
      <td>
       <span style="filter:flipv fliph;writing-mode:tb-rl;"><span style="">Revenue(In Lakhs)</span></span>
      </td>
      <td width="5px"></td>
      <td>
        <div id="placeholder" style="width:900px;height:450px;"></div>
      </td>
     </tr>
     <tr>
      <td colspan="3" style="text-align:left;padding-left:110px"><font color="red" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Month</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Revenue</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Quantity</u></font>
        <?php
		include "getemployee.php";
		include "config.php";
				$temp = 0;
				echo "r".$r2 = $r = $fm;
					 
					 
		$starttime = strtotime($datefrom);
		$endtime = strtotime($dateto);
		$differ = round((($endtime - $starttime)/(24*60*60*30)),2) ;
		$mnth = explode('-',$datefrom);
		$loop = $differ + 1;
		$month = $mnth[1];
		$year = $mnth[0];
		echo $y1 = substr($year, 2);
          $i = 0;
           while($loop > 1)
           {  
		   $final = 0;
		               
		        echo     $queryplc = "select distinct(invoice),finaltotal,quantity from oc_cobi where code in(select distinct(code) from ims_itemcodes where cat $cg '$category') and m = '$month' and y = '$y1'";
  					 $resultplc = mysql_query($queryplc,$conn1);
                     while($rowplc = mysql_fetch_assoc($resultplc))
                     {
					$quant = $rowplc['quantity'];
              $final = $final + $rowplc['finaltotal'];
		 
		    }
			$quant12 = $quant;
		 echo "reeve".  $ft = round(($final/100000),2);
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
		  $y1 = substr($year, 2);
		 
		   ?>
		   <table>
		   <?php
		  
         ?> 
		 <tr>
		 <td colspan="3" style="text-align:left;" width="50"><?php echo $i + 1; ?></td>
		
		<td colspan="3" style="text-align:left;" width="150"> <?php echo $mon; ?></td>
		<td colspan="3" style="text-align:left;" width="75"> <?php echo $ft; ?></td>
		<td colspan="3" style="text-align:left;" width="75"> <?php echo $quant12; ?></td>
		
		
		 </tr> 
           
           
       <?php
         $d = $i = $i + 1; $r = $r + 1;} ?> </table>
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
				echo "r".$r = $r2;
		
				
					 for($i = 0; $i <= $d; $i++)
					 {
					 
					 $final = 0;
echo	$queryplc = "select distinct(invoice),finaltotal,quantity from oc_cobi where code in(select distinct(code) from ims_itemcodes where cat $cg '$category') and m = '$r'";
  					 $resultplc = mysql_query($queryplc,$conn1);
                     while($rowplc = mysql_fetch_assoc($resultplc))
                     {
					$quant = $rowplc['quantity'];
              $final = $final + $rowplc['finaltotal'];
		 
		    }
			$quan1 = round(($quant/100),2);
		  echo "reven". $ft = round(($final/100000),2);				
					  
		           
			  if($ft > $temp)
			  {
			  $temp = $ft;
			  }
			  //$h = floor($temp/25);
			  //$t = ($h + 1)*25;
       ?>
             [<?php echo $i; ?>,<?php echo $ft; ?>],
         <?php 
		 echo "r".  $r = $r +1;
		   }
		   /*if($t < 25)
		   {
		   $t = 25;
		   }*/
		   
		?>
           //[<?php echo $i; ?>, <?php echo $morper; ?>] 
		    ];
	

 var d3 = [
        <?php        
		
                     include "config.php";
				$temp = 0;
				$r = $fm;
					 for($i = 0; $i <= $d; $i++)
					 {
					 $final = 0;
					
					  
		       $queryplc = "select distinct(invoice),finaltotal,quantity from oc_cobi where code in(select distinct(code) from ims_itemcodes where cat $cg '$category') and m = '$r'";
  					 $resultplc = mysql_query($queryplc,$conn1);
                     while($rowplc = mysql_fetch_assoc($resultplc))
                     {
					$quanti = $rowplc['quantity'];
              $final = $final + $rowplc['finaltotal'];
		 
		    }
			$quan = round(($quanti/100),2);
		   $ft = round(($final/100000),2);
			  if($ft > $temp)
			  {
			  $temp = $ft;
			  }
			  $h = floor($temp/25);
			  $t = ($h + 1)*25;
       ?>
             [<?php echo $i; ?>,<?php echo $quan; ?>],
         <?php 
		   $r = $r +1;}
		   if($t < 25)
		   {
		   $t = 25;
		   }
		   
		?>
           //[<?php echo $i; ?>, <?php echo $morper; ?>] 
		    ];
	
  var plot =   $.plot($("#placeholder"),
           [ { data: d2, label: "Revenue",color:"#00ff00"  },
		   { data: d3, label: "Quantity",color:"#ff9999" }
             ],
           { 
             grid: { hoverable: true, clickable: true },
             bars: { show: true },
			 
             xaxis: { min: 0, max: <?php echo $d+1;?>,
			 
			 
			 
                      tickSize: 1,
					  label: "test"
                    },
					
             yaxis: { min: 0, max: <?php echo $t;?>, tickSize: 25 },
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

    $("#placeholder").bind("plotclick", function (event, pos, item) 
	{
        if (item) {
            $("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");
            plot.highlight(item.series, item.datapoint);
        }
    });
});
</script>
 </body>

</html>

