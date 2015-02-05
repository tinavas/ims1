<?php include "jquery.php";
      include "getemployee.php";
      include "config.php"; 
	  $client = $_SESSION['client'];
?>
<center>
<br />
<h1>Egg/Bird Graph</h1> 
<br /><br /><br />
<form target="_new" action="#">
<table align="center">
<tr>
<td align="right"><strong>Farm&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left">
<select id="unit" name="unit" onchange="loadtype(this.value);">
<option> -Select- </option>
<?php
include "config.php"; 
//$query2 = "SELECT distinct(unitcode) FROM layer_flock where client ='$client' and unitcode!='' order by unitcode ASC"; 
$query2 = "SELECT distinct(farmcode) FROM layer_flock where client ='$client' and farmcode!='' order by farmcode ASC"; 
$result2 = mysql_query($query2,$conn);


while($row2 = mysql_fetch_assoc($result2))
{
?>
<option value="<?php echo $row2['farmcode']; ?>"><?php echo $row2['farmcode']; ?></option>
<?php } ?>
<option value="all">All</option>
</select>
</td>
<td width="15px"></td>


<td align="right"><strong>Type&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left">
<select name="type" id="type">
<option value="0">Live Flocks</option>
<option value="1">Culled Flocks</option>
<option value="all">All</option>
</select>
</td>
<td width="10px"></td>
</tr>
</table>
<br/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" id="report" value="Report" onclick="openreport();"/>
</form>
</center>


<script type="text/javascript">
function  loadtype(uni)
{
var typea = document.getElementById("type");
 removeAllOptions(typea);



if(uni == "all")
{<?php $c1=0;
$q = "select count(*)  as c1 from layer_flock where  client='$client' ";
 $qrs = mysql_query($q,$conn);
  while($qr = mysql_fetch_assoc($qrs))
  {
  $c1 =  $qr['c1'];
  }
  if($c1 > 15)
  {
?>
theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("Live Flocks");
    theOption1.appendChild(theText1);
    theOption1.value = "0";
    typea.appendChild(theOption1);
	
	theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("Culled Flocks");
    theOption1.appendChild(theText1);
    theOption1.value = "1";
    typea.appendChild(theOption1);
<?php } else {?>
theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("Live Flocks");
    theOption1.appendChild(theText1);
    theOption1.value = "0";
    typea.appendChild(theOption1);
	
	theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("Culled Flocks");
    theOption1.appendChild(theText1);
    theOption1.value = "1";
    typea.appendChild(theOption1);
	
	theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("All");
    theOption1.appendChild(theText1);
    theOption1.value = "all";
    typea.appendChild(theOption1);
	
	
<?php }?>
}
else
{

<?php $c2=0;
$q = "select * from layer_flock where  client='$client' ";
 $qrs = mysql_query($q,$conn);
  while($qr = mysql_fetch_assoc($qrs))
  {
  echo "if(uni == '$qr[unitcode]') {";
  $c2 =  $c2 + 1;
  echo "}";
  }
  if($c2 > 15)
  {
?>
theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("Live Flocks");
    theOption1.appendChild(theText1);
    theOption1.value = "0";
    typea.appendChild(theOption1);
	
	theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("Culled Flocks");
    theOption1.appendChild(theText1);
    theOption1.value = "1";
    typea.appendChild(theOption1);
<?php } else {?>
theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("Live Flocks");
    theOption1.appendChild(theText1);
    theOption1.value = "0";
    typea.appendChild(theOption1);
	
	theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("Culled Flocks");
    theOption1.appendChild(theText1);
    theOption1.value = "1";
    typea.appendChild(theOption1);
	
	theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("All");
    theOption1.appendChild(theText1);
    theOption1.value = "all";
    typea.appendChild(theOption1);
	
	
<?php }?>}
}

function openreport()
{
var unitval = document.getElementById('unit').value;
var type = document.getElementById('type').value;


window.open('flot/examples/layereggperbirdgraph.php?unit=' + unitval + '&type=' + type); 

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

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>
	

