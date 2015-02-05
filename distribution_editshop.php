<?php

$id=$_GET['id'];

$q1=mysql_query("set group_concat_max_len=10000000000");

$q1="select group_concat(name separator '$') as names from distribution_shop where id!='$id'";

$q1=mysql_query($q1) or die(mysql_error());

$r1=mysql_fetch_assoc($q1);

$allnames=explode('$',$r1['names']);

$allnamesj=json_encode($allnames);


$details="select * from distribution_shop where id='$id'";

$details=mysql_query($details) or die(mysql_error());

$details=mysql_fetch_assoc($details);



$q1="SELECT areacode,group_concat(name separator '*') as names FROM `distribution_distributor` group by areacode";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))
{
$allareacodes[]=array("areacode"=>$r1['areacode'],"names"=>$r1['names']);
}

$allareacodesj=json_encode($allareacodes);




?>
<script type="text/javascript">

var allnamesj=<?php echo $allnamesj;?>;

var allareacodesj=<?php echo $allareacodesj;?>;


</script>

<center>
<br/>
<h1>Shop Details</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
<form method="post" action="distribution_saveshop.php" onSubmit="return checkform(this);">
<input type="hidden" name="edit"  value="1" />
<input type="hidden" name="oldid" value="<?php echo $id;?>" />
<table>

<tr>
<td align="right" style="vertical-align:middle;"><strong>Shop Name</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left" style="vertical-align:middle;"><input type="text" id="name" name="name" size="30" onkeyup="validatecode(this.id,this.value);" onblur="checkforname(this.id,this.value)"  value="<?php echo $details['name'];?>"/></td>

<td id="usercheck"></td>
<td style="display:none" id="loading" ><img  title="Verifying the Customer Name" src="images\mask-loader.gif" ></td>

<td align="right" style="vertical-align:middle;"><strong>Address</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><textarea rows="4" cols="30" name="address"><?php echo $details['address'];?></textarea></td>
</tr>

<tr style="height:10px"></tr>
<tr>
<td align="right"><strong>Place</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="place" size="30" value="<?php echo $details['place'];?>"/> </td>
<td width="10px"></td>
<td align="right"><strong>Phone</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="phone" size="30" value="<?php echo $details['phone'];?>" /></td>
</tr>

<tr style="height:10px"></tr>

<tr>
<td align="right"><strong>Mobile</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="mobile" size="30" value="<?php echo $details['mobile'];?>" /></td>
<td width="10px"></td>
<td align="right"><strong>PAN/TIN</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" id="pan" name="pan" size="30" onkeyup="validatecode(this.id,this.value);" value="<?php echo $details['PAN/TIN'];?>"
/></td></tr>

<tr style="height:10px"></tr>

<tr>
<td align="right"><strong>Area Code<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select name="areacode" id="areacode" style="width:200px" onchange="getname()">
  <option value="">-Select-</option>
<?php

$q1="select areacode from distribution_area ";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))
{
?>
<option value="<?php echo $r1['areacode'];?>" <?php if($details['areacode']==$r1['areacode']){?> selected="selected" <?php }
?>><?php echo $r1['areacode'];?></option>
<?php }?>


</select></td>
<td width="10px"></td>
<td align="right"><strong>Area Name<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select name="areaname" id="areaname" style="width:200px" onchange="getcode()">
  <option value="">-Select-</option>
<?php

$q1="select areacode,areaname from distribution_area order by areacode";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))
{
?>
<option value="<?php echo $r1['areaname'];?>" title="<?php echo $r1['areaname'];?>" <?php if($details['areaname']==$r1['areaname']){?> selected="selected" <?php }
?>><?php echo $r1['areaname'];?></option>
<?php }?>


</select>
</td></tr>


<tr style="height:10px"></tr>

<tr>
<td align="right"><strong>Distributor Name<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select name="distributor" id="distributor" style="width:200px">
  <option value="">-Select-</option>
<?php
for($i=0;$i<count($allareacodes);$i++)
 { 
   if($allareacodes[$i]['areacode']==$details['areacode'])
   { 
   
     $codes=explode("*",$allareacodes[$i]['names']);
	 
	 for($j=0;$j<count($codes);$j++)
	  {
	    
	?>
    
<option value="<?php echo $codes[$j];?>" title="<?php echo $codes[$j];?>" <?php if($codes[$j]==$details['distributor']){?> selected="selected" <?php }?>><?php echo $codes[$j];?></option>	
	
	<?php 
		
      }
   }
 }
?>



</select></td>
<td width="10px"></td>
<td align="right"><strong>Shop Type<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left">
<input type="radio" name="shoptype" id="shoptype1" value="Retailer" <?php if($details['shoptype']=="Retailer"){?> checked="checked" <?php }?> /><strong>Retailer</strong>&nbsp;&nbsp;&nbsp;
<input type="radio" name="shoptype" id="shoptype2" value="Wholesale" <?php if($details['shoptype']=="Wholesale"){?> checked="checked" <?php }?>/><strong>Wholesale</strong>


</td></tr>


<tr style="height:10px"></tr>

<tr>
<td align="right"><strong></strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"></td>
<td width="10px"></td>
<td align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td align="left"></td></tr>




<tr style="height:10px"></tr>
<tr>
<td align="right" colspan="2" style="vertical-align:middle;"><strong>Note</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left" colspan="3"><textarea rows="4" cols="35" name="note" ><?php echo $details['note'];?></textarea></td>
</tr>



</table>
<table>
<br />
<tr>
<td>
<input type="submit" value="Save" id="save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=distribution_shop';" id="cancel">

</form>
</center>
</td></tr>
</table>

</center>
<script language="JavaScript" type="text/javascript">
function loadfun(a)
{
 if(a=='vendor and party')
  document.getElementById('trvgroup').style.display="block";
 else 
  document.getElementById('trvgroup').style.display="none";
}

function validatecode(a,b)
{
 var expr=/^[A-Za-z0-9 ]*$/;
 if(! b.match(expr))
 {
  alert("Special Characters are not allowed");
  document.getElementById(a).value = "";
  document.getElementById(a).focus();
 }
}

function validatenumber(a,b)
{
 var expr=/^[0-9]*$/;
 if(! b.match(expr))
 {
  alert("It should be a Number");
  document.getElementById(a).value = "";
  document.getElementById(a).focus();
 }
}



function checkform ( form )
{
var numericExpression = /^[0-9]+$/;
    if (form.name.value == "") {
    alert( "Please enter Name." );
    form.name.focus();
    return false ;
  }

   else if (form.address.value == "") {
    alert( "Please enter Address." );
    form.address.focus();
    return false ;
  }
  
    else if (form.phone.value == "") {
    alert( "Please enter Phone no." );
    form.phone.focus();
    return false ;
  }
    else if (!(form.phone.value.match(numericExpression))) {
    alert( "Phone Number Should be Numeric only." );
    form.phone.focus();
    return false ;
  }
    else if (form.phone.value.length < 10 ) {
    alert( "Phone Number Should be atleast 10 digits." );
    form.phone.focus();
    return false ;
  }
     else if (form.mobile.value == "") {
    alert( "Please enter Mobile number." );
    form.mobile.focus();
    return false ;
  }
    else if (!(form.mobile.value.match(numericExpression))) {
    alert( "Mobile Number Should be Numeric only." );
    form.mobile.focus();
    return false ;
  }
    else if (form.mobile.value.length < 5 ) {
    alert( "Mobile Number Should be atleast 5 digits." );
    form.mobile.focus();
    return false ;
  }
 
  else if ((form.areacode.value == "") || (form.areacode.value == "-Select-")) {
    alert( "Please Enter Area Code" );
    form.areacode.focus();
    return false ;
  }
   
     else if ((form.distributor.value == "") || (form.distributor.value == "-Select-")) {
    alert( "Please Select Distributor" );
    form.distributor.focus();
    return false ;
  }
  
  
   else if ((!document.getElementById("shoptype1").checked) && (!document.getElementById("shoptype2").checked))
 {
    alert( "Please Select Shoptype" );
    
    return false ;
	
  }
  else
  {
  
  }
  
  document.getElementById("save").disabled="true";
document.getElementById("cancel").disabled="true";

   
    return true ;
}


function checkforname(id,name)
{

for(i=0;i<allnamesj.length;i++)
{
if(name==allnamesj[i])
{
alert("This Name Already Exists");
document.getElementById(id).value="";
document.getElementById(id).focus();
return false;
}
}

}

function checkstring(id,value)
{

var reg=new RegExp("^[0-9a-zA-z\ ]*$");

if(!reg.test(value))
 {

 alert("Enter Correct String (No Special Characters)");
 
 document.getElementById(id).value="";

 document.getElementById(id).focus();
 
	return false;
 
 
 }



}

function getname()
{

  document.getElementById("areaname").options[document.getElementById("areacode").options.selectedIndex].selected="selected";


  document.getElementById("distributor").options.length=1;

  var areacode=document.getElementById("areacode").value;

  for(i=0;i<allareacodesj.length;i++)
   {

     if(areacode==allareacodesj[i].areacode)
       {

        var codes=allareacodesj[i].names.split("*");
		
		for (j=0;j<codes.length;j++)
		  {
		  
		  var op=new Option(codes[j],codes[j]);
		   
		   op.title=codes[j];
		  
		  document.getElementById("distributor").options.add(op);
		  
		  }



       }
  }


}


function getcode()
{

document.getElementById("areacode").options[document.getElementById("areaname").options.selectedIndex].selected="selected";


 document.getElementById("distributor").options.length=1;

  var areacode=document.getElementById("areacode").value;

  for(i=0;i<allareacodesj.length;i++)
   {

     if(areacode==allareacodesj[i].areacode)
       {

        var codes=allareacodesj[i].names.split("*");
		
		for (j=0;j<codes.length;j++)
		  {
		  
		  var op=new Option(codes[j],codes[j]);
		   
		   op.title=codes[j];
		  
		  document.getElementById("distributor").options.add(op);
		  
		  }



       }
  }

}



</script>
<script type="text/javascript">
function script1() {
window.open('O2CHelp/help_m_addcustomer.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
