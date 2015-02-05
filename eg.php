<?php 

include "config.php";
$res=mysql_query("select * from logdetails ");
$i=1;
while($mrow = mysql_fetch_array($res)) 
{ 
$i++;

 $duration="";
 $days=0;

 $diff=0;
 $min=0;
 $sec=0;
 $hr=0;
 $time1=0;
 $time2=0;
 

 
 $dep=explode(':',$mrow['sessionstarttime']);
 $arr=explode(':',$mrow['sessionendtime']);
 $diff=abs(mktime($dep[0],$dep[1],0,date('n'),date('j'),date('y'))-mktime($arr[0],$arr[1],0,date('n'),date('j')+$nextday,date('y')));
 $hours=floor($diff/(60*60));
 $mins=floor(($diff-($hours*60*60))/(60));
 $secs=floor(($diff-(($hours*60*60)+($mins*60))));
 if(strlen($hours)<2){$hours="0".$hours;}
 if(strlen($mins)<2){$mins="0".$mins;}
 if(strlen($secs)<2){$secs="0".$secs;}
$duration=$hours."hr".$mins."min".$secs;

 
 /*

$time1=strtotime($mrow['sessionstarttime']);
 $time2=strtotime($mrow['sessionendtime']);

$diff=abs($time2-$time1);

echo $diff;

if($diff>0)
{
$hr=$diff/(60*60);
$hr=floor($hr);
$min=$diff%(60*60);
$min=floor($min/60);
$sec=$min%60;


$sec=floor($sec);





}



 $hr=intval($hr);
 $sec=intval($sec);
 $min=intval($min);

 if($hr>0)
$duration=$duration.$hr."hr";
if($min>0)
$duration=$duration.$min."min";
if($sec>0)
$duration=$duration.$sec."sec";

*/
echo $mrow[1]."/".$mrow[3]."/".$mrow[5]."/".$mrow[6]."/".$duration."/".$sestime;
echo "<br/>";


}

?>