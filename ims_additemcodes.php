<script type="text/javascript">
<?php include "config.php"; 
$query1="select fromunits,tounits from ims_convunits";
$result1=mysql_query($query1,$conn);
while($rows1=mysql_fetch_assoc($result1))
{
	$sunits1[]=$rows1["fromunits"];
	$cunits1[]=$rows1["tounits"]	;
}
$sunits=json_encode($sunits1);
$cunits=json_encode($cunits1);
$query = "SELECT cat,iac,cogsac,sac,srac FROM `ims_itemcodes` group by cat order by cat";

$result = mysql_query($query,$conn) or die(mysql_error());


while($rows = mysql_fetch_assoc($result))

{

 $catdup = str_replace(" ","_",$rows[cat]);

 echo "var $catdup = [\"$rows[iac]\",\"$rows[cogsac]\",\"$rows[sac]\",\"$rows[srac]\"];\n";

} 


?>
var sunits=<?php echo $sunits;?>;
var cunits=<?php echo $cunits;?>;
</script>

<?php session_start();?>

<center>

<br />

<h1>Item Masters</h1>

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br/><br/><br />

<form id="form1" name="form1" method="post" action="ims_saveitemcodes.php"  onsubmit="return checkform(this);">

  <table align="center" >

    <tr>

      <td width="200" align="right"><strong>Item Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

      <td width="200" align="left"><input type="text" name="code" size="7" id="code" onkeyup="validatecode(this.id,this.value);" onchange="checknames();" /></td>

      <td width="200" align="right"><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

      <td width="240" align="left"><input type="text"  name="description" size="25" id="description" onchange="checknames();" onkeyup="validatecode(this.id,this.value);" /></td>
    </tr>

    <tr height="10px">

      <td></td>
    </tr>

    <tr>

      <td width="200" align="right"><strong>Category</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

      <td width="200" align="left"><select style="Width:120px" name="cat" id="cat" onchange="changedispmed(this.value);" >

          <option value="">-Select-</option>

          <?php $q = "select * from ims_itemtypes WHERE client = '$client' order by type ASC";	$qrs = mysql_query($q,$conn);

	while($qr = mysql_fetch_assoc($qrs)) { ?>

          <option value="<?php echo $qr['type']; ?>"><?php echo $qr['type']; ?></option>

          <?php } ?>

        </select>

        <a href="dashboardsub.php?page=ims_addcategory"><img src="images/icons/fugue/plus.png" style="vertical-align:middle;" title="Add New Category" border="0px"  /></a></td>
		
		
		  <td width="200" align="right"><strong>Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

      <td width="200" align="left"><select style="Width:180px" name="type" id="type" >

          <option value="">-Select-</option>

          <option value="Consumed">Consumed</option>

          <option value="Finished Goods">Finished Goods</option>

          <option value="Packing Material">Packing Material</option>

          <option value="Raw Material">Raw Material</option>

          <option value="Others">Others</option>

          <option value="Wastage">Wastage</option>

      </select></td>
		
		
    </tr>

    <tr height="10px">

      <td></td>
    </tr>

	  <tr height="10px"></tr>

    <tr>

      <td width="200" align="right"><strong>Valuation Method</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

      <td width="200" align="left"><select style="Width:120px" name="cm" id="cm" onchange="valuation(this.id,this.value)" >

          <option value="">-Select-</option>

        

          <option value="Weighted Average">Weighted Average</option>

          <option value="Standard Costing">Standard Costing</option>

      </select></td>
	  
	  
	  
	        <td width="200" align="right"><strong>Storage Units Of Measure</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

      <td width="200" align="left"><select style="Width:180px" name="sunits" id="sunits" >

          <option value="">-Select-</option>

          <?php include "config.php"; $q2="select distinct(sunits) from ims_itemunits WHERE client = '$client' order by sunits ASC"; $r2 = mysql_query($q2,$conn);

     while($nt2=mysql_fetch_assoc($r2))

     { ?>

          <option value="<?php echo $nt2['sunits']; ?>"><?php echo $nt2['sunits']; ?></option>

          <?php } ?>

        </select>

        <a href="dashboard.php?page=additemunits" onclick=""><img src="images/icons/fugue/plus.png" style="vertical-align:middle;" title="Add New Unit" border="0px"  /></a></td>
	  


   

    
    </tr>

    <tr height="10px">

      <td></td>
    </tr>

    <tr>

<td width="200" align="right"><strong>Consumption Units Of Measure</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

      <td width="200" align="left"><select style="Width:180px" name="cunits" id="cunits" >

          <option value="">-Select-</option>

          <?php include "config.php"; $q2="select distinct(sunits) from ims_itemunits WHERE client = '$client' order by sunits ASC"; $r2 = mysql_query($q2,$conn);

     while($nt2=mysql_fetch_assoc($r2))

     { ?>

          <option value="<?php echo $nt2['sunits']; ?>"><?php echo $nt2['sunits']; ?></option>

          <?php } ?>

        </select>
        </td>
<td width="200" align="right"><strong>Usage</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

      <td width="200" align="left"><select style="Width:180px" name="usage" id="usage" onchange="coas(this.value);" >

          <option value="">-Select-</option>
			
          <option value="General Consumption">General Consumption</option>
            
         

         
        <option value="Sale">Sale</option>
<option value="Rejected">Rejected</option>
<option value="Produced or Sale">Produced or Sale</option>
<option value="Rejected or Sale">Rejected or Sale</option>
<option value="Produced or Rejected">Produced or Rejected</option>
<option value="Produced or Sale or Rejected">Produced or Sale or Rejected</option>

         
         
      </select></td>
</tr>

    <tr height="10px">

      <td></td>
    </tr>

    <tr>

 <td width="200" align="right"><strong>Source</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

      <td width="200" align="left"><select style="Width:180px" name="source" id="source" <?php if($_SESSION['db']=="singhsatrang"){
	?> onchange="coas1(this.value);" <?php } ?> >

          <option value="">-Select-</option>

          
          <option value="Produced">Produced</option>
<option value="Purchased">Purchased</option>
<option value="Produced or Purchased">Produced or Purchased</option>

        
      </select></td>
    

      
	   <td width="200" align="right"><strong>Item A/C</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

      <td width="240" align="left"><select style="Width:180px" name="iac" id="iac" >

          <option value="">-Select-</option>

          <?php 
		$q = "select code,description from ac_coa where type = 'Asset' and client = '$client'  and schedule = 'Inventories' order by code ASC";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
      ?>
       <option title="<?php echo $qr['code']; ?>" value="<?php echo $qr['code']; ?>"><?php echo $qr['description']; ?></option>

          <?php } ?>

      </select></td>
	  
	  
	
	  	   <tr height="10px">

      <td></td>
    </tr>



    
    <tr>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
	  
	    <td width="200" align="right" id="stdcostrow" style="visibility:hidden" ><strong>Standard Cost/Unit</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

      <td width="200" align="left" id="stdcostrow1" ><input type="text" id="stdcost" name="stdcost" style="visibility:hidden"  onkeypress="return validatestdcost(this.id,this.value,event.keyCode)" /></td>

     
    </tr>

    <tr height="10px">

      <td></td>
    </tr>

    <tr>

    

      </tr>

    <tr height="10px">

      <td></td>
    </tr>

  

    <tr height="10px">

      <td></td>
    </tr>



    
    <tr>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
      <td width="200" align="right" id="expcatd" style="visibility:hidden"><strong>Consumption A/C:</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

      <td width="200" align="left"><select style="Width:180px;visibility:hidden" name="expca" id="expca">

          <option value="">-Select-</option>
          <?php 
		$q = "select code,description from ac_coa where type = 'Expense'  and client = '$client'  order by code ASC";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
        ?>
          <option title="<?php echo $qr['code']; ?>" value="<?php echo $qr['code']; ?>"><?php echo $qr['description']; ?></option>
          <?php } ?>
      </select></td>
    </tr>

    <tr height="10px">

      <td></td>
    </tr>

    <tr>

	<td>&nbsp;</td>
	<td>&nbsp;</td>

      <td width="200" align="right" id="cogsactd" style="visibility:hidden"><strong>COGS A/C</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

      <td width="200" align="left"><select style="Width:180px;visibility:hidden" name="cogsac" id="cogsac" >
          <option value="">-Select-</option>
          <?php 
		$q = "select code,description from ac_coa where type = 'Expense'  and client = '$client'  order by code ASC";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
         ?>
          <option title="<?php echo $qr['code']; ?>" value="<?php echo $qr['code']; ?>"><?php echo $qr['description']; ?></option>
          <?php } ?>
      </select></td>
    </tr>

    <tr height="10px">

      <td></td>
    </tr>

    <tr>

  	<td>&nbsp;</td>
	<td>&nbsp;</td>

      <td width="200" align="right" id="sactd" style="visibility:hidden"><strong>Sales A/C</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

      <td width="200" align="left"><select style="Width:180px;visibility:hidden" name="sac" id="sac" >
         <option value="">-Select-</option>
         <?php 
		$q = "select code,description from ac_coa where type = 'Revenue' and schedule = 'Revenue From Operations' and client = '$client'  order by code ASC";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
         ?>
          <option title="<?php echo $qr['code']; ?>" value="<?php echo $qr['code']; ?>"><?php echo $qr['description']; ?></option>
          <?php } ?>
      </select></td>
    </tr>

    <tr height="10px">

      <td></td>
    </tr>

    <tr>

    
		<td>&nbsp;</td>
	<td>&nbsp;</td>
      <td width="200" align="right" id="sractd" style="visibility:hidden"><strong>Sales Return</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
      <td width="200" align="left"><select style="Width:180px;visibility:hidden" name="srac" id="srac" >
          <option value="">-Select-</option>
          <?php 
		$q = "select code,description from ac_coa where type = 'Expense' and client = '$client'  order by code ASC";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
        ?>
          <option title="<?php echo $qr['code']; ?>" value="<?php echo $qr['code']; ?>"><?php echo $qr['description']; ?></option>
          <?php } ?>
      </select></td>
    </tr>

    <tr height="10px">

      <td></td>
    </tr>

   
    <tr height="10px">

      <td height="3"></td>
    </tr>


    <tr>

      <td colspan="5" align="center"><br />

          <center>

            <input name="submit" type="submit" value="Save" />

            &nbsp;&nbsp;&nbsp;

            <input name="button" type="button" onclick="document.location='dashboardsub.php?page=ims_itemcodes';" value="Cancel" />
        </center></td>
    </tr>
  </table>

  </center>

  <br />

  <br /><br />

</form>



<script language="JavaScript" type="text/javascript">




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





function valuation(a,b)
{

if(b=="Standard Costing")
{

document.getElementById("stdcost").style.visibility="visible";
document.getElementById("stdcostrow").style.visibility="visible";

}

else
{

document.getElementById("stdcostrow").style.visibility="hidden";
document.getElementById("stdcost").style.visibility="hidden";

document.getElementById("stdcost").value="";

}


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



function removeAllOptions(selectbox)

{

	var i;

	for(i=selectbox.options.length-1;i>=0;i--)

	{

		//selectbox.options.remove(i);

		selectbox.remove(i);

	}

}





function fooforunits()

{

if (x=prompt("Unit","Please Enter Unit"))

 location.href="additemunits.php?input="+escape(x)

}



function foofortype()

{

if (x=prompt("Type","Please Enter Type"))

 location.href="additemtypes.php?input="+escape(x)

}



function removeAllOptions(selectbox)

{

	var i;

	for(i=selectbox.options.length-1;i>=0;i--)

	{

		selectbox.remove(i);

	}

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

else if ( (!(form.code.value.match(noalpha)))) 

 {

    alert( "Code Number cannot have special charaters." );

    form.code.focus();

    return false ;

 }

else if (form.code.value.length < 5 ) {

    alert( "Code Number Should be atleast 5 characters." );

    form.code.focus();

    return false ;

  }



if (form.description.value == "") 

   {

    alert( "Please enter Description." );

    form.description.focus();

    return false ;

   }

else if ((!(form.description.value.match(noalpha1)))) 

  {

    alert( "Description cannot have special charaters." );

    form.description.focus();

    return false ;

  }

else if (form.description.value.length > 45 ) {

    alert( "Description should not have more than 45 characters" );

    form.code.focus();

    return false ;

  }



if (form.cat.value == "") 

   {

    alert( "Please select a Category." );

    form.cat.focus();

    return false ;

   }



   

if (form.cm.value == "") 

   {

    alert( "Please select a Valuation Methos." );

    form.cm.focus();

    return false ;

   }



if (form.sunits.value == "") {

    alert( "Please select Storage Units." );

    form.sunits.focus();

    return false ;

  }

if (form.cunits.value == "") {

    alert( "Please select Consumption Units." );

    form.cunits.focus();

    return false ;

  }
if (form.sunits.value == form.cunits.value)
{}
else
{	var x=0;
	sunits1=document.getElementById("sunits").value;
	cunits1=document.getElementById("cunits").value;
	for(var i=0;i<sunits.length;i++)
	{
		if(sunits1==sunits[i])	
		{
			if(cunits1==cunits[i])	
			{
				var x=1;	
			}
		}
	} 
	if(x==0)
	{
		alert("Please Enter Units Convertion for "+sunits1+ " and "+cunits1);
		if(confirm('Do You Want to add convertion units'))
		{ document.location='dashboardsub.php?page=ims_addunits'; return false; }
		else
		{
		return false;
		}
	}
}
if (form.usage.value == "")

  {

  	alert( "Please select Usage.");

	form.usage.focus();

	return false;

  }





if (form.source.value == "")

  {

  	alert( "Please select Source.");

	form.source.focus();

	return false;

  }





if (form.type.value == "")

  {

  	alert( "Please select Type.");

	form.type.focus();

	return false;

  }



if (form.iac.value == "")

  {

  	alert( "Please select Item A/C.");

	form.iac.focus();

	return false;

  }


if(form.cm.value=="Standard Costing")

{

if (form.stdcost.value == "")

	{

  		alert( "Please enter standard cost.");

		form.stdcost.focus();

		return false;

  	}





}




if(form.usage.value == "Sale" || form.usage.value == "Produced or Sale")

{

	if (form.cogsac.value == "")

	{

  		alert( "Please select COGS A/C.");

		form.cogsac.focus();

		return false;

  	}

	if (form.sac.value == "")

	{

  		alert( "Please select Sales A/C.");

		form.sac.focus();

		return false;

  	}

	if (form.srac.value == "")

	{

  		alert( "Please select Sales Return");

		form.srac.focus();

		return false;

  	}

}




if(form.usage.value=="General Consumption")
{
	//alert(form.expca.value);
	if(form.expca.value=="")
	{
		alert("Please Select Consumption A/C");
		return false;
	}
}





/*

var j = 0;

for(i = 0;i< form.vendor.options.length;i++)

 	if(form.vendor.options[i].selected)

	j++;



if(j == 0)

{

	alert("Please select one or more in the List");

	form.vendor.focus();

	return false;

}

  else 

  {

 	for(var i = 0;i< form.vendors.options.length;i++)

 	if(form.vendors.options[i].selected)

 		if(form.vendors.options[i].value == "")

		{

		alert("Please select vendors correctly");

		return false;

		}

  }

 	document.getElementById('vendor1').value = "";

 	for(i = 0;i< form.vendors.options.length;i++)

 	if(form.vendors.options[i].selected)

 	document.getElementById('vendor1').value = document.getElementById('vendor1').value + form.vendors.options[i].value + ",";*/

	

    return true;

}






function stdcostenable()

{

	if((document.getElementById('cm').value == "Standard Costing"))

	{

	document.getElementById('stdcostrow').style.visibility = "visible";

	document.getElementById('stdcostrow1').style.visibility = "visible";

	}

	else

	{

	document.getElementById('stdcost').value = "";

	document.getElementById('stdcostrow').style.visibility = "hidden";

	document.getElementById('stdcostrow1').style.visibility = "hidden";

	}

}

function getValue(a,b)

{

 return a[b];

}



function changedispmed(vacmed)

{

var catdup = vacmed.replace(/ /g,"_");

var temp = getValue(eval(catdup),0);


document.getElementById("iac").value = getValue(eval(catdup),0);

document.getElementById("cogsac").value = getValue(eval(catdup),1);

document.getElementById("sac").value = getValue(eval(catdup),2);

document.getElementById("srac").value = getValue(eval(catdup),3);

}



function checknames()

{

var code = document.getElementById('code').value;

var desc = document.getElementById('description').value;

<?php

$q = "select code,description from ims_itemcodes where client = '$client'"; 

$r = mysql_query($q,$conn) or die(mysql_error());

while($qr = mysql_fetch_assoc($r))

{

echo "if((code == '$qr[code]') || (desc == '$qr[description]')) {";

?>

alert("The Entered Item Code and Description already exists");

document.getElementById('code').value = "";

document.getElementById('description').value = "";

<?php echo "}"; } ?>

}



function coas(value)

{
 


	document.getElementById('cogsactd').style.visibility = "hidden";

	document.getElementById('sactd').style.visibility = "hidden";

	document.getElementById('sractd').style.visibility = "hidden";



	document.getElementById('cogsac').style.visibility = "hidden";

	document.getElementById('sac').style.visibility = "hidden";

	document.getElementById('srac').style.visibility = "hidden";

	
	
	document.getElementById('expca').style.visibility = "hidden";
	
	document.getElementById('expcatd').style.visibility = "hidden";
	

	if(value=="General Consumption")
	{
 
	document.getElementById('expca').style.visibility = "visible";
	
	document.getElementById('expcatd').style.visibility = "visible";
	}
	<?php if($_SESSION['db']=="singhsatrang"){
	?>
	if(value.match(/Produced/))
	{
 
	document.getElementById('expca').style.visibility = "visible";
	
	document.getElementById('expcatd').style.visibility = "visible";
	}
<?php } ?>
    
	if(value.match(/Sale/))

	{
 
		document.getElementById('cogsactd').style.visibility = "visible";

		document.getElementById('sactd').style.visibility = "visible";

		document.getElementById('sractd').style.visibility = "visible";

		document.getElementById('cogsac').style.visibility = "visible";

		document.getElementById('sac').style.visibility = "visible";

		document.getElementById('srac').style.visibility = "visible";
	}

	//if(value.match(/Produced/))
//
//	{
//
//		//document.getElementById('wpactd').style.visibility = "visible";
//
//		
//
//	}
	
	
	



}

function coas1(value)

{


  //document.getElementById('expca').style.visibility = "hidden";
//	
//	document.getElementById('expcatd').style.visibility = "hidden";
//	

	if(value.match(/Produced/))
	{
 
	document.getElementById('expca').style.visibility = "visible";
	
	document.getElementById('expcatd').style.visibility = "visible";
	}

}

</script>

<script type="text/javascript">

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