<?php 
include "config.php";
$code = $_GET['code'];

 $query = "select * from ac_financialpostings where itemcode ='$code'";
$resultb = mysql_query($query,$conn);
$rowcnt = mysql_num_rows($resultb);
if ( $rowcnt > 0)
{
     echo "<script type='text/javascript'>";
             echo "alert('Code has been already assigned to an account,Please use different code');";
             echo "document.location = 'dashboardsub.php?page=ims_itemcodes';";
             echo "</script>";
}
else if( $rowcnt == 0)
{
$query = "select * from breeder_vacschedule where vaccode='$code'";
$resultq = mysql_query($query,$conn);
$rowcnt = mysql_num_rows($resultq);
if ( $rowcnt > 0)
{
     echo "<script type='text/javascript'>";
             echo "alert('Code has been already assigned to an account,Please use different code');";
             echo "document.location = 'dashboardsub.php?page=ims_itemcodes';";
             echo "</script>";
}
}
else if( $rowcnt == 0)
{
$query = "select * from feedfformula where ingredient='$code'";
$resultw = mysql_query($query,$conn);
$rowcnt = mysql_num_rows($resultw);
if( $rowcnt == 0)
{
$query="select * from feedfformula where feedtype='$code'";
$resultr=mysql_query($query,$conn);
$rowcnt=mysql_num_rows($resultr);

}
if( $rowcnt > 0)
{
     echo "<script type='text/javascript'>";
             echo "alert('Code has been already assigned to an account,Please use different code');";
             echo "document.location = 'dashboardsub.php?page=ims_itemcodes';";
             echo "</script>";
}                           
}
else if( $rowcnt == 0)
{
$query = "select * from feed_itemwise where ingredient='$code'";
$resultw = mysql_query($query,$conn);
$rowcnt = mysql_num_rows($resultw);
if( $rowcnt == 0)
{
$query="select * from feed_itemwise where feedtype='$code'";
$resultr=mysql_query($query,$conn);
$rowcnt=mysql_num_rows($resultr);

}
if( $rowcnt > 0)
{
     echo "<script type='text/javascript'>";
             echo "alert('Code has been already assigned to an account,Please use different code');";
             echo "document.location = 'dashboardsub.php?page=ims_itemcodes';";
             echo "</script>";
}                           
}
if( $rowcnt == 0)
{
$query = "select * from ims_bagdetails where code ='$code'";
$resultb = mysql_query($query,$conn);
$rowcnt = mysql_num_rows($resultb);
if ( $rowcnt > 0)
{
     echo "<script type='text/javascript'>";
             echo "alert('Code has been already assigned to an account,Please use different code');";
             echo "document.location = 'dashboardsub.php?page=ims_itemcodes';";
             echo "</script>";
}
}

if($rowcnt == 0)
{
$query = "delete from ims_itemcodes where id = '$_GET[id]'";
$result = mysql_query($query,$conn);
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=ims_itemcodes';";
echo "</script>";
}

?>
