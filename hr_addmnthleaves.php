<?php include "jquery.php"; include "getemployee.php"; session_start(); ?>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="height:600px" id="complex_form" method="post" action="hr_savemnthleaves.php" >
	  <h1 id="title1">Allowed Leaves</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>
			  
			 
<br/>
<br/>
<table id="paraID" >
<tr>

<th style="width:150px"><strong>Sector</strong>&nbsp;&nbsp;&nbsp;</th>
<td width="10">&nbsp;</td>
<th style="width:150px"><strong>Designation</strong>&nbsp;&nbsp;&nbsp;</th>
<td width="10">&nbsp;</td>
<th style="width:40px" title="Leaves Allowed / Month"><strong>Leaves</strong>&nbsp;&nbsp;&nbsp;</th>
<td width="10">&nbsp;</td>
<th style="width:100px"><strong>Forwarded Till Months</strong>&nbsp;&nbsp;&nbsp;</th>
</tr>



</table>

<table id="inputs">
<tr>

<td>
<select id ="sector@0" name="sector[]" onchange="func(this.value,this.id);" style="width:150px">
<option>-Select-</option>
<?php
$query = "SELECT distinct(sector) FROM hr_employee ORDER BY sector ASC";
$result = mysql_query($query,$conn) or die(mysql_error());
while($row = mysql_fetch_assoc($result))
{
?>
<option value="<?php echo $row['sector'];?>"><?php echo $row['sector']; ?></option>
<?php } ?>
</select>
</td>

<td width="10px"></td>
<td>
<select id="desig@0" name="desig[]" style="width:150px" onchange="checkdouble(this.id);">
<option value="Select"> Select </option>
</select>
</td>
<td width="10px"></td>
<td>
<input type="text" name="nodays[]" id="nodays@0" style="width:50px"   onfocus="makeform();" />&nbsp;
</td>
<td width="10px"></td>

<td >
<select id="month@0" name="month[]" style="width:100px" onchange="checkdouble(this.id);">
<option value="Select"> Select </option>
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
</select>
</td>


</tr>
</table><br/>
<br/>
<input type="submit" value="Save" id="Save"/>&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=hr_mnthleaves';">
</center>
</form>
 </div>
</section>

		

<br />


<script type="text/javascript">
var index = 0;
function makeform()
{
  if((index>0) &&(document.getElementById('nodays@'+index).value ==""))
  {
  }
  else
  {
  index = index + 1;
  var t1  = document.getElementById('inputs');
  var r1 = document.createElement('tr'); 

 
  myselect1 = document.createElement("select");
  myselect1.style.width = "100px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "month[]";
  myselect1.id = "month@" + index;
  myselect1.onchange = function() { checkdouble(this.id); };
  theOption=document.createElement("OPTION");
  	theText=document.createTextNode("01");
	theOption.appendChild(theText);
	theOption.value = "01";
	myselect1.appendChild(theOption);
	
	theOption=document.createElement("OPTION");
	theText=document.createTextNode("02");
	theOption.appendChild(theText);
	theOption.value = "02";
	myselect1.appendChild(theOption);
	
	theOption=document.createElement("OPTION");
	theText=document.createTextNode("03");
	theOption.appendChild(theText);
	theOption.value = "03";
	myselect1.appendChild(theOption);
	
	theOption=document.createElement("OPTION");
	theText=document.createTextNode("04");
	theOption.appendChild(theText);
	theOption.value = "04";
	myselect1.appendChild(theOption);
	
	theOption=document.createElement("OPTION");
	theText=document.createTextNode("05");
	theOption.appendChild(theText);
	theOption.value = "05";
	myselect1.appendChild(theOption);
	
	theOption=document.createElement("OPTION");
	theText=document.createTextNode("06");
	theOption.appendChild(theText);
	theOption.value = "06";
	myselect1.appendChild(theOption);
	
	theOption=document.createElement("OPTION");
	theText=document.createTextNode("07");
	theOption.appendChild(theText);
	theOption.value = "07";
	myselect1.appendChild(theOption);
	
	theOption=document.createElement("OPTION");
	theText=document.createTextNode("08");
	theOption.appendChild(theText);
	theOption.value = "08";
	myselect1.appendChild(theOption);
	
	theOption=document.createElement("OPTION");
	theText=document.createTextNode("09");
	theOption.appendChild(theText);
	theOption.value = "09";
	myselect1.appendChild(theOption);
	
	theOption=document.createElement("OPTION");
	theText=document.createTextNode("10");
	theOption.appendChild(theText);
	theOption.value = "10";
	myselect1.appendChild(theOption);
	
	
	theOption=document.createElement("OPTION");
	theText=document.createTextNode("11");
	theOption.appendChild(theText);
	theOption.value = "11";
	myselect1.appendChild(theOption);
	
	theOption=document.createElement("OPTION");
	theText=document.createTextNode("12");
	theOption.appendChild(theText);
	theOption.value = "12";
	myselect1.appendChild(theOption);
	
	

  var ba1 = document.createElement('td');
  ba1.appendChild(myselect1);
  var b1 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b1.appendChild(myspace2);


  myselect1 = document.createElement("select");
  myselect1.style.width = "150px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "sector[]";
  myselect1.id = "sector@" + index;
  myselect1.onchange = function() { func(this.value,this.id); };
  theOption=document.createElement("OPTION");
  
<?php
$query = "SELECT distinct(sector) FROM hr_employee ORDER BY sector ASC";
$result = mysql_query($query,$conn) or die(mysql_error());
while($row = mysql_fetch_assoc($result))
{
?>

theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row['sector']; ?>");
		theOption.appendChild(theText);
		theOption.value = "<?php echo $row['sector']; ?>";
		myselect1.appendChild(theOption);
<?php } ?>
 
	
  var ba2 = document.createElement('td');
  ba2.appendChild(myselect1);
  var b2 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b2.appendChild(myspace2);
  
  myselect1 = document.createElement("select");
  myselect1.style.width = "150px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "desig[]";
  myselect1.id = "desig@" + index;
   myselect1.onchange = function() { checkdouble(this.id); };
   theOption=document.createElement("OPTION");
  

  var ba4 = document.createElement('td');
  ba4.appendChild(myselect1);
  var b4 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b4.appendChild(myspace2);
  
  
  
  mybox1=document.createElement("input");
  mybox1.style.width="50px";
  mybox1.type="text";
  mybox1.name="nodays[]";
  mybox1.id="nodays@" +  index;
  mybox1.onfocus = function() { makeform(); };
  var ba3 = document.createElement('td');
  ba3.appendChild(mybox1);

  var b3 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b3.appendChild(myspace2);



 
      
      r1.appendChild(ba2);
      r1.appendChild(b2);
	  r1.appendChild(ba4);
      r1.appendChild(b4);
      r1.appendChild(ba3);
      r1.appendChild(b3);
	  r1.appendChild(ba1);
      r1.appendChild(b1);
     
      t1.appendChild(r1);
	}

}

function func(sval,sid)
{
var sidc = sid.substr(7);

removeAllOptions(document.getElementById('desig@' + sidc));
myselect1 = document.getElementById('desig@' + sidc);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

<?php 
$q = "SELECT distinct(designation),sector FROM hr_employee  ORDER BY designation ASC";
$qrs = mysql_query($q) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
echo "if(sval == '$qr[sector]') {";
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['designation']; ?>");
theOption1.value = "<?php echo $qr['designation']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php echo "}"; }  ?>

checkdouble(sid);
}

function checkdouble(seid)
{
var cid = seid.split("@");
var d = cid[1];
 for(var i = 0; i <= d; i++)
 {
 	for(var j = 0; j <= d; j++)
	{
		if(i!= j)
		{
			if((document.getElementById('sector@' + i).value  == document.getElementById('sector@' + j).value) && (document.getElementById('desig@' + i).value  == document.getElementById('desig@' + j).value))
			{
				alert("Please select different comination");
				document.getElementById('sector@' + j).selectedIndex = 0;
				document.getElementById('desig@' + j).selectedIndex = 0;
				document.getElementById('sector@' + j).focus();
				return;
			
			}
		}
	}
 }

}
function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		//selectbox.options.remove(i);
		selectbox.remove(i);
	}
}



</script>
<div class="clear"></div>
<br />

<script type="text/javascript">
function script1() {
window.open('BroilerHelp/help_t_finalization.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>
