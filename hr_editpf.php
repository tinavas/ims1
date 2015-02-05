<?php

$client = $_SESSION['client']; 

$id = $_GET['id'];

		$q = "select * from hr_pf where id = '$id' and client='$client'";

		$qrs = mysql_query($q,$conn) or die(mysql_error());

		while($qr = mysql_fetch_assoc($qrs))

		{

		$salfrom = $qr['salfrom'];

		$salto = $qr['salto'];

		$tax = $qr['tax'];
		$coa =$qr['coa'];

		}

?>

<br/>

<center>

<h1>Professional Tax</h1>

</center>

<br />

<br/>



<form id="form1" name="form1" method="post"  action="hr_updatepf.php"  enctype="multipart/form-data">

<table align="center"  id="inputs1">

<tr>

<th><strong>Salary From</strong>&nbsp;&nbsp;&nbsp;</th>

<td width="10">&nbsp;</td>

<th><strong>Salary To</strong>&nbsp;&nbsp;&nbsp;</th>

<td width="10">&nbsp;</td>

<th><strong>Tax</strong>&nbsp;&nbsp;&nbsp;</th>

<td width="10">&nbsp;</td>

<th><strong>Coa Code</strong>&nbsp;&nbsp;&nbsp;</th>


</tr>



<tr>

<input type="hidden" id="oldid" name="oldid" value="<?php echo $id;?>"/>

<td align="left"><input type="text" id="salfrom0" name="salfrom0" size="17"  value="<?php echo $salfrom; ?>"/></td> 

<td width="10">&nbsp;</td>

<td  align="left"><input type="text" id="salto0" name="salto0" size="17"  value="<?php echo $salto; ?>"/></td> 

<td width="10">&nbsp;</td>

<td  align="left"><input type="text" id="tax0" name="tax0" size="15"   value="<?php echo $tax; ?>"/></td> 
<td width="10">&nbsp;</td>

<td  align="left">
<select style="Width:120px" name="coa" id="coa" >
  <option value="">-Select-</option>
  <?php 
  $query="select code,description from ac_coa where type='Liability' or type='Expense'";
  $result=mysql_query($query,$conn);
  while($rows1=mysql_fetch_assoc($result))
  {
  ?>
  <option value="<?php echo $rows1['code'];?>" title="<?php echo $rows['description'];?>" <?php if($coa==$rows1['code']) { ?> selected="selected" <?php } ?> ><?php echo $rows1['code'];?></option>
  <?php
  } 
  ?>
</select>
</td>
</tr>

</table>

 <br />

<center>

<input type="submit" value="Update" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=hr_pf';">

</center>





</form>



<script type="text/javascript">

function script1() {

window.open('HRHELP/hr_m_addprofessionaltax.php','BIMS',

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

