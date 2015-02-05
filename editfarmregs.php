<script type="text/javascript">

  	$(document).ready(function()
		{

	            $(function() {
		           $( ".datepicker" ).datepicker();
	            });
		});
		
</script> 
<?php
 include "config.php";
  include "jquery.php";
       $query1 = "SELECT * FROM tbl_farmreg where id='$_GET[id]' ";
       $result1 = mysql_query($query1,$conn);
       while($row1 = mysql_fetch_assoc($result1))
       {
          $farmvillage = $row1['farmvillage'];
  		  $farmer = $row1['farmer'];
          $fatherrhusband = $row1['fatherrhusband'];
		  $farmaddress = $row1['farmaddress'];
		  $residentaddress = $row1['residentaddress'];
		  $dob = date("d.m.Y",strtotime($row1['dob']));
		  $education = $row1['education'];
		  $poultryexp = $row1['poultryexp'];
		  $bankersname = $row1['bankersname'];
		  $bankaddress = $row1['bankaddress'];
		  $backacnotype = $row1['backacnotype'];
		  $pan = $row1['pan'];
		  $farmphoto = $row1['farmphoto'];
		 		  
       }
?>


<center>
<br />

<br/>
<br/><br />
<form id="form1" name="form1" method="post" action="updatefarmreg.php"  onsubmit="return checkform(this);" enctype="multipart/form-data">
<table align="center">

<tr>
<td width="300"></td><td width="450"></td>
</tr>
<tr>
<input type="hidden" id="id" name="id" value="<?php echo $_GET['id'];?>" />
<input type="hidden" id="farmp" name="farmp" value="<?php echo $farmphoto;?>" />
<td  align="right"><strong>Farm and Village</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="frvname" size="50" id="frvname" value="<?php echo $farmvillage; ?>" />
&nbsp;<span id="code1" style="color:red;"></span></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td  align="right"><strong>Farmer's Name</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="fname" size="50" id="fname" value="<?php echo $farmer; ?>"/>
&nbsp;<span id="description1" style="color:red;"></span></td>
</tr>
<tr height="10px"><td></td></tr>
<tr>
<td  align="right"><strong>Father's/Husband's Name</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="fhname" size="50" id="fhname" value="<?php echo $fatherrhusband; ?>"/>
&nbsp;<span id="description1" style="color:red;"></span></td>
</tr>
<tr height="10px"><td></td></tr>

<tr>
<td align="right" valign="middle"><strong>Farm Address</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><textarea rows="4" cols="48" name="faddress" ><?php echo $farmaddress; ?></textarea></td>
</tr>
<tr height="10px"><td></td></tr>

<tr>
<td align="right" valign="middle"><strong>Resident Address</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><textarea rows="4" cols="48" name="raddress" ><?php echo $residentaddress; ?></textarea></td>
</tr>
<tr height="10px"><td></td></tr>

<tr>
<td align="right" valign="middle"><strong>Date of Birth</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="dob" size="10" id="dob" value="<?php echo $dob; ?>" class="datepicker" />
</tr>
<tr height="10px"><td></td></tr>

<tr>
<td align="right" valign="middle"><strong>Education</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left">
<select name="edu" id="edu" style="width:85px">
		<?php
			 $query = "SELECT * FROM hr_qualification ORDER BY qualification ASC ";
			 $result = mysql_query($query,$conn); $i = 0;
			 while($row1q = mysql_fetch_assoc($result))
			 {
			?>
			<option  value="<?php echo $row1q['qualification']; ?>" <?php if($education == $row1q['qualification']) { ?> selected="selected" <?php } ?> ><?php echo $row1q['qualification']; ?></option>
			<?php } 
			?> 

		</select>

</tr>
<tr height="10px"><td></td></tr>

<tr>
<td align="right" valign="middle"><strong>Poultry Experience</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left">
<select name="pexp" id="pexp" style="width:85px">	 
			<option  value="0-1"  <?php if($poultryexp == "0-1") { ?> selected="selected" <?php } ?>>0 to 1</option>
			<option  value="1-3" <?php if($poultryexp == "1-3") { ?> selected="selected" <?php } ?>>1 to 3</option>
			<option  value="3-5" <?php if($poultryexp == "3-5") { ?> selected="selected" <?php } ?>>3 to 5</option>
			<option  value="5-10" <?php if($poultryexp == "5-10") { ?> selected="selected" <?php } ?>>5 to 10</option>
			<option  value="10+" <?php if($poultryexp == "10+") { ?> selected="selected" <?php } ?>>10 + </option>
		</select>
</tr>
<tr height="10px"><td></td></tr>



<tr>
<td align="right" valign="middle"><strong>Banker's Name</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="bname" size="50" id="bname" value="<?php echo $bankersname; ?>" />
</tr>
<tr height="10px"><td></td></tr>

<tr>
<td align="right" valign="middle"><strong>Bank Address</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><textarea rows="4" cols="48" name="baddress"  ><?php echo $bankaddress; ?></textarea></td>
</tr>
<tr height="10px"><td></td></tr>

<tr>
<td align="right" valign="middle"><strong>Bank A/c No & Type</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="bactype" size="50" id="bactype" value="<?php echo $backacnotype; ?>" />
</tr>
<tr height="10px"><td></td></tr>

<tr>
<td align="right" valign="middle"><strong>Permanent Account No.(PAN)</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="pan" size="50" id="pan" value="<?php echo $pan; ?>"/>
</tr>
<tr height="10px"><td></td></tr>

<!--	<tr>
<td align="right" valign="middle"><strong>Farm Photo</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input id="licence_front" name="licence_front" size="20" type="file" /></td>
</tr>
<tr height="10px"><td></td></tr>-->				
<!--<tr>
<td align="right" valign="middle"><strong>Farm Photo</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="hidden" name="MAX_FILE_SIZE" value="100000000000" /><input id="fphoto" name="fphoto" size="31" type="file" /></td>
</tr>
<tr height="10px"><td></td></tr>-->

<tr>
<td align="right"><strong>Farm Photo <em style=" font-size:11px">(MAX : 500Kb )</em></strong>&nbsp;&nbsp;&nbsp;<br/><span style=" color:#FF0000">Upload new image to delete existing image</span></td>
<td align="left"><input type="hidden" name="MAX_FILE_SIZE" value="100000000000" /><input name="fphoto" type="file"  size="31"/></td
></tr>

<?php /*?><tr>
<td width="150" align="right"><strong>Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="300" align="left"><select style="Width:120px;" name="type" id="type" onchange="getschedule(this.value);">
                      <option value="">-Select-</option>
	                  <option value="Asset">Asset</option>
                         <option value="Capital">Capital</option>
					  <option value="Expense">Expense</option>
					  <option value="Liability">Liability</option>
					  <option value="Revenue">Revenue</option>
			</select>
			&nbsp;<span id="type1" style="color:red;"></span>
</td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="150" align="right"><strong>Controll Type</strong>&nbsp;&nbsp;&nbsp;</td>
<td width="300" align="left">
<select style="Width:180px" name="ctype" id="ctype" >
                      <option value=""></option>
			</select>
</td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="150" align="right"><strong>Schedule</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="300" align="left">
<select style="Width:220px" name="schedule" id="schedule" >
                      <option value="">-Select-</option>
			</select>&nbsp;&nbsp;<a href="dashboard.php?page=ac_addschedule"><img src="images/icons/fugue/plus.png" title="Add New Schedule" border="0px" /></a>
			&nbsp;<span id="schedule1" style="color:red;"></span>
</td>
</tr>

<tr height="10px"><td></td></tr><?php */?>

<tr>
<td colspan="5" align="center">
<br />
<center>
<input type="submit" value="Update" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=farmregdisplay';">
</center>
</td>
</tr>
</table>
</center>
<br /><br /><br />
</form>
<script language="JavaScript" type="text/javascript">

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.remove(i);
	}
}


function checkform(form)
{

/* var noalpha = /^[a-zA-Z.0-9]*$/;
 var noalpha1 = /^[a-zA-Z.0-9.\s]*$/;
 var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";
 var nonums = /^[0-9]*$/;
 var numericExpression = /^[0-9].+$/;*/
 if (form.frvname.value == "") 
 {
 alert("Please enter the Farm and Village");
   //document.getElementById("frvname").innerHTML = "Please enter the Farm and Village";
  // document.getElementById("frvname").setAttribute("class","error relative");
   form.frvname.focus();
   return false ;
 }
 else if (form.fname.value == "") 
 {
 alert("Please enter the Farmer's Name");
   //document.getElementById("fname").innerHTML = "Please enter the Farmer's Name";
   //document.getElementById("fname").setAttribute("class","error relative");
   form.fname.focus();
   return false ;
 }
 
 
/* else if ((!(form.code.value.match(noalpha)))) 
 {
   document.getElementById("code1").innerHTML = "Code cannot have special charaters";
   document.getElementById("code").setAttribute("class","error relative");
   form.code.focus();
   return false ;
 }*/
 else if (form.pan.value.length !=	10 ) 
 {
 alert("PAN should be of 10 characters");
  //document.getElementById("pan").innerHTML = "PAN should be of 10 characters";
  //document.getElementById("pan").setAttribute("class","error relative");
  form.pan.focus();
  return false ;
 }
/*else if (form.description.value == "") 
{
  document.getElementById("code1").innerHTML = "";
  document.getElementById("code").setAttribute("class","");
  document.getElementById("description1").innerHTML = "Please enter description";
  document.getElementById("description").setAttribute("class","error relative");
  form.description.focus();
  return false ;
}
else if ((!(form.description.value.match(noalpha1)))) 
{
  document.getElementById("code1").innerHTML = "";
  document.getElementById("code").setAttribute("class","");
  document.getElementById("description1").innerHTML = "Description cannot have special characters";
  document.getElementById("description").setAttribute("class","error relative");
  form.description.focus();
  return false ;
 }
 else if (form.description.value.length > 45 ) 
 {
  document.getElementById("code1").innerHTML = "";
  document.getElementById("code").setAttribute("class","");
  document.getElementById("description1").innerHTML = "Description Should not be morethan 45 characters";
  document.getElementById("description").setAttribute("class","error relative");
  form.description.focus();
  return false ;
  }
else if (form.type.value == "") 
{
  document.getElementById("description1").innerHTML = "";
  document.getElementById("description").setAttribute("class","");
  document.getElementById("type1").innerHTML = "Please select a type";
  document.getElementById("type").setAttribute("class","error relative");
  form.type.focus();
  return false ;
}
else if (form.schedule.value == "") 
{
  document.getElementById("type1").innerHTML = "";
  document.getElementById("type").setAttribute("class","");
  document.getElementById("schedule1").innerHTML = "Please select a schedule";
  document.getElementById("schedule").setAttribute("class","error relative");
  form.schedule.focus();
    return false ;
  } */
  else
  {  
  return true ;
  }
}
</script>

<script type="text/javascript">
function script1() {
window.open('GLHelp/help_m_addcoa.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>