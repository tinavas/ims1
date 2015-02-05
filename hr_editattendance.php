<?php

include "config.php";
include "jquery.php";

if(!isset($_GET['sector']))
$sector = "";
else
 $sector = $_GET['sector'];

if(!isset($_GET['reportingto']))
$reportingto = "";
else
$reportingto = $_GET['reportingto'];

$name=$_GET['name'];

           $query = "SELECT * FROM hr_employee where releaved = '0' and sector = '$_GET[sector]' and reportingto = '$_GET[reportingto]' ORDER BY name ASC ";
           $result = mysql_query($query,$conn); $i = 0;
           while($row1 = mysql_fetch_assoc($result))
           {
            $user1[$i] = $row1['name'];
			$farm[$i] = $row1['farm'];
			$eid[$i] = $row1['employeeid'];
            $i = $i + 1;
           }

           $query3 = "SELECT * FROM hr_attendance where date = '$_GET[id]' ORDER BY date ASC ";
           $result3 = mysql_query($query3,$conn); 
           while($row3 = mysql_fetch_assoc($result3))
           { 
            $newdate = $row3['dumpdate'];  
           }

?>

<br />
<center>
<h1>Daily Attendance</h1>
<br><br>
<form method="post" name="myform" action="hr_updateattendance.php" onSubmit="return valid(this);">
<strong>Sector</strong> &nbsp; 
<select id="sector" name="sector" onChange="fun1();">
<option>-Select-</option>
<?php
$query = "SELECT distinct(sector) FROM hr_employee ORDER BY sector ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           { 
            ?>
<option value="<?php echo $row1['sector'];?>" <?php if($row1['sector'] ==$sector){?> selected="selected" <?php } ?> > <?php echo $row1['sector'];?></option>
<?php } ?>
</select>
<strong>Reporting To</strong> &nbsp;
<select id="reportingto" name="reportingto" onChange="fun2();" >
<option>-Select-</option>
<?php
$query = "SELECT distinct(reportingto) FROM hr_employee where sector = '$sector' ORDER BY reportingto ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           { 
            ?>
<option value="<?php echo $row1['reportingto'];?>" <?php if($row1['reportingto'] == $reportingto){?> selected="selected" <?php } ?> > <?php echo $row1['reportingto'];?></option>
<?php } ?>
</select>
<br /><br /><br />
<div <?php if($sector == "" || $reportingto == "") { ?> style="display:none" <?php } ?>>

<strong>Date</strong> &nbsp;<input type="text" value="<?php echo $newdate; ?>" readonly name="date1" id="date1" class="datepicker" size="15">&nbsp;&nbsp;&nbsp;

&nbsp;&nbsp;<img src="images/icons/fugue/tick-circle.png" title="Chech All" name="CheckAll" onClick="checkAll(document.myform.elements['box1[]'])" />
&nbsp;&nbsp;<img src="images/icons/fugue/cross-octagon-frame.png" title="Uncheck all" name="UnCheckAll" onClick="uncheckAll(document.myform.elements['box1[]'])" />
<!--&nbsp;&nbsp;<img src="information-shield.png" style="border:0px" Title="Help : Select the Presentes and save" />-->
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Update" onClick=""/> &nbsp;&nbsp;&nbsp; <input type="button" value="Cancel" onClick="document.location = 'dashboardsub.php?page=hr_attendance';">
 <br /><br />
 <table width="400" border="0" valign="top">

<tr>
<td width="50"></td>
<td width="150"><strong>Employee Name</strong></td>
<td width="100"><strong>FullDay</strong></td>
<td width="100"><strong>HalfDay</strong></td>
<td width="100"><strong>Leav</strong></td>
</tr>
</table>
<?php for ($j=0;$j<$i;$j++) { ?>

<table width="400" border="0" valign="top">
<tr>
<td width="50">
<img src="images/icons/fugue/user-black.png" style="border:0px" />
</td>
&nbsp;&nbsp;&nbsp;
<td width="150">
<?php echo $user1[$j] ?>
</td>
<td width="100">
<input type="hidden" name="use[]" value="<?php echo $user1[$j]; ?>" />
<?php
           $ispresent = "0"; 
           $query4 = "SELECT * FROM hr_attendance where date = '$_GET[id]' and name = '$user1[$j]' and daytype ='Full' ORDER BY date ASC ";
           $result4 = mysql_query($query4,$conn); 
           $ispresent = mysql_num_rows($result4);

?>
<input type="checkbox" name="box1[]" value="<?php echo $user1[$j].','.$eid[$j].','.$farm[$j]; ?>" <?php if($ispresent <> "0") { ?> checked = "true" <?php } ?>  />
</td>


<td width="100">
<?php
           $ispresent = "0"; 
           $query4 = "SELECT * FROM hr_attendance where date = '$_GET[id]' and name = '$user1[$j]' and daytype ='Half' ORDER BY date ASC ";
           $result4 = mysql_query($query4,$conn); 
           $ispresent = mysql_num_rows($result4);

?>
<input type="checkbox" name="box2[]" value="<?php echo $user1[$j].','.$eid[$j].','.$farm[$j]; ?>" <?php if($ispresent <> "0") { ?> checked = "true" <?php } ?>  />

</td>
<td width="100">
<?php
           $ispresent = "0"; 
           $query4 = "SELECT * FROM hr_attendance where date = '$_GET[id]' and name = '$user1[$j]' and daytype ='Leav' ORDER BY date ASC ";
           $result4 = mysql_query($query4,$conn); 
           $ispresent = mysql_num_rows($result4);

?>
<input type="checkbox" name="box3[]" value="<?php echo $user1[$j].','.$eid[$j].','.$farm[$j]; ?>" <?php if($ispresent <> "0") { ?> checked = "true" <?php } ?>  />

</td>
</tr>

<?php } #$user1 = implode(",", $user1); ?>
</table>
</div>
<br />
</form>

<script type="text/javascript">

function fun1()
{
	var sector = document.getElementById('sector').value;
	var reportingto = "";
	document.location = "dashboardsub.php?page=hr_editattendance&sector=" + sector + "&reportingto=" + reportingto  + "&id=<?php echo $_GET['id'];?>";
}

function fun2()
{
	var sector = document.getElementById('sector').value;
	var reportingto = document.getElementById('reportingto').value;
	document.location = "dashboardsub.php?page=hr_editattendance&sector=" + sector + "&reportingto=" + reportingto  + "&id=<?php echo $_GET['id'];?>";
}

function checkAll(field)
{
 if(isNaN(field.length))
  {
         field.checked = true;
  }
  else
  {
for (i = 0; i < field.length; i++)
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
for (i = 0; i < field.length; i++)
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
     echo "if(document.getElementById('date1').value == '$nt2[dumpdate]'){";
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
   alert('Attendance have been already taken for this date');
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
window.open('HRHELP/help_t_editattendance.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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