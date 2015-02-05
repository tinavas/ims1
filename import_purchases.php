<?php
include "config.php";
include "getemployee.php";

for($i = 0; $i < count($_POST['date']); $i++)
{
 if($_POST['code'][$i] <> "")
 {
  $date = date("Y-m-d",strtotime($_POST['date'][$i]));
  $vendor = $_POST['vendor'][$i];
  $bi = $_POST['bookinvoice'][$i];

  if($date == $prevdate && $vendor == $prevvendor && $bi == $prevbi)
	$nextrow = 1;	//It means it has multiple rows for single purchase
  else
  {
		$discount = $_POST['discount'][$i];
		$totqty = $_POST['totqty'][$i];
		$freightie = $_POST['freightie'][$i];
		$famount = $_POST['famount'][$i];
		$fcode = $_POST['faccount'][$i];
		$grandtotal = $_POST['grandttotal'][$i];
		$noofrows = $_POST['noofrows'][$i];
		$narration = $_POST['narration'][$i];
		$temptotal = 0;
		$count = 0;
		$viaf = "";
		if($fcode <> "")
		{
		 $query = "SELECT controltype FROM ac_coa WHERE code = '$fcode'";
		 $result = mysql_query($query,$conn) or die(mysql_error());
		 $rows = mysql_fetch_assoc($result);
		 $viaf = $rows['controltype'];
		}
        $nextrow = $gtotal = $totalamount = 0;
		$m = date("m",strtotime($date));
		$y = date("y",strtotime($date));
		$query1 = "SELECT MAX(sobiincr) as sobiincr FROM pp_sobi where m = '$m' AND y = '$y' ORDER BY date DESC";
		$result1 = mysql_query($query1,$conn); $cobiincr = 0; 
		while($row1 = mysql_fetch_assoc($result1)) 
		 $sobiincr = $row1['sobiincr']; 
		$sobiincr = $sobiincr + 1;
		if ($sobiincr < 10) 
		$sobi = 'SOBI-'.$m.$y.'-000'.$sobiincr; 
		else if($sobiincr < 100 && $sobiincr >= 10) 
		$sobi = 'SOBI-'.$m.$y.'-00'.$sobiincr; 
		else $sobi = 'SOBI-'.$m.$y.'-0'.$sobiincr;
  }
  $code = $_POST['code'][$i];
  $qty = $_POST['qty'][$i];
  $rate = $_POST['rate'][$i];
  $vat = $_POST['vat'][$i];
  $warehouse = $_POST['warehouse'][$i];
  
  $count++;
  
  $query1 = "SELECT va FROM contactdetails WHERE name=\"$vendor\" AND type LIKE '%vendor%'";
  $result1 = mysql_query($query1,$conn) or die(mysql_error());
  $rows1 = mysql_fetch_assoc($result1);
  $va = $rows1['va'];
  
	$query = "select description,sunits,iac from ims_itemcodes where code = '$code'";
	$result = mysql_query($query,$conn) or die(mysql_error());
	$itemrows = mysql_num_rows($result);
	$rows = mysql_fetch_assoc($result);
	$description = $rows['description'];
	$units = $rows['sunits'];					
	$iac = $rows['iac'];

if($freightie == "Excluded")
 $famount1 = -$famount;
$amount = ($qty * $rate) + $vat - ($discount * $qty / $totqty) + ($famount1 * $qty / $totqty);
$totalamount += $amount;

 if($freightie == "Included")
  $ivalue = round((($qty * $price) + $vat - ($discount * $qty / $totqty) - ($famount * $qty / $totqty)),2);
 else
  $ivalue = round((($qty * $price) + $vat - ($discount * $qty / $totqty)),2);
 
 if($count == $noofrows)
  $ivalue = $grandtotal - $temptotal;
 $temptotal += $ivalue;
 
 $q = "insert into pp_sobi (remarks,date,sobiincr,m,y,so,invoice,vendor,broker,code,description,receivedquantity,rateperunit,itemunits,bags,bagtype,bagunits,taxvalue,taxamount,freightamount,totalamount,pocost,grandtotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coa,cno,flock,sentquantity,warehouse,adate,aempid,aempname,asector,totalquantity) values('$narration','$date','$sobiincr','$m','$y','$sobi','$bi',\"$vendor\",'','$code','$description','$qty','$rate','$units','0','','','0','$vat','$famount','$ivalue','$grandtotal','$grandtotal','$grandtotal','$empid','$empname','$sector','1','','','$freightie','$viaf','$date','$fcode','0','$discount','','','','$qty','$warehouse','$date','$empid','$empname','$sector','$totqty')";
 $qrs = mysql_query($q,$conn) or die(mysql_error());
  
if($nextrow == 0)
{
//Vendor A/c
$query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 	          VALUES('".$date."','','Cr','".$va."','$totqty','".$grandtotal."','".$sobi."','SOBI',\"$vendor\",'".$warehouse."','".$client."')";
$result4 = mysql_query($query4,$conn) or die(mysql_error());
	
if($famount > 0)
{
 if($viaf == "Cash")
 { $cash = "YES"; $bank = "NO"; $cashcode = $fcode; $bankcode = ""; }
 elseif($viaf == "Bank")
 { $cash = "NO"; $bank = "YES"; $cashcode = ""; $bankcode = $fcode; }

 $q = "SELECT code,schedule FROM ac_coa WHERE description LIKE '%Freight%' or description LIKE '%Frieght%' ORDER BY code LIMIT 1";
 $r = mysql_query($q,$conn) or die(mysql_error());
 $rr = mysql_fetch_assoc($r);
 $freightcoa = $rr['code'];
 $schedule = $rr['schedule'];
 //Cash A/c
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,cash,bank,cashcode,bankcode,schedule) VALUES('".$date."','','Dr','".$freightcoa."','$totqty','".$famount."','".$sobi."','SOBI',\"$vendor\",'".$warehouse."','$cash','$bank','$cashcode','$bankcode','$schedule')";
 $result4 = mysql_query($query4,$conn) or die(mysql_error());
 //Freight A/c
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) VALUES('".$date."','','Cr','".$fcode."','$totqty','$famount','".$sobi."','SOBI',\"$vendor\",'".$warehouse."')";
 $result4 = mysql_query($query4,$conn) or die(mysql_error());
 }	//End of famount- if
}
	//Item A/c
  $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) VALUES('".$date."','".$code."','Dr','".$iac."','$qty','".$ivalue."','".$sobi."','SOBI',\"$vendor\",'".$warehouse."')";
  $result4 = mysql_query($query4,$conn) or die(mysql_error());			
	
  $prevdate = $date;
  $prevvendor = $vendor;
  $prevbi = $bi;
 }
}

header("Location:dashboardsub.php?page=tally_purchase");
?>