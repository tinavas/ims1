
<?php 
include "jquery.php"; 
include "config.php";



?>


<center>
<br />
<h1>Hatchery Micro Biology</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />
<form id="form1" name="form1" method="post" action="savehatcherymicrobiology.php" onsubmit="return checkform(this);" >
<table align="center">
<div>
<tr>


 <td><strong>Sampled On</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;<input class="datepicker" type="text" size="15" id="sampledate" name="sampledate" value="<?php echo date("d.m.Y"); ?>" ></td>
                <td width="40px"></td>



 <td><strong>Reported On</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;<input class="datepicker" type="text" size="15" id="reportdate" name="reportdate" value="<?php echo date("d.m.Y"); ?>" ></td>
                <td width="40px"></td>


<td><strong>Hatchery</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;
<select style="Width:180px" name="feeddesc" id="feeddesc">
<option>-Select-</option>


<?php 
	    $query = "select distinct(type1) from tbl_sector where type1 = 'Hatchery'";
    $result = mysql_query($query) or die(mysql_error());
    while($qr = mysql_fetch_assoc($result))
    {
?>
<option value = "<?php echo $qr['type1'];?>"><?php echo $qr['type1'];?></option>
<?php } ?>
                

</tr>
</table>

<br/>
<br/>
<center>

 <table border="0" id="tab1">
     <tr>
<th><strong>Place Of Exposure</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>Score</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
     </tr>

     <tr style="height:20px"></tr>

     <tr>
 
       <td style="text-align:left;">
<select style="Width:120px" name="poe[]" id="poe@-1">
     <option>-Select-</option>
<option value="Entrance">Entrance</option>
<option value="Fumigation Room">Fumigation Room</option>
<option value="Cold Room">Cold Room</option>
<option value="Egg Room">Egg Room</option>
<option value="Candling Room">Candling Room</option>
<option value="Vaccination Room">Vaccination Room</option>
<option value="Setters">Setters</option>
<option value="SetterNo">SetterNo</option>
<option value="Hatchery Room">Hatchery Room</option>
<option value="Overall Score">Overall Score</option>

</select>
       </td>
<td width="10px">&nbsp;</td><td>
<input type="text" size="20" id="score@-1" name="score[]" value="" onfocus="makeform1();"/>
</td>

 </tr>
   </table>

   <br /> 
 </center>

<br />	
<center>		

 <table border="0" id="tab">
     <tr>
<th><strong>ImpressionMethod</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>TotalCount</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>ColiFormCount</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>
<th><strong>FungalCount</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th><td width="10px">&nbsp;</td>

     </tr>

     <tr style="height:20px"></tr>

     <tr>
<td>
 <input type="text" size="20" id="im@-1" name="im[]"/>
</td>

       
<td width="10px">&nbsp;</td><td>
<input type="text" size="20" id="tcount@-1" name="tcount[]"/>
</td>

<td width="10px">&nbsp;</td><td>
<input type="text" size="20" id="ccount@-1" name="ccount[]"/>
</td>

<td width="10px">&nbsp;</td><td>
<input type="text" size="20" id="fungalcount@-1" name="fungalcount[]" onfocus="makeform();"/>
</td>





 </tr>
   </table>

   <br /> 
 </center>


<table border="0"  align="center">
 <tr style="height:10px"></tr> 
<tr>
<td style="vertical-align:middle;"><strong>Remarks</strong>&nbsp;&nbsp;&nbsp;</td>
<td><textarea rows="3" cols="50" id="remarks" name="remarks"></textarea></td>
</tr>
</table>
<center>	


   <br />
   <input type="submit" value="Save" id="save" name="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=hatcherymicrobiology';">
</center>


						
</form>


<script type="text/javascript">
var index1 = -1;
function makeform1()
{
index1=index1 + 1;

table1=document.getElementById("tab1");
tr = document.createElement('tr');
tr.align = "center";
td = document.createElement('td');
myselect1 = document.createElement("select");
myselect1.name = "poe[]";
myselect1.id = "poe@" + index1;
myselect1.style.width = "120px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Entrance");
theOption1.value = "Entrance";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Fumigation Room");
theOption1.value = "Fumigation Room";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Cold Room");
theOption1.value = "Cold Room";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Egg Room");
theOption1.value = "Egg Room";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Candling Room");
theOption1.value = "Candling Room";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Vaccination Room");
theOption1.value = "Vaccination Room";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Setters");
theOption1.value = "Setters";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("SetterNo");
theOption1.value = "SetterNo";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Hatchery Room");
theOption1.value = "Hatchery Room";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("OverallScore");
theOption1.value = "OverallScore";
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
mybox1.name="score[]";
mybox1.id = "score@" + index1;
mybox1.value = "";
mybox1.onfocus = function () { makeform1(); };
td.appendChild(mybox1);

tr.appendChild(b2);
tr.appendChild(td);
table1.appendChild(tr);
}
var index = -1;
function makeform()
{
index = index + 1;

table=document.getElementById("tab");
tr = document.createElement('tr');
tr.align = "center";

td = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="20";
mybox1.type="text";
mybox1.name="im[]";
mybox1.value = "";
mybox1.id = "im@" + index;
td.appendChild(mybox1);


tr.appendChild(td);





var b2 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
b2.appendChild(myspace2);
td = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="20";
mybox1.type="text";
mybox1.name="tcount[]";
mybox1.value = "";
mybox1.id = "tcount@" + index;
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
mybox1.name="ccount[]";
mybox1.value = "";
mybox1.id = "ccount@" + index;

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
mybox1.name="fungalcount[]";
mybox1.value = "";
mybox1.id = "fungalcount@" + index;
mybox1.onfocus = function () { makeform(); };
td.appendChild(mybox1);
tr.appendChild(b4);
tr.appendChild(td);


table.appendChild(tr);
}
function checkform(form)
{



	if(form.feeddesc.value == "")
	{
		alert("Please Select Hatchery");
 form.feeddesc.focus();
return false;
}

for(var i=-1;i<=index1;i++)
{

if(document.getElementById('poe@'+i).value != "" && document.getElementById('score@'+i).value == "")
{

alert("Please Enter Score");
document.getElementById('score@'+i).focus();
return false;
}

}
for(var j=-1;j<=index;j++)
{
if(document.getElementById('im@'+j).value != "" && document.getElementById('tcount@'+j).value == "")
{

alert("Please Enter Total Count");
document.getElementById('tcount@'+j).focus();
return false;
}
else if(document.getElementById('im@'+j).value != "" && document.getElementById('ccount@'+j).value == "")
{

alert("Please Enter Coliform Count");
document.getElementById('ccount@'+j).focus();
return false;
}
else if(document.getElementById('im@'+j).value != "" && document.getElementById('fungalcount@'+j).value == "")
{

alert("Please Enter fungalcount");
document.getElementById('fungalcount@'+j).focus();
return false;
}
}
return true;
}

</script>

<script type="text/javascript">
function script1() {
window.open('IMSHelp/help_t_addhatcherymicrobiology.php','BIMS',
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
