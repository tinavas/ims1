<?php

include "config.php";
include "timepicker.php";

if($_GET['date']<>"")
{
$date=date("",strtotime($_GET['date']));
}
else
{
$date=date("d.m.Y");
}







?>

<div align="center">
<h1>Asset Identification</h1>

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br/><br/><br />

<form name="identification"  method="post" onSubmit="return checkform()" >

<strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;
<input type="text" name="date" id="date" class="datepicker" style="Width:80px" value="<?php echo $date;?>">

<strong>Location</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;
<select name="location" id="location" style="Width:100px" onChange="reloadpage('location')">
<option value="">-Select-</option>
<?php
$q1="select distinct warehouse from pp_sobi where flag=1 and assetcategory!='' and assetcategory is not null";
$q1=mysql_query($q1) or die(mysql_error());
while($r1=mysql_fetch_assoc($q1))
{
?>
<option value="<?php echo $r1['warehouse'];?>" title="<?php echo $r1['warehouse'];?>"><?php echo $r1['warehouse'];?></option>
<?php }?>




</select>&nbsp;&nbsp;

<strong>Asset Category</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;

<select name="category" id="category" style="Width:100px" onChange="reloadpage('category')">
<option value="">-Select-</option>
</select>&nbsp;&nbsp;

<strong>Asset Class</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;

<select name="class" id="class" style="Width:100px" onChange="reloadpage('class')">
<option value="">-Select-</option>
</select>&nbsp;&nbsp;


<strong>Asset Subclass</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;

<select name="subclass" id="subclass" style="Width:100px" onChange="reloadpage('subclass')">
<option value="">-Select-</option>
</select>&nbsp;&nbsp;

<strong>SOBI</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;

<select name="sobi" id="sobi" style="Width:100px" onChange="reloadpage('sobi')">
<option value="">-Select-</option>
</select>&nbsp;&nbsp;

<strong>Quantity</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;

<input type="text" name="quantity" id="quantity" value="0" style="Width:50px">

</form>


</div>
<script type="text/javascript">
function reloadpage(value)
{
if(value=="category")
{
var category=document.getElementById("category").value;
document.location="document.location='dashboardsub.php?page=fa_asset'";
}





}


</script>