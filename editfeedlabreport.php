<?php 
include "config,php"; 
include "jquery.php";

?>
<?php

$query = "SELECT * FROM feedlabreport where id = '$_GET[id]'";

$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{
 $id =  $row1['id'];
 $sdate = $row1['sampledate'];
 $rdate = $row1['reportdate'];

 $sampcode =$row1['samplecode'];
$feeddesc = $row1['feeddescription'];
$ftype = $row1['farmtype'];
 $fname = $row1['farmname'];
 $moisture = $row1['moisture'];
 $protein = $row1['protein'];
 $oil = $row1['oil'];
 $fibre = $row1['fibre'];
 $tash = $row1['tash'];
 $sns = $row1['sandsilica'];
 $calcium = $row1['calcium'];
 $phosphorous = $row1['phosphorous'];
 $salt = $row1['salt'];
 $atoxin = $row1['atoxin'];
$gekcal = $row1['ge'];
 $mekcal = $row1['me'];
$remarks = $row1['remarks'];
}

?>
<br />
<body onLoad= "loadfnames('<?php echo $ftype;?>');">
<center>
<h1>Edit Feed Lab Report</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
</center>


<form id="form1" name="form1" method="post" action="updatefeedlabreport.php" onsubmit="return checkform(this);">

<table align="center">
<tr>
<input type = "hidden" id= "id" name = "id" value = "<?php echo $id;?>"/>
<td><strong>Sample Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;<input class="datepicker" type="text" size="15" id="sampledate" name="sampledate" value="<?php echo $sdate; ?>"></td>
                <td width="10px"></td>




 <td><strong>Report Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;<input class="datepicker" type="text" size="15" id="reportdate" name="reportdate" value="<?php echo $rdate; ?>"></td>
                <td width="40px"></td>



 <td><strong>Sample Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;<input type="text" size="15" id="sampcode" name="sampcode" value="<?php echo $sampcode; ?>" /></td>
                
</tr>

<tr height="10px"></tr>
     <tr>
     <tr style="height:20px"></tr>
 <td><strong>Feed Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
<td style="text-align:left;">
 <select style="Width:180px" name="feeddesc" id="feeddesc">
<option value="">-Select-</option>
<?php
$query = "SELECT *  FROM `ims_itemcodes` WHERE cat = 'Broiler Feed' OR cat = 'Female Feed' OR cat = 'Male Feed' order by description";
$result = mysql_query($query,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($result))
{
if($qr['description']== $feeddesc)
{
?>
<option value = "<?php echo $qr['description'];?>"  selected="selected"><?php echo $qr['description'];?></option>
<?php } 
else 
{
?>
<option value = "<?php echo $qr['description'];?>"><?php echo $qr['description'];?></option>
<?php } } ?>
</select>
</td>
 <td width="40px">&nbsp;</td>
   <td><strong>Farm Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
            <td style="text-align:left;">
     
      <select style="Width:120px" name="ftype" id="ftype" onChange="loadfnames(this.value);">

<option>-select</option>
<option value= "Breeder"<?php if($ftype == 'Breeder') {?> selected="selected" <?php }?>>Breeder</option>
<option value = "Hatchery"<?php if($ftype == 'Hatchery') {?> selected="selected" <?php }?>>Hatchery</option>
<option value="Broiler"<?php if($ftype == 'Broiler') {?> selected="selected" <?php }?>>Broiler</option>
<option value = "Feedmill"<?php if($ftype == 'Feedmill') {?> selected="selected" <?php }?>>Feedmill</option>
      
</select>
       </td>
   <td width="40px">&nbsp;</td>
    <td><strong>Farm Name</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
         <td style="text-align:left;">
			<select style="Width:170px" name="fname" id="fname">
<option>-select</option>
<option value="<?php echo $fname;?>" selected = "selected"><?php echo $fname;?></option>

</select>
</td>

</tr>
 
</table>  
<br/>
<br/>

<center>
 <table border="0" id="tab">
     <tr>
 
<td align="right"><strong>Moisture%</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td align="left">&nbsp;<input type="text" size="10" id="moisture" name="moisture" value = "<?php echo $moisture;?>" /></td>
                <td width="5px"></td>
<td width="10px">&nbsp;</td>

<td align="right"><strong>Protein%</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td align="left">&nbsp;<input type="text" size="10" id="protein" name="protein" value = "<?php echo $protein;?>"/></td>
                <td width="5px"></td>
<td width="10px">&nbsp;</td>

<td align="right"><strong>Oil%</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td align="left">&nbsp;<input type="text" size="10" id="oil" name="oil" value = "<?php echo $oil;?>"/></td>
                <td width="5px"></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Fibre%</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td align="left">&nbsp;<input type="text" size="10" id="fibre" name="fibre" value = "<?php echo $fibre;?>"/></td>
                <td width="5px"></td>

<td width="10px">&nbsp;</td>

<td align="right"><strong>T.Ash%</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td align="left">&nbsp;<input type="text" size="10" id="tash" name="tash" value = "<?php echo $tash;?>"/></td>
                <td width="5px"></td>


</tr>

 <tr style="height:10px"></tr> 
<tr>

<td align="right"><strong>Sand & Silica%</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td align="left">&nbsp;<input type="text" size="10" id="sns" name="sns" value = "<?php echo $sns;?>" /></td>
                <td width="5px"></td>
<td width="10px">&nbsp;</td>

<td align="right"><strong>Calcium</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td align="left">&nbsp;<input type="text" size="10" id="calcium" name="calcium" value = "<?php echo $calcium;?>" /></td>
                <td width="5px"></td>
<td width="10px">&nbsp;</td>

<td align="right"><strong>Phosphorous%</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td align="left">&nbsp;<input type="text" size="10" id="phosphorous" name="phosphorous" value = "<?php echo $phosphorous;?>"/></td>
                <td width="5px"></td>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Salt%</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td align="left">&nbsp;<input type="text" size="10" id="salt1" name="salt1" value = "<?php echo $salt;?>" /></td>
                <td width="5px"></td>

<td width="10px">&nbsp;</td>

<td align="right"><strong>A.Toxin%</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td align="left">&nbsp;<input type="text" size="10" id="atoxin" name="atoxin" value = "<?php echo $atoxin;?>" /></td>
                <td width="5px"></td>

</tr>

 <tr style="height:10px"></tr> 
<tr>
<td align="right"><strong>GE kcal/kg</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td align="left">&nbsp;<input type="text" size="10" id="gekcal" name="gekcal" value = "<?php echo $gekcal;?>"/></td>
                <td width="5px"></td>
<td width="10px">&nbsp;</td>

<td align="right"><strong>MEkcal/kg</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td align="left">&nbsp;<input type="text" size="10" id="mekcal" name="mekcal" value = "<?php echo $mekcal;?>" /></td>
                <td width="5px"></td>
<td width="10px">&nbsp;</td>


</tr>
   </table>
   <br /> 
 </center>

<br />			

<table border="0"  align="center">
 <tr style="height:10px"></tr> 
<tr>
<td style="vertical-align:middle;"><strong>Remarks</strong>&nbsp;&nbsp;&nbsp;</td>
<td><textarea rows="3" cols="50" id="remarks" name="remarks"></textarea></td>
</tr>
</table>
<center>	


   <br />
   <input type="submit" value="Update" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=feedlabreport';">
</center>


						
</form>


<script type="text/javascript">
function checkform(form)
{


	if(form.sampcode.value == "")
	{
		alert("Please Enter Sample Code");
 form.sampcode.focus();
return false;
}
else if(form.feeddesc.value == "")
{
	alert("Please Enter Feed Type");
	form.feeddesc.focus();
	return false;
}
else if(form.ftype.value == "")
{
	alert("Please Enter Farm Type");
	form.ftype.focus();
	return false;
}
else if(form.fname.value == "")
{
	alert("Please Enter Farm Name");
	form.fname.focus();
	return false;
}
else if(form.moisture.value == "")
{
	alert("Please Enter Moisture%");
	form.moisture.focus();
	return false;
}
else if(form.protein.value == "")
{
	alert("Please Enter Protein%");
	form.protein.focus();
	return false;
}
else if(form.oil.value == "")
{
	alert("Please Enter Oil%");
	form.oil.focus();
	return false;
}
else if(form.fibre.value == "")
{
	alert("Please Enter Fibre%");
	form.fibre.focus();
	return false;
}
else if(form.tash.value == "")
{
	alert("Please Enter T.Ash%");
	form.tash.focus();
	return false;
}
else if(form.sns.value == "")
{
	alert("Please Enter Sand & Silica%");
	form.sns.focus();
	return false;
}
else if(form.calcium.value == "")
{
	alert("Please Enter Calcium");
	form.calcium.focus();
	return false;
}
else if(form.phosphorous.value == "")
{
	alert("Please Enter phosphorous%");
	form.phosphorous.focus();
	return false;
}
else if(form.salt1.value == "")
{
	alert("Please Enter Salt%");
	form.salt1.focus();
	return false;
}

else if(form.atoxin.value == "")
{
	alert("Please Enter A.toxin%");
	form.atoxin.focus();
	return false;
}
else if(form.gekcal.value == "")
{
	alert("Please Enter gekcal%");
	form.gekcal.focus();
	return false;
}

else if(form.mekcal.value == "")
{
	alert("Please Enter mekcal%");
	form.mekcal.focus();
	return false;
}
return true;
	}
function getsobi()
{

  var date1 = document.getElementById('date').value;
  var strdot1 = date1.split('.');
  var ignore = strdot1[0];
  var m = strdot1[1];
  var y = strdot1[2].substr(2,4);
     var mon = new Array();
     var yea = new Array();
     var sobiincr = new Array();
    var sobi = "";
	var code = "<?php echo $code; ?>";
  <?php 
   
   $query1 = "SELECT MAX(sobiincr) as sobiincr,m,y FROM pp_sobi GROUP BY m,y ORDER BY date DESC";
   $result1 = mysql_query($query1) or die(mysql_error());
   $k = 0; 
   while($row1 = mysql_fetch_assoc($result1))
   {
?>
     mon[<?php echo $k; ?>] = <?php echo $row1['m']; ?>;
     yea[<?php echo $k; ?>] = <?php echo $row1['y']; ?>;
     sobiincr[<?php echo $k; ?>] = <?php if($row1['sobiincr'] < 0) { echo 0; } else { echo $row1['sobiincr']; } ?>;

<?php $k++; } ?>
for(var l = 0; l <= <?php echo $k; ?>;l++)
{

 if((yea[l] == y) && (mon[l] == m))
  { 
   if(sobiincr[l] < 10)
     sobi = 'SOBI'+'-'+m+y+'-000'+parseInt(sobiincr[l]+1)+code;
   else if(sobiincr[l] < 100 && sobiincr[l] >= 10)
     sobi = 'SOBI'+'-'+m+y+'-00'+parseInt(sobiincr[l]+1)+code;
   else
     sobi = 'SOBI'+'-'+m+y+'-0'+parseInt(sobiincr[l]+1)+code;
     document.getElementById('sobiincr').value = parseInt(sobiincr[l] + 1);
  break;
  }
 else
  {
   sobi = 'SOBI' + '-' + m + y + '-000' + parseInt(1)+code;
   document.getElementById('sobiincr').value = 1;
  }
}
document.getElementById('invoice').value = sobi;
document.getElementById('m').value = m;
document.getElementById('y').value = y;
}
function loadfnames(a)
{

if(a== "Breeder")
{

var item1 = a;
removeAllOptions(document.getElementById('fname'));
myselect1 = document.getElementById("fname");
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "fname";
myselect1.style.width = "170px";


<?php 
	    $query = "select distinct(shedcode),sheddescription from breeder_shed order by shedcode";

    $result = mysql_query($query) or die(mysql_error());
    while($qr = mysql_fetch_assoc($result))
    {

	echo "if(item1 == 'Breeder') {";
?>
	theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['shedcode']; ?>");
theOption1.value = "<?php echo $qr['shedcode']; ?>";
<?php if($fname == $qr['shedcode']) { ?>
theOption1.selected= 'select';
<?php } ?>
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

<?php echo "}"; ?>

<?php }  ?>	 
}
if(a=="Hatchery")
{
var item2 = a;

removeAllOptions(document.getElementById('fname'));
myselect1 = document.getElementById("fname");
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "fname";
myselect1.style.width = "170px";


<?php 
	    $query = "select distinct(type) from tbl_sector where type1 = 'Hatchery'";
    $result = mysql_query($query) or die(mysql_error());
    while($qr = mysql_fetch_assoc($result))
    {

	echo "if(item2 == 'Hatchery') {";
?>
	theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['type']; ?>");
theOption1.value = "<?php echo $qr['type']; ?>";
<?php if($fname == $qr['type']) { ?>
theOption1.selected='select';
<?php } ?>

theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

<?php echo "}"; ?>

<?php }  ?>	 

}
if(a=="Broiler")
{

var item3 = a;

removeAllOptions(document.getElementById('fname'));
myselect1 = document.getElementById("fname");
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "fname";
myselect1.style.width = "170px";


<?php 
	    $query = "select distinct(farm) from broiler_farm";
    $result = mysql_query($query) or die(mysql_error());
    while($qr = mysql_fetch_assoc($result))
    {

	echo "if(item3 == 'Broiler') {";
?>
	theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['farm']; ?>");
theOption1.value = "<?php echo $qr['farm']; ?>";

<?php if($fname == $qr['farm']) { ?>
theOption1.selected='select';
<?php } ?>

theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

<?php echo "}"; ?>

<?php }  ?>	 
}
if(a=="Feedmill")
{

var item4 = a;

removeAllOptions(document.getElementById('fname'));
myselect1 = document.getElementById("fname");
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "fname";
myselect1.style.width = "170px";


<?php 
	    $query = "select distinct(type) from tbl_sector where type1 = 'Feedmill'";
    $result = mysql_query($query) or die(mysql_error());
    while($qr = mysql_fetch_assoc($result))
    {

	echo "if(item4 == 'Feedmill') {";
?>
	theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['type']; ?>");
theOption1.value = "<?php echo $qr['type']; ?>";

<?php if($fname == $qr['type']) { ?>
theOption1.selected='select';
<?php } ?>

theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

<?php echo "}"; ?>

<?php }  ?>	 

}


}


function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.options.remove(i);
		selectbox.remove(i);
	}
}
</script>

<script type="text/javascript">
function script1() {
window.open('IMSHelp/help_t_addfeedlabreport.php','BIMS',
'width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');

}
</script>


	<footer>
		<div class="float-left">
			<a href="#" class="button" onClick="script1()">Help</a>
			<a href="javascript:void(0)" class="button">About</a>
		</div>


		
		<div class="float-right">
			<a href="#top" class="button"><img src="images/icons/fugue/navigation-090.png" width="16" height="16"> Page top</a>
		</div>
		
	</footer>


</body>
</html>




