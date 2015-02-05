<?php 
include "config.php"; 
$stdcost ="";
$query = "select * from ims_itemcodes where id = '$_GET[id]'";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_array($result))
{
  $itemcode = $row['code'];
  $category = $row['cat'];
  $description = $row['description'];
  
  $vmethod = $row['cm'];
  $sunits = $row['sunits'];
  $cunits = $row['cunits'];
 
  $usage = $row['iusage'];
  $source = $row['source'];
  $type = $row['type'];
 
  $iac  = $row['iac'];
 
  $stdcost = $row['stdcost'];
  $wpac = $row['wpac'];
  $qry=mysql_query("SELECT schedule FROM ac_coa WHERE code='".$wpac."' LIMIT 1");
  $re=mysql_fetch_array($qry);
  if($re['schedule']=="Expense3")  
  		$mess="Consumption A/C:";
  else
  		$mess="WIP A/C:";
  $sac = $row['sac'];
  $srac = $row['srac'];
  $cogsac = $row['cogsac'];
}


?>

<center>
<br />
<h1>Item Masters</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/><br/><br />
<form id="form1" name="form1" method="post" action="ims_updateitemcodes.php"  onsubmit="return checkform('form1');">
<input type="hidden" id="oldid" name="oldid" value="<?php echo $_GET['id'];?>"/>

<table align="center" >
<tr> 
<td width="200" align="right"><strong>Item Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"><?php echo $itemcode; ?></td>
<td width="200" align="right"><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="240" align="left"><?php echo $description; ?></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="200" align="right"><strong>Category</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"><?php echo $category; ?></td> 
<input type="hidden" name ="cat" id="cat" value="<?php echo $category; ?>" />
<td width="200" align="right"><strong>Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"><?php echo $type; ?></td>


</tr>
<tr height="10px"><td></td></tr>



<tr>
<td width="200" align="right"><strong>Valuation Method</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"><select style="Width:120px" name="cm" id="cm" onchange="valuation(this.id,this.value)" >
<option value="">-Select-</option>

<option value="Weighted Average" <?php  if($vmethod == "Weighted Average"){?> selected="selected" <?php }?>>Weighted Average</option>
<option value="Standard Costing" <?php  if($vmethod == "Standard Costing"){?> selected="selected" <?php }?>>Standard Costing</option>
</select></td> 

<td width="200" align="right"><strong>Storage Units Of Measure</strong>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"><?php echo $sunits;?></td>


</tr>

<tr height="10px"><td></td></tr>

<tr>

</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="200" align="right"><strong>Consumption Units Of Measure</strong>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"><?php echo $cunits;?></td>
<td width="200" align="right"><strong>Usage</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"><?php echo $usage; ?></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>

<td width="200" align="right"><strong>Source</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left"><?php echo $source; ?></td>



<td width="200" align="right"><strong>Item A/C</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<?php $query = "select description from ac_coa where code = '$iac' and client = '$client' order by code ASC";$result = mysql_query($query,$conn) or die(mysql_error());while($rows = mysql_fetch_assoc($result)){?>
<td width="240" align="left"><?php echo $rows['description']; ?></td><?php } ?>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td>&nbsp;</td>
	<td>&nbsp;</td>
<?php  if($vmethod == "Standard Costing"){?>

<td width="200" align="right" id="stdcostrow"  ><strong>Standard Cost/Unit</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left" id="stdcostrow1" >
<input type="text" id="stdcost" name="stdcost" value="<?php echo $stdcost; ?>"  onkeypress="return validatestdcost(this.id,this.value,event.keyCode)" /></td>

<?php } else{ ?>

	    <td width="200" align="right" id="stdcostrow" style="visibility:hidden"    ><strong>Standard Cost/Unit</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

      <td width="200" align="left" id="stdcostrow1" ><input type="text" id="stdcost" name="stdcost" value="<?php echo $stdcost;?>"  onkeypress="return validatestdcost(this.id,this.value,event.keyCode)" style="visibility:hidden" /></td>
<?php  } ?>



</tr>

 <tr height="10px" >

      <td></td>
    </tr>




<tr>
<td></td>
<td></td>


<td width="200" align="right" id="expcatd" <?php if($wpac == ""){?> style="visibility:hidden" <?php }?>><strong>Consumption A/C</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left" <?php if($wpac == ""){?> style="visibility:hidden" <?php }?>><?php echo $wpac;?></td>

    
    </tr>



<tr height="10px"><td></td></tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td width="200" align="right" id="cogsactd" <?php if($cogsac == ""){?> style="visibility:hidden" <?php }?>><strong>COGS A/C</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left" <?php if($cogsac == ""){?> style="visibility:hidden" <?php }?>><?php echo  $cogsac;?></td>
</tr>
<tr height="10px"><td></td></tr>

<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td width="200" align="right" id="sactd" <?php if($sac == ""){?> style="visibility:hidden" <?php }?>><strong>Sales A/C</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left" <?php if($sac == ""){?> style="visibility:hidden" <?php }?>><?php echo $sac;?></td>
</tr>
<tr height="10px"><td></td></tr>

<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td width="200" align="right" id="sractd" <?php if($srac == ""){?> style="visibility:hidden" <?php }?>><strong>Sales Return</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup></sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="200" align="left" <?php if($srac == ""){?> style="visibility:hidden" <?php }?>><?php echo $srac;?></td>
</tr>
<tr height="10px"><td></td></tr>



<tr>
<td colspan="5" align="center">
<br />
<center>
<input type="submit" value="Update" />&nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=ims_itemcodes'">
</center>
</td>
</tr>
</table>
</center>
<br /><br /><br />
</form>
<script type="text/javascript">




function validatestdcost(a,b,c)

{


if((c<48 || c>57) && (c!=46))

{
event.keyCode=false;
return false;

}

 var expr=/^[0-9\.]*$/;

 if(! b.match(expr))

 {
event.keyCode=false;
  alert("Enter numbers only");

  document.getElementById(a).value = "";

  document.getElementById(a).focus();
  return false;

 }

}






function validatecap(a,b)

{

 var expr=/^[0-9 ]*$/;

 if(! b.match(expr))

 {event.keyCode=false;

  alert("Special Characters are not allowed");

  document.getElementById(a).value = "";

  document.getElementById(a).focus();
  return false;

 }

}




function  valuation(a,b)
{
	if((document.getElementById('cm').value == "Standard Costing"))
	{
	document.getElementById('stdcostrow').style.visibility = "visible";
	document.getElementById('stdcostrow1').style.visibility = "visible";
		document.getElementById('stdcost').style.visibility = "visible";
	document.getElementById('stdcost').value = "<?php echo $stdcost; ?>";
	}
	else
	{
	document.getElementById('stdcost').value = "";
	document.getElementById('stdcostrow').style.visibility = "hidden";
	document.getElementById('stdcost').style.visibility = "hidden";
	document.getElementById('stdcostrow1').style.visibility = "hidden";
	}
}

function checkform(fom)
{
var cmval = document.getElementById('cm').value;
//var sunitsval = document.getElementById('sunits').value;
//var cunitsval = document.getElementById('cunits').value;
var stdcostval = document.getElementById('stdcost').value;
if(cmval == '')
{
alert("Please select value for Valuation Method");
document.getElementById('cm').focus();
return false;
}
else if(stdcostval == '')
{
if(document.getElementById('stdcostrow1').style.visibility == "visible")
{
alert("Please enter Standard Cost/Unit");
document.getElementById('stdcost').focus();
return false;
}
}
else
{
return true;
}
}

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		//selectbox.options.remove(i);
		selectbox.remove(i);
	}
}

function script1() {
window.open('IMSHelp/help_m_additemmaster.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=YES,resizable=yes');
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