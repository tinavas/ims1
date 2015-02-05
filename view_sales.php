<html>
<title>B.I.M.S</title>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" id="complex_form"style="min-height:500px" enctype="multipart/form-data" method="post" action="dashboardsub.php?page=import_sales" >
	  <h1 id="title1">View Sales Data</h1>
		
              <center>

<body>
<?php

 ini_set('display_errors', 0);
 ini_set('log_errors', 0);
 ini_set('error_reporting', E_ALL);

include 'ExcelExplorer2.php';
include "getemployee.php";
include "config.php";
include "jquery.php";

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
  print '<strong>Sheet Name: </strong>'.$ee->AsHTML($ee->GetWorksheetTitle($sheet))."<br><br>\n";
$bank = $ee->AsHTML($ee->GetWorksheetTitle($sheet));
$bank = substr_replace($bank,"",-4); 
?>
<table id="tab1" align="center" cellspacing="0" cellpadding="2" border="2" width="950px">

<tr>
 <th><strong>S.No</strong></th>
 <th><strong>Date</strong></th>
 <th><strong>Book<br/>Invoice</strong></th>
 <th><strong>Customer</strong></th>
 <th><strong>Item Code</strong></th>
 <th><strong>Quantity</strong></th>
 <th><strong>Rate</strong></th>
 <th><strong>Discount</strong></th>
 <th><strong>Vehicle No.</strong></th>
 <th><strong>Driver Name</strong></th>
 <th><strong>Warehouse</strong></th>
</tr>

<?php

if( !$ee->IsEmptyWorksheet($sheet) ) {

 for($row=0; $row<=$ee->GetLastRowIndex($sheet); $row++) {
 
  if( !$ee->IsEmptyRow($sheet,$row) ) {

   for($col=0; $col<=$ee->GetLastColumnIndex($sheet); $col++) {

    if( !$ee->IsEmptyColumn($sheet,$col) ) {

     $data = $ee->GetCellData($sheet,$col,$row);
     $type = '';
//echo $ee->GetCellType($sheet,$col,$row);
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
     //print "Column: $col, row: $row, type: \"$type\", value: \"$data\"<br>\n";
     if ( $row > 0 )
       {  
	  
	   
        if ($col == "0") { $data0 = htmlentities($data, ENT_QUOTES); }	//Date			0
        if ($col == "1") { $data1 = htmlentities($data, ENT_QUOTES); }	//Book Invoice	1
        if ($col == "2") { $data2 = strtoupper($data); $data2 = str_replace("&AMP;","&",$data2); }//htmlentities($data, ENT_QUOTES); }	//Customer		2
        if ($col == "3") { $data3 = htmlentities($data, ENT_QUOTES); }	//Item Code		3
        if ($col == "4") { $data4 = htmlentities($data, ENT_QUOTES); }	//quantity		4
        if ($col == "5") { $data5 = htmlentities($data, ENT_QUOTES); }	//Price			5
        if ($col == "6") { $data6 = htmlentities($data, ENT_QUOTES); }	//Discount		6
        if ($col == "7") { $data7 = htmlentities($data, ENT_QUOTES); }	//Vehicle No.	7
        if ($col == "8") { $data8 = htmlentities($data, ENT_QUOTES); }	//Driver Name	8
        if ($col == "9") { $data9 = htmlentities($data, ENT_QUOTES); }	//Warehouse		9
        if ($col == "10") { $data10 = htmlentities($data, ENT_QUOTES); }//Narration		10
/*        if ($col == "11") { $data11 = htmlentities($data, ENT_QUOTES); }//Warehouse		11
        if ($col == "12") { $data12 = htmlentities($data, ENT_QUOTES); }//Narration		12
        if ($col == "13") { $data13 = htmlentities($data, ENT_QUOTES); }
       
 */          
          $totalcol = "10";
     
if ($col == $totalcol && $data3 <> "" && $data4 <> "" && $data5 <> "")	//	IF-1
{
 if($data0 == "" && $data2 == "")
 {
  $vendor = $previousvendor;
  $data1 = $previousbi;
  $data0 = $previousdate;
 } 
 else
  $vendor = $data2;
 $code = $data3;
 
 $warehouse = $data9;
 
 $alertmsg = "";
 
 $query = "SELECT id FROM contactdetails WHERE name = \"$vendor\" AND type LIKE '%party%'";
 $result = mysql_query($query,$conn) or die(mysql_error());
 if( ! $rows = mysql_fetch_assoc($result))
  $alertmsg = "Customer name: $vendor is not added in the software";
  
 $query = "SELECT id FROM ims_itemcodes WHERE code = '$code'";
 $result = mysql_query($query,$conn) or die(mysql_error());
 if( ! $rows = mysql_fetch_assoc($result))
  $alertmsg = "Item Code: $code is not added in the software";

 if($data4 == "")
  $alertmsg = "Please enter Quantity";
 elseif($data5 == "")
  $alertmsg = "Please enter Rate"; 
 
  
 $query = "SELECT id FROM tbl_sector WHERE sector = '$warehouse'";
 $result = mysql_query($query,$conn) or die(mysql_error());
 if( ! $rows = mysql_fetch_assoc($result))
  $alertmsg = "Warehouse: $warehouse is not added in the software";
  
 if($warehouse == "")
  $alertmsg = "Please enter Warehouse";
  
 $totqty = $data4;
 $countrows = 1;
 $invoiceamount = ($data4 * $data5);

 // if($data7 > 0 or $data9 > 0)
 { 
  for($temp = $row + 1;$temp<=$ee->GetLastRowIndex($sheet);$temp++)
  { 
   $temp2 = $ee->GetCellData($sheet,0,$temp);
   $tempdate = $temp2['string'];
   $tempbi = $ee->GetCellData($sheet,1,$temp);
   $temp2 = $ee->GetCellData($sheet,2,$temp);
   $tempvendor = $ee->AsHTML($temp2);
   if($tempdate == "" && $tempbi == "" && $tempvendor == "")
   {
    $countrows++;
    $totqty += $ee->GetCellData($sheet,4,$temp);
	$invoiceamount += ($ee->GetCellData($sheet,4,$temp) * $ee->GetCellData($sheet,5,$temp));
   }
   else
    break;
  }
 }
 
 if($data6 == "") $data6 = 0;
 if($data7 == "") $data7 = 0;
 if($data9 == "") $data9 = 0;
 
  if($alertmsg == "")
{ 
?>
 <tr>
   <td><?php echo $row; ?></td>
   <td><input type="text" name="date[]" value="<?php echo date("d.m.Y",strtotime($data0)); ?>" size="10" readonly style="background:none; border:none" /></td>
   <td><input type="text" name="bookinvoice[]" value="<?php echo $data1; ?>" size="5" readonly  style="background:none; border:none"/></td>
   <td><input type="text" name="party[]" value="<?php echo $vendor; ?>" size="10" readonly  style="background:none; border:none"/></td>
   <td><input type="text" name="code[]" value="<?php echo $data3; ?>" size="7" readonly  style="background:none; border:none"/></td>
   <td><input type="text" name="qty[]" value="<?php echo $data4; ?>" size="5" readonly  style="background:none; border:none; text-align:right"/></td>
   <td><input type="text" name="rate[]" value="<?php echo $data5; ?>" size="5" readonly  style="background:none; border:none; text-align:right"/></td>
   <td><input type="text" name="discount[]" value="<?php echo $data6; ?>" size="5" readonly  style="background:none; border:none; text-align:right"/></td>
   <td><input type="text" name="vno[]" value="<?php echo $data7; ?>" size="10" readonly  style="background:none; border:none; text-align:right"/></td>
   <td><input type="text" name="driver[]" value="<?php echo $data8; ?>" size="7" readonly  style="background:none; border:none"/></td>
   <td><input type="text" name="warehouse[]" value="<?php echo $data9; ?>" size="8" readonly  style="background:none; border:none"/>
   <input type="hidden" name="narration[]" value="<?php echo $data12; ?>" />
   <input type="hidden" name="totqty[]" value="<?php echo $totqty; ?>" size="5" />
   <input type="hidden" name="grandtotal[]" value="<?php echo $invoiceamount - $data6; ?>" size="5" />
   <input type="hidden" name="noofrows[]" value="<?php echo $countrows; ?>" size="5" />
   </td>
 </tr>  

<?php	
}
else
{
 $error=1;					
?>  
<tr>
 <td style="color:#FF0000;"><?php echo $row; ?></td>
 <td colspan="12" align = "left" style="color:#FF0000;"><?php echo $alertmsg; $alertmsg = ""; ?></td>
</tr>
			 
<?php
 }
 $previousvendor = $data2;
 $previousdate = $data0;
 $previousbi = $data1; 
}	//END OF IF-1
        }
    }

   }

  }
 }
} else {
 print "Empty sheet<br>\n";
} 
?>
</table>
<?php
}
?><br/><br/>
<?php if($error<> 1) { ?>
<input type="submit" value="Save">
<?php } ?>
<input type="button" value="Cancel" onclick="document.location='tally_sales'">
</form>
</body>
</html>