<?php
session_start();
include "config.php";
 $query2="delete from ac_financialpostings  where type='Production' and date between '2013-10-30' and '2013-10-30' ";
$result2=mysql_query($query2,$conn);
$query2="delete from ac_financialpostings  where type='Consumption' and date between '2013-10-30' and '2013-10-30' ";
$result2=mysql_query($query2,$conn);


////////Authorize///////////////
include "getemployee.php";



$query1a1 = "select distinct(id),flock,itemcode,date2,quantity from breeder_consumption where date2 between '2013-10-30' and '2013-10-30' order by id";
         $result1a1 = mysql_query($query1a1,$conn); 
         while($row11a1 = mysql_fetch_assoc($result1a1))
         {
		 
		 $flock=$row11a1['flock'];
$itemcode=$row11a1['itemcode'];
$date2=$row11a1['date2'];
$quantity=$row11a1['quantity'];


$query1a = "select * from ims_itemcodes where code = '$itemcode'";
         $result1a = mysql_query($query1a,$conn); 
         while($row11a = mysql_fetch_assoc($result1a))
         {
             $itemdesc = $row11a['description'];
             $units = $row11a['cunits'];
             $cate = $row11a['cat'];
             $mode = $row11a['cm'];
             $stdcost = $row11a['stdcost'];
             $iac = $row11a['iac'];
             $wpac = $row11a['wpac'];
         }
  



         $amount = (round(calculate($mode,$itemcode,$date2),2));
         $tamount = 0;
  
        /* if($stdcost == "" || $stdcost == 0)
         {*/
           $tamount = $quantity * $amount;
         /*}
         else
         {
           $tamount = $quantity * $stdcost;
         }*/
         $type = "Consumption";
         $tttamount = $tttamount + $tamount;
/********Getting the unit and saveing it as warehouse************/
$q1 = "SELECT unitcode,shedcode FROM breeder_flock WHERE  flockcode = '$flock'";
$r1 = mysql_query($q1,$conn) or die(mysql_error());
$rows1 = mysql_fetch_assoc($r1);
$unit = $rows1['unitcode'];
$shedcode = $rows1['shedcode'];
/**********end of getting the unit*****************************/

         $crdr = "Cr";
         $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse,client) values('".$date2."','".$itemcode."','".$crdr."','".$iac."','".$quantity."','".$tamount."','".$type."','".$flock."','".$flock."','".$unit."','".$client."')";
         $qrs1 = mysql_query($q1,$conn);
		  $crdr = "Dr";
		 $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse,client) values('".$date2."','".$itemcode."','".$crdr."','".$wpac."','".$quantity."','".$tamount."','".$type."','".$flock."','".$flock."','".$unit."','".$client."')";
         $qrs1 = mysql_query($q1,$conn);
		 
  

}



$query1a1 = "select distinct(id),itemcode,quantity,date1 from breeder_production where date1 between '2013-10-30' and '2013-10-30'  order by date1";
         $result1a1 = mysql_query($query1a1,$conn);
		 $herows = mysql_num_rows($result1a1);
		 if($herows>0)
		 {
         while($row11a1 = mysql_fetch_assoc($result1a1))
         {
$itemhat=$row11a1['itemcode'];
$hatquant=$row11a1['quantity'];
$date2=$row11a1['date1'];
//hatch eggs
$query = "SELECT * FROM ims_itemcodes where cat = 'Hatch Eggs' and (iusage='Produced' or iusage = 'Produced or Sale') and client = '$client' and code='$itemhat'  ORDER BY code ASC ";
    $result = mysql_query($query,$conn); 
    while($row1 = mysql_fetch_assoc($result))
    { 
     
     
       $itemcode = $row1['code'];
       $itemdesc = $row1['description'];
       $units = $row1['cunits'];
       $cate = $row1['cat'];
       $mode = $row1['cm'];
       $stdcost = $row1['stdcost'];
       $iac = $row1['iac'];
       $wpac = $row1['wpac'];
       $pvache = $pvac = $row1['pvac'];
       $quantity = $hatquant;

       


       
       if($_SESSION['db'] == "")
       {
           if($cate == "Hatch Eggs")
           {
             $query3 = "SELECT * FROM ims_stock WHERE itemcode = '$itemcode' and warehouse = '$flock' and client = '$client' ";
           }
       }
       else
       {
           if($cate == "Hatch Eggs")
           {
             $query3 = "SELECT * FROM ims_stock WHERE itemcode = '$itemcode' and client = '$client' ";
           }
       } 

       $result3 = mysql_query($query3,$conn);
       while($row3 = mysql_fetch_assoc($result3))
       {
       	$stockqty = $row3['quantity'];
      	$stockunit = $row3['unit']; 
       } 

       if($stockunit == $units)
       {
            $stockqty = $stockqty + $quantity;    
       }
       else
       {
            $stockqty = $stockqty + convertqty($quantity,$units,$stockunit,1);
       }
       if($_SESSION['db'] == "")
       {
          if($cate == "Hatch Eggs")
          {
             $query51 = "UPDATE ims_stock SET quantity = '$stockqty' WHERE itemcode = '$itemcode' and warehouse = '$flock' and client = '$client'";
          }
       }
      else
      {
          if($cate == "Hatch Eggs")
          {
             $query51 = "UPDATE ims_stock SET quantity = '$stockqty' WHERE itemcode = '$itemcode' and client = '$client'";
          }
      }
        $result51 = mysql_query($query51,$conn) or die(mysql_error());

      $damount = $tttamount;
      $tttamount = 0;
	  $amount = round(calculate($mode,$itemcode,$date2),2);
      $tamount = $quantity * $amount;
      $ttamount = $ttamount + $tamount;
      $type = "Production";
    
      $tttamount = $tttamount + $tamount;


        $crdr = "Dr";
        $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse,client) values('".$date2."','".$itemcode."','".$crdr."','".$iac."','".$quantity."','".$tamount."','".$type."','".$flock."','".$flock."','".$unit."','".$client."')";
		if($tamount > 0)
		{
         $qrs1 = mysql_query($q1,$conn);
		 
		 ///insert into ac_financialpostingssummary
		   $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$iac' and date = '$date2' and crdr = '$crdr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		  $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$date2','$iac','$tamount','$crdr','$flock','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + $tamount;
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$iac'and date = '$date2' and crdr = '$crdr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }
		 
		}
        $plusamount = $plusamount + $tamount;
        $plusqty = $plusqty + $quantity;
        $diff = $damount - $ttamount;



    
   }

//other eggs


////////////////other eggs////////////////////
    $query = "SELECT * FROM ims_itemcodes where cat = 'Eggs' and client = '$client' and code='$itemhat'  ORDER BY code ASC ";
    $result = mysql_query($query,$conn); 
    while($row1 = mysql_fetch_assoc($result))
    { 
     
       $itemcode = $row1['code'];
       $itemdesc = $row1['description'];
       $units = $row1['cunits'];
       $cate = $row1['cat'];
       $mode = $row1['cm'];
       $stdcost = $row1['stdcost'];
       $iac = $row1['iac'];
       $wpac = $row1['wpac'];
       $pvac = $row1['pvac'];
	   if($pvache == "")
	    $pvache = $pvac;
       $quantity = $hatquant;

       


 session_start();
       if($_SESSION['db'] == "")
       {
           if($cate == "Eggs")
           {
             $query3 = "SELECT * FROM ims_stock WHERE itemcode = '$itemcode' and warehouse = '$flock' and client = '$client' ";
           }
       }
       else
       {
           if($cate == "Eggs")
           {
             $query3 = "SELECT * FROM ims_stock WHERE itemcode = '$itemcode' and client = '$client' ";
           }
       } 

       $result3 = mysql_query($query3,$conn);
       while($row3 = mysql_fetch_assoc($result3))
       {
       	$stockqty = $row3['quantity'];
      	$stockunit = $row3['unit']; 
       } 

       if($stockunit == $units)
       {
            $stockqty = $stockqty + $quantity;    
       }
       else
       {
            $stockqty = $stockqty + convertqty($quantity,$units,$stockunit,1);
       }
       if($_SESSION['db'] == "")
       {
          if($cate == "Eggs")
          {
             $query51 = "UPDATE ims_stock SET quantity = '$stockqty' WHERE itemcode = '$itemcode' and warehouse = '$flock' and client = '$client'";
          }
       }
      else
      {
          if($cate == "Eggs")
          {
             $query51 = "UPDATE ims_stock SET quantity = '$stockqty' WHERE itemcode = '$itemcode' and client = '$client'";
          }
      }
        $result51 = mysql_query($query51,$conn) or die(mysql_error());




      $damount = $tttamount;
      $tttamount = 0;
		$amount = round(calculate($mode,$itemcode,$date2),2);
      $tamount = $quantity * $amount;
      $ttamount = $ttamount + $tamount;
      $type = "Production";
    
      $tttamount = $tttamount + $tamount;


        $crdr = "Dr";
        $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse,client) values('".$date2."','".$itemcode."','".$crdr."','".$iac."','".$quantity."','".$tamount."','".$type."','".$flock."','".$flock."','".$unit."','".$client."')";
		if($tamount > 0)
		{
         $qrs1 = mysql_query($q1,$conn);
		 
		 }

        $plusamount = $plusamount + $tamount;
        $plusqty = $plusqty + $quantity;
        $diff = $damount - $ttamount;


     }
    


$itemcode1 = ""; 
     $query90 = "SELECT distinct(itemcode) as 'itemcode' FROM `ac_financialpostings` WHERE type='Production' and crdr ='Dr' and date = '$date2' and trnum = '$flock' and client = '$client'";
     $result90 = mysql_query($query90,$conn);
     while($row90 = mysql_fetch_assoc($result90))
     {
        $itemcode1 = $row90['itemcode'] . "/" . $itemcode1;
     }
	 //echo $minusamount."/".$plusamount;
     $diff1 = $minusamount - $plusamount; 
     if($diff1 < 0) { $crdr = "Cr"; $diff1 = -($diff1); } else { $crdr = "Dr"; }
     $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse,client) values('".$date2."','".$itemcode1."','".$crdr."','".$pvache."','".$plusqty."','".$diff1."','".$type."','".$flock."','".$flock."','".$unit."','".$client."')";
     if($plusqty > 0) 
      { 
         $qrs1 = mysql_query($q1,$conn); 
}
}
}

echo "Success";
?>
