<center>
<br />
<h1>Chart Of Accounts</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
<form id="form1" name="form1" method="post" action="ac_savecoa.php"  onsubmit="return checkform(this);">
<table align="center">

<tr>
<td width="150" align="right"><strong>Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="300" align="left"><input type="text" name="code" size="7" id="code" onkeyup="" />
&nbsp;<span id="code1" style="color:red;"></span></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="150" align="right"><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="300" align="left"><input type="text" name="description" size="32" id="description" onkeyup="" />
&nbsp;<span id="description1" style="color:red;"></span></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="150" align="right"><strong>Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="300" align="left"><select style="Width:120px;" name="type" id="type" onchange="getschedule(this.value);">
                      <option value="">-Select-</option>
	                  <option value="Asset">Asset</option>
                         <option value="Capital">Capital</option>
					  <option value="Expense">Expense</option>
					  <option value="Liability">Liability</option>
					  <option value="Revenue">Revenue</option>
			</select>
			&nbsp;<span id="type1" style="color:red;"></span>
</td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="150" align="right"><strong>Controll Type</strong>&nbsp;&nbsp;&nbsp;</td>
<td width="300" align="left">
<select style="Width:180px" name="ctype" id="ctype" >
                      <option value="">-select-</option>
			</select>
</td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td width="150" align="right"><strong>Schedule</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td width="300" align="left">
<select style="Width:220px" name="schedule" id="schedule" >
                      <option value="">-Select-</option>
			</select>&nbsp;&nbsp;<a href="dashboardsub.php?page=ac_addschedule"><img src="images/icons/fugue/plus.png" title="Add New Schedule" border="0px" /></a>
			&nbsp;<span id="schedule1" style="color:red;"></span>
</td>
</tr>

<tr>
<td colspan="5" align="center">
<br />
<center>
<input type="submit" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=ac_coa';">
</center>
</td>
</tr>
</table>
</center>
<br /><br /><br />
</form>
<script language="JavaScript" type="text/javascript">
function getschedule(a)
{
 removeAllOptions(document.getElementById("schedule"));
 removeAllOptions(document.getElementById("ctype"));

 myselect1 = document.getElementById("ctype");
              theOption1=document.createElement("OPTION");
             theOption1.value='';
              theText1=document.createTextNode("-select-");
              theOption1.appendChild(theText1);
              myselect1.appendChild(theOption1);

<?php
     include "config.php";
     $q2=mysql_query("select distinct(type) from ac_controltype order by type ASC");
	 
     while($nt2=mysql_fetch_array($q2)){
     echo "if(document.getElementById('type').value == '$nt2[type]'){";
     $q3=mysql_query("select * from ac_controltype where type='$nt2[type]' order by controltype ASC");
	  
     while($nt3=mysql_fetch_array($q3))
	 { ?>
			 

              theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("<?php echo $nt3['controltype']; ?>");
			  theOption1.value = "<?php echo $nt3['controltype']; ?>";
			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);
			 
    <?php   } 
      echo "}"; 
     }
  ?>


			  myselect1 = document.getElementById("schedule");
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
              theOption1.value = "SELECT";
              theOption1.appendChild(theText1);
              myselect1.appendChild(theOption1);
 <?php
     include "config.php";
     $q2=mysql_query("select distinct(type) from ac_schedule order by type ASC");
	 
     while($nt2=mysql_fetch_array($q2)){
     echo "if(document.getElementById('type').value == '$nt2[type]'){";
     $q3=mysql_query("select distinct(schedule) from ac_schedule where type='$nt2[type]' and ptype = 'InDirect' order by schedule ASC");
	  
     while($nt3=mysql_fetch_array($q3))
	 { ?>
			 

              theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("<?php echo $nt3['schedule']; ?>");
			  theOption1.value = "<?php echo $nt3['schedule']; ?>";
			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);
			 
    <?php   } 
      echo "}"; 
     }
  ?>
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
 var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";
 var nonums = /^[0-9]*$/;
 var numericExpression = /^[0-9].+$/;
 if (form.code.value == "") 
 {
   document.getElementById("code1").innerHTML = "Please enter the code";
   document.getElementById("code").setAttribute("class","error relative");
   form.code.focus();
   return false ;
 }
 else if ((!(form.code.value.match(noalpha)))) 
 {
   document.getElementById("code1").innerHTML = "Code cannot have special charaters";
   document.getElementById("code").setAttribute("class","error relative");
   form.code.focus();
   return false ;
 }

else if (form.description.value == "") 
{
  document.getElementById("code1").innerHTML = "";
  document.getElementById("code").setAttribute("class","");
  document.getElementById("description1").innerHTML = "Please enter description";
  document.getElementById("description").setAttribute("class","error relative");
  form.description.focus();
  return false ;
}
else if ((!(form.description.value.match(noalpha1)))) 
{
  document.getElementById("code1").innerHTML = "";
  document.getElementById("code").setAttribute("class","");
  document.getElementById("description1").innerHTML = "Description cannot have special characters";
  document.getElementById("description").setAttribute("class","error relative");
  form.description.focus();
  return false ;
 }
 else if (form.description.value.length > 45 ) 
 {
  document.getElementById("code1").innerHTML = "";
  document.getElementById("code").setAttribute("class","");
  document.getElementById("description1").innerHTML = "Description Should not be morethan 45 characters";
  document.getElementById("description").setAttribute("class","error relative");
  form.description.focus();
  return false ;
  }
else if (form.type.value == "") 
{
  document.getElementById("description1").innerHTML = "";
  document.getElementById("description").setAttribute("class","");
  document.getElementById("type1").innerHTML = "Please select a type";
  document.getElementById("type").setAttribute("class","error relative");
  form.type.focus();
  return false ;
}
else if (form.schedule.value == "") 
{
  document.getElementById("type1").innerHTML = "";
  document.getElementById("type").setAttribute("class","");
  document.getElementById("schedule1").innerHTML = "Please select a schedule";
  document.getElementById("schedule").setAttribute("class","error relative");
  form.schedule.focus();
    return false ;
  }
    
  return true ;
}
</script>

<script type="text/javascript">
function script1() {
window.open('GLHelp/help_m_addcoa.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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