
<?php 
include "jquery.php"; 
include "config.php";

$query="select * from tbl_profitcenter ";
$result=mysql_query($query);
$num_rows=mysql_num_rows($result);
while($row=mysql_fetch_assoc($result))
  $cc.=$row['costcenter'].','; 
$cc=explode(',',$cc);
$i=0;
while($cc[$i]) $cc1.="'".$cc[$i++]."',";
$cc=substr($cc1,0,-1);
?>
<script>
function validate()
{
if(document.getElementById('pc').value=='@@'){ alert('Select Profit Center');
 return false; }
 if(document.getElementById('fdate').value==''){ alert('Select Fromdate');
 return false; }
if(document.getElementById('tdate').value==''){ alert('Select Todate');
 return false; }
 if(document.getElementById('units').value==''){ alert('Enter Units');
 return false; }

 return true;
}
function onlynum(units,id)
{
if(isNaN(units)) { 
alert('Must be a integer number'); 
document.getElementById(id).value=units.substr(0,units.length-1);
}
}
function getcat(cat)
{
cat=cat.split('@');
document.getElementById('icat').value=cat[1];
document.getElementById('ocat').value=cat[2];
}
</script>
<center>
<br />
<h1><strong>Input Output Ratio</strong></h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br /><br />
<form id="form1" name="form1" method="post" onsubmit="return validate()" action="common_saveioratio.php" >
     
 <table border="0" id="tab">
     <tr style="height:20px"></tr>
<tr>
<td align="right" style="vertical-align:middle">
<strong>Profit Center</strong> <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>
<td width="5px"></td>
<td align="left" >
<select id="pc" name="pc" onchange="getcat(this.value)">
<option value="@@">-Select-</option>
<?php  
$query = "select distinct(profitcenter) as sector,inputcat,outputcat from tbl_profitcenter order by profitcenter";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 ?>
 <option value="<?php echo $rows['sector']; ?>@<?php echo $rows['inputcat']; ?>@<?php echo $rows['outputcat']; ?>" title="<?php echo $rows['sector']; ?>"><?php echo $rows['sector']; ?></option>
 <?php } ?>
</select>
</td>
<td width="5px"></td>
<td style="vertical-align:middle">&nbsp;

</td>
<td width="5px"></td>
<td style="vertical-align:middle">&nbsp;
</td>
 </tr>
 
 <tr style="height:20px"></tr>
<tr >
<td align="right">
<strong>Input Category</strong> <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>
<td width="5px"></td>
<td align="left">
<input type="text" readonly name="icat" id="icat" />
</td>
<td width="5px"></td>
<td align="right">
<strong>Output Category</strong> <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>
<td width="5px"></td>
<td align="left">
<input type="text" readonly name="ocat" id="ocat" />
</td>
 </tr>
  <tr style="height:20px"></tr>
<tr >
<td align="right">
<strong>From Date</strong> <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>
<td width="5px"></td>
<td align="left" >
<input type="text" class="datepicker" readonly name="fdate" id="fdate" />
</td>
<td width="5px"></td>
<td align="right" >
<strong>To Date</strong> <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
</td>
<td width="5px"></td>
<td align="left">
<input type="text" class="datepicker" readonly name="tdate" id="tdate" />
</td>
 </tr>
 <tr height="20px"></tr>
 <tr><td align="center" colspan="7"><strong>Tentitive Output units per 100 Input units <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>&nbsp;&nbsp;<input onkeyup="onlynum(this.value,this.id)" type="text" id="units" name="units"  /></td></tr>
   </table>
   <br /> 
 </center>

<br />			

<center>	


   <br />
   <input type="submit" value="Save" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=common_ioratio';">
</center>


						
</form>


	<footer>
		<div class="float-left">
			<a href="#" class="button" onClick="script1()">Help</a>
			<a href="javascript:void(0)" class="button">About</a>
		</div>


		
		<div class="float-right">
			<a href="#top" class="button"><img src="images/icons/fugue/navigation-090.png" width="16" height="16"> Page top</a>
		</div>
		
	</footer>


</body>
</html>

