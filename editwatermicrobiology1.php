<?php
include "jquery.php"; 
include "config.php";

$id= $_GET['id'];
$tid=$_GET['tid'];


$query1 = "SELECT * FROM watermicrobiology where tid = '$tid'";
$result1 = mysql_query($query1,$conn); 
while($row1 = mysql_fetch_assoc($result1))
{
    $id =  $row1['id'];
$tid = $row1['tid'];
$sdate = $row1['sampledate'];
$rdate = $row1['reportdate'];
$ftype = $row1['farmtype'];
$fname = $row1['farmname'];
$sample1 = $row1['sample'];
$ecoil = $row1['ecoil']; 
$ph = $row1['ph'];
$hardness = $row1['hardness'];
$remarks = $row1['remarks'];
}
?>
<body onLoad= "loadfnames('<?php echo $ftype;?>');">
	<center>
	 <br/>
	  <h1>Edit Water Micro Biology</h1>
	  (Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
</center>
		
		<form id="form1" name="form1" method="post" action="updatewatermicrobiology.php" onSubmit="return checkform(this);" >
<table align="center">



             <input type = "hidden" id= "id" name = "id" value = "<?php echo $id;?>"/>

<input type = "hidden" id= "tid" name = "tid" value = "<?php echo $tid;?>"/>

<tr>
                <td><strong>sample Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;<input class="datepicker" type="text" size="15" id="sampledate" name="sampledate" value="<?php echo date("d.m.Y",strtotime($sdate)); ?>"></td>
                <td width="40px"></td>
 <td><strong>Report Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;<input class="datepicker" type="text" size="15" id="reportdate" name="reportdate" value="<?php echo date("d.m.Y",strtotime($rdate)); ?>"></td>
<td width="40px"></td>
<td><strong>Sample Number</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;<input type="text" size="12" id="samplenum" name="samplenum" value="<?php echo $tid;?>" ></td>
               
</tr>
</table>
<br/>
<br/>
<table border="0" align="center">

     <tr>
    <td><strong>Farm Type</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td style="text-align:left;">
      <select style="Width:120px" name="ftype" id="ftype"  onchange="loadfnames(this.value);"  >
        <option value="">-Select-</option>
<option value= "Breeder"<?php if($ftype == 'Breeder') {?> selected="selected" <?php }?>>Breeder</option>
<option value = "Hatchery"<?php if($ftype == 'Hatchery') {?> selected="selected" <?php }?>>Hatchery</option>
<option value="Broiler"<?php if($ftype == 'Broiler') {?> selected="selected" <?php }?>>Broiler</option>

</select>
				</td>
				 <td width="40px"></td>

                
                <td><strong>Farm Name</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>

					<td style="text-align:left;">
      <select style="Width:120px" name="fname" id="fname">
        <option value="">-Select-</option>
<?php
if($ftype == 'Breeder')
{
		$query = "select distinct(shedcode),sheddescription from breeder_shed where client = '$client' order by shedcode";

    $result = mysql_query($query) or die(mysql_error());
    while($qr = mysql_fetch_assoc($result))
    {
	if ( $qr['shedcode'] == $fname)
	{
	?>
	<option value="<?php echo $qr['shedcode'];?>" selected="selected" ><?php echo $qr['shedcode'];?></option>
<?php } else { ?>
<option value="<?php echo $qr['shedcode'];?>"><?php echo $qr['shedcode']; ?></option>
<?php   } }  }?>

<?php
if($ftype == 'Hatchery')
{
 $query1 = "select distinct(type) from tbl_sector where type1='Hatchery' and client = '$client'";
    $result1 = mysql_query($query1) or die(mysql_error());
    while($qr1 = mysql_fetch_assoc($result1))
    {
if ( $qr1['type'] == $fname)
	{
	?>
	<option value="<?php echo $qr1['type'];?>" selected="selected" ><?php echo $qr1['type'];?></option>
<?php } else { ?>
<option value="<?php echo $qr1['type'];?>"><?php echo $qr1['type']; ?></option>
<?php   }  } }?>
<?php
if($ftype == 'Broiler')
{
  $query = "select distinct(farm) from broiler_farm and client = '$client'";
    $result = mysql_query($query) or die(mysql_error());
    while($qr = mysql_fetch_assoc($result))
    {

if ( $qr['farm'] == $fname)
	{
	?>
	<option value="<?php echo $qr['farm'];?>" selected="selected" ><?php echo $qr['farm'];?></option>
<?php } else { ?>
<option value="<?php echo $qr['farm'];?>"><?php echo $qr['farm']; ?></option>
<?php   }  } }?>
		
					</select>
				</td>
			             
				
              </tr>
            </table>
<br /><br />


<center>
 <table border="0" id="tab">
     <tr>
<th><strong>Sample</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>Ecoil(MNP/100ml)</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>PH</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>Hardness</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>

     </tr>

     <tr style="height:20px"></tr>
	 
	
<?php 
	$q = "select * from watermicrobiology where tid= '$tid'";
	
$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
$x = $qr['sample'];
?>
	 <tr>
	  <td style="text-align:left;">
<select style="Width:120px" name="sample[]" id="sample@-1">
     <option>-Select-</option>
     <option value= "Borewell Water"<?php if($x == 'Borewell Water') {?> selected="selected" <?php }?>>Borewell Water</option>
<option value = "Openwell Water"<?php if($x == 'Openwell Water') {?> selected="selected" <?php }?>>Openwell Water</option>
<option value="MainTank Water"<?php if($x == 'MainTank Water') {?> selected="selected" <?php }?>>MainTank Water</option>
<option value = "PipeLine Water"<?php if($x == 'PipeLine Water') {?> selected="selected" <?php }?>>PipeLine Water</option>
<option value = "Drinking Water"<?php if($x == 'Drinking Water') {?> selected="selected" <?php }?>>Drinking Water</option>
<option value="Other Water"<?php if($x == 'Other Water') {?> selected="selected" <?php }?>>Other Water</option>
</select>
       </td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="10" id="ecoil@-1" name="ecoil[]" value="<?php echo $qr['ecoil']; ?>" />
</td>
<td width="10px">&nbsp;</td><td>

<input type="text" size="10" id="ph@-1" name="ph[]" value="<?php echo $qr['ph']; ?>" />
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="10" style="text-align:left;" id="hardness@-1" name="hardness[]" value="<?php echo $qr['hardness']; ?>" onFocus="makeform();" />
</td>
	 </tr>
<?php } ?>
<td style="text-align:left;">
<select style="Width:120px" name="sample[]" id="sample@-1">
     <option value="">-Select-</option>
     <option value="Borewell Water">Borewell Water </option>
<option value="Openwell Water">Openwell Water</option>
<option value="MainTank Water">MainTank Water</option>
<option value="PipeLine Water">PipeLine Water</option>
<option value="Drinking Water">Drinking Water</option>
<option value="Other Water">Other Water</option>
</select>
       </td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="10" id="ecoil@-1" name="ecoil[]" value="" />
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="10" id="ph@-1" name="ph[]" value="" />
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="10" id="hardness@-1" name="hardness[]" value="" onFocus="makeform();"/>
</td>

	 
</table>
</br>

 </center>
<br />			

<table border="0"  align="center">
 <tr style="height:10px"></tr> 
<tr>
<td style="vertical-align:middle;"><strong>Remarks</strong>&nbsp;&nbsp;&nbsp;</td>
<td><textarea rows="3" cols="50" id="remarks" name="remarks"></textarea></td>
</tr>
</table>
<center>	


   <br />
   <input type="submit" value="Update" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=watermicrobiology';">
</center>


						
</form>



   		
<script type="text/javascript">
var index = -1;

function loadfnames(a)
{

if(a== "Breeder")
{

var item1 = a;
removeAllOptions(document.getElementById('fname'));
myselect1 = document.getElementById("fname");
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "fname";
myselect1.style.width = "170px";


<?php 
	    $query = "select distinct(shedcode),sheddescription from breeder_shed order by shedcode";

    $result = mysql_query($query) or die(mysql_error());
    while($qr = mysql_fetch_assoc($result))
    {

	echo "if(item1 == 'Breeder') {";
?>
	theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['shedcode']; ?>");
theOption1.value = "<?php echo $qr['shedcode']; ?>";
<?php if($fname == $qr['shedcode']) { ?>
theOption1.selected= 'select';
<?php } ?>
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

<?php echo "}"; ?>

<?php }  ?>	 
}
if(a=="Hatchery")
{
var item2 = a;

removeAllOptions(document.getElementById('fname'));
myselect1 = document.getElementById("fname");
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "fname";
myselect1.style.width = "170px";


<?php 
	    $query1 = "select distinct(type) from tbl_sector where type1='Hatchery'";
    $result1 = mysql_query($query1) or die(mysql_error());
    while($qr1 = mysql_fetch_assoc($result1))
    {

	echo "if(item2 == 'Hatchery') {";
?>
	theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr1['type']; ?>");
theOption1.value = "<?php echo $qr1['type']; ?>";
<?php if($fname == $qr1['type']) { ?>
theOption1.selected='select';
<?php } ?>

theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

<?php echo "}"; ?>


<?php }  ?>	 

}
if(a=="Broiler")
{

var item3 = a;

removeAllOptions(document.getElementById('fname'));
myselect1 = document.getElementById("fname");
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "fname";
myselect1.style.width = "170px";


<?php 
	    $query3 = "select distinct(farm) from broiler_farm";
    $result3 = mysql_query($query3) or die(mysql_error());
    while($qr3 = mysql_fetch_assoc($result3))
    {

	echo "if(item3 == 'Broiler') {";
?>
	theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr3['farm']; ?>");
theOption1.value = "<?php echo $qr3['farm']; ?>";
<?php if($fname == $qr3['farm']) { ?>
theOption1.selected='select';
<?php } ?>


theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

<?php echo "}"; ?>

<?php }  ?>	 


}

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
function makeform()
{
if((document.getElementById('sample@'+index).value != "") && (document.getElementById('sample@'+index).value != "-Select-"))
{



index = index + 1 ;

table=document.getElementById("tab");
tr = document.createElement('tr');
tr.align = "center";
var b1 = document.createElement('td');
myspace1= document.createTextNode('\u00a0');
b1.appendChild(myspace1);


td = document.createElement('td');
myselect1 = document.createElement("select");
myselect1.name = "sample[]";
myselect1.id = "sample@" + index;
myselect1.style.width = "120px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Borewell Water");
theOption1.value = "Borewell Water";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Openwell Water");
theOption1.value = "Openwell Water";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("MainTank Water");
theOption1.value = "MainTank Water";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("PipeLine Water");
theOption1.value = "PipeLine Water";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Drinking Water");
theOption1.value = "Drinking Water";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Other Water");
theOption1.value = "Other Water";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);



td.appendChild(myselect1);

tr.appendChild(td);
var b2 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
b2.appendChild(myspace2);
td = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="10";
mybox1.type="text";
mybox1.name="ecoil[]";
mybox1.value = "";
mybox1.id = "ecoil@" + index;
td.appendChild(mybox1);

tr.appendChild(b2);
tr.appendChild(td);
var b3 = document.createElement('td');
myspace3= document.createTextNode('\u00a0');
b3.appendChild(myspace3);


td = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="10";
mybox1.type="text";
mybox1.name="ph[]";
mybox1.value = "";
mybox1.id = "ph@" + index;

td.appendChild(mybox1);

tr.appendChild(b3);
tr.appendChild(td);


var b4 = document.createElement('td');
myspace4= document.createTextNode('\u00a0');
b4.appendChild(myspace4);



td = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="10";
mybox1.type="text";
mybox1.name="hardness[]";
mybox1.value = "";
mybox1.id = "hardness@" + index;
mybox1.onfocus = function () { makeform(); };
td.appendChild(mybox1);
tr.appendChild(b4);
tr.appendChild(td);


table.appendChild(tr);
}
}
function checkform(form)
{

	if(form.ftype.value == "")
	{
		alert("Please Enter Farm Type");
 form.ftype.focus();
return false;
}
else if(form.fname.value == "")
{
	alert("Please Enter Farm Name");
	form.fname.focus();
	return false;
}

for(var i=-1;i<=index;i++)
{

if(document.getElementById('sample@'+i).value != "" && document.getElementById('ecoil@'+i).value == "")
{

alert("Please Enter Ecoil ");
document.getElementById('ecoil@'+i).focus();
return false;
}
else if(document.getElementById('sample@'+i).value != "" && document.getElementById('ph@'+i).value == "")
{

alert("Please Enter PH");
document.getElementById('ph@'+i).focus();
return false;
}

else if(document.getElementById('sample@'+i).value != "" && document.getElementById('hardness@'+i).value == "")
{

alert("Please Enter Hardness ");
document.getElementById('hardness@'+i).focus();
return false;
}

}
return true;
}
</script>

<script type="text/javascript">
function script1() {
window.open('IMSHelp/help_t_watermicrobiology.php','BIMS',
'width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');

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


</body>
</html>

