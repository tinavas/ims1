<?php 
include "config.php";
include "jquery.php";
?>

<br>
<br>

<center>
<h1>Setting Opening / Closing Stock</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br>
<br>
<form action="ims_saveintermediate.php" method="post">
<table>
<tr>
<td><strong>Date</strong></td>
<td width="10px"></td>

<td><input type="text" size="15" id="date" name="date" value="<?php echo date("d.m.Y"); ?>" class="datepicker" />
</td>
<td width="10px"></td>
</tr>
</table>

<br>
<br>
 <table border="0" id="maintable">
     <tr>
        <th style=""><strong>Category</strong></th>
        <th width="10px"></th>
 
        <th style=""><strong>Item Code<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th>
        <th width="10px"></th>
  
        <th style=""><strong>Description<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th>
        <th width="10px"></th>

        <th style=""><strong>Quantity<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th>
        <th width="10px"></th>
 
        <th style=""><strong>Units</strong></th>
        <th width="10px"></th>

        <th style=""><strong>Rate/Unit<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th>
        <th width="10px"></th>

       <!-- <th style=""><strong>COA<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th>
        <th width="10px"></th>-->

		<th style=""><strong>Warehouse</strong></th>
        <th width="10px"></th>
		
     </tr>

     <tr style="height:20px"></tr>

     <tr>
 
       <td style="text-align:left;">
         <select name="cat[]" id="cat@0" onchange="loadcodes(this.id);" style="width:90px;">
           <option>-Select-</option>
           <?php
              include "config.php"; 
              $query = "SELECT * FROM ims_itemtypes ORDER BY type ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
           <option value="<?php echo $row1['type']; ?>" title="<?php echo $row1['type'];?>"><?php echo $row1['type']; ?></option>
           <?php } ?>
         </select>
    </td>
       <td width="10px"></td>

       <td >
         <select name="code[]" id="code@0" onchange="loaddescription(this.id);" style="width:80px;">
           <option>-Select-</option>
         </select>
       </td>
       <td width="10px"></td>

       <td >
         <?php /*?><input type="text" name="description[]" id="description@0" readonly size="25"  /> <?php */?>
		  <select name="description[]" id="description@0" style="width:100px" onchange="getcode(this.id);">
	   <option>-Select-</option>
	   
	   </select>
       </td>
       <td width="10px"></td>

       <td >
         <input type="text" name="quantity[]" id="quantity@0"  size="8"  />
       </td>
       <td width="10px"></td>

       <td >
         <input type="text" name="units[]" id="units@0"  size="8" readonly/>
       </td>
       <td width="10px"></td>

       <td >
         <input type="text" name="rateperunit[]" id="rateperunit@0" size="6" onfocus = "makeRow()" />
       </td>
       <td width="10px"></td>

     <?php /*?>  <td >
         <select name="coa[]" id="coa@0">
		 <option value="">-Select-</option>
		 <?php 
		 	$q = "select distinct(code),description from ac_coa where (controltype = '' OR controltype IS NULL) AND (type != 'Capital') and code not like 'CG%' and code not like  'PV%' and code not like  'PR%' and code not like 'WP%' order by code";
			$qrs = mysql_query($q,$conn) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
		 ?>
		 <option title="<?php echo $qr['description']; ?>" value="<?php echo $qr['code']; ?>"><?php echo $qr['code']; ?></option>
		 <?php } ?>
		 </select>
       </td>
       <td width="10px"></td>
<?php */?>
        <td>
         <select name="warehouse[]" id="warehouse@0">
		 <option >-Select-</option>
		 <?php 
		
		$q = "select distinct(sector) as 'sector' from tbl_sector where (type1 = 'Warehouse' or type1 = 'Chicken Center' or type1 = 'Egg Center') and client = '$client' order by sector";
		
			$qrs = mysql_query($q,$conn) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
		 ?>
		 <option title="<?php echo $qr['sector']; ?>" value="<?php echo $qr['sector']; ?>"><?php echo $qr['sector']; ?></option>
		 <?php } ?>
         </select>
       </td>
       <td width="10px"></td>
	
	   
    </tr>
   </table>
<br>
<br>

   <input type="submit" value="Save" id="save" onclick="return warehousechecking();"/>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=data1';">

</form>
</center>




<script type="text/javascript">

function warehousechecking()
{

    for(i = 0; i < index; i++)
     {
     	 
	     if(document.getElementById('quantity@' + i).value != "" &&  document.getElementById('rateperunit@' + i).value != "")
           {
             if(document.getElementById('warehouse@' + i).value == "")
              {
               alert('Please select warehouse');
              
               return false;
              }
              
           }
     }
	return true;
}


function loadcodes(id)
{
	var index1;
	var id1 = id.split("@");
	index1 = id1[1];
	var cat = document.getElementById(id).value;

	
	document.getElementById('units@' + index1).value = "";
	//document.getElementById('lot@' + index1).value = "";
	//document.getElementById('serial@' + index1).value = "";
	
	
	
	
	
	removeAllOptions(document.getElementById("code@" + index1));
	myselect1 = document.getElementById("code@" + index1);
    theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("-Select-");
    theOption1.appendChild(theText1);
	theOption1.value = "";
    myselect1.appendChild(theOption1);
	
	removeAllOptions(document.getElementById('description@' + index1));
	myselect2 = document.getElementById('description@' + index1);
    theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("-Select-");
    theOption1.appendChild(theText1);
	theOption1.value = "";
    myselect2.appendChild(theOption1);

	<?php 
		$q = "select distinct(cat) from ims_itemcodes where client = '$client'  order by cat";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		echo "if(cat == '$qr[cat]') { ";
		$q1 = "select distinct(code),description from ims_itemcodes where cat = '$qr[cat]' and client = '$client'  order by code";
		$q1rs = mysql_query($q1) or die(mysql_error());
		while($q1r = mysql_fetch_assoc($q1rs))
		{
		?>
	    theOption1=document.createElement("OPTION");
   	 	theText1=document.createTextNode("<?php echo $q1r['code']; ?>");
   		theOption1.appendChild(theText1);
		theOption1.value = "<?php echo $q1r['code']; ?>";
		theOption1.title = "<?php echo $desc['description']; ?>";
    	myselect1.appendChild(theOption1);
		
		
		
		<?php } 
		$q1 = "select distinct(description),code from ims_itemcodes where cat = '$qr[cat]' and client = '$client'  order by description";
		$q1rs = mysql_query($q1) or die(mysql_error());
		while($desc = mysql_fetch_assoc($q1rs))
		{
		
	?>
	    theOption1=document.createElement("OPTION");
   	 	theText1=document.createTextNode("<?php echo $desc['description']; ?>");
   		theOption1.appendChild(theText1);
		theOption1.value = "<?php echo $desc['description']; ?>";
		theOption1.title = "<?php echo $desc['code']; ?>";
    	myselect2.appendChild(theOption1);
				
		<?php }
		
		echo " } "; } ?>

}

function loaddescription(id)
{
	var index1;
	var id1 = id.split("@");
	index1 = id1[1];
	
	for(var i = 0; i <= index1; i++)
	{
		for(var j = 0; j <= index1; j++)
		{
			if( i!= j && document.getElementById('code@' + i).value == document.getElementById('code@' + j).value)
			{
				alert("Please select different combination");
				return;
			}
		}
	}

	var code = document.getElementById(id).value;
	document.getElementById('description@' + index1).value = "";
	document.getElementById('units@' + index1).value = "";
	//document.getElementById('lot@' + index1).value = "";
	//document.getElementById('serial@' + index1).value = "";
	
	
	<?php 
		$q = "select distinct(code) from ims_itemcodes where client = '$client'  order by code";
		$qrs = mysql_query($q) or die(mysql_error_());
		while($qr = mysql_fetch_assoc($qrs))
		{
		echo "if(code == '$qr[code]') { ";
		$q1 = "select description,sunits,lscontrol,startvalue1,startvalue2,warehouse from ims_itemcodes where code = '$qr[code]' and client = '$client' ";
		$q1rs = mysql_query($q1) or die(mysql_error_());
		while($q1r = mysql_fetch_assoc($q1rs))
		{
	?>
	    document.getElementById('description@' + index1).value = "<?php echo $q1r['description']; ?>";
		document.getElementById('units@' + index1).value = "<?php echo $q1r['sunits']; ?>";
		
		
		<?php 
		
		} echo " } "; } ?>
		
}

function getcode(id)
{
	var index1;
	var id1 = id.split("@");
	index1 = id1[1];
	
	for(var i = 0; i <= index1; i++)
	{
		for(var j = 0; j <= index1; j++)
		{
			if( i!= j && document.getElementById('description@' + i).value == document.getElementById('description@' + j).value)
			{
				alert("Please select different combination");
				return;
			}
		}
	}

	var description = document.getElementById(id).value;
	
	document.getElementById('units@' + index1).value = "";
	//document.getElementById('lot@' + index1).value = "";
	//document.getElementById('serial@' + index1).value = "";
	
	
	<?php 
		$q = "select distinct(description) from ims_itemcodes where client = '$client'  order by code";
		$qrs = mysql_query($q) or die(mysql_error_());
		while($qr = mysql_fetch_assoc($qrs))
		{
		echo "if(description == '$qr[description]') { ";
		$q1 = "select code,sunits,lscontrol,startvalue1,startvalue2,warehouse from ims_itemcodes where description = '$qr[description]' and client = '$client' ";
		$q1rs = mysql_query($q1) or die(mysql_error_());
		while($q1r = mysql_fetch_assoc($q1rs))
		{
	?>
	    document.getElementById('code@' + index1).value = "<?php echo $q1r['code']; ?>";
		document.getElementById('units@' + index1).value = "<?php echo $q1r['sunits']; ?>";
		
		
		<?php 
		} echo " } "; } ?>
		
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

var index = 0;
function makeRow()
{
 if(document.getElementById("description@" + index).value != "" && document.getElementById("quantity@" + index).value != "" && document.getElementById('quantity@' + index).value > 0)
 {
	index = index + 1;
	var mytable = document.getElementById('maintable');
	var myrow = document.createElement('tr');
	var mytd = document.createElement('td');
	
	/////// Category /////////
	
	var myselect1 = document.createElement("select");
	myselect1.id = "cat@" + index;
	myselect1.name = "cat[]";
	myselect1.onchange = function () { loadcodes(this.id); };
	myselect1.style.width = "90px";
	
    theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("-Select-");
    theOption1.appendChild(theText1);
	theOption1.value = "";
    myselect1.appendChild(theOption1);
	
	<?php 
        $query = "SELECT * FROM ims_itemtypes ORDER BY type ASC ";
        $result = mysql_query($query) or die(mysql_error());
        while($row1 = mysql_fetch_assoc($result))
        {
	?>
    theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("<?php echo $row1['type']; ?>");
    theOption1.appendChild(theText1);
	theOption1.value = "<?php echo $row1['type']; ?>";
    myselect1.appendChild(theOption1);
	<?php } ?>	
	mytd.appendChild(myselect1);
	myrow.appendChild(mytd);
	
	mytd = document.createElement('td');
	mytd.width = "10px";
	myrow.appendChild(mytd);
	
	/////// Codes /////////
	mytd = document.createElement('td');
	
	myselect1 = document.createElement("select");
	myselect1.id = "code@" + index;
	myselect1.name = "code[]";
	myselect1.onchange = function () { loaddescription(this.id); };
	myselect1.style.width = "80px";
	
    theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("-Select-");
    theOption1.appendChild(theText1);
	theOption1.value = "";
    myselect1.appendChild(theOption1);
	mytd.appendChild(myselect1);
	myrow.appendChild(mytd);
	
	mytd = document.createElement('td');
	mytd.width = "10px";
	myrow.appendChild(mytd);
	
	/////// Description /////////
	
	/*mytd = document.createElement('td');
	var input = document.createElement("input");
	input.type = "text";
	input.id = "description@" + index;
	input.name = "description[]";
	input.size = "25";
	input.setAttribute("readonly");
	mytd.appendChild(input);
	myrow.appendChild(mytd);
	
	mytd = document.createElement('td');
	mytd.width = "10px";
	myrow.appendChild(mytd);
	*/
	mytd = document.createElement('td');
	var input = document.createElement("select");
	input.id = "description@" + index;
	input.name = "description[]";
	//input.setAttribute ("width","100px");
	input.style.width = "100px";
	input.onchange = function (){ getcode(this.id);};
	option1 = document.createElement("option");
	data = document.createTextNode("-Select-");
	option1.appendChild(data);
	input.appendChild(option1);
	mytd.appendChild(input);
	myrow.appendChild(mytd);
	
	mytd = document.createElement('td');
	mytd.width = "10px";
	myrow.appendChild(mytd);
	
	//////////// Quantity //////////////
	
	mytd = document.createElement('td');
	input = document.createElement("input");
	input.type = "text";
	input.id = "quantity@" + index;
	input.name = "quantity[]";
	
	input.size = "8";
	mytd.appendChild(input);
	myrow.appendChild(mytd);
	
	mytd = document.createElement('td');
	mytd.width = "10px";
	myrow.appendChild(mytd);

	/////////////// Units /////////////
	
	mytd = document.createElement('td');
	input = document.createElement("input");
	input.type = "text";
	input.id = "units@" + index;
	input.name = "units[]";
	input.size = "8";
	input.setAttribute("readonly");
	mytd.appendChild(input);
	myrow.appendChild(mytd);
	
	mytd = document.createElement('td');
	mytd.width = "10px";
	myrow.appendChild(mytd);
	
	/////////// Rate/Unit ////////
	
	mytd = document.createElement('td');
	input = document.createElement("input");
	input.type = "text";
	input.id = "rateperunit@" + index;
	input.name = "rateperunit[]";
	input.size = "6";
	input.onfocus = function () { makeRow(); };
	mytd.appendChild(input);
	myrow.appendChild(mytd);
	
	mytd = document.createElement('td');
	mytd.width = "10px";
	myrow.appendChild(mytd);
	
	/////// COA /////////
	/*mytd = document.createElement('td');
	
	myselect1 = document.createElement("select");
	myselect1.id = "coa@" + index;
	myselect1.name = "coa[]";
			
    theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("-Select-");
    theOption1.appendChild(theText1);
	theOption1.value = "";
    myselect1.appendChild(theOption1);
	<?php 
	$q = "select distinct(code),description from ac_coa where (controltype = '' OR controltype IS NULL) AND (type != 'Capital')  and code not like 'CG%' and code not like  'PV%' and code not like  'PR%' and code not like 'WP%' order by code";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	?>
    theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("<?php echo $qr['code']; ?>");
    theOption1.appendChild(theText1);
	theOption1.value = "<?php echo $qr['code']; ?>";
     theOption1.title = "<?php echo $qr['description']; ?>";
    myselect1.appendChild(theOption1);
	<?php } ?>	

	mytd.appendChild(myselect1);
	myrow.appendChild(mytd);
	
	mytd = document.createElement('td');
	mytd.width = "10px";
	myrow.appendChild(mytd);*/
	

	/////////// Rate/Unit ////////
	
	/*mytd = document.createElement('td');
	input = document.createElement("input");
	input.type = "text";
	input.id = "lot@" + index;
	input.name = "lot[]";
	input.size = "7";
	input.setAttribute("readonly");
	mytd.appendChild(input);
	myrow.appendChild(mytd);
	
	mytd = document.createElement('td');
	mytd.width = "10px";
	myrow.appendChild(mytd);

	/////////// Rate/Unit ////////
	
	mytd = document.createElement('td');
	input = document.createElement("input");
	input.type = "text";
	input.id = "serial@" + index;
	input.name = "serial[]";
	input.size = "10";
	input.setAttribute("readonly");
	mytd.appendChild(input);
	myrow.appendChild(mytd);
	
	mytd = document.createElement('td');
	mytd.width = "10px";
	myrow.appendChild(mytd);*/

	

	/////// Warehouse /////////
	mytd = document.createElement('td');
	
	myselect1 = document.createElement("select");
	myselect1.id = "warehouse@" + index;
	myselect1.name = "warehouse[]";
	//myselect1.style.width = "80px";
	
    theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("-Select-");
    theOption1.appendChild(theText1);
	theOption1.value = "";
    myselect1.appendChild(theOption1);

	<?php 
	
	 $query = "select distinct(sector) as 'sector' from tbl_sector where (type1 = 'Warehouse' or type1 = 'Chicken Center' or type1 = 'Egg Center') and client = '$client' order by sector";
   
	$result = mysql_query($query) or die(mysql_error());
        while($row1 = mysql_fetch_assoc($result))
        {
	?>
    theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("<?php echo $row1['sector']; ?>");
    theOption1.appendChild(theText1);
	theOption1.value = "<?php echo $row1['sector']; ?>";
    myselect1.appendChild(theOption1);
	<?php } ?>	

	mytd.appendChild(myselect1);
	myrow.appendChild(mytd);
	
	mytd = document.createElement('td');
	mytd.width = "10px";
	myrow.appendChild(mytd);
 
    mytable.appendChild(myrow);
	
	}
}

</script>
<script type="text/javascript">
function script1() {
window.open('IMSHelp/help_t_addintermediateissue.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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