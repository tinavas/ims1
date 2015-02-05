<?php include "jquery.php"; ?>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="height:600px" id="complex_form" method="post" action="hr_saveconversion.php" >
	  <h1 id="title1">Currency Conversion</h1>
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
        <th style="text-align:center"><strong>From Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th>
        <th width="10px"></th>
        <th style="text-align:center"><strong>To Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th>
		<th width="10px"></th>
        <th style="text-align:center"><strong>Currency<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th>
        <th width="10px"></th>
        <th style="text-align:center"><strong>Rate<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th>
</tr>
<tr height="10px"></tr>
<tr>
 <td><input type="text" class="datepicker" id="fromdate@0" name="fromdate[]" size="10" /></td>
 <td width="10px"></td>
 <td><input type="text" class="datepicker" id="todate@0" name="todate[]" size="10" /></td>
 <td width="10px"></td>
 <td>
           <select name="currency[]" id="currency@0" style="width:108px;">
           <option value="select">-Select-</option>
           <?php
              include "config.php"; 
              $query = "SELECT distinct(currency),country FROM currency where currency NOT IN (SELECT bcurrency FROM bccurrency) ORDER BY currency ASC ";
              $result = mysql_query($query,$conn); 
			  $numrows = mysql_num_rows($result);
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
           <option value="<?php echo $row1['country']."@".$row1['currency']; ?>" title="<?php echo $row1['country']; ?>"><?php echo $row1['currency']; ?></option>
           <?php } ?>
         </select>

 </td>
 <td width="10px"></td>
 <td>
 <input type="text" id="rate@0" name="rate[]" onfocus="makeForm()" size="7" />
 </td>
 </tr>
</table> 

<table align="center">
<tr height="30px"></tr>
<tr>
 <td><input type="submit" value="Save" name="submit" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" name="cancel" onclick="document.location='dashboardsub.php?page=hr_conversion'" />
 </td>
 </tr>
 </table>
 
<script type="text/javascript"> 
var totalrows = <?php echo $numrows; ?> - 1;
function makeForm()
{
if(document.getElementById('currency@'+index).value != "select")
{
index = index + 1;
var tab1 = document.getElementById("inputs");
var tr = document.createElement('tr');

input1 = document.createElement('input');
input1.id = "fromdate@"+index;
input1.name = "fromdate[]";
input1.size = "10";
var c = "datepicker" + index;
input1.setAttribute("class",c);
var fromdate = document.createElement('td');
fromdate.appendChild(input1);

var tds2 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
tds2.appendChild(myspace2);

input1 = document.createElement('input');
input1.id = "todate@"+index;
input1.name = "todate[]";
input1.size = "10";
var c = "datepicker" + index;
input1.setAttribute("class",c);
var todate = document.createElement('td');
todate.appendChild(input1);

var tds3 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
tds3.appendChild(myspace2);

myselect1 = document.createElement('select');
myselect1.id = "currency@"+index;
myselect1.name = "currency[]";
myselect1.style.width = "108px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "select";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php
$query = "SELECT distinct(currency),country FROM currency where currency NOT IN (SELECT bcurrency FROM bccurrency) ORDER BY currency ASC ";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['currency']; ?>");
theOption1.value = "<?php echo $row1['country']."@".$row1['currency']; ?>";
theOption1.title = "<?php echo $row1['country']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

<?php } ?>

var currency = document.createElement('td');
currency.appendChild(myselect1);

var tds1 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
tds1.appendChild(myspace2);

input1 = document.createElement('input');
input1.id = "rate@"+index;
input1.name = "rate[]";
input1.size = "7";
input1.onfocus = function() { makeForm(); };
var rate = document.createElement('td');
rate.appendChild(input1);

tr.appendChild(fromdate);
tr.appendChild(tds2);
tr.appendChild(todate);
tr.appendChild(tds3);
tr.appendChild(currency);
tr.appendChild(tds1);
tr.appendChild(rate);

tab1.appendChild(tr);
  $(function() {
	$( "." + c ).datepicker();
  });

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
