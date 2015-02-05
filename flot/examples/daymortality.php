<?php include "config.php"; 
$unit = $_GET['unit']; ?>
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
	$date = date("Y-m-d",strtotime($_GET['date']));
	$query = "SELECT distinct(flock),fmort FROM breeder_consumption c,breeder_flock f WHERE date2 = '$date' AND flock = flockcode AND (fmort > 0) AND c.client = '$client' AND flock IN (SELECT distinct(flockcode) FROM breeder_flock WHERE unitcode = '$unit') ORDER BY flkmain";
	$result = mysql_query($query,$conn1) or die(mysql_error());
	while($rows = mysql_fetch_assoc($result))
	{
	 $tmortality += $rows['fmort'];
	 ?>
	 data[++i] = { label: "<?php echo $rows['flock']; ?>", data:<?php echo $rows['fmort']; ?> }
	 <?php
	}
	?>
		//data[i] = { label: "Series"+(i+1), data: Math.floor(Math.random()*100)+1 }

	// mortality
    $.plot($("#mortality"), data, 
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
	
$("#mortality").bind("plothover", pieHover);
$("#mortality").bind("plotclick", pieClick);
function pieHover(event, pos, obj) 
{
	if (!obj)
                return;
	//var temp = obj.series.data;
	//alert(temp);
	percent = parseFloat(obj.series.percent).toFixed(2);
	$("#hover1").html('<span style="font-weight: bold; color: '+obj.series.color+'">Flock :'+obj.series.label+' Female Mortality :'+percent+'%(' + String(obj.series.data).substr(2) +')</span>');
}

function pieClick(event, pos, obj) 
{
	if (!obj)
                return;
	percent = parseFloat(obj.series.percent).toFixed(2);
	alert('Flock '+obj.series.label+' Female Mortality: '+percent+'%');
}

	//Second Graph
	var data = [];
	var i = -1;
	<?php
	$date = date("Y-m-d",strtotime($_GET['date']));
	$query2 = "SELECT sum( quantity ) AS consumption, SUM( femaleopening) AS sumbirds, flock FROM `breeder_consumption` , breeder_flock WHERE flock = flockcode AND date2 = '$date' AND unitcode = '$unit' AND itemcode IN (SELECT code FROM ims_itemcodes WHERE cat = 'Female Feed')GROUP BY FLOCK ORDER BY flkmain";
	$result2 = mysql_query($query2,$conn1) or die(mysql_error());
	while($rows2 = mysql_fetch_assoc($result2))
	{
$flock = $rows2['flock'];	
$bal = $rows2['sumbirds'];	
$query = "SELECT sum(quantity) as trout FROM ims_stocktransfer WHERE fromwarehouse = '$flock' AND (cat = 'Female Birds') AND date < '$date' and client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$bal -= $rows['trout'];

$query = "SELECT sum(quantity) as trin FROM ims_stocktransfer WHERE towarehouse = '$flock' AND (cat = 'Female Birds') AND date < '$date' and client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$bal += $rows['trin'];

$query = "SELECT sum(quantity) as sales FROM oc_cobi WHERE flock = '$flock' AND code in (select distinct(code) from ims_itemcodes where (cat = 'Female Birds')) AND date < '$date' and client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$bal -= $rows['sales'];

$query = "SELECT distinct(date2),fmort,fcull  FROM breeder_consumption WHERE flock = '$flock' AND date2 < '$date' AND client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $bal -= ($rows['fmort'] + $rows['fcull']);
}
$result = round(($rows2['consumption'] * 1000/ $bal),2);
$tconsumed += $rows2['consumption'];
$tbirds += $bal;
	 ?>
	 data[++i] = { label: "<?php echo $flock; ?>", data:<?php echo $result; ?> }
	 <?php
	}
	?>
    $.plot($("#consumed"), data, 
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
        }

	});
	
$("#consumed").bind("plothover", pieHover2);
$("#consumed").bind("plotclick", pieClick2);


function pieHover2(event, pos, obj) 
{
	if (!obj)
                return;
				
	percent = parseFloat(obj.series.percent).toFixed(2);
	$("#hover2").html('<span style="font-weight: bold; color: '+obj.series.color+'">Flock :'+obj.series.label+' Female Feed Con./Bird :'+percent+'%(' + String(obj.series.data).substr(2) +')</span>');
}

function pieClick2(event, pos, obj) 
{
	if (!obj)
                return;
	percent = parseFloat(obj.series.percent).toFixed(2);
	alert('Flock '+obj.series.label+' Female Feed Consumed/Bird: '+percent+'%');
}


	//Graph - 5
	var data = [];
	var i = -1;
	<?php
	$date = date("Y-m-d",strtotime($_GET['date']));
	$query2 = "SELECT sum( quantity ) AS consumption, SUM( maleopening) AS sumbirds, flock FROM `breeder_consumption` , breeder_flock WHERE flock = flockcode AND date2 = '$date' AND unitcode = '$unit' AND itemcode IN (SELECT code FROM ims_itemcodes WHERE cat = 'Male Feed')GROUP BY FLOCK ORDER BY flkmain";
	$result2 = mysql_query($query2,$conn1) or die(mysql_error());
	while($rows2 = mysql_fetch_assoc($result2))
	{
$flock = $rows2['flock'];	
$bal = $rows2['sumbirds'];	
$query = "SELECT sum(quantity) as trout FROM ims_stocktransfer WHERE fromwarehouse = '$flock' AND (cat = 'Male Birds') AND date < '$date' and client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$bal -= $rows['trout'];

$query = "SELECT sum(quantity) as trin FROM ims_stocktransfer WHERE towarehouse = '$flock' AND (cat = 'Male Birds') AND date < '$date' and client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$bal += $rows['trin'];

$query = "SELECT sum(quantity) as sales FROM oc_cobi WHERE flock = '$flock' AND code in (select distinct(code) from ims_itemcodes where (cat = 'Male Birds')) AND date < '$date' and client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$bal -= $rows['sales'];

$query = "SELECT distinct(date2),mmort,mcull  FROM breeder_consumption WHERE flock = '$flock' AND date2 < '$date' AND client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $bal -= ($rows['mmort'] + $rows['mcull']);
}
$result = round(($rows2['consumption'] * 1000/ $bal),2);
$tmconsumed += $rows2['consumption'];
$tmbirds += $bal;
	 ?>
	 data[++i] = { label: "<?php echo $flock; ?>", data:<?php echo $result; ?> }
	 <?php
	}
	?>
    $.plot($("#mconsumed"), data, 
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
        }

	});
	
$("#mconsumed").bind("plothover", pieHover5);
$("#mconsumed").bind("plotclick", pieClick5);


function pieHover5(event, pos, obj) 
{
	if (!obj)
                return;
				
	percent = parseFloat(obj.series.percent).toFixed(2);
	$("#hover5").html('<span style="font-weight: bold; color: '+obj.series.color+'">Flock :'+obj.series.label+' Male Feed Con./Bird :'+percent+'%(' + String(obj.series.data).substr(2) +')</span>');
}

function pieClick5(event, pos, obj) 
{
	if (!obj)
                return;
	percent = parseFloat(obj.series.percent).toFixed(2);
	alert('Flock '+obj.series.label+' Male Feed Consumed/Bird: '+percent+'%');
}

	//Graph - 3
	var data = [];
	var i = -1;
	<?php
	$date = date("Y-m-d",strtotime($_GET['date']));

	$query = "SELECT sum( quantity ) AS result, flock FROM `breeder_production` p ,breeder_flock WHERE date1 = '$date' AND flock = flockcode AND p.client = '$client' AND flock IN (SELECT distinct(flockcode) FROM breeder_flock WHERE unitcode = '$unit') GROUP BY flock HAVING result >0 ORDER BY flkmain";
	$result = mysql_query($query,$conn1) or die(mysql_error());
	while($rows = mysql_fetch_assoc($result))
	{
	 $tproduction += $rows['result'];
	 ?>
	 data[++i] = { label: "<?php echo $rows['flock']; ?>", data:<?php echo $rows['result']; ?> }
	 <?php
	}
	?>
    $.plot($("#production"), data, 
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
        }

	});
	
$("#production").bind("plothover", pieHover3);
$("#production").bind("plotclick", pieClick3);

function pieHover3(event, pos, obj) 
{
	if (!obj)
                return;
	percent = parseFloat(obj.series.percent).toFixed(2);
	$("#hover3").html('<span style="font-weight: bold; color: '+obj.series.color+'">Flock :'+obj.series.label+' Production :'+percent+'%(' + String(obj.series.data).substr(2) +')</span>');
}

function pieClick3(event, pos, obj) 
{
	if (!obj)
                return;
	percent = parseFloat(obj.series.percent).toFixed(2);
	alert('Flock '+obj.series.label+' Production: '+percent+'%');
}

	//Graph - 4
	var data = [];
	var i = -1;
	<?php
	$date = date("Y-m-d",strtotime($_GET['date']));
	$query2 = "SELECT sum( quantity ) AS production, SUM( femaleopening) AS sumbirds, flock FROM `breeder_production` , breeder_flock WHERE flock = flockcode AND unitcode = '$unit' AND date1 = '$date' AND itemcode IN (SELECT code FROM ims_itemcodes WHERE cat = 'Eggs') AND breeder_production.client = '$client' GROUP BY FLOCK ORDER BY flkmain";
	$result2 = mysql_query($query2,$conn1) or die(mysql_error());
	while($rows2 = mysql_fetch_assoc($result2))
	{
$flock = $rows2['flock'];	
$bal = $rows2['sumbirds'];	
$query = "SELECT sum(quantity) as trout FROM ims_stocktransfer WHERE fromwarehouse = '$flock' AND (cat = 'Female Birds') AND date < '$date' and client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$bal -= $rows['trout'];

$query = "SELECT sum(quantity) as trin FROM ims_stocktransfer WHERE towarehouse = '$flock' AND (cat = 'Female Birds') AND date < '$date' and client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$bal += $rows['trin'];

$query = "SELECT sum(quantity) as sales FROM oc_cobi WHERE flock = '$flock' AND code in (select distinct(code) from ims_itemcodes where (cat = 'Female Birds')) AND date < '$date' and client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$bal -= $rows['sales'];

$query = "SELECT distinct(date2),fmort,fcull  FROM breeder_consumption WHERE flock = '$flock' AND date2 < '$date' AND client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $bal -= ($rows['fmort'] + $rows['fcull']);
}
$result = round(($rows2['production'] / $bal),2);	
$teggbird += $rows2['production'];
$teggobirds += $bal;	
	 ?>
	 data[++i] = { label: "<?php echo $flock; ?>", data:<?php echo $result; ?> }
	 <?php
	}
	?>
    $.plot($("#eggbird"), data, 
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
        }

	});
	
$("#eggbird").bind("plothover", pieHover4);
$("#eggbird").bind("plotclick", pieClick4);


function pieHover4(event, pos, obj) 
{
	if (!obj)
                return;
	percent = parseFloat(obj.series.percent).toFixed(2);
	$("#hover4").html('<span style="font-weight: bold; color: '+obj.series.color+'">Flock :'+obj.series.label+' Egg/Bird :'+percent+'%(' + String(obj.series.data).substr(2) +')</span>');
}

function pieClick4(event, pos, obj) 
{
	if (!obj)
                return;
	percent = parseFloat(obj.series.percent).toFixed(2);
	alert('Flock '+obj.series.label+' Egg/Bird: '+percent+'%');
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
 </head>
    <body>
	<?php include "reportheader.php"; ?>
<table align="center" border="0">
<tr>
 <td align="center"><strong><font color="#3e3276">Day wise Performance</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td align="center"><strong>Unit : </strong><?php echo $unit; ?></td>
</tr> 
<tr height="5px"></tr>
<tr>
 <td align="center"><strong>Date : </strong><?php echo date("d.m.Y",strtotime($date)); ?></td>
</tr> 
<tr height="10px"></tr>
</table>

	<center>
	<div id="graph1" style="float:left">
	<h3>Mortality</h3>
    <div id="mortality" class="graph"></div><br>
	<div><?php echo "Total Female Mortality is $tmortality"; ?></div><br>
	<div id="hover1"></div>
	</div>
	<div id="graph2" style="float:left">
	<h3>Female Feed Consumed/Bird</h3>
    <div id="consumed" class="graph"></div><br>
	<div><?php echo "Total Female Feed Con./Bird is ".round($tconsumed * 1000/$tbirds); ?></div><br>
	<div id="hover2">&nbsp;</div>
	</div><br><br><br>
	<div id="graph5" style="float:left">
	<h3>Male Feed Consumed/Bird</h3>
    <div id="mconsumed" class="graph"></div><br>
	<div><?php echo "Total Male Feed Con./Bird is ".round($tmconsumed * 1000/$tmbirds); ?></div><br>
	<div id="hover5">&nbsp;</div>
	</div>
	<div id="graph3" style="float:left;">
	<h3>Production</h3>
    <div id="production" class="graph"></div><br>
	<div><?php echo "Total Production is $tproduction"; ?></div><br>
	<div id="hover3"></div>
	</div><br><br><br>
	<div id="graph4" style="float:left;">
	<h3>Egg/Bird</h3>
    <div id="eggbird" class="graph"></div><br>
	<div><?php echo "Total Egg/Bird is ".round(($teggbird/$teggobirds),2); ?></div><br>
	<div id="hover4"></div>
	</div>
	</center>
 </body>
</html>

