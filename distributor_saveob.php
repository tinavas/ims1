<?php
include "config.php";
include "getemployee.php";
$id=$_POST['id'];
$tno=$_POST['tno'];
if($_POST['eid']==1)
{
$q1="delete FROM distributor_ob where  trnum='$tno'";
$r=mysql_query($q1);

$q2="delete from distribution_financialpostings where trnum='$tno' and type='DTOB'";
$r=mysql_query($q2);
}
$ddate=date("Y-m-d",strtotime($_POST['date']));

$trnum1=0;

$q = "select max(trnum) as tid from  `distributor_ob`"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
$qr = mysql_fetch_assoc($qrs);

 if($qr['tid']==0)
 {
 $tnum = 1;
 }
else
{
 $tnum = $tnum + 1;
 }

/*for($i = 0;$i < count($_POST['distributor']); $i++)
if( $_POST['distributor'][$i] != '0' && $_POST['ob'][$i] != '')
{
$dist = $_POST['distributor'][$i];
 $q1="select min(date) as date from distribution_financialpostings where warehouse='$dist'";
 $res1=mysql_query($q1,$conn);
$r1=mysql_fetch_assoc($res1);
 $dates[$i]=$r1['date'];
}
                          
//for($i=0;$i<count($dates);$i++)
  //echo $dates[$i]."<br/>"; 
  
 $mindate=$dates[0];
for ($c = 0 ;$c < count($dates);$c++) 
    {
	 if (strtotime($dates[$c]) < strtotime($mindate)) 
        {
           $mindate = $dates[$c];
            
        }
    } */
 
 //echo $mindate;
 
  //echo $date=date("Y-m-d",strtotime($mindate));
 //echo $ddate=date("Y-m-d",strtotime($_POST['date']));
 
 // if(strtotime($mindate)>strtotime($ddate))

for($i = 0;$i < count($_POST['distributor']); $i++)
if( $_POST['distributor'][$i] != '0' && $_POST['ob'][$i] != '')
{
$ob = $_POST['ob'][$i];
$dist = $_POST['distributor'][$i];
$superstockist=$_POST['superstockist'];
 $query="INSERT INTO distributor_ob (date,trnum,superstockist,distributor,openingbal,empname)
 VALUES ('".$ddate."','".$tnum."','".$_POST['superstockist']."','".$dist."','".$ob."','".$empname."')";

 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());
 
 $q3="insert into distribution_financialpostings(date,itemcode,crdr,quantity,amount,trnum,type,warehouse) values ('$ddate','','Cr','0','$ob','$tnum','DTOB','$superstockist'),('$ddate','','Dr','0','$ob','$tnum','DTOB','$dist') ";
 
 $q3=mysql_query($q3) or die(mysql_error());

}
 header('Location:dashboardsub.php?page=distributorob');




