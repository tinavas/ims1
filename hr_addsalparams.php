<?php include "config.php"; ?>

<?php include "jquery.php"; ?>

<br />

<center>

<h1>Define Salary Parameters</h1>

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br/>

<br/>

<br/>

<form id="form1" name="form1" method="post" action="hr_savesalparams.php"  onsubmit="return checkform(this);">

<table align="center">



<tr> 

<td align="right"><strong>Parameter Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

<td align="left"><input type="text" name="code" size="17" id="code"/></td>

<td align="right"><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

<td align="left"><input type="text" name="description" size="20" id="description" /></td>

</tr>



<tr height="10px"><td></td></tr>



<tr>

<td align="right"><strong>Unit</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

<td align="left" ><select style="Width:120px" name="unittd" id="unittd" onchange="checkper()" >

  <option value="">-Select-</option>

  <option value="Per">%</option>

  <option value="Flat">Flat</option>

</select></td> 

<td align="right" id="typetd" ><strong>Basis</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

<td align="left" id="based" ><select style="Width:120px" name="based" id="based" onchange="formulaflat(this.value);"  >



  <option value="Salary">Salary</option>



</select></td>

</tr>

<tr height="10px"><td></td></tr>

<tr> 

<td align="right" id="def" name ="def" ><strong>Default Value</strong>&nbsp;&nbsp;&nbsp;</td>

<td align="left"><input  name="default" id="default" size="17" onkeyup="return checkper()" onblur="return checkper()" /></td>

<td align="right" ><strong>Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

<td align="left" id="based" ><select style="Width:120px" name="incex" id="incex" >

  <option value="">-Select-</option>

  <option value="include">Include</option>

  <option value="exclude">Exclude</option>

</select></td>

</tr>
<tr height="10px"><td></td></tr>

<tr> 

<td align="right" id="def" name ="def" >
<input type="checkbox" id="ded" name="ded" value="ded" onclick="checkfun1()"  />
<strong>Deduction</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left" id="based" >
<select style="Width:120px" name="coa" id="coa" onchange="checkded()"  >
  <option value="">-Select-</option>
  <?php 
  $query="select code,description from ac_coa where type='Liability' or type='Expense'";
  $result=mysql_query($query,$conn);
  while($rows=mysql_fetch_assoc($result))
  {
  ?>
  <option value="<?php echo $rows['code'];?>" title="<?php echo $rows['description'];?>" ><?php echo $rows['code'];?></option>
  <?php
  } 
  ?>
</select></td>
</tr>




<tr height="10px"><td></td></tr>

<tr>

<td colspan="4" align="center" style="padding-left:80px; visibility:hidden">





<select name="paramcode[]" id="paramcode"  style="width:150px; " multiple onclick="getdescr(this.value)">

  <option disabled>-Select-</option>

  <?php

                  include "config.php"; 

                  $query = "SELECT distinct(code),description FROM hr_params ORDER BY description";

                  $result = mysql_query($query,$conn); 

                  while($row1 = mysql_fetch_assoc($result))

                  {

            ?>

  <option value="<?php echo $row1['description']; ?>"><?php echo $row1['description']; ?></option>

  <?php } ?>

</select></td>

</tr>



<tr height="10px"><td></td></tr>



<tr>

<td colspan="4" align="center" id="for" name ="for" style="visibility:hidden"><strong>Formula</strong>

&nbsp;&nbsp;&nbsp;&nbsp;

<textarea id="formula" name="formula" type="html" rows="5" ></textarea></td>

</tr>



<tr height="10px"><td></td></tr>



<tr><td colspan="4" align="center"><strong><span id="spanid1"></span></strong></td></tr>



<tr>

<td colspan="4" align="center">

<br />

<center>

<input type="submit" value="Save" id="save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=hr_salparams';">

</center></td>

</tr>

</table>

</center>

<br /><br /><br />

</form>



<script language="JavaScript" type="text/javascript">


function checkper()
{

if(document.getElementById("unittd").value=="Per")
{
if(document.getElementById("default").value>100)
{
alert("Percentage value should not be greter than 100");

document.getElementById("default").value=0;
return false;

}
}


}
function checkfun1()
{
	if(document.getElementById('ded').checked)
		{}
	else
		{
		document.getElementById('coa').value="";
		}
	}
function checkded()
{
	if(document.getElementById('ded').checked)
		{}
	else
		{
		alert("Pleck Click Deduction");
		document.getElementById('coa').value="";
		document.getElementById('ded').focus();
		}
}
function checkform (form)

{

 var noalpha = /^[a-zA-Z0-9]*$/;

 var noalpha1 = /^[a-zA-Z0-9\s]*$/;

  if (form.code.value == "") 

  {

    alert( "Please enter Code." );

    form.code.focus();

	document.getElementById('save').disabled = true;

    return false ;

	

  }

   if ( (!(form.code.value.match(noalpha)))) 

 {

    alert( "Code cannot have special charaters  and spaces." );

    form.code.focus();

	document.getElementById('save').disabled = true;

    return false ;

	

 }

  if (form.description.value == "") 

  {

    alert( "Please enter Description." );

    form.description.focus();

	document.getElementById('save').disabled = true

    return false ;

	

  }



  if ( (!(form.description.value.match(noalpha1)))) 

  {

    alert( "Description cannot have special charaters." );

    form.description.focus();

	document.getElementById('save').disabled = true;

    return false ;

  }

   if (form.unittd.value == "") 

   {

    alert( "Please select Unit." );

    form.unittd.focus();

	document.getElementById('save').disabled = true;

    return false ;

   }

  if (form.based.value == "") 

  {

    alert( "Please select Basis." );

    form.based.focus();

	document.getElementById('save').disabled = true;

    return false ;

  }

  if (form.incex.value == "") 

  {

    alert( "Please select Type." );

    form.incex.focus();

	document.getElementById('save').disabled = true;

    return false ;

  }

  

  if(form.based.value == "Others")

  {

  if (form.paramcode.value == "") 

  {

    alert( "Please select Parameters." );

    form.paramcode.focus();

	document.getElementById('save').disabled = true;

    return false ;

  }

  if(form.formula.value == "") 

  {

    alert( "Please enter Formula." );

    form.formula.focus();

	document.getElementById('save').disabled = true;

    return false ;

  }

  }
if(document.getElementById('ded').checked)
		{
			if(document.getElementById('coa').value=="")
			{
				alert("Pleck Select Coa");
		document.getElementById('coa').focus();
				return false;
				}
			}
			
			
			
			<?php
			
			$query="SELECT code, description
FROM `hr_params`";

			$result=mysql_query($query,$conn);
			while($row=mysql_fetch_array($result))
			{
			?>
			
			if(form.code.value=="<?php echo $row['code'];?>")
			{
			
			
				alert("Code already exists");
				return false;
			
			}
			
			
			if(form.description.value=="<?php echo $row['description'];?>")
			{
			
			
				alert("Description already exists");
				return false;
			
			}	
			
			<?php }?>
			

 document.getElementById('save').disabled =false;

  return true;

}





function formulaflat(a)

{

	if(a == "Others")

	{

		

		document.getElementById('paramcode').style.visibility = "visible";

		document.getElementById('for').style.visibility = "visible";

		document.getElementById('formula').style.visibility = "visible";

				document.getElementById('formula').innerHTML  = "e.g:   $Basic + ($PF - $ProfTax)";

	}

	else if(a == "Salary")

	{

		

		document.getElementById('paramcode').style.visibility = "hidden";

		document.getElementById('paramcode').value = "";

		document.getElementById('for').style.visibility = "hidden";

		document.getElementById('formula').style.visibility = "hidden";

		document.getElementById('formula').value="";

		

	}

	

}

function getdescr(a)

{

  var out = "";

  document.getElementById("formula").innerHTML = "";

  for (var i = 0; i < document.getElementById("paramcode").options.length; i++) 

   {

      if( document.getElementById("paramcode").options[i].selected)

      {

        var test = document.getElementById("paramcode").options[i].value.split('@');

        out += test[0]+' ';

       
      }

   }



  document.getElementById("formula").value = out;

}



function removeAllOptions(selectbox)

{

	var i;

	for(i=selectbox.options.length-1;i>=0;i--)

	{

		selectbox.remove(i);

	}

}





</script>



<script type="text/javascript">

function script1() {

window.open('HRHELP/hr_m_salpara.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');

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

