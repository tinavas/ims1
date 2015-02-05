<?php include "config.php"; 
 $date11 = ceil((strtotime($_GET['todate']) - strtotime($_GET['fromdate']))/2505600) -1 ;
// echo strtotime($_GET['todate']) -  strtotime($_GET['fromdate']);
 
 $ts1 = strtotime($_GET['fromdate']);
$ts2 = strtotime($_GET['todate']);

$year1 = date('Y', $ts1);
$year2 = date('Y', $ts2);

$month1 = date('m', $ts1);
$month2 = date('m', $ts2);

 $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
 
 
 
$m[1]="January";
$m[2]="February";
$m[3]="March";
$m[4]="April";
$m[5]="May";
$m[6]="June";
$m[7]="July";
$m[8]="August";
$m[9]="September";
$m[10]="October";
$m[11]="November";
$m[12]="December";
$col = array('#FF0000','#006600','#660000','#9900CC','#990066','#006666','#993300','#0066FF','#999933','#330000','#330066','#CC0066','#6633FF','#6699FF');

$mon=json_encode($m);

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
	<link href="../../css/common1.css" type="text/css">
	
<script type="text/javascript">

function addCommas(nStr)
    {
		<?php if($_SESSION[millionformate]) { ?>
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
		<?php } else {?> 
		 nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{2})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
		<?php }?>
    }
var mon=<?php echo $mon;?>;
$(function () {
	//Graph - 3
	var data = [];
	var i = -1;
	<?php
	//$date2=date("Y-m-d",strtotime(date("Y-m")." -1 month"));
	$date3 = date("Y-m-d",strtotime($_GET['todate']));
	$date4 =date("Y-m-d",strtotime($_GET['fromdate']));
	$query = "SELECT sum( quantity ) AS result FROM `breeder_production` p  WHERE date1 between '$date4' and '$date3' AND p.client = '$client' and flock = '2-SH-17-6' ";
	$result = mysql_query($query,$conn1) or die(mysql_error());
	while($rows = mysql_fetch_assoc($result))
	{
		$tot=$rows['result'];
	}
	for($i=$diff;$i>=0;$i--)
	{
		$date1=date("Y-m-d",strtotime(date("Y-m")." -$i month"));
	$date = date("Y-m-d",strtotime("+1 month -1 second",strtotime($date1)));
	$t1=explode("-",$date1);
	$m1=$t1[1];
	$y1=$t1[0];
	$t2=explode("-",$date);
	$m2=$t2[1];
	$y2=$t2[0];
	$query = "SELECT sum( quantity ) AS result FROM `breeder_production` p  WHERE date1 between '$date1' and '$date' AND p.client = '$client' and flock = '2-SH-17-6' ";
	$result = mysql_query($query,$conn1) or die(mysql_error());
	while($rows = mysql_fetch_assoc($result))
	{
	 $tproduction += $rows['result'];
	 ?>
	 data[++i] = { label: mon[<?php echo $m1;?>]+"<?php echo '-'.$y1;?>", data:<?php echo round(($rows['result']/$tot)*100,2); ?> , color:"<?php echo $col[$i];?>"}
	 <?php
	}}
	?>
    $.plot($("#production"), data, 
	{
		series: {
			pie: { 
				show: true,
				radius: 1.0,
				label: {
					show: true,
					radius: .75,
					formatter: function(label, series){
						return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">'+label+'<br/>'+String(series.data).substr(2)+'</div>';
					},
					background: { 
						opacity: 0.5
					}
				}
			}
		},
		grid: {
            hoverable: true,
            clickable: true
        },
		 legend: {
			show: false
			}

	});
	
$("#production").bind("plothover", pieHover3);
$("#production").bind("plotclick", pieClick3);

function pieHover3(event, pos, obj) 
{
	if (!obj)
                return;
	percent = parseFloat(obj.series.percent).toFixed(2);
	 tot1=parseFloat(parseFloat(String(obj.series.data).substr(2))*<?php echo $tot;?>/100).toFixed(2);
	// tot=tot1.toLocaleString(); alert(tot1.toLocaleString());
	//alert(tot1);
	tot=addCommas(tot1);
	 $("#hover3").html('<span style="font-weight: bold;">'+obj.series.label+' Production :'+percent+'%(' + tot +')</span>');
}

function pieClick3(event, pos, obj) 
{
	if (!obj)
                return;
	percent = parseFloat(obj.series.percent).toFixed(2);
	alert(obj.series.label+' Production: '+percent+'%');
}



}); 

</script><link href="css/common.css" rel="stylesheet" type="text/css">
	<link href="css/standard.css" rel="stylesheet" type="text/css">
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
			height: 400px;
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
		
button,input[type=submit],input[type=reset],input[type=button],
.big-button {
	display: inline-block;
	border: 1px solid;
	border-color: #50a3c8 #297cb4 #083f6f;
	background: #0c5fa5 url(../../images/old-browsers-bg/button-element-bg.png) repeat-x left top;
	-webkit-background-size: 100% 100%;
	-moz-background-size: 100% 100%;
	-o-background-size: 100% 100%;
	background-size: 100% 100%;
	background: -moz-linear-gradient(
		top,
		white,
		#72c6e4 4%,
		#0c5fa5
	);
	background: -webkit-gradient(
		linear,
		left top, left bottom,
		from(white),
		to(#0c5fa5),
		color-stop(0.03, #72c6e4)
	);
	-moz-border-radius: 0.333em;
	-webkit-border-radius: 0.333em;
	-webkit-background-clip: padding-box;
	border-radius: 0.333em;
	color: white;
	-moz-text-shadow: 0 1px 2px rgba(0, 0, 0, 0.4);
	-webkit-text-shadow: 0 1px 2px rgba(0, 0, 0, 0.4);
	text-shadow: 0 1px 2px rgba(0, 0, 0, 0.4);
	-moz-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
	-webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
	box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
	font-size: 1.0em;
	padding: 0.286em 1em 0.357em;
	line-height: 1.429em;
	cursor: pointer;
	font-weight: bold;
	}
		
	</style>
<style type="text/css" media="print">
.printbutton {
  visibility: hidden;
  display: none;
}
#hover1 {
display:none;
}
#hover2 {
display:none;
}
#hover3 {
display:none;
}
#hover4 {
display:none;
}
#hover5 {
display:none;
}
</style>
 </head>
    <body>

<table align="center" border="0" style=" width:10px">
<tr><td  align="center">
	<div id="graph3" style="float:left;">
	<center><h4>Production Composition for flock 2-SH-17-6</h4></center>
    <div id="production" class="graph"></div><br>
    
	<div><?php include "getemployee.php"; echo "Total Production is". changequantity($tproduction); ?></div>
	<div id="hover3"></div>
	</div>

    </td>
</tr>
</table>
 </body>
</html>
