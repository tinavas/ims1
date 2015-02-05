<?php include "config.php"; 
$date = $_GET['date'];
$todate = date("Y-m-d",strtotime($date));

$q = "SELECT fdate FROM ac_definefy";
$r = mysql_fetch_assoc(mysql_query($q,$conn1));
$fromdate = $r['fdate'];
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>B.I.M.S</title>
	<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="../excanvas.min.js"></script><![endif]-->
    <script language="javascript" type="text/javascript" src="../jquery.js"></script>
	<script language="javascript" type="text/javascript" src="../jquery.flot.js"></script>
    <script language="javascript" type="text/javascript" src="../jquery.flot.pie.js"></script>
	
<script type="text/javascript">
$(function () {

	var data = [];
	var i = -1;
	<?php
	 $query1 = "SELECT distinct(code),description FROM ac_coa WHERE schedule = 'Current Assets' AND client = '$client' ORDER BY code";
	 $result1 = mysql_query($query1,$conn1) or die(mysql_error());
	 while($rows1 = mysql_fetch_assoc($result1))
	 {
	  $cramount = $dramount = 0;
	  $query2 = "SELECT sum(amount) as cramount FROM ac_financialpostings WHERE date BETWEEN '$fromdate' AND '$todate' AND coacode = '$rows1[code]' AND crdr = 'Cr' AND client = '$client'";
	  $result2 = mysql_query($query2,$conn1) or die(mysql_error());
	  $rows2 = mysql_fetch_assoc($result2);
	  $cramount = $rows2['cramount'];
	  $query2 = "SELECT sum(amount) as dramount FROM ac_financialpostings WHERE date BETWEEN '$fromdate' AND '$todate' AND coacode = '$rows1[code]' AND crdr = 'Dr' AND client = '$client'";
	  $result2 = mysql_query($query2,$conn1) or die(mysql_error());
	  $rows2 = mysql_fetch_assoc($result2);
	  $dramount = $rows2['dramount'];
	  $bal = round(($cramount - $dramount)/100000,2);
	 ?>
	 data[++i] = { label: "<?php echo $rows1['code']; ?>", data:<?php echo $bal; ?> }
	 <?php
	}
	?>
		//data[i] = { label: "Series"+(i+1), data: Math.floor(Math.random()*100)+1 }

	// schedule
    $.plot($("#schedule"), data, 
	{
		series: {
			pie: { 
				show: true,
				radius: 0.8,
				label: {
					show: true,
					radius: 3/4,
					formatter: function(label, series){
						return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">'+label+'<br/>'+String(series.data).substr(2)+'</div>';
					},
					background: { 
						opacity: 0.5,
						color: '#000'
					}
				}
			}
		},
		grid: {
            hoverable: true,
            clickable: true
        },
		legend: {
		 	margin: 5
		}	

	});
	
$("#schedule").bind("plothover", pieHover);
$("#schedule").bind("plotclick", pieClick);
function pieHover(event, pos, obj) 
{
	if (!obj)
                return;
	//var temp = obj.series.data;
	//alert(temp);
	percent = parseFloat(obj.series.percent).toFixed(2);
	$("#hover1").html('<span style="font-weight: bold; color: '+obj.series.color+'">COA Code :'+obj.series.label+' Amount :'+percent+'%(' + String(obj.series.data).substr(2) +' Lakhs)</span>');
}

function pieClick(event, pos, obj) 
{
	if (!obj)
                return;
	percent = parseFloat(obj.series.percent).toFixed(2);
	alert('COA Code '+obj.series.label+' Amount: '+percent+'%');
}

});

</script>
	<style type="text/css">
		* {
		  font-family: sans-serif;
		}
		
		body
		{
			padding: 0 1em 1em 1em;
			line-spacing: 0px;
		}
		
		div.graph
		{
			width: 400px;
			height: 300px;
			/*border: 1px dashed gainsboro;*/
		}
		
		label
		{
			display: block;
			margin-left: 400px;
			padding-left: 1em;
		}
		
		h2
		{
			padding-top: 1em;
			margin-bottom: 0;
			clear: both;
			color: #ccc;
		}
		
		code
		{
			display: block;
			background-color: #eee;
			border: 1px dashed #999;
			padding: 0.5em;
			margin: 0.5em;
			color: #666;
			font-size: 10pt;
		}
		
		code b
		{
			color: black;
		}
		
		ul
		{
			font-size: 10pt;
		}
		
		ul li
		{
			margin-bottom: 0.5em;
		}
		
		ul.options li
		{
			list-style: none;
			margin-bottom: 1em;
		}
		
		ul li i
		{
			color: #999;
		}
	
	</style>
<style type="text/css" media="print">
.printbutton {
  visibility: hidden;
  display: none;
}
</style>
<script>
document.write("<center><input type='button' " + "onClick='window.print()' " + "class='printbutton' " + "value='Print This Page'/></center><br /><br />");
</script>
	
 </head>
    <body>
	
	<?php include "reportheader.php"; ?>
<table align="center" border="0">
<tr>
 <td align="center"><strong><font color="#3e3276"></font></strong></td>
</tr>
<tr>
 <td align="center"><strong>From : </strong><?php echo date("d.m.Y",strtotime($fromdate)); ?><strong>To : </strong><?php echo date("d.m.Y",strtotime($todate)); ?></td>
</tr> 
<tr height="10px"></tr>
</table>

<center>
	<div id="graph1" style="float:left">
	<h3>schedule</h3>
    <div id="schedule" class="graph"></div><br>
	<!--<div><?php echo "Total Amount is "; ?></div><br>-->
	<div id="hover1"></div>
	</div>
</center>
 </body>
</html>

