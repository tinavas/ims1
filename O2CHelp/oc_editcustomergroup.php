
<center>
<br />
<h1>Customer Group Mapping</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
</center>

<form id="form1" name="form1" method="post" action="oc_updatecustomergroup.php" >
<?php
   $code = $_GET['id'];
   include "config.php"; 
           $query = "SELECT * FROM ac_vgrmap where vgroup = '$code' and client = '$client'  ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
		     $desc = $row1['vdesc'];
			 $currency = $row1['currency'];
			 $controllac = $row1['vca'];
			 $ppac = $row1['vppac'];
			 $remarks = $row1['remarks'];
		   }

  ?>
<div style="height:auto">

<table align="center">
<tr>
<td>
<strong>Customer Group Code</strong>
</td>
<td>
<input type="text" id="grcode" name="tno" value="<?php echo $code; ?>" readonly size="10"  />
</td>
</tr>
<tr height="10px"></tr>
<tr>
<td><strong>Customer Group Description</strong></td>
<td><input type="text" id="desc" name="desc" size="20" value="<?php echo $desc; ?>"  /></td>
</tr><br />
</table>
<br />
<table border="1" cellpadding="2" cellspacing="2" id="mytable" align="center">
<tr align="center">
<thead align="center">
<td>
<strong>Currency</strong>
</td>
<td>
<strong>Customer Controll A/C</strong>
</td>
<td>
<strong>Customer Advance A/C</strong>
</td>
</thead>
</tr>
<tr>
<td>
<input type="text" id="curr" name="curr" value="<?php echo $currency; ?>" size="5"  />
</td>
<td>
<select name="ca" id="ca"  style="width:160px;">
<option>Select Code</option>
<?php
           include "config.php"; 
           $query1 = "SELECT * FROM ac_coa where controltype='Customer A/c' and client = '$client'  ORDER BY code ASC ";
           $result1 = mysql_query($query1,$conn); 
           while($row11 = mysql_fetch_assoc($result1))
           {
		     if ( $row11['code'] == $controllac ) {
           ?>
	<option title="<?php echo $row11['description']; ?>" value="<?php echo $row11['code']; ?>" selected="selected"><?php echo $row11['code']; ?></option>	   
<?php } else { ?>
<option value="<?php echo $row11['code']; ?>"><?php echo $row11['code']; ?></option>
<?php } } ?>
</select>
</td>
<td>
<select name="ppac" id="ppac"  style="width:160px;">
<option>Select Code</option>
<?php
           include "config.php"; 
           $query1 = "SELECT * FROM ac_coa where controltype='Customer Advance A/c' and client = '$client'  ORDER BY code ASC ";
           $result1 = mysql_query($query1,$conn); 
           while($row11 = mysql_fetch_assoc($result1))
           {
		     if ( $row11['code'] == $ppac ) {
           ?>
	<option title="<?php echo $row11['description']; ?>" value="<?php echo $row11['code']; ?>" selected="selected"><?php echo $row11['code']; ?></option>	   
<?php } else { ?>
<option value="<?php echo $row11['code']; ?>"><?php echo $row11['code']; ?></option>
<?php } } ?>
</select>
</td>
</tr>
</table>
<br />
</div>
<br />
<center>
<input type="submit" value="Update" id="Save" name="Save"/>&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="top.location='dashboard.php?page=oc_customergroup';">
</center>
<br />
<!-- </center> -->
</form>
<script type="text/javascript">
function script1() {
window.open('O2CHelp/help_m_editcustomergrmapping.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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