<br><br>
<div id=n1 style="z-index: 2; position: relative; right: 0px; top: 10px; background-color:#FFCC99;
width: 100px; padding: 10px; color: white; font-size:20px; border: #0000cc 2px dashed; "> </div>
<?php 
include "mainconfig.php";
 $q="SELECT TIME( NOW( ) ) as t1 , TIME( updated ) as t2 FROM blockedusers where uname='$_GET[uname]'";
 $q=mysql_query($q,$conn) or die(mysql_error());
$r=mysql_fetch_array($q);
$t1=strtotime($r[t1]);
$t2=strtotime($r[t2]);
$d=$t1-$t2;
$diff=date('H:i:s',$d);
?>

<script language=javascript>
to_start();
<?php 
$d1=explode(":",$diff);
?>
var h="<?php echo $d1[0];?>";
var m="<?php echo $d1[1];?>";
var s="<?php echo $d1[2];?>";

function to_start(){
tm=window.setInterval('disp()',1000);
}


function disp(){
// Format the output by adding 0 if it is single digit //
if(s<10){var s1='0' + s;}
else{var s1=s;}
if(m<10){var m1='0' + m;}
else{var m1=m;}
if(h<10){var h1='0' + h;}
else{var h1=h;}
// Display the output //
str= h1 + ':' + m1 +':' + s1 ;
document.getElementById('n1').innerHTML=str;
// Calculate the stop watch // 
if(s>0){ 
s=s-1;
}else{
s=59;
m=m-1;
if(m<0){
m=59;
s=59;
h=h-1;
if(h<=0)
window.clearInterval(tm);
} 
}
}
</script>