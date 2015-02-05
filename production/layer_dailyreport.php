<?php
include "getemployee.php";
session_start();
$client = $_SESSION['client'];
include "config.php";
$q1 = "select * from layer_consumption where  client = '$client' order by date2 desc";
$qrs = mysql_query($q1,$conn1) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
	  $sdate =  $qr['date2'];
} 

$fdatedump = $_GET['date'];
$fdate = date("Y-m-d", strtotime($fdatedump));
if($_SESSION['db'] != 'albustanlayer')
{
if($sdate == $fdate)
{
////////////// if start date start //////////////

$fdatedump = $_GET['date'];
$fdate = date("Y-m-j", strtotime($fdatedump));
$tdatedump = $_GET['date'];
$tdate = date("Y-m-j", strtotime($tdatedump));

$q = "select * from ac_coa where controltype = 'Cash' and client = '$client' ";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
  $coa = $qr['code'];
  $desc = $qr['description'];
}



$drtotal = 0;
$crtotal = 0;
$oflag = "Dr";
$obal = 0;

$type = "";
$q = "select * from ac_coa where code = '$coa' and client = '$client' ";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
  $type = $qr['type'];
}

if ( $type == "Expense" or $type == "Revenue")
{
   $startdate = $fdate;
   $q = "select * from ac_definefy where fdate <= '$fdate' and client = '$client' and tdate >= '$fdate' ";
   $qrs = mysql_query($q,$conn1) or die(mysql_error());
   while($qr = mysql_fetch_assoc($qrs))
   {
	  $startdate = $qr['fdate'];
   }
	
   $q1 = "select sum(amount) as cramount from ac_financialpostings where coacode = '$coa' and type = 'RV' and client = '$client' and crdr = 'Cr' and date >= '$startdate' and date = '$fdate' ";
   $qrs = mysql_query($q1,$conn1) or die(mysql_error());
   while($qr = mysql_fetch_assoc($qrs))
   {
	  $crtotal = $crtotal + $qr['cramount'];
   } 
 
   $q = "select sum(amount) as dramount from ac_financialpostings where coacode = '$coa' and type = 'RV' and client = '$client' and crdr = 'Dr' and date >= '$startdate'  and date = '$fdate' ";
   $qrs = mysql_query($q,$conn1) or die(mysql_error());
   while($qr = mysql_fetch_assoc($qrs))
   {
        $drtotal = $drtotal + $qr['dramount'];
   } 	
	
}
else
{
   $q1 = "select sum(amount) as cramount from ac_financialpostings where coacode = '$coa'  and type = 'RV' and client = '$client' and crdr = 'Cr' and date = '$fdate' ";
   $qrs = mysql_query($q1,$conn1) or die(mysql_error());
   while($qr = mysql_fetch_assoc($qrs))
   {
	  $crtotal = $crtotal + $qr['cramount'];
   } 

   $q = "select sum(amount) as dramount from ac_financialpostings where coacode = '$coa'  and type = 'RV' and client = '$client' and crdr = 'Dr' and date = '$fdate' ";
   $qrs = mysql_query($q,$conn1) or die(mysql_error());
   while($qr = mysql_fetch_assoc($qrs))
   {
	  $drtotal = $drtotal + $qr['dramount'];
   } 	
}

  
if ( $drtotal > $crtotal )
{
  $obal = $drtotal - $crtotal;
} 		
else
{
  $obal = $crtotal - $drtotal;
  $oflag = "Cr";
}
$drtotal = 0;
$crtotal = 0;

$nxtdate = "";
$dumfrmdate = ""; 

$query1 = "SELECT * from ac_financialpostings where coacode = '$coa'  and date >= '$fdate' and type <>'RV' and client = '$client' and date <= '$tdate' order by date,trnum ";
$result1 = mysql_query($query1,$conn1);
$dumfrmdate = $fdate;
while($row2 = mysql_fetch_assoc($result1))
{
   $dumfrmdate = $row2['date'];
   if ( $row2['crdr'] == "Dr" ) { $drtotal = $drtotal + $row2['amount']; } 

   if ( $row2['crdr'] == "Cr" ) { $crtotal = $crtotal + $row2['amount']; } 
}
$clbal = $obal + $drtotal - $crtotal; 











$teggrecp = 0;
$teggissue = 0;
$teggobl = 0;

$q12 = "select * from ims_itemcodes where cat  = 'Layer Eggs' and client = '$client'  ";
	$qrs12 = mysql_query($q12,$conn1) or die(mysql_error());
	while($qr12 = mysql_fetch_assoc($qrs12))
 {
   $egcode = $qr12['code'];
   $egitemcode = "";
   $eggrecp = 0;
   $eggissue = 0;
   $preissueqty = 0;
   $prercvqty = 0;
   $eggobl = 0;

   $q = "select * from ims_itemcodes where code  = '$egcode' and client = '$client'  ";
	$qrs = mysql_query($q,$conn1) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	   $egitemcode = $qr['iac'];
	}


   $q = "select amount,quantity,type,trnum from ac_financialpostings where crdr = 'Cr'  and type = 'IR' and client = '$client' and itemcode  = '$egcode' and coacode = '$egitemcode' and date = '$fdate' order by date ";
	$qrs = mysql_query($q,$conn1) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	     $preissueqty = $preissueqty + $qr['quantity'];
	}


   $q = "select amount,quantity,type,trnum from ac_financialpostings where itemcode  = '$egcode' and type = 'IR' and client = '$client' and crdr = 'Dr' and coacode = '$egitemcode' and date = '$fdate' order by date ";
	$qrs = mysql_query($q,$conn1) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	     $prercvqty = $prercvqty + $qr['quantity'];
	}

     

	$eggobl = $prercvqty - $preissueqty;

   $query1 = "SELECT type,trnum,date,quantity,amount,crdr from ac_financialpostings where itemcode = '$egcode'  and type <> 'IR' and client = '$client' and coacode = '$egitemcode'  and date >= '$fdate' and date <= '$tdate'  order by date ";
   $result1 = mysql_query($query1,$conn1);
   while($row2 = mysql_fetch_assoc($result1))
   {
     $dumfrmdate = $row2['date'];
     if($row2['crdr'] == "Dr") 
     {
       //echo $row2['quantity']; echo "<br />";
       $eggrecp = $eggrecp + $row2['quantity'];
     }
     else
       $eggissue = $eggissue + $row2['quantity'];
   }

 $teggrecp = $teggrecp + $eggrecp;
 $teggissue = $teggissue + $eggissue;
 $teggobl = $teggobl + $eggobl;
}

$j = -1;
$query1 = "SELECT * from ac_bankmasters where mode = 'Bank' and client = '$client' order by name ";
$result1 = mysql_query($query1,$conn1);
while($row2 = mysql_fetch_assoc($result1))
{
  $j = $j + 1;
  $bname[$j] = $row2['name'];
  $bcode[$j] = $row2['code'];
}


$j = -1;
$bq34 = "select * from ac_coa where controltype = 'Bank' and client = '$client' order by code asc";
$bqrs34 = mysql_query($bq34,$conn1) or die(mysql_error());
while($bqr34 = mysql_fetch_assoc($bqrs34))
{
  $j = $j + 1;
  $bcoa = $bqr34['code'];
  $bdesc = $bqr34['description'];


$bdrtotal = 0;
$bcrtotal = 0;
$boflag = "Dr";
$bobal = 0;

$type = "";
$bq = "select * from ac_coa where code = '$bcoa' and client = '$client' ";
$bqrs = mysql_query($bq,$conn1) or die(mysql_error());
while($bqr = mysql_fetch_assoc($bqrs))
{
  $btype = $bqr['type'];
}

if ( $btype == "Expense" or $btype == "Revenue")
{
   $bstartdate = $fdate;
   $bq = "select * from ac_definefy where fdate <= '$fdate' and client = '$client' and type = 'RV' and tdate >= '$fdate' ";
   $bqrs = mysql_query($bq,$conn1) or die(mysql_error());
   while($bqr = mysql_fetch_assoc($bqrs))
   {
	  $bstartdate = $bqr['fdate'];
   }
	
   $bq1 = "select sum(amount) as cramount from ac_financialpostings where coacode = '$bcoa' and type = 'RV'  and client = '$client' and crdr = 'Cr' and date >= '$bstartdate' and date < '$fdate' ";
   $bqrs = mysql_query($bq1,$conn1) or die(mysql_error());
   while($bqr = mysql_fetch_assoc($bqrs))
   {
	  $bcrtotal = $bcrtotal + $bqr['cramount'];
   } 
 
   $bq = "select sum(amount) as dramount from ac_financialpostings where coacode = '$bcoa' and type = 'RV'  and client = '$client' and crdr = 'Dr' and date >= '$bstartdate'  and date < '$fdate' ";
   $bqrs = mysql_query($bq,$conn1) or die(mysql_error());
   while($bqr = mysql_fetch_assoc($bqrs))
   {
        $bdrtotal = $bdrtotal + $bqr['dramount'];
   } 	
	
}
else
{
   $bq1 = "select sum(amount) as cramount from ac_financialpostings where coacode = '$bcoa' and type = 'RV' and client = '$client' and crdr = 'Cr' and date = '$fdate' ";
   $bqrs = mysql_query($bq1,$conn1) or die(mysql_error());
   while($bqr = mysql_fetch_assoc($bqrs))
   {
	  $bcrtotal = $bcrtotal + $bqr['cramount'];
   } 

   $bq = "select sum(amount) as dramount from ac_financialpostings where coacode = '$bcoa' and type = 'RV' and client = '$client' and crdr = 'Dr' and date = '$fdate' ";
   $bqrs = mysql_query($bq,$conn1) or die(mysql_error());
   while($bqr = mysql_fetch_assoc($bqrs))
   {
	  $bdrtotal = $bdrtotal + $bqr['dramount'];
   } 	
}

  
if ( $bdrtotal > $bcrtotal )
{
  $bobal = $bdrtotal - $bcrtotal;
} 		
else
{
  $bobal = $bcrtotal - $bdrtotal;
  $boflag = "Cr";
}
$bdrtotal = 0;
$bcrtotal = 0;

$bnxtdate = "";
$bdumfrmdate = ""; 

$bquery1 = "SELECT * from ac_financialpostings where coacode = '$bcoa'  and type <> 'RV' and date >= '$fdate' and client = '$client' and date <= '$tdate' order by date,trnum ";
$bresult1 = mysql_query($bquery1,$conn1);
$bdumfrmdate = $fdate;
while($row2 = mysql_fetch_assoc($bresult1))
{
   $bdumfrmdate = $row2['date'];
   if ( $row2['crdr'] == "Dr" ) { $bdrtotal = $bdrtotal + $row2['amount']; } 

   if ( $row2['crdr'] == "Cr" ) { $bcrtotal = $bcrtotal + $row2['amount']; } 
}
$bclbal = $bobal + $bdrtotal - $bcrtotal; 

$abobal[$j] = $bobal;
$abdrtotal[$j] = $bdrtotal;
$abcrtotal[$j] = $bcrtotal;
$abclbal[$j] = $bclbal;

}
////////////// if start date end //////////////

} 
else
{

////////////// if not start date start //////////////

$fdatedump = $_GET['date'];
$fdate = date("Y-m-j", strtotime($fdatedump));
$tdatedump = $_GET['date'];
$tdate = date("Y-m-j", strtotime($tdatedump));

$q = "select * from ac_coa where controltype = 'Cash' and client = '$client' ";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
  $coa = $qr['code'];
  $desc = $qr['description'];
}



$drtotal = 0;
$crtotal = 0;
$oflag = "Dr";
$obal = 0;

$type = "";
$q = "select * from ac_coa where code = '$coa' and client = '$client' ";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
  $type = $qr['type'];
}

if ( $type == "Expense" or $type == "Revenue")
{
   $startdate = $fdate;
   $q = "select * from ac_definefy where fdate <= '$fdate' and client = '$client' and tdate >= '$fdate' ";
   $qrs = mysql_query($q,$conn1) or die(mysql_error());
   while($qr = mysql_fetch_assoc($qrs))
   {
	  $startdate = $qr['fdate'];
   }
	
   $q1 = "select sum(amount) as cramount from ac_financialpostings where coacode = '$coa' and client = '$client' and crdr = 'Cr' and date >= '$startdate' and date < '$fdate' ";
   $qrs = mysql_query($q1,$conn1) or die(mysql_error());
   while($qr = mysql_fetch_assoc($qrs))
   {
	  $crtotal = $crtotal + $qr['cramount'];
   } 
 
   $q = "select sum(amount) as dramount from ac_financialpostings where coacode = '$coa' and client = '$client' and crdr = 'Dr' and date >= '$startdate'  and date < '$fdate' ";
   $qrs = mysql_query($q,$conn1) or die(mysql_error());
   while($qr = mysql_fetch_assoc($qrs))
   {
        $drtotal = $drtotal + $qr['dramount'];
   } 	
	
}
else
{
   $q1 = "select sum(amount) as cramount from ac_financialpostings where coacode = '$coa' and client = '$client' and crdr = 'Cr' and date < '$fdate' ";
   $qrs = mysql_query($q1,$conn1) or die(mysql_error());
   while($qr = mysql_fetch_assoc($qrs))
   {
	  $crtotal = $crtotal + $qr['cramount'];
   } 

   $q = "select sum(amount) as dramount from ac_financialpostings where coacode = '$coa' and client = '$client' and crdr = 'Dr' and date < '$fdate' ";
   $qrs = mysql_query($q,$conn1) or die(mysql_error());
   while($qr = mysql_fetch_assoc($qrs))
   {
	  $drtotal = $drtotal + $qr['dramount'];
   } 	
}

  
if ( $drtotal > $crtotal )
{
  $obal = $drtotal - $crtotal;
} 		
else
{
  $obal = $crtotal - $drtotal;
  $oflag = "Cr";
}
$drtotal = 0;
$crtotal = 0;

$nxtdate = "";
$dumfrmdate = ""; 

 $query1 = "SELECT * from ac_financialpostings where coacode = '$coa'  and date >= '$fdate' and client = '$client' and date <= '$tdate' order by date,trnum ";
$result1 = mysql_query($query1,$conn1);
$dumfrmdate = $fdate;
while($row2 = mysql_fetch_assoc($result1))
{
   $dumfrmdate = $row2['date'];
   if ( $row2['crdr'] == "Dr" ) { $drtotal = $drtotal + $row2['amount']; } 

   if ( $row2['crdr'] == "Cr" ) { $crtotal = $crtotal + $row2['amount']; } 
}
$clbal = $obal + $drtotal - $crtotal; 

$teggrecp = 0;
$teggissue = 0;
$teggobl = 0;

$q12 = "select * from ims_itemcodes where cat  = 'Layer Eggs' and client = '$client'  ";
	$qrs12 = mysql_query($q12,$conn1) or die(mysql_error());
	while($qr12 = mysql_fetch_assoc($qrs12))
 {
   $egcode = $qr12['code'];
   $egitemcode = "";
   $eggrecp = 0;
   $eggissue = 0;
   $preissueqty = 0;
   $prercvqty = 0;
   $eggobl = 0;

   $q = "select * from ims_itemcodes where code  = '$egcode' and client = '$client'  ";
	$qrs = mysql_query($q,$conn1) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	   $egitemcode = $qr['iac'];
	}


   $q = "select amount,quantity,type,trnum from ac_financialpostings where crdr = 'Cr'  and client = '$client' and itemcode  = '$egcode' and coacode = '$egitemcode' and date < '$fdate' order by date ";
	$qrs = mysql_query($q,$conn1) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	     $preissueqty = $preissueqty + $qr['quantity'];
	}


   $q = "select amount,quantity,type,trnum from ac_financialpostings where itemcode  = '$egcode' and client = '$client' and crdr = 'Dr' and coacode = '$egitemcode' and date < '$fdate' order by date ";
	$qrs = mysql_query($q,$conn1) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	     $prercvqty = $prercvqty + $qr['quantity'];
	}

     

	$eggobl = $prercvqty - $preissueqty;

   $query1 = "SELECT type,trnum,date,quantity,amount,crdr from ac_financialpostings where itemcode = '$egcode' and client = '$client' and coacode = '$egitemcode'  and date >= '$fdate' and date <= '$tdate'  order by date ";
   $result1 = mysql_query($query1,$conn1);
   while($row2 = mysql_fetch_assoc($result1))
   {
     $dumfrmdate = $row2['date'];
     if($row2['crdr'] == "Dr") 
     {
       //echo $row2['quantity']; echo "<br />";
       $eggrecp = $eggrecp + $row2['quantity'];
     }
     else
       $eggissue = $eggissue + $row2['quantity'];
   }

 $teggrecp = $teggrecp + $eggrecp;
 $teggissue = $teggissue + $eggissue;
 $teggobl = $teggobl + $eggobl;
}

$j = -1;
$query1 = "SELECT * from ac_bankmasters where mode = 'Bank' and client = '$client' order by coacode asc";
$result1 = mysql_query($query1,$conn1);
while($row2 = mysql_fetch_assoc($result1))
{
  $j = $j + 1;
  $bname[$j] = $row2['name'];
  $bcode[$j] = $row2['code'];
}


$j = -1;
$bq34 = "select * from ac_coa where controltype = 'Bank' and client = '$client' order by code asc";
$bqrs34 = mysql_query($bq34,$conn1) or die(mysql_error());
while($bqr34 = mysql_fetch_assoc($bqrs34))
{
  $j = $j + 1;
  $bcoa = $bqr34['code'];
  $bdesc = $bqr34['description'];


$bdrtotal = 0;
$bcrtotal = 0;
$boflag = "Dr";
$bobal = 0;

$type = "";
$bq = "select * from ac_coa where code = '$bcoa' and client = '$client' ";
$bqrs = mysql_query($bq,$conn1) or die(mysql_error());
while($bqr = mysql_fetch_assoc($bqrs))
{
  $btype = $bqr['type'];
}

if ( $btype == "Expense" or $btype == "Revenue")
{
   $bstartdate = $fdate;
   $bq = "select * from ac_definefy where fdate <= '$fdate' and client = '$client' and tdate >= '$fdate' ";
   $bqrs = mysql_query($bq,$conn1) or die(mysql_error());
   while($bqr = mysql_fetch_assoc($bqrs))
   {
	  $bstartdate = $bqr['fdate'];
   }
	
   $bq1 = "select sum(amount) as cramount from ac_financialpostings where coacode = '$bcoa' and client = '$client' and crdr = 'Cr' and date >= '$bstartdate' and date < '$fdate' ";
   $bqrs = mysql_query($bq1,$conn1) or die(mysql_error());
   while($bqr = mysql_fetch_assoc($bqrs))
   {
	  $bcrtotal = $bcrtotal + $bqr['cramount'];
   } 
 
   $bq = "select sum(amount) as dramount from ac_financialpostings where coacode = '$bcoa' and client = '$client' and crdr = 'Dr' and date >= '$bstartdate'  and date < '$fdate' ";
   $bqrs = mysql_query($bq,$conn1) or die(mysql_error());
   while($bqr = mysql_fetch_assoc($bqrs))
   {
        $bdrtotal = $bdrtotal + $bqr['dramount'];
   } 	
	
}
else
{
   $bq1 = "select sum(amount) as cramount from ac_financialpostings where coacode = '$bcoa' and client = '$client' and crdr = 'Cr' and date < '$fdate' ";
   $bqrs = mysql_query($bq1,$conn1) or die(mysql_error());
   while($bqr = mysql_fetch_assoc($bqrs))
   {
	  $bcrtotal = $bcrtotal + $bqr['cramount'];
   } 

   $bq = "select sum(amount) as dramount from ac_financialpostings where coacode = '$bcoa' and client = '$client' and crdr = 'Dr' and date < '$fdate' ";
   $bqrs = mysql_query($bq,$conn1) or die(mysql_error());
   while($bqr = mysql_fetch_assoc($bqrs))
   {
	  $bdrtotal = $bdrtotal + $bqr['dramount'];
   } 	
}

  
if ( $bdrtotal > $bcrtotal )
{
  $bobal = $bdrtotal - $bcrtotal;
} 		
else
{
  $bobal = $bcrtotal - $bdrtotal;
  $boflag = "Cr";
}
$bdrtotal = 0;
$bcrtotal = 0;

$bnxtdate = "";
$bdumfrmdate = ""; 

$bquery1 = "SELECT * from ac_financialpostings where coacode = '$bcoa'  and date >= '$fdate' and client = '$client' and date <= '$tdate' order by date,trnum ";
$bresult1 = mysql_query($bquery1,$conn1);
$bdumfrmdate = $fdate;
while($row2 = mysql_fetch_assoc($bresult1))
{
   $bdumfrmdate = $row2['date'];
   if ( $row2['crdr'] == "Dr" ) { $bdrtotal = $bdrtotal + $row2['amount']; } 

   if ( $row2['crdr'] == "Cr" ) { $bcrtotal = $bcrtotal + $row2['amount']; } 
}
$bclbal = $bobal + $bdrtotal - $bcrtotal; 

$abobal[$j] = $bobal;
$abdrtotal[$j] = $bdrtotal;
$abcrtotal[$j] = $bcrtotal;
$abclbal[$j] = $bclbal;

}
}
}

////////////// if not start date end //////////////

?>

<!-- <?php 
$sExport = @$_GET["export"]; 
if (@$sExport == "") { ?>
 
  <style type="text/css">
        thead tr {
            position: absolute; 
            height: 20px;
            top: expression(this.offsetParent.scrollTop);
        }
        tbody {
            height: auto;
        }
        .ewGridMiddlePanel {
        	border: 0;	
            height: 435px;
            padding-top:20px; 
            overflow: scroll; 
        }
    </style>
<?php } ?> -->
<?php include "reportheader.php"; ?>

<?php 
ini_set('display_errors', 0);
ini_set('log_errors', 0);
ini_set('error_reporting', E_ALL);
$client = $_SESSION['client'];
?>

<?php
session_start();
ob_start();

$query11 = "SELECT max(date2) as 'date' FROM layer_consumption where client = '$client'  ";
$result11 = mysql_query($query11,$conn1);
while($row21 = mysql_fetch_assoc($result11))
{
  $maxdate = $row21['date'];
}

$query11 = "SELECT min(id) as 'id' FROM layer_consumption where client = '$client'  ";
$result11 = mysql_query($query11,$conn1);
while($row21 = mysql_fetch_assoc($result11))
{
  $id = $row21['id'];
}

$maxdate = date("d.m.Y",strtotime($maxdate));

$getdate = $_GET['date'];
if(!isset($getdate)) { $getdate = $maxdate; } 
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php include "phprptinc/ewrcfg3.php"; ?>
<?php include "phprptinc/ewmysql.php"; ?>
<?php include "phprptinc/ewrfn3.php"; ?>
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "dummy", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "dummy_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "dummy_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "dummy_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "dummy_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "dummy_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "layer_consumption";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT layer_consumption.id FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "layer_consumption.id = '$id' and client = '$client'";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_id = NULL; // Popup filter for id
?>
<?php
$sExport = @$_GET["export"]; // Load export request
if ($sExport == "html") {

	// Printer friendly
}
if ($sExport == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . EW_REPORT_TABLE_VAR .'.xls');
}
if ($sExport == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . EW_REPORT_TABLE_VAR .'.doc');
}
?>
<?php

// Initialize common variables
// Paging variables

$nRecCount = 0; // Record count
$nStartGrp = 0; // Start group
$nStopGrp = 0; // Stop group
$nTotalGrps = 0; // Total groups
$nGrpCount = 0; // Group count
$nDisplayGrps = 3; // Groups per page
$nGrpRange = 10;

// Clear field for ext filter
$sClearExtFilter = "";

// Non-Text Extended Filters
// Text Extended Filters
// Custom filters

$ewrpt_CustomFilters = array();
?>
<?php
?>
<?php

// Field variables
$x_id = NULL;

// Detail variables
$o_id = NULL; $t_id = NULL; $ft_id = 3; $rf_id = NULL; $rt_id = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 2;
$nGrps = 1;
$val = ewrpt_InitArray($nDtls, 0);
$cnt = ewrpt_Init2DArray($nGrps, $nDtls, 0);
$smry = ewrpt_Init2DArray($nGrps, $nDtls, 0);
$mn = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
$mx = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
$grandsmry = ewrpt_InitArray($nDtls, 0);
$grandmn = ewrpt_InitArray($nDtls, NULL);
$grandmx = ewrpt_InitArray($nDtls, NULL);

// Set up if accumulation required
$col = array(FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();

// Set up popup filter
SetupPopup();

// Extended filter
$sExtendedFilter = "";

// Build popup filter
$sPopupFilter = GetPopupFilter();

//echo "popup filter: " . $sPopupFilter . "<br>";
if ($sPopupFilter <> "") {
	if ($sFilter <> "")
		$sFilter = "($sFilter) AND ($sPopupFilter)";
	else
		$sFilter = $sPopupFilter;
}

// No filter
$bFilterApplied = FALSE;

// Get sort
$sSort = getSort();

// Get total count
$sSql = ewrpt_BuildReportSql($EW_REPORT_TABLE_SQL_SELECT, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY, $EW_REPORT_TABLE_SQL_HAVING, $EW_REPORT_TABLE_SQL_ORDERBY, $sFilter, @$sSort);
$nTotalGrps = GetCnt($sSql);
if ($nDisplayGrps <= 0) // Display all groups
	$nDisplayGrps = $nTotalGrps;
$nStartGrp = 1;

// Show header
$bShowFirstHeader = ($nTotalGrps > 0);

//$bShowFirstHeader = TRUE; // Uncomment to always show header
// Set up start position if not export all

if (EW_REPORT_EXPORT_ALL && @$sExport <> "")
    $nDisplayGrps = $nTotalGrps;
else
    SetUpStartGroup(); 

// Get current page records
$rs = GetRs($sSql, $nStartGrp, $nDisplayGrps);
?>
<?php include "phprptinc/header.php"; ?>
<?php if (@$sExport == "") { ?>
<script type="text/javascript">
var EW_REPORT_DATE_SEPARATOR = "-";
if (EW_REPORT_DATE_SEPARATOR == "") EW_REPORT_DATE_SEPARATOR = "/"; // Default date separator
</script>
<script type="text/javascript" src="phprptjs/ewrpt.js"></script>
<?php } ?>
<?php if (@$sExport == "") { ?>
<script src="phprptjs/popup.js" type="text/javascript"></script>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script src="FusionChartsFree/JSClass/FusionCharts.js" type="text/javascript"></script>
<script type="text/javascript">
var EW_REPORT_POPUP_ALL = "(All)";
var EW_REPORT_POPUP_OK = "  OK  ";
var EW_REPORT_POPUP_CANCEL = "Cancel";
var EW_REPORT_POPUP_FROM = "From";
var EW_REPORT_POPUP_TO = "To";
var EW_REPORT_POPUP_PLEASE_SELECT = "Please Select";
var EW_REPORT_POPUP_NO_VALUE = "No value selected!";

// popup fields
</script>
<?php } ?>
<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table align="center" id="ewContainer" cellspacing="0" cellpadding="0" border="0" style="width:900px"> 
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Daily Consumption & Production  report on <?php echo $getdate; ?></font></strong></td>
</tr>
</table>
<br />
<center>
<?php if (@$sExport == "") { ?>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="layer_dailyreport.php?export=html&date=<?php echo $getdate; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="layer_dailyreport.php?export=excel&date=<?php echo $getdate; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="layer_dailyreport.php?export=word&date=<?php echo $getdate; ?>">Export to Word</a><br /><br />
<?php } else { ?>
<?php } ?>

<?php if (@$sExport == "") { ?>
</div></td></tr>
<!-- Top Container (End) -->
<tr>
	<!-- Left Container (Begin) -->
	<td valign="top"><div id="ewLeft" class="phpreportmaker">
	<!-- Left slot -->
	</div></td>
	<!-- Left Container (End) -->
	<!-- Center Container - Report (Begin) -->
	<td valign="top" class="ewPadding"><div id="ewCenter" class="phpreportmaker">
	<!-- center slot -->
<?php } ?>

<?php 

if($getdate)
  $comparedate = date("Y-m-d",strtotime($getdate));
else
$comparedate = date("Y-m-d");
$query = "select flockcode,narration from layer_narration where date = '$comparedate'";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
$narration[$res['flockcode']] = $res['narration'];
?>
<!-- summary report starts -->
<div id="report_summary">
<table align="center" class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<form action="dailyreport.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr>
<td>
<span class="phpreportmaker">
Date&nbsp;
<input type="text" class="datepicker" id="date1" name="date1" value="<?php if($getdate) { echo $getdate; } else { echo date("d.m.y"); }  ?>" onchange="document.location='layer_dailyreport.php?date=' + this.value;" />
&nbsp;&nbsp;&nbsp;
</span>
</td>


<td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="layer_dailyreport.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="layer_dailyreport.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="layer_dailyreport.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="layer_dailyreport.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpreportmaker">&nbsp;of <?php echo $Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpreportmaker"> <?php echo $Pager->FromIndex ?> to <?php echo $Pager->ToIndex ?> of <?php echo $Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($sFilter == "0=101") { ?>
	<span class="phpreportmaker">Please enter search criteria</span>
	<?php } else { ?>
	<span class="phpreportmaker">No records found</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($nTotalGrps > 0) { ?>
		<td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<!-- <td align="right" valign="top" nowrap><span class="phpreportmaker">Groups Per Page&nbsp;
<select name="<?php echo EW_REPORT_TABLE_GROUP_PER_PAGE; ?>" onChange="this.form.submit();" class="phpreportmaker">
<option value="1"<?php if ($nDisplayGrps == 1) echo " selected" ?>>1</option>
<option value="2"<?php if ($nDisplayGrps == 2) echo " selected" ?>>2</option>
<option value="3"<?php if ($nDisplayGrps == 3) echo " selected" ?>>3</option>
<option value="4"<?php if ($nDisplayGrps == 4) echo " selected" ?>>4</option>
<option value="5"<?php if ($nDisplayGrps == 5) echo " selected" ?>>5</option>
<option value="10"<?php if ($nDisplayGrps == 10) echo " selected" ?>>10</option>
<option value="20"<?php if ($nDisplayGrps == 20) echo " selected" ?>>20</option>
<option value="50"<?php if ($nDisplayGrps == 50) echo " selected" ?>>50</option>
<option value="ALL"<?php if (@$_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE] == -1) echo " selected" ?>>All</option>
</select>
		</span></td> -->
<?php } ?>
	</tr>
</table>
</form>
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0">
<?php

// Set the last group to display if not export all
if (EW_REPORT_EXPORT_ALL && @$sExport <> "") {
	$nStopGrp = $nTotalGrps;
} else {
	$nStopGrp = $nStartGrp + $nDisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($nStopGrp) > intval($nTotalGrps))
	$nStopGrp = $nTotalGrps;
$nRecCount = 0;

// Get first row
if ($nTotalGrps > 0) {
	GetRow(1);
	$nGrpCount = 1;
}
while (($rs && !$rs->EOF) || $bShowFirstHeader) {

	// Show header
	if ($bShowFirstHeader) {
?>
	<thead>

	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
	}
	$nRecCount++;


		$sItemRowClass = " class=\"ewTableRow\"";
		$sItemRowClass1 = " class=\"ewTableAltRow\"";
?>


<tr>
	<td class="ewTableHeader">Flock</td>
         <?php 
		 $olddate = $comparedate;
  $olddate = strtotime($comparedate) - (24 * 60 * 60);
  $olddate = date("Y-m-d",$olddate);
            $f = 0;
            
            $q = "select distinct(flock) from layer_consumption where date2 = '$comparedate' and client = '$client'   order by flock"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
              $flo[$f] = $qr['flock'];
			  $qb = "SELECT breed FROM layer_flock WHERE flockcode = '$qr[flock]'";
  			  $rb = mysql_query($qb,$conn1); 
  			  while($rb1 = mysql_fetch_assoc($rb))  
  				{
 				 $breedi = $rb1['breed'];
 				 }
				  $breed[$f] = $breedi;
         ?>
	     <td class="ewTableHeader"><?php echo $qr['flock']; ?></td>
         <?php $f = $f + 1; }   
		 $f = 0;
		  $q = "select distinct(flock) from layer_consumption where date2 = '$olddate' and client = '$client'   order by flock"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
              $flo1[$f] = $qr['flock'];
         ?>
	     <?php $f = $f + 1; } ?>   
	<td class="ewTableHeader">Total</td>

</tr>


<tr>
	<td<?php echo $sItemRowClass1; ?>>Age</td>
         <?php 
            $s = 0;
            
            $q = "select age from layer_consumption where date2 = '$comparedate' and client = '$client' group by flock order by flock"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
              $age = $qr['age'];
              //$age1 = $age % 7; 
              //$age = round($age / 7);
              $nrSeconds = $age * 24 * 60 * 60;
              $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
              $nrWeeksPassed = floor($nrSeconds / 604800); 
              $nrYearsPassed = floor($nrSeconds / 31536000); 
         ?>
	     <td<?php echo $sItemRowClass1; ?>><?php echo $age1[$s] = $nrWeeksPassed; ?>.<?php echo $nrDaysPassed; ?></td>
         <?php $s = $s + 1; } ?>   
	<td<?php echo $sItemRowClass1; ?>>&nbsp;</td>
</tr>

<tr>
	<td<?php echo $sItemRowClass; ?>>Feed (Kg's) &nbsp;&nbsp;</td>
         <?php 
            
            $feedtype = "'dummy'";
            $q = "select * from ims_itemcodes where cat = 'Layer Feed' and client = '$client'"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
              $feedtype = $feedtype . ",'" . $qr['code'] . "'";
            } 
            $q = "select sum(quantity) as 'quantity' from layer_consumption where itemcode in ($feedtype) and date2 = '$comparedate' and client = '$client'   group by flock order by flock"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
         ?>
	     <td<?php echo $sItemRowClass; ?>><?php echo $qr['quantity']; $finalfeed = $finalfeed + $qr['quantity']; ?></td>
         <?php } ?>   
	<td<?php echo $sItemRowClass; ?>><?php echo $finalfeed; ?></td>
</tr>

<?php
            $medicines = "''";
            $q = "select * from ims_itemcodes where cat = 'Medicines' and client = '$client'  "; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
              $medicines = $medicines . ",'" . $qr['code'] . "'";
            } 

            $vaccines = "''";
            $q = "select * from ims_itemcodes where cat = 'Vaccines' and client = '$client'  "; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
              $vaccines = $vaccines . ",'" . $qr['code'] . "'";
            } 

            $q = "select * from layer_consumption where itemcode in ($medicines) and date2 = '$comparedate' and client = '$client'   group by flock order by flock"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
            $medcount = mysql_num_rows($qrs);

            $q = "select * from layer_consumption where itemcode in ($vaccines) and date2 = '$comparedate' and client = '$client'   group by flock order by flock"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
            $vaccount = mysql_num_rows($qrs);
			
			$q = "select * from layer_consumption where fweight > 0 and date2 = '$comparedate' and client = '$client'   group by flock order by flock"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
            $bodyweightcount = mysql_num_rows($qrs);
         
		 $q = "select * from layer_consumption where water > 0 and date2 = '$comparedate' and client = '$client'   group by flock order by flock"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
            $watercount = mysql_num_rows($qrs);

         $q = "select * from layer_consumption where eggwt > 0 and date2 = '$comparedate' and client = '$client'   group by flock order by flock"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
            $eggwtcount = mysql_num_rows($qrs);
			
	    $q = "select * from layer_consumption where tempmin > 0 and date2 = '$comparedate' and client = '$client'   group by flock order by flock"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
            $tempmincount = mysql_num_rows($qrs);
 
          $q = "select * from layer_consumption where tempmax > 0 and date2 = '$comparedate' and client = '$client'   group by flock order by flock"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
            $tempmaxcount = mysql_num_rows($qrs);
			
	     $q = "select * from layer_consumption where avgwt > 0 and date2 = '$comparedate' and client = '$client'   group by flock order by flock"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
            $avgwtcount = mysql_num_rows($qrs);




?>

<?php if($medcount) { ?>
<tr>
	<td<?php echo $sItemRowClass; ?>>Medicine &nbsp;&nbsp;</td>
       <?php for($l = 0;$l < count($flo);$l++) { ?>
         <?php 
            
            $feedtype = "'dummy'";

            $q = "select * from layer_consumption where itemcode in ($medicines) and date2 = '$comparedate' and client = '$client'  and flock = '$flo[$l]'"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
            if(mysql_num_rows($qrs))
            {
		while($qr = mysql_fetch_assoc($qrs))
		{
                $medname = "";
                $q23 = "select * from ims_itemcodes where code = '$qr[itemcode]' and client = '$client'  "; 
  	          $qrs23 = mysql_query($q23,$conn1) or die(mysql_error());
 		    while($qr23 = mysql_fetch_assoc($qrs23))
		    {
                  $medname = $qr23['description'];
                }
         ?>
	     <td<?php echo $sItemRowClass; ?>><?php echo $medname . " : " .$qr['quantity']. " ".$qr['units']; ?></td>
         <?php } ?>   
        <?php } else { ?>
	     <td<?php echo $sItemRowClass; ?>>&nbsp;</td>
        <?php } ?>
       <?php } ?> 
	<td<?php echo $sItemRowClass; ?>>&nbsp;</td>
</tr>
<?php } ?>


<?php if($vaccount) { ?>
<tr>
	<td<?php echo $sItemRowClass; ?>>Vaccine &nbsp;&nbsp;</td>
       <?php for($l = 0;$l < count($flo);$l++) { ?>
         <?php 
            
            $feedtype = "'dummy'";

            $q = "select * from layer_consumption where itemcode in ($vaccines) and date2 = '$comparedate' and client = '$client'   and flock = '$flo[$l]'"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
            if(mysql_num_rows($qrs))
            {
		while($qr = mysql_fetch_assoc($qrs))
		{
                $vacname = "";
                $q23 = "select * from ims_itemcodes where code = '$qr[itemcode]' and client = '$client'  "; 
  	          $qrs23 = mysql_query($q23,$conn1) or die(mysql_error());
 		    while($qr23 = mysql_fetch_assoc($qrs23))
		    {
                  $vacname = $qr23['description'];
                }
         ?>
	     <td<?php echo $sItemRowClass; ?>><?php echo $vacname . " : " .$qr['quantity']. " ".$qr['units']; ?></td>
         <?php } ?>   
        <?php } else { ?>
	     <td<?php echo $sItemRowClass; ?>>&nbsp;</td>
        <?php } ?>
       <?php } ?> 
	<td<?php echo $sItemRowClass; ?>>&nbsp;</td>
</tr>
<?php } ?>

<?php
            $eggtype = "'dummy'";
            $q = "select * from ims_itemcodes where cat = 'Layer Eggs' and client = '$client'  "; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
              $eggtype = $eggtype . ",'" . $qr['code'] . "'";
            } 
            $st = 0;
            $sItemRowClass2 = $sItemRowClass1;
            $q = "select distinct(itemcode) from layer_production where itemcode in ($eggtype) and client = '$client'  and date1 = '$comparedate'  order by itemcode"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
              $q12 = "select * from ims_itemcodes where code = '$qr[itemcode]' and client = '$client'  "; 
     		  $qrs12 = mysql_query($q12,$conn1) or die(mysql_error());
		  while($qr12 = mysql_fetch_assoc($qrs12))
		  {
                $idesc = $qr12['description'];
              }
?>
<tr>
	<td<?php echo $sItemRowClass2; ?>><?php echo $qr['itemcode']; ?><br />(<?php echo $idesc; ?>)</td>
       <?php for($l = 0;$l < count($flo);$l++) { ?>
         <?php 
            
            $q1 = "select sum(quantity) as 'quantity' from layer_production where itemcode = '$qr[itemcode]' and client = '$client'  and flock = '$flo[$l]' and date1 = '$comparedate' group by flock order by flock"; 
  		$qrs1 = mysql_query($q1,$conn1) or die(mysql_error());
            if(mysql_num_rows($qrs1))
            {
              
		  while($qr1 = mysql_fetch_assoc($qrs1))
		  {
         ?>
	          <td<?php echo $sItemRowClass2; ?>><?php echo $qr1['quantity']; $finaleggs = $finaleggs + $qr1['quantity']; ?></td>
         <?php } } else { ?>   
	          <td<?php echo $sItemRowClass2; ?>><?php echo "0"; $finaleggs = $finaleggs; ?></td>
         <?php } ?>
       <?php } ?>
	<td<?php echo $sItemRowClass2; ?>><?php echo $finaleggs; $finaleggs = 0; ?></td>
</tr>
<?php
  $st = $st + 1;
  if($st % 2) { $sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; }
}  

?>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass1; } else { $sItemRowClass2 = $sItemRowClass; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Total Eggs</td>
  <?php for($l = 0;$l < count($flo);$l++) { ?>
         <?php 
           //$l = 0;
            
            $q = "select sum(quantity) as 'quantity' from layer_production where itemcode in ($eggtype) and client = '$client'  and date1 = '$comparedate' and flock = '$flo[$l]' group by flock order by flock"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
            if(mysql_num_rows($qrs))
            {
  		 while($qr = mysql_fetch_assoc($qrs))
		 {
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $tegg[$l] = $qr['quantity']; $fegg = $fegg + $qr['quantity']; ?></td>
         <?php } } else { ?>   
	          <td<?php echo $sItemRowClass2; ?>><?php echo "0";$fegg = $fegg ; ?></td>
 <?php } } ?>
	<td<?php echo $sItemRowClass2; ?>><?php echo $fegg; ?></td>
</tr>

<?php
  $olddate = $comparedate;
  $olddate = strtotime($comparedate) - (24 * 60 * 60);
  $olddate = date("Y-m-d",$olddate);
?>

  <?php for($l = 0;$l < count($flo1);$l++) { ?>
         <?php 
            
           $q1a = "select sum(quantity) as 'quantity' from layer_production where itemcode in ($eggtype) and client = '$client'  and date1 = '$olddate' and flock = '$flo1[$l]' group by flock order by flock"; 
  		$qrs1a = mysql_query($q1a,$conn1) or die(mysql_error());
            if(mysql_num_rows($qrs1a))
            {
  		 while($qr1a = mysql_fetch_assoc($qrs1a))
		 {
         ?>
	     <?php $tegg1a[$l] = $qr1a['quantity']; $fegg1a = $fegg1a + $qr1a['quantity']; ?>
         <?php } } else { ?>   
	          <?php  "0";$fegg1a = $fegg1a ; ?>
 <?php } } ?>
	<?php  $fegg1a; ?>


         <?php 
             
            for($f = 0;$f<count($flo1);$f++)
            {
             $q1a = "select * from layer_flock where flockcode = '$flo1[$f]' and client = '$client'  "; 
    		 $qrs1a = mysql_query($q1a,$conn1) or die(mysql_error());
		 while($qr1a = mysql_fetch_assoc($qrs1a))
		 {
               $q11a = "select * from layer_shed where shedcode = '$qr1a[shedcode]' and client = '$client'  "; 
     		   $qrs11a = mysql_query($q11a,$conn1) or die(mysql_error());
 		   while($qr11a = mysql_fetch_assoc($qrs11a))
 		   {
                  $shedtype1a = $qr11a['shedtype'];
               }
             }

             $q1a = "select * from layer_flock where flockcode = '$flo1[$f]' and client = '$client'  "; 
    		 $qrs1a = mysql_query($q1a,$conn1) or die(mysql_error());
		 while($qr1a = mysql_fetch_assoc($qrs1a))
		 {
                $fopening1a = $qr1a['femaleopening'];
             }
             

 
             $minus1a = 0; 
             $q1a = "select distinct(date2),fmort,fcull from layer_consumption where flock = '$flo1[$f]' and client = '$client'  and client = '$client'  and date2 < '$olddate' "; 
    		 $qrs1a = mysql_query($q1a,$conn1) or die(mysql_error());
		 while($qr1a = mysql_fetch_assoc($qrs1a))
		 {
                $minus1a = $minus1a + $qr1a['fmort'] + $qr1a['fcull'];
             }


             $q1a = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat IN ('Layer Birds','Layer Chicks') and client = '$client'  and fromwarehouse = '$flo1[$f]' and date < '$olddate'"; 
    		 $qrs1a = mysql_query($q1a,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs1a))
             {
		   while($qr1a = mysql_fetch_assoc($qrs1a))
    		   {
                $ftransfer1a = $qr1a['quantity'];
               }
             }
             else
             {
                $ftransfer1a = 0;
             } 




             $q1a = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat IN ('Layer Birds','Layer Chicks') and client = '$client'  and towarehouse = '$flo1[$f]' and date < '$olddate'"; 
    		 $qrs1a = mysql_query($q1a,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs1a))
             {
		   while($qr1a = mysql_fetch_assoc($qrs1a))
    		   {
                $ttransfer1a = $qr1a['quantity'];
               }
             }
             else
             {
                $ttransfer1a = 0;
             } 

             $qwe = "select sum(quantity) as 'quantity' from oc_cobi where flock = '$flo[$f]' and description = 'Layer BIRDS' and client = '$client'  and date < '$comparedate'"; 
    		 $qrswe = mysql_query($qwe,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrswe))
             {
		   while($qrwe = mysql_fetch_assoc($qrswe))
    		   {
                $tsale1a = $qrwe['quantity'];
               }
             }
             else
             {
                $tsale1a = 0;
             } 
             if($client == "STR")
			 {
			   $qwe = "select sum(receivedquantity) as 'quantity' from pp_sobi where flock = '$flo[$f]' and client = '$client'  and date <= '$comparedate'"; 
    		 $qrswe = mysql_query($qwe,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrswe))
             {
		   while($qrwe = mysql_fetch_assoc($qrswe))
    		   {
                $tpurchase1a = $qrwe['quantity'];
               }
             }
             else
             {
                $tpurchase1a = 0;
             } 
  	    }


			if($client == "STR")
			{
			$remaining1a = ($fopening1a - $minus1a - $ftransfer1a + $ttransfer1a) - $tsale1a + $tpurchase1a;
			}
			else
			{
			$remaining1a = ($fopening1a - $minus1a - $ftransfer1a + $ttransfer1a) - $tsale1a;
			}

             //$remaining1a = $fopening1a - $minus1a - $ftransfer1a + $ttransfer1a;
         ?>
	     <?php $remaining1a; if($shedtype1a == "CHICK" || $shedtype1a == "GROWER") { $chickopening1a = $chickopening1a + $remaining1a; } $finalrem1a = $finalrem1a + $remaining1a; ?>
         <?php }  ?>   
	   <?php $finalrem1a;  $finalopen1a = $finalrem1a; ?>




<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Opening Birds</td>
         <?php 
            
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select * from layer_flock where flockcode = '$flo[$f]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
               $q1 = "select * from layer_shed where shedcode = '$qr[shedcode]' and client = '$client'  "; 
     		   $qrs1 = mysql_query($q1,$conn1) or die(mysql_error());
 		   while($qr1 = mysql_fetch_assoc($qrs1))
 		   {
                  $shedtype = $qr1['shedtype'];
               }
             }

             $q = "select * from layer_flock where flockcode = '$flo[$f]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $fopening = $qr['femaleopening'];
             }
             

 
             $minus = 0; 
			 
             $q = "select distinct(date2),fmort,fcull from layer_consumption where flock = '$flo[$f]' and client = '$client'  and date2 < '$comparedate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $minus = $minus + $qr['fmort'] + $qr['fcull'];
             }


             $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat IN ('Layer Birds','Layer Chicks') and client = '$client'  and fromwarehouse = '$flo[$f]' and date < '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ftransfer = $qr['quantity'];
               }
             }
             else
             {
                $ftransfer = 0;
             } 

             $q = "select sum(quantity) as 'quantity' from oc_cobi where flock = '$flo[$f]' and  description = 'Layer BIRDS' and client = '$client'  and date < '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $tsale = $qr['quantity'];
               }
             }
             else
             {
                $tsale = 0;
             } 
             
			   $q = "select sum(receivedquantity) as 'quantity' from pp_sobi where flock = '$flo[$f]' and client = '$client'  and date < '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $tpurchase = $qr['quantity'];
               }
             }
             else
             {
                $tpurchase = 0;
             } 
			
			  

             $q = "select ( sum(quantity) - sum(tmort) )as 'quantity' from ims_stocktransfer where cat IN ('Layer Birds','Layer Chicks') and client = '$client'  and towarehouse = '$flo[$f]' and date < '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ttransfer = $qr['quantity'];
               }
             }
             else
             {
                $ttransfer = 0;
             } 
            // echo $flo[$f];echo "&nbsp;";
			 //echo $fopening; echo "&nbsp;";
			 //echo $minus; echo "&nbsp;";
			 //echo "ft".$ftransfer; echo "&nbsp;";
			 //echo "tt".$ttransfer; echo "</br>";
			
			 $remaining = ($fopening - $minus - $ftransfer + $ttransfer) - $tsale + $tpurchase;
			
             
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $bopen[$f] = $remaining; if($shedtype == "CHICK" || $shedtype == "GROWER") { $chickopening = $chickopening + $remaining; } $finalrem = $finalrem + $remaining; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>><?php echo $finalrem; $finalopen = $finalrem; ?></td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass; ?>>Feed / Bird (Grams) &nbsp;&nbsp;</td>
         <?php 
            
            $feedtype1 = "'dummy'";
            $q = "select * from ims_itemcodes where cat = 'Layer Feed' and client = '$client'"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
              $feedtype1 = $feedtype1 . ",'" . $qr['code'] . "'";
            } 
            $z = 0;
            $q = "select sum(quantity) as 'quantity' from layer_consumption where itemcode in ($feedtype1) and date2 = '$comparedate' and client = '$client'   group by flock order by flock"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
         ?>
	     <td<?php echo $sItemRowClass; ?>><?php echo round(($qr['quantity'] / $bopen[$z]) * 1000,2); $finalfeed12 = $finalfeed12 + $qr['quantity']; ?></td>
         <?php $z = $z + 1; } ?>   
	<td<?php echo $sItemRowClass; ?>>&nbsp;</td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Mortality</td>
         <?php 
            
            $q = "select fmort from layer_consumption where date2 = '$comparedate' and client = '$client'   group by flock order by flock"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $qr['fmort']; $finalmort = $finalmort + $qr['fmort']; ?></td>
         <?php } ?>   
	<td<?php echo $sItemRowClass2; ?>><?php echo $finalmort; ?></td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Culls</td>
         <?php 
            
            $q = "select fcull from layer_consumption where date2 = '$comparedate' and client = '$client'   group by flock order by flock"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $qr['fcull']; $finalcull = $finalcull + $qr['fcull']; ?></td>
         <?php } ?>   
	<td<?php echo $sItemRowClass2; ?>><?php echo $finalcull; ?></td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Transfered In Birds</td>
         <?php 
            
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select ( sum(quantity) - sum(tmort) ) as 'quantity' from ims_stocktransfer where cat IN ('Layer Birds','Layer Chicks') and client = '$client'  and towarehouse = '$flo[$f]' and date = '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ttransfer = $qr['quantity'];
               }
             }
             else
             {
                $ttransfer = 0;
             } 
             if($ttransfer == "") { $ttransfer = 0; }
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $ttransfer;  ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>


<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Transfered Out Birds</td>
         <?php 
            
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat IN ('Layer Birds','Layer Chicks') and client = '$client'  and fromwarehouse = '$flo[$f]' and date = '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ftransfer = $qr['quantity'];
               }
             }
             else
             {
                $ftransfer = 0;
             } 
             if($ftransfer == "") { $ftransfer = 0; }

         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $ftransfer;  ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Sale Of Birds</td>
         <?php 
            
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select sum(quantity) as 'quantity' from oc_cobi where flock = '$flo[$f]' and  description = 'Layer BIRDS' and client = '$client'  and date = '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $tsale = $qr['quantity'];
               }
             }
             else
             {
                $tsale = 0;
             } 
             if($tsale == "") { $tsale = 0; }
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $tsale; $finalsale = $finalsale + $tsale;  ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>><?php echo $finalsale; ?></td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Closing Birds</td>
         <?php 
            
            $fopening = 0; $ftransfer = 0; $ttransfer = 0; $finalrem = 0;
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select * from layer_flock where flockcode = '$flo[$f]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $fopening = $qr['femaleopening'];
             }

             $minus = 0; 
             $q = "select distinct(date2),fmort,fcull from layer_consumption where flock = '$flo[$f]' and client = '$client'  and date2 <= '$comparedate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $minus = $minus + $qr['fmort'] + $qr['fcull'];
             }


             $q = "select  sum(quantity) as 'quantity' from ims_stocktransfer where cat IN ('Layer Birds','Layer Chicks') and client = '$client'  and fromwarehouse = '$flo[$f]' and date <= '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ftransfer = $qr['quantity'];
               }
             }
             else
             {
                $ftransfer = 0;
             } 


             $q = "select sum(quantity) as 'quantity' from oc_cobi where flock = '$flo[$f]' and  description = 'Layer BIRDS' and client = '$client'  and date <= '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $tsale = $qr['quantity'];
               }
             }
             else
             {
                $tsale = 0;
             } 

             $q = "select  sum(quantity) as 'quantity' from ims_stocktransfer where cat IN ('Layer Birds','Layer Chicks') and client = '$client'  and towarehouse = '$flo[$f]' and date <= '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ttransfer = $qr['quantity'];
               }
             }
             else
             {
                $ttransfer = 0;
             } 
			 if($client == "STR")
			 {
			   $q = "select sum(receivedquantity) as 'quantity' from pp_sobi where flock = '$flo[$f]' and client = '$client'  and date <= '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $tpurchase = $qr['quantity'];
               }
             }
             else
             {
                $tpurchase = 0;
             } 
			 }
			  
             if($client == "STR")
			 {
			 $remaining = ($fopening - $minus - $ftransfer + $ttransfer) - $tsale + $tpurchase;
			 }
			 else
			 {
			 $remaining = ($fopening - $minus - $ftransfer + $ttransfer) - $tsale;
			 }

             
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $remaining; $finalrem = $finalrem + $remaining; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>><?php echo $finalrem; ?></td>
</tr>

<?php if ($bodyweightcount > 0) { ?>
<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Body Weight</td>
         <?php 
            
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select fweight from layer_consumption where flock = '$flo[$f]' and client = '$client'  and date2 = '$comparedate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $fweight = $qr['fweight'];
             }
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $fweight; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>
<?php } ?>
<?php if ($watercount > 0) { ?>
<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Water</td>
         <?php 
            
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select water from layer_consumption where flock = '$flo[$f]' and client = '$client'  and date2 = '$comparedate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $water = $qr['water'];
             }
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $water; $twater = $twater + $water; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>><?php echo $twater; ?></td>
</tr>
<?php } ?>
<?php if ($eggwtcount > 0) { ?>
<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Egg Weight</td>
         <?php 
            
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select eggwt from layer_consumption where flock = '$flo[$f]' and client = '$client'  and date2 = '$comparedate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $eggwt = $qr['eggwt'];
             }
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $eggwt; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>
<?php } ?>
<?php if ($avgwtcount > 0) { ?>
<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Average Weight</td>
         <?php 
            
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select avgwt from layer_consumption where flock = '$flo[$f]' and client = '$client'  and date2 = '$comparedate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $avgwt = $qr['avgwt'];
             }
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $avgwt; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>
<?php } ?>
<?php if ($tempmincount > 0) { ?>
<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Min. Temperature</td>
         <?php 
            
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select tempmin,tempmax from layer_consumption where flock = '$flo[$f]' and client = '$client'  and date2 = '$comparedate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $temperature = $qr['tempmin'];
             }
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $temperature; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>
<?php } ?>
<?php if ($tempmaxcount > 0) { ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Max. Temperature</td>
         <?php 
            
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select tempmin,tempmax from layer_consumption where flock = '$flo[$f]' and client = '$client'  and date2 = '$comparedate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $temperature = $qr['tempmax'];
             }
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $temperature; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>
<?php } ?>
<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Production %</td>
         <?php 
            
            for($f = 0;$f<count($flo);$f++)
            {
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo round(($tegg[$f]/$bopen[$f]) * 100,2); ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Std. Production %</td>
         <?php
            
            for($f = 0;$f<count($flo);$f++)
            {
             if($age1[$f] >= 72) { $age1[$f] = 72; }
             $q = "select * from layer_pstandards where age = '$age1[$f]' and breed = '$breed[$f]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $henday = $qr['henday'];
             }
             }
             else { $henday = 0; }
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $henday; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>
<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Remarks</td>
         <?php
            
            for($f = 0;$f<count($flo);$f++)
            {
                         
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php if($narration[$flo[$f]]) echo $narration[$flo[$f]]; else echo "&nbsp;"; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>

<!--

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Consumption Cost</td>
         <?php 
            
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select price from layer_consumption where flock = '$flo[$f]' and client = '$client'  and date2 = '$comparedate' limit 1"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $camount[$f] = round($qr['price'],2);
             }
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $camount[$f]; $finalcamount = $finalcamount + $camount[$f]; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>><?php echo $finalcamount; ?></td>
</tr>



<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Production Cost</td>
         <?php 
            
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select price from layer_production where flock = '$flo[$f]' and client = '$client'  and date1 = '$comparedate' limit 1"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs)) {
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $pamount[$f] = round($qr['price'],2);
             }
             }
             else { $pamount[$f] = 0; }
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $pamount[$f]; $finalpamount = $finalpamount + $pamount[$f]; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>><?php echo $finalpamount; ?></td>
</tr>


<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Price Varience</td>
         <?php 
            
            for($f = 0;$f<count($flo);$f++)
            {
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $pamount[$f] - $camount[$f]; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>><?php echo $finalpamount - $finalcamount; ?></td>
</tr>
-->

<?php

		// Accumulate page summary
		AccumulateSummary();

		// Get next record
		GetRow(2);
	$nGrpCount++;
} // End while
?>
	</tbody>
	<tfoot>
<?php

	// Get total count from sql directly
	$sSql = ewrpt_BuildReportSql($EW_REPORT_TABLE_SQL_SELECT_COUNT, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY, $EW_REPORT_TABLE_SQL_HAVING, $EW_REPORT_TABLE_SQL_ORDERBY, $sFilter, @$sSort);
	$rstot = $conn->Execute($sSql);
	if ($rstot)
		$rstotcnt = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
	else
		$rstotcnt = 0;

	// Get total from sql directly
	$sSql = ewrpt_BuildReportSql($EW_REPORT_TABLE_SQL_SELECT_AGG, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY, $EW_REPORT_TABLE_SQL_HAVING, $EW_REPORT_TABLE_SQL_ORDERBY, $sFilter, @$sSort);
	$sSql = $EW_REPORT_TABLE_SQL_AGG_PFX . $sSql . $EW_REPORT_TABLE_SQL_AGG_SFX;

	//echo "sql: " . $sSql . "<br>";
	$rsagg = $conn->Execute($sSql);
	if ($rsagg) {
	}
	else {

		// Accumulate grand summary from detail records
		$sSql = ewrpt_BuildReportSql($EW_REPORT_TABLE_SQL_SELECT, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY, $EW_REPORT_TABLE_SQL_HAVING, $EW_REPORT_TABLE_SQL_ORDERBY, "", "");
		$rs = $conn->Execute($sSql);
		if ($rs) {
			GetRow(1);
			while (!$rs->EOF) {
				AccumulateGrandSummary();
				GetRow(2);
			}
		}
	}
?>
<?php if ($nTotalGrps > 0) { ?>
	<!-- tr><td colspan="1"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<!-- <tr class="ewRptGrandSummary"><td colspan="1">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr> -->
<?php } ?>
	</tfoot>
</table>


</div>
<?php if($_SESSION['db'] != 'albustanlayer')
{
 if ($nTotalGrps > 0) { ?>
<div class="ewGridLowerPanel">
<form action="dailyreport.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table>
  <tr height="15px"><td></td></tr>
  <tr><td colspan="8">&nbsp;</td><td colspan="4"><center><b>Excluding Chicks & Growers</b></center></td><td colspan="4"><center><b>Including Chicks & Growers</b></center></td></tr>
  <tr height="15px"><td></td></tr>  
  <tr>
    <td>Total Production</td><td width="15px"></td><td><?php echo $fegg; ?></td>
    <td width="25px"></td>
    <td>Total Feed</td><td width="15px"></td><td><?php echo $finalfeed; ?></td>
    <td width="25px"></td>
    <td>Production %</td><td width="15px"></td><td><?php echo $a1 = round(($fegg / ($finalopen - $chickopening)) * 100,2);  ?></td>
    <td width="25px"></td>
    <td>Production %</td><td width="15px"></td><td><?php echo $b1 = round(($fegg / $finalopen) * 100,2); ?></td>
  </tr>
  <tr>
    <td>Eggs per 1 Ton Feed</td><td width="15px"></td><td><?php echo round($fegg / ($finalfeed/1000)); ?></td>
    <td width="25px"></td>
    <td>Feed per 1 Egg(grams)</td><td width="15px"></td><td><?php echo round((($finalfeed * 1000) / $fegg) /1000,3) * 1000; ?></td>
    <td width="25px"></td>
    <td>Prev. Day Production %</td><td width="15px"></td><td><?php echo $a2 = round(($fegg1a / ($finalopen1a - $chickopening1a)) * 100,2);   ?></td>
    <td width="25px"></td>
    <td>Prev. Day Production %</td><td width="15px"></td><td><?php echo $b2 = round(($fegg1a / $finalopen1a) * 100,2); ?></td>
  </tr>

  <tr>
    <td></td><td width="15px"></td><td></td>
    <td width="25px"></td>
    <td></td><td width="15px"></td><td></td>
    <td width="25px"></td>
    <td>Difference %</td><td width="15px"></td><td <?php if(($a1 - $a2) < 0) { ?>style="color:red"<?php } else { ?>style="color:green"<?php } ?>><?php echo round($a1 - $a2,2); ?></td>
    <td width="25px"></td>
    <td>Difference %</td><td width="15px"></td><td <?php if(($b1 - $b2) < 0) { ?>style="color:red"<?php } else { ?>style="color:green"<?php } ?>><?php echo round($b1 - $b2,2); ?></td>
  </tr>

  <tr style="display:none">
    <td colspan="3"><center><b>Today Egg Rates (For 100 Eggs)</b></center></td>
    <td width="25px"></td>
    <td colspan=""></td>
    <td></td><td width="15px"></td><td></td>
    <td width="25px"></td>
    <td></td><td width="15px"></td><td></td>
    <td width="25px"></td>
    <td></td><td width="15px"></td><td></td>
  </tr>

<?php
             $q = "select * from common_rates where location = 'Hyderabad' and client = '$client'  and date = '$comparedate' and type = 'Egg' limit 1"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs)) {
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $hyderabad = $qr['rate'];
             }
             } else { $hyderabad = "-"; }

             $q = "select * from common_rates where location = 'Warangal' and client = '$client'  and date = '$comparedate' and type = 'Egg' limit 1"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs)) {
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $warangal = $qr['rate'];
             }
             } else { $warangal = "-"; }

             $q = "select * from common_rates where location = 'Delhi (CC)' and client = '$client'  and date = '$comparedate' and type = 'Egg' limit 1"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs)) {
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $delhi = $qr['rate'];
             }
             } else { $delhi = "-"; }

             $q = "select * from common_rates where location = 'Barwala' and client = '$client'  and date = '$comparedate' and type = 'Egg' limit 1"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs)) {
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $barwala = $qr['rate'];
             }
             } else { $barwala = "-"; }

             $q = "select * from common_rates where location = 'Punjab' and client = '$client'  and date = '$comparedate' and type = 'Egg' limit 1"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs)) {
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $punjab = $qr['rate'];
             }
             } else { $punjab = "-"; }

             $q = "select * from common_rates where location = 'Banglore (CC)' and client = '$client'  and date = '$comparedate' and type = 'Egg' limit 1"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs)) {
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $bangalore = $qr['rate'];
             }
             } else { $bangalore = "-"; }

             $q = "select * from common_rates where location = 'Hospet' and client = '$client'  and date = '$comparedate' and type = 'Egg' limit 1"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs)) {
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $hospet = $qr['rate'];
             }
             } else { $hospet = "-"; }

             $q = "select * from common_rates where location = 'Namakkal' and client = '$client'  and date = '$comparedate' and type = 'Egg' limit 1"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs)) {
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $namakkal = $qr['rate'];
             }
             } else { $namakkal = "-"; }
?>
<?php if($_SESSION['client'] == "NITISHA") { ?>
  <tr style="display:none">
    <td>Hyderabad</td><td width="15px"></td><td><?php echo $hyderabad; ?></td>
    <td width="25px"></td>
    <td></td><td width="15px"></td><td><?php ?></td>
    <td width="25px"></td>
    <td></td><td width="15px"></td><td></td>
    <td width="25px"></td>
    <td></td><td width="15px"></td><td></td>
  </tr>
<?php } else if($_SESSION['client'] == "MRPF" || $_SESSION['client'] == "VPF" ) { ?>
  <tr style="display:none">
    <td>Hyderabad</td><td width="15px"></td><td><?php echo $hyderabad; ?></td>
    <td width="25px"></td>
    <td>Warangal</td><td width="15px"></td><td><?php echo $warangal; ?></td>
    <td width="25px"></td>
    <td></td><td width="15px"></td><td></td>
    <td width="25px"></td>
    <td></td><td width="15px"></td><td></td>
  </tr>
<?php } else if($_SESSION['client'] == "KIPFPUN" ) { ?>

  <tr style="display:none">
    <td>Barwala</td><td width="15px"></td><td><?php echo $barwala; ?></td>
    <td width="25px"></td>
    <td>Punjab</td><td width="15px"></td><td><?php echo $punjab; ?></td>
    <td width="25px"></td>
    <td>Delhi</td><td width="15px"></td><td><?php echo $delhi; ?></td>
    <td width="25px"></td>
    <td></td><td width="15px"></td><td></td>
  </tr>
<?php } else { ?>
  <tr style="display:none">
    <td>Bangalore</td><td width="15px"></td><td><?php echo $bangalore; ?></td>
    <td width="25px"></td>
    <td>Namakkal</td><td width="15px"></td><td><?php echo $namakkal; ?></td>
    <td width="25px"></td>
    <td>Hospet</td><td width="15px"></td><td><?php echo $hospet; ?></td>
    <td width="25px"></td>
    <td></td><td width="15px"></td><td></td>
  </tr>
<?php } ?>
</table>
<br />
<br />
<hr />
<br />
<table>
<tr>
    <td></td><td width="15px"></td>
    <td><b>Op. Balance</b></td><td width="15px"></td>
    <td><b>Receipts</b></td><td width="15px"></td>
    <td><b>Payment</b></td><td width="15px"></td>
    <td><b>Cl. Balance</b></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td><b>Op. Balance</b></td><td width="15px"></td>
    <td><b>Production</b></td><td width="15px"></td>
    <td><b>Dt. Sales</b></td><td width="15px"></td>
    <td><b>Cl. Balance</b></td><td width="15px"></td>
</tr>
<tr height="5px"><td></td></tr>
<tr>
    <td><b>Cash</b></td><td width="15px"></td>
    <td><?php echo changeprice($obal); ?></td><td width="15px"></td>
    <td><?php echo changeprice($drtotal); ?></td><td width="15px"></td>
    <td><?php echo changeprice($crtotal); ?></td><td width="15px"></td>
    <td><?php echo changeprice($clbal); ?></td><td width="15px"></td>
    <td><b></b></td><td width="15px"></td>
    <td><b>Eggs</b></td><td width="15px"></td>
    <td><?php echo changeprice1($teggobl); ?></td><td width="15px"></td>
    <td><?php echo changeprice1($teggrecp); ?></td><td width="15px"></td>
    <td><?php echo changeprice1($teggissue); ?></td><td width="15px"></td>
    <td><?php echo changeprice1($teggobl + $teggrecp - $teggissue); ?></td><td width="15px"></td>
</tr>
</table>
<br />
<br />
<table>
<tr>
    <td><b>Name of the Bank</b></td><td width="15px"></td>
    <td><b>Opening Balance</b></td><td width="15px"></td>
    <td><b>Deposits</b></td><td width="15px"></td>
    <td><b>With Draws</b></td><td width="15px"></td>
    <td><b>Closing Balance</b></td><td width="15px"></td>
</tr>
<?php for($k = 0;$k < sizeof($bname);$k++) { ?>
<tr height="5px"><td></td></tr>
<tr>
    <td><?php echo "$bname[$k] ( $bcode[$k] )"; ?></td><td width="15px"></td>
    <td><?php echo changeprice($abobal[$k]); ?></td><td width="15px"></td>
    <td><?php echo changeprice($abdrtotal[$k]); ?></td><td width="15px"></td>
    <td><?php echo changeprice($abcrtotal[$k]); ?></td><td width="15px"></td>
    <td><?php echo changeprice($abclbal[$k]); ?></td><td width="15px"></td>
</tr>
<?php } ?>
</table>
<br />
<br />
<hr />
<br />
<br /><br /><br /><br /><br />
<br /><br /><br /><br /><br />
<br /><br /><br /><br /><br />
<br /><br /><br /><br /><br />

<b><u>Purchases</u></b><br /><br />
<table>
<tr>
    <td><b>Vendor</b></td><td width="15px"></td>
    <td><b>So #</b></td><td width="15px"></td>
    <td><b>Item Code</b></td><td width="15px"></td>
    <td><b>Item Description</b></td><td width="15px"></td>
    <td><b>Quantity</b></td><td width="15px"></td>
    <td><b>Price</b></td><td width="15px"></td>
    <td><b>Total Quantity</b></td><td width="15px"></td>
    <td><b>Amount</b></td><td width="15px"></td>
</tr>
<?php 

$q43 = "SELECT pp_sobi.vendor, pp_sobi.date, pp_sobi.so, pp_sobi.totalquantity, pp_sobi.grandtotal FROM pp_sobi where pp_sobi.date = '$fdate' and client = '$client' group by pp_sobi.vendor, pp_sobi.date, pp_sobi.so, pp_sobi.totalquantity, pp_sobi.grandtotal order by pp_sobi.vendor ASC, pp_sobi.date ASC"; 
$qrs43 = mysql_query($q43,$conn1) or die(mysql_error());
while($qr43 = mysql_fetch_assoc($qrs43))
{

$code = $description = $quantity = $price = "";
$q = "select * from pp_sobi where date = '$qr43[date]' and vendor = '$qr43[vendor]' and client = '$client' and so = '$qr43[so]' order by date asc";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
	$code.= $qr['code'] . "/";
	$description.= $qr['description'] . "/";
	$quantity.= $qr['receivedquantity'] . "/";
	$price.= $qr['rateperunit'] . "/";
	
}

$code = substr($code,0,-1);
$description = substr($description,0,-1);
$quantity = substr($quantity,0,-1);
$price = substr($price,0,-1);

?>
<tr height="5px"><td></td></tr>
<tr>
    <td><?php echo $qr43['vendor']; ?></td><td width="15px"></td>
    <td><?php echo $qr43['so']; ?></td><td width="15px"></td>
    <td><?php echo $code; ?></td><td width="15px"></td>
    <td><?php echo $description; ?></td><td width="15px"></td>
    <td><?php echo changeprice($quantity); ?></td><td width="15px"></td>
    <td><?php echo changeprice($price); ?></td><td width="15px"></td>
    <td><?php echo changeprice($qr43['totalquantity']); ?></td><td width="15px"></td>
    <td><?php echo changeprice($qr43['grandtotal']); ?></td><td width="15px"></td>
</tr>
<?php $ttq = $ttq + $qr43['totalquantity']; $tgt = $tgt + $qr43['grandtotal']; } ?>
<tr height="2px"><td></td></tr>
<tr>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td><hr /></td><td width="15px"></td>
    <td><hr /></td><td width="15px"></td>
</tr>
<tr height="2px"><td></td></tr>
<tr>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td><?php echo changeprice($ttq); $ttq = 0; ?></td><td width="15px"></td>
    <td><?php echo changeprice($tgt); $tgt = 0; ?></td><td width="15px"></td>
</tr>
</table>
<br />

<b><u>Sales</u></b>
<br /><br />
<table>
<tr>
    <td><b>Customer</b></td><td width="15px"></td>
    <td><b>Invoice</b></td><td width="15px"></td>
    <td><b>Item Code</b></td><td width="15px"></td>
    <td><b>Item Description</b></td><td width="15px"></td>
    <td><b>Quantity</b></td><td width="15px"></td>
    <td><b>Price</b></td><td width="15px"></td>
    <td><b>Total Quantity</b></td><td width="15px"></td>
    <td><b>Amount</b></td><td width="15px"></td>
</tr>
<?php 

$q43 = "SELECT * FROM oc_cobi where oc_cobi.date = '$fdate' and client = '$client' group by oc_cobi.party, oc_cobi.date, oc_cobi.invoice, oc_cobi.totalquantity, oc_cobi.finaltotal order by oc_cobi.code ASC, oc_cobi.date ASC, oc_cobi.party ASC"; 
$qrs43 = mysql_query($q43,$conn1) or die(mysql_error());
while($qr43 = mysql_fetch_assoc($qrs43))
{

$code = $description = $quantity = $price = "";
$q = "select * from oc_cobi where date = '$qr43[date]' and party = '$qr43[party]' and client = '$client' and invoice = '$qr43[invoice]' order by date asc";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
	$code.= $qr['code'] . "/";
	$description.= $qr['description'] . "/";
	$quantity.= $qr['quantity'] . "/";
	$price.= $qr['price'] . "/";
	
}

$code = substr($code,0,-1);
$description = substr($description,0,-1);
$quantity = substr($quantity,0,-1);
$price = substr($price,0,-1);

?>
<tr height="2px"><td></td></tr>
<tr>
    <td><?php echo $qr43['party']; ?></td><td width="15px"></td>
    <td><?php echo $qr43['invoice']; ?></td><td width="15px"></td>
    <td><?php echo $code; ?></td><td width="15px"></td>
    <td><?php echo $description; ?></td><td width="15px"></td>
    <td><?php echo changeprice($quantity); ?></td><td width="15px"></td>
    <td><?php echo changeprice($price); ?></td><td width="15px"></td>
    <td><?php echo changeprice($qr43['totalquantity']); ?></td><td width="15px"></td>
    <td><?php echo changeprice($qr43['finaltotal']); ?></td><td width="15px"></td>
</tr>
<?php $ttq = $ttq + $qr43['totalquantity']; $tgt = $tgt + $qr43['finaltotal']; } ?>
<tr height="2px"><td></td></tr>
<tr>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td><hr /></td><td width="15px"></td>
    <td><hr /></td><td width="15px"></td>
</tr>
<tr height="5px"><td></td></tr>
<tr>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td><?php echo changeprice($ttq); ?></td><td width="15px"></td>
    <td><?php echo changeprice($tgt); ?></td><td width="15px"></td>
</tr>
</table>


</form>
</div>
<?php } }?>
</td></tr></table>
</div>
<!-- Summary Report Ends -->
<?php if (@$sExport == "") { ?>
	</div><br /></td>
	<!-- Center Container - Report (End) -->
	<!-- Right Container (Begin) -->
	<td valign="top"><div id="ewRight" class="phpreportmaker">
	<!-- Right slot -->
	</div></td>
	<!-- Right Container (End) -->
</tr>
<!-- Bottom Container (Begin) -->
<tr><td colspan="3"><div id="ewBottom" class="phpreportmaker">
	<!-- Bottom slot -->
	</div><br /></td></tr>
<!-- Bottom Container (End) -->
</table>
<!-- Table Container (End) -->
<?php } ?>
<?php
$conn->Close();

// display elapsed time
if (defined("EW_REPORT_DEBUG_ENABLED"))
	echo ewrpt_calcElapsedTime($starttime);
?>
<?php include "phprptinc/footer.php"; ?>
<?php

// Accummulate summary
function AccumulateSummary() {
	global $smry, $cnt, $col, $val, $mn, $mx;
	$cntx = count($smry);
	for ($ix = 0; $ix < $cntx; $ix++) {
		$cnty = count($smry[$ix]);
		for ($iy = 1; $iy < $cnty; $iy++) {
			$cnt[$ix][$iy]++;
			if ($col[$iy]) {
				$valwrk = $val[$iy];
				if (is_null($valwrk) || !is_numeric($valwrk)) {

					// skip
				} else {
					$smry[$ix][$iy] += $valwrk;
					if (is_null($mn[$ix][$iy])) {
						$mn[$ix][$iy] = $valwrk;
						$mx[$ix][$iy] = $valwrk;
					} else {
						if ($mn[$ix][$iy] > $valwrk) $mn[$ix][$iy] = $valwrk;
						if ($mx[$ix][$iy] < $valwrk) $mx[$ix][$iy] = $valwrk;
					}
				}
			}
		}
	}
	$cntx = count($smry);
	for ($ix = 1; $ix < $cntx; $ix++) {
		$cnt[$ix][0]++;
	}
}

// Reset level summary
function ResetLevelSummary($lvl) {
	global $smry, $cnt, $col, $mn, $mx, $nRecCount;

	// Clear summary values
	$cntx = count($smry);
	for ($ix = $lvl; $ix < $cntx; $ix++) {
		$cnty = count($smry[$ix]);
		for ($iy = 1; $iy < $cnty; $iy++) {
			$cnt[$ix][$iy] = 0;
			if ($col[$iy]) {
				$smry[$ix][$iy] = 0;
				$mn[$ix][$iy] = NULL;
				$mx[$ix][$iy] = NULL;
			}
		}
	}
	$cntx = count($smry);
	for ($ix = $lvl; $ix < $cntx; $ix++) {
		$cnt[$ix][0] = 0;
	}

	// Clear old values
	// Reset record count

	$nRecCount = 0;
}

// Accummulate grand summary
function AccumulateGrandSummary() {
	global $cnt, $col, $val, $grandsmry, $grandmn, $grandmx;
	@$cnt[0][0]++;
	for ($iy = 1; $iy < count($grandsmry); $iy++) {
		if ($col[$iy]) {
			$valwrk = $val[$iy];
			if (is_null($valwrk) || !is_numeric($valwrk)) {

				// skip
			} else {
				$grandsmry[$iy] += $valwrk;
				if (is_null($grandmn[$iy])) {
					$grandmn[$iy] = $valwrk;
					$grandmx[$iy] = $valwrk;
				} else {
					if ($grandmn[$iy] > $valwrk) $grandmn[$iy] = $valwrk;
					if ($grandmx[$iy] < $valwrk) $grandmx[$iy] = $valwrk;
				}
			}
		}
	}
}

// Get count
function GetCnt($sql) {
	global $conn;

	//echo "sql (GetCnt): " . $sql . "<br>";
	$rscnt = $conn->Execute($sql);
	$cnt = ($rscnt) ? $rscnt->RecordCount() : 0;
	return $cnt;
}

// Get rs
function GetRs($sql, $start, $grps) {
	global $conn;
	$wrksql = $sql . " LIMIT " . ($start-1) . ", " . ($grps);

	//echo "wrksql: (rsgrp)" . $sSql . "<br>";
	$rswrk = $conn->Execute($wrksql);
	return $rswrk;
}

// Get row values
function GetRow($opt) {
	global $rs, $val;
	if (!$rs)
		return;
	if ($opt == 1) { // Get first row
		$rs->MoveFirst();
	} else { // Get next row
		$rs->MoveNext();
	}
	if (!$rs->EOF) {
		$GLOBALS['x_id'] = $rs->fields('id');
		$val[1] = $GLOBALS['x_id'];
	} else {
		$GLOBALS['x_id'] = "";
	}
}

//  Set up starting group
function SetUpStartGroup() {
	global $nStartGrp, $nTotalGrps, $nDisplayGrps;

	// Exit if no groups
	if ($nDisplayGrps == 0)
		return;

	// Check for a 'start' parameter
	if (@$_GET[EW_REPORT_TABLE_START_GROUP] != "") {
		$nStartGrp = $_GET[EW_REPORT_TABLE_START_GROUP];
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} elseif (@$_GET["pageno"] != "") {
		$nPageNo = $_GET["pageno"];
		if (is_numeric($nPageNo)) {
			$nStartGrp = ($nPageNo-1)*$nDisplayGrps+1;
			if ($nStartGrp <= 0) {
				$nStartGrp = 1;
			} elseif ($nStartGrp >= intval(($nTotalGrps-1)/$nDisplayGrps)*$nDisplayGrps+1) {
				$nStartGrp = intval(($nTotalGrps-1)/$nDisplayGrps)*$nDisplayGrps+1;
			}
			$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
		} else {
			$nStartGrp = @$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP];
		}
	} else {
		$nStartGrp = @$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP];	
	}

	// Check if correct start group counter
	if (!is_numeric($nStartGrp) || $nStartGrp == "") { // Avoid invalid start group counter
		$nStartGrp = 1; // Reset start group counter
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} elseif (intval($nStartGrp) > intval($nTotalGrps)) { // Avoid starting group > total groups
		$nStartGrp = intval(($nTotalGrps-1)/$nDisplayGrps) * $nDisplayGrps + 1; // Point to last page first group
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} elseif (($nStartGrp-1) % $nDisplayGrps <> 0) {
		$nStartGrp = intval(($nStartGrp-1)/$nDisplayGrps) * $nDisplayGrps + 1; // Point to page boundary
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	}
}

// Set up popup
function SetupPopup() {
	global $conn, $sFilter;

	// Initialize popup
	// Process post back form

	if (count($_POST) > 0) {
		$sName = @$_POST["popup"]; // Get popup form name
		if ($sName <> "") {
		$cntValues = (is_array(@$_POST["sel_$sName"])) ? count($_POST["sel_$sName"]) : 0;
			if ($cntValues > 0) {
				$arValues = ewrpt_StripSlashes($_POST["sel_$sName"]);
				if (trim($arValues[0]) == "") // Select all
					$arValues = EW_REPORT_INIT_VALUE;
				$_SESSION["sel_$sName"] = $arValues;
				$_SESSION["rf_$sName"] = ewrpt_StripSlashes(@$_POST["rf_$sName"]);
				$_SESSION["rt_$sName"] = ewrpt_StripSlashes(@$_POST["rt_$sName"]);
				ResetPager();
			}
		}

	// Get 'reset' command
	} elseif (@$_GET["cmd"] <> "") {
		$sCmd = $_GET["cmd"];
		if (strtolower($sCmd) == "reset") {
			ResetPager();
		}
	}

	// Load selection criteria to array
}

// Reset pager
function ResetPager() {

	// Reset start position (reset command)
	global $nStartGrp, $nTotalGrps;
	$nStartGrp = 1;
	$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
}
?>
<?php

// Set up number of groups displayed per page
function SetUpDisplayGrps() {
	global $nDisplayGrps, $nStartGrp;
	$sWrk = @$_GET[EW_REPORT_TABLE_GROUP_PER_PAGE];
	if ($sWrk <> "") {
		if (is_numeric($sWrk)) {
			$nDisplayGrps = intval($sWrk);
		} else {
			if (strtoupper($sWrk) == "ALL") { // display all groups
				$nDisplayGrps = -1;
			} else {
				$nDisplayGrps = 3; // Non-numeric, load default
			}
		}
		$_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE] = $nDisplayGrps; // Save to session

		// Reset start position (reset command)
		$nStartGrp = 1;
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} else {
		if (@$_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE] <> "") {
			$nDisplayGrps = $_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE]; // Restore from session
		} else {
			$nDisplayGrps = 3; // Load default
		}
	}
}
?>
<?php

// Return poup filter
function GetPopupFilter() {
	$sWrk = "";
	return $sWrk;
}
?>
<?php

//-------------------------------------------------------------------------------
// Function getSort
// - Return Sort parameters based on Sort Links clicked
// - Variables setup: Session[EW_REPORT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
function getSort()
{

	// Check for a resetsort command
	if (strlen(@$_GET["cmd"]) > 0) {
		$sCmd = @$_GET["cmd"];
		if ($sCmd == "resetsort") {
			$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "";
			$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = 1;
			$_SESSION["sort_dummy_id"] = "";
		}

	// Check for an Order parameter
	} elseif (strlen(@$_GET[EW_REPORT_TABLE_ORDER_BY]) > 0) {
		$sSortSql = "";
		$sSortField = "";
		$sOrder = @$_GET[EW_REPORT_TABLE_ORDER_BY];
		if (strlen(@$_GET[EW_REPORT_TABLE_ORDER_BY_TYPE]) > 0) {
			$sOrderType = @$_GET[EW_REPORT_TABLE_ORDER_BY_TYPE];
		} else {
			$sOrderType = "";
		}
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>
