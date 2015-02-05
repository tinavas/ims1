<?php

include "config.php";

$qry1="select group_concat(concat(code,'@',description,'@',sunits)) as codes,cat from ims_itemcodes group by cat ";
  
  $res=mysql_query($qry1,$conn) or die(mysql_error());
  while($row=mysql_fetch_array($res))
  {
    
  $codes[]=array("code"=>$row[codes],"cat"=>$row[cat]);
  
  }
  
  for($i=0;$i<count($codes);$i++)
  {
   $c=$codes[$i]["code"];
  $c0=explode(',',$c);
  for($j=0;$j<count($c0);$j++)
  {
  $c1=explode('@',$c0[$j]);
 echo $code=$c1[0];
 echo " ";
 echo $codes[$i]["cat"];
 echo "<br>";
   }
   
   }
   
 ?>