<?php 
//sleep(10);
//echo '5';
session_start(); $_SESSION[s]=0;
include "config.php";
 $i=0;$j=0; $countofCT=0;
					      $query="select distinct(name),ca,va,type,cterm from contactdetails where type like '%party%' order by type,name";
							$result1=mysql_query($query) or die(mysql_error());
							while($a=mysql_fetch_assoc($result1))
							{ 
							if($a[type]=='party')
							 $coacode="'$a[ca]'";
							else if ($a[type]=='vendor') 
							$coacode="'$a[va]'";
							else 
							 $coacode="'$a[ca]','$a[va]'";
							 $_SESSION[s]=$_SESSION[s]+1;
							 
							$query="SELECT sum(amount) as Dramount FROM `ac_financialpostings` WHERE `venname` LIKE ".' "'.$a[name].'"'." and coacode in ($coacode) and crdr='Dr'";
							$_SESSION[name]=$query;
							$result=mysql_query($query) or die( mysql_error()) ;
							$a1=mysql_fetch_assoc($result);
							$query="SELECT sum(amount) as Cramount FROM `ac_financialpostings` WHERE `venname`LIKE ".' "'.$a[name].'"'." and coacode in ($coacode) and crdr='Cr'";
							$_SESSION[name]=$query;
							$result=mysql_query($query) or die(mysql_error()) ;
							$a2=mysql_fetch_assoc($result);
							
							$bal=$a2[Cramount]-$a1[Dramount];
							
							if ($bal != 0) { 
							$countofCT++;
							if($bal>0)
							 { $msg=$msgpay[$i]="$bal should pay to $a[name]"; $i++; }
							else
							 { //$msg=$msgget[$j]=($bal*(-1))." &nbsp; should get from $a[name]"; $j++;
							   $msg=$msgpay[$i]=($bal*(-1))." should get from $a[name]"; $i++;
							   /*$nameget[$j]=$a[name];
							   $dateget[$j]='';
							   $balget[$j]=($bal*(-1));
							    $trnum='';
							    $remaining=$balget[$j];
		$q="SELECT date_add( date, INTERVAL $a[cterm] DAY ) AS ctdate, `amount`,trnum  FROM `ac_financialpostings` WHERE venname= '$a[name]' and type='COBI' and crdr='Dr' having ctdate<(select now() from dual) ORDER BY ctdate desc";
							 $r=mysql_query($q);
							 while($array=mysql_fetch_assoc($r))
							 {
							  $date=$array[ctdate];
							  $trnum=$array[trnum];
							  $remaining-=$array[amount];
							  if($remaining < 0)
							   break;
							 }
							 $dateget[$j]= $date;
							 $trnumget[$j]= $trnum;
							  */
							}
							
							  } // end of if cond of bal
							} // end of while
							
							$count +=$countofCT;
							$implode=implode('@@@',$msgpay);
							echo $countofCT.'###'.$implode;
							exit;
?>
