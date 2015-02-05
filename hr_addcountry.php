<?php include "jquery.php"; ?>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="height:600px" id="complex_form" method="post" action="hr_savecountry.php" >
	  <h1 id="title1">Country</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>
<script type="text/javascript">
var index = 0;
</script>			  
<br />
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)<br /><br />
<br />

<table align="center" id="inputs">
<tr>
        <th style="text-align:center"><strong>Country<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th>
</tr>
<tr height="10px"></tr>
<tr>
 <td>
 <input type="text" id="country@0" name="country[]" onblur="makeForm()" size="15" />
 </td>
 </tr>
</table> 

<table align="center">
<tr height="30px"></tr>
<tr>
 <td><input type="submit" value="Save" name="submit" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" name="cancel" onclick="document.location='dashboardsub.php?page=hr_country'" />
 </td>
 </tr>
 </table>
 
<script type="text/javascript"> 
var totalrows = <?php echo $numrows; ?> - 1;
function makeForm()
{
if(document.getElementById('country@'+index).value != "" )
{
index = index + 1;
var tab1 = document.getElementById("inputs");
var tr = document.createElement('tr');

input1 = document.createElement('input');
input1.id = "country@"+index;
input1.name = "country[]";
input1.size = "15";
input1.onfocus = function() { makeForm(); };
var country = document.createElement('td');
country.appendChild(input1);

tr.appendChild(country);
tab1.appendChild(tr);

var tr = document.createElement('tr');
tr.height = "20px";
tab1.appendChild(tr);
}
}

function checkcodes()
{

	for(var i = 0; i <= index; i++)
	{
		for(var j = 0; j <= index; j++)
		{
			if( i!= j && document.getElementById('country@' + i).value == document.getElementById('country@' + j).value)
			{
				alert("Please select different combination");
				document.getElementById('country@' + j).selectedIndex = 0;
				return;
			}
		}
	}

}

</script>
<script type="text/javascript">
function script1() {
window.open('BREEDERHelp/breedercountry.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
