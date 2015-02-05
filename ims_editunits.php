<script type="text/javascript">

<?php include "config.php"; 
$fromunits=$_GET["fromunits"];
$tounits=$_GET["tounits"];
$conunits=$_GET["conunits"];
$id=$_GET["id"];
?>

</script>

<?php session_start();?>
<center>

<br />

<h1>Conversion Units</h1>

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br/><br/><br />

<form id="form1" name="form1" method="post" action="ims_updateunits.php"  onsubmit="return checkform(this);">
<center><input type="hidden" id="sead" name="sead"  value="1" />
<input type="hidden" id="id" name="id"  value="<?php echo $id;?>" />
<table align="center" >
  <tr>
	<td width="100" align="right"><strong>From Units</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
	<td width="100" align="left">
    <select style="Width:100px" name="fromunits" id="fromunits" >
	<option value="">-Select-</option>
	<?php include "config.php"; 
	$q2="select distinct(sunits) from ims_itemunits WHERE client = '$client' order by sunits ASC"; $r2 = mysql_query($q2,$conn);
	while($nt2=mysql_fetch_assoc($r2))
	{ ?>
	<option value="<?php echo $nt2['sunits']; ?>" <?php if($fromunits==$nt2['sunits']) { ?> selected="selected" <?php } ?>><?php echo $nt2['sunits']; ?></option>
	<?php } ?>
	</select>
	</td>
    <td width="100" align="right"><strong>To Units</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
	<td width="100" align="left">
    <select style="Width:100px" name="tounits" id="tounits" >
	<option value="">-Select-</option>
	<?php include "config.php"; 
	$q2="select distinct(sunits) from ims_itemunits WHERE client = '$client' order by sunits ASC"; $r2 = mysql_query($q2,$conn);
	while($nt2=mysql_fetch_assoc($r2))
	{ ?>
	<option value="<?php echo $nt2['sunits']; ?>" <?php if($tounits==$nt2['sunits']) { ?> selected="selected" <?php } ?>><?php echo $nt2['sunits']; ?></option>
	<?php } ?>
	</select>
	</td>
     <td width="100" align="right"><strong>Conversion Unit</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
	<td  align="left">
    <input type="text" id="conunits" name="conunits" value="<?php echo $conunits;?>" size="10"  onkeyup="validatecode(this.id,this.value);" />
	</td>
 </tr>
 <tr height="10px">
 <td height="3"></td>
 </tr>
 <tr>
 <td colspan="6" align="center"><br />
 <center>
 <input name="submit" type="submit" value="Update" />
 &nbsp;&nbsp;&nbsp;
 <input name="button" type="button" onclick="document.location='dashboardsub.php?page=ims_units';" value="Cancel" />
 </center>
 </td>
</tr>
</table>

  </center>

  <br />

  <br /><br />

</form>



<script language="JavaScript" type="text/javascript">

function checkform ( form )

{
if (form.fromunits.value == "") 
   {
    alert( "Please Select From Units." );
    form.fromunits.focus();
    return false ;
   }
if (form.tounits.value == "") 
   {
    alert( "Please Select To Units." );
    form.tounits.focus();
    return false ;
   }
   if (document.getElementById("conunits").value == "" ) 
   {
    alert( "Please Enter Conversion Units." );
    document.getElementById("conunits").focus();
    return false ;
   }
    return true;

}


</script>

<script type="text/javascript">

function script1() {

window.open('IMSHelp/help_m_additemmaster.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=YES,resizable=yes');

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