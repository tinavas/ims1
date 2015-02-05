<?php
include "jquery.php"; 
include "config.php";


$id= $_GET['id'];
$tid=$_GET['tid'];

$query1 = "SELECT * FROM feedplantwateranalysis where tid = '$tid'";
$result1 = mysql_query($query1,$conn); 
while($row1 = mysql_fetch_assoc($result1))
{
    $id =  $row1['id'];
$tid = $row1['tid'];
$sdate = date("d.m.Y",strtotime($row1['sampleddate']));
$rdate = date("d.m.Y",strtotime($row1['reporteddate']));
$ftype = $row1['feedmill'];
$sample = $row1['sample'];
$ph = $row1['ph']; 
$hardness = $row1['hardness'];
$td = $row1['totaldissolve'];
$equalai = $row1['equalai'];
$remarks = $row1['remarks'];
}
?>

	<center>
	 
	  <h1>Edit Feed Plant Water Analysis</h1>
	   (Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
</center>
		<br /><br />
		<form id="form1" name="form1" method="post" action="updatefeedplantwateranalysis.php" >
<table align="center">
<tr>

<input type = "hidden" id= "id" name = "id" value = "<?php echo $id;?>"/>
<input type = "hidden" id= "tid" name = "tid" value = "<?php echo $tid;?>"/>


 <td><strong>Sampled On</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;<input class="datepicker" type="text" size="15" id="sampledate" name="sampledate" value="<?php echo $sdate; ?>"></td>
                <td width="40px"></td>
 <td><strong>Reported On</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;<input class="datepicker" type="text" size="15" id="reportdate" name="reportdate" value="<?php echo $rdate?>"></td>
                 <td width="40px"></td>
<td><strong>Feed Mill</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;
<select style="Width:180px" name="feeddesc" id="feeddesc">
<option>-Select-</option>


<?php 
	    $query = "select distinct(type1) from tbl_sector where type1 = 'Feedmill'";
    $result = mysql_query($query) or die(mysql_error());
    while($qr = mysql_fetch_assoc($result))
    {
?>
<option value = "<?php echo $qr['type1'];?>" selected = "selected"><?php echo $qr['type1'];?></option>
<?php } ?>
                

</tr>
</table>

<br/>
<br/>
<center>

 <table border="0" id="tab">
     <tr>

<th><strong>Sample</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>PH</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>Hardness(Mg/L)</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>TotalDissolve(PPM)</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>Equalai</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>

     </tr>

     <tr style="height:20px"></tr>
	 
	 

<?php 

	$q = "select * from feedplantwateranalysis where tid= '$tid' order by id ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
$x = $qr['sample'];
	
?>
<tr>

	  <td style="text-align:left;">
<select id="sample<?php echo $i; ?>" name="sample[]" style="width:120px">
<option value="">Select</option>
<option value= "Borewell Water"<?php if($x == 'Borewell Water') {?> selected="selected" <?php }?>>Borewell Water</option>
<option value = "Openwell Water"<?php if($x == 'Openwell Water') {?> selected="selected" <?php }?>>Openwell Water</option>
<option value="MainTank Water"<?php if($x == 'MainTank Water') {?> selected="selected" <?php }?>>MainTank Water</option>
<option value = "PipeLine Water"<?php if($x == 'PipeLine Water') {?> selected="selected" <?php }?>>PipeLine Water</option>
<option value = "Drinking Water"<?php if($x == 'Drinking Water') {?> selected="selected" <?php }?>>Drinking Water</option>
<option value="Other Water"<?php if($x == 'Other Water') {?> selected="selected" <?php }?>>Other Water</option>
      
</select>
       </td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="20" id="ph@-1" name="ph[]" value="<?php echo $qr['ph'];?>" />
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="20" id="hardness@-1" name="hardness[]" value = "<?php echo $qr['hardness'];?>" />
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="20" id="td@-1" name="td[]" value ="<?php echo $qr['totaldissolve'];?>"/>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="20" id="equalai@-1" name="equalai[]" value = "<?php echo $qr['equalai'];?>" onfocus="makeform();"/>
</td>


	 </tr>
<?php } ?>

	  <tr>
 
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
<input type="text" size="20" id="ph@-1" name="ph[]" value="" />
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="20" id="hardness@-1" name="hardness[]" />
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="20" id="td@-1" name="td[]"/>
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="20" id="equalai@-1" name="equalai[]" onfocus="makeform();"/>
</td>
</tr>
	 
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
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=feedplantwateranalysis';">
</center>


						
</form>



   		
<script type="text/javascript">
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
	    $query = "select distinct(type) from tbl_sector where type1='Hatchery'";
    $result = mysql_query($query) or die(mysql_error());
    while($qr = mysql_fetch_assoc($result))
    {

	echo "if(item2 == 'Hatchery') {";
?>
	theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['type']; ?>");
theOption1.value = "<?php echo $qr['type']; ?>";
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
	    $query = "select distinct(farm) from broiler_farm";
    $result = mysql_query($query) or die(mysql_error());
    while($qr = mysql_fetch_assoc($result))
    {

	echo "if(item3 == 'Broiler') {";
?>
	theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['farm']; ?>");
theOption1.value = "<?php echo $qr['farm']; ?>";
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
var index = -1;
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
mybox1.size="20";
mybox1.type="text";
mybox1.name="ph[]";
mybox1.id = "ph@" + index;
td.appendChild(mybox1);

tr.appendChild(b2);
tr.appendChild(td);
var b3 = document.createElement('td');
myspace3= document.createTextNode('\u00a0');
b3.appendChild(myspace3);


td = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="20";
mybox1.type="text";
mybox1.name="hardness[]";
mybox1.id = "hardness@" + index;

td.appendChild(mybox1);

tr.appendChild(b3);
tr.appendChild(td);


var b4 = document.createElement('td');
myspace4= document.createTextNode('\u00a0');
b4.appendChild(myspace4);



td = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="20";
mybox1.type="text";
mybox1.name="td[]";
mybox1.id = "td@" + index;
td.appendChild(mybox1);
tr.appendChild(b4);
tr.appendChild(td);

var b5 = document.createElement('td');
myspace5= document.createTextNode('\u00a0');
b5.appendChild(myspace4);



td = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="20";
mybox1.type="text";
mybox1.name="equalai[]";
mybox1.id = "equalai@" + index;
mybox1.onfocus = function () { makeform(); };
td.appendChild(mybox1);
tr.appendChild(b5);
tr.appendChild(td);


table.appendChild(tr);
}
}
</script>

<script type="text/javascript">
function script1() {
window.open('IMSHelp/help_t_addfeedplantwateranalysis.php','BIMS',
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


