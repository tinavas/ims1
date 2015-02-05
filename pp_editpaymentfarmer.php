<?php 
include "config.php";
include "jquery.php";
$id=$_GET['id'];
$query = "select * from pp_paymentfarmer where tid = $id";
$result = mysql_query($query,$conn) or die(mysql_error());
$globalresult = mysql_fetch_assoc($result);
?>
<center>
<br>
<h1>Farmer's Payment</h1>
<br>
						
<form method="post" id="form1" name="form1" action="pp_savepaymentfarmer.php"> 
<table>
<tr>
<td>
<strong>Date</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="date" name="date" size="15" value="<?php echo date("d.m.Y",strtotime($globalresult['date'])); ?>" class="datepicker" />
</td>
<!--<td width="10px">&nbsp;</td>
<td title="Document Number">
<strong>Doc No.</strong>
</td>
<td width="5px"></td>
<td>
<input type="text" id="doc_no" name="doc_no" size="15" value=""/>
</td>-->
<td width="10px">&nbsp;</td>
<td>
<strong>Farmer</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<select id="farmer" name="farmer" onChange="getflocks(this.value);" >
<option value="">-Select-</option>
<?php 
	$q = "select distinct(farmcode) from layer_flock order by farmcode";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
<option value="<?php echo $qr['farmcode']; ?>" <?php if($globalresult['farmer'] == $qr['farmcode']) { ?> selected="selected" <?php } ?> ><?php echo $qr['farmcode']; ?></option>
<?php } ?>
</select>
</td>
<td width="10px">&nbsp;</td>
<td>&nbsp;<strong>Flock</strong>&nbsp;</td>
<td><select id="flock" name="flock" style="width:100px">
<option value="" >-Select-</option>
<?php $result = mysql_query("select distinct(flockcode),flockdescription from layer_flock where farmcode = '$globalresult[farmer]' and client = '$client' order by flockcode",$conn)or die (mysql_error());
  while($res = mysql_fetch_assoc($result))
  {?>
  <option value="<?php echo $res['flockcode']; ?>" <?php if($globalresult['flock'] == $res['flockcode']) { ?> selected="selected" <?php } ?> ><?php echo $res['flockcode']; ?></option>
<?php } ?>
</select>
</tr>
</table>
<br /><br />
<table>
<tr>

<td width="10px">&nbsp;</td>
<td>
<strong>Payment Mode</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<select id="paymentmode" name="paymentmode" style="width:100px" onChange="cashcheque(this.value);">
<option value="">-Select-</option>
<option value="Cash" <?php if($globalresult['paymentmode'] == "Cash") {?> selected="selected" <?php } ?> >Cash</option>
<option value="Cheque" <?php if($globalresult['paymentmode'] == "Cheque") {?> selected="selected" <?php } ?>>Cheque</option>
<option value="Others" <?php if($globalresult['paymentmode'] == "Others") {?> selected="selected" <?php } ?>>Others</option>
</select>
</td>
<td width="10px">&nbsp;</td>
<td>
<strong id="codename">Code</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<select id="code" name="code" onChange="loadcodedesc(this.value)" style="width:120px">
<option value="">-Select-</option>
<option value="<?php echo $globalresult['bankcashcode']; ?>" selected="selected"><?php echo $globalresult['bankcashcode']; ?></option>
</select>
</td>
</tr>
</table>
<br />
<br />
<table id="TDStable">
<tr>
<td>
<strong>Code</strong>
</td>
<td width="10px">&nbsp;</td><td>
<strong>Description</strong>
</td>
<td width="10px">&nbsp;</td><td>
<strong>Cr</strong>
</td>
<td width="10px">&nbsp;</td><td>
<strong>Amount</strong>
</td>
<td  width="10px">&nbsp;</td><td id="cheq_name_td">
<strong>Cheque #</strong>
</td>
<td width="10px">&nbsp;</td><td id="cheq_date_td">
<strong>Cheque Date</strong>
</td>
</tr>
<tr height="20px"><td>&nbsp;</td></tr>
<tr>
<td>
<input type="text" id="code1" size="14" name="code1" value="<?php echo $globalresult['coacode'];?>" readonly/>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="description" size="20" name="description" value="<?php echo $globalresult['description'];?>" readonly/>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="cr" name="cr" size="6" value="Cr" readonly/>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="amount" name="amount" size="10" value="<?php echo $globalresult['amount'];?>" style="text-align:right"/>
</td>
<td width="10px">&nbsp;</td>
<td id="cheq_name_text">
<input type="text" id="cheque" name="cheque" size="16" value="<?php if($globalresult['cheque']) echo $globalresult['cheque']; else echo "&nbsp;"; ?>" />
</td>
<td width="10px">&nbsp;</td>
<td id="cheq_date_text">
<input type="text" id="cdate" name="cdate" size="15" class="datepicker" value="<?php if($globalresult['cdate']) echo date("d.m.Y",strtotime($globalresult['cdate'])); else echo "&nbsp;"; ?>"/>
</td>
</tr>
</table>
<br />
<br />
<table>
<td style="vertical-align:middle;"><strong>Narration&nbsp;&nbsp;&nbsp;</strong></td>
<td>
<textarea id="remarks" cols="40"  rows="3" name="remarks"><?php echo $globalresult['narration'];?></textarea>
</td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>
</table>
<br />
<div id="validatecurrency"></div><br>
<br />
<input type="submit" id="save" name="save" value="Pay" onClick="return checkamount();" /> &nbsp;&nbsp;&nbsp;
<input type="button" id="cancel" name="cancel" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_paymentfarmer';"/>
<input type="hidden" id="edit" name="edit" value="<?php echo $globalresult['tid'];?>">
</form>
</center>

<script type="text/javascript">

function checkamount()
{

 if(document.getElementById('farmer').value == "")
  {
  alert('please select Farmer');
  return false;
  }
  else if (document.getElementById('flock').value == "")
  {
  alert('please select Flock');
  return false;
  }
  else if (document.getElementById('paymentmode').value == "")
  {
  alert('please select Payment Mode');
  return false;
  }
  else if (document.getElementById('code').value == "")
  {
  alert('please select Cash Code');
  return false;
  }
  else if(document.getElementById('amount').value == '' || document.getElementById('amount').value == 0)
 {
  alert('please enter amount');
  return false;
 } 
 
 return true;
 

}


function cashcheque(a)
{
document.getElementById('code1').value = "";
document.getElementById('description').value = "";

removeAllOptions(document.getElementById('code'));
var code = document.getElementById('code');
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
code.appendChild(theOption1);


document.getElementById("cheq_name_td").style.display="block";
document.getElementById("cheq_name_text").style.display="block";
document.getElementById("cheq_date_td").style.display="block";
document.getElementById("cheq_date_text").style.display="block";


if(a == "Cash")
{
document.getElementById('codename').innerHTML = "Cash Code";
<?php 
	$q = "select distinct(code) from ac_bankmasters where mode = 'Cash' order by code";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['code']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $qr['code']; ?>";
code.appendChild(theOption1);
<?php
	}
?>
document.getElementById("cheq_name_td").style.display="none";
document.getElementById("cheq_name_text").style.display="none";
document.getElementById("cheq_date_td").style.display="none";
document.getElementById("cheq_date_text").style.display="none";
}
else if(a == "Cheque")
{
document.getElementById('codename').innerHTML = "Bank A/C No.";

<?php 
	$q = "select distinct(acno) from ac_bankmasters where mode = 'Bank' order by acno";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['acno']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $qr['acno']; ?>";
code.appendChild(theOption1);
<?php
	}
?>
}
}

function loadcodedesc(a)
{

var mode = document.getElementById('paymentmode').value;
document.getElementById('code1').value = "";
document.getElementById('description').value = "";
if(a== "")
return;
<?php 
$q = "select code,acno,coacode from ac_bankmasters order by coacode";
$qrs = mysql_query($q) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
echo " if( mode == 'Cash') { ";
echo " if(a == '$qr[code]') { ";
?>
document.getElementById('code1').value = "<?php echo $qr['coacode']; ?>";
<?php 
echo " } } else if( mode == 'Cheque') { ";
echo " if(a == '$qr[acno]') { ";
?>
document.getElementById('code1').value = "<?php echo $qr['coacode']; ?>";
<?php 
echo " } } ";
}
?>

<?php 
$q1 = "select distinct(code) from ac_coa order by code";
$q1rs = mysql_query($q1) or die(mysql_error());
while($q1r = mysql_fetch_assoc($q1rs))
{
echo "if(document.getElementById('code1').value == '$q1r[code]') { ";

$q = "select distinct(description) from ac_coa where code = '$q1r[code]' order by description";
$qrs = mysql_query($q) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
{
?>
document.getElementById('description').value = "<?php echo $qr['description']; ?>";
<?php
}
echo " } ";
}
?>
}

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.options.remove(i);
		selectbox.remove(i);
	}
}


function getflocks(farm)
{
 var id = document.getElementById('flock');
 for($i=id.length;$i>0;$i--)
  id.remove($i);
  
<?php $result = mysql_query("select distinct(farmcode),flockcode,flockdescription from layer_flock where client = '$client' order by flockcode",$conn)or die (mysql_error());
  while($res = mysql_fetch_assoc($result))
  {?>
    if(farm == "<?php echo $res['farmcode']; ?>")
	{
	theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("<?php echo $res['flockcode']; ?>");
    theOption1.appendChild(theText1);
    theOption1.value = "<?php echo $res['flockcode']; ?>";
    theOption1.title = "<?php echo $res['flockdescription']; ?>";
    id.appendChild(theOption1);
	
	}
	
<?php } ?>	
   
}

</script>
<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_p_addpaymentfarmer.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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