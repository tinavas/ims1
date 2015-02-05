<html>
<head>
</head>
<body>
<?php
include "config.php";
$gquery = "select * from pp_payment where tid = '$_GET[id]'";
$gresult = mysql_query($gquery,$conn) or die(mysql_error());

$globalrow = mysql_fetch_assoc($gresult);





$q1=mysql_query("SET group_concat_max_len=10000000");

//vendor name

	$q = "select group_concat(distinct(name) order by name) as name from contactdetails where type = 'vendor' or type = 'vendor and party' order by name";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	$qr = mysql_fetch_assoc($qrs);
	$name=explode(",",$qr['name']);
//sectors

        if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
       
		$q = "SELECT group_concat(distinct(Sector) order by sector) as sector FROM tbl_sector WHERE type1 <> 'Warehouse' order by sector";
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	  
		$q = "SELECT  group_concat(distinct(Sector) order by sector) as sector FROM tbl_sector WHERE type1 <> 'Warehouse'  and sector in ($sectorlist) order by sector";
	   
	 }
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		$qr = mysql_fetch_assoc($qrs);
		$sec=explode(",",$qr['sector']);
	
		//code and description
		
		
		 $query = "SELECT group_concat(distinct(code),'@',description ORDER BY code ASC)  as cd FROM ac_coa where controltype='' "; 
		 $result = mysql_query($query,$conn); 
      $row1 = mysql_fetch_assoc($result);
	  {
	  
	  $codedesc=explode(",",$row1['cd']);
	  
	  }
	
	$codedesc1=json_encode($codedesc);
	
	//cash
	
		$q = "select  group_concat(code,'@',coacode order by code) as cashcode  from ac_bankmasters where mode = 'Cash' order by code";
	$qrs = mysql_query($q) or die(mysql_error());
	$qr = mysql_fetch_assoc($qrs);
	{
	$cashcode=explode(",",$qr['cashcode']);
	
	}

$cashcode1=json_encode($cashcode);


//bank

	$q = "select group_concat(acno,'@',coacode  order by acno) as bankcode from ac_bankmasters where mode = 'Bank' order by acno";
	$qrs = mysql_query($q) or die(mysql_error());
	$qr = mysql_fetch_assoc($qrs);
	{
	$bankcode=explode(",",$qr['bankcode']);
	
	}

$bankcode1=json_encode($bankcode);

//cash bank code& desc

		 $query = "SELECT group_concat(distinct(code),'@',description ORDER BY code ASC)  as cd FROM ac_coa "; 
		 $result = mysql_query($query,$conn); 
      $row1 = mysql_fetch_assoc($result);
	  {
	  
	  $cashbank=explode(",",$row1['cd']);
	  
	  }
	
	$cashbank1=json_encode($cashbank);


?>
<script type="text/javascript">
var cashbank=<?php if(empty($cashbank1)) { echo "0";} else {echo $cashbank1;}?>;
var codedesc=<?php if(empty($codedesc1)) { echo "0";} else {echo $codedesc1;}?>;
var cashcode=<?php if(empty($cashcode1)) { echo "0";} else {echo $cashcode1;}?>;
var bankcode=<?php if(empty($bankcode1)) { echo "0";} else {echo $bankcode1;}?>;

</script>





<?php 
include "config.php";
include "jquery.php";

?>

<center>
<section class="grid_8">
  <div class="block-border">
  								
						
								
								
     <form class="block-content form" id="complex_form" name="form1" method="post" action="pp_savepayment.php" onsubmit="return checkform(this);">
		


<br />

<h1>Payment</h1>
<br />


<b>Payment</b>
<br />


(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br />
<br />
<br />


<input type="hidden" name="deltid" id="deltid" value="<?php echo $_GET['id']; ?>" />
<input type="hidden" id="cuser" name="cuser" value="<?php echo  $globalrow['empname'];?>" />

<input type="hidden" id="saed" name="saed" value="1"/>
<table>
<tr>
<td>
<strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="date" name="date" size="15" onChange="check_limit(this);check_tdslimit(dis);" value="<?php echo date("d.m.Y",strtotime($globalrow['date']));?>" class="datepicker"   />
</td>

<td title="Document Number">
&nbsp;<strong>Doc No</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="doc_no" name="doc_no" size="15" value="<?php echo $globalrow['doc_no'];?>" />
</td>
<td width="10px">&nbsp;</td>
<td>
<strong>Vendor</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>
<td width="10px">&nbsp;</td>
<td>
<select  id="vendor" name="vendor"  style="width:200px" >
<option value="">-Select-</option>
<?php

for($j=0;$j<count($name);$j++)
{
?>
<option title="<?php echo $name[$j];   ?>" value="<?php echo $name[$j]; ?>" <?php if($globalrow['vendor'] == $name[$j]) { ?> selected="selected" <?php } ?>><?php echo $name[$j]; ?></option>
<?php } ?>



</select>
</td>


<td align="right"><strong>Location</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left">

 <select id="unitc" name="unitc"  >
<option value="">-Select-</option>


<?php 

for($j=0;$j<count($sec);$j++)
{
?>
<option value="<?php echo $sec[$j]; ?>" <?php if($sec[$j]==$globalrow['unit']) {?> selected="selected" <?php  } ?>  ><?php echo $sec[$j]; ?></option>
<?php }?>


</select>

 
 
 </td>



</tr>
</table>
<br /><br />
<table>




<tr>
<td width="10px">&nbsp;</td>

<td <?php if($_SESSION['tax']==0) { ?> style="visibility:hidden" <?php } ?>>

<strong>TDS</strong>

</td>

<td width="10px">&nbsp;</td>

<td <?php if($_SESSION['tax']==0) { ?> style="visibility:hidden" <?php } ?>>


<select id="tds" name="tds" onChange="displaytdstable(this.value);">

<option value="With TDS" <?php if($globalrow['tds']== "With TDS"){?> selected="selected"<?php } ?>>With TDS</option>

<option value="Without TDS" <?php if($globalrow['tds']== "Without TDS"){?> selected="selected"<?php } ?>>Without TDS</option>

</select>

</td>
<input type="hidden" id="choice" name="choice" value="On A/C" />
<td width="10px">&nbsp;</td>

<td>

<strong>Payment Mode</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>



</td>

<td width="10px">&nbsp;</td>

<td>

<select id="paymentmode" name="paymentmode" style="width:100px" onChange="cashcheque(this.value);">

<option value="">-Select-</option>

<option value="Cash"  <?php if($globalrow['paymentmode']== "Cash"){?> selected="selected"<?php } ?>>Cash</option>

<option value="Cheque"  <?php if($globalrow['paymentmode']== "Cheque"){?> selected="selected"<?php } ?>>Cheque</option>

<option value="Transfer" <?php if($globalrow['paymentmode'] == "Transfer") { ?> selected="selected" <?php } ?>>Transfer</option>

<option value="Others"  <?php if($globalrow['paymentmode']== "Others"){?> selected="selected"<?php } ?>>Others</option>

</select>





</td>

<td width="10px">&nbsp;</td>

<td>

<?php if($globalrow['paymentmode'] == "Cash") { ?>

<strong id="codename">Cash Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>

<?php } else { ?>

<strong id="codename">Bank A/C No. </strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>

<?php } ?>



</td>

<td width="10px">&nbsp;</td>

<td>

<select id="code" name="code" onChange="loadcodedesc(this.value)" style="width:120px">

<option value="">-Select-</option>



 <?php
  
  
  if($globalrow['paymentmode'] == "Cash")
  {
 
       
 for($j=0;$j<count($cashcode);$j++)
		   {
			$cashcodes1=explode('@',$cashcode[$j]);
		
           ?>
<option value="<?php echo $cashcodes1[0];?>"  <?php if($cashcodes1[0]==$globalrow['code']){ ?> selected="selected" <?php  } ?> title="<?php echo $cashcodes1[0]; ?>"><?php echo $cashcodes1[0]; ?></option>
<?php } 


  } 
    else
	{
	
	for($j=0;$j<count($bankcode);$j++)
		   {
			$bankcodes1=explode('@',$bankcode[$j]);
           ?>
<option value="<?php echo $bankcodes1[0];?>"  <?php if($bankcodes1[0]==$globalrow['code']){ ?> selected="selected" <?php  } ?> title="<?php echo $bankcodes1[0]; ?>"><?php echo $bankcodes1[0]; ?></option>
<?php }  }?>

</select>



</td>



</tr>
</table>





<br />
<br />
<table id="TDStable">


<tr>

<td>

<strong>Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>

</td>

<td width="10px">&nbsp;</td><td>

<strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>

</td>

<td width="10px">&nbsp;</td><td>

<strong>Cr</strong>

</td>

<td width="10px">&nbsp;</td><td>

<strong>Amount</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>

</td>




<td width="10px">&nbsp;</td><td id="cheq_name_td" <?php if($globalrow['paymentmode'] == "Cash" || $globalrow['paymentmode'] == "Transfer") { ?> style="display:none" <?php } ?>>

<strong>Cheque #</strong>

</td>

<td width="10px">&nbsp;</td><td id="cheq_date_td" <?php if($globalrow['paymentmode'] == "Cash" || $globalrow['paymentmode'] == "Transfer" ) { ?> style="display:none" <?php } ?>>

<strong>Cheque Date</strong>

</td>

</tr>



<tr height="20px"><td>&nbsp;</td></tr>

<tr>

<td>

<input type="text" id="code1"  style="width:100px;" name="code1" value="<?php echo $globalrow['code1'];?>" readonly/>

</td>

<td width="10px">&nbsp;</td>

<td>

<input type="text" id="description" size="20" name="description" value="<?php echo $globalrow['description']; ?>" readonly/>

</td>

<td width="10px">&nbsp;</td>

<td>

<input type="text" id="cr" name="cr" size="6" value="Cr" readonly/>

</td>

<td width="10px">&nbsp;</td>

<td>

<input type="text" id="amount" name="amount" size="10" value="<?php echo $globalrow['amount'];?>" style="text-align:right" onKeyUp="check_limit(this);"/>

</td>

<td width="10px">&nbsp;</td>



<td id="cheq_name_text" <?php if($globalrow['paymentmode'] == "Cash"  || $globalrow['paymentmode'] == "Transfer") { ?> style="display:none" <?php } ?>>

<input type="text" id="cheque" name="cheque" size="16" <?php if($globalrow['paymentmode'] != "Cash"  || $globalrow['paymentmode']!= "Transfer") { ?> value="<?php echo $globalrow['cheque']; ?>" <?php } ?>  />

</td>

<td width="10px">&nbsp;</td>

<td id="cheq_date_text" <?php if($globalrow['paymentmode'] == "Cash"  || $globalrow['paymentmode'] == "Transfer") { ?> style="display:none" <?php } ?>>

<input type="text" id="cdate" name="cdate" size="15" class="datepicker" <?php if($globalrow['paymentmode'] != "Cash"  || $globalrow['paymentmode']!= "Transfer") { ?> value="<?php echo date("d.m.Y",strtotime($globalrow['cdate'])); ?>" <?php } ?>/>

</td>



</tr>







<?php

$query = "select * from ac_financialpostings where trnum = '$globalrow[tid]' and type = 'PMT' and coacode <> '$globalrow[code1]' and crdr = 'Cr'";

$result1 = mysql_query($query,$conn) or die(mysql_error());

if(mysql_num_rows($result1) > 0)

{

$i = 0;

while($res = mysql_fetch_assoc($result1))

{

?>





<tr id="TDSrow">

<td>



<select id="tdscode@<?php echo $i; ?>" name="tdscode[]" style="width:105px" onChange="loadtdsdesc(this.id);">

<option value="">-Select-</option>



<?php for($j=0;$j<count($codedesc);$j++)
	{
	$codedesc1=explode("@",$codedesc[$j]);
	?>
	
	<option value="<?php echo $codedesc1[0];?>"  <?php if($globalrow['tdscode'] == $codedesc1[0]) { ?> selected="selected" <?php } ?> title="<?php echo $codedesc1[1];?>"><?php echo $codedesc1[0];?></option>
	
	
	<?php }?>


</select>

</td>

<td width="10px">&nbsp;</td>

<td>

<input type="text" id="tdsdescription@<?php echo $i; ?>" size="20" name="tdsdescription[]" value="<?php echo $globalrow['tdsdescription'];?>; ?>" readonly/>

</td>

<td width="10px">&nbsp;</td>

<td>

<input type="text" id="tdscr@<?php echo $i; ?>" name="tdscr[]" size="6" value="Cr" readonly/>

</td>

<td width="10px">&nbsp;</td>

<td>

<input type="text" style="text-align:right" id="tdsamount@<?php echo $i; ?>" name="tdsamount[]" size="10" value="<?php echo $res['amount']; ?>" />

</td>

</tr>

<?php $i++; } } else { ?>

<tr id="TDSrow" <?php if($globalrow['tds'] != "With TDS"){?> style="Display:none" <?php }?>>

<td>



<select id="tdscode@0" name="tdscode[]" style="width:100px" onChange="loadtdsdesc(this.id);">

<option value="">-Select-</option>



<?php for($j=0;$j<count($codedesc);$j++)
	{
	$codedesc1=explode("@",$codedesc[$j]);
	?>
	
	<option value="<?php echo $codedesc1[0];?>"  <?php if($globalrow['tdscode'] == $codedesc1[0]) { ?> selected="selected" <?php } ?> title="<?php echo $codedesc1[1];?>"><?php echo $codedesc1[0];?></option>
	
	
	<?php }?>



</select>

</td>

<td width="10px">&nbsp;</td>

<td>

<input type="text" id="tdsdescription@0" size="20" name="tdsdescription[]" value="" readonly/>

</td>

<td width="10px">&nbsp;</td>

<td>

<input type="text" id="tdscr@0" name="tdscr[]" size="6" value="Cr" readonly/>

</td>

<td width="10px">&nbsp;</td>

<td>

<input type="text" style="text-align:right" id="tdsamount@0" name="tdsamount[]" size="10" value="0" />

</td>

</tr>





<?php } ?>

</table>


<br/>
<br/>
<br/>
<table>

<td style="vertical-align:middle;"><strong>Narration&nbsp;&nbsp;&nbsp;</strong></td>
<td>
<textarea id="remarks" cols="40"  rows="3" name="remarks"><?php echo $globalrow['remarks']; ?></textarea>
</td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>
</table>
<br />

<br />
<input type="submit" id="save" name="save" value="Update" /> &nbsp;&nbsp;&nbsp;
<input type="button" id="cancel" name="cancel" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_payment';"/>
</form>
</div>
</section>
</center>

<script type="text/javascript">
var flag = 0;

function check_limit(dis)
{
	var pay_mode=document.getElementById("paymentmode").value;
	var dt=document.getElementById("date").value;
	
dt=dt.split(".");
	dt=dt[2]+"-"+dt[1]+"-"+dt[0];
	
	if(document.getElementById("amount").value>0)
		document.getElementById("save").disabled=false;
}



function checkform()
	{
	
		if(document.getElementById("doc_no").value=="")
		{
		alert("Enter Document Number");						          
		document.getElementById("doc_no").focus();		
		return false;
		}
		
		
if(document.getElementById('unitc').value == "")
	{
	 alert("Select unit");
	 return false;
	}

	if(document.getElementById('vendor').value == "")
	{
	 alert("Select vendor");
	 return false;
	}


	

if(document.getElementById('paymentmode').value == "")
	{
	 alert("Select payment mode");
	 return false;
	}

	if(document.getElementById('code1').value =="" || document.getElementById('description').value =="")
	return false;
	
	
	
	document.getElementById('save').disabled=true;
	
		
	}



function check_tdslimit(dis)
{
	var pay_mode=document.getElementById("tds").value;
	var dt=document.getElementById("date").value;
	dt=dt.split(".");
	dt=dt[2]+"-"+dt[1]+"-"+dt[0];

	if(document.getElementById("tdsamount@0").value>0)
		document.getElementById("save").disabled=false;
}





function cashcheque(a)
{


document.getElementById('code1').value = "";

document.getElementById('description').value = "";



document.getElementById('code').options.length=1;

var code = document.getElementById('code');



document.getElementById("cheq_name_td").style.display="block";

document.getElementById("cheq_name_text").style.display="block";

document.getElementById("cheq_date_td").style.display="block";

document.getElementById("cheq_date_text").style.display="block";



if(a == "Cash")
{
document.getElementById('codename').innerHTML = "Cash Code";
for(j=0;j<cashcode.length;j++)
{
var cc=cashcode[j];
var cashcode1=cc.split("@");
var op1=new Option(cashcode1[0],cashcode1[0]);
	code.options.add(op1);



}



document.getElementById("cheq_name_td").style.display="none";
document.getElementById("cheq_name_text").style.display="none";
document.getElementById("cheq_date_td").style.display="none";
document.getElementById("cheq_date_text").style.display="none";
}
else if(a == "Cheque" || a== 'Transfer')
{
document.getElementById('codename').innerHTML = "Bank A/C No.";

for(j=0;j<bankcode.length;j++)
{

var bc=bankcode[j];
var bankcode1=bc.split("@");
var op1=new Option(bankcode1[0],bankcode1[0]);
code.options.add(op1);


}




if(a=='Transfer'){
document.getElementById("cheq_name_td").style.display="none";
document.getElementById("cheq_name_text").style.display="none";
document.getElementById("cheq_date_td").style.display="none";
document.getElementById("cheq_date_text").style.display="none";
}

}

}

function loadcodedesc(a)
{






var mode = document.getElementById('paymentmode').value;

document.getElementById('code1').value = "";

document.getElementById('description').value = "";

if(a== "")

return;
if(mode=="Cash")
{
for(j=0;j<cashcode.length;j++)
{
var cc=cashcode[j];
var cashcode1=cc.split("@");

if(a==cashcode1[0])
document.getElementById('code1').value =cashcode1[1];


}


}

else if( mode == 'Cheque' || mode == 'Transfer')
{

for(j=0;j<bankcode.length;j++)
{

var bc=bankcode[j];
var bankcode1=bc.split("@");
if(a==bankcode1[0])
document.getElementById('code1').value =bankcode1[1];


}


}

code=document.getElementById('code1').value;
for(j=0;j<cashbank.length;j++)
{

var cd=cashbank[j];

var cashbank1=cd.split("@");
if(code==cashbank1[0])
document.getElementById('description').value =cashbank1[1];


}


}
var TDSindex = parseInt(<?php echo $i-1;?>);

function displaytdstable(a)
{
	document.getElementById('TDSrow').style.display = "none";
	if(a == "With TDS")
	{
		document.getElementById('TDSrow').style.display = "inline";
	}
	
}



function loadtdsdesc(id)
{
var id1 = id.split("@");
var index1 = id1[1];
if( document.getElementById(id).selectedIndex == 0 )
{
	document.getElementById("tdsdescription@" + index1).value = "";
	document.getElementById(id).focus();
	alert("Please select TDS Code");
	return;
}
for(var i = 0; i <=TDSindex;i++)
{
	for(var j = 0; j <=TDSindex;j++)
	{
		if( i != j )
		{
			if(document.getElementById('tdscode@' + i).value == document.getElementById('tdscode@' + j).value)
			{
			document.getElementById('tdsdescription@' + j).value = "";
			alert("Please select different combinations");
			return;
			}
		}
	}
}

var tdscode = document.getElementById('tdscode@' + index1).value

for(j=0;j<codedesc.length;j++)
{

var cd=codedesc[j];
var codedesc1=cd.split("@");
if(codedesc1[0]==tdscode)
document.getElementById('tdsdescription@'+ index1).value =codedesc1[1];


}


}


</script>
<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_p_editpayment.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=no');
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