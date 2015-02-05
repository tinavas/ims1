<?php include "config.php"; ?>
<?php include "jquery.php"; ?>
<?php 
 $id = $_GET['id'];
 $q1 = "SELECT * FROM vehicle_tripdetails WHERE id = '$id' AND client = '$client'"; 
$r1 = mysql_query($q1,$conn);
      while($row1 = mysql_fetch_assoc($r1))
      {
        $vtype = $row1['vehicletype'];
		$tid = $row1['tid'];
	    $vnumber = $row1['vehiclenumber'];
		$driver = $row1['driver'];
		$sdate = date("d.m.Y",strtotime($row1['startdate']));
		$stime = $row1['starttime'];
		$splace = $row1['startplace'];
		$sread = $row1['startreading'];
		$edate = date("d.m.Y",strtotime($row1['enddate']));
		$etime = $row1['endtime'];
		$eplace = $row1['endplace'];
		$eread = $row1['endreading'];
		$wload = $row1['wload'];
		$exp = $row1['expensesincurred'];
        $remarks = $row1['remarks'];
      }
?>



<br />
<center>
<h1>Edit Vehicle Trip Details</h1>
</center>

<form id="form1" name="form1" method="post" action="vehicle_updatetrip.php" >

<table align="center">
<tr>
<input type="hidden" id="id" name="id" value="<?php echo $id;?>" />
<td style="vertical-align:middle"><strong>Vehicle Type<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>
<td style="vertical-align:middle">


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
<td style="vertical-align:middle"><strong>Vehicle No:<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>

<td style="vertical-align:middle">
<span id="newb1">
<select name="vnum" id="vnum" style="width:120px" >
<option value="">-Select-</option>
<?php include "config.php"; 
      $query = "SELECT distinct(vnumber) from vehicle_master where vtype = '$vtype'";
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
</span>
</td>
				
<td width="10px"></td>


<td style="vertical-align:middle"><strong>Driver<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>
<td>
<select name="driver[]" id="driver" multiple="multiple" style="width:120px">
<option value="" disabled="disabled">-Select-</option>
<?php
           $q12 = "SELECT * FROM vehicle_tripdetails where id = '$id'";
$res1 = mysql_query($q12,$conn); 
while($qr = mysql_fetch_assoc($res1))
{
$type = $qr['driver'];
$vtype1 = explode('/',$type);
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
<table align="center">
<tr height="20px"></tr>
<tr>
		
 <td><strong>Start Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>
<td>
<input type="text" name="sdate" id="sdate" size="18" class="datepicker" value="<?php echo $sdate;?>" /></td>
</td>
 
  
<td width="10px"></td>

<td id="fuel1"><strong>&nbsp;&nbsp;Start time<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>
                <td>&nbsp;<input type="text" size="18" id="stime" name="stime" value="<?php echo $stime;?>"></td>
<td width="10px"></td>


<td><strong>&nbsp;&nbsp;Start Place<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>
                <td>
<select name="splace" id="splace" style="width:120px">
<option value="">-Select-</option>
<?php include "config.php"; 
      $query = "SELECT distinct(sector) from tbl_sector where client = '$client' ";
      $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result))
      {
if($row1['sector'] == $splace)
 {
?>
<option value="<?php echo $row1['sector']; ?>" selected="selected"><?php echo $row1['sector']; ?></option>
<?php } else{ ?>
<option value="<?php echo $row1['sector']; ?>" ><?php echo $row1['sector']; ?></option>

<?php }}?>
<?php 
$query = "select distinct(location) from vehicle_location where client = '$client'";
$result = mysql_query($query,$conn);
while($rows = mysql_fetch_assoc($result))
{
?>
<option value="<?php echo $rows['location']; ?>" <?php if($rows['location'] == $splace) { ?> selected="selected" <?php } ?> ><?php echo $rows['location']; ?></option>
<?php } ?>
</select>
</td>

				<td width="10px"></td>

<td id="fuel1"><strong>&nbsp;&nbsp;Start Reading<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>
                <td>&nbsp;<input type="text" size="18" id="sread" name="sread" value="<?php echo $sread;?>"></td>

 
 
</tr>
</table>
</br>
</br>
<table align="center">
<tr height="10px"></tr>
<tr>
		
 <td><strong>End Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>
<td>
<input type="text" name="edate" id="edate" size="18" class="datepicker" value="<?php echo $edate;?>" /></td>
</td>
 
  
<td width="10px"></td>

<td id="fuel1"><strong>&nbsp;&nbsp;End time<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>
                <td>&nbsp;<input type="text" size="18" id="etime" name="etime" value="<?php echo $etime;?>"></td>
<td width="10px"></td>


<td><strong>&nbsp;&nbsp;End Place<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>
<td>
              <select name="eplace" id="eplace" style="width:120px">
<option value="">-Select-</option>
<?php include "config.php"; 
      $query = "SELECT distinct(sector) from tbl_sector where client = '$client' ";
      $result = mysql_query($query,$conn) or die(mysql_error()); 
      while($row1 = mysql_fetch_assoc($result))
      {
if($row1['sector'] == $eplace)
 {
?>
<option value="<?php echo $row1['sector']; ?>" selected="selected"><?php echo $row1['sector']; ?></option>
<?php } else{ ?>
<option value="<?php echo $row1['sector']; ?>" ><?php echo $row1['sector']; ?></option>

<?php }}?>
<?php 
$query = "select distinct(location) from vehicle_location where client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
?>
<option value="<?php echo $rows['location']; ?>" <?php if($rows['location'] == $eplace) { ?> selected="selected" <?php } ?> ><?php echo $rows['location']; ?></option>
<?php } ?>
</select>
				<td width="10px"></td>

<td id="fuel1"><strong>&nbsp;&nbsp;End Reading<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>
                <td>&nbsp;<input type="text" size="18" id="eread" name="eread" value="<?php echo $eread;?>"></td>

 
 
</tr>
</table>
<br/>
<br/>
<table align="center">
<tr height="10px"></tr>
<td id="fuel1"><strong>&nbsp;&nbsp;Expenses Incurred<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> &nbsp;&nbsp;</strong></td>
                <td>&nbsp;<input type="text" size="18" id="exp" name="exp" value="<?php echo $exp;?>"></td>
<td width="10px">

         <td>
		 
		<input type="radio" name="load"  value="WithLoad" <?php if($wload =="WithLoad"){ ?> checked="checked" <?php } ?>/> <strong>With Load</strong>
		&nbsp;&nbsp;
		<input type="radio" name="load" value="withoutload" <?php if($wload =="withoutload"){ ?> checked="checked" <?php } ?>/> <strong>Without Load</strong>
		</td>

</table>
</br>
</br>
<table align="center">
<tr>

<td width="10px"></td>
<td><strong>Remarks&nbsp;&nbsp;</strong></td>
<td><textarea rows="2" cols="30" id="remarks" name="remarks"><?php echo $remarks ;?></textarea></td>
</tr>
</table>

<center>	

   <input type="submit" value="Update" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="cancel" onClick="document.location='dashboardsub.php?page=vehicle_tripdetails';">
</center>


						
</form>
<script type="text/javascript">
function getfuel1(a)
{

var f = document.getElementById(a).value;

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
			$q = "select distinct(vtype) from vehicle_type";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(type == '$qr[vtype]') {";
			$q1 = "select distinct(vnumber) from vehicle_master where vtype = '$qr[vtype]'";
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

function changetype()
{
  document.getElementById("newb").innerHTML = "<input type='text' size='18' id='newvt' name='newvt' />";
 
  
}

</script>
<script type="text/javascript">
function script1() {
window.open('vehiclehelp/edithelptrip.php','BIMS',
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

