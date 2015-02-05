<?php 
include "config.php";
include "jquery.php";

if(!isset($_GET['party']))
$party = "";
else
$party = $_GET['party'];

if(!isset($_GET['date']))
$date = date("d.m.Y");
else
$date = date("d.m.Y",strtotime($_GET['date']));
?>
<center>
<br>
<h1>SOBI Clearance</h1>
<br>

<form method="post" id="form1" action="pp_savesobiclearance.php">
<table>
<tr>
<td>
<strong>Date</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="date" name="date" size="15" value="<?php echo $date;?>" class="datepicker"/>
</td>
<td width="10px">&nbsp;</td>
<td>
<strong>Supplier</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<select id="vendor" name="vendor" onchange="loadsobi();">
<option value="">-Select-</option>
<?php 
	 $q = "select distinct(vendor) from pp_sobi where client = '$client' order by vendor";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
<option value="<?php echo $qr['vendor']; ?>" <?php if($party == $qr['vendor']) { ?> selected="selected" <?php } ?> ><?php echo $qr['vendor']; ?></option>
<?php } ?>
</select>
</td>


<td width="10px">&nbsp;</td>
<td>
<strong>SOBI</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<select id="sobi" name="sobi" style="width:150px" onchange="loadbalamt();">
<option value="">-Select-</option>
</select>
</td>
<td width="10px">&nbsp;</td>
<td>
<strong>Balance Amount</strong>
</td>
<td width="10px">&nbsp;</td>
<td>
<input type="text" id="amount" name="amount" size="15" readonly="true" value="" />
</td>
</tr>
</table>
<br />
<br />
<table id="test">
<tr>
<td></td>
<td>
<strong>Type</strong></td>
<td width="10px">&nbsp;</td><td>
<strong>Transaction Date</strong>
</td>
<td width="10px">&nbsp;</td><td>
<strong>Transaction No.</strong>
</td>
<td width="10px">&nbsp;</td><td>
<strong>Warehouse</strong>
</td>

<td width="10px">&nbsp;</td><td>
<strong>Balance Amount</strong>
</td>
<td width="10px">&nbsp;</td><td>
<strong>Clearing Amount</strong>
</td>
</tr>

</table>
</br>
<table align="center">
<tr>
<td width="400px"></td>
<td>
Total
</td>
<td><input type="text" id="totall" name="totall" size="12" readonly style="border:0px;background:none"  /></td>
</tr>
</table>
</br>
<table>
<td style="vertical-align:middle;"><strong>Narration&nbsp;&nbsp;&nbsp;</strong></td>
<td>
<textarea id="remarks" cols="40"  rows="3" name="remarks"></textarea>
</td>
<td style="color:red;font-weight:bold;padding-top:10px">&nbsp;*Max 225 Characters</td>
</table>
<br />

<br />
<input type="submit" id="save"  name="save" value="Clear" /> &nbsp;&nbsp;&nbsp;
<input type="button" id="cancel" name="cancel" value="Cancel" onclick="document.location='dashboardsub.php?page=pp_sobiclearance';"/>
</form>
</center>

<script type="text/javascript">
var index = 1;
function loadsobi()
{
var party = document.getElementById('vendor').value;
removeAllOptions(document.getElementById("sobi"));
	 
	 
	 
	 
			  
			  myselect1 = document.getElementById("sobi");
            
  <?php 
  
$query1 = "select vendor,grandtotal,so from pp_sobi where client = '$client'  group by so order by date";
$result1 = mysql_query($query1,$conn);
while($row1 = mysql_fetch_assoc($result1))
{
  $pamt = 0;

   ?>

   <?php
   echo "if( document.getElementById('vendor').value == '$row1[vendor]') { ";
  ?>

   <?php
   $query2 = "select sum(sobiamount) as totamt from pp_sobiclearance where sobi = '$row1[so]' and client = '$client'  ";
   $result2 = mysql_query($query2,$conn) or die(mysql_error());
    while($row2 = mysql_fetch_assoc($result2))
    {
	  $pamt = $row2['totamt'];
	}
	if ( $pamt < $row1['grandtotal'] )
	{ ?>
	
			
			    theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("<?php echo $row1['so']; ?>");
			  theOption1.value = "<?php echo $row1['so']; ?>";
			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);
			 
	<?php }
   echo " } ";
}
?>
loadprepayment(party);
}

function loadprepayment(party)
{
   var test  = document.getElementById('test');
  var rowCount = test.rows.length;

  
  for(i=rowCount-1;i>0;i--)
  {
 
  test.deleteRow(i);
  
  }
 
  
<?php
  $query1 = "select * from contactdetails where (type = 'vendor' or type = 'vedor and party') and client = '$client'  order by name";
  $result1 = mysql_query($query1,$conn);
  while($row1 = mysql_fetch_assoc($result1))
  {
    
    echo "if( document.getElementById('vendor').value == '$row1[name]') { ";
	//Loading Prepayament
	
			       if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
	 }
		if($sectorlist=="")  
	
   $query2 = "select * from pp_payment where  choice <> 'SOBIs' and vendor = '$row1[name]' and client = '$client'  order  by date ";
   
   else
    $query2 = "select * from pp_payment where  choice <> 'SOBIs' and vendor = '$row1[name]' and client = '$client' and unit in ($sectorlist)  order  by date ";
   $result2 = mysql_query($query2,$conn);
    while($row2 = mysql_fetch_assoc($result2))
    {
	  
	   $clearamt = 0;
	   $query3 = "select sum(sourceamount) as clamt from pp_sobiclearance where vendor = '$row1[name]' and client = '$client'  and sourcenum = '$row2[tid]'  and sourcetype = '$row2[paymentmethod]' ";
       $result3 = mysql_query($query3,$conn) or die(mysql_error());
       while($row3 = mysql_fetch_assoc($result3))
       {
	      $clearamt = $row3['clamt'];
	   }
	   $balamt = $row2['amount'] - $clearamt;
	   if ( $balamt > 0 )
	   {
	     ?>
       var i,b;
       var t1  = document.getElementById('test');
	   var rowCount = t1.rows.length;
       var r  = t1.insertRow(rowCount);
	   
	   
	
	     ////////////empty td/////////
      myspace2 = document.createTextNode('\u00a0');
      var et6 = r.insertCell(0);
      et6.appendChild(myspace2);
	   
	   
	   // Type Of Receipt
	   
	   var ca1=r.insertCell(1);
	   mybox1=document.createElement("input");
       mybox1.size="14";
       mybox1.type="text";
       mybox1.name="type[]";
       mybox1.id = "type" + index;
       mybox1.setAttribute("readonly","true");
	   mybox1.style.background = "none";
	   mybox1.style.border = "0px";
	   mybox1.value = "<?php echo $row2['paymentmethod']; ?>";
    
       ca1.appendChild(mybox1);
	   
	   
	   
	    ////////////empty td/////////
       myspace2 = document.createTextNode('\u00a0');
       var et1 = r.insertCell(2);
       et1.appendChild(myspace2);
	    //End Of Type
		//Date
		
		 var ca2 = r.insertCell(3);
		 mybox1=document.createElement("input");
       mybox1.size="14";
       mybox1.type="text";
       mybox1.name="tdate[]";
       mybox1.id = "tdate" + index;
       mybox1.setAttribute("readonly","true");
	   mybox1.style.background = "none";
	   mybox1.style.border = "0px";
	   mybox1.value = "<?php echo date("d.m.Y",strtotime($row2['date']));  ?>";
      
       ca2.appendChild(mybox1);
	   // End Of Date 
	   
	   
       ////////////empty td/////////
	   myspace2 = document.createTextNode('\u00a0');
       var et2 =r.insertCell(4);
	   et2.appendChild(myspace2);
	   
	   // Transaction Num
	    var ca3 = r.insertCell(5);
	    mybox1=document.createElement("input");
       mybox1.size="6";
       mybox1.type="text";
       mybox1.name="tnum[]";
       mybox1.id = "tnum" + index;
       mybox1.setAttribute("readonly","true");
	   mybox1.style.background = "none";
	   mybox1.style.border = "0px";
	   mybox1.value = "<?php echo $row2['tid'];?>";
      
       ca3.appendChild(mybox1);
	   // End Of Transaction Num
	   
	   
	    ////////////empty td/////////
       myspace2 = document.createTextNode('\u00a0');
       var et3 = r.insertCell(6);
       et3.appendChild(myspace2);
	   
	    // warehouse
	    mybox1=document.createElement("input");
       mybox1.size="6";
       mybox1.type="text";
       mybox1.name="unit[]";
       mybox1.id = "unit" + index;
       mybox1.setAttribute("readonly","true");
	   mybox1.style.background = "none";
	   mybox1.style.border = "0px";
	   mybox1.value = "<?php echo $row2['unit'];?>";
       var ca5 = r.insertCell(7);
       ca5.appendChild(mybox1);
	   // End Of Warehouse
	   
	    ////////////empty td/////////
      myspace2 = document.createTextNode('\u00a0');
      var et4 = r.insertCell(8);
      et4.appendChild(myspace2);
      ///////////////////////////////
	   
	   //Balance
	    mybox1=document.createElement("input");
       mybox1.size="10";
       mybox1.type="text";
       mybox1.name="bamount[]";
       mybox1.id = "bamount" + index;
       mybox1.setAttribute("readonly","true");
	   mybox1.style.background = "none";
	   mybox1.style.border = "0px";
	   mybox1.value = "<?php echo $balamt; ?>";
       var ca4 = r.insertCell(9);
       ca4.appendChild(mybox1);
	   // End Of Balance
	
	
      ////////////empty td/////////
      myspace2 = document.createTextNode('\u00a0');
      var et5 = r.insertCell(10);
      et5.appendChild(myspace2);
	
	   //Clearing Amount
	     mybox1=document.createElement("input");
       mybox1.size="12";
       mybox1.type="text";
       mybox1.name="samount[]";
       mybox1.id = "samount" + index;
	   mybox1.onkeyup = function ()  {  total(); };
	   mybox1.value = "0";
       var ca6 = r.insertCell(11);
       ca6.appendChild(mybox1);
	   //Clearing Amount Ends here
	   
	   
	   
	  
      ///////////////////////////////
	  

	  index = index + 1;
		
	
	   <?php }
	}
	
	
	 if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
	 }
		if($sectorlist=="")  
$query2 = "select * from ac_crdrnote where  vcode = '$row1[name]' and (mode = 'VCN' or mode = 'VDN') and client = '$client'  order  by date ";

else 
$query2 = "select * from ac_crdrnote where  vcode = '$row1[name]' and (mode = 'VCN' or mode = 'VDN') and client = '$client' and unit in ($sectorlist)  order  by date ";


   $result2 = mysql_query($query2,$conn);
    while($row2 = mysql_fetch_assoc($result2))
    {
	  
	   $clearamt = 0;
	   $query3 = "select sum(sourceamount) as clamt from pp_sobiclearance where vendor = '$row1[name]' and client = '$client'  and sourcenum = '$row2[crnum]'  and sourcetype = '$row2[mode]' ";
       $result3 = mysql_query($query3,$conn) or die(mysql_error());
       while($row3 = mysql_fetch_assoc($result3))
       {
	      $clearamt = $row3['clamt'];
	   }
	   $balamt = $row2['totalamount'] - $clearamt;
	   if ( $balamt > 0 )
	   {
	     ?>
		
		 
		 
		 
		 
		   
       var i,b;
       var t1  = document.getElementById('test');
	   var rowCount=t1.rows.length;
       var r  = t1.insertRow(rowCount);
	   
	   
	
	     ////////////empty td/////////
      myspace2 = document.createTextNode('\u00a0');
      var et6 = r.insertCell(0);
      et6.appendChild(myspace2);
	   
	   
	   // Type Of Receipt
	   
	   var ca1=r.insertCell(1);
	   mybox1=document.createElement("input");
       mybox1.size="14";
       mybox1.type="text";
       mybox1.name="type[]";
       mybox1.id = "type" + index;
       mybox1.setAttribute("readonly","true");
	   mybox1.style.background = "none";
	   mybox1.style.border = "0px";
	   mybox1.value = "<?php echo $row2['mode']; ?>";
    
       ca1.appendChild(mybox1);
	   
	   
	   
	    ////////////empty td/////////
       myspace2 = document.createTextNode('\u00a0');
       var et1 = r.insertCell(2);
       et1.appendChild(myspace2);
	    //End Of Type
		//Date
		
		 var ca2 = r.insertCell(3);
		 mybox1=document.createElement("input");
       mybox1.size="14";
       mybox1.type="text";
       mybox1.name="tdate[]";
       mybox1.id = "tdate" + index;
       mybox1.setAttribute("readonly","true");
	   mybox1.style.background = "none";
	   mybox1.style.border = "0px";
	   mybox1.value = "<?php echo date("d.m.Y",strtotime($row2['date']));  ?>";
      
       ca2.appendChild(mybox1);
	   // End Of Date 
	   
	   
       ////////////empty td/////////
	   myspace2 = document.createTextNode('\u00a0');
       var et2 =r.insertCell(4);
	   et2.appendChild(myspace2);
	   
	   // Transaction Num
	    var ca3 = r.insertCell(5);
	    mybox1=document.createElement("input");
       mybox1.size="6";
       mybox1.type="text";
       mybox1.name="tnum[]";
       mybox1.id = "tnum" + index;
       mybox1.setAttribute("readonly","true");
	   mybox1.style.background = "none";
	   mybox1.style.border = "0px";
	   mybox1.value = "<?php echo $row2['crnum'];?>";
      
       ca3.appendChild(mybox1);
	   // End Of Transaction Num
	   
	   
	    ////////////empty td/////////
       myspace2 = document.createTextNode('\u00a0');
       var et3 = r.insertCell(6);
       et3.appendChild(myspace2);
	   
	    // warehouse
	    mybox1=document.createElement("input");
       mybox1.size="6";
       mybox1.type="text";
       mybox1.name="unit[]";
       mybox1.id = "unit" + index;
       mybox1.setAttribute("readonly","true");
	   mybox1.style.background = "none";
	   mybox1.style.border = "0px";
	   mybox1.value = "<?php echo $row2['unit'];?>";
       var ca5 = r.insertCell(7);
       ca5.appendChild(mybox1);
	   // End Of Warehouse
	   
	    ////////////empty td/////////
      myspace2 = document.createTextNode('\u00a0');
      var et4 = r.insertCell(8);
      et4.appendChild(myspace2);
      ///////////////////////////////
	   
	   //Balance
	    mybox1=document.createElement("input");
       mybox1.size="10";
       mybox1.type="text";
       mybox1.name="bamount[]";
       mybox1.id = "bamount" + index;
       mybox1.setAttribute("readonly","true");
	   mybox1.style.background = "none";
	   mybox1.style.border = "0px";
	   mybox1.value = "<?php echo $balamt; ?>";
       var ca4 = r.insertCell(9);
       ca4.appendChild(mybox1);
	   // End Of Balance
	
	
      ////////////empty td/////////
      myspace2 = document.createTextNode('\u00a0');
      var et5 = r.insertCell(10);
      et5.appendChild(myspace2);
	
	   //Clearing Amount
	     mybox1=document.createElement("input");
       mybox1.size="12";
       mybox1.type="text";
       mybox1.name="samount[]";
       mybox1.id = "samount" + index;
	   mybox1.onkeyup = function ()  {  total(); };
	   mybox1.value = "0";
       var ca6 = r.insertCell(11);
       ca6.appendChild(mybox1);
	   //Clearing Amount Ends here
	   
	   
	   
	  
      ///////////////////////////////
	  

	
	  index = index + 1;
		
	
	   <?php }
	}
	
	// End of credit notes loading
	
	echo " } ";
  }
  
  ?>
}

function loadbalamt()
{
  
  <?php
  $query1 = "select distinct(so),grandtotal from pp_sobi where flag = 1  and client = '$client'  ";
  $result1 = mysql_query($query1,$conn);
  while($row1 = mysql_fetch_assoc($result1))
  {
     $pamt = 0;
	 $balamt = 0;
	 ?>
	 
	 <?php
     echo "if( document.getElementById('sobi').value == '$row1[so]') { ";
	 
	 $query2 = "select sum(amountpaid) as totamt from pp_payment where posobi = '$row1[so]' and client = '$client'  and flag = 1 ";
     $result2 = mysql_query($query2,$conn) or die(mysql_error());
     while($row2 = mysql_fetch_assoc($result2))
     {
	   $pamt = $row2['totamt'];
	 }
	 $query2 = "select sum(sourceamount) as totamt from pp_sobiclearance where sobi = '$row1[invoice]'  and client = '$client' and flag = 1 ";
     $result2 = mysql_query($query2,$conn) or die(mysql_error());
     while($row2 = mysql_fetch_assoc($result2))
     {
	   $pamt = $pamt + $row2['totamt'];
	 }
	 
	 $balamt = $row1['grandtotal'] - $pamt;
	 ?>
	
	 document.getElementById('amount').value = "<?php echo $balamt; ?>"; 
	 <?php
	 echo " } ";
  } ?>
 
}

function total()
{
 var tot = 0;
 

   for ( var i = 1;i < index;i++ )
   {
    
    if ( document.getElementById("samount" + i).value != "" )
	 {
	   if ( document.getElementById("samount" + i).value > document.getElementById("bamount" + i).value  )
     {
        document.getElementById('save').disabled = true;
        alert("Cannot Clear more than balance amount");
     }
    else
    {
       document.getElementById('save').disabled = false;
	   tot = tot + parseFloat(document.getElementById('samount' + i).value);
     } 
	} 
    
   } 
   document.getElementById('totall').value = tot;
 
}

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length;i>0;i--)
	{
		selectbox.options.remove(i);
		selectbox.remove(i);
	}
}





</script>
<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_p_sobicle.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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