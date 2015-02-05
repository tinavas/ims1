<?php 
include "jquery.php";
include "config.php"; 
$client = $_SESSION['client'];
?>

<body>
<center>
<br />
<h1>Stock Transfer(Rental)</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)<br><br>
<?php
if($_SESSION['client'] == 'KWALITY')
{
?><b>Note: Broiler Feed should be entered in Bags</b>
<?php } ?>
</center>
<br /><br />

<form id="form" name="form" method="post" action="ims_savestocktransferrental.php">
<input type="hidden" name="saed" id="saed" value="save" />
<table align="center">
<tr>
 <td align="right"><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
 <td align="left"><input type="text" size="15" id="date" name="date" class="datepicker" value="<?php echo date("d.m.Y"); ?>" />&nbsp;&nbsp;&nbsp;</td>
 <td align="right"><strong>Warehouse</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
 <td align="left"><select id="warehouse" name="warehouse" style="width:180px;" onChange="loaditemcategory(this.value);">
         <option value="">-Select-</option>
		 
        <?php
if($_SESSION['client'] == 'FEEDATIVES')
{
	if($_SESSION['sectorr'] == "all")
	{
	 $q2 = "SELECT * FROM tbl_sector WHERE type1 = 'Warehouse' AND client = '$client'"; 
	}
	else
	{
	 $sectortype =  $_SESSION['sectorr'];
	$q2 = "SELECT * FROM tbl_sector WHERE type1 = 'Warehouse' AND place = '$sectortype' AND client = '$client'"; 
	}
}
else
 	$q2 = "SELECT * FROM tbl_sector WHERE type1 = 'Warehouse' AND client = '$client'"; 		 
           //$q2 = "SELECT * FROM tbl_sector WHERE type1 = 'Warehouse' AND client = '$client'"; 
		   $r2 = mysql_query($q2,$conn); $n2 = mysql_num_rows($r2);
if($_SESSION['client'] == 'FEEDATIVES')
{
	if($_SESSION['sectorr'] == "all")
	{
	 $q1 = "SELECT * FROM tbl_sector WHERE type1 = 'Hatchery' AND client = '$client'"; 
	}
	else
	{
	 $sectortype =  $_SESSION['sectorr'];
	$q1 = "SELECT * FROM tbl_sector WHERE type1 = 'Hatchery' AND client = '$client' AND place = '$sectortype'";  
	}
}
else
 	$q1 = "SELECT * FROM tbl_sector WHERE type1 = 'Hatchery' AND client = '$client'";  
		   
           //$q1 = "SELECT * FROM tbl_sector WHERE type1 = 'Hatchery' AND client = '$client'"; 
		   $r1 = mysql_query($q1,$conn); $n1 = mysql_num_rows($r1);
           $n = $n1 + $n2;
if($_SESSION['client'] == 'FEEDATIVES')
{
	if($_SESSION['sectorr'] == "all")
	{
	 $q2 = "SELECT * FROM tbl_sector WHERE type1 = 'Warehouse' AND client = '$client'"; 
	}
	else
	{
	 $sectortype =  $_SESSION['sectorr'];
	$q2 = "SELECT * FROM tbl_sector WHERE type1 = 'Warehouse' AND client = '$client' AND place = '$sectortype'";
	}
}
else
 	$q2 = "SELECT * FROM tbl_sector WHERE type1 = 'Warehouse' AND client = '$client'"; 
		   
           //$q2 = "SELECT * FROM tbl_sector WHERE type1 = 'Warehouse' AND client = '$client'"; 
		   $r2 = mysql_query($q2,$conn);
           while($row2 = mysql_fetch_assoc($r2))
           {
        ?>
        <option value="<?php echo $row2['sector'].'@'.$row2['type1']; ?>" <?php if($n == 1) { ?> selected="selected" <?php } ?>><?php echo $row2['sector']; ?></option>
        <?php }
if($_SESSION['client'] == 'FEEDATIVES')
{
	if($_SESSION['sectorr'] == "all")
	{
	 $q1 = "SELECT * FROM tbl_sector WHERE type1 = 'Hatchery' AND client = '$client'"; 
	}
	else
	{
	 $sectortype =  $_SESSION['sectorr'];
	 $q1 = "SELECT * FROM tbl_sector WHERE type1 = 'Hatchery' AND client = '$client' AND place = '$sectortype'";  
	}
}
else
 	$q1 = "SELECT * FROM tbl_sector WHERE type1 = 'Hatchery' AND client = '$client'";  
		 
          //$q1 = "SELECT * FROM tbl_sector WHERE type1 = 'Hatchery' AND client = '$client'"; 
		  $r1 = mysql_query($q1,$conn);
        while($row1 = mysql_fetch_assoc($r1)) { ?>
          <option value="<?php echo $row1['sector'].'@'.$row1['type1']; ?>" <?php if($n == 1) { ?> selected="selected" <?php } ?>><?php echo $row1['sector']; ?></option>
       <?php } ?>

<?php
      $q1 = "SELECT distinct(flockcode) FROM breeder_flock WHERE client = '$client' order by flockcode ASC";
      $r1 = mysql_query($q1,$conn);
      while($row1 = mysql_fetch_assoc($r1)) { ?>
  <option value="<?php echo $row1['flockcode']; ?>" title="<?php echo $row1['flockcode']; ?>"><?php echo $row1['flockcode']; ?></option>
<?php } ?>    

  
<?php
if($_SESSION['client'] == 'FEEDATIVES')
{
	if($_SESSION['sectorr'] == "all")
	{
	  $q1 = "SELECT distinct(farm) FROM broiler_farm WHERE client = '$client' AND type = 'rental' order by farm ASC";
	}
	else
	{
	 $sectortype =  $_SESSION['sectorr'];
	 $q1 = "SELECT distinct(farm) FROM broiler_farm WHERE client = '$client' AND place = '$sectortype' AND type == 'rental' order by farm ASC";  
	}
}
else
 	 $q1 = "SELECT distinct(farm) FROM broiler_farm WHERE client = '$client' order by farm ASC";

      //$q1 = "SELECT distinct(farm) FROM broiler_farm WHERE client = '$client' order by farm ASC";
      $r1 = mysql_query($q1,$conn);
      while($row1 = mysql_fetch_assoc($r1)) { ?>
  <option value="<?php echo $row1['farm']; ?>" title="<?php echo $row1['farm']; ?>"><?php echo $row1['farm']; ?></option>
<?php } ?>   

       </select>
 </td>
</tr>
<tr style="height:20px"></tr>
</table>

<table id="paraID" align="center">
<tr align="center">
  <th width="10px">&nbsp;</th>
  <th><strong>Category</strong></th>
  <th width="10px">&nbsp;</th>
  <th><strong>Code</strong></th>
  <th width="10px">&nbsp;</th>
  <th><strong>Description</strong></th>
  <th width="10px">&nbsp;</th>
  <th><strong>Units</strong></th>
  <th width="10px">&nbsp;</th>
  <th><strong>To</strong></th>
   <?php if($_SESSION['db'] == 'feedatives'){?>
   <th width="10px">&nbsp;</th>
  <th><strong>Type   </strong></th>
   <th width="10px">&nbsp;</th>
  <th><strong>Flock   </strong></th>
  <?php } ?>
   <th width="10px">&nbsp;</th>
  <th style="text-align:left"><strong>Quantity</strong></th>
  <th width="10px">&nbsp;</th>
  <th title="Transfer Memo/Delivery Challan"><strong>DC #</strong></th>
  <th width="10px">&nbsp;</th>
  <th title="Transportation Cost"><strong>T.Cost</strong></th>
  <th width="10px">&nbsp;</th>
  <th><strong>Vehicle No</strong></th>
  <th width="10px">&nbsp;</th>
  <th><strong>Remarks</strong></th>
  <th width="10px">&nbsp;</th>
</tr>

<tr style="height:10px"></tr>

<tr align="center">
<td width="10px">&nbsp;</td>
 <td><select id="cat@-1" name="cat[]" onChange="getcode(this.id);" style="width:120px"><option value="">-Select-</option>
        <?php $q = "select distinct(type) from ims_itemtypes WHERE type <> 'Broiler Birds' AND (type <> 'Broiler Chicks' or type <> 'Broiler Day Old Chicks')  AND type <> 'Consumables' AND type <> 'Eggs' AND type <> 'Equipments' AND type <> 'Female Birds' AND type <> 'Male Birds' AND type <> 'Stationary' AND type <> 'Wastages' AND client = '$client' order by type"; $qrs = mysql_query($q,$conn) or die(mysql_error());
        while($qr = mysql_fetch_assoc($qrs)) { ?>
    <option value="<?php echo $qr['type']; ?>"><?php echo $qr['type']; ?></option>
       <?php } ?></select>
 </td>

 <td width="10px"></td>

<td><select style="Width:75px" name="code[]" id="code@-1" onChange="selectdesc(this.id);">
	<option>-Select-</option>
	</select>
</td>

 <td width="10px">&nbsp;</td>

<td>
<select style="Width:130px" name="desc[]" id="desc@-1" onChange="selectcode(this.id);">
     		<option>-Select-</option>
</select>
<input type="hidden" size="15" id="description@-1" name="description[]" value="" readonly/>
</td>

<td width="10px">&nbsp;</td>

<td><input type="text" size="8" id="units@-1" name="units[]" value="" readonly/></td>

<td width="10px">&nbsp;</td>

<td><select style="Width:140px" id="towarehouse@-1" name="towarehouse[]" <?php if($_SESSION['db'] == 'feedatives'){?> onChange="getfarm(this.id,this.value);" <?php } ?> ><option value="">-Select-</option>


<?php
      $q1 = "SELECT distinct(flockcode) FROM breeder_flock WHERE client = '$client' and cullflag='0' order by flockcode ASC";
      $r1 = mysql_query($q1,$conn);
      while($row1 = mysql_fetch_assoc($r1)) { ?>
  <option value="<?php echo $row1['flockcode']; ?>" title="<?php echo $row1['flockcode']; ?>"><?php echo $row1['flockcode']; ?></option>
<?php } ?>    

<?php
if($_SESSION['client'] == 'FEEDATIVES')
{
	if($_SESSION['sectorr'] == "all")
	{
	 $q1 = "SELECT * FROM tbl_sector WHERE type1 = 'Warehouse' AND client = '$client' order by sector ASC";
	}
	else
	{
	 $sectortype =  $_SESSION['sectorr'];
	$q1 = "SELECT * FROM tbl_sector WHERE type1 = 'Warehouse' AND place = '$sectortype' AND client = '$client' order by sector ASC";
	}
}
else
 	$q1 = "SELECT * FROM tbl_sector WHERE type1 = 'Warehouse' AND client = '$client' order by sector ASC";

      //$q1 = "SELECT * FROM tbl_sector where type1 = 'Warehouse' AND client = '$client' order by sector ASC";
      $r1 = mysql_query($q1,$conn);
      while($row1 = mysql_fetch_assoc($r1)) { ?>
  <option value="<?php echo $row1['sector']; ?>" title="<?php echo $row1['sector']; ?>"><?php echo $row1['sector']; ?></option>
<?php } ?>         
  
<?php
if($_SESSION['client'] == 'FEEDATIVES')
{
	if($_SESSION['sectorr'] == "all")
	{
	  $q1 = "SELECT farm FROM broiler_farm WHERE client = '$client' AND type = 'rental' order by farm ASC";
	}
	else
	{
	 $sectortype =  $_SESSION['sectorr'];
	 $q1 = "SELECT farm FROM broiler_farm WHERE client = '$client' AND place = '$sectortype' AND type = 'rental' order by farm ASC";  
	}
}
else
 	 $q1 = "SELECT distinct(farm) FROM broiler_farm WHERE client = '$client' order by farm ASC";

      //$q1 = "SELECT distinct(farm) FROM broiler_farm WHERE client = '$client' order by farm ASC";
      $r1 = mysql_query($q1,$conn);
      while($row1 = mysql_fetch_assoc($r1)) { ?>
  <option value="<?php echo $row1['farm']; ?>" title="<?php echo $row1['farm']; ?>"><?php echo $row1['farm']; ?></option>
<?php } ?> 


</select>
</td>
<?php if($_SESSION['db'] == "feedatives"){?>

<td width="10px">&nbsp;</td>

<td><select id="type@-1" name="type[]" style="width:100px"  onChange="changetype(this.id,this.value)">
<option value="Existing">Existing</option>
<option value="New">New</option>
</select></td>
<td width="10px">&nbsp;</td>

<td><input type="text" name="aflock[]" id="aflock@-1" size="14" <?php if($_SESSION['db'] == 'feedatives'){?> style="display:none" <?php }?> onBlur="checkFlock(this.value,this.id);" />


<?php if($_SESSION['db'] == 'feedatives'){?>
<select name="existflock[]" id="existflock@-1" style="width:100px">
<option value="">-Select-</option>
<?php } ?>

<?php } ?>
<!--<td width="10px">&nbsp;</td>

<td><select id="flock@-1" name="flock[]" style="width:80px"><option value="">-Select-</option>

</select>
</td>
-->
<td  width="10px">&nbsp;</td>

<td> <input type="text" size="8" id="squantity@-1" name="squantity[]" value="" /></td>

<td width="10px">&nbsp;</td>

<td> <input type="text" size="4" id="tmno@-1" name="tmno[]" value="0" /></td>

<td  width="10px">&nbsp;</td>

<td> <input type="text" size="4" id="tcost@-1" name="tcost[]" value="0" width="20px"/></td>

<td  width="10px">&nbsp;</td>

<td> <input type="text" size="10" id="vno@-1" name="vno[]" value="" /></td>

<td  width="10px">&nbsp;</td>

<td> <input type="text" size="8" id="remarks@-1" name="remarks[]" value="" onFocus="makeForm();"/></td>

<td  width="10px">&nbsp;</td><td>


</tr>
</table>

<br/>

<table align="center">
<tr>
<td colspan="5" align="center">
<center>
<input type="submit" id="Save" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" id="Cancel" value="Cancel" onClick="document.location = 'dashboardsub.php?page=ims_stocktransferrental';"/>
</center>
</td>
</tr>
</table>
</form>
	<script type="text/javascript">
function script1() {
window.open('IMSHelp/help_t_addstocktransferrental.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
<script type="text/javascript">
function getfarm(a,b)
{
var typeindex = a.substr(12);
 var typeid = "flock@"+typeindex;
 myselect1 = document.getElementById(typeid);
 
 for($i=myselect1.length;$i>0;$i--)
  myselect1.remove($i);

<?php
$query ="SELECT distinct(farm) FROM broiler_daily_entry WHERE client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_query());
while($rows = mysql_fetch_assoc($result))
{
 echo "if(b == '$rows[farm]') {";
 $query2 = "SELECT distinct(flock) FROM broiler_daily_entry WHERE farm = '$rows[farm]' AND flock NOT IN ( SELECT flock FROM broiler_transferrate WHERE client = '$client' AND farmer = '$rows[farm]') AND client = '$client'";
 $result2 = mysql_query($query2,$conn) or die(mysql_error());
 while($rows2 = mysql_fetch_assoc($result2))
 {
 ?>
 theOption1=document.createElement("OPTION");
 theText1=document.createTextNode("<?php echo $rows2['flock']; ?>");
 theOption1.appendChild(theText1);
 theOption1.value = "<?php echo $rows2['flock']; ?>";
 theOption1.title = "<?php echo $rows2['flock']; ?>";
 myselect1.appendChild(theOption1);
 
 <?php
 }
 echo " } ";
}
?>
}


<?php
 $q2 = "SELECT * FROM tbl_sector WHERE client = '$client'"; $r2 = mysql_query($q2,$conn); $n2 = mysql_num_rows($r2);
 while($row2 = mysql_fetch_assoc($r2))
 {
?>
//var <?php echo $row2['sector'].'_'.$row2['type1']; ?> = new Array();
<!--warehouse['<?php echo $row2['sector'].'-'.$row2['type1']; ?>'] = { }; -->
<?php } ?>

///////////////makeform//////////////
var index = -1;

function loaditemcategory(b)
{
 //alert(b);
var t =  document.getElementsByName("cat");
//alert(t[0].name);

}
function selectdesc(codeid)
{
     var temp = codeid.split("@");
     var tempindex = temp[1];
     document.getElementById("desc@" + tempindex).value = document.getElementById("code@" + tempindex).value;
     var w = document.getElementById("desc@" + tempindex).selectedIndex; 
     var description = document.getElementById("desc@" + tempindex).options[w].text;
     document.getElementById("description@" + tempindex).value = description;
	 var code1 = document.getElementById("code@" + tempindex).value;
	<?php 
			$q = "select distinct(code) from ims_itemcodes where source = 'Purchased' or source = 'Produced or Purchased' order by code";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(code1 == '$qr[code]') {";
			$q1 = "select distinct(description),sunits from ims_itemcodes where code = '$qr[code]' order by description";
			$q1rs = mysql_query($q1) or die(mysql_error());
			if($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
				document.getElementById('units@' + tempindex).value = "<?php echo $q1r['sunits'];?>";
	<?php
			}
			echo "}";
			}
	?>
}
function selectcode(codeid)
{
     var temp = codeid.split("@");
     var tempindex = temp[1];
     document.getElementById("code@" + tempindex).value = document.getElementById("desc@" + tempindex).value;
     var w = document.getElementById("desc@" + tempindex).selectedIndex; 
     var description = document.getElementById("desc@" + tempindex).options[w].text;
     document.getElementById("description@" + tempindex).value = description;
	 var code1 = document.getElementById("code@" + tempindex).value;
	<?php 
			$q = "select distinct(code) from ims_itemcodes where source = 'Purchased' or source = 'Produced or Purchased' order by code";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(code1 == '$qr[code]') {";
			$q1 = "select distinct(description),sunits from ims_itemcodes where code = '$qr[code]' order by description";
			$q1rs = mysql_query($q1) or die(mysql_error());
			if($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
				document.getElementById('units@' + tempindex).value = "<?php echo $q1r['sunits'];?>";
	<?php
			}
			echo "}";
			}
	?>
}



function getdesc(code)
{
	var code1 = document.getElementById(code).value;
	temp = code.split("@");
	var index1 = temp[1];
	

	<?php 
			$q = "select distinct(code) from ims_itemcodes WHERE client = '$client'";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(code1 == '$qr[code]') {";
			$q1 = "select distinct(description),sunits from ims_itemcodes where code = '$qr[code]' AND client = '$client' order by description";
			$q1rs = mysql_query($q1) or die(mysql_error());
			if($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
				document.getElementById('description@' + index1).value = "<?php echo $q1r['description'];?>";
				document.getElementById('units@' + index1).value = "<?php echo $q1r['sunits'];?>";
	<?php
			}
			echo "}";
			}
	?>
	//alert(index);

}


function getcode(cat)
{
	var cat1 = document.getElementById(cat).value;
	temp = cat.split("@");
	var index1 = temp[1];
	var i,j;
	<?php if($_SESSION['db'] == 'feedatives') {?>
	  if(cat1 == 'Broiler Feed')
	  {
	   document.getElementById('existflock@'+index1).style.display = "block";
       
	    document.getElementById('type@'+index1).style.display = "block";
	  }	
	  else
	  {
	   document.getElementById('existflock@'+index1).style.display = "none";
       document.getElementById('aflock@'+index1).style.display = "none";
	   document.getElementById('type@'+index1).style.display = "none";
	  
	  }
	<?php } ?>
	removeAllOptions(document.getElementById('code@' + index1));
      var code = document.getElementById('code@' + index1);
      theOption1=document.createElement("OPTION");
      theText1=document.createTextNode("-Select-");
	theOption1.value = "";
      theOption1.appendChild(theText1);
      code.appendChild(theOption1);
	  
	removeAllOptions(document.getElementById('desc@' + index1)); 
	var description = document.getElementById('desc@' + index1); 
	theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
	        theOption1.value = "";
              theOption1.appendChild(theText1);
              description.appendChild(theOption1);
<?php 
    $q = "select distinct(type) from ims_itemtypes WHERE client = '$client'";
    $qrs = mysql_query($q) or die(mysql_error());
    while($qr = mysql_fetch_assoc($qrs))
    {
	echo "if(cat1 == '$qr[type]') {";
	$q1 = "select distinct(code),description from ims_itemcodes where cat = '$qr[type]' and client = '$client' and (source = 'Purchased' or source = 'Produced or Purchased') order by code";
	$q1rs = mysql_query($q1) or die(mysql_error());
	while($q1r = mysql_fetch_assoc($q1rs))
	{
?>
         theOption1=document.createElement("OPTION");
         theText1=document.createTextNode("<?php echo $q1r['code'];?>");
         theOption1.appendChild(theText1);
         theOption1.value = "<?php echo $q1r['code'];?>";
	   theOption1.title = "<?php echo $q1r['description'];?>";
         code.appendChild(theOption1);
		 
		  theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("<?php echo $q1r['description'];?>");
              theOption1.appendChild(theText1);
	        theOption1.value = "<?php echo $q1r['code'];?>";
	        theOption1.title = "<?php echo $q1r['description'];?>";
              description.appendChild(theOption1);
<?php }
 echo "}";
 }	?>

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


function makeForm() {
index = index + 1;
var i,b;

table=document.getElementById("paraID");
tr = document.createElement('tr');
tr.align = "center";

////////space td//////////////
var b1 = document.createElement('td');
myspace1= document.createTextNode('\u00a0');
b1.appendChild(myspace1);
////////space td//////////////

////////category td//////////////
td = document.createElement('td');
myselect1 = document.createElement("select");
myselect1.name = "cat[]";
myselect1.id = "cat@" + index;
myselect1.style.width = "120px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);
myselect1.onchange = function () { getcode(this.id); };
<?php
         $q = "select distinct(type) from ims_itemtypes WHERE type <> 'Broiler Birds' AND (type <> 'Broiler Chicks' or type <> 'Broiler Day Old Chicks') AND type <> 'Consumables' AND type <> 'Eggs' AND type <> 'Equipments' AND type <> 'Female Birds' AND type <> 'Male Birds' AND type <> 'Stationary' AND type <> 'Wastages' AND client = '$client' order by type"; 
         $qrs = mysql_query($q,$conn) or die(mysql_error());
        while($qr = mysql_fetch_assoc($qrs)) {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['type']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $qr['type']; ?>";
myselect1.appendChild(theOption1);
<?php } ?>
td.appendChild(myselect1);
//////////category td/////////

tr.appendChild(b1);
tr.appendChild(td);


////////space td//////////////
var b2 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
b2.appendChild(myspace2);
////////space td//////////////

////////item code td//////////////
td = document.createElement('td');
myselect1 = document.createElement("select");
myselect1.name = "code[]";
myselect1.id = "code@" + index;
myselect1.style.width = "75px";

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);
myselect1.onchange = function () { selectdesc(this.id); };

td.appendChild(myselect1);

// for description start

myselect1 = document.createElement("select");
myselect1.name = "desc[]";
myselect1.id = "desc@" + index;
myselect1.style.width = "130px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.onchange = function () { selectcode(this.id); };

// for description end


//////////item code td/////////

tr.appendChild(b2);
tr.appendChild(td);

////////space td///////////
var b3 = document.createElement('td');
myspace3= document.createTextNode('\u00a0');
b3.appendChild(myspace3);
/////////////space td//////

/////////////description////////
td = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="15";
mybox1.type="hidden";
mybox1.name="description[]";
mybox1.id = "description@" + index;

td.appendChild(mybox1);

td.appendChild(myselect1); // for description
//////////fdescription td//////

tr.appendChild(b3);
tr.appendChild(td);

////////space td///////////
var b4 = document.createElement('td');
myspace4= document.createTextNode('\u00a0');
b4.appendChild(myspace4);
/////////////space td//////

/////////////units////////
td = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="8";
mybox1.type="text";
mybox1.name="units[]";
mybox1.id = "units@" + index;
td.appendChild(mybox1);
//////////units td//////

tr.appendChild(b4);
tr.appendChild(td);


////////space td//////////////
var b5 = document.createElement('td');
myspace5= document.createTextNode('\u00a0');
b5.appendChild(myspace5);
////////space td//////////////

////////towarehouse td//////////////
td = document.createElement('td');
myselect1 = document.createElement("select");
myselect1.name = "towarehouse[]";
myselect1.id = "towarehouse@" + index;
<?php if($_SESSION['db'] == 'feedatives'){?>
myselect1.onchange = function () { getfarm(this.id,this.value); };
<?php } ?>
myselect1.style.width = "140px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);
<?php
      $q1 = "SELECT distinct(flockcode) FROM breeder_flock WHERE client = '$client' and cullflag='0' order by flockcode ASC";
      $r1 = mysql_query($q1,$conn);
      while($row1 = mysql_fetch_assoc($r1)) { 
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['flockcode']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['flockcode']; ?>";
theOption1.title = "<?php echo $row1['flockcode']; ?>";
myselect1.appendChild(theOption1);
<?php } ?>

<?php
if($_SESSION['client'] == 'FEEDATIVES')
{
	if($_SESSION['sectorr'] == "all")
	{
	 $q1 = "SELECT * FROM tbl_sector WHERE type1 = 'Warehouse' AND client = '$client' order by sector ASC";
	}
	else
	{
	 $sectortype =  $_SESSION['sectorr'];
	$q1 = "SELECT * FROM tbl_sector WHERE type1 = 'Warehouse' AND place = '$sectortype' AND client = '$client' order by sector ASC";
	}
}
else
 	$q1 = "SELECT * FROM tbl_sector WHERE type1 = 'Warehouse' AND client = '$client' order by sector ASC";
      
      $r1 = mysql_query($q1,$conn);
      while($row1 = mysql_fetch_assoc($r1)) { 
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['sector']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['sector']; ?>";
theOption1.title = "<?php echo $row1['sector']; ?>";
myselect1.appendChild(theOption1);
<?php } ?>
<?php
if($_SESSION['client'] == 'FEEDATIVES')
{
	if($_SESSION['sectorr'] == "all")
	{
	  $q1 = "SELECT farm FROM broiler_farm WHERE client = '$client' AND type = 'rental' order by farm ASC";
	}
	else
	{
	 $sectortype =  $_SESSION['sectorr'];
	 $q1 = "SELECT farm FROM broiler_farm WHERE client = '$client' AND place = '$sectortype' AND type = 'rental' order by farm ASC";  
	}
}
else
 	 $q1 = "SELECT distinct(farm) FROM broiler_farm WHERE client = '$client' order by farm ASC";

      $r1 = mysql_query($q1,$conn);
      while($row1 = mysql_fetch_assoc($r1)) { 
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['farm']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['farm']; ?>";
theOption1.title = "<?php echo $row1['farm']; ?>";
myselect1.appendChild(theOption1);
<?php } ?>
td.appendChild(myselect1);
//////////towarehouse td/////////

tr.appendChild(b5);
tr.appendChild(td);



////////space td///////////
var b10 = document.createElement('td');
myspace10= document.createTextNode('\u00a0');
b10.appendChild(myspace10);
/////////////space td//////

////////flock td--Now Removed//////////////
td = document.createElement('td');
myselect1 = document.createElement("select");
myselect1.name = "flock[]";
myselect1.id = "flock@" + index;
myselect1.style.width = "80px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);
td.appendChild(myselect1);
//////////flock td/////////

/*tr.appendChild(b10);
tr.appendChild(td);*/
<?php if($_SESSION['db'] == "feedatives") { ?>
////////space td///////////
var b2 = document.createElement('td');
myspace2= document.createTextNode('\u00a0');
b2.appendChild(myspace2);
/////////////space td//////



///////parent flock td/////////
td = document.createElement('td');
myselect1 = document.createElement("select");
myselect1.name = "type[]";
myselect1.id = "type@" + index;
myselect1.style.width = "100px";

myselect1.onchange = function ()  {  changetype(this.id,this.value); };
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Existing");
theOption1.appendChild(theText1);
theOption1.value = "Existing";
myselect1.appendChild(theOption1);

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("New");
theOption1.appendChild(theText1);
theOption1.value = "New";
myselect1.appendChild(theOption1);

td.appendChild(myselect1);

tr.appendChild(b2);
tr.appendChild(td);

var b13 = document.createElement('td');
myspace6= document.createTextNode('\u00a0');
b13.appendChild(myspace6);
/////////////space td//////

/////////////squantity////////
td = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="14";
mybox1.type="text";
mybox1.name="aflock[]";
mybox1.id = "aflock@" + index;
mybox1.onblur = function () { checkFlock(this.value,this.id); };
mybox1.style.display = "none";
td.appendChild(mybox1);

myselect1 = document.createElement("select");
myselect1.name = "existflock[]";
myselect1.id = "existflock@" + index;
myselect1.style.width = "100px";

theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
theOption1.value = "";
myselect1.appendChild(theOption1);
myselect1.appendChild(theOption1);
td.appendChild(myselect1);

//////////squantity td//////

tr.appendChild(b13);
tr.appendChild(td);




<?php } ?>

////////space td///////////
var b6 = document.createElement('td');
myspace6= document.createTextNode('\u00a0');
b6.appendChild(myspace6);
/////////////space td//////

/////////////squantity////////
td = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="8";
mybox1.type="text";
mybox1.name="squantity[]";
mybox1.id = "squantity@" + index;
td.appendChild(mybox1);
//////////squantity td//////

tr.appendChild(b6);
tr.appendChild(td);

////////space td///////////
/*var b7 = document.createElement('td');
myspace7= document.createTextNode('\u00a0');
b7.appendChild(myspace7);
/////////////space td//////

/////////////price////////
td = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="4";
mybox1.type="text";
mybox1.name="price[]";
mybox1.id = "price@" + index;
mybox1.value = "0";
td.appendChild(mybox1);
//////////price td//////

tr.appendChild(b7);
tr.appendChild(td);*/


////////space td///////////
var b8 = document.createElement('td');
myspace8= document.createTextNode('\u00a0');
b8.appendChild(myspace8);
/////////////space td//////

/////////////tmno////////
td = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="4";
mybox1.type="text";
mybox1.name="tmno[]";
mybox1.id = "tmno@" + index;
mybox1.value = "0";
td.appendChild(mybox1);
//////////tmno td//////

tr.appendChild(b8);
tr.appendChild(td);

////////space td///////////
var b12 = document.createElement('td');
myspace12= document.createTextNode('\u00a0');
b12.appendChild(myspace12);
/////////////space td//////

/////////////tmno////////
td = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="4";
//mybox1.style.width = "20px";
mybox1.type="text";
mybox1.name="tcost[]";
mybox1.id = "tcost@" + index;
mybox1.value = "0";
td.appendChild(mybox1);
//////////tmno td//////

tr.appendChild(b12);
tr.appendChild(td);

////////space td///////////
var b9 = document.createElement('td');
myspace9= document.createTextNode('\u00a0');
b9.appendChild(myspace9);
/////////////space td//////

/////////////vno////////
td = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="10";
mybox1.type="text";
mybox1.name="vno[]";
mybox1.id = "vno@" + index;
td.appendChild(mybox1);
//////////vno td//////

tr.appendChild(b9);
tr.appendChild(td);








////////space td///////////
var b11 = document.createElement('td');
myspace11= document.createTextNode('\u00a0');
b11.appendChild(myspace11);
/////////////space td//////

/////////////remarks////////
td = document.createElement('td');
mybox1=document.createElement("input");
mybox1.size="8";
mybox1.type="text";
mybox1.name="remarks[]";
mybox1.id = "remarks@" + index;
mybox1.onfocus = function () { makeForm(); };
td.appendChild(mybox1);
//////////remarks td//////

tr.appendChild(b11);
tr.appendChild(td);

////////space td///////////
var b12 = document.createElement('td');
myspace12= document.createTextNode('\u00a0');
b12.appendChild(myspace12);
/////////////space td//////

tr.appendChild(b12);


table.appendChild(tr);


}

///////////////end of make form////////////////
function changetype(a,b)
{
var typeindex = a.substr(5);

if(b == "Existing")
{
document.getElementById("aflock@"+typeindex).style.display = "none";
document.getElementById("existflock@"+typeindex).style.display = "block";
}
else
{
document.getElementById("existflock@"+typeindex).style.display = "none";
document.getElementById("aflock@"+typeindex).style.display = "block";
document.getElementById("aflock@"+typeindex).value = "";
}
}

function checkFlock(a,b)
{
var typeindex = b.substr(7);
<?php
$flag =0;
$query = "SELECT distinct(flock) FROM broiler_daily_entry WHERE client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $flock = $rows['flock'];
 echo "if(a == '$flock') {";
?>
alert("Flock name is already existing");
var typeid = "aflock@"+typeindex;
document.getElementById(typeid).value = "";
document.getElementById(typeid).focus();
<?php

 echo "}";
}
?>
}

function getfarm(a,b)
{
var typeindex = a.substr(12);
 var typeid = "existflock@"+typeindex;
 myselect1 = document.getElementById(typeid);
 
 for($i=myselect1.length;$i>0;$i--)
  myselect1.remove($i);

<?php
$query ="SELECT distinct(farm) FROM broiler_daily_entry WHERE client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_query());
while($rows = mysql_fetch_assoc($result))
{
 echo "if(b == '$rows[farm]') { ";
 $query2 = "SELECT distinct(flock) FROM broiler_daily_entry WHERE farm = '$rows[farm]' AND flock NOT IN ( SELECT flock FROM broiler_transferrate WHERE client = '$client' AND farmer = '$rows[farm]') AND client = '$client'";
 $result2 = mysql_query($query2,$conn) or die(mysql_error());
 while($rows2 = mysql_fetch_assoc($result2))
 {
 $existingflocks[$rows2['flock']] = 1;
 ?>
 theOption1=document.createElement("OPTION");
 theText1=document.createTextNode("<?php echo $rows2['flock']; ?>");
 theOption1.appendChild(theText1);
 theOption1.value = "<?php echo $rows2['flock']; ?>";
 theOption1.title = "<?php echo $rows2['flock']; ?>";
 myselect1.appendChild(theOption1);
 
 <?php
 }
 
 $query3 = "select distinct(flock) from pp_sobi where warehouse = '$rows[farm]' and flock <> ''";
 
 $result3 = mysql_query($query3,$conn) or die(mysql_error());
 while($rows3 = mysql_fetch_assoc($result3))
 {
 if( $existingflocks[$rows3['flock']] != 1)
 {
 ?>
 
 theOption1=document.createElement("OPTION");
 theText1=document.createTextNode("<?php echo $rows3['flock']; ?>");
 theOption1.appendChild(theText1);
 theOption1.value = "<?php echo $rows3['flock']; ?>";
 theOption1.title = "<?php echo $rows3['flock']; ?>";
 myselect1.appendChild(theOption1);
 
 <?php
 } }
 
 
 
 echo " } ";
}
?>

}

</script>




<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>

