<?php include "jquery.php"; include "getemployee.php"; session_start();
$id=$_GET['id'];
$query="select * from hr_incometax where id='$id'";
$result=mysql_query($query,$conn);
$rows=mysql_fetch_assoc($result);
 ?>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="height:600px" id="complex_form" method="post" action="hr_saveincometax.php" onsubmit=" return checkform();" >
	  <h1 id="title1">Edit Income Tax Structure</h1>
 <div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
<center>
<br/>
<br/>
<table >
<tr>
<td style="width:100px"><strong>From Date</strong></td> 
<td>
<input type="hidden" id="id" name="id" value="<?php echo $rows['id'];?>"  />
<input type="hidden" id="edit" name="edit" value="1" />
<input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($rows['fromdate'])); ?>"  onchange="reloadpage();"/></td>
<td width="10">&nbsp;</td>
 <td style="width:100px"><strong>To Date</strong></td> 
 <td><input type="text" name="todate" id="todate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($rows['todate'])); ?>"  onchange="reloadpage();"/></td>
</tr>
<tr height="10px" ></tr>
<tr>
<td style="width:150px"><strong>From Salary</strong></td> 
<td>
<input type="text" id="fromsal" name="fromsal" onkeypress="validatekey(event.keyCode)" value="<?php echo $rows['fromsal'];?>"  />
</td>
<td width="10">&nbsp;</td>
<td style="width:150px"><strong>To Salary</strong></td> 
<td>
<input type="text" id="tosal" name="tosal" onkeypress="validatekey(event.keyCode)" value="<?php echo $rows['tosal'];?>"  />
</td>
</tr>
<tr height="10px" ></tr>
<tr>
<td style="width:150px"><strong>Base Amount Deducted</strong></td> 
<td>
<input type="text" id="balamtded" name="balamtded" onkeypress="validatekey(event.keyCode)" value="<?php echo $rows['balamtded'];?>" />
</td>
<td width="10">&nbsp;</td>
<td style="width:150px"><strong>Amount Exceeded</strong></td> 
<td>
<input type="text" id="amtex" name="amtex" onkeypress="validatekey(event.keyCode)" value="<?php echo $rows['amtexceeded'];?>" />
</td>
</tr>
<tr height="10px" ></tr>
<tr>
<td style="width:150px"><strong>Deduction %</strong></td> 
<td>
<input type="text" id="ded" name="ded" value="<?php echo $rows['deductionper'];?>" onkeypress="validatekey(event.keyCode)" />
</td>
<td width="10">&nbsp;</td>
<td style="width:150px"><strong>Coa</strong></td> 
<td>
<select style="Width:120px" name="coa" id="coa" >
  <option value="">-Select-</option>
  <?php 
  $query="select code,description from ac_coa where type='Liability' or type='Expense'";
  $result=mysql_query($query,$conn);
  while($rows1=mysql_fetch_assoc($result))
  {
  ?>
  <option value="<?php echo $rows1['code'];?>" title="<?php echo $rows['description'];?>" <?php if($rows['coa']==$rows1['code']) { ?> selected="selected" <?php } ?> ><?php echo $rows1['code'];?></option>
  <?php
  } 
  ?>
</select>
</td>
</tr>
</table>
<br/>
<br/>
<input type="submit" value="Save" id="Save"/>&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=hr_incometax';">
</center>
</form>
 </div>
</section>
<br />
<script type="text/javascript">
function validatekey(a)
{ 
 if((a<48 || a>57) && a!=46 && a!=13)	
   event.keyCode=false;
}

function checkform()
{
		if(document.getElementById('fromsal').value=="")
		{
			alert("Enter From Salary");	
			document.getElementById('fromsal').focus();
			return false;		
		}
		if(document.getElementById('tosal').value=="")
		{
			alert("Enter To Salary");	
			document.getElementById('tosal').focus();
			return false;		
		}
		if(document.getElementById('balamtded').value=="")
		{
			alert("Enter The Base Amount Deducted");	
			document.getElementById('balamtded').focus();
			return false;		
		}
		if(document.getElementById('amtex').value=="")
		{
			alert("Enter The Amount Exceeded");	
			document.getElementById('amtex').focus();
			return false;		
		}
		if(document.getElementById('ded').value=="")
		{
			alert("Enter The Deduction Percentage");	
			document.getElementById('ded').focus();
			return false;		
		}
		
		if(document.getElementById('ded').value>100)
		{
			alert("Enter The appropriate Deduction Percentage");	
			document.getElementById('ded').focus();
			return false;		
		}
		
		if(document.getElementById('coa').value=="")
		{
			alert("Slect The COA");	
			document.getElementById('coa').focus();
			return false;		
		}
		return true;
	
}
</script>

<div class="clear"></div>

<br />



<script type="text/javascript">

function script1() {

window.open('HRHELP/hr_m_leavesallowed.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');

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

