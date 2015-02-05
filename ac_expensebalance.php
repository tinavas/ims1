<?php include "jquery.php";
      include "config.php"; 
      session_start();
      $client = $_SESSION['client'];
?>
<center>
<br />
<h1>Expenses Ledger</h1> 
<br /><br /><br />
<form method="post" action="">
<table align="center">
<?php if($_SESSION[db]=='alkhumasiyabrd') { ?>
<tr>
 <td align="right" ><strong>Cost Center</strong>&nbsp;&nbsp;&nbsp;</td><td align="left">
  <select id="warehouse" name="warehouse">
  <option value="">All</option>
  <?php
  $query = "select sector from tbl_sector where type1 in ('Breeder','Hatchery','Administration Office')";
  $result = mysql_query($query,$conn) or dir(mysql_error());
  while($rows = mysql_fetch_assoc($result))
  {
  ?>
  <option value="<?php echo $rows['sector']; ?>"><?php echo $rows['sector']; ?></option>
  <?php
  }
  ?>
  </select>
 </td>
</tr>
<tr height="10px"></tr> 
<?php } ?>
<?php if($_SESSION[db]=='vaibhav') { ?>
<tr>
 <td align="right" ><strong>Cost Center</strong>&nbsp;&nbsp;&nbsp;</td><td align="left">
  <select id="warehouse" name="warehouse">
  <option value="">All</option>
 <?php 
        if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{ $q = "SELECT * FROM tbl_sector WHERE type1 <> 'Warehouse' order by sector";
	}
	 else
	 {
	$sectorlist = $_SESSION['sectorlist'];
	$q = "SELECT * FROM tbl_sector WHERE type1 <> 'Warehouse'  and sector in ($sectorlist) order by sector";
	}
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
<option value="<?php echo $qr['sector']; ?>"><?php echo $qr['sector']; ?></option>
<?php } ?>
  </select>
 </td>
</tr>
<tr height="10px"></tr> 
<?php } ?>
<tr>
<td align="right"><strong>Expense Code &nbsp;&nbsp;</strong></td>
<td align="left">
<select id="code" name="code" onchange="document.getElementById('desc').value=this.value;">
<option value="">Select</option>
<option title="All" value="All@All">All</option>
<?php 
		$q = "select code,controltype,description from ac_coa where schedule = 'Indirect Expenses' and client = '$client' order by code ";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['code']; ?>@<?php echo $qr['description']; ?>"><?php echo $qr['code']; ?></option>
<?php } ?>

</select>
</td>
</tr>
<tr height="10px"></tr> 
<tr>
<td align="right"><strong>Description &nbsp;&nbsp;</strong></td>
<td>
<select onchange="document.getElementById('code').value=this.value;" id="desc" name="desc">
<option value="">Select</option>
<option title="All" value="All@All">All</option>
<?php 
		$q = "select code,controltype,description from ac_coa where schedule = 'Indirect Expenses' and client = '$client' order by description ";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
?>
<option title="<?php echo $qr['code']; ?>" value="<?php echo $qr['code']; ?>@<?php echo $qr['description']; ?>"><?php echo $qr['description']; ?></option>
<?php } ?>

</select>
</td>
</tr>
<tr height="10px"></tr> 
</table>
<table align="center">
<tr>
<td align="right"><strong>From&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left"><input type="text" size="15" id="date2" class="datepicker" name="date2" value="<?php echo date("d.m.Y"); ?>" ></td>
<td width="10px"></td>
<td><strong align="right">To&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left"><input type="text" size="15" id="date3" class="datepicker" name="date3" value="<?php echo date("d.m.Y"); ?>" onChange="datecomp();" ></td>
</tr>
</table>
<br/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" id="report" value="Report" onclick="openreport();" />
</form>
</center>




<script type="text/javascript">
function openreport()
{
var fromdate = document.getElementById('date2').value;
var todate = document.getElementById('date3').value;
var code = document.getElementById('code').value;
var desc = code.split('@')
var warehouse = "All";
<?php if(($_SESSION[db]=='alkhumasiyabrd') || ($_SESSION[db]=='vaibhav')) { ?>
var warehouse = document.getElementById('warehouse').value; <?php } ?>
window.open('production/expenseledger.php?fromdate=' + fromdate + '&todate=' + todate + '&code=' + desc[0] + '&desc=' + desc[1] + '&warehouse=' + warehouse); 
}


function datecomp()
{

dd = document.getElementById('date2').value;
temp =  dd.split('.');
temp = temp[1] + '/' + temp[0] + '/' + temp[2];
temp1 = new Date(temp);

dd1 = document.getElementById('date3').value;
temp3 =  dd1.split('.');
temp3 = temp3[1] + '/' + temp3[0] + '/' + temp3[2];
temp4 = new Date(temp3);

if(temp1 >temp4)
{
 alert('To date must be greater than or equal to From date');
 document.getElementById('report').disabled = true;
}
}

</script>
<script type="text/javascript">
function script1() {
window.open('GLHelp/help_coaledger.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=no,resizable=no');
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
	