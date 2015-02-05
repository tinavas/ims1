<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>User Entries Log Report</title>
</head>

<script>
function pop_up(url){
window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=800,height=400,directories=no,location=no') 
}
</script>

<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "config.php";
include "viewpage.php";
if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d");
if($_GET['todate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate = date("Y-m-d"); 
 
 if($_GET['emp'] <> "")
 $emp = $_GET['emp'];
else
 $emp = "";
 
  if($_GET['tr'] <> "")
  {
 $t = explode("@",$_GET['tr']);
 $tr=$t[0];
 $tr1=$t[1];
 $cond="and parentid='$tr1'";
 }
else
{
 $tr = "";
 $tr1="";
 $cond="";
 }
   if($_GET['tr1'] <> "")
  {
 //$t1 = explode("@",$_GET['tr1']);
 //$tr11=$t1[0];
 $tr110=$_GET['tr1'];
 }
else
{
// $tr11= "";
 $tr110="";
 }
 
  if($_GET['module'] <> "")
  {
 $module = $_GET['module'];
 $cond='';
 }
else
{
 $module = "";
 }
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
<table align="center" border="0">
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">User Entries Log Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">From Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?></td>
</tr> 
</table>
<center><p style="padding-left:430px;color:red"> All amounts in <?php echo $_SESSION['currency'];?></p></center>

<?php
session_start();
$client = $_SESSION['client'];
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
&nbsp;&nbsp;<a href="templet.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="templet.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="templet.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="templet.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Reset All Filters</a>
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
<table>
 <tr>
 <td> Employee</td>
 <td><select name="emp" id="emp" onchange="reloadpage()">
 <option value="">-Select-</option>
 <?php
 $q1=mysql_query("select distinct(username) as uname from common_useraccess where username!='tulasisingh'",$conn1) or die(mysql_error());
 while($r1=mysql_fetch_array($q1))
 {
 ?>
 <option value="<?php  echo $r1[uname];?>" <?php if($emp==$r1[uname]){?> selected="selected"<?php }?>><?php  echo $r1[uname];?></option>
 <?php }?>
 </select></td>
 <td>From</td>
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>"  onchange="reloadpage();"/></td>
 <td>To</td>
 <td><input type="text" name="todate" id="todate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($todate)); ?>"  onchange="reloadpage();"/></td>
  <td> Module</td>
 <td><select name="module" id="module" onchange="reloadpage()">
 <option value="">-Select-</option>
 <?php
  $q=mysql_query("select view from common_useraccess where username='$emp'",$conn1) or die(mysql_error());
 while($r=mysql_fetch_array($q))
 {
 $view=explode(",",$r[view]);
 }
 $q1=mysql_query("select distinct(name) as name,refid from common_links where step=2 and active=1 and refid in (select parentid from common_links where active='1' and name like 'Transactions')",$conn1) or die(mysql_error());
 while($r1=mysql_fetch_array($q1))
 {
  if(in_array($r1[refid],$view))
 {
 ?>
 <option value="<?php  echo $r1[name];?>" <?php if($module==$r1[name]){?> selected="selected"<?php }?>><?php  echo $r1[name];?></option>
 <?php }}?>
 </select></td>
 <td>Section</td>
 <td><select name="tr" id="tr" onchange="reloadpage()">
 <option value="">-Select-</option>
 <?php
/*if($module=="Production" || $module=="Distribution")
$cond="";
else*/
$cond="and name not like '%Masters%'";
 $q1=mysql_query("select distinct(name) as name,refid from common_links where active=1 and name not like '%Reports%' and name not like '%Graphs%' and  name not like '%Manual%' and name not like '$module' and  parentid in (select refid from common_links where name='$module' and active='1')",$conn1) or die(mysql_error());
 while($r1=mysql_fetch_array($q1))
 {
  if(in_array($r1[refid],$view))
 {
 ?>
 <option value="<?php  echo $r1[name]."@".$r1[refid];?>" <?php if($tr==$r1[name] && $tr1==$r1[refid]){?> selected="selected"<?php }?>><?php  echo $r1[name];?></option>
 <?php }}?>
 </select></td>
 <td>Transactions</td>
 <td><select name="tr1" id="tr1" onchange="reloadpage()">
 <option value="">-Select-</option>
 <?php

 $q1="select distinct(name) as name,refid from common_links where active=1 and parentid='$tr1'";
 $q1=mysql_query($q1,$conn1) or die(mysql_error());
 while($r1=mysql_fetch_array($q1))
 {
 if(in_array($r1[refid],$view))
 {

 ?>
 <option value="<?php  echo $r1[refid];?>" <?php if($tr110==$r1[refid]){ $tr11=$r1[name];?> selected="selected"<?php }?>><?php  echo $r1[name];?></option>
 <?php }}?>
 </select></td>
</tr>
</table>	  
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Type
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Type</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Transaction
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Transaction</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Warehouse
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Warehouse</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>

<?php 

if( $tr11!="")
{
//echo $tr11;
if($tr11=='Price Master' && $module=='Order To Cash')
{
$type='Price Masters';
$q2="select date(updated) as date,'Price Masters' as type, itemcode as trnum,customer as warehouse from oc_pricemaster where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Price Master' && $module=='Procure To Pay')
{
$type='Price Masters';
$q2="select date(updated) as date,'Price Masters' as type, itemcode as trnum,customer as warehouse from pp_pricemaster where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Discount Master')
{
$type='Discount Masters';
$q2="select date(updated) as date,'Discount Masters' as type, itemcode as trnum,customer as warehouse from oc_discounts where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Create Supplier')
{
$type='Create Supplier';
$q2="select date(updated) as date,'Create Supplier' as type, name as trnum,address as warehouse from contactdetails where date(updated) between '$fromdate' and '$todate' and empname='$emp' and type='party'"; 
}
else if($tr11=='Create Customer')
{
$type='Create Customer';
$q2="select date(updated) as date,'Create Customer' as type, name as trnum,address as warehouse from contactdetails where date(updated) between '$fromdate' and '$todate' and empname='$emp' and type='vendor'"; 
}
else if($tr11=='Tax Masters')
{
$type='Tax Masters';
$q2="select date(updated) as date,'Tax Masters' as type, description as trnum,rule as warehouse from ims_taxcodes where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Credit Term')
{
$type='Credit Term';
$q2="select date(updated) as date,'Credit Term' as type, description as trnum,rule as warehouse from ims_taxcodes where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Vendor Group' || $tr11=='Customer Group')
{
$type=$tr11;
$q2="select date(updated) as date,$tr11 as type, vca as trnum,vppac as warehouse from ac_vgrmap where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Chart Of Accounts')
{
$type='Chart Of Accounts';
$q2="select date(updated) as date,'Chart Of Accounts' as type, description as trnum,type as warehouse from ac_coa where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Define Schedule')
{
$type='Schedule';
$q2="select date(updated) as date,'Shedule' as type, schedule as trnum,pschedule as warehouse from ac_schedule where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Bank/Cash Masters')
{
$type='Bank/Cash Masters';
$q2="select date(updated) as date,'Bank/Cash Masters' as type, mode as trnum,name as warehouse from ac_bankmasters where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Define Financial Year')
{
$type=' Financial Year';
$q2="select date(updated) as date,' Financial Year' as type, concat(fdatedump,'-',tdatedump) as trnum,'-' as warehouse from ac_definefy where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Item Masters')
{
$type='Item Masters';
$q2="select date(updated) as date,'Item Masters' as type,cat as trnum,description as warehouse from ims_itemcodes where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Sectors')
{
$type='Sectors';
$q2="select date(updated) as date,'Sectors' as type,type1 as trnum,sector as warehouse from tbl_sector where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Item Category')
{
$type='Item Category';
$q2="select date(updated) as date,'Item Category' as type,type as trnum,'-' as warehouse from ims_itemtypes where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Units Conversion')
{
$type='Units Conversion';
$q2="select date(updated) as date,'Units Conversion' as type,fromunits as trnum,tounits as warehouse from ims_convunits where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Create Employee')
{
$type='Employees';
$q2="select date(updated) as date,'Employees' as type,name as trnum,sector as warehouse from hr_employee where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Holidays')
{
$type='Holidays';
$q2="select date(updated) as date,'Holidays' as type,dumpdate as trnum,reason as warehouse from hr_holidays where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Income Tax')
{
$type='Income Tax';
$q2="select date(updated) as date,'Income Tax' as type,concat(fromsal,'-',tosal) as trnum,deductionper as warehouse from hr_incometax where date(updated) between '$fromdate' and '$todate' and addemp='$emp'"; 
}
else if($tr11=='Define Parameters')
{
$type='Parameters';
$q2="select date(updated) as date,'Parameters' as type,concat(code,'-',description) as trnum,type as warehouse from hr_parms where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Working Days')
{
$type='Working Days';
$q2="select date(updated) as date,'Working Days' as type,concat(month,'-',year) as trnum,noofdays as warehouse from hr_working_days where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Leaves Allowed')
{
$type='Leaves Allowed';
$q2="select date(updated) as date,'Leaves Allowed' as type,concat(month,'-',year) as trnum,noofdays as warehouse from hr_leaves where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Define Salary Procedure')
{
$type='Salary Procedure';
$q2="select date(updated) as date,'Salary Procedure' as type,procedure as trnum,'-' as warehouse from hr_salary_procedure where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Create Designation')
{
$type='Designation';
$q2="select date(updated) as date,'Designation' as type,name as trnum,'-' as warehouse from hr_designation where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Vehicle type')
{
$type='Vehicle type';
$q2="select date(updated) as date,'Vehicle type' as type,vtype as trnum,'-' as warehouse from vehicle_type where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Vehicle Masters')
{
$type='Vehicle Masters';
$q2="select date(updated) as date,'Vehicle Masters' as type,concat(vtype,'-',purchasecost) as trnum,unit as warehouse from vehicle_master where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Vehicle Spare Parts')
{
$type='Vehicle Spare Parts';
$q2="select date(updated) as date,'Vehicle Spare Parts' as type,vehicletype as trnum,spareparts as warehouse from vehicle_spareparts where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Vehicle Service Masters')
{
$type='Vehicle Service Masters';
$q2="select date(updated) as date,'Vehicle Service Masters' as type,servicedescription as trnum,narration as warehouse from vehicle_servicemaster where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Vehicle Charge Masters')
{
$type='Vehicle Charge Masters';
$q2="select date(updated) as date,'Vehicle Charge Masters' as type,chargedescription as trnum,narration as warehouse from vehicle_chargemaster where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Charges Renewal')
{
$type='Charges Renewal';
$q2="select date(updated) as date,'Charges Renewal' as type,transactioncode as trnum,vehiclenumber as warehouse from vehicle_renewal where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Vehicle Fuel Filling')
{
$type='Fuel Filling';
 $q2="select date(updated) as date,'Fuel Filling' as type,billnumber as trnum,warehouse from vehicle_fuelfilling where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Vehicle Trip Sheet')
{
$type='Vehicle Trip Sheet';
$q2="select date(updated) as date,'Vehicle Trip Sheet' as type,vehiclenumber as trnum,concat(startplace,'-',endplace) as warehouse from vehicle_tripdetails where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Vehicle Servicing')
{
$type='Vehicle Servicing';
 $q2="select date(updated) as date,'Vehicle Servicing' as type,transactioncode as trnum,narration as warehouse from vehicle_servicing where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Packing Cost')
{
$type='Packing Cost';
$q2="select date(updated) as date,'Packing Cost' as type,concat(description,'-',code) as trnum,location as warehouse from packing_packingcost where date(updated) between '$fromdate' and '$todate' and (addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp'))"; 
}
else if($tr11=='Production Formula')
{
$type='Production Formula';
$q2="select date(updated) as date,'Production Formula' as type,name as trnum,warehouse from product_formula where date(updated) between '$fromdate' and '$todate' and (empname='$emp' or empname=(select employeename from common_useraccess where username='$emp'))"; 
}
else if($tr11=='Shop')
{
$type='Shop';
$q2="select date(updated) as date,'Shop' as type,concat(name,'-',place) as trnum,concat(distributor,'-',superstockist) as warehouse from distribution_shop where date(updated) between '$fromdate' and '$todate' and (addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp'))"; 
}
else if($tr11=='Area')
{
$type='Area';
$q2="select date(updated) as date,'Area' as type,areaname as trnum,superstockist as warehouse from distribution_area where date(updated) between '$fromdate' and '$todate' and (addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp'))"; 
}
else if($tr11=='Distributor')
{
$type='Distributor';
$q2="select date(updated) as date,'Distributor' as type,name as trnum,superstockist as warehouse from distribution_distributor where date(updated) between '$fromdate' and '$todate' and (addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp'))"; 
}
else if($tr11=='Sales Man')
{
$type='Sales Man';
$q2="select date(updated) as date,'Sales Man' as type,salesman as trnum,superstockist as warehouse from distribution_salesman where date(updated) between '$fromdate' and '$todate' and (addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp'))"; 
}
else if($tr11=='Distribution Minimum Stock Level')
{
$type='Distribution Minimum Stock Level';
$q2="select date(updated) as date,'Distribution Minimum Stock Level' as type,areaname as trnum,stock as warehouse from distribution_stocklevel where date(updated) between '$fromdate' and '$todate' and (addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp'))"; 
}
else if($tr11=='Stock Transfer')
{
$type='STR';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select id from ims_stocktransfer where empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Stock Receive')
{
$type='SRC';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select tid from ims_stockreceive where empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Stock Adjustment' && $module=='Inventory')
{
$type='STA';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select trnum from ims_stockadjustment where empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Intermediate Receipt')
{
$type='IR';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select trnum from ims_intermediatereceipt where riflag='R' and empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Intermediate Issue')
{
$type='II';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select trnum from ims_intermediatereceipt where riflag='I' and empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Payment Voucher')
{
$type='PV';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select transactioncode from ac_gl where voucher='P' and empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Receipt Voucher')
{
$type='RV';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select transactioncode from ac_gl where voucher='R' and empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Journal Voucher(Regular)')
{
$type='JV';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select transactioncode from ac_gl where voucher='J' and empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Direct Purchase')
{
$type='SOBI';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select so from pp_sobi where empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Purchase Return')
{
$type='PRTN';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select trid from pp_purchasereturn where empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Payment' && $module=='Procure To Pay')
{
$type='PMT';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select tid from pp_payment where empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Receipt' && $module=='Procure To Pay')
{
$type='PPRCT';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select tid from pp_receipt where empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Credit Note' && $module=='Procure To Pay')
{
$type='VCN';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select tid from ac_crdrnote where mode='VCN' and empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Debit Note' && $module=='Procure To Pay')
{
$type='VDN';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select tid from ac_crdrnote where mode='VDN' and empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Direct Sales')
{
$type='COBI';
 $q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select invoice from oc_cobi where empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Sales Return')
{
$type='SR';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select trid from oc_salesreturn where empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Payment' && $module=='Order To Cash')
{
$type='OCPMT';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select tid from oc_payment where empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Receipt' && $module=='Order To Cash')
{
$type='RCT';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select tid from oc_receipt where empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Credit Note' && $module=='Order To Cash')
{
$type='CCN';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select tid from ac_crdrnote where mode='CCN' and empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Debit Note' && $module=='Order To Cash')
{
$type='CDN';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select tid from ac_crdrnote where mode='CDN' and empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Monthly Attendance')
{
$type='Monthly Attendance';
$q2="select date(updated) as date,'Monthly Attendance' as type,concat(employeename,'-',designation) as trnum,sector as warehouse from hr_mnth_attendance where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Salary Parameters')
{
$type='Salary Parameters';
$q2="select date(updated) as date,'Salary Parameters' as type,concat(employeename,'-',designation) as trnum,sector as warehouse from hr_mnth_attendance where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
}
else if($tr11=='Employee Debit Note')
{
$type='EDN';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select tid from hr_empcrdrnote where mode='EDN' and empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Employee Credit Note')
{
$type='ECN';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select tid from hr_empcrdrnote where mode='ECN' and empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Employee Pament Voucher')
{
$type='EPV';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select tid from ac_gl where voucher='EPV' and empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Salary Payment')
{
$type='EPV';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select tid from ac_gl where voucher='EPV' and empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Salary Generation')
{
$type='EPV';
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select tid from ac_gl where voucher='EPV' and empname='$emp') and type='$type' group by trnum order by date";
}
else if($tr11=='Production Unit')
{
 $q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select formula from product_productionunit where empname='$emp') and type in ('product Produced') group by trnum,type order by date,trnum";
}
else if($tr11=='Daily Packing')
{
 $q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select trnum from packing_dailypacking where addempname='$emp') and type in ('DPACK') group by trnum,type order by date";
}
else if($tr11=='Sales Receipt')
{
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and trnum in (select trnum from distribution_salesreceipt where addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp')) and type in ('DCOBIR') group by trnum,type order by date";
}
else if($tr11=='Receipt From Distributor')
{
$q2="select * from distribution_financialpostings where date between '$fromdate' and '$todate' and trnum in (select tid from distribution_receipt where addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp')) and type in ('DRCT') group by trnum,type order by date";
}
else if($tr11=='Stock Issue To Distributor')
{
$q2="select * from distribution_financialpostings where date between '$fromdate' and '$todate' and trnum in (select trnum from distribution_stockissuetodistributor where addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp')) and type in ('STDT') group by trnum,type order by date";
}
else if($tr11=='Stock Return From Distributor')
{
$q2="select * from distribution_financialpostings where date between '$fromdate' and '$todate' and trnum in (select trnum from distribution_stockreturnfromdistributor where addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp')) and type in ('RTDT') group by trnum,type order by date";
}
else if($tr11=='Distributor Opening Balence')
{
$q2="select * from distribution_financialpostings where date between '$fromdate' and '$todate' and trnum in (select trnum from distributor_ob where empname='$emp' or empname=(select employeename from common_useraccess where username='$emp')) and type in ('DTOB') group by trnum,type order by date";
}
else if($tr11=='C&F Opening Stock')
{
$q2="select trnum,'CNF Opening Stock' as type,date, superstockist as warehouse from distribution_cnfopeningstock where date between '$fromdate' and '$todate' and (addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp'))  group by trnum order by date";
}
else if($tr11=='Sales Man Visits')
{
$q2="select trnum,'Sales Man Visits' as type,date, superstockist as warehouse from distribution_salesmanvisits where date between '$fromdate' and '$todate' and (addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp'))  group by trnum order by date";
}
else if($tr11=='Stock Adjustment' && $module=='Distribution')
{
$q2="select trnum,'Stock Adjustment' as type,date, superstockist as warehouse from distribution_stockadjustment where date between '$fromdate' and '$todate' and (addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp'))  group by trnum order by date";
}
else if($tr11=='Distributor Stocks')
{
$q2="select trnum,'Distributor Stocks' as type,date, superstockist as warehouse from distribution_distributorstock where date between '$fromdate' and '$todate' and (addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp'))  group by trnum order by date";
}
else
{
$q2="select * from ac_financialpostings where date between '$fromdate' and '$todate' and empname='$emp' and type='$tr11' group by trnum,date";
}
$q2=mysql_query($q2,$conn1) or die(mysql_error());
while($r2=mysql_fetch_array($q2))
{ 
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue(date("d.m.Y",strtotime($r2['date']))) ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue($r2[type]); ?></td>


   <td class="ewRptGrpField1" align="right"><?php if($tr!='Masters'){?><a href="#test" onclick="pop_up('a.php?date=<?php echo $r2['date']; ?>&trnum=<?php echo $r2['trnum']; ?>&wh=<?php echo $r2['warehouse']; ?>&emp=<?php echo $emp; ?>&type=<?php echo $tr11; ?>&module=<?php echo $module; ?>')" class="nyromodel" ><?php } echo ewrpt_ViewValue($r2[trnum]); ?><?php if($tr!='Masters'){?></a><?php }?></td>

		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($r2[warehouse]); ?></td>
	</tr>
<?php
}}
?>
	</tbody>
	<tfoot>

 </tfoot>
</table>
</div>
</td></tr></table>
</div>
<?php if (@$sExport == "") { ?>
	</div><br /></td>
</tr>
</table>
<?php include "phprptinc/footer.php"; ?>
<?php } ?>
<script type="text/javascript">
function reloadpage()
{
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	var emp = document.getElementById('emp').value;
	var module = document.getElementById('module').value;
	var tr = document.getElementById('tr').value;
	var tr1 = document.getElementById('tr1').value;
	document.location = "userentrieslog.php?fromdate=" + fdate + "&todate=" + tdate+ "&emp=" + emp+ "&module=" + module+ "&tr=" + tr+ "&tr1=" + tr1;
}
</script>