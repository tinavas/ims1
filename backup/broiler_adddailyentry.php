<?php 
include "config,php"; 
include "broiler_adddailyentry1.php";
include "jquery.php";
?>
<br />
<center>
<h1>Broiler Daily Entry</h1>
</center>

<form id="form1" name="form1" method="post" action="broiler_savedailyentry.php">
<input type="hidden" name="saed" id="saed" value="save" />
<br /><br />
<center>
<strong>Supervisor</strong>&nbsp;&nbsp;&nbsp;&nbsp;
<select id="supervisor" name="supervisor" onChange="loadfarms(0)">
<option value="">-Select-</option>
<?php 
	   if($_SESSION['db'] == "feedatives")
		{
		   if($_SESSION['sectorr'] == "all")
		   {
		   	$query = "SELECT distinct(supervisor) FROM broiler_supervisor WHERE client = '$client' ORDER BY supervisor ASC ";
		   }
		   else
		   {
		   $sectorr = $_SESSION['sectorr'];
		   $query = "SELECT distinct(supervisor) FROM broiler_place WHERE client = '$client' and place = '$sectorr' ORDER BY supervisor ASC ";
		   }
		   
		 }
	   else
	   {
	   $query = "SELECT distinct(supervisor) FROM broiler_supervisor WHERE client = '$client' ORDER BY supervisor ASC ";
	   }
        

$qrs = mysql_query($query,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
?>
<option value="<?php echo $qr['supervisor']; ?>"><?php echo $qr['supervisor']; ?></option>
<?php } ?>
</select>
</center>
<br /><br />

<table id="paraID" align="center">
<tr align="center">
<td><strong>Farm</strong></td>
<td>&nbsp;&nbsp;</td>
<td><strong>Flock</strong></td>
<td>&nbsp;&nbsp;</td>
<td><strong>Age</strong></td>
<td>&nbsp;&nbsp;</td>
<td><strong>Date</strong></td>
<td>&nbsp;&nbsp;</td>
<td><strong>Mort</strong></td>
<td>&nbsp;&nbsp;</td>
<td><strong>Cull</strong></td>
<td>&nbsp;&nbsp;</td>
<td><strong>Feed Type</strong></td>
<td>&nbsp;&nbsp;</td>
		<?php session_start();
		if($_SESSION['client'] == 'KWALITY')
		{
		?><td><strong>Feed<br><font size="1px">(In Bag's)</font></strong></td><?php
		}
		else
		{
		?><td><strong>Feed<br><font size="1px">(In Kg's)</font></strong></td><?php
		}
		?>


<td>&nbsp;&nbsp;</td>
<td><strong title="Average Weight">Avg.Wgt<br><font size="1px">(In Gms)</font></strong></td>
<td>&nbsp;&nbsp;</td>
<td><strong>Water</strong></td>
<td>&nbsp;&nbsp;</td> 
<td><strong>Medicine</strong></td>
<td>&nbsp;&nbsp;</td>
<td><strong>Quantity</strong></td>
<td>&nbsp;&nbsp;</td>
<td><strong>Vaccine</strong></td>
<td>&nbsp;&nbsp;</td>
<td><strong>Quantity</strong></td>
</tr>
<tr height="10px"><td></td></tr>

<tr align="center">
<input type="hidden" id="dispflock" value=""/>
<input type="hidden" id="dispage" value=""/>
<input type="hidden" id="dispdate" value=""/>
<input type="hidden" id="dispflock1" value=""/>
<input type="hidden" id="dispage1" value=""/>
<input type="hidden" id="dispdate1" value=""/>
<input type="hidden" id="trc1" value=""/>
<input type="hidden" id="prc1" value=""/>

<td>
<select name="farm[]" id="farm@0" style="width:120px" onChange="func(0,this.value);">
<option value="">-Select-</option>

<?php
           include "config.php";
           $query = "SELECT * FROM broiler_farmers where rsupervisor = '$_GET[user]' ORDER BY name ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
<option value="<?php echo $row1['name']; ?>" title="<?php echo $row1['name']; ?>"><?php echo $row1['name']; ?></option>
<?php } ?>
</select>
</td>
<td>&nbsp;&nbsp;</td>
<td>
<input type="text" name="flock[]" id="flock@0" size="7" readonly/>
</td>
<td>&nbsp;&nbsp;</td>
<td>
<input type="text" name="age[]" id="age@0" size="2" readonly/>
</td>
<td>&nbsp;&nbsp;</td>
<td>
<input type="text" name="date1[]" id="date1@0" size="10" readonly/>
</td>
<td>&nbsp;&nbsp;</td>
<td>
<input type="text" name="mort[]" id="mort@0" size="2" value="0" />
</td>
<td>&nbsp;&nbsp;</td>
<td>
<input type="text" name="cull[]" id="cull@0"size="2" value="0"/>
</td>
<td>&nbsp;&nbsp;</td>
<td>
<select name="feedtype[]" id="feedtype@0" style="width:100px">
<option value="">-Select-</option>
	    <?php 
			     include "config.php";
	             $query = "SELECT distinct(code),description FROM ims_itemcodes WHERE cat = 'Broiler Feed' ORDER BY code ASC";
		         $result = mysql_query($query,$conn);
 		         while($row = mysql_fetch_assoc($result))
		         {
            ?>
	 <option value="<?php echo $row['code'];?>" title="<?php echo $row['description'];?>"><?php echo $row['code']; ?></option>
	        <?php } ?>
</select>
</td>
<td>&nbsp;&nbsp;</td>
<td>
<input type="text" name="consumed[]" id="consumed@0" size="4" value="0"/>
</td>
<td>&nbsp;&nbsp;</td>
<td>
<input type="text" name="weight[]" id="weight@0" size="4" value="0"/>
</td>
<td>&nbsp;&nbsp;</td>
<td>
<input type="text" name="water[]" id="water@0" value="0"  size="4" />
</td>
<td>&nbsp;&nbsp;</td>
<td>
<!--<input type="text" name="medicine[]" id="medicine@0" value="" size="10" />-->
<select id="medicine@0" name="medicine[]">
<option value="">-Select-</option>
<?php 
$q = "select distinct(code),description from ims_itemcodes where cat = 'Medicines' order by code";
$qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
?>
<option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['code']; ?>"><?php echo $qr['code']; ?></option>
<?php } ?>
</select>

</td>
<td>&nbsp;&nbsp;</td>
<td>
<input type="text" name="mquantity[]" id="mquantity@0" value="0"  size="3" />
</td>
<td>&nbsp;&nbsp;</td>
<td>
<!--<input type="text" name="vaccine[]" id="vaccine@0" value=""  size="10" />-->
<select id="vaccine@0" name="vaccine[]">
<option value="">-Select-</option>
<?php 
$q = "select distinct(code),description from ims_itemcodes where cat = 'Vaccines' order by code";
$qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
?>
<option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['code']; ?>"><?php echo $qr['code']; ?></option>
<?php } ?>
</select>

</td>
<td>&nbsp;&nbsp;</td>
<td>
<input type="text" name="vquantity[]" id="vquantity@0" size="3" value="0" onfocus = "makeForm();" />
</td>
<td>&nbsp;&nbsp;</td>
<td>
<input type="hidden" name="birds[]" id="birds@0" value="0"/>
</td>
</tr>
</table>


<center>
<br />
<br />
<input type="submit" value="Save" id="Save"/>&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=broiler_dailyentry';">
</center>

</form>

<div class="clear"></div>
<br />

<script type="text/javascript">
function script1() {
window.open('BroilerHelp/Help_t_addbrdailyentry.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
<br />
<body> 
<script type="text/javascript">
function func(a,b)
{
<?php 
$j = 0;$k =0;
$query="select distinct(towarehouse) from ims_stocktransfer where cat = 'Broiler Chicks' AND client = '$client'";
$result=mysql_query($query,$conn);
$no1 = mysql_num_rows($query);
while($rows=mysql_fetch_array($result))
{
echo "if(b=='$rows[towarehouse]') { ";
$j++;
echo "}";
}

$query1="select distinct(warehouse) from pp_sobi where description = 'Broiler Chicks' AND client = '$client'";
$result1=mysql_query($query1,$conn);
$no2 = mysql_num_rows($query1);
while($rows1=mysql_fetch_array($result1))
{
echo "if(b=='$rows1[warehouse]') { ";
$k++;
echo "}";
}

if(($j >= 0) && ($k == 0))
{?>
func1(a,b);
<?php
}
else if(($j == 0) && ($k >0))
{?>
func2(a,b);
<?php 
}
else if(($j > 0) && ($k >0))
{
?>
func3(a,b);
<?php 
}
?>
}
function func1(a,b)
{
//alert("only stock transfer");
document.getElementById('flock@' + a).value = "";
document.getElementById('age@' + a).value = "";
document.getElementById('date1@' + a).value = "";

<?php
$query="select distinct(towarehouse) from ims_stocktransfer";
$result=mysql_query($query,$conn) or die(mysql_error());
while($rows=mysql_fetch_array($result))
{
$newflock =""; $ToFlock="";$maxflock = "";$displayflock="";$displayage="";$displaydate="";$notr1 = 0; $notc1 = 0;$farmer ="";$notc =0;$notr=0;
echo "if(b=='$rows[towarehouse]') { ";
$i++;
$farmer=$rows['towarehouse'];
	
 $q1 = mysql_query("select distinct(flock) as ToFlock, aflock, date as Date, towarehouse as Farmer1 from ims_stocktransfer where towarehouse ='$farmer' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
	 	$notr = mysql_num_rows($q1);
		
	   if($nt1 = mysql_fetch_assoc($q1))
        $ToFlocknum = $nt1['ToFlock'];
		$ToFlock = $nt1['aflock'];
		
$q2 = mysql_query("select distinct(flock) as newflock,aflock,date,towarehouse as farmer from ims_stocktransfer where towarehouse = '$farmer' AND (cat = 'Broiler Chicks' or cat = 'Broiler Day Old Chicks') AND client = '$client' order by date DESC",$conn) or die(mysql_error());
	 	$notc = mysql_num_rows($q2);
		
		if($nt2 = mysql_fetch_assoc($q2))
		$newflocknum = $nt2['newflock'];
		$newflock = $nt2['aflock'];
		
		if($newflocknum>0 && $ToFlocknum >0 && $newflocknum > $ToFlocknum)
		$maxflock = $newflock;
		else
		$maxflock = $ToFlock;
				
		$sq1 = mysql_query("select distinct(aflock) as ToFlock,date as Date,towarehouse as Farmer1 from ims_stocktransfer where towarehouse = '$farmer' and aflock = '$maxflock' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
		$notr1 = mysql_num_rows($sq1);
		if($sq1r = mysql_fetch_assoc($sq1))
		$trdate = $sq1r['Date'];
	
		$sq2 = mysql_query("select distinct(aflock) as newflock,date,towarehouse as farmer from ims_stocktransfer where towarehouse = '$farmer' and aflock = '$maxflock' AND (cat = 'Broiler Chicks' or cat = 'Broiler Day Old Chicks') AND client = '$client' order by date DESC",$conn) or die(mysql_error());
		$notc1 = mysql_num_rows($sq2);
		if($sq2r = mysql_fetch_assoc($sq2))
		$tcdate = $sq2r['date']; 

		if($notr1 != 0 && $notc1 != 0)
		$finaldate = $tcdate;
		else if($notr1 != 0 && $notc1 == 0)
		$finaldate = $trdate;
		else if($notr1 == 0 && $notc1 != 0)
		$finaldate = $tcdate;
		$culled = "";
		$nobde = 0;
			
if($notr1 != 0 && $notc1 != 0)
{	
	$q3 = mysql_query("select distinct(flock) as flock,cullflag,age,entrydate from broiler_daily_entry where farm ='$farmer' and flock = '$maxflock' and client = '$client' order by entrydate DESC",$conn) or die(mysql_error());
	$nobde = mysql_num_rows($q3);
	if($q3r = mysql_fetch_assoc($q3))
	{
	$culled = $q3r['cullflag'];
	$entrydate = $q3r['entrydate'];
	$age = $q3r['age'];
	$currflock = $q3r['flock'];
	}
	
	if($nobde != 0)
	{
		if($culled == 1)
		{
			$displayflock = "";
			$displayage = "";
			$displaydate = "";
			
			$warning = "Flock " . $maxflock . " has been culled";
		}
		else if($culled == 0)
		{
			$displayflock = $maxflock;
			$displayage = $age + 1;
			$displaydate = date("d.m.Y",strtotime($entrydate) + 86400);
		}
	}
	else if($nobde == 0)
	{
		$displayflock = $maxflock;
		$displayage = 1;
		$displaydate = date("d.m.Y",strtotime($finaldate));
	}
}
else
{
	if($notc1 == 0 && $notr1 != 0)
	{
	$displaydate = date("d.m.Y");
	$warning = "Please do Chicks Transfer for the Flock: " . $maxflock;
	}
	else if($notr1 == 0 && $notc1 != 0)
	{
	$displaydate = date("d.m.Y");
	$warning = "Please do Feed Transfer for the Flock: " . $maxflock;
	}
	else
	{
	$displaydate = date("d.m.Y");
	$warning = "Please do Chicks Transfer & Feed Transfer";
	}
	
}


?>
/*
document.getElementById('mort@0').value = "<?php echo  $aa; ?>";
document.getElementById('cull@0').value = "<?php echo  $aaa; ?>";*/
document.getElementById('flock@' + a).value = "<?php echo  $displayflock; ?>";
document.getElementById('age@' + a).value = "<?php echo $displayage; ?>";
document.getElementById('date1@' + a).value = "<?php echo $displaydate; ?>";
<?php
echo "}";
}
?>

if(document.getElementById('farm@' + a ).value == "")
{
document.getElementById('flock@' + a).value = "";
document.getElementById('age@' + a).value = "";
document.getElementById('date1@' + a).value = "";
//document.getElementById('Save').disabled = true;
//document.getElementById('vquantity@' + a).onfocus = "";
alert("Please select Farm");
return;
}
var i1,j1;
for(var i = 0;i<=index;i++)
{
	for(var j = 0;j<=index;j++)
	{
		i1=i;
		j1=j;
		
		if( i != j)
		{
			if(document.getElementById('farm@' + i1).value == document.getElementById('farm@' + j1).value)
			{
				//document.getElementById('Save').disabled = true;
				document.getElementById('flock@' + a).value = "";
				document.getElementById('age@' + a).value = "";
				document.getElementById('date1@' + a).value = "";
				//document.getElementById('vquantity@' + a).onfocus = "";
				alert("Please select different combination");
				document.getElementById('farm@' + j1).options[0].selected = true;
				return;
			}
		}
	}
}
//document.getElementById('Save').disabled = false;
//document.getElementById('vquantity@' + a).onfocus = function ()  {  makeForm(); };


 


}
function func2(a,b)
{
//alert("only purchase");
document.getElementById('flock@' + a).value = "";
document.getElementById('age@' + a).value = "";
document.getElementById('date1@' + a).value = "";

<?php
$query="select distinct(warehouse) from pp_sobi where description = 'Broiler Chicks' AND client = '$client' order by warehouse asc";
$result=mysql_query($query,$conn) or die(mysql_error());
while($rows=mysql_fetch_array($result))
{
$newflock =""; $ToFlock="";$maxflock = "";$displayflock1="";$displayage1="";$displaydate1="";$notr1 = 0; $notc1 = 0;$farmer ="";$notc =0;$notr=0;
echo "if(b=='$rows[warehouse]') { ";
$j++;
$farmer=$rows['warehouse'];


     $q1 = mysql_query("select distinct(aflock) as ToFlock, date as Date, towarehouse as Farmer1 from ims_stocktransfer where towarehouse ='$farmer' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
	 $notr = mysql_num_rows($q1);
		
	   if($nt1 = mysql_fetch_assoc($q1))
        $ToFlock = $nt1['ToFlock'];
		$feedtrdate = $nt1['date'];
	 
	
	  $q2 = mysql_query("select distinct(flock) as newflock,date,warehouse as farmer from pp_sobi where warehouse = '$farmer' AND description = 'Broiler Chicks' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
	 $notc = mysql_num_rows($q2);
		
		if($nt2 = mysql_fetch_assoc($q2))
		$newflock = $nt2['newflock'];
		$chkpurdate = $nt2['date'];

		
		if($newflock == $ToFlock)
		{
		$maxflock = $newflock;
		}
		else
		{
		$maxflock = $ToFlock;
		}
		
		$sq1 = mysql_query("select distinct(aflock) as ToFlock,date as Date,towarehouse as Farmer1 from ims_stocktransfer where towarehouse = '$farmer' and aflock = '$maxflock' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
		
		$notr1 = mysql_num_rows($sq1);
		if($sq1r = mysql_fetch_assoc($sq1))
		$trdate = $sq1r['Date'];
	
		$sq2 = mysql_query("select distinct(flock) as newflock,date,warehouse as farmer from pp_sobi where warehouse = '$farmer' and flock = '$maxflock' AND description = 'Broiler Chicks' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
		$notc1 = mysql_num_rows($sq2);
		if($sq2r = mysql_fetch_assoc($sq2))
		$tcdate = $sq2r['date']; 
		$chickspurdate = $tcdate;
		
		if($notr1 != 0 && $notc1 != 0)
		$finaldate = $tcdate;
		else if($notr1 != 0 && $notc1 == 0)
		$finaldate = $trdate;
		else if($notr1 == 0 && $notc1 != 0)
		$finaldate = $tcdate;
		$culled = "";
		$nobde = 0;
  
if($notr1 != 0 && $notc1 != 0)
{

	$q3 = mysql_query("select distinct(flock) as flock,cullflag,age,entrydate from broiler_daily_entry where farm ='$farmer' and flock = '$maxflock' and client = '$client' order by entrydate DESC",$conn) or die(mysql_error());
	$nobde = mysql_num_rows($q3);
	if($q3r = mysql_fetch_assoc($q3))
	{
	$culled = $q3r['cullflag'];
	$entrydate = $q3r['entrydate'];
	$age = $q3r['age'];
	$currflock = $q3r['flock'];
	}
	
	if($nobde != 0)
	{
		if($culled == 1)
		{
			$displayflock1 = "";
			$displayage1 = "";
			$displaydate1 = "";
			
			$warning = "Flock " . $maxflock . " has been culled";
		}
		else if($culled == 0)
		{
			$displayflock1 = $maxflock;
			$displayage1 = $age + 1;
			$displaydate1 = date("d.m.Y",strtotime($entrydate) + 86400);
		}
	}
	else if($nobde == 0)
	{
	
		$displayflock1 = $maxflock;
		$displayage1 = 1;
		$displaydate1 = date("d.m.Y",strtotime($finaldate));
	}
}
else
{

	if($notc1 == 0 && $notr1 != 0)
	{
	$displaydate1 = date("d.m.Y");
	$warning = "Please do Chicks Purchase for the Flock: " . $maxflock;
	}
	else if($notr1 == 0 && $notc1 != 0)
	{
	$displaydate1 = date("d.m.Y");
	$warning = "Please do Feed Transfer for the Flock: " . $maxflock;
	}
	else
	{
	$displaydate1 = date("d.m.Y");
	$warning = "Please do Chicks Purchase & Feed Transfer";
	}
	
}


?>
/*document.getElementById('mort@0').value = "<?php echo  $aa; ?>";
document.getElementById('cull@0').value = "<?php echo  $aaa; ?>";*/
document.getElementById('flock@' + a).value = "<?php echo  $displayflock1; ?>";
document.getElementById('age@' + a).value = "<?php echo $displayage1; ?>";
document.getElementById('date1@' + a).value = "<?php echo $displaydate1; ?>";
<?php
echo "}";

}

?>

if(document.getElementById('farm@' + a ).value == "")
{
document.getElementById('flock@' + a).value = "";
document.getElementById('age@' + a).value = "";
document.getElementById('date1@' + a).value = "";
//document.getElementById('Save').disabled = true;
//document.getElementById('vquantity@' + a).onfocus = "";
alert("Please select Farm");
return;
}
var i1,j1;
for(var i = 0;i<=index;i++)
{
	for(var j = 0;j<=index;j++)
	{
		i1=i;
		j1=j;
		
		if( i != j)
		{
			if(document.getElementById('farm@' + i1).value == document.getElementById('farm@' + j1).value)
			{
				//document.getElementById('Save').disabled = true;
				document.getElementById('flock@' + a).value = "";
				document.getElementById('age@' + a).value = "";
				document.getElementById('date1@' + a).value = "";
				//document.getElementById('vquantity@' + a).onfocus = "";
				alert("Please select different combination");
				document.getElementById('farm@' + j1).options[0].selected = true;
				return;
			}
		}
	}
}
//document.getElementById('Save').disabled = false;
//document.getElementById('vquantity@' + a).onfocus = function ()  {  makeForm(); };



}

function func3(a,b)
{

var dispflk ="";var dispage = "";var dispdate = "";
var dispflk1 ="";var dispage1 = "";var dispdate1 = "";
var dispflk2 ="";var dispage2 = "";var dispdate2 = "";
var trc ="";var prc = "";

document.getElementById('dispflock').value = "";
document.getElementById('dispage').value = "";
document.getElementById('dispdate').value = "";
document.getElementById('dispflock1').value = "";
document.getElementById('dispage1').value = "";
document.getElementById('dispdate1').value = "";
document.getElementById('trc1').value = "";
document.getElementById('prc1').value = "";

document.getElementById('flock@' + a).value = "";
document.getElementById('age@' + a).value = "";
document.getElementById('date1@' + a).value = "";

<?php
$query="select distinct(towarehouse) from ims_stocktransfer";
$result=mysql_query($query,$conn) or die(mysql_error());
while($rows=mysql_fetch_array($result))
{
$newflock =""; $ToFlock="";$maxflock = "";$displayflock="";$displayage="";$displaydate="";$notr1 = 0; $notc1 = 0;$farmer ="";$notc =0;$notr=0;
echo "if(b=='$rows[towarehouse]') { ";
$i++;
$farmer=$rows['towarehouse'];

     $q1 = mysql_query("select distinct(flock) as ToFlock, aflock, date as Date, towarehouse as Farmer1 from ims_stocktransfer where towarehouse ='$farmer' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
	 	$notr = mysql_num_rows($q1);
		
	   if($nt1 = mysql_fetch_assoc($q1))
        $ToFlocknum = $nt1['ToFlock'];
		$ToFlock = $nt1['aflock'];
		
$q2 = mysql_query("select distinct(flock) as newflock,aflock,date,towarehouse as farmer from ims_stocktransfer where towarehouse = '$farmer' AND (cat = 'Broiler Chicks' or cat = 'Broiler Day Old Chicks') AND client = '$client' order by date DESC",$conn) or die(mysql_error());
	 	$notc = mysql_num_rows($q2);
		
		if($nt2 = mysql_fetch_assoc($q2))
		$newflocknum = $nt2['newflock'];
		$newflock = $nt2['aflock'];
		
		if($newflocknum>0 && $ToFlocknum >0 && $newflocknum > $ToFlocknum)
		$maxflock = $newflock;
		else
		$maxflock = $ToFlock;
				
		$sq1 = mysql_query("select distinct(aflock) as ToFlock,date as Date,towarehouse as Farmer1 from ims_stocktransfer where towarehouse = '$farmer' and aflock = '$maxflock' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
		$notr1 = mysql_num_rows($sq1);
		if($sq1r = mysql_fetch_assoc($sq1))
		$trdate = $sq1r['Date'];
	
		$sq2 = mysql_query("select distinct(aflock) as newflock,date,towarehouse as farmer from ims_stocktransfer where towarehouse = '$farmer' and aflock = '$maxflock' AND (cat = 'Broiler Chicks' or cat = 'Broiler Day Old Chicks') AND client = '$client' order by date DESC",$conn) or die(mysql_error());
		$notc1 = mysql_num_rows($sq2);
		if($sq2r = mysql_fetch_assoc($sq2))
		$tcdate = $sq2r['date']; 

		if($notr1 != 0 && $notc1 != 0)
		$finaldate = $tcdate;
		else if($notr1 != 0 && $notc1 == 0)
		$finaldate = $trdate;
		else if($notr1 == 0 && $notc1 != 0)
		$finaldate = $tcdate;
		$culled = "";
		$nobde = 0;
			
if($notr1 != 0 && $notc1 != 0)
{	
	$q3 = mysql_query("select distinct(flock) as flock,cullflag,age,entrydate from broiler_daily_entry where farm ='$farmer' and flock = '$maxflock' and client = '$client' order by entrydate DESC",$conn) or die(mysql_error());
	$nobde = mysql_num_rows($q3);
	if($q3r = mysql_fetch_assoc($q3))
	{
	$culled = $q3r['cullflag'];
	$entrydate = $q3r['entrydate'];
	$age = $q3r['age'];
	$currflock = $q3r['flock'];
	}
	
	if($nobde != 0)
	{
		if($culled == 1)
		{
			$displayflock = "";
			$displayage = "";
			$displaydate = "";
			
			$warning = "Flock " . $maxflock . " has been culled";
		}
		else if($culled == 0)
		{
			$displayflock = $maxflock;
			$displayage = $age + 1;
			$displaydate = date("d.m.Y",strtotime($entrydate) + 86400);
		}
	}
	else if($nobde == 0)
	{
		$displayflock = $maxflock;
		$displayage = 1;
		$displaydate = date("d.m.Y",strtotime($finaldate));
	}
}
else
{
	if($notc1 == 0 && $notr1 != 0)
	{
	$displaydate = date("d.m.Y");
	$warning = "Please do Chicks Transfer for the Flock: " . $maxflock;
	}
	else if($notr1 == 0 && $notc1 != 0)
	{
	$displaydate = date("d.m.Y");
	$warning = "Please do Feed Transfer for the Flock: " . $maxflock;
	}
	else
	{
	$displaydate = date("d.m.Y");
	$warning = "Please do Chicks Transfer & Feed Transfer";
	}
	
}


?>
/*
document.getElementById('mort@0').value = "<?php echo  $aa; ?>";
document.getElementById('cull@0').value = "<?php echo  $aaa; ?>";*/
document.getElementById('dispflock').value = "<?php echo $displayflock; ?>";
document.getElementById('dispage').value = "<?php echo $displayage; ?>";
document.getElementById('dispdate').value = "<?php echo $displaydate; ?>";
document.getElementById('trc1').value = "<?php echo $chickstrdate; ?>";

<?php
echo "}";
}





$query="select distinct(warehouse) from pp_sobi where description = 'Broiler Chicks' AND client = '$client' order by warehouse asc";
$result=mysql_query($query,$conn);
while($rows=mysql_fetch_array($result))
{
$newflock =""; $ToFlock="";$maxflock = "";$displayflock1="";$displayage1="";$displaydate1="";$notr1 = 0; $notc1 = 0;$farmer ="";$notc =0;$notr=0;
echo "if(b=='$rows[warehouse]') { ";
$i++;
$farmer=$rows['warehouse'];

      $q1 = mysql_query("select distinct(aflock) as ToFlock, date as Date, towarehouse as Farmer1 from ims_stocktransfer where towarehouse ='$farmer' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
	 $notr = mysql_num_rows($q1);
		
	   if($nt1 = mysql_fetch_assoc($q1))
        $ToFlock = $nt1['ToFlock'];
		$feedtrdate = $nt1['date'];
	 
	
	  $q2 = mysql_query("select distinct(flock) as newflock,date,warehouse as farmer from pp_sobi where warehouse = '$farmer' AND description = 'Broiler Chicks' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
	 $notc = mysql_num_rows($q2);
		
		if($nt2 = mysql_fetch_assoc($q2))
		$newflock = $nt2['newflock'];
		$chkpurdate = $nt2['date'];

		
		if($newflock == $ToFlock)
		{
		$maxflock = $newflock;
		}
		else
		{
		$maxflock = $ToFlock;
		}
		
		$sq1 = mysql_query("select distinct(aflock) as ToFlock,date as Date,towarehouse as Farmer1 from ims_stocktransfer where towarehouse = '$farmer' and aflock = '$maxflock' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
		
		$notr1 = mysql_num_rows($sq1);
		if($sq1r = mysql_fetch_assoc($sq1))
		$trdate = $sq1r['Date'];
	
		$sq2 = mysql_query("select distinct(flock) as newflock,date,warehouse as farmer from pp_sobi where warehouse = '$farmer' and flock = '$maxflock' AND description = 'Broiler Chicks' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
		$notc1 = mysql_num_rows($sq2);
		if($sq2r = mysql_fetch_assoc($sq2))
		$tcdate = $sq2r['date']; 
		$chickspurdate = $tcdate;
		
		if($notr1 != 0 && $notc1 != 0)
		$finaldate = $tcdate;
		else if($notr1 != 0 && $notc1 == 0)
		$finaldate = $trdate;
		else if($notr1 == 0 && $notc1 != 0)
		$finaldate = $tcdate;
		$culled = "";
		$nobde = 0;
  
if($notr1 != 0 && $notc1 != 0)
{

	$q3 = mysql_query("select distinct(flock) as flock,cullflag,age,entrydate from broiler_daily_entry where farm ='$farmer' and flock = '$maxflock' and client = '$client' order by entrydate DESC",$conn) or die(mysql_error());
	$nobde = mysql_num_rows($q3);
	if($q3r = mysql_fetch_assoc($q3))
	{
	$culled = $q3r['cullflag'];
	$entrydate = $q3r['entrydate'];
	$age = $q3r['age'];
	$currflock = $q3r['flock'];
	}
	
	if($nobde != 0)
	{
		if($culled == 1)
		{
			$displayflock1 = "";
			$displayage1 = "";
			$displaydate1 = "";
			
			$warning = "Flock " . $maxflock . " has been culled";
		}
		else if($culled == 0)
		{
			$displayflock1 = $maxflock;
			$displayage1 = $age + 1;
			$displaydate1 = date("d.m.Y",strtotime($entrydate) + 86400);
		}
	}
	else if($nobde == 0)
	{
	
		$displayflock1 = $maxflock;
		$displayage1 = 1;
		$displaydate1 = date("d.m.Y",strtotime($finaldate));
	}
}
else
{

	if($notc1 == 0 && $notr1 != 0)
	{
	$displaydate1 = date("d.m.Y");
	$warning = "Please do Chicks Purchase for the Flock: " . $maxflock;
	}
	else if($notr1 == 0 && $notc1 != 0)
	{
	$displaydate1 = date("d.m.Y");
	$warning = "Please do Feed Transfer for the Flock: " . $maxflock;
	}
	else
	{
	$displaydate1 = date("d.m.Y");
	$warning = "Please do Chicks Purchase & Feed Transfer";
	}
	
}



?>
document.getElementById('dispflock1').value = "<?php echo $displayflock1; ?>";
document.getElementById('dispage1').value = "<?php echo $displayage1; ?>";
document.getElementById('dispdate1').value = "<?php echo $displaydate1; ?>";
document.getElementById('prc1').value = "<?php echo $chickspurdate; ?>";
<?php
echo "}";

}
?>
dispflk =document.getElementById('dispflock').value;
dispage = document.getElementById('dispage').value;
dispdate = document.getElementById('dispdate').value;
dispflk1 =document.getElementById('dispflock1').value;
dispage1 = document.getElementById('dispage1').value;
dispdate1 = document.getElementById('dispdate1').value;
trc = document.getElementById('trc1').value ;
prc = document.getElementById('prc1').value ;

if((dispflk != "") && (dispflk1 == ""))
{
dispflk2 =dispflk;
dispage2 = dispage;
dispdate2 = dispdate;
}
else if((dispflk == "") && (dispflk1 != ""))
{
dispflk2 =dispflk1;
dispage2 = dispage1;
dispdate2 = dispdate1;
}
else if((dispflk != "") && (dispflk1 != ""))
{
if(prc > trc)
{
dispflk2 =dispflk1;
dispage2 = dispage1;
dispdate2 = dispdate1;
}
else
{
dispflk2 =dispflk;
dispage2 = dispage;
dispdate2 = dispdate;
}
}
document.getElementById('flock@' + a).value = dispflk2;
document.getElementById('age@' + a).value = dispage2;
document.getElementById('date1@' + a).value = dispdate2;
<?php
/*if(($displayflock != "") && ($displayflock1 == ""))
{
$displayflock2 =  $displayflock;
$displayage2 = $displayage;
$displaydate2 = $displaydate;
}
else if(($displayflock == "") && ($displayflock1 != ""))
{
$displayflock2 =  $displayflock1;
$displayage2 = $displayage1;
$displaydate2 = $displaydate1;
}
else if(($displayflock != "") && ($displayflock1 != ""))
{
if($chickspurdate > $chickstrdate)
{
$displayflock2 =  $displayflock1;
$displayage2 = $displayage1;
$displaydate2 = $displaydate1;
}
else
{
$displayflock2 =  $displayflock;
$displayage2 = $displayage;
$displaydate2 = $displaydate;
}
}


if(($no1 >0) || ($no2 >0))
{
?>
document.getElementById('flock@' + a).value = "<?php echo $displayflock2; ?>";
document.getElementById('age@' + a).value = "<?php echo $displayage2; ?>";
document.getElementById('date1@' + a).value = "<?php echo $displaydate2; ?>";
<?php
}*/
/*$query1="select distinct(warehouse) from pp_sobi";
$result1=mysql_query($query1,$conn) or die(mysql_error());
while($rows1=mysql_fetch_array($result1))
{
echo "if(b=='$rows1[warehouse]') { ";
$j++;
$farmer1=$rows1['warehouse'];


$query4 = mysql_query("select date,flock from pp_sobi where warehouse='$farmer1' order by id desc") or die(mysql_error());
$r4no = mysql_num_rows($query4);
if($rows4 = mysql_fetch_assoc($query4))
$displayflock = $rows4['flock'];

if($displayflock!="")
{
 $displayage="1";
 $displaydate=date("d.m.Y",strtotime($rows4['date']));
}
?>
document.getElementById('flock@' + a).value = "<?php echo  $displayflock; ?>";
document.getElementById('age@' + a).value = "<?php echo $displayage; ?>";
document.getElementById('date1@' + a).value = "<?php echo $displaydate; ?>";
<?php
echo "}";
} */
?>

if(document.getElementById('farm@' + a ).value == "")
{
document.getElementById('flock@' + a).value = "";
document.getElementById('age@' + a).value = "";
document.getElementById('date1@' + a).value = "";
//document.getElementById('Save').disabled = true;
//document.getElementById('vquantity@' + a).onfocus = "";
alert("Please select Farm");
return;
}
var i1,j1;
for(var i = 0;i<=index;i++)
{
	for(var j = 0;j<=index;j++)
	{
		i1=i;
		j1=j;
		
		if( i != j)
		{
			if(document.getElementById('farm@' + i1).value == document.getElementById('farm@' + j1).value)
			{
				//document.getElementById('Save').disabled = true;
				document.getElementById('flock@' + a).value = "";
				document.getElementById('age@' + a).value = "";
				document.getElementById('date1@' + a).value = "";
				//document.getElementById('vquantity@' + a).onfocus = "";
				alert("Please select different combination");
				document.getElementById('farm@' + j1).options[0].selected = true;
				return;
			}
		}
	}
}
//document.getElementById('Save').disabled = false;
//document.getElementById('vquantity@' + a).onfocus = function ()  {  makeForm(); };


 <?php /*?><?php
	 $notr = 0; $notc = 0; $nobde = 0; $culled =""; $notc1 = 0; $nobde1 = 0; $culled1 =""; $nobde2 = 0; $culled2 ="";
	 $notc2 = 0; $nobde3 = 0; $culled3 =""; $nobde4 = 0; $culled4 =""; $ToFlock = ""; $newflock = ""; $newflock1 = "";
	 $bdeflock = ""; $bdeflock1 = "";
     include "config.php";	 
     $q = mysql_query("select distinct(name) as name from broiler_farm ORDER BY name ASC");
	 
     while($nt = mysql_fetch_assoc($q))
	 {
     echo "if(document.getElementById('farm@' + a).value == '$nt[name]') { ";
     $q1 = mysql_query("select distinct(ToFlock) as ToFlock,Date,Farmer1 from broiler_feedtransfer where Farmer1 ='$nt[name]' order by Date DESC") or die(mysql_error());
	 	$notr = mysql_num_rows($q1);
		
	   if($nt1 = mysql_fetch_assoc($q1))
       $ToFlock = $nt1['ToFlock'];
	 
	 $q2 = mysql_query("select distinct(newflock) as newflock,date,farmer from transferchicks where farmer = '$nt[name]' order by date DESC") or die(mysql_error());
	 	$notc = mysql_num_rows($q2);
		
		if($nt2 = mysql_fetch_assoc($q2))
		$newflock = $nt2['newflock'];
		if($newflock > $ToFlock)
		$maxflock = $newflock;
		else
		$maxflock = $ToFlock;
		
		$sq1 = mysql_query("select distinct(ToFlock) as ToFlock,Date,Farmer1 from broiler_feedtransfer where Farmer1 = '$nt[name]' and ToFlock = '$maxflock' order by Date DESC") or die(mysql_error());
		$notr1 = mysql_num_rows($sq1);
		if($sq1r = mysql_fetch_assoc($sq1))
		$trdate = $sq1r['Date'];
		
		$sq2 = mysql_query("select distinct(newflock) as newflock,date,farmer from transferchicks where farmer = '$nt[name]' and newflock = '$maxflock' order by Date DESC") or die(mysql_error());
		$notc1 = mysql_num_rows($sq2);
		if($sq2r = mysql_fetch_assoc($sq2))
		$tcdate = $sq2r['Date'];
		
		if($notr1 != 0 && $notc1 != 0)
		$finaldate = $tcdate;
		else if($notr1 != 0 && $notc1 == 0)
		$finaldate = $trdate;
		else if($notr1 == 0 && $notc1 != 0)
		$finaldate = $tcdate;

  if($notr1 != 0 && $notc1 != 0)
  {
	$q3 = mysql_query("select distinct(flock) as flock,cullflag,age,entrydate from broiler_daily_entry where farm ='$nt[name]' and flock = '$maxflock' order by entrydate DESC") or die(mysql_error());
	$nobde = mysql_num_rows($q3);
	if($q3r = mysql_fetch_assoc($q3))
	{
	$culled = $q3r['cullflag'];
	$entrydate = $q3r['entrydate'];
	$age = $q3r['age'];
	}
	if($nobde != 0)
	{
		if($culled == 1)
		{
			?>
			alert("Flock : <?php echo $maxflock; ?> has been culled");
			document.getElementById('flock' + a).value = "";
			document.getElementById('age' + a).value = "";
			document.getElementById('date1' + a).value = "";
			document.getElementById('vquantity' + a).onfocus = "";
			document.getElementById('Save').disabled = true;
			return;
			<?php
		}	
		else if($culled == 0)
		{
			?>
			document.getElementById('flock' + a).value = "<?php echo $maxflock; ?>";
			document.getElementById('age' + a).value = "<?php echo $age + 1; ?>";
			document.getElementById('date1' + a).value = "<?php echo date("d.m.Y",strtotime($entrydate) + 86400); ?>";
			<?php	
		}
	}
	else if($nobde == 0)
	{
		?>
		document.getElementById('flock' + a).value = "<?php echo $maxflock; ?>";
		document.getElementById('age' + a).value = "<?php echo 1; ?>";
		document.getElementById('date1' + a).value = "<?php echo date("d.m.Y",strtotime($finaldate)); ?>";
		<?php	
	}
}
else
{
	if($notc1 == 0 && $notr1 != 0)
	{
	?>
	alert("Plese do chicks transfer for the Flock : <?php echo $maxflock; ?>");
	document.getElementById('flock' + a).value = "";
	document.getElementById('age' + a).value = "";
	document.getElementById('date1' + a).value = "";
	document.getElementById('vquantity' + a).onfocus = "";
	document.getElementById('Save').disabled = true;
	return;
	<?php
	}
	else if($notr1 == 0 && $notc1 != 0)
	{
	?>
	alert("Plese do feed transfer for the Flock : <?php echo $maxflock; ?>");
	document.getElementById('flock' + a).value = "";
	document.getElementById('age' + a).value = "";
	document.getElementById('date1' + a).value = "";
	document.getElementById('vquantity' + a).onfocus = "";
	document.getElementById('Save').disabled = true;
	return;
	<?php
	}
	else
	{
	?>
	alert("Plese do feed & chicks transfer");
	document.getElementById('flock' + a).value = "";
	document.getElementById('age' + a).value = "";
	document.getElementById('date1' + a).value = "";
	document.getElementById('vquantity' + a).onfocus = "";
	document.getElementById('Save').disabled = true;
	return;
	<?php
	}
	
}	
	
   echo "}";
 }<?php */?>

}

function fun(a,b) 
{

document.getElementById('flock@' + a).value = "";
document.getElementById('age@' + a).value = "";
document.getElementById('date1@' + a).value = "";

<?php
$query="select distinct(towarehouse) from ims_stocktransfer";
$result=mysql_query($query,$conn) or die(mysql_error());
while($rows=mysql_fetch_array($result))
{
echo "if(b=='$rows[towarehouse]') { ";
$i++;
$farmer=$rows['towarehouse'];

     $q1 = mysql_query("select distinct(aflock) as ToFlock, date as Date, towarehouse as Farmer1 from ims_stocktransfer where towarehouse ='$farmer' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
	 	$notr = mysql_num_rows($q1);
		
	   if($nt1 = mysql_fetch_assoc($q1))
        $ToFlock = $nt1['ToFlock'];
	 
	 $q2 = mysql_query("select distinct(aflock) as newflock,date,towarehouse as farmer from ims_stocktransfer where towarehouse = '$farmer' AND cat = 'Broiler Chicks' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
	 	$notc = mysql_num_rows($q2);
		
		if($nt2 = mysql_fetch_assoc($q2))
		$newflock = $nt2['newflock'];
		
		if($newflock > $ToFlock)
		$maxflock = $newflock;
		else
		$maxflock = $ToFlock;
		
		$sq1 = mysql_query("select distinct(aflock) as ToFlock,date as Date,towarehouse as Farmer1 from ims_stocktransfer where towarehouse = '$farmer' and aflock = '$maxflock' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
		$notr1 = mysql_num_rows($sq1);
		if($sq1r = mysql_fetch_assoc($sq1))
		$trdate = $sq1r['Date'];
	
		$sq2 = mysql_query("select distinct(aflock) as newflock,date,towarehouse as farmer from ims_stocktransfer where towarehouse = '$farmer' and aflock = '$maxflock' AND cat = 'Broiler Chicks' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
		$notc1 = mysql_num_rows($sq2);
		if($sq2r = mysql_fetch_assoc($sq2))
		$tcdate = $sq2r['date']; 
		$chickstrdate = $tcdate;

		if($notr1 != 0 && $notc1 != 0)
		$finaldate = $tcdate;
		else if($notr1 != 0 && $notc1 == 0)
		$finaldate = $trdate;
		else if($notr1 == 0 && $notc1 != 0)
		$finaldate = $tcdate;
		$culled = "";
		$nobde = 0;
  
if($notr1 != 0 && $notc1 != 0)
{
	$q3 = mysql_query("select distinct(flock) as flock,cullflag,age,entrydate from broiler_daily_entry where farm ='$farmer' and flock = '$maxflock' and client = '$client' order by entrydate DESC",$conn) or die(mysql_error());
	$nobde = mysql_num_rows($q3);
	if($q3r = mysql_fetch_assoc($q3))
	{
	$culled = $q3r['cullflag'];
	$entrydate = $q3r['entrydate'];
	$age = $q3r['age'];
	$currflock = $q3r['flock'];
	}
	
	if($nobde != 0)
	{
		if($culled == 1)
		{
			$displayflock = "";
			$displayage = "";
			$displaydate = "";
			
			$warning = "Flock " . $maxflock . " has been culled";
		}
		else if($culled == 0)
		{
			$displayflock = $maxflock;
			$displayage = $age + 1;
			$displaydate = date("d.m.Y",strtotime($entrydate) + 86400);
		}
	}
	else if($nobde == 0)
	{
		$displayflock = $maxflock;
		$displayage = 1;
		$displaydate = date("d.m.Y",strtotime($finaldate));
	}
}
else
{
	if($notc1 == 0 && $notr1 != 0)
	{
	$displaydate = date("d.m.Y");
	$warning = "Please do Chicks Transfer for the Flock: " . $maxflock;
	}
	else if($notr1 == 0 && $notc1 != 0)
	{
	$displaydate = date("d.m.Y");
	$warning = "Please do Feed Transfer for the Flock: " . $maxflock;
	}
	else
	{
	$displaydate = date("d.m.Y");
	$warning = "Please do Chicks Transfer & Feed Transfer";
	}
	
}


?>
document.getElementById('flock@' + a).value = "<?php echo $displayflock; ?>";
document.getElementById('age@' + a).value = "<?php echo $displayage; ?>";
document.getElementById('date1@' + a).value = "<?php echo $displaydate; ?>";
<?php
echo "}";
}


$query="select distinct(warehouse) from pp_sobi where description = 'Broiler Chicks' AND client = '$client' order by warehouse asc";
$result=mysql_query($query,$conn) or die(mysql_error());
while($rows=mysql_fetch_array($result))
{
echo "if(b=='$rows[warehouse]') { ";
$i++;
$farmer=$rows['warehouse'];

     $q1 = mysql_query("select distinct(aflock) as ToFlock, date as Date, towarehouse as Farmer1 from ims_stocktransfer where towarehouse ='$farmer' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
	 $notr = mysql_num_rows($q1);
		
	   if($nt1 = mysql_fetch_assoc($q1))
        $ToFlock = $nt1['ToFlock'];
	 
	  $q2 = mysql_query("select distinct(flock) as newflock,date,warehouse as farmer from pp_sobi where warehouse = '$farmer' AND description = 'Broiler Chicks' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
	 $notc = mysql_num_rows($q2);
		
		if($nt2 = mysql_fetch_assoc($q2))
		$newflock = $nt2['newflock'];
		
		if($newflock > $ToFlock)
		$maxflock = $newflock;
		else
		$maxflock = $ToFlock;
		
		$sq1 = mysql_query("select distinct(aflock) as ToFlock,date as Date,towarehouse as Farmer1 from ims_stocktransfer where towarehouse = '$farmer' and aflock = '$maxflock' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
		$notr1 = mysql_num_rows($sq1);
		if($sq1r = mysql_fetch_assoc($sq1))
		$trdate = $sq1r['Date'];
	
		$sq2 = mysql_query("select distinct(flock) as newflock,date,warehouse as farmer from pp_sobi where warehouse = '$farmer' and flock = '$maxflock' AND description = 'Broiler Chicks' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
		$notc1 = mysql_num_rows($sq2);
		if($sq2r = mysql_fetch_assoc($sq2))
		$tcdate = $sq2r['date']; 
		$chickspurdate = $tcdate;
		
		if($notr1 != 0 && $notc1 != 0)
		$finaldate = $tcdate;
		else if($notr1 != 0 && $notc1 == 0)
		$finaldate = $trdate;
		else if($notr1 == 0 && $notc1 != 0)
		$finaldate = $tcdate;
		$culled = "";
		$nobde = 0;
  
if($notr1 != 0 && $notc1 != 0)
{
	$q3 = mysql_query("select distinct(flock) as flock,cullflag,age,entrydate from broiler_daily_entry where farm ='$farmer' and flock = '$maxflock' and client = '$client' order by entrydate DESC",$conn) or die(mysql_error());
	$nobde = mysql_num_rows($q3);
	if($q3r = mysql_fetch_assoc($q3))
	{
	$culled = $q3r['cullflag'];
	$entrydate = $q3r['entrydate'];
	$age = $q3r['age'];
	$currflock = $q3r['flock'];
	}
	
	if($nobde != 0)
	{
		if($culled == 1)
		{
			$displayflock1 = "";
			$displayage1 = "";
			$displaydate1 = "";
			
			$warning = "Flock " . $maxflock . " has been culled";
		}
		else if($culled == 0)
		{
			$displayflock1 = $maxflock;
			$displayage1 = $age + 1;
			$displaydate1 = date("d.m.Y",strtotime($entrydate) + 86400);
		}
	}
	else if($nobde == 0)
	{
		$displayflock1 = $maxflock;
		$displayage1 = 1;
		$displaydate1 = date("d.m.Y",strtotime($finaldate));
	}
}
else
{
	if($notc1 == 0 && $notr1 != 0)
	{
	$displaydate1 = date("d.m.Y");
	$warning = "Please do Chicks Purchase for the Flock: " . $maxflock;
	}
	else if($notr1 == 0 && $notc1 != 0)
	{
	$displaydate1 = date("d.m.Y");
	$warning = "Please do Feed Transfer for the Flock: " . $maxflock;
	}
	else
	{
	$displaydate1 = date("d.m.Y");
	$warning = "Please do Chicks Purchase & Feed Transfer";
	}
	
}


?>
document.getElementById('flock@' + a).value = "<?php echo $displayflock1; ?>";
document.getElementById('age@' + a).value = "<?php echo $displayage1; ?>";
document.getElementById('date1@' + a).value = "<?php echo $displaydate1; ?>";
<?php
echo "}";

}

/*if(($displayflock != "") && ($displayflock1 == ""))
{
$displayflock2 =  $displayflock;
$displayage2 = $displayage;
$displaydate2 = $displaydate;
}
else if(($displayflock == "") && ($displayflock1 != ""))
{
$displayflock2 =  $displayflock1;
$displayage2 = $displayage1;
$displaydate2 = $displaydate1;
}
else if(($displayflock != "") && ($displayflock1 != ""))
{
if($chickspurdate > $chickstrdate)
{
$displayflock2 =  $displayflock1;
$displayage2 = $displayage1;
$displaydate2 = $displaydate1;
}
else
{
$displayflock2 =  $displayflock;
$displayage2 = $displayage;
$displaydate2 = $displaydate;
}
}

if(($no1 >0) || ($no2 >0))
{
?>
document.getElementById('flock@' + a).value = "<?php echo $displayflock2; ?>";
document.getElementById('age@' + a).value = "<?php echo $displayage2; ?>";
document.getElementById('date1@' + a).value = "<?php echo $displaydate2; ?>";
<?php
}*/
/*$query1="select distinct(warehouse) from pp_sobi";
$result1=mysql_query($query1,$conn) or die(mysql_error());
while($rows1=mysql_fetch_array($result1))
{
echo "if(b=='$rows1[warehouse]') { ";
$j++;
$farmer1=$rows1['warehouse'];


$query4 = mysql_query("select date,flock from pp_sobi where warehouse='$farmer1' order by id desc") or die(mysql_error());
$r4no = mysql_num_rows($query4);
if($rows4 = mysql_fetch_assoc($query4))
$displayflock = $rows4['flock'];

if($displayflock!="")
{
 $displayage="1";
 $displaydate=date("d.m.Y",strtotime($rows4['date']));
}
?>
document.getElementById('flock@' + a).value = "<?php echo  $displayflock; ?>";
document.getElementById('age@' + a).value = "<?php echo $displayage; ?>";
document.getElementById('date1@' + a).value = "<?php echo $displaydate; ?>";
<?php
echo "}";
} */
?>

if(document.getElementById('farm@' + a ).value == "")
{
document.getElementById('flock@' + a).value = "";
document.getElementById('age@' + a).value = "";
document.getElementById('date1@' + a).value = "";
//document.getElementById('Save').disabled = true;
//document.getElementById('vquantity@' + a).onfocus = "";
alert("Please select Farm");
return;
}
var i1,j1;
for(var i = 0;i<=index;i++)
{
	for(var j = 0;j<=index;j++)
	{
		i1=i;
		j1=j;
		
		if( i != j)
		{
			if(document.getElementById('farm@' + i1).value == document.getElementById('farm@' + j1).value)
			{
				//document.getElementById('Save').disabled = true;
				document.getElementById('flock@' + a).value = "";
				document.getElementById('age@' + a).value = "";
				document.getElementById('date1@' + a).value = "";
				//document.getElementById('vquantity@' + a).onfocus = "";
				alert("Please select different combination");
				document.getElementById('farm@' + j1).options[0].selected = true;
				return;
			}
		}
	}
}
//document.getElementById('Save').disabled = false;
//document.getElementById('vquantity@' + a).onfocus = function ()  {  makeForm(); };


 <?php
	 $notr = 0; $notc = 0; $nobde = 0; $culled =""; $notc1 = 0; $nobde1 = 0; $culled1 =""; $nobde2 = 0; $culled2 ="";
	 $notc2 = 0; $nobde3 = 0; $culled3 =""; $nobde4 = 0; $culled4 =""; $ToFlock = ""; $newflock = ""; $newflock1 = "";
	 $bdeflock = ""; $bdeflock1 = "";
     include "config.php";	 
     $q = mysql_query("select distinct(name) as name from broiler_farm ORDER BY name ASC");
	 
     while($nt = mysql_fetch_assoc($q))
	 {
     echo "if(document.getElementById('farm@' + a).value == '$nt[name]') { ";
     $q1 = mysql_query("select distinct(ToFlock) as ToFlock,Date,Farmer1 from broiler_feedtransfer where Farmer1 ='$nt[name]' order by Date DESC") or die(mysql_error());
	 	$notr = mysql_num_rows($q1);
		
	   if($nt1 = mysql_fetch_assoc($q1))
       $ToFlock = $nt1['ToFlock'];
	 
	 $q2 = mysql_query("select distinct(newflock) as newflock,date,farmer from transferchicks where farmer = '$nt[name]' order by date DESC") or die(mysql_error());
	 	$notc = mysql_num_rows($q2);
		
		if($nt2 = mysql_fetch_assoc($q2))
		$newflock = $nt2['newflock'];
		if($newflock > $ToFlock)
		$maxflock = $newflock;
		else
		$maxflock = $ToFlock;
		
		$sq1 = mysql_query("select distinct(ToFlock) as ToFlock,Date,Farmer1 from broiler_feedtransfer where Farmer1 = '$nt[name]' and ToFlock = '$maxflock' order by Date DESC") or die(mysql_error());
		$notr1 = mysql_num_rows($sq1);
		if($sq1r = mysql_fetch_assoc($sq1))
		$trdate = $sq1r['Date'];
		
		$sq2 = mysql_query("select distinct(newflock) as newflock,date,farmer from transferchicks where farmer = '$nt[name]' and newflock = '$maxflock' order by Date DESC") or die(mysql_error());
		$notc1 = mysql_num_rows($sq2);
		if($sq2r = mysql_fetch_assoc($sq2))
		$tcdate = $sq2r['Date'];
		
		if($notr1 != 0 && $notc1 != 0)
		$finaldate = $tcdate;
		else if($notr1 != 0 && $notc1 == 0)
		$finaldate = $trdate;
		else if($notr1 == 0 && $notc1 != 0)
		$finaldate = $tcdate;

  if($notr1 != 0 && $notc1 != 0)
  {
	$q3 = mysql_query("select distinct(flock) as flock,cullflag,age,entrydate from broiler_daily_entry where farm ='$nt[name]' and flock = '$maxflock' order by entrydate DESC") or die(mysql_error());
	$nobde = mysql_num_rows($q3);
	if($q3r = mysql_fetch_assoc($q3))
	{
	$culled = $q3r['cullflag'];
	$entrydate = $q3r['entrydate'];
	$age = $q3r['age'];
	}
	if($nobde != 0)
	{
		if($culled == 1)
		{
			?>
			alert("Flock : <?php echo $maxflock; ?> has been culled");
			document.getElementById('flock' + a).value = "";
			document.getElementById('age' + a).value = "";
			document.getElementById('date1' + a).value = "";
			document.getElementById('vquantity' + a).onfocus = "";
			document.getElementById('Save').disabled = true;
			return;
			<?php
		}	
		else if($culled == 0)
		{
			?>
			document.getElementById('flock' + a).value = "<?php echo $maxflock; ?>";
			document.getElementById('age' + a).value = "<?php echo $age + 1; ?>";
			document.getElementById('date1' + a).value = "<?php echo date("d.m.Y",strtotime($entrydate) + 86400); ?>";
			<?php	
		}
	}
	else if($nobde == 0)
	{
		?>
		document.getElementById('flock' + a).value = "<?php echo $maxflock; ?>";
		document.getElementById('age' + a).value = "<?php echo 1; ?>";
		document.getElementById('date1' + a).value = "<?php echo date("d.m.Y",strtotime($finaldate)); ?>";
		<?php	
	}
}
else
{
	if($notc1 == 0 && $notr1 != 0)
	{
	?>
	alert("Plese do chicks transfer for the Flock : <?php echo $maxflock; ?>");
	document.getElementById('flock' + a).value = "";
	document.getElementById('age' + a).value = "";
	document.getElementById('date1' + a).value = "";
	document.getElementById('vquantity' + a).onfocus = "";
	document.getElementById('Save').disabled = true;
	return;
	<?php
	}
	else if($notr1 == 0 && $notc1 != 0)
	{
	?>
	alert("Plese do feed transfer for the Flock : <?php echo $maxflock; ?>");
	document.getElementById('flock' + a).value = "";
	document.getElementById('age' + a).value = "";
	document.getElementById('date1' + a).value = "";
	document.getElementById('vquantity' + a).onfocus = "";
	document.getElementById('Save').disabled = true;
	return;
	<?php
	}
	else
	{
	?>
	alert("Plese do feed & chicks transfer");
	document.getElementById('flock' + a).value = "";
	document.getElementById('age' + a).value = "";
	document.getElementById('date1' + a).value = "";
	document.getElementById('vquantity' + a).onfocus = "";
	document.getElementById('Save').disabled = true;
	return;
	<?php
	}
	
}	
	
   echo "}";
 }
?>

}

function loadfarms(i)
{
document.getElementById('flock@' + i).value = "";
document.getElementById('age@' + i).value = "";
document.getElementById('date1@' + i).value = "";
var supervisor = document.getElementById('supervisor').value;
var myselect = document.getElementById('farm@' + i);
removeAllOptions(document.getElementById('farm@' + i));
			theOption1=document.createElement("OPTION");
			theText1=document.createTextNode("-Select-");
			theOption1.value = "";
			theOption1.appendChild(theText1);
			myselect.appendChild(theOption1);

	<?php 
		$q = "select distinct(supervisor) from broiler_farm order by supervisor";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		echo "if( supervisor == '$qr[supervisor]' ) {";
		$q1 = "select distinct(farm) from broiler_farm where supervisor = '$qr[supervisor]' order by farm";
		$q1rs = mysql_query($q1) or die(mysql_error());
		while($q1r = mysql_fetch_assoc($q1rs))
		{
	?>
			theOption1=document.createElement("OPTION");
			theText1=document.createTextNode("<?php echo $q1r['farm']; ?>");
			theOption1.value = "<?php echo $q1r['farm']; ?>";
			theOption1.appendChild(theText1);
			myselect.appendChild(theOption1);
	
	<?php 
	} 
	echo "}";
	}
	?>
	
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

</script>