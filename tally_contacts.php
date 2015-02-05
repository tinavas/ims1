<script type="text/javascript">
function checkform()
{
 var a = document.getElementById("excel_file").value;
 if(a == "")
 {
  alert("Please select the file");
  return false;
 }
 else
 {
  var temp = a.substr(a.length-4);
	  if(temp != ".xls")
	  {
	   alert("Incorrect file selected");
	   document.getElementById("excel_file").value = "";
	   return false;
	  }
  return true;
 } 
}
</script>

<section class="grid_8">
  <div class="block-border">
     <form class="block-content  form" id="complex_form"style="height:500px" enctype="multipart/form-data" method="post" onsubmit="return checkform();" <?php if($_SESSION[db]=='albustan' || $_SESSION['db'] == "albustanlayer" ) { ?> action="dashboardsub.php?page=import_contacts_codes"  <?php } else { ?> action="dashboardsub.php?page=import_contacts" <?php } ?> >
	  <h1 id="title1">Import Contacts</h1>
		
              <center>

<br />
<table id="tab1" align="center" width="750px">
<tr>
 <td align="center"><strong>Instructions for Importing Contacts</strong></td>
</tr>
<tr height="15px"></tr>
<tr align="left">
 <td> 1. The Excel file should be in 2003 format only.</td>
</tr>
<tr height="15px"></tr>
<tr align="left">
 <td> 2. The order of the columns should be same as in Sample Format File</td>
</tr>
<tr height="15px"></tr>
<tr align="left">
 <td> 3. No other data should be there in the excel file except the data that is to be entered into the software.</td>
</tr>
<tr height="15px"></tr>
<tr align="left">
 <td> 4. The first row in the excel file should contain the header names.</td>
</tr>
<tr height="15px"></tr>
<tr align="left">
 <td> 5. The data should start from 2nd row onwards. Please dont give empty rows in the middle of the data</td>
</tr> 
<tr height="15px"></tr>
<tr align="left">
 <td> 6. You can also download the sample format <input type="button" value="Download" <?php if($_SESSION[db]=='albustan' || $_SESSION['db'] == "albustanlayer") { ?> onclick="document.location='./P2PHelp/Contacts_code.xls'" <?php } else { ?> onclick="document.location='./P2PHelp/Contacts.xls'" <?php } ?>  />  </td>
</tr> 
<tr height="15px"></tr>
<tr align="center">
 <td><strong>Excel File</strong>&nbsp;&nbsp;<input type=file id="excel_file" name="excel_file"></td>
</tr> 
<tr height="30px"></tr>
<tr align="center">
 <td><input type="submit" value="Import" id="import" name="import" />&nbsp;<input type="button" value="Cancel" onClick="javascript: history.go(-1)" /></td>
</tr> 
</table>

</center>
</form>

</div>
</section>
	<footer>
		<div class="float-left">
			<a href="#" class="button" onClick="script1()">Help</a>
			<a href="javascript:void(0)" class="button">About</a>
			<a href="./P2PHelp/Contacts.xls" class="button" >Contacts Sample Format</a>
		</div>
		<div class="float-right">
			<a href="#top" class="button"><img src="images/icons/fugue/navigation-090.png" width="16" height="16"> Page top</a>
		</div>
		
	</footer>
<script type="text/javascript">
function script1() {

}
</script>
