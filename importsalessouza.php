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
        if ($col == "1") { $data1 = htmlentities($data, ENT_QUOTES); }	//Book Invoice	1
        if ($col == "2") { $data2 = htmlentities($data, ENT_QUOTES); }	//Vendor		2
        if ($col == "3") { $data3 = htmlentities($data, ENT_QUOTES); }	//Item Code		3
        if ($col == "4") { $data4 = htmlentities($data, ENT_QUOTES); }	//quantity		4
        if ($col == "5") { $data5 = htmlentities($data, ENT_QUOTES); }	//Price			5
        if ($col == "6") { $data6 = htmlentities($data, ENT_QUOTES); }	//Warehouse		6
       
           
          $totalcol = "6";
        
                if ($col == $totalcol)
                {  
				   $num = 0;
				   $cgroup = "";
				   $vca = "";
                    $query2 = "SELECT * FROM contactdetails where name =  '$data2' and type LIKE '%party%'  ";
                    $result2 = mysql_query($query2,$conn); 
                    $num = mysql_num_rows($result2);
					while($row1 = mysql_fetch_assoc($result2))
					{
					 $cgroup = $row1['cgroup'];
					}
					//echo $hold;
				  if(($num > 0) or (($data3 <> "") and ($data2 == "")))
					{
									
					
					if($data1 == "")
					 $hold = 1;
					else
					{
					 $hold = 0;
					 $totamount = 0;
					 $totqty = 0;					 
					}
                   
					$query2 = "SELECT * FROM ac_vgrmap where vgroup = '$cgroup' and flag = 'C'  ";
                    $result2 = mysql_query($query2,$conn); 
                    $num = mysql_num_rows($result2);
					while($row1 = mysql_fetch_assoc($result2))
					 $vca = $row1['vca'];
					$data0;
					if($hold == 0)
					{
					$strdot1 = explode('/',$data0); 
$ignore = $strdot1[0]; 
$m = $strdot1[1];
$y = substr($strdot1[2],2,4);
if($m < 10)
 $m1 = "0".$m;
$query1 = "SELECT MAX(cobiincr) as cobiincr FROM oc_cobi where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $cobiincr = 0; 
while($row1 = mysql_fetch_assoc($result1)) 
$cobiincr = $row1['cobiincr']; 
$cobiincr = $cobiincr + 1;
if ($cobiincr < 10) 
$cobi = 'COBI-'.$m1.$y.'-000'.$cobiincr; 
else if($cobiincr < 100 && $cobiincr >= 10) 
$cobi = 'COBI-'.$m1.$y.'-00'.$cobiincr; 
else $cobi = 'COBI-'.$m1.$y.'-0'.$cobiincr;
if($m < 10)
$m = "0".$m;
if($ignore < 10)
$ignore = "0".$ignore;
 $date = $strdot1[2]."-".$m."-".$ignore;
 $party =  $data2;
 $binvoice = $data1;
 $vcaorig = $vca;
					}
					else
					{
					$data1 = $binvoice;
					$data2 = $party;
					$vca = $vcaorig;
					}
					
$query1 = "SELECT* from ims_itemcodes where code = '$data3'";
$result1 = mysql_query($query1,$conn);
while($row1 = mysql_fetch_assoc($result1)) 
{
$code = $row1['code'];
$description = $row1['description'];
$itemac = $row1['iac'];
$cogsac = $row1['cogsac'];
$salesac = $row1['sac'];
$stdcost = $row1['stdcost'];
$warehouse = $row1['warehouse'];
}
 
$amount = $data4 * $data5;
$totamount = $totamount + $amount;
$stdamount = $stdcost * $data4;
$totqty += $data4;

  $q = "insert into oc_cobi (date,cobiincr,m,y,invoice,bookinvoice,party,broker,code,description,quantity,price,freightamount,total,finaltotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coacode,cno,units,warehouse,client,flock,totalquantity) 	values('$date','$cobiincr','$m','$y','$cobi','$data1','$data2','','$code','$description','$data4','$data5','0','$amount','$amount','$amount','0','','','0','0','','','','$date','','0','0','','','','$data6','".$client."','','$totqty')";
	
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	
	if($hold == 1)
	{
	 $q = "update oc_cobi set totalquantity = '$totqty',finaltotal = '$totamount',balance = '$totamount' where invoice = '$cobi'  ";
     $qr = mysql_query($q,$conn) or die(mysql_error());

$q = "delete from ac_financialpostings where coacode = '$vca' and trnum = '$cobi'  ";
$qr = mysql_query($q,$conn) or die(mysql_error());

 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
	          VALUES('".$date."','','Dr','".$vca."','$totqty','".$totamount."','".$cobi."','COBI','".$data2."','".$data6."','".$client."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
    }
	else
	{
	
 ///Customer Account Debit
  
   $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
	          VALUES('".$date."','','Dr','".$vca."','$totqty','".$amount."','".$cobi."','COBI','".$data2."','".$data6."','".$client."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	}
	
	
	////Item Account Credit
$dummyquantity = 0;
$stdamount = round($stdamount,3);
     $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
	          VALUES('".$date."','".$code."','Cr','".$itemac."','".$data4."','".$stdamount."','".$cobi."','COBI','".$data2."','".$warehouse."','".$client."')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());

   /// COGS A/C Debit
   
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
	          VALUES('".$date."','".$code."','Dr','".$cogsac."','".$data4."','".$stdamount."','".$cobi."','COBI','".$data2."','".$data6."','".$client."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	///Sales A/C Credit
	$mainitemcost = round($mainitemcost,3);
   $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
	          VALUES('".$date."','','Cr','".$salesac."','$data4','$amount','".$cobi."','COBI','".$vendor."','".$data6."','".$client."')";
 $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	
					}
					else
					{
					echo "Contact Name Not added in the software.Name:".$data2."Date:".$date."Voucher:".$data1;
					}
  

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