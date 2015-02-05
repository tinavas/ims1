<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1256"> 
<META HTTP-EQUIV="Content-language" CONTENT="ar"> 

<title>B.I.M.S</title>
<!-- calender -->
<link type="text/css" rel="stylesheet" href="../dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<link type="text/css" rel="stylesheet" href="../dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051124" media="screen"></LINK>
<link type="text/css" rel="stylesheet" href="../dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051167" media="screen"></LINK>
<SCRIPT type="text/javascript" src="../dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
<SCRIPT type="text/javascript" src="reports.js"></script>
<style type="text/css">
body
{
font-family:Arial,Helvetica,sans-serif;
font-size:12px;
font-weight:bold;
}
td
{
font-size:12px;
font-weight:bold;
}
</style>
</head>
<body bgcolor="#ECF1F5">

<fieldset style="height:440px;padding-left:10px">
<center>
<h4 style="color:red;font-weight:bold;padding-top:10px"><u>Employee Reports</u></h2>
</center>
<br />

<table align="center">
<tr>
<td>
<strong>Sector:</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<select id="sector" name="sector"   style="width:150" onChange="fun()" tabindex="2">
<option> Select  </option>
<?php
           include "config.php"; 
           $query = "SELECT distinct(sector) FROM hr_employee  ORDER BY sector ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
<option value="<?php echo $row1['sector']; ?>"><?php echo $row1['sector']; ?></option>
<?php } ?>
</select>
</td>

<td width="10px">&nbsp;</td>
<td>
<strong>Employee Name : </strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<select name="empname" id="empname" tabindex="2" onChange="" style="width:150">
<option value="Select">Select</option>
</select>
</td>
</tr>
<tr height="20px"></tr>
<tr>
<td>
<strong>Month : </strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<select id="month" onChange="" name="month" >
<option value="Select"> Select </option>
<option value="01">JAN</option>
<option value="02">FEB</option>
<option value="03">MAR</option>
<option value="04">APR</option>
<option value="05">MAY</option>
<option value="06">JUN</option>
<option value="07">JUL</option>
<option value="08">AUG</option>
<option value="09">SEP</option>
<option value="10">OCT</option>
<option value="11">NOV</option>
<option value="12">DEC</option>
</select>
</td>
<td width="10px">&nbsp;</td>
<td align="right">
<strong>Year : </strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<select id="year" onChange="" name="year">
<option value="Select"> Select </option>
<option value="2011">2011</option>
<option value="2012">2012</option>
<option value="2013">2013</option>
<option value="2014">2014</option>
<option value="2015">2015</option>
<option value="2016">2016</option>
<option value="2017">2017</option>
<option value="2018">2018</option>
<option value="2019">2019</option>
<option value="2020">2020</option>
</select>
</td>
</tr>
</table>

<table align="center" style="visibility:visible">
<tr height="20"></tr>
<tr><td><td colspan="15" style="text-align:center"><input type="button" value="Open Report" onClick="openreport();" /></td></tr>
</table>
		
<!-- Daily Entry End -->




<script type="text/javascript">

function openreport()
{
var sector = document.getElementById('sector').value;
var empname = document.getElementById('empname').value;
var month = document.getElementById('month').value;
var year = document.getElementById('year').value;

   if( (sector =='Select') || (empname =='Select') || (month =='Select') || (year =='Select') )
   {
   alert('You have not selected SECTOR or EMPLOYEE NAME or MONTH or YEAR, Please select all these');
   }
  	else
	{   
    window.open('production/report3.php' + '?empname=' + empname + '&month=' + month+ '&year=' + year+ '&sector=' + sector); 
	}

}


function fun()
{
			  removeAllOptions(document.getElementById("empname"));
			  
			  myselect1 = document.getElementById('empname');
			  theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("Select");
			  theOption1.value = "Select";
			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);
			  
			  
			  if(document.getElementById("sector").value !="All")
			  {
<?php
	
     $q2=mysql_query("select distinct(sector) from hr_employee order by sector ASC");
	 
     while($nt2=mysql_fetch_array($q2)){
     echo "if(document.getElementById('sector').value == '$nt2[sector]'){";
     $q3=mysql_query("select distinct(name) from hr_employee where sector ='$nt2[sector]' order by name ASC");
	  
     while($nt3=mysql_fetch_array($q3))
	 { ?>
			 

              theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("<?php echo $nt3['name']; ?>");
			  theOption1.value = "<?php echo $nt3['name']; ?>";
			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);
			 
    <?php   } 
      echo "}"; 
     }
  ?>
  }
  else
  {
  	<?php
	     
     $q3=mysql_query("select distinct(name) from hr_employee order by name ASC");
	  
     while($nt3=mysql_fetch_array($q3))
	 { ?>
			 

              theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("<?php echo $nt3['name']; ?>");
			  theOption1.value = "<?php echo $nt3['name']; ?>";
			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);
			 
    <?php   } 
     
   ?>
  }
  <?php echo "
if(document.getElementById('sector').selectedIndex == 0)
{
			  removeAllOptions(document.getElementById('empname'));
			  myselect1 = document.getElementById('empname');
			  theOption1=document.createElement('OPTION');
			  theText1=document.createTextNode('Select');
			  theOption1.value = 'Select';
			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);
}
"; ?>
}


function removeAllOptions(selectbox)
{
<?php echo "
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.remove(i);
	}
	"; ?>
}

</script>
</fieldset>
</body>
</html>