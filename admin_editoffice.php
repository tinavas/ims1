

<center>
<h1>Offices</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/>
<form method="post" action="admin_updateoffice.php?id=<?php echo $_GET['id']; ?>" onSubmit="return checkform(this);">
<table>
<?php include "config.php"; $query1 = "SELECT * FROM tbl_sector where id = $_GET[id] ORDER BY id ASC "; 
      $result1 = mysql_query($query1,$conn); while($row1 = mysql_fetch_assoc($result1)) { ?>        
<tr>
<td align="right"><strong>Location Name</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" name="name" value="<?php echo $row1['sector']; ?>" size="33" /></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
<td align="right"><strong>Location Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td align="left">
      
	  
	  <select name="type" id="type" style="width:200px;">
<option value="">-Select-</option>

		<option value="Administration Office"<?php if($row1['type1']=="Administration Office"){?> selected="selected" <?php  } ?>>Administration Office</option>
		<option value="Dispatch Location" <?php if($row1['type1']=="Dispatch Location"){?> selected="selected" <?php  } ?>>Dispatch Location</option>
		
		<option value="Head Office" <?php if($row1['type1']=="Head Office"){?> selected="selected" <?php  } ?>>Head Office</option>
		<option value="Sales Office" <?php if($row1['type1']=="Sales Office"){?> selected="selected" <?php  } ?>>Sales Office</option>
		<option value="Warehouse" <?php if($row1['type1']=="Warehouse"){?> selected="selected" <?php  } ?>>Warehouse</option>
      </select>	   </td>
</tr>
<tr height="10px"><td></td></tr>
					 
					
<?php
}
?>
</table>
<br /><br />
<input type="submit" value="Update" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=admin_office';">

</form>
</center>



<script language="JavaScript" type="text/javascript">


function checkform ( form )
{
var numericExpression = /^[0-9]+$/;
    if (form.name.value == "") {
    alert( "Please enter Name." );
    form.name.focus();
    return false ;
  }
 
  return true ;
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

</script>
<script type="text/javascript">
function script1() {
window.open('IMSHelp/help_m_editoffice.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
