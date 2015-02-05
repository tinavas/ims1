<?php $time = microtime(); $time = explode(" ", $time); $time = $time[1] + $time[0]; $start = $time; ?>
<?php
$cvdate = $_POST['cvdate'];
$cvdate1 = $_POST['cvdate'];
$cvdate = date("Y-m-j", strtotime($cvdate));
$flock = $_POST['flock'];
$age = $_POST['age'];

$weight1 = $_POST['weight1'];
$num1 = $_POST['num1'];
$weight2 = $_POST['weight2'];
$num2 = $_POST['num2'];
$weight3 = $_POST['weight3'];
$num3 = $_POST['num3'];
$weight4 = $_POST['weight4'];
$num4 = $_POST['num4'];
$weight5 = $_POST['weight5'];
$num5 = $_POST['num5'];
$weight6 = $_POST['weight6'];
$num6 = $_POST['num6'];
$weight7 = $_POST['weight7'];
$num7 = $_POST['num7'];
$weight8 = $_POST['weight8'];
$num8 = $_POST['num8'];
$weight9 = $_POST['weight9'];
$num9 = $_POST['num9'];
$weight10 = $_POST['weight10'];
$num10 = $_POST['num10'];
$weight11 = $_POST['weight11'];
$num11 = $_POST['num11'];
$numerator = 0;
$sum = 0;
$numb = 0;
$total = 0;
$sum = $num1 + $num2 + $num3 + $num4 + $num5 + $num6 + $num7 + $num8 + $num9 + $num10 + $num11;
$numerator = ((($weight6 - $weight1) * ($weight6 - $weight1)) * $num1) + 
             ((($weight6 - $weight2) * ($weight6 - $weight2)) * $num2) +
             ((($weight6 - $weight3) * ($weight6 - $weight3)) * $num3) +
             ((($weight6 - $weight4) * ($weight6 - $weight4)) * $num4) +
             ((($weight6 - $weight5) * ($weight6 - $weight5)) * $num5) +
             ((($weight6 - $weight7) * ($weight6 - $weight7)) * $num7) +
	         ((($weight6 - $weight8) * ($weight6 - $weight8)) * $num8) +
	         ((($weight6 - $weight9) * ($weight6 - $weight9)) * $num9) +
			 ((($weight6 - $weight10) * ($weight6 - $weight10)) * $num10) +
			 ((($weight6 - $weight11) * ($weight6 - $weight11)) * $num11) ;
$denominator = $num1 + $num2 + $num3 + $num4 + $num5 + $num6 + $num7 + $num8 + $num9 + $num10 + $num11;
  $numb = max($num1,$num2,$num3,$num4,$num5,$num6,$num7,$num8,$num9,$num10,$num11);
$cv = ((sqrt(($numerator/$denominator)))/($weight6)) * 100;

include "config.php";
$query = "INSERT INTO cvanalysis (cvdate,flock,age,
                                  weight1,weight2,weight3,weight4,weight5,avgweight,weight7,weight8,weight9,weight10,weight11,
                                 num1,num2,num3,num4,num5,num6,num7,num8,num9,num10,num11,total,cv)
                         VALUES ('".$cvdate."','".$flock."','".$age."','".$weight1."','".$weight2."','".$weight3."','".$weight4."','".$weight5."','".$weight6."',
						         '".$weight7."','".$weight8."','".$weight9."','".$weight10."','".$weight11."',
						        '".$num1."','".$num2."','".$num3."','".$num4."','".$num5."',
					            '".$num6."','".$num7."','".$num8."','".$num9."','".$num10."','".$num11."','".$sum."','".$cv."')" 
							  or die(mysql_error());
		
    $get_entriess_res5 = mysql_query($query,$conn) or die(mysql_error());


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>C.V.Analysis</title>
<link type="text/css" rel="stylesheet" href="dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></link>
<script type="text/javascript" src="dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
<style type="text/css">
body{font-family:"Lucida Sans Unicode", "Lucida Grande", Verdana, Arial, Helvetica, sans-serif; font-size:12px; color:#555555;}
div.main{margin:30px auto; overflow:auto; width:700px;}
table.sortable{border:0; padding:0; margin:0;}
table.sortable td{padding:4px; width:120px; border-bottom:solid 1px #DEDEDE;}
table.sortable th{padding:4px;}
table.sortable thead{background:#e3edef; color:#333333; text-align:left;}
table.sortable tfoot{font-weight:bold; }
table.sortable tfoot td{border:none;}
</style>

</head>
<body bgcolor="#ECF1F5">
<?php include "commonheader.php"; ?>
<center><h3><b>C.V.Analysis</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3></center>
<form name="cvgraphInsert" id="cvgraphInsert">
<input type="hidden" name="date" id="date" value="<?php echo $_GET['date']; ?>" />
<input type="hidden" name="flock" id="flock" value="<?php echo $_GET['flock']; ?>" />
<!--<div align="center"  id="paraIDTop" style=" visibility:visible; overflow: auto;height: 350px;padding-left:3px" >-->
<center>
<table width="487" border="1">
  <thead>
    <tr>
      <th width="102" style="text-align:left">Weight<font size="1px">(in grams)</font></th>
	  <th width="86" style="text-align:left">Weight<font size="1px">(in kgs)</font></th>
      <th width="82" style="text-align:left">No. Of Birds</th><?php for($i=0;$i<$numb;$i++) { ?><th width="75"></th><?php } ?>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?php echo $weight1; ?></td>
	  <td><?php echo round($weight1/1000,2); ?></td>
      <td><?php echo $num1; ?></td>
	  <?php for($i=0;$i<$num1;$i++) { ?><td>X</td><?php }  ?>
	  <?php for($i=$num1;$i<$numb;$i++) { ?><td></td><?php }  ?>
    </tr>
	<tr>
      <td><?php echo $weight2; ?></td>
	  <td><?php echo round($weight2/1000,2); ?></td>
      <td><?php echo $num2; ?></td>
	  <?php for($i=0;$i<$num2;$i++) { ?><td>X</td><?php } ?>
	  <?php for($i=$num2;$i<$numb;$i++) { ?><td></td><?php }  ?>
    </tr>
	<tr>
      <td><?php echo $weight3; ?></td>
	  <td><?php echo round($weight3/1000,2); ?></td>
      <td><?php echo $num3; ?></td>
	  <?php for($i=0;$i<$num3;$i++) { ?><td>X</td><?php } ?>
	  <?php for($i=$num3;$i<$numb;$i++) { ?><td></td><?php }  ?>
    </tr>
	<tr>
      <td><?php echo $weight4; ?></td>
	  <td><?php echo round($weight4/1000,2); ?></td>
      <td><?php echo $num4; ?></td>
	  <?php for($i=0;$i<$num4;$i++) { ?><td>X</td><?php } ?>
	  <?php for($i=$num4;$i<$numb;$i++) { ?><td></td><?php }  ?>
    </tr>
	<tr>
      <td><?php echo $weight5; ?></td>
	  <td><?php echo round($weight5/1000,2); ?></td>
      <td><?php echo $num5; ?></td>
	  <?php for($i=0;$i<$num5;$i++) { ?><td>X</td><?php } ?>
	  <?php for($i=$num5;$i<$numb;$i++) { ?><td></td><?php }  ?>
    </tr>
	<tr>
      <td><?php echo $weight6; ?></td>
	  <td><?php echo round($weight6/1000,2); ?></td>
      <td><?php echo $num6; ?></td>
	  <?php for($i=0;$i<$num6;$i++) { ?><td>X</td><?php } ?>
	  <?php for($i=$num6;$i<$numb;$i++) { ?><td></td><?php }  ?>
    </tr>
	<tr>
      <td><?php echo $weight7; ?></td>
	  <td><?php echo round($weight7/1000,2); ?></td>
      <td><?php echo $num7; ?></td>
	  <?php for($i=0;$i<$num7;$i++) { ?><td>X</td><?php } ?>
	  <?php for($i=$num7;$i<$numb;$i++) { ?><td></td><?php }  ?>
    </tr>
	<tr>
      <td><?php echo $weight8; ?></td>
	  <td><?php echo round($weight8/1000,2); ?></td>
      <td><?php echo $num8; ?></td>
	  <?php for($i=0;$i<$num8;$i++) { ?><td>X</td><?php } ?>
	  <?php for($i=$num8;$i<$numb;$i++) { ?><td></td><?php }  ?>
    </tr>
	<tr>
      <td><?php echo $weight9; ?></td>
	  <td><?php echo round($weight9/1000,2); ?></td>
      <td><?php echo $num9; ?></td>
	  <?php for($i=0;$i<$num9;$i++) { ?><td>X</td><?php } ?>
	  <?php for($i=$num9;$i<$numb;$i++) { ?><td></td><?php }  ?>
    </tr>
	<tr>
      <td><?php echo $weight10; ?></td>
	  <td><?php echo round($weight10/1000,2); ?></td>
      <td><?php echo $num10; ?></td>
	  <?php for($i=0;$i<$num10;$i++) { ?><td>X</td><?php } ?>
	  <?php for($i=$num10;$i<$numb;$i++) { ?><td></td><?php }  ?>
    </tr>
	<tr>
      <td><?php echo $weight11; ?></td>
	  <td><?php echo round($weight11/1000,2); ?></td>
      <td><?php echo $num11; ?></td>
	  <?php for($i=0;$i<$numb;$i++) { ?><td>X</td><?php } ?>
    </tr>
  </tbody>
</table>
<br />
<table width="346" border="1">
 <tr>
  <td width="115"><b>Date</b></td>
  <td width="106"><?php echo $cvdate1; ?></td>
 </tr>
 <tr>
  <td><b>Flock</b></td>
  <td><?php echo $flock; ?></td>
 </tr>
 <tr>
  <td><b>Age</b></td>
  <td><?php echo $age; ?></td>
 </tr>
 <tr>
  <td><b>Number Sampled</b></td>
  <td><?php echo $sum; ?></td>
 </tr>
 <tr>
  <td><b>Taget Weight</b></td>
  <td><?php echo $weight6; ?></td>
 </tr>
 <tr>
  <td><b>C.V%</b></td>
  <td><?php echo round($cv,2); ?></td>
 </tr>

</table>
</center>
<!--</div>-->
</form>

<center>

<input type="button" name="cancel" id="cancel" value="Cancel" onclick="document.location = 'dashboard.php?page=cv';" />
</center>

</body>


<?php $time = microtime(); $time = explode(" ", $time); $time = $time[1] + $time[0]; $finish = $time; $totaltime = ($finish - $start); printf ("Page took "); ?>
<font color="red">
<?php printf ("%f", $totaltime); ?>
</font>
<?php printf (" seconds to load "); ?>
</html>




