<?php   include "config.php"; 
        include "getemployee.php";
		$tnum = $_GET['id'];
            $mode = $_GET['mode'];
		$q = "select * from ac_crdrnote where crnum = '$tnum' and mode = '$mode' order by id ";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		  //$mode = $qr['mode'];
		  $total = $qr['totalamount'];
		  $stdate = date("d-m-Y",strtotime($qr['date']));
		  $remarks = $qr['remarks'];
		  $vendor = $qr['vcode'];
		  $drtotal = $qr['drtotal'];
		  $crtotal = $qr['crtotal'];
		}

 if($mode == 'VCN') { $mode2 = 'Vendor Credit'; }
 else if($mode == 'VDN') { $mode2 = 'Vendor Debit'; }


		if ( $mode == "VCN")
		{
		$btype = "Credit";
		} else if ( $mode == "VDN")
		{
		$btype = "Debit";
		}
		$type = $_GET['type'];
?>
<center>
<br />
<h1><?php echo $mode2;?> Note</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
</center>
<br /><br />
<form id="form1" name="form1" method="post" action="pp_updatecreditnote.php" >
<input type="hidden" id="mode" name="mode" value="<?php echo $mode; ?>" />
<input type="hidden" id="type" name="type" value="<?php echo $btype; ?>" />

<div style="height:auto">
<table border="0"	align="center">
<tr align="center">
<td align="right"><strong>Transaction No.</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" id="tno" name="tno" value="<?php echo $tnum; ?>" readonly style="border:0px;background:none" />&nbsp;&nbsp;</td>
<td align="right"><strong>Date</strong>&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" size="15" id="date" class="datepicker" name="date" value="<?php echo $stdate; ?>" /></td>

</tr>

<tr style="height:20px"><td></td><td></td><td></td><td style="color:red;font-weight:bold;padding-top:10px">Status-Not Authorised</td></tr>

<tr>
<td align="right"><strong>Vendor</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select style="width: 170px"  name="vendor" id="vendor" >
                <option value="">-Select-</option>
   <?php $query = "SELECT distinct(name) FROM contactdetails where type = 'vendor' ORDER BY name ASC"; 
   		 $result = mysql_query($query,$conn);
         while($row = mysql_fetch_assoc($result))
		 {  
		 if ( $vendor == $row['name'] ) { ?>
      <option value="<?php echo $row['name'];?> " selected="selected"><?php echo $row['name']; ?></option>
  <?php } else { ?><option value="<?php echo $row['name'];?>"><?php echo $row['name']; ?></option><?php } } ?>
</select>&nbsp;&nbsp;</td>
<?php if($_SESSION[db]=='albustan' || $_SESSION['db'] == "albustanlayer") { ?>
<td width="10px">&nbsp;</td>
<td>
<strong>Vendor Code</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<select  onchange="document.getElementById('vendor').value=this.value" id="vendorcode" name="vendorcode" <?php if($_SESSION['db'] == 'central') { ?> onchange="fvalidatecurrency();" <?php } ?>
<option value="">-Select-</option>
<?php 
	$q = "select distinct(name),code from contactdetails where type = 'vendor' or type = 'vendor and party' order by name";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
<option title="<?php echo $qr['name']; ?>" value="<?php echo $qr['name']; ?>@<?php echo $qr['code']; ?>" <?php if($vendor == $qr['name']) { ?> selected="selected" <?php } ?> ><?php echo $qr['code']; ?></option>
<?php } ?>
</select>
</td>
<?php } ?>
<td width="10px">&nbsp;</td>
<td align="right"><strong>Amount&nbsp;&nbsp;&nbsp;</strong></td>

<td align="left"><input type="text" style="text-align:right;" size="15" id="vendamount" name="vendamount" value="<?php echo $total; ?>" onchange="total();"  /></td>

</tr>
</table>

<br />
<table border="0" cellpadding="2" cellspacing="2" id="mytable" align="center">
<tr align="center">
<thead>
<th><strong>S.No.</strong></th>
<th width="10px"></th>
<th><strong>Code</strong></th>
<th width="10px"></th>
<th><strong>Description</strong></th>
<th width="10px"></th>
<th><strong>Dr/Cr</strong></th>
<th width="10px"></th>
<th><strong>Dr</strong></th>
<th width="10px"></th>
<th><strong>Cr</strong></th>
</thead>
</tr>
<tr style="height:20px"></tr>
<script type="text/javascript">
var index = 0;
</script>
<?php 
	$i = -1;
	
	$q = "select * from ac_crdrnote where crnum = '$tnum' and mode = '$mode' order by id  ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	
?>
<script type="text/javascript">
index = index + 1;
</script>


<tr>
<td>
<input type="text"  id="sno" name="sno" value="<?php echo $i + 2; ?>" readonly style="border:0px;background:none" size="2"/>
</td>
<td width="10px"></td>
<td>
<select id="code<?php echo $i; ?>" name="code[]" disabled >
<option value="">Select</option>
<?php 
		$q1 = "SELECT code,description FROM ac_coa WHERE TYPE IN ('Capital','Expense','Liability') OR schedule IN ('Other Income','Current Assets','Fixed Assets','Short Term Loans and Advances') AND controltype NOT IN ('Vendor Contra A/C','Vendor Prepayment A/C','Customer A/C','Custormer Addvanced A/C','Vendor A/C') ORDER BY code";
		$qrs1 = mysql_query($q1,$conn) or die(mysql_error());
		while($qr1 = mysql_fetch_assoc($qrs1))
		{
		if ( $qr1['code'] == $qr['code'] ) { 
?>
<option value="<?php echo $qr['code']?>" selected="selected"><?php echo $qr['code'] ?></option>
<?php } else { ?>
<option value="<?php echo $qr1['code']; ?>"><?php echo $qr1['code']; ?></option>
<?php } ?>
<?php } ?>
</select>
</td>
<td width="10px"></td>
<td>
<input type="text" id="desc<?php echo $i; ?>" name="desc[]" value="<?php echo $qr['description']; ?>" size="25" readonly />
</td>
<td width="10px"></td>
<td>
<select id="crdr<?php echo $i; ?>" name="crdr[]" disabled  >
<option value="">Select</option>
<?php if ( $qr['crdr'] == "Cr" ) { ?>
<option value="Cr" selected="selected">Cr</option>
<?php } else { ?>
<option value="Cr">Cr</option>
<?php } ?>
<?php if ( $qr['crdr'] == "Dr" ) { ?>
<option value="Dr" selected="selected">Dr</option>
<?php } else { ?>
<option value="Dr" >Dr</option>
<?php } ?>
</select>
</td>
<td width="10px"></td>
<td>
<input type="text" align="right" id="dramount<?php echo $i; ?>"  name="dramount[]" <?php if ( $qr['crdr'] == "Cr" ) {  ?> readonly <?php } ?> value="<?php echo $qr['dramount']; ?>"  onchange="total();" size="8" style="text-align:right"/>
</td>
<td width="10px"></td>
<td>
<input type="text" align="right" id="cramount<?php echo $i; ?>"  name="cramount[]" <?php if ( $qr['crdr'] == "Dr" ) {  ?> readonly <?php } ?> value="<?php echo $qr['cramount']; ?>" onchange="total();" size="8" style="text-align:right"/>
</td>
</tr>
<?php $i++; } ?>
</table>
<br />

<table cellpadding="5" cellspacing="5" align="center" border="0">
<tr>
<td><input type="text" style="visibility:hidden" size="8"/></td>
<td><input type="text" style="visibility:hidden" size="12"/></td>
<td><input type="text" style="visibility:hidden" size="12"/></td>
<td><input type="text" style="visibility:hidden" size="10"/></td>
<td><input type="text" style="visibility:hidden" size="8"/></td>
<td align="right"><strong>Total</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td width="10px"></td>
<td align="right"><input type="text" id="drtotal" style="text-align:right;background:none;border:none;" name="drtotal" value="0" size="8" align="right" readonly  /></td>
<td width="10px"></td>
<td align="right"><input type="text" id="crtotal" style="text-align:right;background:none;border:none;" name="crtotal" value="0" size="8" align="right" readonly /></td>
<td><input type="text" style="visibility:hidden" size="8"/></td>
</tr>
</table>
<center>
</br>
<table border="0">
<td style="vertical-align:middle"><strong>Narration</strong>&nbsp;&nbsp;&nbsp;</td>
<td><textarea id="remarks" name="remarks" rows="3" cols="50"></textarea></td>
</table>
</center>

</div>
<br />
<center>
<input type="submit" value="Save" id="Save" disabled="disabled" name="Save"/>&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=pp_creditnote&type=<?php echo $type; ?>';">
</center>
<br />
<!-- </center> -->

<br />
</form>
<script type="text/javascript">
function total()
{
/*if(index == -1)
var a = "";
else */
var a = index;
	var ctot = 0;
	var dtot = 0;
	
	for (var i = -1;i<index-1;i++)
	{
		ctot+=parseFloat(document.getElementById('cramount' + i).value);
		dtot+=parseFloat(document.getElementById('dramount' + i).value);
	}
	document.getElementById('crtotal').value = ctot;
	document.getElementById('drtotal').value = dtot;
	var type = document.getElementById('type').value;
	if ( type == "Credit")
	{
	var diff = dtot - ctot;
	}
	else
	{
	var diff = ctot - dtot;
	}
	var vamt = parseFloat(document.getElementById('vendamount').value);
	if( diff == vamt )
	{
	document.getElementById('Save').disabled = false;
	}
	else
	{
	document.getElementById('Save').disabled = true;
	}
}

</script>


