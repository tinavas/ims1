<html>
<title>B.I.M.S</title>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" id="complex_form"style="min-height:500px" enctype="multipart/form-data" method="post" action="dashboardsub.php?page=import_receipts" >
	  <h1 id="title1">View Receipts Data</h1>
		
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
 <th><strong>Document<br/>Number</strong></th>
 <th><strong>Customer</strong></th>
 <th><strong>Receipt<br/>Method</strong></th>
 <th><strong>Receipt<br/>Mode</strong></th>
 <th><strong>Cash / Bank<br/>Code</strong></th>
 <th><strong>Amount</strong></th>
 <th><strong>Cheque No.</strong></th>
 <th><strong>Cheque Date</strong></th>
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
        if ($col == "1") { $data1 = htmlentities($data, ENT_QUOTES); }	//Doc. No.	1
        if ($col == "2") { $data2 = strtoupper($data); $data2 = str_replace("&AMP;","&",$data2); } //htmlentities($data, ENT_QUOTES); }	//Customer		2
        if ($col == "3") { $data3 = htmlentities($data, ENT_QUOTES); }	//Pay Method	3
        if ($col == "4") { $data4 = htmlentities($data, ENT_QUOTES); }	//Pay Mode		4
        if ($col == "5") { $data5 = htmlentities($data, ENT_QUOTES); }	//Cash/Bank		5
        if ($col == "6") { $data6 = htmlentities($data, ENT_QUOTES); }	//Amount		6
        if ($col == "7") { $data7 = htmlentities($data, ENT_QUOTES); }	//Cheque 		7
        if ($col == "8") { $data8 = htmlentities($data, ENT_QUOTES); }	//Cheque Date	8
        if ($col == "9") { $data9 = htmlentities($data, ENT_QUOTES); }	//Narration		9
/*        if ($col == "10") { $data10 = htmlentities($data, ENT_QUOTES); }//Freight A/c	10
        if ($col == "11") { $data11 = htmlentities($data, ENT_QUOTES); }//Warehouse		11
        if ($col == "12") { $data12 = htmlentities($data, ENT_QUOTES); }//Narration		12
        if ($col == "13") { $data13 = htmlentities($data, ENT_QUOTES); }
       
 */          
          $totalcol = "9";
     
if ($col == $totalcol && $data0 <> "" && $data1 <> "" && $data2 <> "")	//	IF-1
{
 $vendor = $data2;
 $cashbankcode = $data5;
 
 $alertmsg = "";
 
 $query = "SELECT id FROM contactdetails WHERE name = \"$vendor\" AND type LIKE '%party%'";
 $result = mysql_query($query,$conn) or die(mysql_error());
 if( ! $rows = mysql_fetch_assoc($result))
  $alertmsg = "Vendor name: $vendor is not added in the software";
  
 $query = "SELECT id FROM ac_coa WHERE code = '$cashbankcode' AND controltype IN ('Cash','Bank')";
 $result = mysql_query($query,$conn) or die(mysql_error());
 if( ! $rows = mysql_fetch_assoc($result))
  $alertmsg = "Cash/Bank COA Code: $cashbankcode should be of control type Cash or Bank";

 $query = "SELECT id FROM ac_coa WHERE code = '$cashbankcode'";
 $result = mysql_query($query,$conn) or die(mysql_error());
 if( ! $rows = mysql_fetch_assoc($result))
  $alertmsg = "Cash/Bank Account COA Code: $cashbankcode is not added in the software";

 if($data3 == "")
  $alertmsg = "Please enter Payment Method";
 elseif($data4 == "")
  $alertmsg = "Please enter Payment Mode"; 
 elseif($data5 == "")
  $alertmsg = "Please enter Cash/Bank Code";
 elseif($data6 == "0" or $data6 == "")
  $alertmsg = "Please enter Amount";

  if($data8 == "") $data8 = date("d.m.Y");
  if($alertmsg == "")
{ 
?>
<tr>
   <td><?php echo $row; ?></td>
   <td><input type="text" name="date[]" value="<?php echo date("d.m.Y",strtotime($data0)); ?>" size="10" readonly style="background:none; border:none" /></td>
   <td><input type="text" name="docno[]" value="<?php echo $data1; ?>" size="5" readonly  style="background:none; border:none"/></td>
   <td><input type="text" name="party[]" value="<?php echo $vendor; ?>" size="20" readonly  style="background:none; border:none"/></td>
   <td><input type="text" name="pmethod[]" value="<?php echo $data3; ?>" size="7" readonly  style="background:none; border:none"/></td>
   <td><input type="text" name="pmode[]" value="<?php echo $data4; ?>" size="5" readonly  style="background:none; border:none;"/></td>
   <td><input type="text" name="cashbankcode[]" value="<?php echo $data5; ?>" size="5" readonly  style="background:none; border:none; text-align:right"/></td>
   <td><input type="text" name="amount[]" value="<?php echo $data6; ?>" size="5" readonly  style="background:none; border:none; text-align:right"/></td>
   <td><input type="text" name="cheque[]" value="<?php echo $data7; ?>" size="5" readonly  style="background:none; border:none; text-align:right"/></td>
   <td><input type="text" name="chequedate[]" value="<?php echo date("d.m.Y",strtotime($data8)); ?>" size="10" readonly  style="background:none; border:none"/>
   <input type="hidden" name="narration[]" value="<?php echo $data9; ?>" size="5" readonly  style="background:none; border:none; text-align:right"/>
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
 <td colspan="9" align = "left" style="color:#FF0000;"><?php echo $alertmsg; $alertmsg = ""; ?></td>
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
<input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=tally_receipts'">
</form>
</body>
</html>