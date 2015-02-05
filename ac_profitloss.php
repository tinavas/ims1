<?php include "jquery.php";

     include "config.php"; 

	  include "getemployee.php";

	  $q1 = "SELECT max(fdate) as fdate from ac_definefy ";

$result = mysql_query($q1,$conn);

while($row1 = mysql_fetch_assoc($result))

 {

 $fromdate = $row1['fdate'];

 $fromdate = date("d.m.Y",strtotime($fromdate));

 }

?>

<center>

<br />

<h1>Profit & Loss</h1> 

<br /><br /><br />

<form method="post" target="_new" action="production/profitloss.php" id="form1" name="form1">

<table align="center">
<tr>
	<td align="right"><strong>Cost Center&nbsp;&nbsp;&nbsp;</strong></td>
	<td width="10px"></td>
	<td align="left">
	<select id="costcenter" name="costcenter" multiple="multiple" size="4" onchange="cal_costcenter(this.value)" >
	<option value="all">-All-</option>
		  <?php
  if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
{
 $q1 ="SELECT DISTINCT (sector) as sector FROM tbl_sector";
 }
 else
 {
  $sectorlist = $_SESSION['sectorlist'];
 $q1 ="SELECT  DISTINCT (sector) as sector FROM tbl_sector WHERE sector in ($sectorlist)";
 }
  $result = mysql_query($q1,$conn) or dir(mysql_error());
  while($rows = mysql_fetch_assoc($result))
  {
  ?>
  <option value="<?php echo $rows['sector']; ?>"><?php echo $rows['sector']; ?></option>
  <?php
  }
  ?>
    </select>
	</td>
</tr>
</table>
<br/>
<table align="center" >
<tr>

<td align="right"><strong>From&nbsp;&nbsp;&nbsp;</strong></td>

<td width="10px"></td>

<td align="left"><input type="text" size="15" id="date2" class="datepicker" name="date2" value="<?php echo $fromdate; ?>" onChange="datecomp();"  ></td>

<td width="10px"></td>

<td><strong align="right">To&nbsp;&nbsp;&nbsp;</strong></td>

<td width="10px"></td>

<td align="left"><input type="text" size="15" id="date3" class="datepicker" name="date3" value="<?php echo date("d.m.o"); ?>" onChange="datecomp();" ></td>

</tr>

</table>

<br/><br/>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type="button" id="report" value="Report" onclick="openreport();"/>

</form>

</center>









<script type="text/javascript">
var s=0;
function openreport()

{
	 var ccenter = "";
 for(var i=0; i< document.form1.costcenter.length; i++)
 {
  if(document.form1.costcenter[i].selected)
   ccenter += "'" + document.form1.costcenter[i].value + "',";
 }
 ccenter = ccenter.substr(0,(ccenter.length-1));
 if(ccenter == "")
 {
  alert("Please select atleast one of the costcenter");
  return;
 }
var fromdate = document.getElementById('date2').value;

var todate = document.getElementById('date3').value;

<?php if($_SESSION['db'] == "albustan") { ?>

window.open('production/profitloss_horizontal.php?fromdate=' + fromdate + '&todate=' + todate+ '&costcenter=' + ccenter+'&s='+s); 
s=0;
<?php } else { ?>

window.open('production/profitloss.php?fromdate=' + fromdate + '&todate=' + todate+ '&costcenter=' + ccenter+'&s='+s); 
s=0;
<?php } ?>



}


function cal_costcenter(val)
{
s=0;

var cc=document.getElementById("costcenter");
if(val=="all")
{
s=1;
for(var i=0;i<cc.length;i++)
{
cc.options[i].selected=true;
}
}
cc.options[0].selected=false;
//alert(s);
}

function datecomp()

{

<?php echo "

dd = document.getElementById('date2').value;

temp =  dd.split('.');

temp = temp[1] + '/' + temp[0] + '/' + temp[2];

temp1 = new Date(temp);



dd1 = document.getElementById('date3').value;

temp3 =  dd1.split('.');

temp3 = temp3[1] + '/' + temp3[0] + '/' + temp3[2];

temp4 = new Date(temp3);



if(temp1 >=temp4)

{

 alert('To date must be greater than or equal to From date');

 document.getElementById('report').disabled = true;

}

else

{

 document.getElementById('report').disabled = false;

 reloadpurord();

}

 ";

?>

}

function description()

{



	<?php

		$q = "select * from ims_itemcodes order by code";

		$qrs = mysql_query($q) or die(mysql_error());

		while($qr = mysql_fetch_assoc($qrs))

		{

		echo "if(document.getElementById('code').value == '$qr[code]') { ";

		$q1 = "select code,description from ims_itemcodes where code = '$qr[code]'";

		$q1rs = mysql_query($q1) or die(mysql_error());

		if($q1r = mysql_fetch_assoc($q1rs))

		{

	?>

	    document.getElementById('desc').value = "<?php echo $q1r['description']; ?>";

		

		<?php 

		}

		echo " } "; 

		}

		?>

		

}



function reloadpur()

{

 date2 = document.getElementById('date2').value;

 date2 = temp =  date2.split('.');

 var fdate =(date1[2] + '-' + date2[1] + '-' + date2[0]).toString();

 

 date3 = document.getElementById('date3').value;

 date3 = temp =  date3.split('.');

 var tdate =(date3[2] + '-' + date3[1] + '-' + date3[0]).toString();

}



</script>

<script type="text/javascript">

function script1() {

window.open('GLHelp/help_profitandloss.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=no,resizable=no');

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

	



