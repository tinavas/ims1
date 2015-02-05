<?php
include "config.php";
?>
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
<div align="center">
<?php
if(isset($_GET['error']))
{
if($_GET['error']==1)
{?>
<h4 style="color:#FF0000">Select Valid Year and Month</h4>
<?php 
}
}
?>
<br/><br/>
<form  method="post" action="logimport.php" onsubmit="return check()">
<strong>Select Month</strong>
<select name="month" id="month">
<option value="">-Select-</option>
<option value="01">JAN</option>
<option value="02">FEB</option>
<option value="03">MAR</option>
<option value="04">APR</option>
<option value="05">MAY</option>
<option value="06">JUN</option>
<option value="07">JUL</option>
<option value="08">AUG</option>
<option value="09">SEP</option>
<option value="10">OCT</option>
<option value="11">NOV</option>
<option value="12">DEC</option>
</select>&nbsp;&nbsp;&nbsp;

<strong>Select Year</strong><select name="year" id="name">
<option value="">-Select-</option>
<?php
$sql="SELECT distinct(left(amy,4)) as year FROM `logregister`";
$q1=mysql_query($sql);
while($r=mysql_fetch_array($q1))
{?>

<option value="<?php echo $r['year'];?>"><?php echo $r['year'];?></option>

<?php }?>
</select>



<br/><br/><br/><br/>
<input type="submit" value="Get Excel" id="sub">
</form>
</div>
<script type="text/javascript">
function check()
{
//alert("dsdf");
//alert(document.getElementById("year").value);
if(document.getElementById("year").value=="")
{
alert("Select year");
document.getElementById("year").focus();
return false;

}

if(document.getElementById("month").value=="")
{
alert("Select month");
document.getElementById("month").focus();
return false;

}
//document.getElementById("sub").disabled=true;




var month=document.getElementById("month").value;
var year=document.getElementById("year").value;
var my=year+"-"+month;


var dd="<?php echo date("Y-m-d");?>";
var dd1=dd.split("-");
var dform=dd1[0]+"-"+dd1[1];
//alert(dform);
if(dform==my)
{
return true;
}


var flag=0;

<?php
$sql=mysql_query("select left(amy,7) as my from logregister;");
while($r=mysql_fetch_array($sql))
{?>
if(my=="<?php echo $r['my'];?>")
{
flag=1;
}
<?php }?>
if(flag==0)
{
alert("Select previous or current month and year ");
return false;
}




}

</script>