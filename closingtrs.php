<?php include "jquery.php";
?>
<center>

<br />

<h1>Close & Transactions</h1> 

<br /><br /><br />

<form method="post" action="c1.php" id="form1" name="form1">


<br/>
<table align="center" >
<tr>

<td align="right"><strong>Till&nbsp; Date&nbsp;&nbsp;</strong></td>

<td width="10px"></td>

<td align="left"><input type="text" size="15" id="date2" class="datepicker" name="date2" value="<?php echo $fromdate; ?>" onChange="datecomp();"  ></td>


</tr>

</table>

<br/><br/>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type="submit" id="report" value="Check Ready" />

</form>

</center>
<script type="text/javascript">
function chkready()
{

}
</script>


</body>
</html>