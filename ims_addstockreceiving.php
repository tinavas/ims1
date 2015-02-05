
<?php 
include "jquery.php";
include "config.php"; 
$client = $_SESSION['client'];
$i=0;
$q1=mysql_query("SET group_concat_max_len=10000000");
//getting cat,itemcodes
$query="select cat,group_concat(concat(code,'@',description,'@',sunits) ) as cd from ims_itemcodes where (source = 'Purchased' or source = 'Produced or Purchased' or source = 'Produced')  group by cat";
$result=mysql_query($query,$conn);
$i=0;
while($r=mysql_fetch_array($result))
{
$items[$i]=array("cat"=>"$r[cat]","cd"=>"$r[cd]");
$i++;
} 
$item=json_encode($items);

$o=0;
if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
{
$q1 = "SELECT towarehouse,GROUP_CONCAT( DISTINCT (tmno)) as tid FROM ims_stocktransfer WHERE flag='0' and tmno not in (select distinct transferid FROM  `ims_stockreceive` ) group by tid";
}
else
{
$sectorlist = $_SESSION['sectorlist'];
$q1 = "SELECT towarehouse,GROUP_CONCAT( DISTINCT (tmno)) as tid FROM ims_stocktransfer WHERE flag='0' and tmno not in (select distinct transferid FROM  `ims_stockreceive` ) and towarehouse in ($sectorlist) group by tid";
}
 $res1 = mysql_query($q1,$conn); 
while($rows1 = mysql_fetch_assoc($res1))
     {
	$trn[]=array("warehouse" =>$rows1[towarehouse],"tid"=>$rows1[tid]);
	if(in_array($rows1["towarehouse"],$sec))
	{

 }
 else
 {
 $sec[$o]=$rows1["towarehouse"];	
 $o++;
 }
	 }
	 $trns=json_encode($trn);
//getting to warehouses

$q1 = "SELECT GROUP_CONCAT( DISTINCT (fromwarehouse)  ) as sector FROM ims_stocktransfer  where flag='0'";



 $res1 = mysql_query($q1,$conn); 
$rows1 = mysql_fetch_assoc($res1);
     {
 $sec1=explode(",",$rows1["sector"]);	
	 }
	 $sector=json_encode($sec1);
	 
	 if($_GET['date']<>"")
	 {
	 $date=date("d.m.Y",strtotime($_GET['date']));
	 }
	 else
	 {
	 $date=date("d.m.Y");
	 }
	 $dt=date('Y-m-d',strtotime($date));
	 
	 
?>
<script type="text/javascript">
var items=<?php if(empty($item)){echo 0;} else{ echo $item; }?>;
var sectors1=<?php if(empty($sector)){echo 0;} else{ echo $sector; }?>;
var trns=<?php if(empty($trns)){echo 0;} else{ echo $trns; }?>;
</script>
	<?php	
	$q1="SELECT max(right(tid,length(tid)-4)*1) as max FROM `ims_stockreceive` order by id desc";

$q1=mysql_query($q1) or die(mysql_error());

$r1=mysql_fetch_assoc($q1);

if($r1['max']=="" || $r1['max']=="0")
{
$incr=1;
}
else
{
$incr=$r1['max']+1;
}

$tnum="SRC-".$incr;

?>




<center>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="min-height:600px" id="complex_form" name="form" method="post" onSubmit="return checkform(this)" action="ims_savestockreceive1.php" >
	  <h1 id="title1">Stock Receiving</h1>
		
  
<br />
<b>Stock Receiving</b>
<br />

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)<br /><br />
  


<br /><br />

<input type="hidden" name="saed" id="saed" value="save" />
<table align="center">
<tr>
 <td align="right"><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
 <td align="left"><input type="text" size="15" id="date" name="edate" class="datepickerinv" value="<?php echo $date; ?>" onchange="reloadpage()" />&nbsp;&nbsp;&nbsp;</td>
 <td align="right"><strong>To Warehouse</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
 <td align="left"><select id="warehouse" name="warehouse" style="width:180px;" onchange="gettrnos(this.value)">
         <option value="">-Select-</option>
 <?php
          
          
		   for($j=0;$j<count($sec);$j++)
		   {
			
           ?>
<option value="<?php echo $sec[$j];?>" title="<?php echo $sec[$j]; ?>" <?php if($_GET[w]==$sec[$j]){?> selected="selected" <?php }?>><?php echo $sec[$j]; ?></option>
<?php } ?>


       </select>
 </td>
 <td align="right"><strong>Transfer Tr.No</strong>&nbsp;&nbsp;&nbsp;</td>
 <td align="left"><select id="str" name="str" onchange="reloadpage()">
 <option value="">-Select-</option>
 <?php $qq=mysql_query("select distinct(tmno) as tid from ims_stocktransfer where towarehouse='$_GET[w]' and date <='$dt' and  tmno not in (select distinct transferid FROM  `ims_stockreceive` ) and flag='0'");
while($rr=mysql_fetch_array($qq))
{?>
<option value="<?php echo $rr[tid];?>" <?php if($_GET[str]==$rr[tid]){ ?> selected="selected" <?php }?>><?php echo $rr[tid];?></option>
<?php }?>
 </select>
 &nbsp;&nbsp;&nbsp;</td>
 
 <td align="right"><strong>Tr.No</strong>&nbsp;&nbsp;&nbsp;</td>
 <td align="left"><input type="text" size="8" id="trno" name="trno"  value="<?php echo $tnum; ?>" readonly="true" style="background:none; border:0px;" />&nbsp;&nbsp;&nbsp;</td>
 
 <td title="Transfer Memo/Delivery Challan"><strong>DC #</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
<td> <input type="text"  size="7" id="tmno"  name="tmno"  /></td>
 
</tr>
<tr style="height:20px"></tr>
</table>

<table id="paraID" align="center">
<tr align="center">
  <th width="10px">&nbsp;</th>
  <th><strong>Sent Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
  <th width="10px">&nbsp;</th>
  <th><strong>Category</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
  <th width="10px">&nbsp;</th>
  <th><strong>Code<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>   </strong></th>
  <th width="10px">&nbsp;</th>
  <th><strong>Description<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>   </strong></th>
  <th width="10px">&nbsp;</th>
  <th><strong>Units</strong></th>
  <th width="10px">&nbsp;</th>
  <th><strong>From Warehouse<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>   </strong></th>
   <th width="10px">&nbsp;</th>
  <th style="text-align:left"><strong>Sent Quantity<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>   </strong></th>
  <th width="10px">&nbsp;</th>
  <th><strong>Received Quantity<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>   </strong></th>
  <th width="10px">&nbsp;</th>
  <th><strong>Transfer Loss<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>   </strong></th>
</tr>
<?php 
$s=1;
$q1=mysql_query("select * from ims_stocktransfer where tmno='$_GET[str]'  ");
while($r1=mysql_fetch_array($q1))
{
$sdate=$r1['date'];
$r3=mysql_fetch_assoc(mysql_query("select * from ims_itemcodes where code='".$r1[code]."'"));
?>
<tr style="height:10px"></tr>
<tr align="center">


<td width="10px">&nbsp;</td>
 <td><input type="text" size="18" name="date[]" value="<?php echo date("d.m.Y",strtotime($sdate)); ?>" readonly style="background:none; border:0px" />
 </td>
 
 <td width="10px">&nbsp;</td>
 <td><input type="text" size="18" name="cat[]" value="<?php echo $r1[cat];?>" readonly style="background:none; border:0px" />
 </td>

 <td width="10px"></td>

<td>
<input type="text" size="8" name="code[]" value="<?php echo $r1[code];?>" readonly style="background:none; border:0px" />
</td>

<td width="10px"></td>

<td>
<input type="text" size="25" name="desc[]" value="<?php echo $r3[description];?>" readonly style="background:none; border:0px" />
</td>

<td width="10px">&nbsp;</td>

<td><input type="text" size="8"  name="units[]" value="<?php echo $r1[fromunits];?>" readonly style="background:none; border:0px" /></td>

<td width="10px">&nbsp;</td>

<td><input type="text" size="18" name="towarehouse[]" value="<?php echo $r1[fromwarehouse];?>" readonly style="background:none; border:0px" /></td>

<td width="10px">&nbsp;</td>

<td><input type="text"  size="8"  id="squantity@<?php echo $s;?>" name="squantity[]" value="<?php echo $r1[quantity];?>"  style="background:none; border:0px"  /></td>

<td width="10px">&nbsp;</td>

<td><input type="text"  size="8" id="rquantity@<?php echo $s;?>"  name="rquantity[]" value="0" onkeyup="loss(this.id)"  onKeyPress="return num1(this.id,event.keyCode)" /></td>
<td width="10px">&nbsp;</td>
<td><input type="text"  size="8" id="lossqty@<?php echo $s;?>"  name="lossqty[]" readonly="readonly" value="0"  onKeyPress="return num1(this.id,event.keyCode)" /></td>


</tr>
<?php $s++; }?>
<tr><td><input type="hidden" name="sdate" value="<?php echo $sdate;?>"  id="sdate" /></td></tr>
</table>

<br/>



<table align="center">
<tr>
<td colspan="5" align="center">
<center>
<input type="submit" id="Save" value="Save" />&nbsp;&nbsp;&nbsp;<input type="button" id="Cancel" value="Cancel" onClick="document.location='dashboardsub.php?page=ims_stockreceive';"/>
</center>
</td>
</tr>
</table>
</form>
</div>
</section>
</center>
	<script type="text/javascript">
	function reloadpage()
	{
	var warehouse=document.getElementById("warehouse").value;
	var str=document.getElementById("str").value;
	var date=document.getElementById("date").value;
	document.location="dashboardsub.php?page=ims_addstockreceiving&w="+warehouse+"&str="+str+"&date="+date;
	}
	function loss(id)
	{
	var index=id.split('@');
	var i=index[1];
	//alert(i);
	var sqty=document.getElementById("squantity@"+i).value;
	var rqty=document.getElementById("rquantity@"+i).value;
	if((parseInt(sqty)-parseInt(rqty))>=0)
	{
	document.getElementById("lossqty@"+i).value=parseInt(sqty)-parseInt(rqty);
	}
	else
	{
	alert("Received Quantity Should Not Be Greater Than Sent Quantity");
	document.getElementById("rquantity@"+i).value="";
	}
	}
	function gettrnos(a)
	{
	var myselect1=document.getElementById("str");
	myselect1.options.length=1;

	for(i=0;i<trns.length;i++){
		if(trns[i].warehouse==a){
		var val=trns[i].tid.split(",");
		for(j=0;j<val.length;j++)
		{
			var op=new Option(val[j],val[j]);
			op.title=val[j];
			myselect1.add(op);
		}}}
		
	}
	function checkform()
	{
/*	var s="<?php echo $s;?>";
	alert(s)
	for(i=1;i<s;i++)
	{
	var actualqty=document.getElementById("squantity"+i).value;
	var receiveqty=document.getElementById("rquantity"+i).value;
	var lossqty=document.getElementById("lossqty"+i).value;
	if(actualqty==(parseInt(receiveqty)+parseInt(lossqty)))
	{
	}
	else
	{
	alert("Received quantity + loss quantity should be equal to Sent Quantity");
	document.getElementById("rquantity"+i).focus();
	return false;
	}
	}*/
	//alert(document.getElementById("sdate").value);
	var warehouse=document.getElementById("warehouse").value;
	if(warehouse=="")
	  {
	  	alert("select warehouse");
		return false;
	  }
	  var dcno=document.getElementById("tmno").value;
	if(dcno=="")
	  {
	  	alert("Enter dc. number");
		return false;
	  
	  }
	  var warehouse=warehouse.split("@");
	  warehouse=warehouse[0];
	
	
	  var cat =document.getElementById("cat@-1").value;
	  var code=document.getElementById("code@-1").value;
	  var desc=document.getElementById("desc@-1").value;
	var towarehouse= document.getElementById("towarehouse@-1").value;
	
	if(warehouse==towarehouse)
	{
		alert("From warehosue and towarehouse should be differeent for 1st row");
		return false;
	
	}
	 
	  var quantity=document.getElementById("squantity@-1").value;
	  if(cat=="" ||code=="" || desc=="" || quantity=="" ||quantity==0 || towarehouse=="")
	  return false;
	  
	  
	for(j=-1;j<index;j++)
	{


	var cat =document.getElementById("cat@"+j).value;
	var code= document.getElementById("code@"+j).value;
	var desc =document.getElementById("desc@"+j).value;
	var towarehouse= document.getElementById("towarehouse@"+j).value;
	var qty=document.getElementById("squantity@"+j).value;
	if(warehouse==towarehouse)
	{
		alert("From warehosue and towarehouse should be differeent for"+j+"row");
		return false;
	
	}
	
	if(cat=="" || code== "" || desc=="" || towarehouse=="" ||qty=="")
	
		return false;
	

}
	  
	document.getElementById('Save').disabled=true;
	
	}
	


function num1(a,b)
{

	if((b<48 || b>57) &&(b!=46))
	{
	 	event.keyCode=false;
		return false;
	
		
	}
	
	

}
	
	
function script1() {
window.open('IMSHelp/help_t_addstocktransfer.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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


///////////////makeform//////////////

///////////////end of make form////////////////



</script>




<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>

