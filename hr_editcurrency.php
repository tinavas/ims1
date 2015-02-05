<?php include "jquery.php"; 
$id = $_GET['id'];
$query = "SELECT country,currency FROM currency WHERE id = '$id'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$country = $rows['country'];
$currency = $rows['currency'];
?>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="height:600px" id="complex_form" method="post" action="hr_updatecurrency.php" >
	  <h1 id="title1">Currency</h1>
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
        <th width="10px"></th>
        <th style="text-align:center"><strong>Currency<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th>
</tr>
<tr height="10px"></tr>
<tr>
 <td>
           <select name="country[]" id="country@0" style="width:108px;" onchange="checkcodes();" readonly>
           <option value="select">-Select-</option>
           <?php
              include "config.php"; 
              $query = "SELECT distinct(country_name) FROM countries where country_name NOT IN (SELECT country FROM currency WHERE country <> '$country') ORDER BY country_name ASC ";
              $result = mysql_query($query,$conn); 
			  $numrows = mysql_num_rows($result);
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
           <option value="<?php echo $row1['country_name']; ?>" <?php if($country == $row1['country_name']) { ?> selected="selected" <?php } ?>><?php echo $row1['country_name']; ?></option>
           <?php } ?>
         </select>

 </td>
 <td width="10px"></td>
 <td>
 <input type="text" id="currency@0" name="currency[]" value="<?php echo $rows['currency']; ?>" size="5"/>
 <input type="hidden" id="oldid" name="oldid" value="<?php echo $id; ?>" />
 </td>
 </tr>
</table> 

<table align="center">
<tr height="30px"></tr>
<tr>
 <td><input type="submit" value="Update" name="submit" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" name="cancel" onclick="document.location='dashboardsub.php?page=hr_currency'" />
 </td>
 </tr>
 </table>
 
<script type="text/javascript"> 
var totalrows = <?php echo $numrows; ?> - 1;
function makeForm()
{
if(document.getElementById('country@'+index).value != "select" && index != totalrows)
{
index = index + 1;
var tab1 = document.getElementById("inputs");
var tr = document.createElement('tr');

myselect1 = document.createElement('select');
myselect1.id = "country@"+index;
myselect1.name = "country[]";
myselect1.onchange = function() { checkcodes(); };
myselect1.style.width = "108px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "select";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php
$query = "SELECT distinct(description) FROM ims_itemcodes where cat = 'Breeder Equipment' and client = '$_SESSION[client]' AND description NOT IN (SELECT country FROM breeder_country WHERE client = '$client') ORDER BY code ASC ";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['description']; ?>");
theOption1.value = "<?php echo $row1['description']; ?>";
theOption1.title = "<?php echo $row1['description']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

<?php } ?>

var country = document.createElement('td');
country.appendChild(myselect1);

var tds1 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
tds1.appendChild(myspace2);

input1 = document.createElement('input');
input1.id = "currency@"+index;
input1.name = "currency[]";
input1.size = "5";
input1.onfocus = function() { makeForm(); };
var currency = document.createElement('td');
currency.appendChild(input1);

tr.appendChild(country);
tr.appendChild(tds1);
tr.appendChild(currency);
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
