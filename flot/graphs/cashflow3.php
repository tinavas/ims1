<?php include "config.php"; 
if($_GET['todate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate = date("Y-m-d"); 
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


$(function () {
	//Graph - 3
	var data = [];
	var i = -1;
	
	/////////////////////// start of
	<?php
	
		
$query = "select socobi,sum(amountreceived) as amount from oc_receipt where  (choice = 'COBIs' or choice = 'CDN')  and flag = 1  group by socobi";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
$pendingso[$res['socobi']] = $res['amount'];




$query = "select cobicdn,sum(clearingamount) as amount from oc_cobiclearance where (choice = 'COBIs' or choice = 'Debit Notes')  group by cobicdn";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
$pendingso[$res['cobicdn']] += $res['amount'];

$query = "select cobi,sum(cretqty * rate) as amount from oc_salesreturn  group by cobi";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
$pendingso[$res['cobi']] += $res['amount'];


$q1 = "select * from contactdetails  where type='vendor and party' or type ='party'  order by name";
	$quers1 = mysql_query($q1,$conn1) or die(mysql_error());
	while($row11 = mysql_fetch_assoc($quers1))
	{
	$ca = $row11['ca'];
//$sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = $sum7 = $sum8 = 0;
$query = "SELECT date,trnum,amount AS finaltotal,type FROM ac_financialpostings WHERE date <= '$todate' AND venname = '$row11[name]' AND crdr = 'Dr' AND coacode = '$ca' and trnum not in (select socobi from oc_receipt where balance = 0  and (choice = 'COBIs' or choice = 'CDN') and flag = 1 )   ORDER BY date,id";


$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $pamount = $rows['finaltotal'];
 
 if($pamount <= $bal)
  $bal -= $pamount;
 else
{
if($bal > 0)
 $balamt = ($pamount - $bal);
else
 $balamt = $pamount;
 $bal = 0;
$pdate = $rows['date'];
$difdays = round(((strtotime($todate) - strtotime($pdate)) / (24 * 60 * 60)),0);
$balamt -= $pendingso[$rows['trnum']];
 ?>
 //alert("<?php echo $difdays.'-'.$todate.'-'.$pdate.'-'.$rows['trnum']; ?>");
 <?php
 if( $balamt > 0 )
 {
	if ($difdays < 16) 
	{
		$sum1+=$balamt;	
	}
	if (($difdays > 15) and ($difdays < 31 ))
	{
		 $sum2+=$balamt;
	}
	if (($difdays > 30) and ($difdays < 61 ))
	{
		$sum3+=$balamt;
	}
	if (($difdays > 60) and ($difdays < 91 ))
	{
		 $sum4+=$balamt;
	}
	if (($difdays > 90) and ($difdays < 121 ))
	{
		$sum5+=$balamt;
	}
	if (($difdays > 120) and ($difdays < 151 ))
	{
		$sum6+=$balamt;
	}
		
	if (($difdays > 150) and ($difdays < 181 ))
	{
		$sum7+=$balamt;
	}
				
	if (($difdays > 180))
	{
		 $sum8+=$balamt;
	}
			
	}	
}

}
?>
//alert("<?php echo $sum1.'-'.$sum2.'-'.$sum3.'-'.$sum4.'-'.$sum5.'-'.$sum6.'-'.$sum7.'-'.$sum8.'-'.$row11['name'] ?>");
<?php
}

$tot1 = $sum1 + $sum2 + $sum3 + $sum4 + $sum5 + $sum6 + $sum7 + $sum8;

	
	?>
	//alert("<?php echo $sum1.'-'.$sum2.'-'.$sum3.'-'.$sum4.'-'.$sum5.'-'.$sum6.'-'.$sum7.'-'.$sum8 ?>");
	 data[++i] = { label: "<?php echo '0 To 15 Days' ?>", data:<?php echo round($sum1,2);?>  , color:"#6600FF" }
	 data[++i] = { label: "<?php echo '16 To 30 Days' ?>", data:<?php echo round($sum2,2); ?> , color:"#FF00FF" }
	 data[++i] = { label: "<?php echo '31 To 60 Days' ?>", data:<?php echo round($sum3,2); ?> , color:"#006600" }
	 data[++i] = { label: "<?php echo '61 To 90 Days' ?>", data:<?php echo round($sum4,2); ?>  , color:"#FF0099"}
	 data[++i] = { label: "<?php echo '91 To 120 Days' ?>", data:<?php echo round($sum5,2); ?>  , color:"#0000FF"}
	 data[++i] = { label: "<?php echo '121 To 150 Days' ?>", data:<?php echo round($sum6,2); ?>  , color:"#00FF00"}
	 data[++i] = { label: "<?php echo '151 To 180 Days' ?>", data:<?php echo round($sum7,2); ?> , color:"#FF0000" }
	 data[++i] = { label: "<?php echo '181 Days And More' ?>", data:<?php echo round($sum8,2); ?> , color:"#660000" }
	 <?php
	
	
	
	
	
	
	
	
	?>
	
	
	
	
	//////////
	
	
	
	
	
    $.plot($("#production"), data, 
	{
		series: {
			pie: { 
				show: true,
				radius: 1.0,
				label: {}
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
//alert(obj);
	if (!obj)
                return;
	percent = parseFloat(obj.series.percent).toFixed(2);

	 tot1=parseFloat(String(obj.series.data).substr(2));
	 tot=addCommas(tot1);
	$("#hover3").html('<span style="font-weight: bold; color: '+obj.series.color+'">No Of Days :'+obj.series.label+'<br> Amount :'+percent+'%(' + tot +')</span>');
}

function pieClick3(event, pos, obj) 
{
	if (!obj)
                return;
	percent = parseFloat(obj.series.percent).toFixed(2);
	
	alert('No Of Days'+obj.series.label+' Amount: '+percent+'%');
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
			margin-left: 100px;
			padding-left: 100em;
			
			
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

<table align="center" border="0" style=" width:100px">
<tr>
 <td align="center"><strong><font color="#3e3276">Customer Ageing Analysis Graph</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>

</tr>
<tr><td  align="center">
	<div id="graph3" style="float:left; ">
    <div id="production" class="graph" ></div><br>
	<div><?php include "getemployee.php"; echo "Total Balance is ". changequantity($tot1); ?></div>
	<div id="hover3"></div>
	</div>

    </td>
</tr>
</table>
 </body>
</html>

