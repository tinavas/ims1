<?php include "jquery.php";
      include "config.php"; 
?>
<center>
<br />
<h1>Flock Wise Combined Report</h1> 
<br /><br /><br />
<form target="_new" action="production/balancesheet.php">
<table align="center">
<tr>

<script type="text/javascript">
function getflock(a)
{
 var flk = a.split(",");
 var flocka = document.getElementById("flock");
 removeAllOptions(flocka);

 theOption1=document.createElement("OPTION");
 theText1=document.createTextNode("-Select-");
 theOption1.appendChild(theText1);
 theOption1.value = flk[0];
 flocka.appendChild(theOption1);
 
 for(var i = 1;i<flk.length;i++)
 {
 

    theOption1=document.createElement("OPTION");
    theText1=document.createTextNode(flk[i]);
    theOption1.appendChild(theText1);
    theOption1.value = flk[i];
    flocka.appendChild(theOption1);
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

<td align="right"><strong>Select Unit&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left">
<select id="unit" onchange="getflock(this.value);">
<option> -Select- </option>
<?php
include "config.php"; 
$query2 = "SELECT distinct(unitcode) FROM breeder_flock order by unitcode ASC"; $result2 = mysql_query($query2,$conn);
while($row2 = mysql_fetch_assoc($result2))
{
   $flocks = "";
   $query2a = "SELECT distinct(flockcode) FROM breeder_flock where unitcode = '$row2[unitcode]' order by flockcode ASC"; $result2a = mysql_query($query2a,$conn);
   while($row2a = mysql_fetch_assoc($result2a))
   {
     $flocks = $flocks . "," . $row2a['flockcode'];
   }
?>
<option value="<?php echo $flocks; ?>"><?php echo $row2['unitcode']; ?></option>
<?php } ?>
</select>
</td>

<td width="15px"></td>

<td align="right"><strong>Select Flock&nbsp;&nbsp;&nbsp;</strong></td>
<td width="10px"></td>
<td align="left">
<select id="flock">
<option> -Select- </option>
<!--

<?php
include "config.php"; 
$query2 = "SELECT distinct(flockcode) FROM breeder_flock WHERE cullflag = '0' order by flockcode ASC"; $result2 = mysql_query($query2,$conn);
while($row2 = mysql_fetch_assoc($result2))
{
?>
<option value="<?php echo $row2['flockcode']; ?>"><?php echo $row2['flockcode']; ?></option>
<?php } ?>

-->

</select>
</td>
</tr>
</table>
<br/><br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" id="report" value="Report" onclick="openreport();"/>
</form>
</center>


<script type="text/javascript">
function openreport()
{
var a = document.getElementById("flock").value;
window.open('newflockreport/index.php?flock=' + a); 
}
</script>
</body>
</html>
	

