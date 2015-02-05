
<?php 
include "config,php"; 
include "jquery.php";

?>
<?php

$query = "SELECT * FROM watermicrobiology where id = '$_GET[id]'";

$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{
 $id =  $row1['id'];
$tid = $row1['tid'];
$sdate = $row1['sampledate'];
$rdate = $row1['reportdate'];
$ftype = $row1['farmtype'];
$fname = $row1['farmname'];
$sample = $row1['sample'];
$ecoil = $row1['ecoil']; 
$ph = $row1['ph'];
$hardness = $row1['hardness'];

}

?>
<br />
<center>
<h1>Water Micro Biology</h1>
<br /><br />
</center>

<form id="form1" name="form1" method="post" action="updatewatermicrobiology.php">

<table align="center">
<tr>
<td><input type = "hidden" id= "id" name = "id" value = "<?php echo $id;?>"/></td>





 <td><strong>Sample Date</strong></td>
                <td>&nbsp;<input class="datepicker" type="text" size="15" id="sampledate" name="sampledate" value="<?php echo $sdate; ?>"  onchange="getsobi();"></td>
                <td width="5px"></td>


<td>&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td>&nbsp;&nbsp;&nbsp;</td>

 <td><strong>Report Date</strong></td>
                <td>&nbsp;<input class="datepicker" type="text" size="15" id="reportdate" name="reportdate" value="<?php echo $rdate; ?>"   onchange="getsobi();"></td>
                <td width="5px"></td>

</tr>
</table>

<br/>
<br/>
<center>
 <table border="0" id="table-po">
     <tr>
     <tr style="height:20px"></tr>

      <th><strong> Farm Type</strong></th><td width="10px">&nbsp;</td>

       <td style="text-align:left;">
      <select style="Width:120px" name="ftype" id="ftype"  onchange="loadfnames(this.value);">

        <option>-Select-</option>
echo $ftype;
<option value="<?php echo $ftype; ?>" selected=selected ><?php echo $ftype; ?></option>
     </select>
       </td>
    <td width="10px">&nbsp;</td>
    <td width="10px">&nbsp;</td>
    <td width="10px">&nbsp;</td>
     <th><strong>Farm Name</strong></th><td width="10px">&nbsp;</td>
       <td width="10px"></td>

       <td style="text-align:left;">
			<select style="Width:170px" name="fname" id="fname">
     		<option>-Select-</option>
     
</select>
       </td>

</tr>
 
</table>  
<br/>
<br/>

<center>
 <table border="0" id="tab">
     <tr>
<th><strong>Sample</strong></th><td width="10px">&nbsp;</td>
<th><strong>Ecoil(MNP/100ml)</strong></th><td width="10px">&nbsp;</td>
<th><strong>PH</strong></th><td width="10px">&nbsp;</td>
<th><strong>Hardness</strong></th><td width="10px">&nbsp;</td>

     </tr>

     <tr style="height:20px"></tr>

     <tr>
 
       <td style="text-align:left;">
<select style="Width:120px" name="sample[]" id="sample@-1">
     <option>-Select-</option>
     <option>Borewell Water </option>
<option>Openwell Water</option>
<option>MainTank Water</option>
<option>PipeLine Water</option>
<option>Drinking Water</option>
<option>Other Water</option>
</select>
       </td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="20" id="ecoil@-1" name="ecoil[]" value="<?php echo $ecoil;?>" />
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="10" id="ph@-1" name="ph[]" value="<?php echo $ph;?>" />
</td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="10" id="hardness@-1" name="hardness[]" value="<?php echo $hardness;?>" onfocus="makeform();"/>
</td>

 </tr>
   </table>
   <br /> 
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
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=watermicrobiology';">
</center>


						
</form>


<script type="text/javascript">
function getsobi()
{

  var date1 = document.getElementById('date').value;
  var strdot1 = date1.split('.');
  var ignore = strdot1[0];
  var m = strdot1[1];
  var y = strdot1[2].substr(2,4);
     var mon = new Array();
     var yea = new Array();
     var sobiincr = new Array();
    var sobi = "";
	var code = "<?php echo $code; ?>";
  <?php 
   
   $query1 = "SELECT MAX(sobiincr) as sobiincr,m,y FROM pp_sobi GROUP BY m,y ORDER BY date DESC";
   $result1 = mysql_query($query1) or die(mysql_error());
   $k = 0; 
   while($row1 = mysql_fetch_assoc($result1))
   {
?>
     mon[<?php echo $k; ?>] = <?php echo $row1['m']; ?>;
     yea[<?php echo $k; ?>] = <?php echo $row1['y']; ?>;
     sobiincr[<?php echo $k; ?>] = <?php if($row1['sobiincr'] < 0) { echo 0; } else { echo $row1['sobiincr']; } ?>;

<?php $k++; } ?>
for(var l = 0; l <= <?php echo $k; ?>;l++)
{

 if((yea[l] == y) && (mon[l] == m))
  { 
   if(sobiincr[l] < 10)
     sobi = 'SOBI'+'-'+m+y+'-000'+parseInt(sobiincr[l]+1)+code;
   else if(sobiincr[l] < 100 && sobiincr[l] >= 10)
     sobi = 'SOBI'+'-'+m+y+'-00'+parseInt(sobiincr[l]+1)+code;
   else
     sobi = 'SOBI'+'-'+m+y+'-0'+parseInt(sobiincr[l]+1)+code;
     document.getElementById('sobiincr').value = parseInt(sobiincr[l] + 1);
  break;
  }
 else
  {
   sobi = 'SOBI' + '-' + m + y + '-000' + parseInt(1)+code;
   document.getElementById('sobiincr').value = 1;
  }
}
document.getElementById('invoice').value = sobi;
document.getElementById('m').value = m;
document.getElementById('y').value = y;
}
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
	    $query = "select distinct(type) from tbl_sector";
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
<option value="<?php echo $fname; ?>" <?php if($fname == $row1['farmname']) { ?> selected=selected <?php } ?>><?php echo $row1['farmname']; ?></option>
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
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Borewell Water");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Openwell Water");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("MainTank Water");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("PipeLine Water");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Drinking Water");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Other Water");
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
mybox1.name="ecoil[]";
mybox1.id = "ecoil" + index;
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
mybox1.id = "hardness" + index;
mybox1.onfocus = function () { makeform(); };
td.appendChild(mybox1);
tr.appendChild(b4);
tr.appendChild(td);


table.appendChild(tr);
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
