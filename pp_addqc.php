<?php
include "config.php";
#include "jquery.php";

 session_start();
 $date = $_GET['date'];
 $date = date("Y-m-j", strtotime($date));
 $ge = $_GET['ge'];
 $name = $_GET['name'];
 
 $vendor = "";
 $po = "";
 $q = "select combinedpo,vendor from pp_gateentry where ge = '$ge'";
 $qrs = mysql_query($q,$conn) or die(mysql_error());
 if($qr = mysql_fetch_assoc($qrs))
 {
 $po = $qr['combinedpo'];
 $vendor = $qr['vendor'];
 }
?>

<form name="lanInsert1" id="labInsert1" method="post" action="pp_saveqc.php" style="background : #d5d8db;" >
<input type="hidden" name="date" id="date" value="<?php echo $_GET['date']; ?>"/>
<input type="hidden" name="ge" id="ge" value="<?php echo $_GET['ge']; ?>"/>
<input type="hidden" name="po" id="po" value="<?php echo $po; ?>"/>
<input type="hidden" name="name" id="name" value="<?php echo $_GET['name']; ?>"/>
<input type="hidden" name="vendor" id="vendor" value="<?php echo $vendor; ?>"/>
<table width="914" border="0">
 <tr>
 <?php include "config.php";

       $query1 = "SELECT * FROM labdetails WHERE ingname = '$name' ORDER BY parameter ASC";
	   $result1 = mysql_query($query1,$conn);
	   $i = 1;
	   while($row1 = mysql_fetch_assoc($result1))
	   {
	     $query2 = "SELECT * FROM labprocedures WHERE parameter = '$row1[parameter]'";
		 $result2 = mysql_query($query2,$conn);
		 while($row2 = mysql_fetch_assoc($result2))
		 {
  ?>
   <td><div align="right"><b><font color="#FF0000"><?php echo $row1['parameter']; ?></font></b></div></td>
   <input type="hidden" name="param[]" id="param" value="<?php echo $row1['parameter']; ?>"  />

<?php if ($_GET['name'] == "Maize" and $row1['parameter'] == "Moisture%") { ?>
<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
<input type="hidden" name="First[]" value = "0" />
<input type="hidden" name="Second[]" value = "0" />
<input type="hidden" name="Third[]" value = "0" />
<input type="hidden" name="Fourth[]" value = "0" />
<input type="hidden" name="Fifth[]" value = "0" />
<input type="hidden" name="Sixth[]" value = "0" />


<?php } else { ?>


  <?php if(($row2['A'] <> "") and (!preg_match("/[*,-,+,(,),.,0-9,^,\-,\/]/i",$row2['A']))) { ?><td><div align="right"><b><?php echo $row2['A']; ?></b></div></td>
                                 <td><input type="text" size="3" id="A<?php echo "_".$i; ?>" name="First[]" value="0" onkeyup="calci('<?php echo $i; ?>');"></td>
  <?php } else { ?><input type="hidden" name="First[]" id="A<?php echo "_".$i; ?>" value="<?php echo $row2['A']; ?>" /><td></td><td></td><?php } ?>


  <?php if(($row2['B'] <> "") and (!preg_match("/[*,-,+,(,),.,0-9,^,\-,\/]/i",$row2['B']))) { ?><td><div align="right"><b><?php echo $row2['B']; ?></b></div></td>
                                 <td><input type="text" size="3" id="B<?php echo "_".$i; ?>" name="Second[]" value="0" onkeyup="calci('<?php echo $i; ?>');"></td>
  <?php } else { ?><input type="hidden" name="Second[]" id="B<?php echo "_".$i; ?>" value="<?php echo $row2['B']; ?>" /><td></td><td></td><?php } ?>


  <?php if(($row2['C'] <> "") and (!preg_match("/[*,-,+,(,),.,0-9,^,\-,\/]/i",$row2['C']))) { ?><td><div align="right"><b><?php echo $row2['C']; ?></b></div></td>
                                 <td><input type="text" size="3" id="C<?php echo "_".$i; ?>" name="Third[]" value="0" onkeyup="calci('<?php echo $i; ?>');"></td>
  <?php } else { ?><input type="hidden" name="Third[]" id="C<?php echo "_".$i; ?>" value="<?php echo $row2['C']; ?>" /><td></td><td></td><?php } ?>   


  <?php if(($row2['D'] <> "") and (!preg_match("/[*,-,+,(,),.,0-9,^,\-,\/]/i",$row2['D']))) { ?><td><div align="right"><b><?php echo $row2['D']; ?></b></div></td>
                                 <td> <input type="text" size="3" id="D<?php echo "_".$i; ?>" name="Fourth[]" value="0" onkeyup="calci('<?php echo $i; ?>');"></td>
  <?php } else { ?><input type="hidden" name="Fourth[]" id="D<?php echo "_".$i; ?>" value="<?php echo $row2['D']; ?>" /><td></td><td></td><?php } ?>


  <?php if(($row2['E'] <> "") and (!preg_match("/[*,-,+,(,),.,0-9,^,\-,\/]/i",$row2['E']))) { ?><td><div align="right"><b><?php echo $row2['E']; ?></b></div></td>
                                 <td><input type="text" size="3" id="E<?php echo "_".$i; ?>" name="Fifth[]" value="0" onkeyup="calci('<?php echo $i; ?>');"></td>
  <?php } else { ?><input type="hidden" name="Fifth[]" id="E<?php echo "_".$i; ?>" value="<?php echo $row2['E']; ?>" /><td></td><td></td><?php } ?> 


  <?php if(($row2['R'] <> "") and (!preg_match("/[*,-,+,(,),.,0-9,^,\-,\/]/i",$row2['R']))) { ?><td><div align="right"><b><?php echo $row2['R']; ?></b></div></td>
                                   <td> <input type="text" size="3" id="R<?php echo "_".$i; ?>" name="Sixth[]" value="0"  onkeyup="calci('<?php echo $i; ?>');"></td>
  <?php } else { ?><input type="hidden" name="Sixth[]" id="R<?php echo "_".$i; ?>" value="<?php echo $row2['R']; ?>" /><td></td><td></td><?php } ?>


<?php } ?>

  <input type="hidden" name="cal" id="cal<?php echo "_".$i; ?>" value="<?php echo $row2['calculation']; ?>" />
  <td><div align="right"><b><font color="#FF0000">Result</font></b></div></td>
  <?php if ( $row2['result'] == "text" ) { ?>
  <td>
  <input type="text" size="3" id="result<?php echo "_".$i; ?>" name="result[]" value="">

  <select name="unit[]" style="width:40px">
<?php
           include "config.php"; 
           $query = "SELECT * FROM units ORDER BY unit ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
<option value="<?php echo $row1['unit']; ?>" title="<?php echo $row1['unit']; ?>"><?php echo $row1['unit']; ?></option>

<?php } ?>
</select>
  </div></td> 
  <?php } else { ?>
  <td><select name="result[]"><option value="( + Ve)">( + Ve )</option><option value="( - Ve)">( - Ve )</option></select></div></td> 
  <?php } ?>
 </tr>
<?php $i = $i + 1; } } ?>
</table>


<br />
<br />
<br />
<center>
<input type="hidden" name="type" id="type" />
<?php if ($_GET['name'] == "Maize") { ?>
Selection : &nbsp;&nbsp;
<select><option style="text-align:center">--</option><option>Needed</option></select>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php } ?>
<input type="button" name="Accept" id="Accept" value="Accept" onclick="acc(this.value);"/>
<input type="button" name="Reject" id="Reject" value="Reject" onclick="acc(this.value);"/>
<input type="button" name="PartialAccept" id="PartialAccept" value="PartialAccept" onclick="acc(this.value);"/>
<!--<input type="button" name="Cancel" id="Cancel" value="Cancel" onclick="document.location='purchaseorderCancelDelete.php';" />-->
</center>
</form>


<script type="text/javascript">
function calci(l)
{
   var A = "A_" + l;
   A = parseFloat(document.getElementById(A).value);
  
   var B = "B_" + l;
   B = parseFloat(document.getElementById(B).value);

   var C = "C_" + l;
   C = parseFloat(document.getElementById(C).value);

   var D = "D_" + l;
   D = parseFloat(document.getElementById(D).value);

   var E = "E_" + l;
   E = parseFloat(document.getElementById(E).value);

   var R = "R_" + l;
   R = parseFloat(document.getElementById(R).value);
 
   var cal = "cal_" + l;
   cal = document.getElementById(cal).value;
   cal = eval(cal);
   cal = Math.round(cal * 10000) / 10000;

   var result = "result_" + l;
   document.getElementById(result).value = cal;
   //alert(cal);
}


function acc(acce)
{
 document.getElementById("type").value = acce;
 document.lanInsert1.submit();
}

</script>


