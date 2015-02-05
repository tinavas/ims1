
<form action="bkup.php" method="post">
<?php 
     include "config.php"; 

	  include "getemployee.php";
	  
	  $dt=date("Y-m-d",strtotime($_POST[date2]));
	  ?>
      
      <table align="center">
      <?php 
	 echo  $q="select * from ims_stocktransfer where date <='$dt' and tmno not in (select transferid from ims_stockreceive where date <='$dt')";
	  $aa=mysql_query($q) or die(mysql_error());
	  while($rr=mysql_fetch_array($aa))
	  {?>
	  <tr>
      <td><?php echo $rr[1];?></td>
      <td><?php echo $rr[4];?></td>
      <td><?php echo $rr[6];?></td>
      <td><?php echo $rr[8];?></td>
      <td><?php echo $rr[9];?></td>
      <td><?php echo $rr[2];?></td>
      <td><?php echo $rr[27];?></td>
      </tr>
	  <?php }
	  
	  ?>
      </table>
       <table align="center">
       <?php 
	   $i=0;
	  echo  $a="select * from oc_cobi where date <='$dt' and invoice not in (select invoice from distribution_salesreceipt) group by invoice";
	  $aa=mysql_query($a);
	  while($rr=mysql_fetch_array($aa))
	  {
	  $code='';
	  $quantity='';
	  $aa1=mysql_query("select * from oc_cobi where date <='$dt' and invoice='$rr[invoice]'");
	  while($rr1=mysql_fetch_array($aa1))
	  {
	  $code=$code."/".$rr1[code];
	  $quantity=$quantity."/".$rr1[quantity];
	  }
	  ?>
	  <tr>
      <td><?php echo $i;?>&nbsp;&nbsp;</td>
      <td><?php echo $rr[date];?></td>
      <td><?php echo $rr[party];?></td>
      <td><?php echo $rr[invoice];?></td>
      <td><?php echo $code;?></td>
      <td><?php echo $quantity;?></td>
      <td><?php echo $rr[finaltotal];?></td>
      <td><?php echo $rr[warehouse];?></td>
      </tr>
	  <?php $i++; }
	  
	  ?>
  </table>
         <table align="center">
       <?php 
	   $j=0;
	   echo $a1="select * from pp_sobi where date <='$dt' and receiveflag='0' group by so";
	  $aa=mysql_query($a1);
	  while($rr=mysql_fetch_array($aa))
	  {
	  $code='';
	  $quantity='';
	  $aa1=mysql_query("select * from pp_sobi where date <='$dt' and so='$rr[so]'");
	  $n=mysql_num_rows($aa1);
	  while($rr1=mysql_fetch_array($aa1))
	  {
	 
	  
	  $code=$code.$rr1[code]."/";
	  $quantity=$quantity.$rr1[receivedquantity]."/";
	  }
	  ?>
	  <tr>
      <td><?php echo $j;?></td>
      <td><?php echo $rr[date];?></td>
      <td><?php echo $rr[so];?></td>
      <td><?php echo $rr[vendor];?></td>
      <td><?php echo $code;?>&nbsp;&nbsp;</td>
      <td><?php echo $quantity;?></td>
      <td><?php echo $rr[grandtotal];?></td>
      <td><?php echo $rr[warehouse];?></td>
      </tr>
	  <?php $j++; }
	  
	  ?>    
      
      </table>
      <?php 
	  
	  
	  $q=mysql_query("select distinct(warehouse) as warehouse from ac_financialpostings");
	  while($r=mysql_fetch_array($q))
	  {
	  $wh[]=$r[warehouse];
	  }
	echo $qq="select sum(amount) as amount,sum(quantity) as quantity,crdr,coacode,warehouse from ac_financialpostings where warehouse!=''  and warehouse is not null and  date <='$dt' group by coacode,crdr,warehouse order by warehouse,coacode";
	  $q1=mysql_query($qq,$conn);
	  while($r1=mysql_fetch_array($q1))
	  {
	  if($r1[crdr]=='Cr')
	  {
	 $arr[$r1[coacode]][quantity][cr][$r1[warehouse]]=$r1[quantity];
	 $arr[$r1[coacode]][amount][cr][$r1[warehouse]]=$r1[amount];
	  }
	  else
	  {
	  $arr[$r1[coacode]][quantity][dr][$r1[warehouse]]=$r1[quantity];
	 $arr[$r1[coacode]][amount][dr][$r1[warehouse]]=$r1[amount];
	  }
	  //echo "<br>";
	  }
	  $q2=mysql_query("select distinct warehouse as wh,coacode as code from ac_financialpostings where warehouse!='' and warehouse is not null group by coacode order by warehouse,coacode");
	  echo mysql_num_rows($q2);
	  while($r2=mysql_fetch_array($q2))
	  {
	  //echo $r2[code];
	 // echo $w=$r2[wh];
	  //echo $arr[$r2[code]][amount][dr][$w];
	  $ab[]=array("code"=>$r2['code'],"val"=>$arr[$r2[code]][quantity][dr][$r2[wh]]-$arr[$r2[code]][quantity][cr][$r2[wh]]);
	   $abc[]=array("code"=>$r2['code'],"val"=>$arr[$r2[code]][amount][dr][$r2[wh]]-$arr[$r2[code]][amount][cr][$r2[wh]]);
	    
	   if(($arr[$r2[code]][quantity][dr][$r2[wh]]-$arr[$r2[code]][quantity][cr][$r2[wh]])<0 )
	   {
	   //echo "Quantities.......<br>";
	   echo $r2[wh]."="; 
	   echo $r2[code]."="; 
	   echo $arr[$r2[code]][quantity][dr][$r2[wh]]-$arr[$r2[code]][quantity][cr][$r2[wh]];
	   echo "<br>";
	   }
	    if(($arr[$r2[code]][amount][dr][$r2[wh]]-$arr[$r2[code]][amount][cr][$r2[wh]])<0 )
	   {
	   //echo "Values.......<br>";
	   echo $r2[wh]."="; 
	   echo $r2[code]."=";
	   echo $arr[$r2[code]][amount][dr][$r2[wh]]-$arr[$r2[code]][amount][cr][$r2[wh]];
	   echo "<br>";
	   }
	   	  }
	  $aa=json_encode($a1);
	  $aa1=json_encode($a2);
?>
<script type="text/javascript">
var qtys=<?php if(empty($aa)){echo "0";} else{ echo $aa; }?>;
var vals=<?php if(empty($aa1)){echo "0";} else{ echo $aa1; }?>;
</script>


<input type="submit" value="Take Back Up and Close"  />
<input type="hidden" name="dt" value="<?php echo $dt;?>" />

</form>