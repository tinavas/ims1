<?php include "jquery.php"; 
	  include "config.php"; 
?>
 <?php
       include "config.php";
       $query1 = "SELECT * FROM hr_employee where employeeid='$_GET[id]' ";
       $result1 = mysql_query($query1,$conn);
       while($row1 = mysql_fetch_assoc($result1))
       {
          $id = $row1['employeeid'];
  		  $sector = $row1['sector'];
          $groupname = $row1['groupname'];
		  $employeeid = $row1['employeeid'];
		  $salarytype = $row1['salarytype'];
		  $name = $row1['name'];
		  $salary = $row1['salary'];
		  $fname = $row1['fname'];
		  //$advance = $row1['advance'];
		  $sex = $row1['sex'];
		 // $savings = $row1['savings'];
		  $dob = date("d.m.Y",strtotime($row1['dob']));
		  $vehicleno = $row1['vehicleno'];
		  $bloodgroup = $row1['bloodgroup'];
		  $qualification = $row1['qualification'];
		  $designation = $row1['designation'];
		  $vinsurance = $row1['vinsurance'];
		  $joiningdate = date("d.m.Y",strtotime($row1['joiningdate']));
		  $drivinglicense = $row1['drivinglicense'];
		  $address = $row1['address'];
		  $leaves = $row1['leaves'];
		//  $expenseac=$row1['expenseac'];
		 // $advanceac=$row1['advanceac'];
		  if($leaves == "")
		  {
		  $leaves =0;
		  }
		  
		  $mdate = explode("-",$row1['expvinsurance']);
		  $expvinsurance = $mdate[2] . '.' . $mdate[1] . '.' . $mdate[0];
		  
		  
		  $personalcontact = $row1['personalcontact'];
		  
		  $mdate = explode("-",$row1['expdlicense']);
		  $expdlicense = $mdate[2] . '.' . $mdate[1] . '.' . $mdate[0];
		  
		  $companycontact = $row1['companycontact'];
		  $farm = explode(",",$row1['farm']);
		  $bank = $row1['bank'];
		  $accountno = $row1['accountno'];
		  $bankbranch = $row1['bankbranch'];
		  $ifsc = $row1['ifsc'];
		  $pancard = $row1['pancard'];
		  $reportingto = $row1['reportingto'];
		  
		  $ref1name = $row1['ref1name'];
		  $ref1address = $row1['ref1address'];
		  $ref1contact1 = $row1['ref1contact1'];
		  $ref1contact2 = $row1['ref1contact2'];
		  $ref2name = $row1['ref2name'];
		  $ref2address = $row1['ref2address'];
		  $ref2contact1 = $row1['ref2contact1'];
		  $ref2contact2 = $row1['ref2contact2'];
		  
		  $spouse = $row1['spouse'];
		  $title = $row1['title'];
		  $bgroup = $row1['bgroup'];
		  $eref1name = $row1['eref1name'];
		  $eref1address = $row1['eref1address'];
		  $eref1contact1 = $row1['eref1contact1'];
		  $eref1contact2 = $row1['eref1contact2'];
		  
		  $countryname = $row1['country'];
		  $ref1country = $row1['ref1country'];
		  $ref2country = $row1['ref2country'];
		  $eref1country = $row1['eref1country'];
		  
		  $salaryac = $row1['salaryac'];
		  $loanac = $row1['loanac'];
		  
       }
 ?> 
<link href="editor/sample.css" rel="stylesheet" type="text/css"/>

<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" enctype="multipart/form-data" id="complex_form" method="post" action="hr_updateemployee.php">
	 <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
	  <h1>Edit Employee</h1>
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
			<option value="Dr." <?php if($title == "Dr.") {?> selected="selected" <?php } ?>>
			Dr.
			</option>
			<option value="Mr." <?php if($title == "Mr.") {?> selected="selected" <?php } ?>>
			Mr.
			</option>
			<option title="Mrs." <?php if($title == "Mrs.") {?> selected="selected" <?php } ?>>
			Mrs.
			</option>
			<option value="Ms." <?php if($title == "Ms.") {?> selected="selected" <?php } ?>>
			Ms.
			</option>
		</select>
		</td>
		
		<td width="10px"></td>
		
	 	<td align="right">
			<strong>Emp. Name&nbsp;&nbsp;&nbsp;</strong>
		</td>
	 	<td align="left">
			<input type="text" name="name" size="25" id="name" value="<?php echo $name; ?>"/>
		</td>
		
		<td width="10px"></td>
		
	 	<td align="right">
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
			 //$query = "SELECT * FROM tbl_sector WHERE type1 != 'Warehouse' ORDER BY sector ASC ";
			  $query = "SELECT * FROM tbl_sector  ORDER BY sector ASC ";
			 $result = mysql_query($query,$conn); $i = 0;
			 while($row1 = mysql_fetch_assoc($result))
 			{
			?>
			<option value="<?php echo $row1['sector']; ?>" <?php if($sector == $row1['sector']) { ?> selected="selected" <?php } ?>><?php echo $row1['sector']; ?>
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
			<option value="<?php echo $row1['groupname']; ?>" <?php if($groupname == $row1['groupname']) { ?> selected="selected" <?php } ?>><?php echo $row1['groupname']; ?></option>
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
		<input type="text" name="salary" id="salary" size="12" value="<?php echo $salary;  ?>" style="text-align:right"/>
		</td>
		
     	<td width="10px"></td>
		
	 	<td align="right">
			<strong>Sal. Type&nbsp;&nbsp;&nbsp;</strong>
		</td>
	 	<td align="left">
		<select name="salarytype" id="salarytype" style="width:70">
		<option <?php if($salarytype == "Daily") {?> selected="selected" <?php } ?>>Daily</option>
		<option <?php if($salarytype == "Monthly") {?> selected="selected" <?php } ?>>Monthly</option>
		</select>
		</td>

     	<?php /*?><td width="10px"></td>
		
	 	<td align="right">
			<strong>Advance&nbsp;&nbsp;&nbsp;</strong>
		</td>
	 	<td align="left">
		<input type="text" name="advance" id="advance" size="12" style="text-align:right" value="<?php echo $advance;  ?>"/>
		</td><?php */?>
     	
    </tr>

	<tr style="height:20px"></tr>
		
	<tr>
	 	
		<?php /*?><td align="right">
			<strong>Savings&nbsp;&nbsp;&nbsp;</strong>
		</td>
	 	<td align="left">
		<input type="text" name="savings" id="savings" size="12" value="<?php echo $savings;  ?>" style="text-align:right"/>
		</td>

		<td width="10px"></td><?php */?>
		
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
			<option value="<?php echo $row1['name']; ?>" <?php if($row1['name'] == $designation) { ?> selected="selected" <?php } ?>><?php echo $row1['name']; ?></option>
			<?php } ?> 
			</select>
		</td>

		<td width="10px"></td>

		<td align="right">
			<strong>D.O.J&nbsp;&nbsp;&nbsp;</strong>
		</td>
	 	<td align="left">
		<input type="text" size="15" id="joiningdate" class="datepicker" name="joiningdate" value="<?php echo $joiningdate; ?>">
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
		$query = "SELECT distinct(reportingto),name FROM hr_employee where designation In ('Manager','Supervisor','CEO','Account Officer','General Manager','Chief Financial Officer','Farm Manager','Veterinary Doctor') ORDER BY name ASC ";
		 $result = mysql_query($query,$conn); $i = 0;
		 while($row1 = mysql_fetch_assoc($result))
		 {
		?>
		<option value="<?php echo $row1['name']; ?>" <?php if($reportingto == $row1['name']) { ?> selected="selected" <?php } ?>><?php echo $row1['name']; ?></option>
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
		<option title="<?php echo $row1['description']; ?>" value="<?php echo $row1['code']; ?>" <?php if($row1['code'] == $salaryac) { ?> selected="selected" <?php } ?>><?php echo $row1['code']; ?></option>
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
		$query = "SELECT distinct(code),description FROM ac_coa where type='Asset' ORDER BY code ASC ";
		 $result = mysql_query($query,$conn); $i = 0;
		 while($row1 = mysql_fetch_assoc($result))
		 {
		?>
		<option title="<?php echo $row1['description']; ?>" value="<?php echo $row1['code']; ?>" <?php if($row1['code'] == $loanac) { ?> selected="selected" <?php } ?>><?php echo $row1['code']; ?></option>
		<?php } ?> 
		</select>
		</td>
		
	</tr>
	
	<tr style="height:20px"></tr>
	<tr>	
	
	<?php /*?>
		<td align="left">



			<strong>Expense&nbsp;&nbsp;A/C&nbsp;&nbsp;</strong>

		</td>
<td align="left">

		<select name="expac" id="expac" style="width:100px">

		<option value="" >-select-</option>

		<?php

		$query = "SELECT distinct(code),description FROM ac_coa where type='Liability' ORDER BY code ASC ";

		 $result = mysql_query($query,$conn); $i = 0;

		 while($row1 = mysql_fetch_assoc($result))

		 {

		?>
		<option title="<?php echo $row1['description']; ?>" value="<?php echo $row1['code']; ?>" <?php if($expenseac == $row1['code']) { ?> selected="selected"<?php }?>><?php echo $row1['code']; ?></option>

		<?php } ?> 

		</select>

		</td>
		<td width="10px"></td>
		<td align="right">

			<strong>Advance&nbsp;&nbsp;A/C&nbsp;&nbsp;</strong>

		</td>

		<?php $query = "SELECT code FROM ac_coa where type='Asset' and description like 'ADVANCES TO STAFF AGAINST EXPENSES' ORDER BY code ASC limit 1 ";

		 $result = mysql_query($query,$conn); 

		 while($row1 = mysql_fetch_assoc($result))

		 {

		 $advac = $row1['code'];

		 }

		 ?>

	 	<td align="left">

		<select name="advac" id="advac" style="width:100px">

		<option value="" >-select-</option>

		<?php

		$query = "SELECT distinct(code),description FROM ac_coa where type='Asset' ORDER BY code ASC ";

		 $result = mysql_query($query,$conn); $i = 0;

		 while($row1 = mysql_fetch_assoc($result))

		 {

		?>

		<option title="<?php echo $row1['description']; ?>" value="<?php echo $row1['code']; ?>" <?php if($advanceac == $row1['code']) { ?> selected="selected"<?php }?>><?php echo $row1['code']; ?></option>

		<?php } ?> 

		</select>

		</td>
		
	<td height="10px"></td>
	
	<?php */?>
		<td align="right" title="Leaves Remaining">
			<strong>Leaves&nbsp;&nbsp;&nbsp;</strong>
		</td>
	 	<td align="left">
		<input type="text" name="leaves" id="leaves" size="12" value="<?php echo $leaves;?>" style="text-align:right"/>
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
		<input type="text" name="fname" id="fname" size="25" value="<?php echo $fname;?>"/>
		</td>
		
		<td width="10px"></td>
		
	 	<td align="center" colspan="2">
			<input type="radio" name="mar" id="unmar" <?php if($spouse !=""){ ?> checked="checked" <?php } ?> onClick="marriagestatus()"/>&nbsp;<strong>Married</strong>
			&nbsp;&nbsp;
			<input type="radio" name="mar" id="unmar" <?php if($spouse ==""){ ?> checked="checked" <?php } ?> onClick="marriagestatus()"/>&nbsp;<strong>Unmarried</strong>
		</td>
		
		<td width="10px"></td>
	 	<td align="right" id="spousetd" <?php if($spouse == "") { ?>style="visibility:hidden" <?php } else { ?> style="visibility:visible" <?php } ?>>
		<strong>Spouse&nbsp;&nbsp;&nbsp;</strong>
		</td>		
	 	<td align="left">
			<input type="text" name="spouse" id="spouse" size="20" <?php if($spouse == "") { ?>style="visibility:hidden" <?php } else { ?> style="visibility:visible" <?php } ?> value="<?php echo $spouse; ?>"/>
		</td>
		</tr>
		
		<tr style="height:20px"></tr>
        
		<tr>
	 	<td align="right">
			<strong>Gender&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left">
		<input type="radio" name="sex"  value="Male" <?php if($sex =="Male"){ ?> checked="checked" <?php } ?>/> <strong>Male</strong>
		&nbsp;&nbsp;
		<input type="radio" name="sex" value="Female" <?php if($sex =="Female"){ ?> checked="checked" <?php } ?>/> <strong>Female</strong>
		</td>
		
		<td width="10px"></td>

	 	<td align="right">
			<strong>D.O.B &nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left">
		<input type="text" value="<?php echo $dob; ?>"  class="datepicker" name="dob" id="dob" size="12">
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
			<option  value="<?php echo $row1['bloodgroup']; ?>" <?php if($bloodgroup == $row1['bloodgroup']) { ?> selected="selected" <?php } ?>><?php echo $row1['bloodgroup']; ?></option>
			<?php } 
			?> 
			</select>
		</td>
		
		</tr>		
		
		<tr style="height:20px"></tr>
		
		<tr>
	 	<td align="left" colspan="2">
		<input type="checkbox" name="lic" id="lyes" onClick="licensestatus()" <?php if($drivinglicense !=""){ ?> checked="checked" <?php } ?>/>&nbsp;<strong>Drv. Lic.</strong>
	<?php /*?>	&nbsp;&nbsp;&nbsp;
		<input type="radio" name="lic" id="lno" onClick="licensestatus()"  <?php if($drivinglicense ==""){ ?> checked="checked" <?php } ?>/> &nbsp;<strong>No Drv. Lic.</strong><?php */?>
		</td>
		
		<td width="10px"></td>
	 	
		<td align="right" id="dltd"  <?php if($drivinglicense!= "") { ?> style="visibility:visible" <?php } else { ?> style="visibility:hidden" <?php } ?> > 
			<strong> Drv.&nbsp;Lic.&nbsp;#&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left">
		<input type="text" <?php if($drivinglicense!= "") { ?> style="visibility:visible" <?php } else { ?> style="visibility:hidden" <?php } ?>value="<?php echo $drivinglicense; ?>"name="drivinglicense" id="dlicense" size="15" onKeyUp="edl()"/>
		</td>
		
		<td width="10px"></td>
	 	
		<td align="right" id="edltd" <?php  if($drivinglicense == ""){ ?> style="visibility:hidden" <?php } else { ?> style="visibility:visible" <?php } ?>>
			<strong>Exp.of Lic.&nbsp;&nbsp;&nbsp; </strong>
		 </td>
		<td align="left">
		<input type="text"  value="<?php echo $expdlicense; ?>" name="expdlicense" id="expdlicense" size="12" class="datepicker"  <?php if($drivinglicense == ""){ ?> style="visibility:hidden" <?php } else { ?> style="visibility:visible" <?php } ?>>
		</td>
		</tr>
		
		<tr style="height:20px"></tr>
		
		<tr>
	 	<td align="left" colspan="2">
		<input type="checkbox" name="veh" id="vehyes" <?php if($vehicleno !=""){ ?> checked="checked" <?php } ?> onClick="vehiclestatus()"/>&nbsp;<strong>Vehicle</strong>
		<?php /*?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" name="veh" id="vehno" <?php if($vehicleno ==""){ ?> checked="checked" <?php } ?> onClick="vehiclestatus()"/>&nbsp;<strong>No Vehicle</strong><?php */?>
		</td>
			
		<td width="10px"></td>
		<td align="right"  id="vehtd" <?php if($vehicleno !=""){ ?> style="visibility:visible" <?php } else { ?> style="visibility:hidden" <?php } ?> >
			<strong>Vehicle #&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left" >
		<input type="text" <?php if($vehicleno !=""){ ?> style="visibility:visible" <?php } else { ?> style="visibility:hidden" <?php } ?> name="vehicleno" id="vehicleno" size="15" onKeyUp="vehicleino()" value="<?php echo $vehicleno; ?>"/>
		</td>

		<td width="10px"></td>
		<td align="right"  id="vino" <?php if($vinsurance !=""){ ?> style="visibility:visible" <?php } else { ?> style="visibility:hidden" <?php } ?>>
			<strong>Veh. Ins. #&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left" >
		<input type="text"  <?php if($vinsurance !=""){ ?> style="visibility:visible" <?php } else { ?> style="visibility:hidden" <?php } ?> name="vinsurance" id="vinsurance" size="15" value="<?php echo $vinsurance; ?>"onKeyUp="evi()"/>
		</td>
	</tr>
	
			<tr style="height:20px"></tr>
		
		<tr>
	 	<td align="right">
			<strong>Qualification&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left">
		<select name="qualification" id="qualification" style="width:85px">
		<option <?php if($qualification =="B.A"){ ?> selected="selected" <?php } ?>>
		B.A
		</option>
		<option <?php if($qualification =="BCom"){ ?> selected="selected" <?php } ?>>
		BCom
		</option>
		<option <?php if($qualification =="B.Sc"){ ?> selected="selected" <?php } ?>>
		B.Sc
		</option>
		<option <?php if($qualification =="B.E / B.Tech"){ ?> selected="selected" <?php } ?>>
		B.E / B.Tech
		</option>
		<option <?php if($qualification =="MBBS"){ ?> selected="selected" <?php } ?>>
		MBBS
		</option>
		<option <?php if($qualification =="MVSC"){ ?> selected="selected" <?php } ?>>
		MVSC
		</option>
		<option <?php if($qualification =="BVSC"){ ?> selected="selected" <?php } ?>>
		BVSC
		</option>
		<option <?php if($qualification =="M.Sc"){ ?> selected="selected" <?php } ?>>
		M.Sc
		</option>
		<option <?php if($qualification =="Other"){ ?> selected="selected" <?php } ?>>
		Other
		</option>
		</select>
		</td>
		
		<td width="10px"></td>
		<td align="right">
			<strong><?php echo $_SESSION['idcard']; ?>&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left" >
		<input type="text" name="pancard" id="pancard" size="15" value="<?php echo $pancard; ?>"/>
		</td>

		<td width="10px"></td>
		<td align="right" id="expvtd" <?php if($vinsurance !=""){ ?> style="visibility:visible" <?php } else { ?> style="visibility:hidden" <?php } ?>>
			<strong>Exp.of Ins.&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left">
		<input type="text" value="<?php echo $expvinsurance; ?>" readonly name="expvinsurance" id="expvinsurance" size="12" class="datepicker" <?php if($vinsurance !=""){ ?> style="visibility:visible" <?php } else { ?> style="visibility:hidden" <?php } ?> id="expvinsurance">
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
		<option value="<?php echo $row1['bankname']; ?>" <?php if($bank == $row1['bankname']) {?> selected="selected"<?php } ?>><?php echo $row1['bankname']; ?></option>
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
		<input type="text" name="bankbranch"  id="bankbranch" size="20" value="<?php echo $bankbranch; ?>"/>
		</td>

		<td width="10px"></td>		

		<td align="right">
			<strong>A/C. #&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left" >
		<input type="text" name="accountno"  id="accountno" size="15" value="<?php echo $accountno; ?>"/>
		</td>
		
		</tr>

		<tr style="height:20px"></tr>
		
		<tr>
		
		<td align="right">
			<strong><?php if($countryname == 'INDIA') echo "IFSC Code"; else echo "Bank Code"; ?>&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left">
		<input type="text" name="ifsc" id="ifsc" size="15" value="<?php echo $ifsc; ?>"/>
		</td>

		<td width="10px"></td>	
		<td align="right">
			<strong>Contact #&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left">
		<input type="text" name="personalcontact" id="personalcontact" size="15" value="<?php echo $personalcontact; ?>"/>
		</td>

		<td width="10px"></td>	
		<td align="right">
			<strong>Company #&nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left">
		<input type="text" name="companycontact" id="companycontact" size="15" value="<?php echo $companycontact; ?>"/>
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
		 while ($row1 = mysql_fetch_array($get_entriess_res2)) { ?>
		<option value="<?php echo $row1['country_name']; ?>" <?php if($row1['country_name'] == $countryname) { ?> selected="selected"<?php } ?> ><?php echo $row1['country_name']; ?></option>
		<?php } ?>
		</select> 
		</td>

		<td width="10px"></td>	
		
		<td align="right" style="vertical-align:middle">
			<strong>Address &nbsp;&nbsp;&nbsp;</strong>
		</td>
		<td align="left" style="vertical-align:middle" colspan="3">
		<textarea rows="4" cols="20" name="address"><?php echo $address;?></textarea>
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
<td align="left"><input type="text" name="ref1name" size="25" value="<?php echo $ref1name; ?>"/></td>
<td width="10px"></td>
<td align="right"><strong>Name</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="ref2name" size="25" value="<?php echo $ref2name; ?>"/></td>
</tr>

<tr style="height:20px"></tr>

<tr>
<td align="right"><strong>Address</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><textarea rows="4" cols="20" name="ref1address" ><?php echo $ref1address; ?></textarea></td>
<td width="10px"></td>
<td align="right"><strong>Address</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><textarea rows="4" cols="20" name="ref2address" ><?php echo $ref2address; ?></textarea></td>
</tr>

<tr style="height:20px"></tr>

<tr>
<td align="right"><strong>Country</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left">
<select name="ref1country" id="ref1country" style="width:165px">
<?php
$get_entriess1 = "select * from countries order by country_name Asc ";
$get_entriess_res2 = mysql_query($get_entriess1,$conn) or die(mysql_error());
 while ($row1 = mysql_fetch_array($get_entriess_res2)) { ?>
<option value="<?php echo $row1['country_name']; ?>" <?php if($ref1country == $row1['country_name']) { ?> selected="selected" <?php } ?>><?php echo $row1['country_name']; ?></option>
<?php 
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
 while ($row1 = mysql_fetch_array($get_entriess_res2)) { ?>
<option value="<?php echo $row1['country_name']; ?>" <?php if($ref2country == $row1['country_name']) { ?> selected="selected" <?php } ?>><?php echo $row1['country_name']; ?></option>
<?php } ?>
</select> 
</td>
</tr>

<tr style="height:20px"></tr>

<tr>
<td align="right"><strong>Contact No 1</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="ref1contact1" size="15" value="<?php echo $ref1contact1; ?>"/></td>
<td width="10px"></td>
<td align="right"><strong>Contact No 1</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="ref2contact1" size="15" value="<?php echo $ref2contact1; ?>" /></td>
</tr>

<tr style="height:20px"></tr>

<tr>
<td align="right"><strong>Contact No 2</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="ref1contact2" size="15" value="<?php echo $ref1contact2; ?>"/></td>
<td width="10px"></td>
<td align="right"><strong>Contact No 2</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="ref2contact2" size="15" value="<?php echo $ref2contact2; ?>"/></td>
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
<td align="left"><input type="text" name="eref1name" size="25" value="<?php echo $eref1name; ?>"/></td>
</tr>
<tr style="height:20px"></tr>
<tr>
<td align="right"><strong>Address</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><textarea rows="4" cols="20" name="eref1address" ><?php echo $eref1address; ?></textarea></td>
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
?>
<option value="<?php echo $row1['country_name']; ?>" <?php if($eref1country == $row1['country_name']) { ?> selected="selected" <?php } ?>><?php echo $row1['country_name']; ?></option>
<?php 
}
?>
</select> 
</td>
</tr>
<tr style="height:20px"></tr>
<tr>
<td align="right"><strong>Contact No 1</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="eref1contact1" size="15" value="<?php echo $eref1contact1; ?>"/></td>
</tr>
<tr style="height:20px"></tr>
<tr>
<td align="right"><strong>Contact No 2</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="eref1contact2" size="15" value="<?php echo $eref1contact2; ?>"/></td>
</tr>

     </table>
   <br />
   <input type="submit" value="Update" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=hr_employee';">
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
window.open('HRHELP/help_m_editemployee.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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