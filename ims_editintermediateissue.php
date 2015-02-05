<?php 
include "config.php";
include "jquery.php";

session_start();
$client = $_SESSION['client'];
$tid = $_GET['id'];

 $query1 = "select * from ims_intermediatereceipt WHERE riflag = 'I' and tid = '$tid' and client = '$client' ";
$result1 = mysql_query($query1,$conn); 
while($row1 = mysql_fetch_assoc($result1))
{
 $datemain = date("d.m.Y",strtotime($row1['date']));
 $empname=$row1['empname'];
  $docno=$row1['docno'];
  $remarks=$row1['narration'];
 }
$i=0;


$q1=mysql_query("SET group_concat_max_len=10000000");

//getting cat,itemcodes
$query="select cat,group_concat(concat(code,'@',description,'@',sunits) ) as cd from ims_itemcodes  group by cat";
$result=mysql_query($query,$conn);
$i=0;
while($r=mysql_fetch_array($result))
{
$items[$i]=array("cat"=>"$r[cat]","cd"=>"$r[cd]");
$i++;
} 
$item=json_encode($items);




//getting warehouses

	    if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
	 }
	 $i=0;
		if($sectorlist=="")  
$q1 = "SELECT GROUP_CONCAT( DISTINCT (sector)  ORDER BY sector ) as sector FROM tbl_sector WHERE type1 =  'warehouse'";
else

$q1 = "SELECT GROUP_CONCAT( DISTINCT (sector)  ORDER BY sector ) as sector FROM tbl_sector WHERE type1 =  'warehouse' and sector in ($sectorlist)";


 $res1 = mysql_query($q1,$conn); 

$rows1 = mysql_fetch_assoc($res1);
     {
	 
 $sec1=explode(",",$rows1["sector"]);	
			
			
	 }
	 
	 $sector=json_encode($sec1);



		 	$q = "select group_concat(code,'@',description order by code) as coacd from ac_coa where type like 'Expense' ";
			$qrs = mysql_query($q,$conn) or die(mysql_error());
			$qr = mysql_fetch_assoc($qrs);
			$coacd=explode(",",$qr['coacd']);
			$codedesc1=json_encode($coacd);
			

?>
<script type="text/javascript">
var items=<?php if(empty($item)){echo 0;} else{ echo $item; }?>;

var sectors1=<?php if(empty($sector)){echo 0;} else{ echo $sector; }?>;

var codedesc=<?php if(empty($codedesc1)){echo 0;} else{ echo $codedesc1; }?>;

</script>

<br>
<br>


<center>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" id="complex_form" method="post" action="ims_updateintermediateissue.php" onsubmit="return warehousechecking()" >	
	 <input type="hidden" name="cuser" id="cuser" value="<?php echo $globalrow['empname'];?>"  />	
	 
	  <h1>Intermediate Issue</h1>
		
		
		<br />
<b>Intermediate Issue</b>
<br />

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)<br /><br />
  


<br /><br />


<table>
<tr>
<td><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
<td width="10px"></td>

<td><input type="text" size="15" id="date" name="date" value="<?php echo $datemain; ?>" class="datepicker" />
<input type="hidden" name="cuser" id="cuser" value="<?php echo $empname;?>" />
</td>
<td width="10px"></td>

		<td><strong>Doc No.</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
				<td><input type="text" id="doc" name="doc" value="<?php echo $docno; ?>"/></td>
         
</tr>
</table>

<br>
<br>
 <table border="0" id="maintable">
     <tr>
        <th style=""><strong>Category</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
        <th width="10px"></th>
 
        <th style=""><strong>Item Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
        <th width="10px"></th>
  
        <th style=""><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
        <th width="10px"></th>

		 <th style=""><strong>Units</strong></th>
        <th width="10px"></th>
		
        <th style=""><strong>Quantity</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
        <th width="10px"></th>
 
       

        <th style=""><strong>COA</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
        <th width="10px"></th>

       
		
		<th style=""><strong>Warehouse<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></strong></font></th>
        <th width="10px"></th>
		


		
     </tr>

     <tr style="height:20px"></tr>
	 <input type="hidden" name="tid" id="tid" value="<?php echo $tid;?>"/>
	 <?php 
 	$i=-1;
	$catSelected="";
	$q =  "select * from ims_intermediatereceipt WHERE riflag = 'I' and tid = '$tid' and client = '$client' order by id ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	$cat1 = $qr['cat'];
	$i++;
 
?>
    <tr>
 
       <td style="text-align:left;">
         <select name="cat[]" id="cat@<?php echo $i; ?>" onchange="loadcodes(this.id);" style="width:90px;">
           <option value="">-Select-</option>
          <?php 
		   for($j=0;$j<count($items);$j++)
{
?>
<option value="<?php echo $items[$j]["cat"]; ?>"  <?php if($cat1 == $items[$j]["cat"]) { ?> selected=selected <?php } ?> ><?php echo $items[$j]["cat"]; ?></option>
<?php } ?>
         </select>
    </td>
       <td width="10px"></td>

       <td >
         <select name="code[]" id="code@<?php echo $i; ?>" onchange="loaddescription(this.id,this.value);" style="width:80px;">
           <option value="">-Select-</option>
			 
		 <?php
for($j=0;$j<count($items);$j++)
{
if($items[$j]["cat"] == $cat1) {	
	$cd1=explode(",",$items[$j]["cd"]);
	for($k=0;$k<count($cd1);$k++)
	
	{
	 $code1=explode("@",$cd1[$k]);
?>
<option value="<?php echo $cd1[$k]; ?>"  <?php if($code1[0]==$qr['code']){ ?> selected="selected"<?php }?>  ><?php echo $code1[0]; ?></option>
<?php } } } ?>
         </select>
       </td>
       <td width="10px"></td>

       <td >
         
		 <select name="description[]" id="description@<?php echo $i; ?>" style="width:100px" onchange="getcode(this.id,this.value);">
	   <option value="">-Select-</option>
		 <?php
for($j=0;$j<count($items);$j++)
{
if($items[$j]["cat"] == $cat1) {	
	$cd1=explode(",",$items[$j]["cd"]);
	for($k=0;$k<count($cd1);$k++)
	
	{
	 $code1=explode("@",$cd1[$k]);
?>
<option value="<?php echo $cd1[$k]; ?>"  <?php if($code1[1]==$qr['description']){ ?> selected="selected"<?php }?>  ><?php echo $code1[1]; ?></option>
<?php } } } ?>
	   </select>
       </td>
       <td width="10px"></td>

	     <td >
         <input type="text" name="units[]" id="units@<?php echo $i; ?>" value="<?php echo $qr['units']; ?>"  size="8" readonly style="background:none; border:0px;" />
       </td>
       <td width="10px"></td>

	   
       <td >
         <input type="text" name="quantity[]" id="quantity@<?php echo $i; ?>"  value="<?php echo $qr['cquantity']; ?>" size="8"  />
       </td>
       <td width="10px"></td>

     
      

       <td >
         <select name="coa[]" id="coa@<?php echo $i; ?>">
		 <option value="">-Select-</option>
		 
		  <?php 
		
		 for($j=0;$j<count($coacd);$j++)
		   {
			$coacd1=explode("@",$coacd[$j]);
           ?><option value="<?php echo $coacd1[0]; ?>" <?php  if ( $qr['coa'] == $coacd1[0]) {?> selected="selected" <?php } ?>  title="<?php echo $coacd1[0]; ?>"><?php echo $coacd1[0]; ?></option>
<?php } ?>

		 </select>
       </td>
       <td width="10px"></td>

  
   <td>
         <select name="warehouse[]" id="warehouse@<?php echo $i; ?>" style=" width:100px">
		 <option >-Select-</option>
		 <?php 
		
		 for($j=0;$j<count($sec1);$j++)
		   {
 ?><option value="<?php echo $sec1[$j]; ?>" <?php  if ( $qr['warehouse'] == $sec1[$j] ) {?> selected="selected" <?php } ?>  title="<?php echo $sec1[$j]; ?>"><?php echo $sec1[$j]; ?></option>
<?php }

?>
         </select>
       </td>


<td width="10px">&nbsp;</td>
   
	   
    </tr>
	
	
	 <?php
	  } ?>
   </table>
<br>
<br>
<?php if($_SESSION['db']=="mew") {?>
<table align="center">
<tr>
<th style=""><strong>Narration<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th>
        <th width="10px"></th>
<td><textarea rows="3" cols="30" id="remarks" name="remarks"><?php echo $remarks;?></textarea></td>
      
</tr>
</table>
<?php } ?>

<br>
<br>

   <input type="submit" value="Save" id="save" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=ims_intermediateissue';">

</form>
</center>

<script type="text/javascript">
function script1() {
window.open('IMSHelp/help_t_addintermediatereceipt.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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


    <p>
  <script type="text/javascript">

var index="<?php echo $i;?>";
function warehousechecking()
{


  
  if(document.getElementById('date').value=="")
{

	alert("Select date");
	return false;

}

if(document.getElementById('doc').value=="")
  {
  
  	alert("Enter document number");
	return false;
  
  }

  <?php if($_SESSION['db']=="mew"){ ?>
  if(document.getElementById('remarks').value=="")
  {
  
  	alert("Enter Narration");
	return false;
  
  }
  
  <?php } ?>


	  var cat =document.getElementById("cat@0").value;
	  var code=document.getElementById("code@0").value;
	  var desc=document.getElementById("description@0").value;
	
var quantity=document.getElementById("quantity@0").value;
	
	   var coa=document.getElementById("coa@0").value;
	     var warehouse=document.getElementById("warehouse@0").value;
	  if(cat=="" ||code=="" || desc=="" || quantity=="" ||quantity==0 || coa=="" || warehouse=="")
	  {alert("select all the fields of 1st row");
	  return false;
	  }
	  
	for(j=0;j<index;j++)
	{


	var cat =document.getElementById("cat@"+j).value;
	var code= document.getElementById("code@"+j).value;
	var desc =document.getElementById("description@"+j).value;
	
	var qty=document.getElementById("quantity@"+j).value;
	
	   var coa=document.getElementById("coa@"+j).value;
    var warehouse=document.getElementById("warehouse@"+j).value;
	
	if(cat=="" || code== "" || desc==""  ||qty=="" || qty=="" || coa=="" || warehouse=="" )
	{
	
	alert("Please fill the all fields of row "+(j+1));
	
		return false;
		}
	

}
	
document.getElementById("save").disabled=true;	



}

function loadcodes(id)
{


	var index1;
	var id1 = id.split("@");
	index1 = id1[1];
	var cat = document.getElementById(id).value;

	
	document.getElementById('units@' + index1).value = "";
	
	
	removeAllOptions(document.getElementById("code@" + index1));
	myselect1 = document.getElementById("code@" + index1);
   
	removeAllOptions(document.getElementById('description@' + index1));
	myselect2 = document.getElementById('description@' + index1);
    
	
	
	
var l=items.length;		  
for(i=0;i<l;i++)
{
if(items[i].cat == cat)
{
var ll=items[i].cd.split(",");
for(j=0;j<ll.length;j++)
{ 
var expp=ll[j].split("@");
var op1=new Option(expp[0],ll[j]);

op1.title=expp[0];

var op2=new Option(expp[1],ll[j]);

op2.title=expp[1];

document.getElementById("code@" + index1).options.add(op1);
document.getElementById("description@" + index1).options.add(op2);
}
}
}
	
	
	
}

function getcode(codeid,value)
{


	  var temp = codeid.split("@");
     var tempindex = temp[1];
	 var temp2 = value.split("@");

if(value=="")

{

document.getElementById('code@' + tempindex).value = "";
document.getElementById('description@' +tempindex).value="";
document.getElementById("units@"+tempindex).value="";
				return false;

}

for(var i = 0;i<=index;i++)
{
	for(var j = 0;j<=index;j++)
	{
		
		if( i != j)
		{
			if(document.getElementById('description@' + i).value == document.getElementById('description@' + j).value)
			{
				
				
				alert("Please select different combination");
				document.getElementById('code@' + tempindex).value = "";
				document.getElementById('description@' +tempindex).value="";
				document.getElementById("units@"+tempindex).value="";
				return false;
			}
		}
	}
}

 document.getElementById("units@"+tempindex).value = temp2[2];
     document.getElementById("code@" + tempindex).value = document.getElementById("description@" + tempindex).value;
	


}
function loaddescription(codeid,value)
{


	 var temp = codeid.split("@");
     var tempindex = temp[1];
	 var temp2 = value.split("@");

if(value=="")

{

document.getElementById('code@' + tempindex).value = "";
document.getElementById('description@' +tempindex).value="";
document.getElementById("units@"+tempindex).value="";
				return false;

}

for(var i = 0;i<=index;i++)
{
	for(var j = 0;j<=index;j++)
	{
		
		if( i != j)
		{
			if(document.getElementById('code@' + i).value == document.getElementById('code@' + j).value)
			{
				
				
				alert("Please select different combination");
				document.getElementById('code@' + tempindex).value = "";
				document.getElementById('description@' +tempindex).value="";
				document.getElementById("units@"+tempindex).value="";
				return false;
			}
		}
	}
}


	 document.getElementById("units@"+tempindex).value = temp2[2];
     document.getElementById("description@" + tempindex).value = document.getElementById("code@" + tempindex).value;


		
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
  </script>
      
  
    <p>&nbsp;</p>
</body>
</html>