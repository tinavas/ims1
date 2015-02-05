<center>

<br />

<h1>New Schedule</h4>

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br/>

<br/><br />

</center>



<form method="post" action="ac_saveschedule.php" onsubmit="return checkform(this);">

<table align="center" >

<tr>

<td width="150" align="right"><strong>Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

<td width="150" align="left"><input type="text" name="code" size="7" id="code" onkeyup="" /></td>

</tr>



<tr height="10px"><td></td></tr>



<tr>

<td width="150" align="right"><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

<td width="150" align="left"><input type="text" name="description" size="25" id="description" onkeyup="" /></td>

</tr>



<tr height="10px"><td></td></tr>



<tr>

<td width="150" align="right"><strong>Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

<td width="150" align="left"><select style="Width:120px" name="type" id="type" onchange="getschedule(this.value);">

                      <option value="SELECT">-Select-</option>

	                  <option value="Asset">Asset</option>

                      <option value="Capital">Capital</option>

					  <option value="Expense">Expense</option>

					  <option value="Liability">Liability</option>

					  <option value="Revenue">Revenue</option>

			</select>

</td>

</tr>

<tr height="10px"></tr>
<tr>
<td colspan="2" align="center"><input type="radio" size="10" onClick="loadfun('false')" value="direct" name="direct" id="direct">&nbsp;&nbsp;<strong>Parent</strong>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" onchange="getschedule(this.value);" onClick="loadfun('true')" value="indirect" size="10" name="direct"  checked="checked" id="indirect">&nbsp;&nbsp;<strong>Child</strong></td>
</tr>

<tr height="10px"></tr>



<tr>

<td width="150" align="right"><strong>Parent Schedule</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

<td width="150" align="left">

<select style="Width:220px" name="schedule" id="schedule" >

                      <option value="SELECT">-Select-</option>

 			</select>

</td>

</tr>



<tr height="10px"><td></td></tr>



<tr>

<td colspan="5" align="center">

<br />

<center>

<input type="submit" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=ac_schedule';">

</center>

</td>

</tr>

</table>

<br /><br /><br />

</form>

<script language="JavaScript" type="text/javascript">
function loadfun(a)
{
 if(document.getElementById('indirect').checked)
 {
 document.getElementById("schedule").value = "";
  removeAllOptions(document.getElementById("schedule"));
  document.getElementById("schedule").disabled = false;
  myselect1 = document.getElementById("schedule");
  theoption = document.createElement("option");
  theText1 = document.createTextNode("-Select-");
  theoption.value = '';
  myselect1.appendChild(theoption);
<?php
     $q4 = mysql_query("select distinct(schedule) from ac_schedule where type in ('Asset','Capital','Expense','Liability','Revenue') and ptype = 'InDirect' order by schedule");
	 while($nt4 = mysql_fetch_array($q4))
	 {
	  ?>
			 

              theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("<?php echo $nt4['schedule']; ?>");
			  theOption1.value = "<?php echo $nt4['schedule']; ?>";
			  theOption1.appendChild(theText1);
			  theOption1.title = "<?php echo $nt4['schedule']; ?>";
			  myselect1.appendChild(theOption1);
			 
    <?php } ?>
  
 }
 else
 {
   document.getElementById("schedule").value = "";
  document.getElementById("schedule").disabled = true;
  removeAllOptions(document.getElementById("schedule"));
  } 
}


function getschedule(a)

{

 removeAllOptions(document.getElementById("schedule"));



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

     $q3=mysql_query("select * from ac_schedule where type='$nt2[type]' and ptype = 'Direct' order by schedule ASC");

	  

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

var numericExpression = /^[0-9].+$/;

    if (form.code.value == "") {

    alert( "Please enter Code." );

    form.code.focus();

    return false ;

  }

   else if (form.description.value == "") {

    alert( "Please enter Description." );

    form.description.focus();

    return false ;

  }

    else if (form.type.value == "SELECT") {

    alert( "Please select Type." );

    form.type.focus();

    return false ;

  }

   else if (form.schedule.value == "SELECT") {

    alert( "Please select parent schedule Type." );

    form.schedule.focus();

    return false ;

  }

    

  return true ;

}





</script>

<script type="text/javascript">

function script1() {

window.open('GLHelp/help_m_addnewschedule.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');

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

