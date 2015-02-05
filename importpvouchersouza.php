<html>
<title>B.I.M.S</title>
<body bgcolor="#ECF1F5" >
<?php

 ini_set('display_errors', 0);
 ini_set('log_errors', 0);
 ini_set('error_reporting', E_ALL);

include 'ExcelExplorer2.php';
include "getemployee.php";
include "config.php";

if( $_FILES['excel_file'] &&
   ($_FILES['excel_file']['tmp_name'] != '') ) {

 $fsz = filesize($_FILES['excel_file']['tmp_name']);
 $fh = @fopen ($_FILES['excel_file']['tmp_name'],'rb');
 if( !$fh || ($fsz==0) )
  die('No file uploaded');
 $file = fread( $fh, $fsz );
 @fclose($fh);
 if( strlen($file) < $fsz )
  die('Cannot read the file');
} else {
 die('No file uploaded');
}

$ee = new ExcelExplorer;

switch ($ee->Explore($file)) {
 case 0:
  break;
 case 1:
  die('File corrupted or not in Excel 5.0 and above format');
 case 2:
  die('Unknown or unsupported Excel file version');
 default:
  die('ExcelExplorer give up');
}

for( $sheet=0; $sheet<$ee->GetWorksheetsNum(); $sheet++ ) {
  print 'Sheet: '.$ee->AsHTML($ee->GetWorksheetTitle($sheet))."<br>\n";
$bank = $ee->AsHTML($ee->GetWorksheetTitle($sheet));
$bank = substr_replace($bank,"",-4); 
?>
Data saved successfully.<br /><br />
<input type="button" value="Go Back" onClick="document.location='import.php';" />
<input type="button" value="View Report" onClick="window.open('reportsmry.php');" />
<?php

if( !$ee->IsEmptyWorksheet($sheet) ) {

 print "<br>\nData:<br>\n";
 
 for($row=0; $row<=$ee->GetLastRowIndex($sheet); $row++) {
 
  if( !$ee->IsEmptyRow($sheet,$row) ) {

   for($col=0; $col<=$ee->GetLastColumnIndex($sheet); $col++) {

    if( !$ee->IsEmptyColumn($sheet,$col) ) {

     $data = $ee->GetCellData($sheet,$col,$row);
     $type = '';

     switch( $ee->GetCellType($sheet,$col,$row) ) {
      case 0:
       $type = 'Empty';
       break;
      case 7:
       $type = 'Blank';
       break;
      case 8:
       $type = 'Merged';
       break;
      case 1:
       $type = 'Number';
       break;
      case 3:
       $type = 'Text';
       $data = $ee->AsHTML($data);
       break;
      case 2:
       $type = 'Percentage';
       $data = (100*$data).'%';
       break;
      case 4:
       $type = 'Boolean';
       $data = ($data ? 'TRUE' : 'FALSE');
       break;
      case 5:
       $type = 'Error';
       switch( $data ) {
        case 0x00:
         $data = "#NULL!";
         break;
        case 0x07:
         $data = "#DIV/0";
         break;
        case 0x0F:
         $data = "#VALUE!";
         break;
        case 0x17:
         $data = "#REF!";
         break;
        case 0x1D:
         $data = "#NAME?";
         break;
        case 0x24:
         $data = "#NUM!";
         break;
        case 0x2A:
         $data = "#N/A!";
         break;
        default:
         $data = "#UNKNOWN";
         break;
       }
       break;
      case 6:
       $data = $data['string'];
       $type = 'Date';
       break;
      default:
       break;
     }

    // print "Column: $col, row: $row, type: \"$type\", value: \"$data\"<br>\n";
     if ( $row > 0 )
       {  
	  
	   
        if ($col == "0") { $data0 = htmlentities($data, ENT_QUOTES); }	//Date			0
        if ($col == "1") { $data1 = htmlentities($data, ENT_QUOTES); }	//Cash Code	1
        if ($col == "2") { $data2 = htmlentities($data, ENT_QUOTES); }	//Code		2
        if ($col == "3") { $data3 = htmlentities($data, ENT_QUOTES); }	//Amount		3
		if ($col == "4") { $data4 = htmlentities($data, ENT_QUOTES); }	//Doc. No.		4       
           
          $totalcol = "4";
        
                if ($col == $totalcol)
                {

$strdot1 = explode('/',$data0); 
$ignore = $strdot1[0]; 
$m = $strdot1[1];
if($m < 10)
 $m = "0".$m;
if($ignore < 10)
 $ignore = "0".$ignore;
$date = $strdot1[2]."-".$m."-".$ignore;
$warehouse = "Head Office";

$q = "select max(transactioncode) as mid from ac_gl WHERE voucher = 'P'  and client = '$client' "; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs)) { $tnum = $qr['mid']; $tnum = $tnum + 1;	} 
$mode = "P";

$q = "select mode,coacode,description from ac_bankmasters t1,ac_coa t2 where t1.code = '$data1' and t2.code = t1.coacode";
$qrs = mysql_query($q,$conn) or die(mysql_error());
$qr = mysql_fetch_assoc($qrs);
$cashcoa = $qr['coacode'];
$cashdesc = $qr['description'];
$paymentmode = $qr['mode'];

$q = "select description,type,controltype,schedule from ac_coa where code = '$data2'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
$qr = mysql_fetch_assoc($qrs);
$desc = $qr['description'];
$type = $qr['type'];
$ctype = $qr['controltype'];
$schedule = $qr['schedule'];
$remarks = "Voucher No.:".$data4;

$q = "insert into ac_gl (mode,transactioncode,bccodeno,code,description,type,controltype,schedule,crdr,cramount,dramount,rremarks,crtotal,drtotal,name,pmode,chequeno,date,status,voucher,vstatus,warehouse,client,vouchernumber) VALUES ('$paymentmode','$tnum','$data1','$cashcoa','$cashdesc','Asset','$paymentmode','Current Assets','Cr','$data3','0','$remarks','$data3','$data3','','','','$date','U','P','A','$warehouse','$client','$data4')";
$result = mysql_query($q,$conn) or die(mysql_error());

$q = "insert into ac_gl (mode,transactioncode,bccodeno,code,description,type,controltype,schedule,crdr,cramount,dramount,rremarks,crtotal,drtotal,name,pmode,chequeno,date,status,voucher,vstatus,warehouse,client,vouchernumber) VALUES ('$paymentmode','$tnum','$data1','$data2','$desc','$type','$ctype','$schedule','Dr','0','$data3','$remarks','$data3','$data3','','','','$date','U','P','A','$warehouse','$client','$data4')";
$result = mysql_query($q,$conn) or die(mysql_error());

if($paymentmode == "Cash")
{ $cash = "YES"; $bank = "NO"; $cashcode = $cashcoa; $bankcode = "";  }
elseif($paymentmode == "Bank")
{ $cash = "NO"; $bank = "YES"; $cashcode = ""; $bankcode = $cashcoa;  }

$q1 = "insert into ac_financialpostings(date,crdr,coacode,amount,trnum,type,client,warehouse,venname) VALUES ('$date','Cr','$cashcoa','$data3','$tnum','PV','$client','Head Office','') ";
$qrs1 = mysql_query($q1,$conn) or die(mysql_error());				

$q1 = "insert into ac_financialpostings(date,crdr,coacode,amount,trnum,type,client,warehouse,venname,cash,bank,cashcode,bankcode,schedule) VALUES ('$date','Dr','$data2','$data3','$tnum','PV','$client','Head Office','','$cash','$bank','$cashcode','$bankcode','$schedule') ";
$qrs1 = mysql_query($q1,$conn) or die(mysql_error());				
				}
        }
    }

   }

  }
 }
} else {
 print "Empty sheet<br>\n";
} 
print "<hr>\n";
}
?>
</body>
</html>