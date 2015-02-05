<?php include "config.php";
include "jquery.php"; 
$id = $_GET['id'];

$query1 = "SELECT * FROM ims_standardcosts WHERE id = '$id'";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
$rows1 = mysql_fetch_assoc($result1);
$code=$rows1['code'];
?>
<section class="grid_8">
  <div class="block-border">
   <form class="block-content form" style="height:600px" id="complex_form" method="post" onsubmit="return checkform(this)" action="ims_updatestandardcosts.php" >
	  <h1 id="title1">Standard Costs</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<input type="hidden" id="oldid" name="oldid" value="<?php echo $id; ?>" />
<br><br>
<table id="tab1" align="center">
	<tr>
		<td><strong>From Date</strong></td>
		<td width="10px"></td>
		<td><strong>To Date</strong></td>
		<td width="10px"></td>
		<td><strong>Category</strong></td>
		<td width="10px"></td>
		<td><strong>Code</strong></td>
		<td width="10px"></td>
		<td><strong>Description</strong></td>
		<td width="10px"></td>
		<td><strong>Standard Cost</strong></td>
	</tr>
	<tr height="10px"></tr>
	<tr>
		<td><input type="text" id="fromdate@1" name="fromdate[]" value="<?php echo date("d.m.Y",strtotime($rows1[fromdate])); ?>" class="datepicker" size="10" /></td>
		<td width="10px"></td>
		<td><input type="text" id="todate@1" name="todate[]" value="<?php echo date("d.m.Y",strtotime($rows1[todate])); ?>" class="datepicker" size="10"/></td>
		<td width="10px"></td>
		<td>
			<select id="cat@1" name="cat[]" onchange="loadcodes(this.id)" style="width:200px" />
			<option value="">-Select-</option>
			<?php 
			$query = "SELECT type AS cat FROM ims_itemtypes ORDER BY cat";
			$result = mysql_query($query,$conn) or die(mysql_error());
			while($rows = mysql_fetch_assoc($result))
			{
			 ?>
			 <option value="<?php echo $rows['cat']; ?>" title="<?php echo $rows['cat']; ?>" <?php if($rows1['cat'] == $rows['cat']) { ?> selected="selected" <?php } ?>><?php echo $rows['cat']; ?></option>
			 <?php
			}
			?>
			</select>
		</td>
		<td width="10px"></td>
		<td>
			<select id="code@1" name="code[]" onchange="selectdesc(this.id)" style="width:100px" />
			<option value="">-Select-</option>
			<?php 
			$query = "SELECT code,description FROM ims_itemcodes WHERE cat = '$rows1[cat]' ORDER BY code";
			$result = mysql_query($query,$conn) or die(mysql_error());
			while($rows = mysql_fetch_assoc($result))
			{
			 ?>
			 <option value="<?php echo $rows['code']."@".$rows['description']; ?>" title="<?php echo $rows['description']; ?>" <?php if($rows1['code'] == $rows['code']) { ?> selected="selected" <?php } ?>><?php echo $rows['code']; ?></option>
			 <?php 
			}
			?>
			</select>
		</td>
		<td width="10px"></td>
		<td>
			<select id="desc@1" name="desc[]" onchange="selectcode(this.id)" style="width:200px" />
			<option value="">-Select-</option>
			<?php 
			$query = "SELECT code,description FROM ims_itemcodes WHERE cat = '$rows1[cat]' ORDER BY description";
			$result = mysql_query($query,$conn) or die(mysql_error());
			while($rows = mysql_fetch_assoc($result))
			{
			 ?>
			 <option value="<?php echo $rows['code']."@".$rows['description']; ?>" title="<?php echo $rows['description']; ?>" <?php if($rows1['description'] == $rows['description']) { ?> selected="selected" <?php } ?>><?php echo $rows['description']; ?></option>
			 <?php 
			}
			?>
			</select>
		</td>
		<td width="10px"></td>
		<td>
		
		<?php   $q="select iac from ims_itemcodes where code='$code'";
   $r=mysql_query($q,$conn);
   $r1=mysql_fetch_array($r);
   $coacode=$r1['iac'];


  $q1="select max(date) as maxdate from ac_financialpostings where itemcode='$code' and coacode='$coacode'";
   $r1=mysql_query($q1,$conn);
   $r2=mysql_fetch_array($r1);
$maxdate=$r2['maxdate'];
?>
			<input type="text" id="stdcost@1" name="stdcost[]" value="<?php echo $rows1['stdcost']; ?>" size="10" style="text-align:right" <?php if($maxdate>=$rows1['fromdate']&& $maxdate<=$rows1['todate']) {?> readonly="true" <?php } ?> />
		</td>
	</tr>
</table>
<br><br>
<input type="submit" value="Update" />&nbsp;&nbsp;
<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=ims_standardcosts'" />
</form>
<script type="text/javascript">

function checkform()
{
 if(document.getElementById('stdcost@1').value > 0 && document.getElementById('code@1').value == "")
 {
	alert("Please Select Code");
	document.getElementById('code@1').focus();
	return false;
 }
 return true;
}

function loadcodes(a)
{
 var temp = a.split('@');
 var tempindex = temp[1];
 var cat = document.getElementById("cat@"+tempindex).value;
 removeAllOptions(document.getElementById("code@"+tempindex));
 removeAllOptions(document.getElementById("desc@"+tempindex));
 var select1 = document.getElementById("code@"+tempindex);
 var select2 = document.getElementById("desc@"+tempindex);
 <?php 
 $query = "SELECT type AS cat FROM ims_itemtypes ORDER BY type";
 $result = mysql_query($query,$conn) or die(mysql_error());
 while($rows = mysql_fetch_assoc($result))
 {
	echo "if(cat == '$rows[cat]') { ";
	$query1 = "SELECT code,description FROM ims_itemcodes WHERE cat = '$rows[cat]' ORDER BY code";
	$result1 = mysql_query($query1,$conn) or die(mysql_error());
	while($rows1 = mysql_fetch_assoc($result1))
	{
	 ?>
  theOption1 = document.createElement("OPTION");
  theText1 = document.createTextNode("<?php echo $rows1['code']; ?>");
  theOption1.value = "<?php echo $rows1['code']."@".$rows1['description']; ?>";
  theOption1.title = "<?php echo $rows1['description']; ?>";
  theOption1.appendChild(theText1);
  select1.appendChild(theOption1);	 
	 <?php 
	}
	$query1 = "SELECT code,description FROM ims_itemcodes WHERE cat = '$rows[cat]' ORDER BY description";
	$result1 = mysql_query($query1,$conn) or die(mysql_error());
	while($rows1 = mysql_fetch_assoc($result1))
	{
	 ?>
  theOption1 = document.createElement("OPTION");
  theText1 = document.createTextNode("<?php echo $rows1['description']; ?>");
  theOption1.value = "<?php echo $rows1['code']."@".$rows1['description']; ?>";
  theOption1.title = "<?php echo $rows1['description']; ?>";
  theOption1.appendChild(theText1);
  select2.appendChild(theOption1);	 
	 <?php 
	}
	echo " } ";
 }
 ?>
}

function selectdesc(a)
{
 var temp = a.split('@');
 var tempindex = temp[1];
 document.getElementById('desc@'+tempindex).value =  document.getElementById('code@'+tempindex).value
}

function selectcode(a)
{
 var temp = a.split('@');
 var tempindex = temp[1];
 document.getElementById('code@'+tempindex).value =  document.getElementById('desc@'+tempindex).value
}

function removeAllOptions(selectbox)
{
	for(var i=selectbox.options.length-1;i>0;i--)
		selectbox.remove(i);
}

</script>

<script type="text/javascript">

function script1() {

window.open('IMSHelp/help_m_addstandardcost.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=YES,resizable=yes');

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
