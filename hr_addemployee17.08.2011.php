<?php 
      session_start();
	  include "config.php"; 
	  //include "getemployee.php";
	 $client = $_SESSION['client'];
?>

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
       $query1 = "SELECT max(id) as `id` FROM hr_employee ORDER BY id ASC ";
       $result1 = mysql_query($query1,$conn);
       while($row1 = mysql_fetch_assoc($result1))
       {
          $id = $row1['id'] + 1;
       }
 ?> 

<link href="editor/sample.css" rel="stylesheet" type="text/css"/>

<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" id="complex_form" method="post" action="hr_saveemployee.php">
	  <h1>Add Employee</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
		<div class="columns">
			<div class="col200pxL-left">
				<h2>&nbsp;</h2><br /><br />

				<ul class="side-tabs js-tabs same-height">
					<li><a href="#tab-po" title="Employee Details">Employee Details</a></li>
					<li><a href="#tab-taxes" title="Personal Information">Personal Information</a></li>
     				      <li><a href="#tab-charges" title="References">References</a></li>
					<li><a href="#tab-discounts" title="Emergency Contact">Emergency Contact</a></li>
				</ul>				
						
			</div>
		<div class="col200pxL-right">
		
<br />

<!-- /////////////////////////////Employee Details/////////////////////////////////////////// -->

<div id="tab-po" class="tabs-content" style="height:350px">
<center>   <br />    <br /> 
 <table border="0" id="table-po">
     <tr>
	 	<td align="right">
			<strong>Title&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left">
		<select name="title" id="title">
			<option value="Dr.">
			Dr.
			</option>
			<option value="Mr.">
			Mr.
			</option>
			<option title="Mrs.">
			Mrs.
			</option>
			<option value="Ms.">
			Ms.
			</option>
		</select>
		</td>
		
		<td width="10px"></td>
		
	 	<td align="right" title="Employee Name">
			<strong>Emp. Name&nbsp;&nbsp;&nbsp;</strong>
		</td>
	 	<td align="left">
			<input type="text" name="name" size="25" id="name"/>
		</td>
		
		<td width="10px"></td>
		
	 	<td align="right" title="Employee Id">
			<strong>Emp. ID&nbsp;&nbsp;&nbsp;</strong>
		</td>
	 	<td align="left">
			<input type="text" style="background:none;border:none;" name="employeeid" readonly id="employeeid" size="10" value="<?php echo $id; ?>" />
		</td>
		</tr>
		
		<tr style="height:20px"></tr>
		
		<tr>
	 	<td align="right">
			<strong>Sector&nbsp;&nbsp;&nbsp;</strong>
		</td>
	 	<td align="left">
			<select name="sector" id="sector" onChange="farmhv();" style="width:150px">
			<?php
			 $query = "SELECT * FROM tbl_sector WHERE type1 != 'Warehouse' ORDER BY sector ASC ";
			 $result = mysql_query($query,$conn); $i = 0;
			 while($row1 = mysql_fetch_assoc($result))
 			{
			?>
			<option value="<?php echo $row1['sector']; ?>"><?php echo $row1['sector']; ?>
			</option>
			<?php } ?> 
			</select>
		</td>
		<td width="10px"></td>
	 	<td align="right">
			<strong>Group&nbsp;&nbsp;&nbsp;</strong>
		</td>
	 	<td align="left">
			<select name="group" id="group" style="width:100px">
			<?php
			 $query = "SELECT distinct(groupname) FROM hr_group ORDER BY groupname ASC ";
			 $result = mysql_query($query,$conn); $i = 0;
			 while($row1 = mysql_fetch_assoc($result))
			 {
			?>
			<option value="<?php echo $row1['groupname']; ?>"><?php echo $row1['groupname']; ?></option>
			<?php } ?>
			</select>
		</td>
		
		<td width="10px"></td>
	 	<td align="right" id="farmtd" style="visibility:hidden">
			<strong><span id="spanfarm">Farm</span>&nbsp;&nbsp;&nbsp;</strong>
		</td>
	 	<td align="left" id="farmtd1" style="visibility:hidden">
			<select name="farm[]" id="farm" style="visibility:hidden;width:150px;vertical-align:middle" size="2" multiple="multiple">
			</select>
		</td>

     </tr>
	 
	<tr style="height:20px"></tr>
		
	<tr>
	 	<td align="right">
			<strong>Salary&nbsp;&nbsp;&nbsp;</strong>
		</td>
	 	<td align="left">
		<input type="text" name="salary" id="salary" size="12" value="0" style="text-align:right"/>
		</td>
		
     	<td width="10px"></td>
		
	 	<td align="right">
			<strong>Sal. Type&nbsp;&nbsp;&nbsp;</strong>
		</td>
	 	<td align="left">
		<select name="salarytype" id="salarytype" style="width:70"><option>Daily</option><option selected="selected">Monthly</option></select>
		</td>

     	<td width="10px"></td>
		
	 	<td align="right">
			<strong>Advance&nbsp;&nbsp;&nbsp;</strong>
		</td>
	 	<td align="left">
		<input type="text" name="advance" id="advance" size="12" value="0" style="text-align:right"/>
		</td>
     	
    </tr>

	<tr style="height:20px"></tr>
		
	<tr>
	 	
		<td align="right">
			<strong>Savings&nbsp;&nbsp;&nbsp;</strong>
		</td>
	 	<td align="left">
		<input type="text" name="savings" id="savings" size="12" value="0" style="text-align:right"/>
		</td>

		<td width="10px"></td>
		
		<td align="right">
			<strong>Designation&nbsp;&nbsp;&nbsp;</strong>
		</td>
	 	<td align="left">
			<select name="designation" id="designation" style="width:120px">
			<?php
			 $query = "SELECT * FROM hr_designation ORDER BY name ASC ";
			 $result = mysql_query($query,$conn); $i = 0;
			 while($row1 = mysql_fetch_assoc($result))
			 {
			?>
			<option value="<?php echo $row1['name']; ?>"><?php echo $row1['name']; ?></option>
			<?php } ?> 
			</select>
		</td>

		<td width="10px"></td>

		<td align="right">
			<strong title="Date of Joining">D.O.J&nbsp;&nbsp;&nbsp;</strong>
		</td>
	 	<td align="left">
		<input type="text" size="15" id="joiningdate" class="datepicker" name="joiningdate" value="<?php echo date("d.m.Y"); ?>">
		</td>

	</tr>
	
	<tr style="height:20px"></tr>
		
	<tr>
	 	
		<td align="right">
			<strong>Rpt. To&nbsp;&nbsp;&nbsp;</strong>
		</td>
	 	<td align="left">
		<select name="reportingto" id="reportingto" style="width:120px">
		<?php
		$query = "SELECT distinct(reportingto),name FROM hr_employee where designation='Manager' or designation = 'Supervisor' or designation = 'CEO' ORDER BY name ASC ";
		 $result = mysql_query($query,$conn); $i = 0;
		 while($row1 = mysql_fetch_assoc($result))
		 {
		?>
		<option value="<?php echo $row1['name']; ?>"><?php echo $row1['name']; ?></option>
		<?php } ?> 
		</select>

		</td>

		<td width="10px"></td>
		<td align="right">
			<strong>Salary A/C&nbsp;&nbsp;&nbsp;</strong>
		</td>
	 	<td align="left">
		<select name="salaryac" id="salaryac" style="width:100px">
		<?php
		$query = "SELECT distinct(code),description FROM ac_coa where type='Expense' ORDER BY code ASC ";
		 $result = mysql_query($query,$conn); $i = 0;
		 while($row1 = mysql_fetch_assoc($result))
		 {
		?>
		<option title="<?php echo $row1['description']; ?>" value="<?php echo $row1['code']; ?>"><?php echo $row1['code']; ?></option>
		<?php } ?> 
		</select>
		</td>
		
		<td width="10px"></td>
		<td align="right">
			<strong>Loan&nbsp;&nbsp;A/C&nbsp;&nbsp;</strong>
		</td>
	 	<td align="left">
		<select name="loanac" id="loanac" style="width:100px">
		<?php
		$query = "SELECT distinct(code),description FROM ac_coa where type='Liability' ORDER BY code ASC ";
		 $result = mysql_query($query,$conn); $i = 0;
		 while($row1 = mysql_fetch_assoc($result))
		 {
		?>
		<option title="<?php echo $row1['description']; ?>" value="<?php echo $row1['code']; ?>"><?php echo $row1['code']; ?></option>
		<?php } ?> 
		</select>
		</td>
		
	</tr>
	<tr style="height:20px"></tr>
	<tr>	
		
		<td align="right">
			<strong>Image&nbsp;&nbsp;&nbsp;</strong>
		</td>
	 	<td align="left" colspan="3">
		 <!-- <input name="uploadedfile" type="file" width="15px" size="20" /> -->
<div id="sampleFile">
<?php 
if($_SESSION['client'] == 'KEHINDE')
{
include_once('fileupload.php');
}
else
{ include_once('file/fileupload.php');
} ?>
</div>
		</td>

	</tr>
	
   </table>
 </center>
</div>

<!-- /////////////////////////////Personal Information/////////////////////////////////////////// -->

<div id="tab-taxes" class="tabs-content">
   <center>
   <br />
<br />

      <table border="0" id="table-taxes">
      <tr>
	 	<td align="right">
			<strong>Father&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left">
		<input type="text" name="fname" id="fname" size="25" />
		</td>
		
		<td width="10px"></td>
		
	 	<td align="center" colspan="2">
			<input type="radio" name="mar" id="unmar" onClick="marriagestatus()"/>&nbsp;<strong>Married</strong>
			&nbsp;&nbsp;
			<input type="radio" name="mar" id="unmar" onClick="marriagestatus()"/>&nbsp;<strong>Unmarried</strong>
		</td>
		
		<td width="10px"></td>
	 	<td align="right" id="spousetd" style="visibility:hidden">
		<strong>Spouse&nbsp;&nbsp;&nbsp;</strong>
		</td>		
	 	<td align="left">
			<input type="text" name="spouse" id="spouse" size="20" style="visibility:hidden" />
		</td>
		</tr>
		
		<tr style="height:20px"></tr>
        
		<tr>
	 	<td align="right">
			<strong>Gender&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left">
		<input type="radio" name="sex"  value="Male" /> <strong>Male</strong>
		&nbsp;&nbsp;
		<input type="radio" name="sex" value="Female" /> <strong>Female</strong>
		</td>
		
		<td width="10px"></td>

	 	<td align="right">
			<strong title="Date of Birth">D.O.B &nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left">
		<input type="text" value="<?php echo date('d.m.Y') ?>" class="datepicker" name="dob" id="dob" size="12">
		</td>
		
		<td width="10px"></td>

	 	<td align="right">
			<strong>Blood&nbsp;Group&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left">
			<select name="bloodgroup" id="bloodgroup" style="width:50px">
			<?php
			 $query = "SELECT * FROM hr_bloodgroup ORDER BY bloodgroup ASC ";
			 $result = mysql_query($query,$conn); $i = 0;
			 while($row1 = mysql_fetch_assoc($result))
			 {
			?>
			<option  value="<?php echo $row1['bloodgroup']; ?>"><?php echo $row1['bloodgroup']; ?></option>
			<?php } 
			?> 
			</select>
		</td>
		
		</tr>		
		
		<tr style="height:20px"></tr>
		
		<tr>
	 	<td align="left" colspan="2">
		<input type="radio" name="lic" id="lyes" onClick="licensestatus()"/>&nbsp;<strong>Drv. Lic.</strong>
		&nbsp;&nbsp;&nbsp;
		<input type="radio" name="lic" id="lno" onClick="licensestatus()"/> &nbsp;<strong>No Drv. Lic.</strong>
		</td>
		
		<td width="10px"></td>
	 	
		<td align="right" id="dltd" style="visibility:hidden">
		 <strong>Drv.&nbsp;Lic.&nbsp;#&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left" >
		<input type="text" style="visibility:hidden" name="drivinglicense" id="dlicense" size="15" onKeyUp="edl()"/>
		</td>
		
		<td width="10px"></td>
	 	
		<td align="right" id="edltd" style="visibility:hidden">
			<strong>Exp.of Lic.&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left">
		<input type="text" value="<?php echo date('d.m.Y') ?>" name="expdlicense" id="expdlicense" size="12" class="datepicker" style="visibility:hidden">
		</td>
		</tr>
		
		<tr style="height:20px"></tr>
		
		<tr>
	 	<td align="left" colspan="2">
		<input type="radio" name="veh" id="vehyes" onClick="vehiclestatus()"/>&nbsp;<strong>Vehicle</strong>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" name="veh" id="vehno" onClick="vehiclestatus()"/>&nbsp;<strong>No Vehicle</strong>
		</td>
			
		<td width="10px"></td>
		<td align="right" id="vehtd" style="visibility:hidden">
			<strong>Vehicle #&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left" >
		<input type="text" style="visibility:hidden" name="vehicleno" id="vehicleno" size="15" onKeyUp="vehicleino()"/>
		</td>

		<td width="10px"></td>
		<td align="right" id="vino" style="visibility:hidden">
			<strong>Veh. Ins. #&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left" >
		<input type="text" style="visibility:hidden" name="vinsurance" id="vinsurance" size="15" onKeyUp="evi()"/>
		</td>
	</tr>
	
			<tr style="height:20px"></tr>
		
		<tr>
	 	<td align="right">
			<strong>Qualification&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left">
		<select name="qualification" id="qualification" style="width:85px">
		<?php
			 $query = "SELECT * FROM hr_qualification ORDER BY qualification ASC ";
			 $result = mysql_query($query,$conn); $i = 0;
			 while($row1 = mysql_fetch_assoc($result))
			 {
			?>
			<option  value="<?php echo $row1['qualification']; ?>"><?php echo $row1['qualification']; ?></option>
			<?php } 
			?> 

		</select>
		</td>
		
		<td width="10px"></td>
		<td align="right">
<?php 
if($client == 'KEHINDE')
{ ?>
<strong>IDEF No.&nbsp;&nbsp;&nbsp;</strong>
<?php }
else
{ ?>
<strong>PAN Card&nbsp;&nbsp;&nbsp;</strong>
<?php } ?>
		
		</td>
		<td align="left" >
		<input type="text" name="pancard" id="pancard" size="15"/>
		</td>

		<td width="10px"></td>
		<td align="right" id="expvtd" style="visibility:hidden">
			<strong>Exp.of Ins.&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left">
		<input type="text" value="<?php echo date('d.m.Y') ?>" readonly name="expvinsurance" id="expvinsurance" size="12" class="datepicker" style="visibility:hidden" id="expvinsurance">
		</td>
		
		</tr>
		
		<tr style="height:20px"></tr>
		
		<tr>
		
		<td align="right">
			<strong>Bank&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left" style="vertical-align:top">
		
		<select name="bank" id="bank" onChange="bank1(this.value);" style="visibility:visible;position:absolute;width:150px">
		<?php
		 $query = "SELECT distinct(bankname) FROM bankdetails ORDER BY bankname ASC ";
		 $result = mysql_query($query,$conn); $i = 0;
		 while($row1 = mysql_fetch_assoc($result))
		 {
		?>
		<option value="<?php echo $row1['bankname']; ?>"><?php echo $row1['bankname']; ?></option>
		<?php } ?>
		<option value="other">Other</option>
		</select>
		
		<input type="text" name="bankname" id="bankname" style="visibility:hidden;position:absolute" size="25" />
		</td>
		
		<td width="10px"></td>		

		<td align="right">
			<strong>Branch&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left" >
		<input type="text" name="bankbranch"  id="bankbranch" size="20"/>
		</td>

		<td width="10px"></td>		

		<td align="right">
			<strong>A/C. #&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left" >
		<input type="text" name="accountno"  id="accountno" size="15"/>
		</td>
		
		</tr>

		<tr style="height:20px"></tr>
		
		<tr>
		
		<td align="right">
			<strong>IFSC Code&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left">
		<input type="text" name="ifsc" id="ifsc" size="15" />
		</td>

		<td width="10px"></td>	
		<td align="right">
			<strong>Contact #&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left">
		<input type="text" name="personalcontact" id="personalcontact" size="15" />
		</td>

		<td width="10px"></td>	
		<td align="right">
			<strong>Company #&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left">
		<input type="text" name="companycontact" id="companycontact" size="15" />
		</td>
		<td width="10px"></td>	
	
		</tr>		
		
		<tr style="height:20px"></tr>
		
		<tr>
		
		<td align="right" style="vertical-align:middle">
			<strong>Country&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left" style="vertical-align:middle">
		<select name="country" id="country" style="width:165px" >
		<?php
		$get_entriess1 = "select * from countries order by country_name Asc ";
		$get_entriess_res2 = mysql_query($get_entriess1,$conn) or die(mysql_error());
		 while ($row1 = mysql_fetch_array($get_entriess_res2)) {
		 
		 if ($row1['country_name'] == 'India')
		 {
		?>
		<option selected="selected" value="<?php echo $row1['country_name']; ?>"><?php echo $row1['country_name']; ?></option>
		<?php
		} 
		else
		{
		?>
		<option value="<?php echo $row1['country_name']; ?>"><?php echo $row1['country_name']; ?></option>
		<?php } 
		
		
		} ?>
		</select> 
		</td>

		<td width="10px"></td>	
		
		<td align="right" style="vertical-align:middle">
			<strong>Address &nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left" style="vertical-align:middle" colspan="3">
		<textarea rows="4" cols="20" name="address"></textarea>
		</td>
	
		</tr>	
		
     </table>
   <br />
  </center>
</div>

<!-- /////////////////////////////References/////////////////////////////////////////// -->

<div id="tab-charges" class="tabs-content">
   <center>
<br /><br /><br />
<table id="table-charges">
<tr>

<td colspan="3">
<strong>Reference-1 Details</strong>
</td>
<td colspan="3">
<strong>Reference-2 Details</strong>
</td>
</tr>
<tr style="height:20px"></tr>
<tr style="height:20px"></tr>
<tr>
<td align="right"><strong>Name</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="ref1name" size="25" /></td>
<td width="10px"></td>
<td align="right"><strong>Name</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="ref2name" size="25" /></td>
</tr>

<tr style="height:20px"></tr>

<tr>
<td align="right"><strong>Address</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><textarea rows="4" cols="20" name="ref1address" ></textarea></td>
<td width="10px"></td>
<td align="right"><strong>Address</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><textarea rows="4" cols="20" name="ref2address" ></textarea></td>
</tr>

<tr style="height:20px"></tr>

<tr>
<td align="right"><strong>Country</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left">
<select name="ref1country" id="ref1country" style="width:165px">
<?php
$get_entriess1 = "select * from countries order by country_name Asc ";
$get_entriess_res2 = mysql_query($get_entriess1,$conn) or die(mysql_error());
 while ($row1 = mysql_fetch_array($get_entriess_res2)) {

		 if ($row1['country_name'] == 'India')
		 {
		?>
		<option selected="selected" value="<?php echo $row1['country_name']; ?>"><?php echo $row1['country_name']; ?></option>
		<?php
		} 
		else
		{
		?>
		<option value="<?php echo $row1['country_name']; ?>"><?php echo $row1['country_name']; ?></option>
		<?php } 
		
}
?>

</select> 
</td>
<td width="10px"></td>
<td align="right"><strong>Country</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left">
<select name="ref2country" id="ref2country" style="width:165px">
<?php
include("config.php");
$get_entriess1 = "select * from countries order by country_name Asc ";
$get_entriess_res2 = mysql_query($get_entriess1,$conn) or die(mysql_error());
 while ($row1 = mysql_fetch_array($get_entriess_res2)) {

		 if ($row1['country_name'] == 'India')
		 {
		?>
		<option selected="selected" value="<?php echo $row1['country_name']; ?>"><?php echo $row1['country_name']; ?></option>
		<?php
		} 
		else
		{
		?>
		<option value="<?php echo $row1['country_name']; ?>"><?php echo $row1['country_name']; ?></option>
		<?php  
		}} ?>
</select> 
</td>
</tr>

<tr style="height:20px"></tr>

<tr>
<td align="right"><strong>Contact No 1</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="ref1contact1" size="15" /></td>
<td width="10px"></td>
<td align="right"><strong>Contact No 1</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="ref2contact1" size="15" /></td>
</tr>

<tr style="height:20px"></tr>

<tr>
<td align="right"><strong>Contact No 2</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="ref1contact2" size="15" /></td>
<td width="10px"></td>
<td align="right"><strong>Contact No 2</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="ref2contact2" size="15" /></td>
</tr>

</table>

   <br />
  </center>

</div>

<!-- /////////////////////////////Emergency Contact/////////////////////////////////////////// -->

<div id="tab-discounts" class="tabs-content">
   <center>
<br /><br /><br />
<table border="0" id="table-discounts">
<tr>
<td align="right"><strong>Name</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="eref1name" size="25" /></td>
</tr>
<tr style="height:20px"></tr>
<tr>
<td align="right"><strong>Address</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><textarea rows="4" cols="20" name="eref1address" ></textarea></td>
</tr>
<tr style="height:20px"></tr>
<tr>
<td align="right"><strong>Country</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left">
<select name="eref1country" id="eref1country" style="width:175px">
<?php
include("config.php");
$get_entriess1 = "select * from countries order by country_name Asc ";
$get_entriess_res2 = mysql_query($get_entriess1,$conn) or die(mysql_error());
 while ($row1 = mysql_fetch_array($get_entriess_res2)) {
 if ($row1['country_name']=='India' )
 {
?>
<option selected ="slected" value="<?php echo $row1['country_name']; ?>"><?php echo $row1['country_name']; ?></option>
<?php }
else
{ ?>
<option value="<?php echo $row1['country_name']; ?>"><?php echo $row1['country_name']; ?></option>
<?php 
}
}
?>
</select> 
</td>
</tr>
<tr style="height:20px"></tr>
<tr>
<td align="right"><strong>Contact No 1</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="eref1contact1" size="15" /></td>
</tr>
<tr style="height:20px"></tr>
<tr>
<td align="right"><strong>Contact No 2</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="eref1contact2" size="15" /></td>
</tr>

     </table>
   <br />
   <input type="submit" value="Save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Back" onclick="top.location='dashboard.php?page=hr_employee';">
  </center>
</div>
						
					</div>
					
				</div>
				
			</form></div>
		</section>
		
		<div class="clear"></div>


<br />
<script type="text/javascript">
function script1() {
window.open('HRHELP/help_m_addemployee.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
<!-- Javascripts -->
<script type="text/javascript">
function farmhv()
{
if(document.getElementById("sector").value == "Integration")
document.getElementById("spanfarm").innerHTML = "Farm";
else if(document.getElementById("sector").value == "Breeding Farm")
document.getElementById("spanfarm").innerHTML = "Unit";
else
document.getElementById("spanfarm").innerHTML = "";
removeAllOptions(document.getElementById("farm"));
			  myselect1 = document.getElementById("farm");
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
              theOption1.appendChild(theText1);
			  theOption1.disabled = true;
              myselect1.appendChild(theOption1);
			  
if(document.getElementById("sector").value == "Integration")
{
document.getElementById("farm").style.visibility = "visible";
document.getElementById("farmtd").style.visibility = "visible";
document.getElementById("farmtd1").style.visibility = "visible";
 		<?php

 $query = "SELECT distinct(name) FROM broiler_farmers ORDER BY name ASC ";
 $result = mysql_query($query);
 while($row1 = mysql_fetch_assoc($result))
 {
?>
              theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("<?php echo $row1['name']; ?>");
			  theOption1.value = "<?php echo $row1['name']; ?>";
			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);
			 
    <?php } ?>
}
else if(document.getElementById("sector").value == "Breeding Farm")
{
document.getElementById("farm").style.visibility = "visible";
document.getElementById("farmtd").style.visibility = "visible";
document.getElementById("farmtd1").style.visibility = "visible";
<?php
 $query = "SELECT distinct(name) FROM tbl_unit ORDER BY name ASC ";
 $result = mysql_query($query);
 while($row1 = mysql_fetch_assoc($result))
 {
?>
              theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("<?php echo $row1['name']; ?>");
			  theOption1.value = "<?php echo $row1['name']; ?>";
			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);
			 
    <?php } ?>
}
else
{
document.getElementById("farmtd").style.visibility = "hidden";
document.getElementById("farmtd1").style.visibility = "hidden";
document.getElementById("farm").style.visibility = "hidden";
removeAllOptions(document.getElementById("farm"));
}
}

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.remove(i);
	}
}

function marriagestatus()
{
if(document.getElementById('unmar').checked == true)
{
document.getElementById('spousetd').style.visibility = 'visible';
document.getElementById('spouse').style.visibility = 'visible';
}
else
{
document.getElementById('spousetd').style.visibility = 'hidden';
document.getElementById('spouse').style.visibility = 'hidden';
document.getElementById('spouse').value = '';
}

}

function licensestatus()
{

if(document.getElementById('lyes').checked == true)
{
document.getElementById('dltd').style.visibility = 'visible';
document.getElementById('dlicense').style.visibility = 'visible';
}
else
{
document.getElementById('dltd').style.visibility = 'hidden';
document.getElementById('dlicense').style.visibility = 'hidden';
document.getElementById('dlicense').value = '';

document.getElementById('edltd').style.visibility = 'hidden';
document.getElementById('expdlicense').style.visibility = 'hidden';
}

}

function edl()
{

if(document.getElementById('dlicense').value != '')
{
document.getElementById('edltd').style.visibility = 'visible';
document.getElementById('expdlicense').style.visibility = 'visible';
}
else
{
document.getElementById('edltd').style.visibility = 'hidden';
document.getElementById('expdlicense').style.visibility = 'hidden';
}

}

function vehiclestatus()
{

if(document.getElementById('vehyes').checked == true)
{
document.getElementById('vehtd').style.visibility = 'visible';
document.getElementById('vehicleno').style.visibility = 'visible';
}
else
{
document.getElementById('vehtd').style.visibility = 'hidden';
document.getElementById('vehicleno').style.visibility = 'hidden';
document.getElementById('vehicleno').value = '';

document.getElementById('vino').style.visibility = 'hidden';
document.getElementById('vinsurance').style.visibility = 'hidden';
document.getElementById('expvtd').style.visibility = 'hidden';
document.getElementById('expvinsurance').style.visibility = 'hidden';
document.getElementById('vinsurance').value = '';
}
}

function vehicleino()
{

if(document.getElementById('vehicleno').value != '')
{
document.getElementById('vino').style.visibility = 'visible';
document.getElementById('vinsurance').style.visibility = 'visible';
}
else
{
document.getElementById('vino').style.visibility = 'hidden';
document.getElementById('vinsurance').style.visibility = 'hidden';
document.getElementById('expvtd').style.visibility = 'hidden';
document.getElementById('expvinsurance').style.visibility = 'hidden';
document.getElementById('vinsurance').value = '';
}

}

function evi()
{

if(document.getElementById('vinsurance').value != '')
{
document.getElementById('expvtd').style.visibility = 'visible';
document.getElementById('expvinsurance').style.visibility = 'visible';
}
else
{
document.getElementById('expvtd').style.visibility = 'hidden';
document.getElementById('expvinsurance').style.visibility = 'hidden';
}

}

function bank1(a) 
{
 
if ( a == 'other' )
{
document.getElementById('bank').style.visibility = 'hidden';
document.getElementById('bankname').style.visibility = 'visible';
document.getElementById('bankname').focus();
}
}
</script>