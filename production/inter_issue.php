<html>
<body>
<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "getemployee.php"; 
 
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php include "phprptinc/ewrcfg3.php"; ?>
<?php include "phprptinc/ewmysql.php"; ?>
<?php include "phprptinc/ewrfn3.php"; ?>
<?php include "phprptinc/header.php"; ?>
 <form method="get" >
<?php

?>
<table align="center" border="0">
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276"><h2>Intermediate Issue Report</h2></font></strong></td>
  
</tr>
<tr height="5px"></tr>
<tr>
<?php
if($_GET['fdate']!="" )
{?>
 <td><strong>From : </strong><?php echo date($datephp,strtotime($_GET['fdate'])); ?></td>
 <?php
 }
 else{?>
 <td><strong>From : </strong><?php echo date('d.m.Y'); ?></td>&nbsp;&nbsp;<?php } 
 if($_GET['tdate']!="")
{?>
<td><strong>To : </strong><?php echo date($datephp,strtotime($_GET['tdate']));?></td>
<?php
}
else
{
?>
<td><strong>To : </strong><?php echo date('d.m.Y'); ?></td>
<?php } ?>
</tr>  
<tr><?php
if($_GET['wh']!="")
{?>
  
<td><strong>Warehouse:<strong><?php echo $_GET['wh'];?></td>
 
<?php 
}else{?>
<td><?php echo "<strong>Warehouse</strong>:All"; ?></td>
<?php
}
?>
<tr>

<tr><?php
if($_GET['cat']!="")
{?>
  
<td><strong>Category:</strong><?php echo $_GET['cat'];?></td>
 
<?php 
}else{?>
<td><?php echo "<strong>Category</strong>:All"; ?></td>
<?php
}
?>
<tr>

<tr><?php
if($_GET['code']!="")
{?>
  
<td><strong>Code:</strong><?php echo $_GET['code'];?></td>
 
<?php 
}else{?>
<td><?php echo "<strong>Code</strong>:All"; ?></td>
<?php
}
?>
<tr>

<tr><?php
if($_GET['desc']!="")
{?>
  
<td><strong>Description:</strong><?php echo $_GET['desc'];?></td>
 
<?php 
}else{?>
<td><?php echo "<strong>Description</strong>:All"; ?></td>
<?php
}
?>
<tr>

<tr><?php
if($_GET['coa']!="")
{?>
  
<td><strong>Coa:</strong><?php echo $_GET['coa'];?></td>
 
<?php 
}else{?>
<td><?php echo "<strong>Coa</strong>:All"; ?></td>
<?php
}
?>
<tr>


 
</tr> 
</table>

<?php
 if($_GET['fdate']!="" )
{
$fdate=date("Y-m-d",strtotime($_GET['fdate']));
//$cond="and date between '$fdate' and '$tdate'";
}
else
{
  $fdate=date('Y-m-d');
  //$cond=" ";
}   
if($_GET['tdate']!="")
{
$tdate= date("Y-m-d",strtotime($_GET['tdate']));
//$cond="and date between '$fdate' and '$tdate'";
}
else
{
  $tdate=date('Y-m-d');
  //$cond=" ";
}
if($_GET['wh']!="")
{
  $wh=$_GET['wh'];
  //$cond1="and warehouse='$wh'";
}
else
{
  $wh="";
  //$cond1=" ";
}
if($_GET['cat']!="")
{
  $cat=$_GET['cat'];
  //$cond2="and cat='$cat'";
}
else
{
  $cat="";
  //$cond2=" ";
}

if($_GET['code']!="")
{
  $code=$_GET['code'];
  //$cond3="and code='$code'";
}
else
{
  $code="";
  //$cond3=" ";
}
if($_GET['desc']!="")
{
  $desc=$_GET['desc'];
  //$cond4="and description='$desc'";
}
else
{
  $desc="";
  //$cond4=" ";
}

if($_GET['coa']!="")
{
  $coa=$_GET['coa'];
  //$cond5="and coa='$coa'";
}
else
{
  $coa="";
  //$cond5=" ";
}

if($wh!='' && $cat=='' && $code=='' && $coa=='')
{
 $cond="where date between '$fdate' and '$tdate' and warehouse='$wh'";
}
else if($wh=='' && $cat!='' && $code=='' && $coa=='')
{
 $cond="where date between '$fdate' and '$tdate' and cat='$cat'";
}
else if($wh=='' && $cat=='' && $code!='' && $coa=='')
{
 $cond="where date between '$fdate' and '$tdate' and code='$code' and description='$desc'";
}

else if($wh=='' && $cat=='' && $code=='' && $coa!='')
{
 $cond="where date between '$fdate' and '$tdate' and coa='$coa'";
}

else if($wh!='' &&$cat!=''&& $code==''&&$coa=='')
{
 $cond="where date between '$fdate' and '$tdate' and warehouse='$wh' and cat='$cat'";
}

else if($wh!='' &&$cat==''&& $code!=''&&$coa=='')
{
 $cond="where date between '$fdate' and '$tdate' and warehouse='$wh' and code='$code' and description='$desc'";
}

else if($wh!='' &&$cat==''&& $code==''&&$coa!='')
{
 $cond="where date between '$fdate' and '$tdate' and warehouse='$wh' and coa='$coa'";
}

else if($wh=='' &&$cat!=''&& $code!=''&&$coa=='')
{
 $cond="where date between '$fdate' and '$tdate' and cat='$cat' and code='$code' and description='$desc'";
}

else if($wh=='' &&$cat!=''&& $code==''&&$coa!='')
{
 $cond="where date between '$fdate' and '$tdate' and cat='$cat' and code='$code' and description='$desc'";
}

else if($wh=='' &&$cat==''&& $code!=''&&$coa!='')
{
 $cond="where date between '$fdate' and '$tdate' and code='$code' and description='$desc' and coa='$coa'";
}

else if($wh!='' &&$cat!=''&& $code!=''&&$coa=='')
{
 $cond="where date between '$fdate' and '$tdate' and warehouse='$wh' and cat='$cat' and code='$code' and description='$desc'";
}

else if($wh=='' &&$cat!=''&& $code!=''&&$coa!='')
{
$cond="where date between '$fdate' and '$tdate' and cat='$cat' and code='$code' and description='$desc' and coa='$coa'";
}

else if($wh!='' &&$cat==''&& $code!=''&&$coa!='')
{
 $cond="where date between '$fdate' and '$tdate' and warehouse='$wh' and code='$code' and description='$desc' and coa='$coa'";
}

else if($wh!='' &&$cat!=''&& $code==''&&$coa!='')
{
$cond="where date between '$fdate' and '$tdate' and warehouse='$wh' and cat='$cat' and coa='$coa'";
}

else if($wh!='' &&$cat!=''&& $code!=''&&$coa!='')
{
 $cond="where date between '$fdate' and '$tdate' and warehouse='$wh' and cat='$cat' and code='$code' and description='$desc'  and coa='$coa'";
}

else
{
 $cond = "where date between '$fdate' and '$tdate'";
}

?>
<?php
$sExport = @$_GET["export"]; // Load export request
if ($sExport == "html") {
	// Printer friendly
}
if ($sExport == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . EW_REPORT_TABLE_VAR .'.xls');
}
if ($sExport == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . EW_REPORT_TABLE_VAR .'.doc');
}
?>



<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0" align="center">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<?php } ?>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;
<a href="inter_issue.php?export=html&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&wh=<?php echo $wh;?>&cat=<?php echo $cat;?>&code=<?php echo $code;?>&desc=<?php echo $desc;?>&coa=<?php echo $coa;?>">Printer Friendly</a>
&nbsp;&nbsp;
<a href="inter_issue.php?export=excel&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&wh=<?php echo $wh;?>&cat=<?php echo $cat;?>&code=<?php echo $code;?>&desc=<?php echo $desc;?>&coa=<?php echo $coa;?>">Export to Excel</a>
&nbsp;&nbsp;
<a href="inter_issue.php?export=word&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&wh=<?php echo $wh;?>&cat=<?php echo $cat;?>&code=<?php echo $code;?>&desc=<?php echo $desc;?>&coa=<?php echo $coa;?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="inter_issue.php?cmd=reset&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&wh=<?php echo $wh;?>&cat=<?php echo $cat;?>&code=<?php echo $code;?>&desc=<?php echo $desc;?>&coa=<?php echo $coa;?>">Reset All Filters</a>
<?php } ?>
<?php } ?>
<br /><br />
<?php if (@$sExport == "") { ?>
</div></td></tr>
<!-- Top Container (End) -->
<tr>
	<!-- Left Container (Begin) -->
	<td valign="top"><div id="ewLeft" class="phpreportmaker">
	<!-- Left slot -->
	</div></td>
	<!-- Left Container (End) -->
	<!-- Center Container - Report (Begin) -->
	<td valign="top" class="ewPadding"><div id="ewCenter" class="phpreportmaker">
	<!-- center slot -->
<?php } ?>
<!-- summary report starts -->
<div id="report_summary">

<table class="ewGrid" cellspacing="0" align="center"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
 
<table align="center">
 <tr>
  <td><b>From Date:</b></td>
 <td><input type="text" id="fdate" name="fdate" class="datepicker" onChange="send()" value="<?php echo date("d.m.Y",strtotime($fdate)); ?>"></td>
 <td><b>To Date:</b></td>
 <td><input type="text" id="tdate" name="tdate" class="datepicker" onChange="send()" value="<?php echo date("d.m.Y",strtotime($tdate));?>"></td>
<?php 
  $q="select distinct(sector) as 'sector' from tbl_sector where (type1 = 'Warehouse' or type1 = 'Chicken Center' or type1 = 'Egg Center') and client = '$client' order by sector";
  $r=mysql_query($q,$conn1);
  
?>
 <td><b>Warehouse:</b></td>
 <td><select id="wh" name="wh" onChange="send()"> 
 <option value="">--All--</option>
 <?php
 while($rows=mysql_fetch_array($r))
  {
 ?> 
 <option value="<?php echo $rows['sector'];?>" <?php if($wh==$rows['sector']){?> selected="selected" <?php } ?>><?php echo $rows['sector'];?></option>
 <?php } ?>
 </select></td>
 <td><b>Category:</b></td>
 <td>
 <select id="cat" name="cat"  onChange="loadcodes(this.value);send();" >
 <option value="">--All--</option>
    <?php 
	$q1="SELECT * FROM ims_itemtypes ORDER BY type ASC";
	$r1=mysql_query($q1,$conn1);
	while($rw=mysql_fetch_array($r1))
	{
	?>  
    <option value="<?php echo $rw['type'];?>" <?php if($cat==$rw['type']){?> selected="selected" <?php } ?> ><?php echo $rw['type'];?>
	</option>	    
	<?php
	}
	?> </select></td>
	 
	<td><b>Code:</b></td>
	<?php if($cat=='')
	{
	?>
	<td> 
	<select id="code" name="code" onChange="load_desc(this.id)" onChange="send()">
	<option value="">--All--</option>
	<?php /*?><?php
	$q4="select distinct(code) from ims_itemcodes order by code";
	$r4=mysql_query($q4,$conn);
	while($rw4=mysql_fetch_array($r4))
	{
	?>
	<option value="<?php echo $rw4['code'];?>" <?php if($code==$rw4['code']){?> selected="selected" <?php } ?>><?php echo $rw4['code'];?></option>
	<?php } ?><?php */?>
	</select>
	</td>
	<?php }
	else 
	{
	?>
	<td> 
	<select id="code" name="code" onChange="load_desc(this.id)" onChange="send()">
	<option value="">--All--</option>
	<?php
	$q4="select distinct(code) from ims_itemcodes where cat='$cat' order by code";
	$r4=mysql_query($q4,$conn1);
	while($rw4=mysql_fetch_array($r4))
	{
	?>
	<option value="<?php echo $rw4['code'];?>" <?php if($code==$rw4['code']){?> selected="selected" <?php } ?>><?php echo $rw4['code'];?></option>
	<?php } ?>
	</select>
	</td>
	<?php } ?>
	
	<td><b>Description:</b></td>
	<?php if($cat==''){?>
	<td><select id="desc" name="desc" onChange="load_code(this.id)">
	<option value="">--All--</option>
	<?php /*?><?php
	$q5="select distinct(description) from ims_itemcodes order by description";
	$r5=mysql_query($q5,$conn);
	while($rw5=mysql_fetch_array($r5))
	{
	?>
	<option value="<?php echo $rw5['description'];?>" <?php if($desc==$rw5['description']){?> selected="selected" <?php } ?>><?php echo $rw5['description'];?></option>
	<?php } ?><?php */?>
	</select>
</td>
<?php }
else
{
 ?>
 <td><select id="desc" name="desc" onChange="load_code(this.id)">
	<option value="">--All--</option>
	<?php
	$q5="select distinct(description) from ims_itemcodes where cat='$cat' order by description";
	$r5=mysql_query($q5,$conn1);
	while($rw5=mysql_fetch_array($r5))
	{
	?>
	<option value="<?php echo $rw5['description'];?>" <?php if($desc==$rw5['description']){?> selected="selected" <?php } ?>><?php echo $rw5['description'];?></option>
	<?php } ?>
	</select>
</td>
<?php } ?>
	
	<td><b>Coa:</b></td>
	<td><select id="coa" name="coa" onChange="send()">
	<option value="">--All--</option>
	<?php
	$q3="select distinct(code),description from ac_coa where (controltype = '' OR controltype IS NULL) AND (type != 'Capital')  and code not like 'CG%' and code not like  'PV%' and code not like  'PR%' and code not like 'WP%' order by code";
	$r3=mysql_query($q3,$conn1);
	while($rw3=mysql_fetch_array($r3))
	{
	?>
	<option value="<?php echo $rw3['code'];?>" <?php if($coa==$rw3['code']){?> selected="selected" <?php } ?>><?php echo $rw3['code'];?></option>
	<?php } ?>
	</select>
	</td>
</tr>
</table>	  
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">

<table class="ewTable ewTableSeparate" cellspacing="0" align="center" border="2" >

	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table  cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  style="width:100px;" align="center">Date</td>
			</tr></table>
		</td>
<?php } ?>
 
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Warehouse
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Warehouse</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Category
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Category</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Itemcode
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Itemcode</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Item Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Item Description</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Rate/Unit
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Rate/Unit</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Amount</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Coa
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Coa</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Coa Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Coa Description</td>
			</tr></table>
		</td>
<?php } ?>
 
	</tr>
	</thead>
	<tbody>
<?php
{ 
  
  $date="";
  $ware="";
  $cat="";
  $cd="";
  $de="";
  $total=0;
  $totalqty=0;
 $query="select date,warehouse,cat,code,description,quantity,rateperunit,amount,coa from ims_intermediatereceipt $cond and riflag='I' order by date,warehouse,cat,code,description";
  $res=mysql_query($query,$conn1) or die(mysql_error());
  $c=mysql_num_rows($res);
   if($c!=0)
   {
  while($rows=mysql_fetch_array($res))
  {
      
      $q1="select description from ac_coa where code='$rows[coa]'";
	  $res1=mysql_query($q1,$conn1);
	  $r=mysql_fetch_assoc($res1)
	  
?>
	<tr>
	<?php if($date!=$rows['date']){ ?>
		<td class="ewRptGrpField1">
<?php 
$date1=date('d.m.Y',strtotime($rows['date']));
echo ewrpt_ViewValue($date1) ?></td>
<?php } else{ ?><td>&nbsp;</td><?php } ?>
 
<?php if($ware!=$rows['warehouse']){ ?>
	  <td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows['warehouse']) ?></td>
<?php } else{ ?><td>&nbsp;</td><?php } ?>

<?php if($cat!=$rows['cat']){ ?>
     <td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue($rows['cat']) ?></td>
<?php } else{ ?><td>&nbsp;</td><?php } ?>

    <?php if($cd!=$rows['code']){ ?>
	 <td class="ewRptGrpField4">
<?php echo ewrpt_ViewValue($rows['code']) ?></td>
<?php } else{ ?><td>&nbsp;</td><?php } ?>

<?php if($de!=$rows['description']){ ?>
	<td class="ewRptGrpField5">
<?php echo ewrpt_ViewValue($rows['description']) ?></td>
<?php } else{ ?><td>&nbsp;</td><?php } ?>

	<td class="ewRptGrpField6" align="right">
<?php echo changeprice($rows['quantity']); $totalqty=$totalqty+$rows['quantity']; ?></td>
	
	<td class="ewRptGrpField7" align="right">
<?php echo changeprice($rows['rateperunit']); ?></td>

<td class="ewRptGrpField7" align="right">
<?php echo changeprice($rows['amount']);$total=$total+$rows['amount'];?></td>
	
	
	<td class="ewRptGrpField8">
<?php echo ewrpt_ViewValue($rows['coa']) ?></td>
	
	<td class="ewRptGrpField9">
	<?php echo ewrpt_ViewValue($r['description']) ?></td>
	
 
	</tr>
	
<?php
    $j++;
	$date=$rows['date'];
	$ware=$rows['warehouse'];
	$cat=$rows['cat'];
	$cd=$rows['code'];
	$de=$rows['description'];
   } ?>
   <tr>
<td colspan="5" align="center"><b>Total</b></td>
<td class="ewRptGrpField2" align="right" >

<?php echo changeprice($totalqty); ?></td>
<td class="ewRptGrpField2" align="right" >&nbsp;
</td>
<td class="ewRptGrpField2" align="right" >

<?php echo changeprice($total); ?></td></tr>
 <?php 
    
}
else
{
?>
<tr><td><b>No records found</b></td></tr>
<?php 
}
}
?>
</tbody>
<tfoot>
</tfoot>
</table>
</div>
</table>
</div>
<?php if (@$sExport == "") { ?>
	</div><br /></td>
</tr>
</table>

</form>

<?php } ?>
<?php include "phprptinc/footer.php"; ?>
</body>
</html>
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript">
//function reloadpage()
//{
//	var fdate = document.getElementById('fromdate').value;
//	var tdate = document.getElementById('todate').value;
//	document.location = "cstaff_list.php?fromdate=" + fdate + "&todate=" + tdate;
//}
$(function(){

    $('.datepicker').datepicker({
	     inline:true,
		 changeYear:true,
		 changeMonth:true,
		 numberofMonths:1,
		 dateFormat:'yy-mm-dd'
     
     });
});
function filter(a)
{
  var clas=document.getElementById(a).value;
    //alert(clas);
  document.location="examschedule_list.php?clas="+clas;

}
function send()
{
  var fdate=document.getElementById("fdate").value;
  var tdate=document.getElementById("tdate").value;
  var wh1=document.getElementById("wh").value;
  var cat1=document.getElementById("cat").value;
  var coa1=document.getElementById("coa").value;
  var code=document.getElementById("code").value;
  var desc=document.getElementById("desc").value;
  document.location="inter_issue.php?fdate="+fdate+"&tdate="+tdate+"&wh="+wh1+"&cat="+cat1+"&code="+code+"&desc="+desc+"&coa="+coa1;

}


function send1(a)
{
  var wh1=document.getElementById(a).value;
  document.location="inter_issue.php?wh="+wh1;
}

function loadcodes(cat)
{
  var c=document.getElementById("code").options.length;
  var d=document.getElementById("desc").options.length;
    for(var i=c;i>=0;i--)
    {
        document.getElementById("code").remove(i);
    }
	for(var i=d;i>=0;i--)
    {
        document.getElementById("desc").remove(i);
    }
	
	
    myselect1 = document.getElementById("code");
    theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("-Select-");
    theOption1.appendChild(theText1);
	theOption1.value = "";
    myselect1.appendChild(theOption1);
	
	myselect2 = document.getElementById('desc');
    theOption2=document.createElement("OPTION");
    theText2=document.createTextNode("-Select-");
    theOption2.appendChild(theText2);
	theOption2.value = "";
    myselect2.appendChild(theOption2);

	<?php 
		$q = "select distinct(cat) from ims_itemcodes order by cat";
		$qrs = mysql_query($q) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		echo "if(cat == '$qr[cat]') { ";
		$q1 = "select distinct(code) from ims_itemcodes where cat = '$qr[cat]' order by code";
		$q1rs = mysql_query($q1) or die(mysql_error());
		while($q1r = mysql_fetch_assoc($q1rs))
		{
		?>
	    theOption1=document.createElement("OPTION");
   	 	theText1=document.createTextNode("<?php echo $q1r['code']; ?>");
   		theOption1.appendChild(theText1);
		theOption1.value = "<?php echo $q1r['code']; ?>";
    	myselect1.appendChild(theOption1);
		
		
		
		<?php } 
		
		$q1 = "select distinct(description) from ims_itemcodes where cat = '$qr[cat]' order by description";
		$q1rs = mysql_query($q1) or die(mysql_error());
		while($desc = mysql_fetch_assoc($q1rs))
		{
		
	?>
	    theOption1=document.createElement("OPTION");
   	 	theText1=document.createTextNode("<?php echo $desc['description']; ?>");
   		theOption1.appendChild(theText1);
		theOption1.value = "<?php echo $desc['description']; ?>";
		theOption1.title = "<?php echo $desc['description']; ?>";
    	myselect2.appendChild(theOption1);
				
		<?php }
		
		echo " } "; } ?>

}

function load_desc(a)
{
  var code=document.getElementById(a).value;
   
  var desc=document.getElementById("desc");
  if(code=="")
  {
    desc.value="";
  }
  var fdate=document.getElementById("fdate").value;
  var tdate=document.getElementById("tdate").value;
  var wh1=document.getElementById("wh").value;
  var cat1=document.getElementById("cat").value;
  var coa1=document.getElementById("coa").value;
  <?php
   
  $q="select code,description from ims_itemcodes";
  $r=mysql_query($q,$conn1);
  while($rows=mysql_fetch_array($r))
  {
  ?>
   
   if(code=="<?php echo $rows['code'];?>")
   {
     desc.value="<?php echo $rows['description'];?>";
   }
  <?php } ?>
 document.location="inter_issue.php?code="+code+"&desc="+document.getElementById("desc").value+"&fdate="+fdate+"&tdate="+tdate+"&wh="+wh1+"&cat="+cat1+"&coa="+coa1;
}


<?php /*?>function load_code(a)
{
  var desc=document.getElementById(a).value;
   
  var code=document.getElementById("code");
  if(desc=="")
  {
    code.value="";
  }
  var fdate=document.getElementById("fdate").value;
  var tdate=document.getElementById("tdate").value;
  var wh1=document.getElementById("wh").value;
  var cat1=document.getElementById("cat").value;
  var coa1=document.getElementById("coa").value;
  <?php
   
  $q="select code,description from ims_itemcodes";
  $r=mysql_query($q,$conn);
  while($rows=mysql_fetch_array($r))
  {
  ?>
   
   if(desc=="<?php echo $rows['description'];?>")
   {
     code.value="<?php echo $rows['code'];?>";
   }
  <?php } ?>
 document.location="inter_receipt.php?code="+code+"&desc="+document.getElementById("desc").value+"&fdate="+fdate+"&tdate="+tdate+"&wh="+wh1+"&cat="+cat1+"&coa="+coa1;
}
<?php */?>

var d=" ";
var c=" ";
function load_code(a)
{
  var desc=document.getElementById(a).value;
  var  code=document.getElementById("code");
  if(desc=="")
  {
    code.value="";
  }
  var fdate=document.getElementById("fdate").value;
  var tdate=document.getElementById("tdate").value;
  var wh1=document.getElementById("wh").value;
  var cat1=document.getElementById("cat").value;
  var code1=document.getElementById("code").value;
  var coa1=document.getElementById("coa").value
  <?php
  
  $q="select code,description from ims_itemcodes";
  $r=mysql_query($q,$conn1);
  while($rows=mysql_fetch_array($r))
  {
  ?>
   if(desc=="<?php echo $rows['description'];?>")
   {
     code.value="<?php echo $rows['code'];?>";
   }
  <?php } ?>
  document.location="inter_issue.php?desc="+desc+"&code="+document.getElementById("code").value+"&fdate="+fdate+"&tdate="+tdate+"&wh="+wh1+"&cat="+cat1+"&coa="+coa1;
}

</script>