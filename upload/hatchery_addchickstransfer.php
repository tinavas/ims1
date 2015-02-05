
<?php include "jquery.php"; ?>
<?php include "hatchery_addchickstransfer1.php"; ?>

<br />
<center>
<h1>Chicks Transfer</h1>
</center>

<form id="form1" name="form1" method="post" action="hatchery_savechickstransfer.php" >
<input type="hidden" name="saed" id="saed" value="save" />
<br /><br />
<center>
<strong>Date</strong> &nbsp;&nbsp;&nbsp;
<input type="text" id="date" name="date" value="<?php echo date("d.m.Y");?>" size="12" class="datepicker" />&nbsp;&nbsp;&nbsp;

<strong>From Hatchery Unit</strong> &nbsp;&nbsp;&nbsp;
<select id="fromwarehouse" name="fromwarehouse">
<option value="">-Select-</option>
<?php include "config.php";
  $q2 = "SELECT * FROM tbl_sector WHERE type1 = 'Warehouse' AND client = '$client'";
  $r2 = mysql_query($q2,$conn);
  $n2 = mysql_num_rows($r2);

 $q1 = "SELECT * FROM tbl_sector WHERE type1 = 'Hatchery' AND client = '$client'";
 $r1 = mysql_query($q1,$conn);
 $n1 = mysql_num_rows($r1);
 if(($n1 == 0) OR ($n1 == ""))
 {
  $q2 = "SELECT * FROM tbl_sector WHERE type1 = 'Warehouse' AND client = '$client'";
  $r2 = mysql_query($q2,$conn);
  while($row2 = mysql_fetch_assoc($r2))
  {
?>
<option value="<?php echo $row2['sector']; ?>" <?php if($n2 == 1) { ?> selected=selected<?php } ?>><?php echo $row2['sector']; ?></option>
<?php
 } }
 else
 {
  while($row1 = mysql_fetch_assoc($r1))
  {
  ?>
<option value="<?php echo $row1['sector']; ?>" <?php if($n1 == 1) { ?> selected=selected<?php } ?>><?php echo $row1['sector']; ?></option>
<?php } } ?>
</select>&nbsp;&nbsp;&nbsp;

</center>
<br /><br />

<table id="paraID" align="center">
<tr  align="center">
<td width="10px"></td>
<td><strong>Farm</strong></td>
<td width="10px"></td>
<td><strong>Parent Flock</strong></td>
<td width="10px"></td>
<td><strong>Flock</strong></td>
<td width="10px"></td>
<td><strong>No.Of Chicks</strong></td>
<td width="10px"></td>
<td><strong>Price</strong></td>
<td width="10px"></td>
<td><strong>Free Chicks</strong></td>
<td width="10px"></td>
<td title="Transfer Memo/Delivery Challan"><strong>DC #</strong></td>
<td width="10px"></td>
<td title="Transportation Cost"><strong>T.Cost</strong></td>
<td width="10px"></td>
<td><strong>Vehicle No.</strong></td>
<td width="10px"></td>
<td><strong>Driver</strong></td>
<td width="10px"></td>
<td title="Transport/Box Mortality"><strong>T.Mort</strong></td>
<td width="10px"></td>
<td><strong>Shortage</strong></td>
<td width="10px"></td>
<td><strong>Remarks</strong></td>
<td width="10px"></td>
</tr>

<tr height="10px"><td></td></tr>

<tr align="center">
<td width="10px"></td>
<td>
<select name="farm[]" id="farm@-1" style="width:160px" >
<option value="">-Select-</option>
<?php include "config.php"; 

	   if($_SESSION['db'] == "feedatives")
		{
		   if($_SESSION['sectorr'] == "all")
		   {
		   	$query = "SELECT * FROM broiler_farm WHERE client = '$client' ORDER BY farm ASC ";
		   }
		   else
		   {
		   $sectorr = $_SESSION['sectorr'];
		   $query = "SELECT * FROM broiler_farm WHERE client = '$client' and place = '$sectorr' ORDER BY farm ASC ";
		   }
		   
		 }
	   else
	   {
	   $query = "SELECT * FROM broiler_farm WHERE client = '$client' ORDER BY farm ASC ";
	   }
        
      $result = mysql_query($query,$conn); 
      while($row1 = mysql_fetch_assoc($result))
      {
?>
<option value="<?php echo $row1['farm']; ?>" title="<?php echo $row1['farmer']." @ ".$row1['place']; ?>"><?php echo $row1['farm']; ?></option>
<?php } ?>
</select>
</td>

<td width="10px"></td>

<td>
<select name="parentflock[]" id="parentflock@-1" style="width:100px" onChange="fun(this,this.value)">
<option value="">Select</option>
<?php
           include "config.php"; 
           $query = "SELECT distinct(flockcode) FROM breeder_flock WHERE client = '$client' ORDER BY flockcode ASC ";
           $result = mysql_query($query,$conn); 
           $n22 = mysql_num_rows($result); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
<option value="<?php echo $row1['flockcode']; ?>" title="<?php echo $row1['flockcode']; ?>"><?php echo $row1['flockcode']; ?></option>
<?php } ?>
<?php if(($n22 == "") OR ($n22 == 0)) { 
$q2 = "SELECT * FROM tbl_sector WHERE type1 = 'Warehouse' AND client = '$client'";
  $r2 = mysql_query($q2,$conn);
  $n2 = mysql_num_rows($r2);

 $q1 = "SELECT * FROM tbl_sector WHERE type1 = 'Hatchery' AND client = '$client'";
 $r1 = mysql_query($q1,$conn);
 $n1 = mysql_num_rows($r1);
 if(($n1 == 0) OR ($n1 == ""))
 {
  $q2 = "SELECT * FROM tbl_sector WHERE type1 = 'Warehouse' AND client = '$client'";
  $r2 = mysql_query($q2,$conn);
  while($row2 = mysql_fetch_assoc($r2))
  {
?>
<option value="<?php echo $row2['sector']; ?>"><?php echo $row2['sector']; ?></option>
<?php
 } }
 else
 {
  while($row1 = mysql_fetch_assoc($r1))
  {
  ?>
<option value="<?php echo $row1['sector']; ?>"><?php echo $row1['sector']; ?></option>
<?php } } ?>

<?php } ?>
</select>
</td>

<td width="10px"></td>

<td><input type="text" name="aflock[]" id="aflock@-1" size="14" />

<input type="hidden" name="flkcount[]" id="flkcount@-1" value="" /></td>

<td width="10px"></td>

<td><input type="text" name="chicks[]" id="chicks@-1" size="8" /></td>

<td width="10px"></td>
<?php if($_SESSION['db'] == "feedatives") { ?>
<td><input type="text" name="price[]" id="price@-1" size="3"  value="20"/></td>
<?php } else {?>
<td><input type="text" name="price[]" id="price@-1" size="3"  value="0"/></td>
<?php } ?>
<td width="10px"></td>

<td><input type="text" name="freechicks[]" id="freechicks@-1" size="4" value="0" /></td>

<td width="10px"></td>



<td><input type="text" name="dc[]" id="dc@-1" size="6" value="0" /></td>

<td width="10px"></td>

<td><input type="text" name="tcost[]" id="tcost@-1" size="8" value="0"/></td>

<td width="10px"></td>

<td><input type="text" name="vehicle[]" id="vehicle@-1" size="12" /></td>

<td width="10px"></td>

<td><select name="driver[]" id="driver@-1" style="width:100px">
<option value="">-Select-</option>
<?php
           include "config.php"; 
           $query = "SELECT * FROM hr_employee where designation='Driver' AND client = '$client' ORDER BY name ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
<option value="<?php echo $row1['name']; ?>"><?php echo $row1['name']; ?></option>
<?php } ?>
</select>
</td>

<td width="10px"></td>

<td><input type="text" name="mort[]" id="mort@-1" size="6" value="0" /></td>

<td width="10px"></td>

<td><input type="text" name="shortage[]" id="shortage@-1" size="6" value="0" /></td>

<td width="10px"></td>

<td><input type="text" name="remarks[]" id="remarks@-1" size="14" /></td>

</tr>
</table>
</center>

<center>
<br />
<br />
<input type="submit" value="Save" id="Save" disabled="disabled"/>&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=hatchery_chickstransfer';">

<br />
<!-- </center> -->
</form>

<script type="text/javascript">
function script1() {
window.open('Hatchery Help/help_p_chickstransfer.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
index = -1;
function fun(b,flock) 
{ 
if(index == -1)
var a = index;
else
var a = index;

if(document.getElementById('farm@' + a ).value == "")
{ 
document.getElementById('aflock@' + a).value = "";
document.getElementById('flkcount@' + a).value = "";
document.getElementById('Save').disabled = true;
document.getElementById('remarks@' + a).onfocus = "";
alert("Please select Farm");
return;
}
if(document.getElementById('parentflock@' + a ).value == "")
{
document.getElementById('aflock@' + a).value = "";
document.getElementById('flkcount@' + a).value = "";
document.getElementById('Save').disabled = true;
document.getElementById('remarks@' + a).onfocus = "";
alert("Please select Parent Flock");
return;
}

var i1,j1;
for(var i = -1;i<=index;i++)
{ 
	for(var j = -1;j<=index;j++)
	{
		if(i == -1)
		i1 = i;
		else
		i1=i;
		
		if(j == -1)
		j1 = j;
		else
		j1=j;
		
		if( i != j)
		{
			if(document.getElementById('farm@' + i1).value == document.getElementById('farm@' + j1).value && document.getElementById('parentflock@' + i1).value == document.getElementById('parentflock@' + j1).value)
			{
				document.getElementById('Save').disabled = true;
                        document.getElementById('aflock@' + a).value = "";
				document.getElementById('flkcount@' + a).value = "";
				alert("Please select differen combination");
				document.getElementById('remarks@' + a).onfocus = "";
				return;
			}
		}
	}
}
document.getElementById('Save').disabled = false;
document.getElementById('remarks@' + a).onfocus = function ()  {  makeForm(); };

/*
//Displaying Cost
<?php
if($_SESSION['client'] == 'FEEDATIVES')
{
$query = "SELECT distinct(flock) FROM hatchery_hatchrecord WHERE client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 echo "if(flock == '$rows[flock]') { ";
 $query2 = "SELECt flock,cost FROM hatchery_hatchrecord WHERE flock = '$rows[flock]' AND client = '$client' ORDER BY transferdate DESC LIMIT 1";
 $result2 = mysql_query($query2,$conn) or die(mysql_error());
 $rows2 = mysql_fetch_assoc($result2);
 $cost = $rows2['cost'];
 ?>
 var priceid = "price@" + a;
 document.getElementById(priceid).value = "<?php echo $cost; ?>";
 <?php
 echo " } ";
}
}
?>

*/
var date1 = document.getElementById("date").value;
 var strdot1 = date1.split('.');
  var ignore = strdot1[0];
  var m = strdot1[1];
  var y = strdot1[2];
 
var date2 = new Date(y,m,ignore);

 <?php
  $notr = 0; $notc = 0; $nobde = 0; $culled =""; $notc1 = 0; $nobde1 = 0; $culled1 =""; $nobde2 = 0; $culled2 ="";
  $notc2 = 0; $nobde3 = 0; $culled3 =""; $nobde4 = 0; $culled4 =""; $ToFlock = ""; $newflock = ""; $newflock1 = "";
  $bdeflock = ""; $bdeflock1 = "";
 
  $q = mysql_query("select distinct(farm) as name from broiler_farm WHERE client = '$client' ORDER BY farm ASC");
  while($nt = mysql_fetch_assoc($q))
  {
   echo "if(document.getElementById('farm@' + a).value == '$nt[name]') { ";
     $q1 = mysql_query("select distinct(flock) as ToFlock,aflock,date,towarehouse from ims_stocktransfer where towarehouse ='$nt[name]' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC LIMIT 1") or die(mysql_error());
     $notr = mysql_num_rows($q1);

      while($nt1 = mysql_fetch_assoc($q1))
      {
         $ToFlock = $nt1['ToFlock'];
         $faflock = $nt1['aflock'];
      }

     $q2 = mysql_query("select distinct(flock) as newflock,aflock,date,towarehouse from ims_stocktransfer where towarehouse = '$nt[name]' AND cat = 'Broiler Chicks' AND client = '$client' order by date DESC LIMIT 1") or die(mysql_error());
     $notc = mysql_num_rows($q2);

  	 while($nt2 = mysql_fetch_assoc($q2))
       {
	   $newflock = $nt2['newflock'];
         $caflock = $nt2['aflock'];
       }

 	 if($newflock >= $ToFlock)
       {
          $maxflock = $newflock;
          $maxflock1 = $caflock;
       }
       else
       {
         $maxflock = $ToFlock;
         $maxflock1 = $faflock;
       } 


if($notr != 0 || $notc != 0)
{
	$q3 = mysql_query("select distinct(flock),cullflag,entrydate from broiler_daily_entry where farm ='$nt[name]' and flock = '$maxflock1' AND client = '$client' order by entrydate DESC") or die(mysql_error());
	$nobde = mysql_num_rows($q3);
	if($q3r = mysql_fetch_assoc($q3))
	{
	$culled = $q3r['cullflag'];
	$entrydate = $q3r['entrydate'];
	}
	if($nobde != 0)
	{
		if($culled == 1)
		{
			?>
			document.getElementById('aflock@' + a).value = "<?php echo $nt['name'].'-@-'.($maxflock + 1); ?>";
			document.getElementById('flkcount@' + a).value = "<?php echo $maxflock + 1; ?>";
			<?php
		}	
		else if($culled == 0)
		{ 
            ?>
                var entryd1 = '<?php echo $entrydate; ?>'; 
                var entryd2 = entryd1.split('-');
                var entryd = new Date(entryd2[0],entryd2[1],entryd2[2]);
                var diff1 = date2.getTime() - entryd.getTime();
                var diff = parseInt(Math.floor(diff1/1000/60/60/24));
                if(diff > 10) 
                {
			document.getElementById('aflock@' + a).value = "<?php echo $nt['name'].'-@-'.($maxflock + 1); ?>";
			document.getElementById('flkcount@' + a).value = "<?php echo $maxflock + 1; ?>";
                }
		   else
		   {
			document.getElementById('aflock@' + a).value = "<?php echo $nt['name'].'-@-'.$maxflock; ?>";
			document.getElementById('aflock@' + a).value = "<?php echo $maxflock1; ?>";
			document.getElementById('flkcount@' + a).value = "<?php echo $maxflock; ?>";
  		   }
  	<?php	
		}
	}
	else if($nobde == 0)
	{
		?>
		document.getElementById('aflock@' + a).value = "<?php echo $nt['name'].'-@-'.$maxflock; ?>";
		document.getElementById('aflock@' + a).value = "<?php echo $maxflock1; ?>";
		document.getElementById('flkcount@' + a).value = "<?php echo $maxflock; ?>";
		<?php
	}
	
}
else
{
 
	?>
	document.getElementById('aflock@' + a).value = "<?php echo $nt['name'].'-@-'.'1'; ?>";
	document.getElementById('flkcount@' + a).value = "<?php echo 1; ?>";
	<?php
}	
	
   echo "}";
 }
?>

}
</script>
</html>
