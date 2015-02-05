
<?php
include "jquery.php"; 
include "config.php";

$id= $_GET['id'];
$query1 = "SELECT * FROM vehicle_fuelfilling where id = '$id' and client = '$client'";
$result1 = mysql_query($query1,$conn); 
while($row1 = mysql_fetch_assoc($result1))
{
    $id =  $row1['id'];
	$type=$row1['type'];
	$warehouse=$row1['warehouse'];
	$vtype = $row1['vtype'];
	$vnumber = $row1['vnumber'];
	$ftype = $row1['fueltype'];
	$fuel = $row1['fuel'];
	$rate = $row1['rate'];
	$bill = $row1['billnumber'];
	$amount = $row1['amount'];
	 $date = date("d.m.Y", strtotime($row1['date']));
	$reading = $row1['reading'];
    $driver = $row1['driver'];
    $narration = $row1['narration'];
	$driver = explode(',',$driver);
	$coacode=$row1['coa'];
	//$fuelcode=$row1['fuelcode'];
$n = count($driver);
for($i = 0;$i<$n;$i++)
{
 $driver1 = $driver[$i];

}

  
}
?>


<form id="form1" name="form1" method="post" action="vehicle_updatefuel.php" >
	

<center>
<br />
<h1>Edit Vehicle Fuel Filling</h1>
<center>(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
 <br /> <br />

<table align="center">
<tr>
<td>
	<input type="radio" name="type" value="own" readonly="true" <?php if($type=="own"){?> checked="checked" <?php  }  else {?> disabled="disabled" <?php }?>  /><strong>Own&nbsp;&nbsp;</strong>
</td>
<td>
	<input type="radio" name="type" value="outside" readonly="true" <?php if($type=="outside"){?> checked="checked" <?php  } else {?> disabled="disabled" <?php }?>  /><strong>Outside&nbsp;&nbsp;<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
</td>

<td width="10px"></td>
<td><strong>Warehouse:<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;</strong></td>

<td>
<select name="ware" id="ware" style="width:120px" >
<option value="">-Select-</option>
	<?php
	
	
		    if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
	 }
	
		if($sectorlist=="")  
 $q = "SELECT DISTINCT(sector) FROM tbl_sector WHERE type1='Warehouse' ORDER BY sector";
else

 $q = "SELECT DISTINCT(sector) FROM tbl_sector WHERE type1='Warehouse' and sector in ($sectorlist) ORDER BY sector";
	 
	
			$res=mysql_query($q, $conn);
		while($data=mysql_fetch_array($res))
		{
			?>
				<option value="<?php echo $data['sector']; ?>"  <?php if($warehouse==$data['sector']) {?> selected="selected" <?php }?> title='<?php echo $data['sector']; ?>'><?php echo $data['sector']; ?></option>
			<?php
		}
	?>
</select>
</td>
</tr>
<tr height="10px"></tr>
</table>






<table align="center">
<tr>
<input type = "hidden" id= "id" name = "id" value = "<?php echo $id;?>"/>
<table align="center">
<tr>

<td><strong>Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;</strong></td>
                <td>&nbsp;<input class="datepicker" type="text" size="16" id="idate" name="idate" value="<?php echo $date; ?>" ></td>

<td width="20px"></td>
<td><strong>&nbsp;&nbsp;Bill No:&nbsp;&nbsp;</strong></td>
<td>&nbsp;<input type="text" size="18" id="bill" name="bill" value="<?php echo $bill;?>"></td>
<td width="20px"></td>
<td><strong>Vehicle Type<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;</strong></td>
<td>
<select name="vt" id="vt" style="width:120px" onChange="getnum(this.value);" >
<option value="">-Select-</option>
<?php include "config.php"; 
      $query = "SELECT * from vehicle_type where client = '$client' ";
      $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result))
      {
 if($row1['vtype'] == $vtype)
 {
?>
<option value="<?php echo $row1['vtype']; ?>" selected="selected"><?php echo $row1['vtype']; ?></option>
<?php } else{ ?>
<option value="<?php echo $row1['vtype']; ?>" ><?php echo $row1['vtype']; ?></option>

<?php }}?>
</select>
</td>
  
<td width="10px"></td>
<td><strong>Vehicle No:<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;</strong></td>

<td>
<select name="vnum" id="vnum" style="width:120px" >
<option value="">-Select-</option>
<?php include "config.php"; 
      $query = "SELECT distinct(vnumber) from vehicle_master where vtype = '$vtype' and client = '$client'";
      $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result))
      {
 if($row1['vnumber'] == $vnumber)
 {
?>
<option value="<?php echo $row1['vnumber']; ?>" selected="selected"><?php echo $row1['vnumber']; ?></option>
<?php } else{ ?>
<option value="<?php echo $row1['vnumber']; ?>" ><?php echo $row1['vnumber']; ?></option>

<?php }}?>
</select>
</td>
<td width="10px"></td>
<td><strong>COA Code:<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;</strong></td>

<td>
<select name="coa" id="coa" style="width:120px" >
<option value="">-Select-</option>
	<?php
		$q="SELECT DISTINCT(code), description FROM ac_coa WHERE type='Expense' AND schedule='Indirect Expense'";
		$res=mysql_query($q, $conn);
		while($data=mysql_fetch_array($res))
		{
			?>
				<option value="<?php echo $data['code']; ?>" title='<?php echo $data['code']; ?>' <?php if($data['code']==$coacode){ ?> selected="selected" <?php } ?>><?php echo $data['description']; ?></option>
			<?php
		}
	?>
</select>
</td>		
				
</tr>
<tr height="10px"></tr>
<tr>
		
 <td><strong>Fuel Type<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;</strong></td>
<td>
<select name="ftype" id="ftype" style="width:120px" onchange="getfuel1(this.id);" >
<option value="">-Select-</option>
<option value="Gas@GA101" <?php if($ftype == 'Gas') {?> selected="selected" <?php }?>>Gas</option>
<option value="Petrol@PA101" <?php if($ftype == 'Petrol') {?> selected="selected" <?php }?>>Petrol</option>
<option value="Diesel@DE101"<?php if($ftype == 'Diesel') {?> selected="selected" <?php }?>>Diesel</option>
</select>
</td>
 
  
<td width="20px"></td>

<td><strong>&nbsp;&nbsp;Fuel <span id="fuelunit"></span><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;</strong></td>

                <td>&nbsp;<input type="text" size="18" id="fl" name="fl" value = "<?php echo $fuel;?>"></td>
<td width="10px"></td>

<td><strong>&nbsp;&nbsp;Amount<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;</strong></td>
                <td>&nbsp;<input type="text" size="18" id="amt" name="amt" onchange="getrate(this.id);" <?php if($type=="outside"){?>  value="<?php echo $amount;?>" <?php } else {?>  readonly="true" <?php  }?>   /></td>
                <td width="10px"></td>


<td><strong>&nbsp;&nbsp;Rate/lt<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;</strong></td>
                <td>&nbsp;<input type="text" size="18" id="ratel" name="ratel" <?php if($type=="outside"){?> value="<?php echo $rate;?>" <?php } else {?> readonly="true" <?php  }?> /></td>
                <td width="5px"></td>
 
 
</tr>
</table>
</br>
</br>
<table align="center">
<tr>
<td style="vertical-align:middle"><strong>&nbsp;&nbsp;Reading&nbsp;&nbsp;</strong></td>
                <td style="vertical-align:middle">&nbsp;<input type="text" size="18" id="reading" name="reading" value = "<?php echo $reading;?>"></td>
              
 

<td width="20px"></td>
<td style="vertical-align:middle"><strong>Driver&nbsp;&nbsp;</strong></td>
<td style="vertical-align:middle">
<select name="driver[]" id="driver" multiple="multiple"sss style="width:100px">
<option value="" disabled="disabled">-Select-</option>
<?php
           $q12 = "SELECT * FROM vehicle_fuelfilling where id = '$id' and client = '$client'";
$res1 = mysql_query($q12,$conn); 
while($qr = mysql_fetch_assoc($res1))
{
$type = $qr['driver'];
$vtype1 = explode(',',$type);
}
$query = "SELECT * FROM hr_employee where designation='Driver' AND client = '$client' ORDER BY name ASC ";
      $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result))
      {
?>
<option value="<?php echo $row1['name']; ?>" <?php if(in_array($row1['name'], $vtype1)) { ?>selected="selected"<?php } ?>><?php echo $row1['name']; ?></option>
<?php } ?>

</select>
</td>
				
</tr>
</table>
<br/>
<br/>

<tr>

<td width="10px"></td>
<td><strong>Remarks&nbsp;&nbsp;</strong></td>
<td><textarea rows="2" cols="30" id="remarks" name="remarks"><?php echo $narration;?> </textarea></td>
</tr>
</table>

<center>	

   <input type="submit" value="Update" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="cancel" onClick="document.location='dashboardsub.php?page=vehicle_fuelfilling';">
</center>


						
</form>
<script type="text/javascript">
function checkform(form)
{
	if(form.vt.value == "")
	{
		alert("Please Enter Type");
 form.vt.focus();
return false;
}
else if(form.vnum.value == "")
{
	alert("Please Enter VehicleNumber");
	form.vnum.focus();
	return false;
}
else if(form.ftype.value == "")
{
	alert("Please Enter FuelType");
	form.ftype.focus();
	return false;
}
else if(form.fl.value == "")
{
	alert("Please Enter Fuel");
	form.fl.focus();
	return false;
}
else if(form.amt.value == "")
{
	alert("Please Enter Amount");
	form.amt.focus();
	return false;
}
else if(form.ratel.value == "")
{
	alert("Please Enter Rate");
	form.ratel.focus();
	return false;
}
else if(form.reading.value == "")
{
	alert("Please Enter Current Reading");
	form.reading.focus();
	return false;
}
else if(form.driver.value == "")
{
	alert("Please Enter Driver");
	form.driver.focus();
	return false;
}
return true;
}
function getfuel1(a)
{

 var f = document.getElementById(a).value;
 if(f == "")
 {
   document.getElementById("fuelunit").innerHTML = "";
 }
 else if(f == "Gas")
 {
   document.getElementById("fuelunit").innerHTML = "(in kgs)";
 }
 else
 {
   document.getElementById("fuelunit").innerHTML = "(in lts)";
 }
}
function getrate(a)
{

var amount = document.getElementById(a).value;
var fuel = document.getElementById("fl").value;

var rate = (amount/fuel);
document.getElementById("ratel").value = rate;

}

function getnum(a)
{

var type = a;


removeAllOptions(document.getElementById("vnum"));
	myselect1 = document.getElementById("vnum");
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "vnum";
myselect1.style.width = "120px";


<?php 
			$q = "select distinct(vtype) from vehicle_type where client = '$client'";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(type == '$qr[vtype]') {";
			$q1 = "select * from vehicle_master where vtype = '$qr[vtype]' and client = '$client'";
			$q1rs = mysql_query($q1) or die(mysql_error());
			while($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
        theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("<?php echo $q1r['vnumber'];?>");
              theOption1.appendChild(theText1);
	          theOption1.value = "<?php echo $q1r['vnumber'];?>";
	          
              myselect1.appendChild(theOption1);
			  
			  <?php
			}
			echo "}";
			}
	?>


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
window.open('vehiclehelp/editfuel.php','BIMS',
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

