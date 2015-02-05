<html>
<body>
<style type="text/css" media="print">
.printbutton {
  visibility: hidden;
  display: none;
}
</style>
</head>
<?php include "config.php";
?>
<body>
<table align="center">
<tr>
<td><strong>Trnum</strong></td>
<td width="10px"></td>
<td><strong>Itemcode</strong></td>
<td width="10px"></td>
<td><strong>Quantity</strong></td>
<td width="10px"></td>
<td><strong>Amount</strong></td>
<td width="10px"></td>
<td><strong>CrDr</strong></td>
<td width="10px"></td>
<td><strong>Coacode</strong></td>
<td width="10px"></td>
<td><strong>Venname</strong></td>
<td width="10px"></td>
<td><strong>Warehouse</strong></td>
</tr>
<tr height="10px">
<?php 
$date=$_GET['date'];
 $wh=$_GET['warehouse'];
 $trnum=$_GET['trnum'];
$tr11=$_GET['type'];
$emp=$_GET['emp'];
$module=$_GET['module'];
if( $tr11!="")
{

//echo $tr11;

if($tr11=='Monthly Attendance')
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
else if($tr11=='Price Master' && $module=='Order To Cash')
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
$q2="select date(updated) as date,'Item Masters' as type,cat as trnum,code as itemcode,description as warehouse from ims_itemcodes where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
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
$q2="select date(updated) as date,'Vehicle Service Masters' as type,sevicedescription as trnum,narration as warehouse from vehicle_servicemaster where date(updated) between '$fromdate' and '$todate' and empname='$emp'"; 
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
else if($tr11=='Fuel Filling')
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
$q2="select * from ac_financialpostings where date='$date' and trnum in (select id from ims_stocktransfer where empname='$emp') and type='$type' and trnum='$trnum' order by date";
}
else if($tr11=='Stock Receive')
{
$type='SRC';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from ims_stockreceive where empname='$emp') and type='$type' and trnum='$trnum' order by date";
}
else if($tr11=='Stock Adjustment' && $module=='Inventory')
{
$type='STA';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select trnum from ims_stockadjustment where empname='$emp') and type='$type' order by date";
}
else if($tr11=='Intermediate Receipt')
{
$type='IR';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select trnum from ims_intermediatereceipt where riflag='R' and empname='$emp') and trnum='$trnum'  and type='$type' order by date";
}
else if($tr11=='Intermediate Issue')
{
$type='II';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select trnum from ims_intermediatereceipt where riflag='I' and empname='$emp') and type='$type' and trnum='$trnum'   order by date";
}
else if($tr11=='Payment Voucher')
{
$type='PV';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select transactioncode from ac_gl where voucher='P' and empname='$emp') and type='$type' and trnum='$trnum'  order by date";
}
else if($tr11=='Receipt Voucher')
{
$type='RV';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select transactioncode from ac_gl where voucher='R' and empname='$emp') and type='$type' and trnum='$trnum'  order by date";
}
else if($tr11=='Journal Voucher(Regular)')
{
$type='JV';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select transactioncode from ac_gl where voucher='J' and empname='$emp') and type='$type' and trnum='$trnum'  order by date";
}
else if($tr11=='Direct Purchase')
{
$type='SOBI';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select so from pp_sobi where empname='$emp') and type='$type' and trnum='$trnum'   order by date";
}
else if($tr11=='Purchase Return')
{
$type='PRTN';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select trid from pp_purchasereturn where empname='$emp') and trnum='$trnum'  and type='$type' order by date";
}
else if($tr11=='Payment' && $module=='Procure To Pay')
{
$type='PMT';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from pp_payment where empname='$emp') and type='$type' and trnum='$trnum'  order by date";
}
else if($tr11=='Receipt' && $module=='Procure To Pay')
{
$type='PPRCT';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from pp_receipt where empname='$emp') and type='$type' and trnum='$trnum'  order by date";
}
else if($tr11=='Credit Note' && $module=='Procure To Pay')
{
$type='VCN';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from ac_crdrnote where mode='VCN' and empname='$emp') and type='$type' and trnum='$trnum'   order by date";
}
else if($tr11=='Debit Note' && $module=='Procure To Pay')
{
$type='VDN';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from ac_crdrnote where mode='VDN' and empname='$emp') and type='$type' and trnum='$trnum'   order by date";
}
else if($tr11=='Direct Sales')
{
$type='COBI';
 $q2="select * from ac_financialpostings where date='$date' and trnum in (select invoice from oc_cobi where empname='$emp') and type='$type' and trnum='$trnum'  order by date";
}
else if($tr11=='Sales Return')
{
$type='SR';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select trid from oc_salesreturn where empname='$emp') and type='$type' and trnum='$trnum'  order by date";
}
else if($tr11=='Payment' && $module=='Order To Cash')
{
$type='OCPMT';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from oc_payment where empname='$emp') and type='$type'  and trnum='$trnum'  order by date";
}
else if($tr11=='Receipt' && $module=='Order To Cash')
{
$type='RCT';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from oc_receipt where empname='$emp') and type='$type'  and trnum='$trnum'  order by date";
}
else if($tr11=='Credit Note' && $module=='Order To Cash')
{
$type='CCN';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from ac_crdrnote where mode='CCN' and empname='$emp') and type='$type' and trnum='$trnum'   order by date";
}
else if($tr11=='Debit Note' && $module=='Order To Cash')
{
$type='CDN';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from ac_crdrnote where mode='CDN' and empname='$emp') and type='$type' and trnum='$trnum'  order by date";
}
else if($tr11=='Employee Debit Note')
{
$type='EDN';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from hr_empcrdrnote where mode='EDN' and empname='$emp' and tid='$trnum') and type='$type' and trnum='$trnum'  order by date";
}
else if($tr11=='Employee Credit Note')
{
$type='ECN';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from hr_empcrdrnote where mode='ECN' and empname='$emp' and tid='$trnum') and type='$type' and trnum='$trnum'  order by date";
}
else if($tr11=='Employee Pament Voucher')
{
$type='EPV';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from ac_gl where voucher='EPV' and empname='$emp' and tid='$trnum') and type='$type' and trnum='$trnum'  order by date";
}
else if($tr11=='Salary Payment')
{
$type='EPV';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from ac_gl where voucher='EPV' and empname='$emp') and type='$type' and trnum='$trnum'  order by date";
}
else if($tr11=='Salary Generation')
{
$type='EPV';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from ac_gl where voucher='EPV' and empname='$emp') and type='$type' and trnum='$trnum'  order by date";
}
else if($tr11=='Production Unit')
{
 $q2="select * from ac_financialpostings where date='$date' and trnum in (select formula from product_productionunit where empname='$emp') and type in ('product Produced') and trnum='$trnum'  order by date,trnum";
}
else if($tr11=='Daily Packing')
{
 $q2="select * from ac_financialpostings where date='$date' and trnum in (select trnum from packing_dailypacking where addempname='$emp') and type in ('DPACK') and trnum='$trnum'  order by date";
}
else if($tr11=='Sales Receipt')
{
$q2="select * from ac_financialpostings where date='$date' and trnum in (select trnum from distribution_salesreceipt where addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp')) and type in ('DCOBIR') and trnum='$trnum'  order by date";
}
else if($tr11=='Receipt From Distributor')
{
$q2="select * from distribution_financialpostings where date='$date' and trnum in (select tid from distribution_receipt where addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp')) and type in ('DRCT') and trnum='$trnum'  order by date";
}
else if($tr11=='Stock Issue To Distributor')
{
$q2="select * from distribution_financialpostings where date='$date' and trnum in (select trnum from distribution_stockissuetodistributor where addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp')) and type in ('STDT') and trnum='$trnum'   order by date";
}
else if($tr11=='Stock Return From Distributor')
{
$q2="select * from distribution_financialpostings where date='$date' and trnum in (select trnum from distribution_stockreturnfromdistributor where addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp')) and type in ('RTDT') and trnum='$trnum'  order by date";
}
else if($tr11=='Distributor Opening Balence')
{
$q2="select * from distribution_financialpostings where date='$date' and trnum in (select trnum from distributor_ob where empname='$emp' or empname=(select employeename from common_useraccess where username='$emp')) and type in ('DTOB') and trnum='$trnum' order by date";
}
else if($tr11=='C&F Opening Stock')
{
$q2="select trnum,'CNF Opening Stock' as type,date, superstockist as warehouse from distribution_cnfopeningstock where date='$date' and (addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp'))  and trnum='$trnum'  order by date";
}
else if($tr11=='Sales Man Visits')
{
$q2="select trnum,'Sales Man Visits' as type,date, superstockist as warehouse from distribution_salesmanvisits where date='$date' and (addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp')) and trnum='$trnum'   order by date";
}
else if($tr11=='Stock Adjustment' && $module=='Distribution')
{
$q2="select trnum,'Stock Adjustment' as type,date, superstockist as warehouse,date,code as itemcode,type as crdr from distribution_stockadjustment where date='$date' and trnum='$trnum'  and (addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp'))  order by date";
}
else if($tr11=='Distributor Stocks')
{
$q2="select trnum,'Distributor Stocks' as type,date, superstockist as warehouse from distribution_distributorstock where date='$date' and trnum='$trnum'  and (addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp'))  order by date";
}
else
{
$q2="select * from ac_financialpostings where date='$date' and empname='$emp' and type='$tr11' and trnum='$trnum' ";
}
$q2=mysql_query($q2,$conn1) or die(mysql_error());
while($r2=mysql_fetch_array($q2))
{ 
?>
<tr>
<td><?php echo $r2[trnum];?></td>
<td width="10px"></td>
<?php if($r2[itemcode]<>""){?>
<td><?php echo $r2[itemcode];?></td>
<td width="10px"></td>
<td><?php echo $r2[quantity];?></td>
<td width="10px"></td>
<?php } else {?>
<td>&nbsp;</td>
<td width="10px"></td>
<td>&nbsp;</td>
<td width="10px"></td><?php }?>
<td><?php echo $r2[amount];?></td>
<td width="10px"></td>
<td><?php echo $r2[crdr];?></td>
<td width="10px"></td>
<td><?php echo $r2[coacode];?></td>
<td width="10px"></td>
<td><?php echo $r2[venname];?></td>
<td width="10px"></td>
<td><?php echo $r2[warehouse];?></td>


</tr>
<?php

}
}
?>
</table>
</body>
</html>
