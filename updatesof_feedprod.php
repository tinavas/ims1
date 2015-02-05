<?php
session_start();
include "config.php";
$query2="delete from ac_financialpostings  where type='Feed Produced'";
$result2=mysql_query($query2,$conn);
$query2="delete from ac_financialpostings  where type='Item Consumed'";
$result2=mysql_query($query2,$conn);
////////Authorize///////////////
include "getemployee.php";
$query="select id,date,mash,production,formula,feedmill from feed_productionunit order by id desc";
$resilt=mysql_query($query,$conn);
while($rows=mysql_fetch_assoc($resilt))
{

$pid = $rows['id'];
$formulaa = $rows['formula'];
$feedmill = $rows['feedmill'];
$date = $rows['date'];
$feedtype = $rows['mash'];
$production = $rows['production'];


 $query9 = "SELECT * FROM tbl_sector WHERE sector = '$feedmill'";
     $result9 = mysql_query($query9,$conn);
	while($row = mysql_fetch_assoc($result9))
     {
	    $warehouse = $row['type'];
     } $tttamount=0;
$query5 = "SELECT * FROM feed_itemwise where pid = '$pid' and formulae = '$formulaa'  ORDER BY ingredient ASC ";
$result5 = mysql_query($query5,$conn); 
$numrows5 = mysql_num_rows($result5);
if( $numrows5 > 0 )
{

   while($row5 = mysql_fetch_assoc($result5))
   { 
     $deduction = $row5['quantity'];       
     $formula = $row5['formulae'];
     $code = $row5['ingredient'];
	 $query9 = "SELECT * FROM ims_itemcodes WHERE code = '$code'";
     $result9 = mysql_query($query9,$conn);
     while($row = mysql_fetch_assoc($result9))
     {$mode = $row['cm'];
       $iac = $row['iac'];
     }
     $amount = changeprice(round(calculate($mode,$code,$date,$deduction),3));
     $tamount = $deduction * $amount;
     $type = "Item Consumed";
    $tttamount = $tttamount + $tamount;
    if(($deduction > 0) or ($tamount > 0))
	{

    $crdr = "Cr";
    $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse) values('".$date."','".$code."','".$crdr."','".$iac."','".$deduction."','".$tamount."','".$type."','".$formula."','".$feedmill."','".$warehouse."')";
   $qrs1 = mysql_query($q1,$conn);
     }

  }
 
	}
	 $q = "select * from ims_itemcodes where code = '$feedtype' ";
    $qrs = mysql_query($q,$conn) or die(mysql_error());
    while($qr = mysql_fetch_assoc($qrs))
    {
	  $stdcost = $qr['stdcost'];
        $iac = $qr['iac'];
        $wpac = $qr['wpac'];
        $prvac = $qr['prvac'];
    }
    $type = "Feed Produced";
    $tamount = $production * $stdcost;
    $final = $tttamount - $tamount;
    $crdr = "Dr";
    $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse) values('".$date."','".$feedtype."','".$crdr."','".$iac."','".$production."','".$tamount."','".$type."','".$formula."','".$feedmill."','".$warehouse."')";
    $qrs1 = mysql_query($q1,$conn);
	if($final != 0)
    {
    if($final < 0) { $crdr = "Cr"; $final = -($final); } else { $crdr = "Dr"; }
    $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse) values('".$date."','".$feedtype."','".$crdr."','".$prvac."','".$production."','".$final."','".$type."','".$formula."','".$feedmill."','".$warehouse."')";
   $qrs1 = mysql_query($q1,$conn);
  }
}
echo "Success";
?>
