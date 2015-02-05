<?php include "config.php";       
      include "jquery.php"; 
      include "getemployee.php";
?>
<center>
<br />
<h1>Bank/Cash Codes</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
</center>
<form name="abt" >
<table border="0" align="center">
<tr>
 <td><input type="radio" id="cash" name="cb" value="cash" onclick="loadframe();"/>&nbsp;&nbsp;&nbsp; <strong>Cash</strong> </td>
 <td>&nbsp;&nbsp;&nbsp;<input type="radio" id="bank" name="cb" value="bank" onclick="loadframe();"/>&nbsp;&nbsp;&nbsp; <strong>Bank</strong></td></tr>
<?php
session_start();
if(($_SESSION['db'] == 'feedatives') or ($_SESSION['db'] == "fortress"))
{ 
?>
<tr height="10px"><td>&nbsp;</td></tr>
<tr>
 <td align="right">&nbsp;&nbsp;&nbsp;<strong>Sector </strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;</td>
 <td align="left">&nbsp;&nbsp;
   <select name="sector" id="sector" style="width:150px;">
           <option>-Select-</option>

	<?php
              include "config.php"; 
			  if($_SESSION['db'] == "feedatives"){
              $query = "SELECT sector FROM tbl_sector WHERE type1 <> 'Warehouse' AND type1 <> 'Integration' AND client = '$client' ORDER BY sector ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
           <option value="<?php echo $row1['sector']; ?>"><?php echo $row1['sector']; ?></option>
           <?php } ?>
	<?php
              $query = "SELECT distinct(place) FROM broiler_farm WHERE client = '$client' ORDER BY place ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
           <option value="<?php echo $row1['place']; ?>" title="<?php echo $row1['place']; ?>"><?php echo $row1['place']; ?></option>
           <?php }
		   }
		   else
		   {
		    $query = "SELECT * FROM tbl_sector WHERE type1='Head Office' or type1='Chicken Center' or type1='Egg Center' order by sector";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
           <option value="<?php echo $row1['sector']; ?>"><?php echo $row1['sector']; ?></option>
           <?php } 
		   } ?>
		   
         </select>

 </td>
</tr>
<?php
}
?>

 
 </tr>
</table>
</form>
<iframe id="myIframe" allowtransparency="true" style="background:none;" src="dummy.html" width="100%" height="350" scrolling="no" frameborder="0" marginheight="0" marginwidth="0"></iframe>

<script type="text/javascript">
function loadframe()
{
	if(document.getElementById('cash').checked == true)
	var mode = "Cash";
	else
	var mode = "Bank";
	document.getElementById('myIframe').src = "ac_addbankcashmastersInsert.php?mode=" + mode;
}
</script>


<script type="text/javascript">
function script1() {
window.open('GLHelp/help_m_addbankcashmaster.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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