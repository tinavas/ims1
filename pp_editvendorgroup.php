
<center>
<br />
<h1>Vendor Group Mapping</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
</center>

<form id="form1" name="form1" method="post" action="pp_updatevendorgroup.php" >
<?php
   $code = $_GET['id'];
   include "config.php"; 
           $query = "SELECT * FROM ac_vgrmap where vgroup = '$code' ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
		     $desc = $row1['vdesc'];
			 
			 $controllac = $row1['vca'];
			 $ppac = $row1['vppac'];
			 $remarks = $row1['remarks'];
		   }

  ?>
<div style="height:auto">

<table align="center">
<tr>
<td>
<strong>Vendor Group Code</strong>
</td>
<td>
<input type="text" id="grcode" name="tno" value="<?php echo $code; ?>" readonly size="10"  />
</td>
</tr>
<tr height="10px"></tr>
<tr>
<td><strong>Vendor Group Description</strong></td>
<td><input type="text" id="desc" name="desc" size="20" value="<?php echo $desc; ?>"  /></td>
</tr><br />
</table>
<br />
<table border="1" cellpadding="2" cellspacing="2" id="mytable" align="center">
<tr align="center">
<thead align="center">

<td>
<strong>Vendor Controll A/C</strong>
</td>
<td>
<strong>Vendor Prepayment A/C</strong>
</td>
</thead>
</tr>
<tr>

<td>
<select name="ca" id="ca"  style="width:160px;">
<option>Select Code</option>
<option value="<?php echo $controllac;?>" selected="selected"><?php echo $controllac;?></option>
<?php
           include "config.php"; 
           $query1 = "SELECT * FROM ac_coa where controltype='Vendor A/c' and code not in(select distinct(vca) from ac_vgrmap) ORDER BY code ASC ";
           $result1 = mysql_query($query1,$conn); 
           while($row11 = mysql_fetch_assoc($result1))
           {?>
		     
<option value="<?php echo $row11['code']; ?>"><?php echo $row11['code']; ?></option>
<?php } ?>
</select>
</td>
<td>
<select name="ppac" id="ppac"  style="width:160px;">
<option>Select Code</option>
<option value="<?php echo $ppac;?>" selected="selected"><?php echo $ppac;?></option>
<?php
           include "config.php"; 
           $query1 = "SELECT * FROM ac_coa where controltype='Vendor Prepayment A/c' and code not in(select distinct(vppac) from ac_vgrmap) ORDER BY code ASC ";
           $result1 = mysql_query($query1,$conn); 
           while($row11 = mysql_fetch_assoc($result1))
           { ?>
<option value="<?php echo $row11['code']; ?>"><?php echo $row11['code']; ?></option>
<?php }  ?>
</select>
</td>
</tr>
</table>
<br />
</div>
<br />
<center>
<input type="submit" value="Update" id="Save" name="Save"/>&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=pp_vendorgroup';">
</center>
<br />
<!-- </center> -->
</form>
<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_m_editvengrmap.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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