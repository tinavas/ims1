<?php 
include "jquery.php"; 
include "config.php";
 include "getemployee.php";
?>

<center>
<br />
<h1>   CHANGING  &nbsp; EMAIL-ID</h1>
<br /><br />
<form id="form1" name="form1" method="post" action="savemailid.php" >

<table border="0"  align="center">
   
<tr style="height:30px"></tr>   
<tr align="center">
  <td>
<input type = "hidden" name = " username" id = "username" value = "<?php echo $_SESSION['valid_user'];?>" /></td>

 <td>
<input type = "hidden" name = " dbemail" id = "dbemail" value = "<?php echo $_SESSION['valid_email'];?>" /></td>


<tr>
<td width="10px">&nbsp;</td>
<td><strong>Previous Email-id</strong>&nbsp;&nbsp;</td>
<td>
<input type="text"  name="pemail" id="pemail" size="40" onblur = "ve(this.id);"  />
</td>

</tr>
 <tr style="height:30px"></tr>    
<tr>


<td width="10px">&nbsp;</td>
<td><strong>New Email-id</strong>&nbsp;&nbsp;</td>
<td>
<input type="text"  name="nemail" id="nemail" size="40" /></td>

</tr>
</table>
<br/>

<br/>
<table align="center">

<tr>
<td colspan="5" align="center">
<center>
<input type="submit" value="Save" id="Save"  name="Save"/>&nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=';">

</center>
</td>
</tr>
</table>
</form>
<script type="text/javascript">
function ve(a)
{

var r = document.getElementById('dbemail').value;


var y = document.getElementById('pemail').value;

if(r!=y)
{
alert("enter correct previous emailid");
document.getElementById('pemail').value="";
}

}
</script>
</body>
</html>
