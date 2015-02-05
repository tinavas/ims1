<?php
include "config.php";

$id=$_GET['id'];

$q1=mysql_query("set group_concat_max_len=10000000000");

$q1="select group_concat(areacode separator '$') as codes from distribution_area where id!='$id'";

$q1=mysql_query($q1) or die(mysql_error());

$r1=mysql_fetch_assoc($q1);

$allcodes=explode("$",$r1['codes']);

$allcodesj=json_encode($allcodes);

 $details="select * from distribution_area where id='$id'";

$details=mysql_query($details) or die(mysql_error());

$details=mysql_fetch_assoc($details);

//print_r($details);


//to get the all states and districts

$q3="SELECT state,group_concat(district separator '*') as districts FROM `state_districts` group by state";

$q3=mysql_query($q3) or die(mysql_error());

while($r3=mysql_fetch_assoc($q3))
{

$allstates[]=array("state"=>$r3['state'],"districts"=>$r3['districts']);

}


$allstatesj=json_encode($allstates);





?>

<script type="text/javascript">

var allcodesj=<?php echo $allcodesj;?>;

var allstatesj=<?php echo $allstatesj;?>;

</script>

<center>
<br/>
<h1>Edit Area</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
<div align="center">
<form name="areaform" id="areaform" action="distribution_savearea.php" method="post" onSubmit="return checkform()">

<input type="hidden" name="edit" value="1" />

<input type="hidden" name="oldid" value="<?php echo $id;?>" />

<table name="tab" id="tab">
<tr>
<td><strong>Area code<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>:</strong></td>
<td>&nbsp;&nbsp;&nbsp;<input type="text" name="areacode" id="areacode"  onblur="checkcode(this.id,this.value)" 
value="<?php echo $details['areacode'];?> " onkeyup="checkstring(this.id,this.value)" ></td>
<td><strong>&nbsp;&nbsp;&nbsp;Area Name<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>:</strong></td>
<td>&nbsp;&nbsp;&nbsp;<input type="text" name="areaname" id="areaname" value="<?php echo $details['areaname'];?> " onkeyup="checkstring(this.id,this.value)"></td>

</tr>
<tr style="height:20px"></tr>

<tr>
<td><strong>CNF/Super Stockist<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>:</strong></td>
<td>&nbsp;&nbsp;&nbsp;
<select name="superstockist" id="superstockist">
<option value="">-Select-</option>
<?php
$q1="select name from contactdetails where superstockist='YES'";
$q1=mysql_query($q1) or die(mysql_error());
while($r1=mysql_fetch_assoc($q1))
{
?>
<option value="<?php echo $r1['name'];?>" <?php if($details['superstockist']==$r1['name']){?> selected="selected" <?php  }?>><?php echo $r1['name'];?></option>

<?php }?>

</select>


</td>
<td><strong>State<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
<td>&nbsp;&nbsp;&nbsp;
<select name="state" id="state"  onchange="getdistricts(this.value)">
<option value="">-Select-</option>
<?php
$q1="SELECT distinct state FROM `state_districts`";
$q1=mysql_query($q1) or die(mysql_error());
while($r1=mysql_fetch_assoc($q1))
{
?>
<option value="<?php echo $r1['state'];?>"  <?php if($details['state']==$r1['state']){?> selected="selected" <?php  }?>><?php echo $r1['state'];?></option>

<?php }?>

</select></td>




<td><strong>&nbsp;&nbsp;&nbsp;District<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
<td>&nbsp;&nbsp;&nbsp;
<select name="district" id="district">
<option value="">-Select-</option>

<?php
for($k;$k<count($allstates);$k++)
{
if($allstates[$k]['state']==$details['state'])
{

$alldistricts=explode("*",$allstates[$k]['districts']);

for($c=0;$c<count($alldistricts);$c++)
{
?>

<option value="<?php echo $alldistricts[$c];?>" <?php if($details['district']==$alldistricts[$c]){?> selected="selected" <?php  }?>><?php echo $alldistricts[$c];?></option>

<?php }
 }
 
 } ?>




</select></td>




</tr>


</table>
<br/><br/><br/>
<input type="submit" value="Update" id="save">&nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" id="cancel" onClick="document.location='dashboardsub.php?page=distribution_area'">
</form>
<script type="text/javascript">

function checkform()
{

if(document.getElementById("areacode").value=="")
{
alert("Enter Area Code");
document.getElementById("areacode").focus();
return false;
}

if(document.getElementById("areaname").value=="")
{
alert("Enter Area Name");
document.getElementById("areaname").focus();
return false;
}

if(document.getElementById("superstockist").value=="")
{
alert("Select Super Stock List");
document.getElementById("superstockist").focus();
return false;
}


if(document.getElementById("state").value=="")
{
alert("Select State");
document.getElementById("state").focus();
return false;
}

if(document.getElementById("district").value=="")
{
alert("Select District");
document.getElementById("district").focus();
return false;
}

document.getElementById("save").disabled="true";
document.getElementById("cancel").disabled="true";

}

function checkcode(id,value)
{

for(i=0;i<allcodesj.length;i++)
{
if(allcodesj[i]==value)
{
alert("This Code Already exists");
document.getElementById(id).value="";
return false;
}
}
}


function checkstring(id,value)
{

var reg=new RegExp("^[0-9a-zA-z\ ]*$");

if(!reg.test(value))
 {

 alert("Enter Correct String (No Special Characters)");
 
 document.getElementById(id).value="";

 document.getElementById(id).focus();
 
	return false;
 
 
 }



}

function getdistricts(value)
{

document.getElementById("district").options.length=1;

for(i=0;i<allstatesj.length;i++)
{

if(allstatesj[i].state==value)

{
var alldistricts=allstatesj[i].districts.split("*");

for(j=0;j<alldistricts.length;j++)
{

var op=new Option(alldistricts[j],alldistricts[j]);

op.title=alldistricts[j];

document.getElementById("district").options.add(op);


}
}

}


}


</script>
</div>

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
