<?php include "config.php";
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
$from = $fy."-".$fm."-01";
$to = $fy1."-".$tm."-".date("t",strtotime($fy1.'-'.$tm.'-01'));
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Sales Comparision</title>
	<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="../excanvas.min.js"></script><![endif]-->
    <script language="javascript" type="text/javascript" src="../jquery.js"></script>
	<script language="javascript" type="text/javascript" src="../jquery.flot.js"></script>
    <script language="javascript" type="text/javascript" src="../jquery.flot.pie.js"></script>
	
<script type="text/javascript">
$(function () {
	var data = [];
	var i = -1;
	<?php
	 $query = "SELECT DISTINCT(cat) FROM ims_itemcodes WHERE code IN (SELECT code FROM oc_cobi WHERE date BETWEEN '$from' AND '$to') ORDER BY cat ASC";
	 $result = mysql_query($query,$conn1) or die(mysql_error());
	 while($rows = mysql_fetch_assoc($result))
	 {
	  $cat = $rows['cat'];
	  $ftotal = 0;
	  $query2 = "SELECT distinct(invoice),finaltotal FROM oc_cobi WHERE date BETWEEN '$from' AND '$to' AND code IN (SELECT distinct(code) FROM ims_itemcodes WHERE cat = '$cat' AND client = '$client') AND client = '$client'";
	  $result2 = mysql_query($query2,$conn1) or die(mysql_error());
	  $numrows = mysql_num_rows($result2);
	  if($numrows > 0)
	  {
	   while($rows2 = mysql_fetch_assoc($result2))
	    $ftotal += $rows2['finaltotal'];
		?>
		data[++i] = { label: "<?php echo $cat; ?>", data: <?php echo $ftotal; ?> }
		<?php
	  }
	 }
	?>

	// sales
    $.plot($("#sales"), data, 
	{
		series: {
			pie: { 
				show: true
			}
		},
		grid: {
            hoverable: true,
            clickable: true
        }

	});
	
$("#sales").bind("plothover", pieHover);
$("#sales").bind("plotclick", pieClick);
function pieHover(event, pos, obj) 
{
	if (!obj)
                return;
	//var temp = obj.series.data;
	//alert(temp);
	percent = parseFloat(obj.series.percent).toFixed(2);
	$("#hover1").html('<span style="font-weight: bold; color: '+obj.series.color+'">'+obj.series.label+'-'+percent+'%(' + changeprice(Number(String(obj.series.data).substr(2))) +')</span>');
}

function pieClick(event, pos, obj) 
{
	if (!obj)
                return;
	percent = parseFloat(obj.series.percent).toFixed(2);
	alert(obj.series.label+'-'+percent+'%');
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Sales Comparision</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong>From : </strong><?php echo $mon; ?><strong> To : </strong><?php echo $mon1; ?></td>
</tr> 
<tr height="10px"></tr>
</table>

	<center>
    <div id="sales" class="graph"></div><br>
	<div id="hover1"></div>
	</center>
 </body>
</html>
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
