

<?php 
include "config.php";
include "jquery.php";

if(!isset($_GET['party']))
$party = "";
else
$party = $_GET['party'];

if(!isset($_GET['date']))
$date = date("d.m.Y");
else
$date = date("d.m.Y",strtotime($_GET['date']));


//party

mysql_query("SET  group_concat_max_len = 1000000");

	$q = "select group_concat(distinct(name) order by name) as name from contactdetails where type = 'party' or type = 'vendor and party' order by name";
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




<center>
<section class="grid_8">
  <div class="block-border">
  								
						
								
								
     <form class="block-content form" id="complex_form" name="form1" method="post" action="oc_savereceipt.php" onsubmit="return checkform1(this);">
		


<br />

<h1>Receipt</h1>
<br />


<b>Receipt</b>
<br />


(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br />
<br />
<br />



<table align="center" border="0">
<tr>
<td>
<strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>

<td>
<input type="text" id="date" name="date" size="15" onchange="check_limit(this);" value="<?php echo $date;?>" class="datepickerCOBIP"/>
</td>

<td title="Document Number">&nbsp;
<strong>Doc No.</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>
<td width="5px"></td>
<td>
<input type="text" id="doc_no" name="doc_no" size="15" value=""/>
</td>

<td>
<strong>Customer</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>
<td width="10px">&nbsp;</td> 
<td>
<select id="party" name="party" style="width:250px">
<option value="">-Select-</option>
<?php 

for($j=0;$j<count($name);$j++)
{
?>
<option title="<?php echo $name[$j];   ?>" value="<?php echo $name[$j]; ?>" <?php if($party == $name[$j]) { ?> selected="selected" <?php } ?>><?php echo $name[$j]; ?></option>
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
<option value="<?php echo $sec[$j]; ?>"><?php echo $sec[$j]; ?></option>
<?php }?></select>

 
 
 </td>





</tr>
</table>
<br /><br />
<table align="center" border="0">
<tr>


<td width="10px">&nbsp;</td>
<td <?php if($_SESSION['tax']==0) { ?> style="visibility:hidden" <?php } ?>>
<strong>TDS</strong>
</td>
<td width="10px">&nbsp;</td>
<td <?php if($_SESSION['tax']==0) { ?> style="visibility:hidden" <?php } ?>>
<select id="tds" name="tds" onchange="displaytdstable(this.value);">
<option value="With TDS">With TDS</option>
<option value="Without TDS" selected="selected">Without TDS</option>
</select>
</td>
<input type="hidden" id="choice" name="choice" value="On A/C" />
<td>
<strong>Reception Mode</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>
<td width="10px">&nbsp;</td>
<td>
<select id="paymentmode" name="paymentmode" style="width:100px" onchange="cashcheque(this.value);">
<option value="">-Select-</option>
<option value="Cash">Cash</option>
<option value="Cheque">Cheque</option>
<option value="Transfer">Transfer</option>

</select>
</td>
<td width="10px">&nbsp;</td>
<td>
<strong id="codename">Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>
<td width="10px">&nbsp;</td>
<td>
<select id="code" name="code" onchange="loadcodedesc(this.value)" style="width:120px">
<option value="">-Select-</option>
</select>
</td>

</tr>
</table>
<br />
<br />
<table id="TDStable" align="center" border="0">
<tr>
<td>
<strong>Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>
<td width="10px">&nbsp;</td><td>
<strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>
<td width="10px">&nbsp;</td><td>
<strong>Dr</strong>
</td>
<td width="10px">&nbsp;</td><td>
<strong>Amount</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>
<td width="10px">&nbsp;</td><td id="bankname">
<strong>Bank</strong>
</td>
<td width="10px">&nbsp;</td><td id="branchname">
<strong>Branch</strong>
</td>
<td width="10px">&nbsp;</td><td id="cheq_name_td">
<strong>Cheque #</strong>
</td>
<td width="10px">&nbsp;</td><td id="cheq_date_td">
<strong>Cheque Date</strong>
</td>
</tr>
<tr height="20px"><td>&nbsp;</td></tr>
<tr>
<td>
<input type="text" id="code1"  style="width:100px;" name="code1" value="" readonly/>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="description" size="20" name="description" value="" readonly/>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="dr" name="dr" size="6" value="Dr" readonly/>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="amount" name="amount" size="10" value="0" onkeyup="enablereceive(this.value);check_limit(this);" style="text-align:right"/>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="bank" name="bank" size="12" />
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="branch" name="branch" size="12" />
</td>
<td width="10px">&nbsp;</td>

<td id="cheq_name_text">
<input type="text" id="cheque" name="cheque" size="16" />
</td>
<td width="10px">&nbsp;</td>
<td id="cheq_date_text">
<input type="text" id="cdate" name="cdate" size="15" class="datepicker" value="<?php echo date("d.m.Y");?>"/>
</td>
</tr>
<tr id="TDSrow" style="Display:none">
<td>
<select id="tdscode@0" name="tdscode[]" style="width:105px" onchange="loadtdsdesc(this.id);">
<option value="">-Select-</option>
<?php for($j=0;$j<count($codedesc);$j++)
	{
	$codedesc1=explode("@",$codedesc[$j]);
	?>
	
	<option value="<?php echo $codedesc1[0];?>" title="<?php echo $codedesc1[1];?>"><?php echo $codedesc1[0];?></option>
	
	
	<?php }?>
</select>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="tdsdescription@0" size="20" name="tdsdescription[]" value="" readonly/>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="tdsdr@0" name="tdsdr[]" size="6" value="Dr" readonly/>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" style="text-align:right" id="tdsamount@0" name="tdsamount[]" size="10" value="0"/>
</td>
</tr>
</table>
<br />
<br />

<table align="center" border="0">
<td style="vertical-align:middle;"><strong>Narration&nbsp;&nbsp;&nbsp;</strong></td>
<td>
<textarea id="remarks" cols="40"  rows="3" name="remarks"></textarea>
</td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>
</table>
<br />

<br />
<center>

<input type="submit" id="save" disabled="disabled" name="save" value="Receive" /> &nbsp;&nbsp;&nbsp;
<input type="button" id="cancel" name="cancel" value="Cancel" onclick="document.location='dashboardsub.php?page=oc_receipt';"/>
</center>
</form>
</div>
</section></center>
<br />
<br />


<script type="text/javascript">



function checkform1(){

if(document.getElementById("doc_no").value==""){alert("Enter Document Number");			document.getElementById("doc_no").focus();			return false;}

if(document.getElementById('unitc').value == "")
	{
	 alert("Select Location");
	 return false;
	}

	if(document.getElementById('party').value == "")
	{
	 alert("Select customer");
	 return false;
	}


	if(document.getElementById('paymentmode').value == "")
	{
	 alert("Select receipt mode");
	 return false;
	}
if(document.getElementById('code1').value =="" || document.getElementById('description').value =="")
	return false;

	if(document.getElementById('tds').value =="With TDS" && Number(document.getElementById('tdsamount@0').value)>0)
	
	{
	if(document.getElementById('tdscode@0').value=="")
	{
	alert("please select code at row2");
	return false;
	}
	
	}
	
	document.getElementById('save').disabled=true;

}




function check_limit(dis)
{
	var pay_mode=document.getElementById("paymentmode").value;
	var dt=document.getElementById("date").value;
	
	dt=dt.split(".");
	dt=dt[2]+"-"+dt[1]+"-"+dt[0];
	
	if(document.getElementById("amount").value>0)
		document.getElementById("save").disabled=false;
}


function cashcheque(a)
{
document.getElementById('code1').value = "";
document.getElementById('description').value = "";

document.getElementById('code').options.length=1;
var code = document.getElementById('code');

document.getElementById("bankname").style.display="block";
document.getElementById("bank").style.display="block";
document.getElementById("branchname").style.display="block";
document.getElementById("branch").style.display="block";
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

document.getElementById("bankname").style.display="none";
document.getElementById("bank").style.display="none";
document.getElementById("branchname").style.display="none";
document.getElementById("branch").style.display="none";
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

}

if(a=="Transfer"){
document.getElementById("cheq_name_td").style.display="none";
document.getElementById("cheq_name_text").style.display="none";
document.getElementById("cheq_date_td").style.display="none";
document.getElementById("cheq_date_text").style.display="none";
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
 //alert(code+" "+cashbank1[0]);
if(code==cashbank1[0])
document.getElementById('description').value =cashbank1[1];


}


}
var TDSindex = 0;

function enablereceive(value)
{
 if(value != 0 && value != "")
 document.getElementById('save').disabled = false;
 else
 document.getElementById('save').disabled = true;
 
}
function displaytdstable(a)
{
	document.getElementById('TDSrow').style.display = "none";
	if(a == "With TDS")
	{
		document.getElementById('TDSrow').style.display = "";
	}
	
}


function loadtdsdesc(id)
{
var id1 = id.split("@");
var index1 = id1[1];
document.getElementById('tdsdescription@' + index1).value = "";
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

function reloadpage(party)
{
	var date = document.getElementById('date').value;
	document.location = "dashboard.php?page=oc_addreceipt&party=" + party + "&date=" + date;
}
</script>
<script type="text/javascript">
function script1() {
window.open('O2CHelp/help_p_addreceipt.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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