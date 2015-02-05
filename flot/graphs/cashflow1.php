<?php

$fromdate = date("Y-m-d",strtotime($_GET['fromdate']));

$todate = date("Y-m-d",strtotime($_GET['todate']));

 include "config.php";  ?>

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

$inflow = 0;	

$query1 = "SELECT distinct(schedule) FROM ac_coa WHERE client = '$client' ORDER BY schedule";

$result1 = mysql_query($query1,$conn1) or die(mysql_error());

while($rows1 = mysql_fetch_assoc($result1))

{ 

 $cramount = $dramount = 0; $displaycrdr = "";

 $query2 = "SELECT SUM(amount) as amount FROM ac_financialpostings WHERE crdr = 'Cr' and (cash ='YES' or bank ='YES') AND client = '$client' AND schedule = '$rows1[schedule]' AND date BETWEEN '$fromdate' AND '$todate'and coacode NOT IN (SELECT code FROM ac_coa WHERE controltype IN ('Cash','Bank') and client = '$client')";

 $result2 = mysql_query($query2,$conn1) or die(mysql_error());

 while($rows2 = mysql_fetch_assoc($result2))

 {

  $amount = $rows2['amount'];

  if($amount > 0)

  {  $inflow += $amount;

	 ?>

	 data[++i] = { label: "<?php echo $rows1['schedule']; ?>", data:<?php echo $rows2['amount']; ?> }

	 <?php

  }	 

 }

}

?>	

	

	

	// inflow

    $.plot($("#inflow"), data, 

	{

		series: {

			pie: { 

				show: true,

				radius: 0.8,

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

	

$("#inflow").bind("plothover", pieHover);

$("#inflow").bind("plotclick", pieClick);

function pieHover(event, pos, obj) 

{

	if (!obj)

                return;

	//var temp = obj.series.data;

	//alert(temp);

	percent = parseFloat(obj.series.percent).toFixed(2);

	$("#hover1").html('<span style="font-weight: bold; color: '+obj.series.color+'">Schedule :'+obj.series.label+'<br> Amount :'+percent+'%(' + changeprice(Number(String(obj.series.data).substr(2))) +')</span>');

}



function pieClick(event, pos, obj) 

{

	if (!obj)

                return;

	percent = parseFloat(obj.series.percent).toFixed(2);

	alert('Schedule '+obj.series.label+' Amount: '+percent+'%');

}



	//Second Graph

	var data = [];

	var i = -1;

	<?php

$outflow = 0;

$query1 = "SELECT distinct(schedule) FROM ac_coa WHERE client = '$client' ORDER BY schedule";

$result1 = mysql_query($query1,$conn1) or die(mysql_error());

while($rows1 = mysql_fetch_assoc($result1))

{ 

 $cramount = $dramount = 0; $displaycrdr = "";

 $query2 = "SELECT SUM(amount) as amount FROM ac_financialpostings WHERE crdr = 'Dr' and (cash ='YES' or bank ='YES') AND client = '$client' AND schedule = '$rows1[schedule]' AND date BETWEEN '$fromdate' AND '$todate'and coacode NOT IN (SELECT code FROM ac_coa WHERE controltype IN ('Cash','Bank') and client = '$client')";

 $result2 = mysql_query($query2,$conn1) or die(mysql_error());

 while($rows2 = mysql_fetch_assoc($result2))

 {

  $amount = $rows2['amount'];

  if($amount > 0)

  {  $outflow += $amount;

	 ?>

	 data[++i] = { label: "<?php echo $rows1['schedule']; ?>", data:<?php echo $amount; ?> }

	 <?php

  }	 

 }

}

?>	

/*    $.plot($("#outflow"), data, 

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



	}); */

    $.plot($("#outflow"), data, 

	{

		series: {

			pie: { 

				show: true,

				radius: 0.8,

			}

		},

		grid: {

            hoverable: true,

            clickable: true

        },

		legend: {

		 	show: true

		}	



	});

	

$("#outflow").bind("plothover", pieHover2);

$("#outflow").bind("plotclick", pieClick2);





function pieHover2(event, pos, obj) 

{

	if (!obj)

                return;

				

	percent = parseFloat(obj.series.percent).toFixed(2);

	$("#hover2").html('<span style="font-weight: bold; color: '+obj.series.color+'">Schedule :'+obj.series.label+'<br> Amount :'+percent+'%(' + changeprice(Number(String(obj.series.data).substr(2))) +')</span>');

}



function pieClick2(event, pos, obj) 

{

	if (!obj)

                return;

	percent = parseFloat(obj.series.percent).toFixed(2);

	alert('Schedule '+obj.series.label+' Amount: '+percent+'%');

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

button,input[type=submit],input[type=reset],input[type=button],

.big-button {

	display: inline-block;

	border: 1px solid;

	border-color: #50a3c8 #297cb4 #083f6f;

	background: #0c5fa5 url(../images/old-browsers-bg/button-element-bg.png) repeat-x left top;

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

	font-size: 1em;

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



</style>

<script>

document.write("<center><input type='button' " + "onClick='window.print()' " + "class='printbutton' " + "value='Print'/></center><br /><br />");

</script>

 </head>

    <body>

	<?php //include "reportheader.php"; ?>

<table align="center" border="0">

<tr>

 <td align="center"><strong><font color="#3e3276">Cash Flow Graph</font></strong></td>

</tr>

<tr height="5px"></tr>

<tr>

 <td align="center"><strong>From : </strong><?php echo date("d.m.Y",strtotime($fromdate)); ?>&nbsp;&nbsp;<strong>Date : </strong><?php echo date("d.m.Y",strtotime($todate)); ?></td>

</tr> 

<tr height="10px"></tr>

</table>



	<center>

	<div id="graph1" style="float:left">

	<h3>In Flow</h3>

    <div id="inflow" class="graph"></div><br>

	<div><?php echo "Total InFlow ".changeprice($inflow); ?></div><br>

	<div id="hover1"></div>

	</div>

	<div id="graph2" style="float:left">

	<h3>Out Flow</h3>

    <div id="outflow" class="graph"></div><br>

	<div><?php echo "Total OutFlow ".changeprice($outflow); ?></div><br>

	<div id="hover2">&nbsp;</div>

	</div><br><br><br>

	

	</center>

 </body>

</html>



<?php



function changeprice($num){

$pos = strpos((string)$num, ".");

if ($pos === false) { $decimalpart="00";}

else { $decimalpart= substr($num, $pos+1, 2); $num = substr($num,0,$pos); }



if(strlen($num)>3 & strlen($num) <= 12){

$last3digits = substr($num, -3 );

$numexceptlastdigits = substr($num, 0, -3 );

$formatted = makecomma($numexceptlastdigits);

$stringtoreturn = $formatted.",".$last3digits.".".$decimalpart ;

}elseif(strlen($num)<=3){

$stringtoreturn = $num.".".$decimalpart ;

}elseif(strlen($num)>12){

$stringtoreturn = number_format($num, 2);

}



if(substr($stringtoreturn,0,2)=="-,"){$stringtoreturn = "-".substr($stringtoreturn,2 );}

$a  = explode('.',$stringtoreturn);

$c = "";

if(strlen($a[1]) < 2) { $c = "0"; }

$stringtoreturn = $stringtoreturn.$c;

return $stringtoreturn;

}



function makecomma($input)

{

if(strlen($input)<=2)

{ return $input; }

$length=substr($input,0,strlen($input)-2);

$formatted_input = makecomma($length).",".substr($input,-2);

return $formatted_input;

}

?>

<script type="text/javascript">

var decimalpart;

function makecomma(input)

{

 input = Number(input);

 if(input < 100)

  return input;

 var length = Math.floor(input/100);

 var formatted_input = makecomma(length) + "," + String(input).substr((String(input).length-2));

 return formatted_input;

}



function changeprice(num)

{

var pos = String(num).lastIndexOf('.');

if(pos == -1)

{

 decimalpart = "00";

 num = String(num);

}

else

{

 decimalpart = String(num).substr(pos+1,2);

 num = String(num).substr(0,pos);

}

if(num.length > 3)

{

 var last3digits = num.substr(num.length-3);

 var numexceptlastdigits = Math.floor(Number(num)/1000);

 var formatted = makecomma(numexceptlastdigits);

 var stringtoreturn = formatted + "," + last3digits + "." + String(decimalpart);

}

else if(num.length <= 3)

 var stringtoreturn = String(num) + "." + String(decimalpart);

return stringtoreturn;

}



</script>

