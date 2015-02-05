<?php 
include "config.php";
include "getemployee.php";

$date = date("Y-m-d",strtotime($_POST['date']));
$cat = $_POST['cat'];
$fromwarehouse1 = explode('@',$_POST['warehouse']);
$fromwarehouse = $fromwarehouse1[0];

$type = "TR";

if($_POST['saed'] == "edit")
{
 $q = "delete from ac_financialpostings where trnum = '$_POST[oid]' AND type ='$_POST[otype]' AND date='$_POST[odate]' AND client='$client'";
   $qr = mysql_query($q,$conn) ;

  $q = "delete from ims_stocktransfer where id = '$_POST[oid]' AND client='$client'";
  $qr = mysql_query($q,$conn) ;
 
}

$tid = "";
$q = "select max(tid) as tid from ims_stocktransfer where client = '$client'";
$qrs =mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'] + 1;

for($i = 0; $i < count($_POST['code']); $i++)
if($fromwarehouse != "")
{
if($_POST['code'][$i] != "" && $_POST['towarehouse'][$i] != "" && $_POST['squantity'][$i] != "")
{
    $cat = $_POST['cat'][$i];
	$code = $_POST['code'][$i]; 
	$description = $_POST['description'][$i];
	$units = $_POST['units'][$i];
	$towarehouse = $_POST['towarehouse'][$i];
	$quantity = $_POST['squantity'][$i];
    $price = $_POST['price'][$i];	
	$tmno = $_POST['tmno'][$i];
	$tcost = $_POST['tcost'][$i];
	$vno = $_POST['vno'][$i];
	$driver = $_POST['driver'][$i];
	$remarks = $_POST['remarks'][$i];
      $amount = 0; 
$aflock = "";

      $q121 = "SELECT distinct(farm) FROM broiler_farm WHERE farm = '$fromwarehouse' AND client = '$client' order by farm ASC";
      $r121 = mysql_query($q121,$conn);
      $n121 = mysql_num_rows($r121);


if($_SESSION['client'] == 'KWALITY' && $cat == 'Broiler Feed')
{
$query = "SELECT capacity FROM bagcapacity WHERE bagcode = 'CON101' AND fromdate <= '".$date."' AND todate >= '".$date."' AND client = '$client' ORDER BY fromdate DESC";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows1 = mysql_num_rows($result);
if($rows1>0)
{
 $rows = mysql_fetch_array($result);
 $capacity = $rows['capacity'];
 $quantity *= $capacity;
 $price = $price/$capacity; 
}
else
{
 $query2 = "SELECT capacity from bagcapacity WHERE bagcode = 'CON101' AND client = '$client' ORDER BY todate DESC";
 $result2 = mysql_query($query2,$conn) or die(mysql_error());
 $rows2 = mysql_num_rows($result2);
 if($rows2 > 0)
 {
  $rows = mysql_fetch_array($result2);
  $capacity = $rows['capacity'];
  $quantity *= $capacity;
  $price = $price/$capacity;
 }
}
}





if($n121 > 0)
{
//////////////getting the flock and a flock for broiler feed transfer for fromwarehouse////////////     
if(($cat == 'Broiler Feed') OR ($cat == 'Medicines') OR ($cat == 'Vaccines'))
{
 
$notr = 0; $notc = 0; $nobde = 0; $culled =""; $notc1 = 0; $nobde1 = 0; $culled1 =""; $nobde2 = 0; $culled2 ="";
$notc2 = 0; $nobde3 = 0; $culled3 =""; $nobde4 = 0; $culled4 =""; $ToFlock = ""; $newflock = ""; $newflock1 = "";
$bdeflock = ""; $bdeflock1 = ""; $maxflock1 = ""; $maxflock = ""; $faflock=""; $caflock="";
 
 $q1 = mysql_query("select distinct(flock) as ToFlock,aflock,date,towarehouse from ims_stocktransfer where towarehouse ='$fromwarehouse' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC LIMIT 1") or die(mysql_error());
  $notr = mysql_num_rows($q1); 

 while($nt1 = mysql_fetch_assoc($q1))
 {
  $ToFlock = $nt1['ToFlock']; 
  $faflock = $nt1['aflock'];
 }
 $q2 = mysql_query("select distinct(flock) as newflock,aflock,date,towarehouse from ims_stocktransfer where towarehouse = '$fromwarehouse' AND cat = 'Broiler Chicks' AND client = '$client' order by date DESC LIMIT 1") or die(mysql_error());
  $notc = mysql_num_rows($q2); 

 while($nt2 = mysql_fetch_assoc($q2))
 {
   $newflock = $nt2['newflock'];
   $caflock = $nt2['aflock'];
 }
 
 if($newflock >= $ToFlock)
 {
   $maxflock = $newflock;
   $maxflock1 = $caflock;
 }
 else
 {
   $maxflock = $ToFlock;
   $maxflock1 = $faflock;
 }
 
 if($notr != 0 || $notc != 0)
 {    
	$q3 = mysql_query("select distinct(flock),cullflag,entrydate from broiler_daily_entry where farm ='$fromwarehouse' and flock = '$maxflock1' AND client = '$client' order by entrydate DESC") or die(mysql_error());
	$nobde = mysql_num_rows($q3);
	if($q3r = mysql_fetch_assoc($q3))
	{
	 $culled = $q3r['cullflag'];
	 $entrydate = $q3r['entrydate'];
	}
	if($nobde != 0)
	{
		if($culled == 1)
		{
              $aflock = $towarehouse.'-@-'.($maxflock + 1);
              $flock = $maxflock + 1;
		}	
		else if($culled == 0)
		{
			$diff = (strtotime($date) - strtotime($entrydate))/86400;
			if($diff > 10)
			{
                       $aflock = $towarehouse.'-@-'.($maxflock + 1);
                       $flock = $maxflock + 1;
			}
			else
			{
                       $aflock = $towarehouse.'-@-'.$maxflock;
                       $aflock = $maxflock1;
                       $flock = $maxflock;
			}
		}
	 }
	 else if($nobde == 0)
	 {
         $aflock = $towarehouse.'-@-'.$maxflock;
         $aflock = $maxflock1;
         $flock = $maxflock;
	 }
  }
  else
  {
         $aflock = $towarehouse.'-@-1';
         if($aflock == "") $aflock = $maxflock1;
         $flock = 1;
  }	

$tflock1 = $aflock;
}

//////////////end of getting the flock and a flock for broiler feed transfer for fromwarehouse////////////
}



//////////////getting the flock and a flock for broiler feed transfer for towarehouse////////////     
if(($cat == 'Broiler Feed') OR ($cat == 'Medicines') OR ($cat == 'Vaccines'))
{
 if($_SESSION['client'] <> 'SOUZANEW1')
 {
  $transflock = "";
		   $transflockdig = 0;
		   $trdate = "";
	  $query2="SELECT * from ims_stocktransfer where towarehouse = '$towarehouse' and (cat = 'Broiler Chicks' or cat = 'Broiler Feed') order by date DESC LIMIT 1";
			$result2=mysql_query($query2,$conn) or die(mysql_error());
			while($rows9=mysql_fetch_array($result2))
			{
			 $transflock = $rows9['aflock'];
			 $transflkdig = $rows9['flock'];
			 $trdate = $rows9['date'];
			}
			if($trdate == "") 
			{
			 $query5="SELECT * from pp_sobi where warehouse = '$towarehouse'  and code = 'BROC101' order by date DESC LIMIT 1";
			}
			else
			{
			  $query5="SELECT * from pp_sobi where warehouse = '$towarehouse' and date > '$trdate' and code = 'BROC101' order by date DESC LIMIT 1";
			}
			
			   $result5=mysql_query($query5,$conn);
			   while($rows5=mysql_fetch_array($result5))
			   {
			   $purchaseflock = $transflock = $rows5['flock'];
			   }
			$cflag = "";
			$cntrows = 0;
			$query2="SELECT * from broiler_daily_entry where flock = '$transflock' order by cullflag DESC LIMIT 1 ";
			$result2=mysql_query($query2,$conn) or die(mysql_error());
			$cntrows = mysql_num_rows($result2);
			if($cntrows > 0){
			while($rows9=mysql_fetch_array($result2))
			{
			   $cflag = $rows9['cullflag'];
			}
			}
			if($cflag == 1)
				{
					$get_flock=$transflock;
					$temp=split('-',$get_flock);
					if($temp[1]=="" || $temp[1]=="@")
					 $flock = "1";
 					else
					 $number = $temp[1]+1;
					$aflock = $temp[0]."-".$number;
					$flock = $number;
					$transflkdig++;
				 }
			else if($transflock == "")
			{
				$query3="select farm,farmcode from broiler_farm where farm = '$towarehouse' ";
				$result3=mysql_query($query3,$conn);
				while($rows3=mysql_fetch_array($result3))
				{
					 $aflock = $rows3['farmcode']."-1";
					$flock = "1";
				}
				
			}
			else
			{ 
				$aflock = $transflock;
			
			 } 			
 }
 elseif($_SESSION['client'] == 'SOUZANEW1')
 {
   
$notr = 0; $notc = 0; $nobde = 0; $culled =""; $notc1 = 0; $nobde1 = 0; $culled1 =""; $nobde2 = 0; $culled2 ="";
$notc2 = 0; $nobde3 = 0; $culled3 =""; $nobde4 = 0; $culled4 =""; $ToFlock = ""; $newflock = ""; $newflock1 = "";
$bdeflock = ""; $bdeflock1 = ""; $maxflock1 = ""; $maxflock = ""; $faflock=""; $caflock="";
 
 $q1 = mysql_query("select distinct(flock) as ToFlock,aflock,date,towarehouse from ims_stocktransfer where towarehouse ='$towarehouse' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC LIMIT 1") or die(mysql_error());
  $notr = mysql_num_rows($q1); 

 while($nt1 = mysql_fetch_assoc($q1))
 {
  $ToFlock = $nt1['ToFlock']; 
  $faflock = $nt1['aflock'];
 }
 $q2 = mysql_query("select distinct(flock) as newflock,aflock,date,towarehouse from ims_stocktransfer where towarehouse = '$towarehouse' AND cat = 'Broiler Chicks' AND client = '$client' order by date DESC LIMIT 1") or die(mysql_error());
  $notc = mysql_num_rows($q2); 

 while($nt2 = mysql_fetch_assoc($q2))
 {
   $newflock = $nt2['newflock'];
   $caflock = $nt2['aflock'];
 }
 
 if($newflock >= $ToFlock)
 {
   $maxflock = $newflock;
   $maxflock1 = $caflock;
 }
 else
 {
   $maxflock = $ToFlock;
   $maxflock1 = $faflock;
 }
 
 if($notr != 0 || $notc != 0)
 {    
	$q3 = mysql_query("select distinct(flock),cullflag,entrydate from broiler_daily_entry where farm ='$towarehouse' and flock = '$maxflock1' AND client = '$client' order by entrydate DESC") or die(mysql_error());
	$nobde = mysql_num_rows($q3);
	if($q3r = mysql_fetch_assoc($q3))
	{
	 $culled = $q3r['cullflag'];
	 $entrydate = $q3r['entrydate'];
	}
	if($nobde != 0)
	{
		if($culled == 1)
		{
              $aflock = $towarehouse.'-@-'.($maxflock + 1);
              $flock = $maxflock + 1;
		}	
		else if($culled == 0)
		{
			$diff = (strtotime($date) - strtotime($entrydate))/86400;
			if($diff > 10)
			{
                       $aflock = $towarehouse.'-@-'.($maxflock + 1);
                       $flock = $maxflock + 1;
			}
			else
			{
                       $aflock = $towarehouse.'-@-'.$maxflock;
                       $aflock = $maxflock1;
                       $flock = $maxflock;
			}
		}
	 }
	 else if($nobde == 0)
	 {
         $aflock = $towarehouse.'-@-'.$maxflock;
         $aflock = $maxflock1;
         $flock = $maxflock;
	 }
  }
  else
  {
         $aflock = $towarehouse.'-@-1';
         if($aflock == "") $aflock = $maxflock1;
         $flock = 1;
  }	

 }
}

//////////////end of getting the flock and a flock for broiler feed transfer for towarehouse////////////

if($tflock == "") $tflock = $fromwarehouse;
if($aflock == "") $aflock = $towarehouse;

/*
if($_SESSION['client'] <> 'SOUZANEW1')
{
$temp = split('-',$aflock);
if($temp[1]=="" || $temp[1]=="@")
 $flock = "1";
else
 $flock=$temp[1];
}*/

if($aflock == $purchaseflock)
{
 $query = "SELECT * FROM broiler_daily_entry WHERE flock = '$aflock' AND client = '$client'";
 $result = mysql_query($query,$conn) or die(mysql_error());
 $norows1 = mysql_num_rows($result);
 $query = "SELECT * FROM ims_stocktransfer WHERE flock = '$aflock' AND client = '$client'";
 $result = mysql_query($query,$conn) or die(mysql_error());
 $norows2 = mysql_num_rows($result);
 $norows = $norows1 + $norows2;
 if($norows == 0)
  $transflkdig++;
} 
if($transflkdig > 1)
 $flock = $transflkdig;

	$q = "insert into ims_stocktransfer (tid,date,cat,fromwarehouse,fromunits,towarehouse,tounits,code,quantity,empid,empname,sector,adate,aempid,aempname,asector,flock,aflock,tflock,price,vehicleno,driver,tmno,tcost,remarks,flag,client) values ('$tid','$date','$cat','$fromwarehouse','$units','$towarehouse','$units','$code','$quantity','$empid','$empname','$sector','$date','$empid','$empname','$sector','$flock','$aflock','$tflock','$price','$vno','$driver','$tmno','$tcost','$remarks','1','$client') ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());

/////////financial postings//////////


$q = "select max(id) as tid from ims_stocktransfer where client = '$client'";
$qrs =mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$id = $qr['tid'];


      $q1 = "SELECT * FROM ims_itemcodes WHERE code = '$code' AND client = '$client'";
      $r1 = mysql_query($q1,$conn);
      while($row1 = mysql_fetch_assoc($r1))
      {
        $mode = $row1['cm'];
	  $iac = $row1['iac'];
	  $wpac = $row1['wpac'];
      }
      $amount = $quantity * changeprice(round(calculate($mode,$code,$date),2));

if($n121 > 0)
{
    $crdr = "Cr";
    $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse,client) values('$date','$code','$crdr','$iac','$quantity','$amount','$type','$id','$tflock','$fromwarehouse','$client')";
    $qrs1 = mysql_query($q1,$conn);

    $crdr = "Dr";
     $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse,client) values('$date','$code','$crdr','$iac','$quantity','$amount','$type','$id','$aflock','$towarehouse','$client')";
     $qrs1 = mysql_query($q1,$conn);
}
else
{
    $crdr = "Cr";
    $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse,client) values('$date','$code','$crdr','$iac','$quantity','$amount','$type','$id','$tflock','$fromwarehouse','$client')";
    $qrs1 = mysql_query($q1,$conn);

    $crdr = "Dr";
    $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse,client) values('$date','$code','$crdr','$iac','$quantity','$amount','$type','$id','$aflock','$towarehouse','$client')";
    $qrs1 = mysql_query($q1,$conn);

}
/////////financial postings//////////

}
}
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=ims_stocktransfer'";
echo "</script>";

?>