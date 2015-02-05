<script type="text/javascript">
function fcheckall()
{
 if(document.form1.checkall.checked)
  for(var i=0; i< document.form1.bims.length; i++)
   document.form1.bims[i].checked = true;
 else
  for(var i=0; i< document.form1.bims.length; i++)
   document.form1.bims[i].checked = false;
}

function changetitle(a)
{
 document.getElementById('title').value = a;
}
function changepid(a)
{
 if(a.length > 1)
  document.getElementById('pid').value = a.substr(0,(a.length-1));
 else
  document.getElementById('pid').value = ""; 
}
function checknumber(a)
{
 if(isNaN(a))
 {
  alert("Enter Integer");
  document.getElementById('sorder').value = "";
 }
}
function checkactive(a)
{
 var b = Number(a);
 if(b != 0 && b != 1)
 {
  alert("Active should be 0 or 1");
  document.getElementById('active').value = "";
 }
}

function validaterefid(a)
{
 var databases = "";
 for(var i=0; i< document.form1.bims.length; i++)
 {
  if(document.form1.bims[i].checked)
   databases += document.form1.bims[i].value + "*";
 }
 databases = databases.substr(0,(databases.length-1));
 document.getElementById("databases").value = databases; 
 if(databases == "")
 {
  alert("Please select atlest one of the databases");
  return false;
 }
 var tdata = a + "?" + databases;
 getdiv('validaterefid',tdata,'common_addlinksframe.php?data=');
}

function checkform()
{ 
 var databases = "";
 for(var i=0; i< document.form1.bims.length; i++)
 {
  if(document.form1.bims[i].checked)
   databases += document.form1.bims[i].value + "*";
 }
 databases = databases.substr(0,(databases.length-1));
 document.getElementById("databases").value = databases; 
 if(databases == "")
 {
  alert("Please select atlest one of the databases");
  return false;
 }

 if(document.getElementById("refid").value.length==0)
 {
  document.getElementById("refid").focus();
  alert("Enter Reference Id");
  return false;
 }
 
 if(document.getElementById("name").value.length == 0)
 {
  document.getElementById("name").focus();
  alert("Enter Name");
  return false;
 }
 
 if(document.getElementById("title").value.length == 0)
 {
  document.getElementById("title").focus();
  alert("Enter Title");
  return false;
 }
 
 if(document.getElementById("pid").value.length == 0)
 {
  document.getElementById("pid").focus();
  alert("Enter Parent Id");
  return false;
 }
 
 if(document.getElementById("link").value.length == 0)
 {
  document.getElementById("link").focus();
  alert("Enter Link");
  return false;
 } 
 else
 { 
  var link1 = document.getElementById("link").value;
  var a = link1.substr(0,1);
  if(a == 'd')
  {
   var temp = link1.substr(0,22);
   if(temp != "dashboardsub.php?page=")
   {
    document.getElementById("link").focus();
	alert("Invalid Link");
	return false;
   }
  }
  else if(a == 'p')
  {
   var temp = link1.substr(0,11);
   if(temp != "production/")
   {
    document.getElementById("link").focus();
	alert("Invalid Link");
	return false;
   }
  }
  else if(a == 'f')
  {
   var temp = link1.substr(0,12);
   if(temp != "flot/graphs/")
   {
    document.getElementById("link").focus();
	alert("Invalid Link: File should be placed in flot/graphs/");
	return false;
   }
  }
  else if(a == 'j') 
  {
   if(link1 != "javascript:void(0)")
   {
    document.getElementById("link").focus();
	alert("Invalid Link");
	return false;
   }
  }
  else
  {
   var html = link1.substr((link1.length-5),5);
   if(html != ".html")
   {
    alert("Invalid Link");
    document.getElementById("link").focus();
    return false;
   }	
  } 
 }
 
 if(document.getElementById("sorder").value.length == 0)
 {
  document.getElementById("sorder").focus();
  alert("Enter Sort Order Value");
  return false;
 }
 
 if(document.getElementById("active").value.length == 0)
 {
  document.getElementById("active").focus();
  alert("Enter Active Value");
  return false;
 }
 else
 {
  var temp = Number(document.getElementById("active").value);
  if(temp != 0 && temp != 1)
  {
   document.getElementById("active").focus();
   alert("Invalid Active Value");
   return false; 
  }
 }
 return true;
}

function loadtarget1(a)
{
 if(a == 1 || a == 2 || a == 3)
  document.getElementById("target").value = "";
 else
  document.getElementById("target").value = "new";
}

function loadtarget2(a)
{
  var link1 = document.getElementById("link").value;
  var a = link1.substr(0,1);
  if(a == 'd')
   document.getElementById("target").value = "new";
  else if(a == 'j')
   document.getElementById("target").value = "";
  else
   document.getElementById("target").value = "_NEW";
}
</script>
<body>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" name="form1" style="min-height:600px;" id="complex_form" method="post" onSubmit="return checkform(this);" action="dashboardsub.php?page=common_savelinks" >
	  <h1 id="title1">Add Link</h1>
		<div class="float-right"> 
		 <a href="production/common_links.php" target="_blank" class="button">Open Report</a>
		</div>
              <center>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)<br /><br /><br>
<table align="center">
<tr>
 <td colspan="3" align="center"><input type="checkbox" id="checkall" name="checkall" onClick="fcheckall();">&nbsp;&nbsp;Check All/UnCheck All</td>
</tr>
<tr height="20px"></tr>
<tr>
 <td colspan="3" align="center">	<!--VALUE IS DEFINED AS DB NAME @ CLIENT NAME-->
<?php
 $db_host = "localhost";

 $db_user = "poultry";

 $db_pass = "4(vQLs+#-b";

 $db_name = "users";

 $conn1=mysql_connect($db_host,$db_user,$db_pass)or die(mysql_error());
 mysql_select_db($db_name);
 $count = 0;
 $query = "SELECT * FROM bims ORDER BY client";
 $result = mysql_query($query,$conn1) or die(mysql_error());
 while($rows = mysql_fetch_assoc($result))
 { $count++;
  ?>
  <input type="checkbox" id="<?php echo $rows['db']; ?>" value="<?php echo $rows['db']."@".$rows['client']; ?>" name="bims">&nbsp;<?php echo $rows['name']; ?>
  <?php
  if($count == 10)
  {
   echo "<br/>";
   $count = 0;
  } 
 }
?>
 <input type="hidden" id="databases" name="databases" value="">
 </td>
</tr> 
<tr height="20px"></tr>
</table>

<table align="center">
<tr>
 <td align="right"><strong>Ref Id<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>
 <td align="left"><input type="text" id="refid" name="refid" onKeyUp="changepid(this.value);" onBlur="validaterefid(this.value);" /></td>
</tr>
<tr height="10px"></tr>
<tr>
 <td align="right"><strong>Icon<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>
 <td align="left">
  <select id="icon" name="icon" style="width:120px;">
<?php
 $db_host = "localhost";

 $db_user = "poultry";

 $db_pass = "4(vQLs+#-b";

 $db_name = "souza";

 $conn=mysql_connect($db_host,$db_user,$db_pass)or die(mysql_error());
 mysql_select_db($db_name);

  $q = "SELECT distinct(icon) FROM common_links ORDER BY icon";
  $r = mysql_query($q,$conn) or die(mysql_error());
  while($rows = mysql_fetch_assoc($r))
  {
   ?>
   <option value="<?php echo $rows['icon']; ?>"><?php echo $rows['icon']; ?></option>
   <?php
  }
 ?> 
  </select>
 </td>
</tr>
<tr height="10px"></tr>
<tr>
 <td align="right"><strong>Name<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>
 <td align="left"><input type="text" id="name" name="name" onKeyUp="changetitle(this.value);" /></td>
</tr>
<tr height="10px"></tr>
<tr>
 <td align="right"><strong>Title<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>
 <td align="left"><input type="text" id="title" name="title" /></td>
</tr>
<tr height="10px"></tr>
<tr>
 <td align="right"><strong>Parent Id<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>
 <td align="left"><input type="text" id="pid" name="pid" /></td>
</tr>
<tr height="10px"></tr>
<tr>
 <td align="right"><strong>Step<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>
 <td align="left">
  <select id="step" name="step" style="width:120px;" onChange="loadtarget1(this.value);">
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4" selected="selected">4</option>
  </select>
 </td>
</tr>
<tr height="10px"></tr>
<tr>
 <td align="right"><strong>Link<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>
 <td align="left"><input type="text" id="link" name="link" size="40" onBlur="loadtarget2(this.value);" /></td>
</tr>
<tr height="10px"></tr>
<tr>
 <td align="right"><strong>Sort Order<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>
 <td align="left"><input type="text" id="sorder" name="sorder" onKeyUp="checknumber(this.value)" /></td>
</tr>
<tr height="10px"></tr>
<tr>
 <td align="right"><strong>Active<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>
 <td align="left"><input type="text" id="active" name="active" value="1" onKeyUp="checkactive(this.value);" /></td>
</tr>
<tr height="10px"></tr>
<tr>
 <td align="right"><strong>Target<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>
 <td align="left">
  <select id="target" name="target" style="width:120px;">
  <option value="">&nbsp;</option>
  <option value="new">new</option>
  <option value="_NEW" selected="selected">_NEW</option>
  </select>
 </td>
</tr>
<tr height="20px"></tr>
<tr>
 <td colspan="3" align="center"> 
 <input type="submit" value="Save" id="Save" />&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=data1'">
 </td>
</tr>
</table><br><br><br>

<div id="validaterefid"></div><br>
<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> The link and reference id are added into the table iff the parent id is existing for that user.
</center>
</form>
</div>
</section>
</body>
</html>