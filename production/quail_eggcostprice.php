<?php
session_start();
$db = $_SESSION['db'];
$fromdate = $_GET['fromdate'];
$todate = $_GET['todate'];
$client = $_SESSION['client'];
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
	
		
      <link href="css/common.css" rel="stylesheet" type="text/css">
	<link href="css/standard.css" rel="stylesheet" type="text/css">
	

 </head>
    <body>
      <center>
	  <?php include "reportheader.php"; ?><br /><br />
    <table border="0">
     <tr>
       <td colspan="4" align="center">
         <strong><font color="#3e3276">Cost Per Hatch Egg Graph from <?php echo $fromdate; ?> to <?php echo $todate; ?></font></strong>
       </td>
     </tr>
      <tr>
      <td colspan="4"><strong>Day</strong></td>
     </tr> 

     <tr>
      <td width="5px"></td>
      <td>
	   <span style="filter:flipv fliph;writing-mode:tb-rl;"><span style=""><strong>Price (in Rs.)</strong></span></span>
      </td>
      <td width="5px"></td>
      <td>
       <div id="placeholder" style="width:900px;height:480px;text-align:left"></div>
      </td>
     </tr>
   </table>
    
<?php
include "config.php";
$i = 0;
$fdump = date("Y-m-d",strtotime($fromdate));
$tdump = date("Y-m-d",strtotime($todate));
$query1 = "SELECT sum(quantity) as pqty,date1 FROM quail_production WHERE date1 BETWEEN '$fdump' AND '$tdump' and itemcode in(select distinct(code) from ims_itemcodes where cat = 'Quail Hatch Eggs' and client = '$client') GROUP BY date1 ORDER BY date1";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
 $pqty = $rows1['pqty'];
 $date1 = $rows1['date1'];
 
$query2 = "SELECT sum(receivedquantity * rateperunit)/sum(receivedquantity) as rate FROM pp_sobi WHERE date <= '$date1' AND code IN (SELECT distinct(code) FROM ims_itemcodes WHERE cat In ('Quail Female Feed','Quail Male Feed'))";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 $rows2 = mysql_fetch_assoc($result2);
$feedcost = $rows2['rate'];

$query3 = "SELECT sum(quantity) as cqty FROM quail_consumption WHERE date2 = '$date1' and itemcode in(select distinct(code) from ims_itemcodes where cat In ('Quail Female Feed','Quail Male Feed') )";
 $result3 = mysql_query($query3,$conn1) or die(mysql_error());
 $rows3 = mysql_fetch_assoc($result3);
 $cqty = $rows3['cqty'];
 
 $price = round(($cqty * $feedcost / $pqty),2);
 
 $fdate[$i] = $date1;
 $cost[$i] = $price;
 $i++;
}
$totaldays = $i;
?>	
<script id="source" language="javascript" type="text/javascript">

$(function () {

var eggcost = [
     <?php 
	 for($j = 0; $j < ($i-1) ; $j++)
	 {
     ?>
       [<?php echo ($j+1); ?>,<?php echo $cost[$j]; ?>],
     <?php  } ?>
     [<?php echo ($j+1); ?>,<?php echo $cost[$j]; ?>]];


<!-- , dashes: { show: true }, hoverable: true  -->

            var plot =   $.plot($("#placeholder"),
           [ { data: eggcost, label: "Hatch Egg Cost", color:'#FF0000', xaxis: 2 } ],
           { 
             grid: { hoverable: true, clickable: true },
             
             yaxis: { min: 0, tickSize: 1, max:10 },
			 xaxis: { min: 0, tickSize: 1, max: 50 },
             legend: { margin: [700,420] } 
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
        //$("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));

        if (1) {
            if (item) {
                if (previousPoint != item.datapoint) {
                    previousPoint = item.datapoint;
                    
                    $("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(0),
                        y = item.datapoint[1].toFixed(2);
                    
                    showTooltip(item.pageX, item.pageY,
                                item.series.label +" for " + x + " day " + " is " + y);
                }
            }
            else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
        }
    });

});



</script>
<table style="text-align:left;padding-left:110px" cellspacing="2">
<tr style="color:red">
 <th><u>Day</u></th>
 <th width="10px"></th>
 <th><u>Date</u></th>
 <th width="10px"></th>
 <th><u>Price</u></th>
</tr>
<?php
for($i =0 ;$i < $totaldays; $i++)
{
?>
<tr>
 <td><?php echo $i + 1; ?></td>
 <td width="10px"></td>
 <td><?php echo date("d.m.Y",strtotime($fdate[$i])); ?></td>
 <td width="10px"></td>
 <td align="right"><?php echo $cost[$i]; ?></td>
</tr> 
<?php
}
?>
</table>
</center>
 </body>
</html>

