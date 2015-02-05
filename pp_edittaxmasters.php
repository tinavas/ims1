<?php include "config.php"; ?>
<?php include "jquery.php"; ?>
<?php 
include "config.php";

$id = $_GET['id'];
$gquery = "select * from ims_taxcodes where id = '$id' and client = '$client'";
$gresult = mysql_query($gquery,$conn) or die(mysql_error());
$gres = mysql_fetch_assoc($gresult);
$type = $gres['type'];
$rule = $gres['rule'];
$cftype = $gres['ctype'];
$coa = $gres['coa'];

$mode=$gres['mode'];
$code=$gres['code'];
$taxflag=$gres['taxflag'];

?>


<br />
<center>
<h1>Tax Masters</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/>
<br/>
<form id="form1" name="form1" method="post" action="pp_updatetaxmasters.php"  onsubmit="return checkform(this);">
<table align="center">
<input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
<tr> 
<td align="right"><strong>Tax Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

<td align="left"><input type="text" name="code" size="17" id="code" value="<?php echo $gres['code']; ?>" onkeyup="taxcodevalue(this.value);" onchange="checkcode(this.id);"/></td>

<td align="right"><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

<td align="left"><input type="text" name="description" size="20" value="<?php echo $gres['description']; ?>" id="description" /></td>
</tr>





<tr height="10px"><td></td></tr>

<tr>
<td align="right" ><strong>Rule</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

<td align="right" >
<select style="Width:120px" name="rule" id="rule"  >
                      <option value="">-Select-</option>
					  <option value="Include"<?php if($rule == "Include"){ ?> selected="selected"<?php } ?>>Include</option>
					  <option value="Exclude"<?php if($rule == "Exclude") { ?> selected="selected"<?php }?>>Exclude</option>
					 		  
			</select>
</td>
<td  align="right"  title="Chart of Account Code" ><strong  >CoA</strong> <font style="color:red;font-weight:bold;padding-top:10px"> <sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"  ><select style="Width:120px" name="coa" id="coa"   >
<option value="">-Select-</option> 
<?php 
$query021 = "SELECT distinct(code) FROM ac_coa WHERE type='Asset' AND (controltype = '' OR controltype IS NULL) ORDER BY code ASC";$result021 = mysql_query($query021,$conn) or die(mysql_error());
while($rows021 = mysql_fetch_assoc($result021))
{
?>
<option value="<?php echo $rows021['code']; ?>" <?php if($rows021['code'] == $coa) { ?> selected="selected" <?php } ?>><?php echo $rows021['code']; ?> </option>
<?php } ?> 
</select></td>

</tr>

<tr height="10px"><td></td></tr>
<tr>
<td colspan="2" align="center">

<input type="radio" id="formulaopt" name="opt" value="Percent"  onclick="formulaflat(this.value);" <?php if($mode=="Percent"){ ?> checked="checked"<?php  }?>/> &nbsp; &nbsp; <strong>Percent</strong>&nbsp; &nbsp;&nbsp; &nbsp;
<input type="radio" id="flatopt" name="opt" value="Flat" onclick="formulaflat(this.value);"  <?php if($mode!="Percent"){ ?> checked="checked"<?php  }?> /> &nbsp; &nbsp; <strong>Flat</strong>
</td>
<td align="right">
<strong>Tax Code Value<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</strong>
</td>
<td align="left" >
<input type="text" id="codevalue" name="codevalue"  value="<?php echo $gres['codevalue']; ?>" size="7" onkeyup="return checkval(this.id,this.value)"/>
</td>


</tr>
<tr height="10px"><td></td></tr>



<tr>
<td colspan="4" align="center">
<br />
<center>
<input type="submit" value="Update" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=pp_taxmasters';">
</center>
</td>
</tr>
</table>
</center>
<br /><br /><br />
</form>

<script language="JavaScript" type="text/javascript">


function checkval(a,b)
{
 var form=document.getElementById("form1");
  if (form.formulaopt.checked ==true && form.flatopt.checked == false) 
  {
  	if(form.codevalue.value >100) 
	{
  	document.getElementById(a).value="";
	
    alert( "Please percent should be less than 100 " );
    form.codevalue.focus();
    return false ;
	
	}
  }


}




function checkcode(a)
{


var code=document.getElementById(a).value;
var code= code.toUpperCase();

<?php
$q="select distinct(code) from ims_taxcodes";
$res=mysql_query($q,$conn);
while($row=mysql_fetch_array($res))
{
?>

if(code=="<?php echo $row['code'];?>" && code!="<?php echo $code;?>")

{

	alert("Code already exists");
	document.getElementById(a).value="";
	return false;

}
<?php } ?>

}




function checkform ( form )
{
var noalpha = /^[a-zA-Z.0-9]*$/;
var noalpha1 = /^[a-zA-Z.0-9.\s]*$/;


  
	if (form.code.value == "") 
   {
    alert( "Please enter Code." );
    form.code.focus();
    return false ;
   }
  if (form.code.value.length < 5 ) 
  {
    alert( "Code Number Should be atleast 5 characters." );
    form.code.focus();
    return false ;
  }
  if ( (!(form.code.value.match(noalpha)))) 
  {
    alert( "Code Number cannot have special charaters." );
    form.code.focus();
    return false ;
  }
  if (form.description.value == "") 
  {
    alert( "Please enter Description." );
    form.description.focus();
    return false ;
  }
  if (form.description.value.length > 25 ) 
  {
    alert( "Description should not have more than 25 characters" );
    form.code.focus();
    return false ;
  }
  if ((!(form.description.value.match(noalpha1)))) 
  {
    alert( "Description cannot have special charaters." );
    form.description.focus();
    return false ;
  }
 if (form.rule.value == "" ) 
  {
    alert( "Please select Rule." );
    form.rule.focus();
    return false ;
  }
  if(form.rule.value != "")
  {
  if ( form.coa.value == "") 
  {
    alert( "Please select CoA." );
    form.coa.focus();
    return false ;
  }
  }
  
  
  
    
  if (form.formulaopt.checked == false && form.flatopt.checked == false ) 
  {
    alert( "Please select percent or flat" );
    form.formulaopt.focus();
    return false ;
  }
  
  
    if (form.codevalue.value == "0" || form.codevalue.value == "" ) 
  {
    alert( "Please enter Code Value." );
    form.codevalue.focus();
    return false ;
  }
  
 


  return true;
}




function taxcodevalue(tcv)
{
 var reg = /^[a-zA-Z]+[a-zA-Z.0-9]*$/;
  if ((!(form1.code.value.match(reg)))) 
  {
    alert( "The first character of code should be alphabet & No Special Characters are allowed" );
	form1.code.value = "";
  }
 
	document.getElementById('spanid').innerHTML = tcv;
}

function formulaflat(a)
{
	if(a == "Percent")
	{
		document.getElementById('codevalue').value=0;
		
	}
	else
	{
		document.getElementById('codevalue').value=0;
	}
}



</script>

<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_m_addtaxmaster.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
