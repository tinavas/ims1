<?php

include "config.php";

include "jquery.php";

?>



<br>

<br>

<center>

<h1>Attendance</h1>

<br>

<br>



<form method="post" name="myform" action="hr_saveattendance.php" onSubmit="return valid(this);">


<strong>Date</strong> &nbsp;

<input type="text" value="<?php echo date('d.m.Y') ?>" readonly name="date1" id="date1"  class="datepicker" size="12" />&nbsp;&nbsp;

<strong>Sector</strong> &nbsp;

<select id="sector" name="sector" onchange="fun1();">

  <option>-Select-</option>

  <?php include "config.php";

$query = "SELECT distinct(sector) FROM hr_employee ORDER BY sector ASC ";

           $result = mysql_query($query,$conn); 

           while($row1 = mysql_fetch_assoc($result))

           { 

            ?>

  <option value="<?php echo $row1['sector'];?>"> <?php echo $row1['sector'];?> </option>

  <?php } ?>

</select>

<strong>Reporting To </strong>&nbsp;

<select id="reportingto" name="reportingto" onChange="fun2();" >

<option>-Select-</option>

</select>

<br /><br />





&nbsp;&nbsp;

<img src="images/icons/fugue/tick-circle.png" title="Check All" name="CheckAll" onClick="checkAll(document.myform.elements['box1[]'])" />

&nbsp;&nbsp;

<img src="images/icons/fugue/cross-octagon-frame.png" title="Uncheck all" name="UnCheckAll" onClick="uncheckAll(document.myform.elements['box1[]'])" />

&nbsp;&nbsp;

<a><img style="display:none;border:0px" src="information-shield.png"  Title="Help : Select the Presentes and save" /></a>



<br />

<br />



<table width="400" border="0" valign="top" id="tableid" style="display:none">

<tr>

<td></td>

<td><strong>Employee Name</strong></td>

<td><strong>FullDay</strong></td>

<td><strong>HalfDay</strong></td>

<td><strong>Leav</strong></td>

</tr>

<tr height="10px"><td>&nbsp;</td></tr>

</table>

<br /><br />

<input type="submit" value="Save" id="Save" disabled="disabled"/> 

&nbsp;&nbsp;&nbsp; 

<input type="button" value="Cancel" onClick="document.location = 'dashboardsub.php?page=hr_attendance';">



</form>

</center>



<script type="text/javascript">

function fun1()

{

	deleteRow();

	document.getElementById('tableid').style.display = "none";

	document.getElementById('Save').disabled = true;



	var sector = document.getElementById('sector').value;

	var reportingto = document.getElementById('reportingto');

	removeAllOptions(reportingto)

	theOption1=document.createElement("OPTION");

	theText1=document.createTextNode("-Select-");

	theOption1.appendChild(theText1);

	theOption1.value = "";

	reportingto.appendChild(theOption1);



	<?php 

	$q ="select distinct(sector) from hr_employee order by sector";

	$qrs = mysql_query($q) or die(mysql_error());

	while($qr = mysql_fetch_assoc($qrs))

	{

	echo "if( sector == '$qr[sector]' ) {";

	$q1 = "select distinct(reportingto) from hr_employee where sector = '$qr[sector]' order by reportingto";

	$q1rs = mysql_query($q1) or die(mysql_error());

	while($q1r = mysql_fetch_assoc($q1rs))

	{

	?>

	theOption1=document.createElement("OPTION");

	theText1=document.createTextNode("<?php echo $q1r['reportingto']; ?>");

	theOption1.appendChild(theText1);

	theOption1.value = "<?php echo $q1r['reportingto']; ?>";

	reportingto.appendChild(theOption1);

	<?php } echo "}"; } ?>

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



function fun2()

{

	deleteRow();

	var sector = document.getElementById('sector').value;

	var reportingto = document.getElementById('reportingto').value;

	var mytable = document.getElementById('tableid');

	var mytr,mytd,text,img;

	

	if(sector != "" && reportingto != "")

	document.getElementById('tableid').style.display = "";

	else

	document.getElementById('tableid').style.display = "none";

	

	document.getElementById('Save').disabled = true;


	

<?php 

$q = "select distinct(sector) from hr_employee order by sector";

$qrs = mysql_query($q) or die(mysql_error());

while($qr = mysql_fetch_assoc($qrs))

{

echo "if( sector == '$qr[sector]' ) { ";

$q1 = "select distinct(reportingto) from hr_employee where sector = '$qr[sector]' order by reportingto";

$q1rs = mysql_query($q1) or die(mysql_error());

while($q1r = mysql_fetch_assoc($q1rs))

{

echo "if( reportingto == '$q1r[reportingto]' ) { ";

$q2 = "select distinct(name),employeeid,farm from hr_employee where sector = '$qr[sector]' and reportingto = '$q1r[reportingto]' order by name";

$q2rs = mysql_query($q2) or die(mysql_error());

while($q2r = mysql_fetch_assoc($q2rs))

{

?>

	rowCount = mytable.rows.length;

	row = mytable.insertRow(rowCount);



	cell1 = row.insertCell(0);

	img = document.createElement("img");

	img.src = "images/icons/fugue/user-black.png";

	img.style.border = "0px";

	cell1.appendChild(img);

		

	cell2 = row.insertCell(1);

	text = document.createTextNode("<?php echo $q2r['name']; ?>");

	cell2.appendChild(text);

	

	

	cell3 = row.insertCell(2);

	myinput = document.createElement("input");

	myinput.type = "checkbox";

	myinput.name = "box1[]";

	myinput.id = "box1[]";

	myinput.value = "<?php echo $q2r['name'] . "," . $q2r['employeeid'] . "," . $q2r['farm'];?>";

	cell3.appendChild(myinput);

	

	cell4 = row.insertCell(3);

	myinput = document.createElement("input");

	myinput.type = "checkbox";

	myinput.name = "box2[]";

	myinput.id = "box2[]";

	myinput.value = "<?php echo $q2r['name'] . "," . $q2r['employeeid'] . "," . $q2r['farm'];?>";

	cell4.appendChild(myinput);	

	

	cell5 = row.insertCell(4);

	myinput = document.createElement("input");

	myinput.type = "checkbox";

	myinput.name = "box3[]";

	myinput.id = "box3[]";

	myinput.value = "<?php echo $q2r['name'] . "," . $q2r['employeeid'] . "," . $q2r['farm'];?>";

	cell5.appendChild(myinput);	

	

	document.getElementById('Save').disabled = false;

<?php } echo "}"; } echo "}"; } ?>



}



function deleteRow() 

{

	var table = document.getElementById('tableid');

	var rowCount = table.rows.length;

	for(var i=2; i<rowCount; i++)

	{

			table.deleteRow(i);

			rowCount--;

			i--;

	}

}



function checkAll(field)

{

 if(isNaN(field.length))

  {

    field.checked = true;

  }

  else

  {

	for(var i = 0; i < field.length; i++)

	field[i].checked = true ;

  }

}



function uncheckAll(field)

{

if(isNaN(field.length))

  {

         field.checked = false;

  }

  else

  { 

	for(i = 0; i < field.length; i++)

	field[i].checked = false ;

  }

}



function valid(a) 

{

var j = 0,l = 0,m=0,n=0;

var field = document.myform.elements['box1[]'];

var field1 = document.myform.elements['box2[]'];

var field2 = document.myform.elements['box3[]'];

 if(isNaN(field.length))

  {

            if(field.checked == true)

            {

              j = 1;

            }

  }

  else

  {

	for (k = 0; k < field.length; k++)

	{

      if(field[k].checked == true)

      {

        j = 1;

      }

	}

  }

 if(isNaN(field1.length))

  {

            if(field1.checked == true)

            {

              l = 1;

            }

  }

  else

  {

	var field1 = document.myform.elements['box2[]'];

	for (k = 0; k < field1.length; k++)

	{

      if(field1[k].checked == true)

      {

        l = 1;

      }

	}

  }

if(isNaN(field2.length))

  {

            if(field2.checked == true)

            {

              n = 1;

            }

  }

  else

  {

	var field2 = document.myform.elements['box3[]'];

	for (k = 0; k < field2.length; k++)

	{

      if(field2[k].checked == true)

      {

        n = 1;

      }

	}

  }



var i = 0;

<?php

     include "config.php";

     $q2=mysql_query("select * from hr_attendance ORDER BY name ASC ");

     while($nt2=mysql_fetch_array($q2))

	 {

     echo "if(document.getElementById('date1').value == '$nt2[dumpdate]' && document.getElementById('sector').value == '$nt2[place]' && document.getElementById('reportingto').value == '$nt2[reportingto]' ){";

     echo "if(document.getElementById('date1').value != '$newdate'){";

     echo "i = i + 1;"; 

      echo "}";

      echo "}"; // end of JS if condition

     }

?>



if ( j == 0 && l == 0 && n == 0)

{

   alert('Enter Attendance');

   return false; 

}

p=0

if ( j!=0 && l!=0 && n!=0)

{

if(isNaN(field1.length) )

  {

            if(field1.checked == true && field2.checked == true && field.checked == true)

            {

              p = 1;

            }

  }

  else

  {

	for (k = 0; k < field1.length; k++)

	{



     if(field1[k].checked == true && field2[k].checked == true && field[k].checked == true)

            {

              p = 1;

            }

	}

  }

}

if ( j!=0 && l!=0 )

{

if(isNaN(field1.length))

  {

            if(field1.checked == true && field.checked == true)

            {

              m = 1;

            }

  }

  else

  {

	for (k = 0; k < field1.length; k++)

	{



      if(field1[k].checked == true && field[k].checked == true)

      {

        m = 1;

      }

	}

  }

}

if ( j!=0 && n!=0 )

{

if(isNaN(field2.length))

  {

            if(field2.checked == true && field.checked == true)

            {

              m = 1;

            }

  }

  else

  {

	for (k = 0; k < field1.length; k++)

	{



      if(field2[k].checked == true && field[k].checked == true)

      {

        m = 1;

      }

	}

  }

}if ( n!=0 && l!=0 )

{

if(isNaN(field1.length))

  {

            if(field1.checked == true && field2.checked == true)

            {

              m = 1;

            }

  }

  else

  {

	for (k = 0; k < field1.length; k++)

	{



      if(field1[k].checked == true && field2[k].checked == true)

      {

        m = 1;

      }

	}

  }

}

if ( i > 0 )

{

   alert('Attendance have been already taken for this date and sector');

   return false;

}

if(p == 1)

{

alert("Three corresping checkboxes should not be checked");

return false;

}

if(m == 1)

{

alert("Two corresping checkboxes should not be checked");

return false;

}

return true;

}

</script>

<script type="text/javascript">

function script1() {

window.open('HRHELP/help_t_addattendance.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');

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