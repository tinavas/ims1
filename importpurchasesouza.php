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
<input type="button" value="Go Back" onClick="document.location='tallypurchasesouza.php';" />
<input type="button" value="View Report" onClick="window.open('reportsmry.php');" />
<?php

if( !$ee->IsEmptyWorksheet($sheet) ) {

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
 //print "<br>\nData:<br>\n";
    // print "Column: $col, row: $row, type: \"$type\", value: \"$data\"<br>\n";
     if ( $row > 0 )
       {  
	  
	   
        if ($col == "0") {echo $data0 = htmlentities($data, ENT_QUOTES); }	//Date			0
        if ($col == "1") { $data1 = htmlentities($data, ENT_QUOTES); }	//Book Invoice	1
        if ($col == "2") { $data2 = htmlentities($data, ENT_QUOTES); }	//Vendor		2
        if ($col == "3") { $data3 = htmlentities($data, ENT_QUOTES); }	//Item Code		3
        if ($col == "4") { $data4 = htmlentities($data, ENT_QUOTES); }	//quantity		4
        if ($col == "5") { $data5 = htmlentities($data, ENT_QUOTES); }	//Price			5
        if ($col == "6") { $data6 = htmlentities($data, ENT_QUOTES); }	//VAT/TAX		6
        if ($col == "7") { $data7 = htmlentities($data, ENT_QUOTES); }	//Discount		7
        if ($col == "8") { $data8 = htmlentities($data, ENT_QUOTES); }	//Warehouse		8
/*        if ($col == "9") { $data9 = htmlentities($data, ENT_QUOTES); }
        if ($col == "10") { $data10 = htmlentities($data, ENT_QUOTES); }
        if ($col == "11") { $data11 = htmlentities($data, ENT_QUOTES); }
        if ($col == "12") { $data12 = htmlentities($data, ENT_QUOTES); }
        if ($col == "13") { $data13 = htmlentities($data, ENT_QUOTES); }
       
 */          
          $totalcol = "8";
     
if ($col == $totalcol)	//	IF-1
{  
	$num = 0;
	$cgroup = "";
	$vca = "";
	$query2 = "SELECT * FROM contactdetails where name =  '$data2' and type like '%vendor%'";
	$result2 = mysql_query($query2,$conn); 
	$num = mysql_num_rows($result2);
	while($row1 = mysql_fetch_assoc($result2))
		$vgroup = $row1['vgroup'];

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
		
		$query2 = "SELECT vca FROM ac_vgrmap where vgroup = '$vgroup' and flag = 'V'  ";
		$result2 = mysql_query($query2,$conn); 
		$num = mysql_num_rows($result2);
		while($row1 = mysql_fetch_assoc($result2))
		 $vca = $row1['vca'];
					
		if($hold == 0)
		{
			$strdot1 = explode('/',$data0); 
			$ignore = $strdot1[0]; 
			
			$m = $m1 = date("m",strtotime($data0));
			$y = date("y",strtotime($data0));
			$query1 = "SELECT MAX(sobiincr) as sobiincr FROM pp_sobi where m = '$m' AND y = '$y' ORDER BY date DESC";
			$result1 = mysql_query($query1,$conn); $cobiincr = 0; 
			while($row1 = mysql_fetch_assoc($result1)) 
			 $sobiincr = $row1['sobiincr']; 
			$sobiincr = $sobiincr + 1;
			if ($sobiincr < 10) 
			$sobi = 'SOBI-'.$m1.$y.'-000'.$sobiincr; 
			else if($sobiincr < 100 && $sobiincr >= 10) 
			$sobi = 'SOBI-'.$m1.$y.'-00'.$sobiincr; 
			else $sobi = 'SOBI-'.$m1.$y.'-0'.$sobiincr;
			echo $date = date("Y-m-d",strtotime($data0));
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
$query = "select description,sunits,iac from ims_itemcodes where code = '$data3'";
$result = mysql_query($query,$conn) or die(mysql_error());
$itemrows = mysql_num_rows($result);
$rows = mysql_fetch_assoc($result);
$description = $rows['description'];
$units = $rows['sunits'];					
$iac = $rows['iac'];
if($itemrows > 0)
{ 
if($data6 == "")
 $data6 = 0;
if($data7 == "")
 $data7 = 0;
$amount = ($data4 * $data5) + $data6 - $data7;
$totamount = $totamount + $amount;
$stdamount = $stdcost * $data4;
$totqty += $data4;

 $q = "insert into pp_sobi (remarks,date,sobiincr,m,y,so,invoice,vendor,broker,code,description,receivedquantity,rateperunit,itemunits,bags,bagtype,bagunits,taxvalue,taxamount,freightamount,totalamount,pocost,grandtotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coa,cno,flock,sentquantity,warehouse,adate,aempid,aempname,asector,totalquantity) 	values('$remarks','$date','$sobiincr','$m','$y','$sobi','$data1','$data2','','$data3','$description','$data4','$data5','$units','0','','','0','$data6','0','$amount','$amount','$amount','$amount','2','Gopalkrishna Baliga','SOUZAGROUP','1','','','Included','','$date','','0','$data7','','','','$data4','$data8','$date','2','Gopalkrishna Baliga','SOUZAGROUP','$totqty')";

	$qrs = mysql_query($q,$conn) or die(mysql_error());
	
	if($hold == 1)
	{
	 $q = "update pp_sobi set totalquantity = '$totqty',totalamount = '$totamount', pocost = '$totamount', grandtotal = '$totamount', balance = '$totamount' where so = '$sobi'  ";
$qr = mysql_query($q,$conn) or die(mysql_error());

$q = "delete from ac_financialpostings where coacode = '$vca' and trnum = '$sobi'  ";
$qr = mysql_query($q,$conn) or die(mysql_error());

 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
	          VALUES('".$date."','','Cr','".$vca."','$totqty','".$totamount."','".$sobi."','SOBI','".$data2."','".$data8."','".$client."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
    }
	else
	{
	
 ///Vendor Account Credit
  
   $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
	          VALUES('".$date."','','Cr','".$vca."','$totqty','".$amount."','".$sobi."','SOBI','".$data2."','".$data8."','".$client."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	}
	
	
	////Item Account Credit
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) VALUES('".$date."','".$data3."','Dr','".$iac."','$data4','".$amount."','".$sobi."','SOBI','".$data2."','".$data8."')";
	$result4 = mysql_query($query4,$conn) or die(mysql_error());			
				}
				else
				{
					echo "Item Code Not added in the software.Code:<b>".$data3."</b>Date:".$date."Voucher:".$data1."<br>\n";
				}
					}
					else
					{
					echo "Contact Name Not added in the software.Name:".$data2."Date:".$date."Voucher:".$data1."<br>\n";
					}
  
			 

          
}	//END OF IF-1
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