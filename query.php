		<div class="float-right"> 
		 <a href="production/common_links.php" target="_blank" class="button">Open Report</a>
		</div>

<?php echo "<font style='color:#FF0000'><b><center><br>".$_GET[status]."</center></b></font>";  ?>
<form method="post" name="form1" onSubmit="return checkform(this);"  action="query_BE.php" >

<table align="center">
<tr height="20px"></tr>
<tr>
 <td colspan="3" align="center"><input type="checkbox" id="checkall" name="checkall" onClick="fcheckall();">&nbsp;&nbsp;Check All/UnCheck All</td>
</tr>
<tr height="20px"></tr>

<tr>
 <td colspan="3" align="center">	<!--VALUE IS DEFINED AS DB NAME @ CLIENT NAME-->
<?php
 $db_host = "localhost";
 $db_user = "poultry";
 $db_pass = "tulA0#s!";
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
 <td align="left"><strong>Query :</strong></td>
</tr>
<tr height="5px"></tr>
<tr> 
 <td align="center">
 <textarea id="query" cols="100" rows="10" name="query"><?php  if($_GET['count'] > 0) { echo $_GET['query']; }  ?></textarea><br /></td>
</tr>
<tr height="5px"></tr>
<tr><td><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> At a time, only 1 Query should be executed.</td></tr>
<tr> 
 <td align="right"><input onSubmit="return checkform(this);" type="submit" value="Execute"/></td>
</tr>
</table>

</form>

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

function checkform()
{ 
    if(document.getElementById("query").value=="")
     {
	 alert("Query must not be empty");
	 return false;
	 }
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
	 
	 
	 if(confirm("ARE YOU SURE TO EXECUTE"))
	  return true;
	 else
	  return false;
	 
}
</script>