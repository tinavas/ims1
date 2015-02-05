<?php 
include "config.php";
include "jquery.php";
?>
<center>
<br />
<h1>Ingredient Lab Report </h1>
</center>
<br />
<form name="lab" id="lab">
<table border="0" align="center">
 <tr>
   <td align="right"><strong>Item Name</strong>&nbsp;&nbsp;&nbsp;</td>
   <td align="left"><select style="width: 200px" name="name" id="name" onChange="fun()">
 			     <option value="">-Select-</option>
<?php $query = "SELECT distinct(desc1) as description FROM pp_gateentry WHERE qc = 'Yes' AND flag = '0' ORDER BY description ASC"; $result = mysql_query($query,$conn);
	while($row = mysql_fetch_assoc($result)) { ?>    
<option value="<?php echo $row['description']; ?>" <?php if($name == $row['description']) { ?> selected="selected" <?php } ?>><?php echo $row['description']; ?></option>
<?php } ?>   
        </select>&nbsp;&nbsp;&nbsp;</td>		
<td align="right"><strong>Gate Entry #</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><select style="width: 150px" name="ge" id="ge" >
			 <option value="">-Select-</option></select>&nbsp;&nbsp;&nbsp;</td>
<td align="right"><strong>Date</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="left"><input type="text" class="datepicker" size="15" id="date" name="date" value="<?php echo date("d.m.o"); ?>" onchange="setIframeSource();"></td>
</tr>
</table>
</form>
<iframe id="myIframe2" name="myIframe2" style="background:none;" allowtransparency="true" src="dummy.html" scrolling="no" width="100%" height="400" frameborder="0" marginheight="0" marginwidth="0" ></iframe>

<script type="text/javascript">

function setIframeSource() {
			 //document.getElementById('s1').style.visibility = "hidden";
             	if(document.getElementById('name').selectedIndex == 0)
			 	{
                 alert("please select Ingredient");
				 document.getElementById('name').focus();
			  	}
             	if(document.getElementById('ge').selectedIndex == 0)
			 	{
				 document.getElementById('myIframe2').src = "dummy.php";
                 //alert("please select PO");
				 document.getElementById('ge').focus();
			  	}
			  
			  else
			   {
			    //document.getElementById('myIframe2').style.visibility = "visible";
                var theIframe = document.getElementById('myIframe2');
                var date = document.getElementById('date').value;
                var name = document.getElementById('name').value;
				var ge = document.getElementById('ge').value;
				var x = document.getElementById('date');
				var theUrl;
				theUrl = "pp_addqc.php?id=";
                theIframe.src = theUrl + "&date=" + date + "&name=" + name + "&ge=" + ge;
			   }
			}

function fun()
{
var name = document.getElementById('name').value;
removeAllOptions(document.getElementById("ge"));
var myselect1 = document.getElementById("ge");
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("Select");
theOption1.appendChild(theText1);
theOption1.value ="";
myselect1.appendChild(theOption1);

		<?php
			$q1 = "select distinct(description) from pp_purchaseorder order by description asc";
			$q1rs = mysql_query($q1) or die(mysql_error());
			while($q1r = mysql_fetch_assoc($q1rs))
			{
			echo "if(name == '$q1r[description]') { ";
			$q2 = "select distinct(ge) from pp_gateentry WHERE desc1 = '$q1r[description]' AND flag = '0' AND aflag = '1' AND qc = 'Yes' ORDER BY ge ASC";
			$q2rs = mysql_query($q2) or die(mysql_error());
			while($q2r = mysql_fetch_assoc($q2rs))
			{
		?>
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("<?php echo $q2r['ge'];?>");
			  theOption1.appendChild(theText1);
			  theOption1.value = "<?php echo $q2r['ge'];?>";
              myselect1.appendChild(theOption1);
		<?php } echo " } "; } ?>
}

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.remove(i);
	}
}

</script>
