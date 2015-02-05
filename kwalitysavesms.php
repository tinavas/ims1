<?php
 $te = $_GET['content'];
 $temp = substr($te,4);
 $te1 = explode(" ",$temp); 
 $l = strlen($te1[0]) + 1;
 $temp1 = substr($temp,$l);
 //$typeofsms = substr($temp1,0,4);
 
 $db_host = "localhost";
 $db_user = "poultry";
 $db_pass = "tulA0#s!";
 if($te1[0] == "KWF")
 {
   $db_name = "kwality";
 }
 if($te1[0] == "ALPINE")
 {
   $db_name = "alpine";
 }
  $conn=mysql_connect($db_host,$db_user,$db_pass)or die(mysql_error());
 mysql_select_db($db_name);

 //$temp = $_GET['content'];
 //$temp1 = substr($temp,4);
 $temp1 = explode(",",$temp1);
 for($k = 0;$k < count($temp1);$k++)
 {
   $temp2 = explode(":",$temp1[$k]);
   $item[$temp2[0]] = $temp2[1];
 }
$phoneno = $_GET['msisdn'];


 $query2="INSERT INTO broiler_sms_entry (flock,number) VALUES ('".$item[flock]."','".$phoneno."')" or die(mysql_error());
 $get_entriess_res2 = mysql_query($query2,$conn) or die(mysql_error());


$qc = "select count(*) as count from ims_stocktransfer where cat='Broiler Chicks' and aflock='$item[flock]' ";
$qcs = mysql_query($qc,$conn) or die(mysql_error());
$qcr = mysql_fetch_assoc($qcs);
{
$countc = $qcr['count']; 
}
$q3aa = "select * from broiler_daily_entry where flock ='$item[flock]' and cullflag = '0' order by entrydate DESC";
$qrsaa = mysql_query($q3aa,$conn) or die(mysql_error());
$counts = mysql_num_rows($qrsaa);
  
if(($counts > 0) || ($countc > 0))
{
if(($countc >0) &&($counts == 0))
{
$q3c = mysql_query("select * from ims_stocktransfer where cat='Broiler Chicks' and aflock='$item[flock]' order by date desc limit 1 ") or die(mysql_error());
if($q3rc = mysql_fetch_assoc($q3c))
 {
	$culled = 0;
	$entrydatec = $q3rc['date'];
	$age = 0;
	$currflock = $q3rc['aflock'];
	$towarehouse = $q3rc['towarehouse'];
    $q3f = mysql_query("select * from broiler_farm where farm='$towarehouse'") or die(mysql_error());
    if($q3rf = mysql_fetch_assoc($q3f))
    {
    $farm = $q3rf['farm']; 
    $supervisor = $q3rf['supervisor'];
    $place = $q3rf['place'];
 	}
 }
}
else
{

 $q3 = mysql_query("select * from broiler_daily_entry where flock ='$item[flock]' order by entrydate DESC") or die(mysql_error());
 if($q3r = mysql_fetch_assoc($q3))
 {
	$culled = $q3r['cullflag'];
	$entrydate = $q3r['entrydate'];
	$age = $q3r['age'];
	$currflock = $q3r['flock'];
    $farm = $q3r['farm']; 
    $supervisor = $q3r['supervisior'];
    $place = $q3r['place'];
 }
 }
 if($culled == 0)
 {
    $item['flock'] = $currflock; 
	//$item['age'] = $age + 1; 
	if($entrydatec != "")
	{
	$item['date'] = date("d.m.Y",strtotime($entrydatec));
	}
	else
	{
	$item['date'] = date("d.m.Y",strtotime($entrydate) + 86400); 
	}
 }
 $date = $item['date'];
 $date = date("Y-m-j", strtotime($date));
  
 if(!$item['m']) { $item['m'] = 0; } 
 if(!$item['feed']) { $item['feed'] = 0; } 
 if(!$item['qty']) { $item['qty'] = 0; } 
 if(!$item['age']) { $item['age'] = $age + 1; }  
 if(!$item['bwt']) { $item['bwt'] = 0; } 
 if(!$item['water']) { $item['water'] = 0; } 
 if(!$item['med']) { $item['med'] = 0; } 
 if(!$item['mqty']) { $item['mqty'] = 0; } 
 if(!$item['vac']) { $item['vac'] = 0; } 
 if(!$item['vqty']) { $item['vqty'] = 0; } 
 if(!$item['c']) { $item['c'] = 0; } 

 $flock = $item['flock'];
 $age = $item['age'];
 $mort = $item['m'];
 $feedtype = $item['feed'];
 $consumed = $item['qty'] * 50;
 $weight = $item['bwt'];
 $water = $item['water'];
 $medicine = $item['med'];
 $mquantity = $item['mqty'];
 $vaccine = $item['vac'];
 $vquantity = $item['vqty'];
 $remarks = 0;
 $cull = $item['c'];
 $birds = "0";

$entry = "SMS";
$phoneno = $_GET['msisdn'];



 $q356 = mysql_query("select * from broiler_daily_entry where flock ='$item[flock]' order by entrydate DESC") or die(mysql_error());
 if($q3r56 = mysql_fetch_assoc($q356))
 {
	$v1 = $q3r56['mortality'];
	$v2 = $q3r56['flock'];
	$v3 = $q3r56['cull'];
	$v4 = $q3r56['feedtype'];
      $v5 = $q3r56['feedconsumed']; 
      $v6 = $q3r56['average_weight'];
      $v7 = $q3r56['water'];
      $v8 = $q3r56['medicine_name'];
      $v9 = $q3r56['medicine_quantity'];
      $v10 = $q3r56['vaccine_name'];
      $v11 = $q3r56['vaccine_quantity'];
	  $v12 = $q3r56['age'];
 }

if($flock == $v2 && $mort == $v1 && $cull == $v3 && $feedtype == $v4 && $consumed == $v5 && $weight == $v6 && $water == $v7 && $medicine == $v8 && $mquantity == $v9 && $vaccine == $v10 && $vquantity == $v11 && $age == $v12 )
{
   $problem = "Duplicate Entry";
   $query2="INSERT INTO broiler_wrong_entry (SrNo,place,farm,flock,age,supervisior,mortality,cull,feedtype,feedconsumed,average_weight,water,medicine_name,medicine_quantity,vaccine_name,vaccine_quantity,entrydate,birds,phoneno,entrytype,problem)
   VALUES (NULL,'".$place."','".$farm."','".$flock."','".$age."','".$supervisor."','".$mort."','".$cull."','".$feedtype."','".$consumed."', 
   '".$weight."','".$water."','".$medicine."','".$mquantity."','".$vaccine."','".$vquantity."','".$date."','".$birds."','".$phoneno."','".$entry."','".$problem."')" or die(mysql_error());
   $get_entriess_res2 = mysql_query($query2,$conn) or die(mysql_error());

   echo "Duplicate Entry";
}
else
{
   $query2="INSERT INTO broiler_daily_entry (SrNo,place,farm,flock,age,supervisior,mortality,cull,feedtype,feedconsumed,average_weight,water,medicine_name,medicine_quantity,vaccine_name,vaccine_quantity,entrydate,birds,phoneno,entrytype)
   VALUES (NULL,'".$place."','".$farm."','".$flock."','".$age."','".$supervisor."','".$mort."','".$cull."','".$feedtype."','".$consumed."', 
   '".$weight."','".$water."','".$medicine."','".$mquantity."','".$vaccine."','".$vquantity."','".$date."','".$birds."','".$phoneno."','".$entry."')" or die(mysql_error());
   $get_entriess_res2 = mysql_query($query2,$conn) or die(mysql_error());
   $type = "BDE";
   if($consumed > 0)
   {
     $q = "select * from ims_itemcodes where code = '$feedtype'";
     $qrs = mysql_query($q,$conn) or die(mysql_error());
     if($qr = mysql_fetch_assoc($qrs))
     {
	  $iac = $qr['iac'];
        $wpac = $qr['wpac'];
     }
      $crdr = "Cr";
	
     $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse) values('$date','$feedtype','$crdr','$iac','$consumed','$consumed','$type','$flock','$flock','$farm')";
     $qrs1 = mysql_query($q1,$conn);

     $crdr = "Dr";
     $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse) values('$date','$feedtype','$crdr','$wpac','$consumed','$consumed','$type','$flock','$flock','$farm')";
     $qrs1 = mysql_query($q1,$conn);
   }

   if($mquantity > 0)
   {
     $q = "select * from ims_itemcodes where code = '$medicine'";
     $qrs = mysql_query($q,$conn) or die(mysql_error());
     if($qr = mysql_fetch_assoc($qrs))
     {
    	 $iac = $qr['iac'];
	 $wpac = $qr['wpac'];
     }
      $crdr = "Cr";
 	$type = "BDE";
      $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse) values('$date','$medicine','$crdr','$iac','$mquantity','$mquantity','$type','$flock','$flock','$farm')";
      $qrs1 = mysql_query($q1,$conn);

      $crdr = "Dr";
      $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse) values('$date','$medicine','$crdr','$wpac','$mquantity','$mquantity','$type','$flock','$flock','$farm')";
      $qrs1 = mysql_query($q1,$conn);
   }

   if($vquantity > 0)
   {
      $q = "select * from ims_itemcodes where code = '$vaccine'";
      $qrs = mysql_query($q,$conn) or die(mysql_error());
      if($qr = mysql_fetch_assoc($qrs))
      {
	  $iac = $qr['iac'];
	  $wpac = $qr['wpac'];
      }
      $crdr = "Cr";
	$type = "BDE";
      $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse) values('$date','$vaccine','$crdr','$iac','$vquantity','$vquantity','$type','$flock','$flock','$farm')";
      $qrs1 = mysql_query($q1,$conn);

      $crdr = "Dr";
      $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse) values('$date','$vaccine','$crdr','$wpac','$vquantity','$vquantity','$type','$flock','$flock','$farm')";
      $qrs1 = mysql_query($q1,$conn);
   }
    echo "Data Saved Successfully";
 }
}
else
{

$farm = 0; 
$supervisor = 0;
$place = 0;

 $date = $item['date'];
 $date = date("Y-m-j", strtotime($date));

 if(!$item['m']) { $item['m'] = 0; } 
 if(!$item['feed']) { $item['feed'] = 0; } 
 if(!$item['qty']) { $item['qty'] = 0; } 
 if(!$item['bwt']) { $item['bwt'] = 0; } 
 if(!$item['water']) { $item['water'] = 0; } 
 if(!$item['med']) { $item['med'] = 0; } 
 if(!$item['mqty']) { $item['mqty'] = 0; } 
 if(!$item['vac']) { $item['vac'] = 0; } 
 if(!$item['vqty']) { $item['vqty'] = 0; } 
 if(!$item['c']) { $item['c'] = 0; } 

 $flock = $item['flock'];
 $age = 0;
 $mort = $item['m'];
 $feedtype = $item['feed'];
 $consumed = $item['qty'];
 $weight = $item['bwt'];
 $water = $item['water'];
 $medicine = $item['med'];
 $mquantity = $item['mqty'];
 $vaccine = $item['vac'];
 $vquantity = $item['vqty'];
 $remarks = 0;
 $cull = $item['c'];
 $birds = "0";
 $entry = "SMS";
 $phoneno = $_GET['msisdn'];
 $problem = "Invalid Flock Name";

 $q673 = mysql_query("select * from broiler_daily_entry where flock ='$item[flock]' order by entrydate DESC") or die(mysql_error());
 if($q673r = mysql_fetch_assoc($q673))
 {
	$vculled = $q673r['cullflag'];
 }
 if($vculled) { $problem = "Flock Culled"; }
   $query2="INSERT INTO broiler_wrong_entry (SrNo,place,farm,flock,age,supervisior,mortality,cull,feedtype,feedconsumed,average_weight,water,medicine_name,medicine_quantity,vaccine_name,vaccine_quantity,entrydate,birds,phoneno,entrytype,problem)
   VALUES (NULL,'".$place."','".$farm."','".$flock."','".$age."','".$supervisor."','".$mort."','".$cull."','".$feedtype."','".$consumed."', 
   '".$weight."','".$water."','".$medicine."','".$mquantity."','".$vaccine."','".$vquantity."','".$date."','".$birds."','".$phoneno."','".$entry."','".$problem."')" or die(mysql_error());
   $get_entriess_res2 = mysql_query($query2,$conn) or die(mysql_error());
  echo $problem;
} 
?>