<?php
include "jquery.php"; 
include "config.php";

$id= $_GET['id'];
$query1 = "SELECT * FROM vehicle_renewal where id = '$id'";
$result1 = mysql_query($query1,$conn); 
while($row1 = mysql_fetch_assoc($result1))
{

    $id =  $row1['id'];
	 $date = date("d.m.Y", strtotime($row1['date']));
$vtype= $row1['vehicletype'];
$vnumber = $row1['vehiclenumber'];
$ccode = $row1['chargecode'];
$amount = $row1['amount'];
$time = $row1['validtime'];
$narration = $row1['narration'];
$mode=$row1['mode'];
$expensecoa=$row1['expensecoa'];
$cashbank=$row1['cashbankcoa'];


}


$q1=mysql_query("SET group_concat_max_len=10000000");
	

//cash code

	   
		  if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		   	$q = "select group_concat(code,'@',coacode order by code) as cashcode from ac_bankmasters where mode = 'Cash' and client = '$client'";
		   }
		   else
		   {
		   $sectorlist = $_SESSION['sectorlist'];
		  $q = "select group_concat(code,'@',coacode order by code)   as cashcode from ac_bankmasters where mode = 'Cash' and client = '$client' AND coacode IN (SELECT coacode FROM ac_bankmasters WHERE code IN (SELECT code FROM ac_bankcashcodes WHERE sector In ($sectorlist) ORDER BY code ASC)) ";
		   }
		
	$qrs = mysql_query($q,$conn) or die(mysql_error());
		$qr = mysql_fetch_assoc($qrs);
		
		
		 $cashcodes=explode(",",$qr["cashcode"]);	
		 $cashcodes1=json_encode($cashcodes);
	

//bank code

	if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		   	$q = "select group_concat(acno,'@',coacode  order by acno) as bankcode from ac_bankmasters where mode = 'Bank' and client = '$client' order by acno";
		   }
		   else
		   {
		    $sectorlist = $_SESSION['sectorlist'];
			$q = "select group_concat(acno,'@',coacode  order by acno) as bankcode from ac_bankmasters where mode = 'Bank' and client = '$client' AND coacode IN (SELECT coacode FROM ac_bankmasters WHERE code IN (SELECT code FROM ac_bankcashcodes WHERE sector In ($sectorlist) ORDER BY code ASC)) order by acno";
		   }



$qrs = mysql_query($q,$conn) or die(mysql_error());
		$qr = mysql_fetch_assoc($qrs);
		
		
		 $bankcodes=explode(",",$qr["bankcode"]);	
		 $bankcodes1=json_encode($bankcodes);



		

	
	
	
		
//iteams and codes

 $q = "SELECT GROUP_CONCAT(code ORDER BY code ) AS codedesc from ac_coa where controltype in('','Bank','Cash') and type = 'Expense' and schedule not in('Inventories','Inventories Work In Progress','Trade Receivable','Trade Payable','Cost Of Sales /Services','Price Variance','Production Variance')";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		$r=mysql_fetch_array($qrs);
{
$items=explode(",",$r['codedesc']);

} 
$item=json_encode($items);



?>

<script type="text/javascript">


var items=<?php if(empty($item)){echo 0;} else{ echo $item; }?>;


var bankcodes=<?php if(empty($bankcodes1)){echo 0;} else{ echo $bankcodes1; }?>;
var cashcodes=<?php if(empty($cashcodes1)){echo 0;} else{ echo $cashcodes1; }?>;

</script>

<center>
<br />
<h1>Edit Charge Renewal</h1>

<br /><br />
<form id="form1" name="form1" method="post" action="vehicle_updaterenewal.php" onsubmit="return checkform(this)" >
<table border="0">

<tr>




<input type="hidden" id="id" name = "id" value="<?php echo $id;?>"/>

<td align="right"><strong>Date</strong>&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;<input class="datepicker" type="text" size="18" id="date" name="date" value="<?php echo date("d.m.Y"); ?>" ></td>
<td width="10px"></td>

<td align="right">&nbsp;&nbsp;<strong>Vehicle Type</strong>&nbsp;&nbsp;&nbsp;</td>


<td align="left"><select name="vt" id="vt" style="width:130px" onChange="getnum(this.value);"  >
<option value="">-Select-</option>
<?php include "config.php"; 
      $query = "SELECT * from vehicle_type where client = '$client' ";
      $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result))
      {
if($row1['vtype'] == $vtype)
 {
?>
<option value="<?php echo $row1['vtype']; ?>" selected="selected"><?php echo $row1['vtype']; ?></option>
<?php } else{ ?>
<option value="<?php echo $row1['vtype']; ?>" ><?php echo $row1['vtype']; ?></option>

<?php }}?>
</select>
</td>


</tr>


<tr style="height:10px"></tr>

<tr>

<td><strong>Vehicle No:&nbsp;&nbsp;</strong></td>

<td>
<select name="vnum" id="vnum" style="width:120px" >
<option value="">-Select-</option>
<?php include "config.php"; 
      $query = "SELECT distinct(vnumber) from vehicle_master where vtype = '$vtype'";
      $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result))
      {
 if($row1['vnumber'] == $vnumber)
 {
?>
<option value="<?php echo $row1['vnumber']; ?>" selected="selected"><?php echo $row1['vnumber']; ?></option>
<?php } else{ ?>
<option value="<?php echo $row1['vnumber']; ?>" ><?php echo $row1['vnumber']; ?></option>

<?php }}?>
</select>
</td>
<td width="10px"></td>
<td><strong>Charge Code&nbsp;&nbsp;</strong></td>

<td>
<select name="ccode" id="ccode" style="width:120px" >
<option value="">-Select-</option>
<?php include "config.php"; 
      $query = "SELECT distinct(chargecode) from vehicle_chargemaster where vehicletype like  '%$vtype%'";
      $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result))
      {
 if($row1['chargecode'] == $ccode)
 {
?>
<option value="<?php echo $row1['chargecode']; ?>" selected="selected"><?php echo $row1['chargecode']; ?></option>
<?php } else{ ?>
<option value="<?php echo $row1['chargecode']; ?>" ><?php echo $row1['chargecode']; ?></option>

<?php }}?>
</select>
</td>
</tr>
<tr style="height:10px"></tr>

<tr>

<td align="right">&nbsp;&nbsp;<strong>Amount</strong>&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;<input type="text" size="18" id="amount" name="amount" value="<?php echo $amount;?>" ></td>

<td width="10px"></td>
<td align="right"><strong>Valid Time</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="time" id = "time" size="18" value="<?php echo $time;?>" /></td></tr>

</table>
<br /><br />



<table border="0" align="center">
 <tr>
 <td width="10px"></td>
 <td><input type="radio" id="cash" name="cb" value="Cash"  <?php if($mode=="Cash"){?> checked="checked" <?php  } ?> onclick="loadframe(this.value);"/>&nbsp;&nbsp;&nbsp; <strong>Cash</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
 <td>&nbsp;&nbsp;&nbsp;<input type="radio" id="bank" name="cb" value="Bank" <?php if($mode=="Bank"){?> checked="checked" <?php  } ?>  onclick="loadframe(this.value);"/>&nbsp;&nbsp;&nbsp; <strong>Bank</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>



<td width="10px"></td>

<td><strong id="codename">Code No.</strong>&nbsp;&nbsp;&nbsp;</td>
<td>
<select id="cno" name="cno">


<option value="">--Select--</option>
 <?php
  
  
  if($mode == "Cash")
  {
 
       
 for($j=0;$j<count($cashcodes);$j++)
		   {
			$cashcodes1=explode('@',$cashcodes[$j]);
		
           ?>
<option value="<?php echo $cashcodes1[0];?>"  <?php if($cashcodes1[0]==$cashbank){ ?> selected="selected" <?php  } ?> title="<?php echo $cashcodes1[0]; ?>"><?php echo $cashcodes1[0]; ?></option>
<?php } 


  } 
    else
	{
	
	for($j=0;$j<count($bankcodes);$j++)
		   {
			$bankcodes1=explode('@',$bankcodes[$j]);
           ?>
<option value="<?php echo $bankcodes1[0];?>"  <?php if($bankcodes1[0]==$cashbank){ ?> selected="selected" <?php  } ?> title="<?php echo $bankcodes1[0]; ?>"><?php echo $bankcodes1[0]; ?></option>
<?php } 
	
	
 }
  
  ?>


</select>
</td>


<td width="10px"></td>
<td><strong>Coacode</strong>
<td><select id="code" name="code" >





        <option value="">-Select-</option>
<?php 
for($j=0;$j<count($items);$j++)
							{ 
							
							
							
					?>
					<option title="<?php echo $items[$j];?>" <?php if($items[$j]==$expensecoa){?> selected="selected" <?php  }?> value="<?php echo $items[$j];?>"><?php echo $items[$j]; ?></option>
					<?php   }   ?>
</select></td>
</tr>
</table>
<br />
<br />



<table border="0">
<td>
<tr>
<td colspan="2" align="right" style="vertical-align:middle;"><strong>Narration</strong>&nbsp;&nbsp;&nbsp;</td>
<td colspan="3" align="left"><textarea rows="3" cols="40" name="remarks" id="remarks" ><?php echo $narration;?></textarea></td>
</tr>
</table>
<br /><br />

   
<center>	


   <br />
   <input type="submit" value="update" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="cancel" onClick="document.location='dashboardsub.php?page=vehicle_renewal';">
</center>


						
</form>

<script type="text/javascript">



function checkform(form)
{


if(form.vt.value == "")
	{
		alert("Please Select Type");
 form.vt.focus();
return false;
}
else if(form.vnum.value == "")
{
	alert("Please Select VehicleNumber");
	form.vnum.focus();
	return false;
}
else if(form.ccode.value == "")
{
	alert("Please Select Charge Code");
	form.vnum.focus();
	return false;
}
else if(form.amount.value == "")
{
	alert("Please Enter Amount");
	form.amount.focus();
	return false;
}
else if(form.time.value == "")
{
	alert("Please Enter Valid Duration");
	form.time.focus();
	return false;
}



if(document.getElementById("cash").checked==false && document.getElementById("bank").checked==false)
{

alert("Please select cash/bank");
form.cash.focus();
return false;

}

if(document.getElementById("cno").value=="")
{

alert("Please select cash/bank codes");
form.cno.focus();
return false;

}



if(document.getElementById("code").value=="")
{

alert("Please select coa code");
form.code.focus();
return false;

}


document.getElementById("save").disabled=true;
}


function loadframe(a)
{

document.getElementById('cno').options.length=1;

var code = document.getElementById('cno');



if(a == "Cash")
{
document.getElementById('codename').innerHTML = "Cash Code";


          
            for(j=0;j<(cashcodes.length);j++)
		   {
		   cashcodes1=cashcodes[j].split("@");
		   	var theOption=new Option(cashcodes1[0],cashcodes1[0]);
			
		theOption.title=cashcodes1[0];
			code.options.add(theOption);
		
 } 


}
else if(a == "Bank")
{
document.getElementById('codename').innerHTML = "Bank A/C No.";



  for(j=0;j<(bankcodes.length);j++)
		   {
		  
		   bankcodes1=bankcodes[j].split("@");
		   	var theOption=new Option(bankcodes1[0],bankcodes1[0]);
			
		theOption.title=bankcodes1[0];
			code.options.add(theOption);
		
}
}



}




function getnum(a)
{
var type = a;


removeAllOptions(document.getElementById("vnum"));
	myselect1 = document.getElementById("vnum");
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "vnum";
myselect1.style.width = "120px";


<?php 
			$q = "select distinct(vtype) from vehicle_type";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(type == '$qr[vtype]') {";
			$q1 = "select * from vehicle_master where vtype = '$qr[vtype]'";
			$q1rs = mysql_query($q1) or die(mysql_error());
			while($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
        theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("<?php echo $q1r['vnumber'];?>");
              theOption1.appendChild(theText1);
	          theOption1.value = "<?php echo $q1r['vnumber'];?>";
	          
              myselect1.appendChild(theOption1);
			  
			  <?php
			}
			echo "}";
			}
	?>

getcharge(type);
}
function getcharge(type)
{

removeAllOptions(document.getElementById("ccode"));
	myselect1 = document.getElementById("ccode");
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "ccode";
myselect1.style.width = "120px";


<?php 
			$q = "select distinct(vtype) from vehicle_type";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(type == '$qr[vtype]') {";
			$q1 = "select * from vehicle_chargemaster where vehicletype like '%$qr[vtype]%'";
			$q1rs = mysql_query($q1) or die(mysql_error());
			while($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
        theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("<?php echo $q1r['chargecode'];?>");
              theOption1.appendChild(theText1);
	          theOption1.value = "<?php echo $q1r['chargecode'];?>";
	          
              myselect1.appendChild(theOption1);
			  
			  <?php
			}
			echo "}";
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

</script>
<script type="text/javascript">
function script1() {
window.open('vehiclehelp/helprenewal.php','BIMS',
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
