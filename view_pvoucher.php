<html>
<title>B.I.M.S</title>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" id="complex_form"style="min-height:500px" enctype="multipart/form-data" method="post" action="dashboardsub.php?page=import_pvoucher" >
	  <h1 id="title1">View Payment Vouchers Data</h1>
		
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

$voucher = 'P';
$q = "select max(transactioncode) as mid from ac_gl WHERE voucher = '$voucher'  and client = '$client' "; $qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs)) { $tid = $qr['mid']; 	} 

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
 <th><strong>Mode</strong></th>
 <th><strong>Cash/Bank Code</strong></th>
 <th><strong>Code</strong></th>
 <th><strong>Cr / Dr</strong></th>
 <th><strong>Amount</strong></th>
 <th><strong>Payment Mode</strong></th>
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
        if ($col == "1") { $data1 = htmlentities($data, ENT_QUOTES); }	//Doc. NO.		1
        if ($col == "2") { $data2 = htmlentities($data, ENT_QUOTES); }	//Mode			2
        if ($col == "3") { $data3 = htmlentities($data, ENT_QUOTES); }	//Cash/Bank Code	3
        if ($col == "4") { $data4 = htmlentities($data, ENT_QUOTES); }	//Code			4
        if ($col == "5") { $data5 = htmlentities($data, ENT_QUOTES); }	//Cr/Dr			5
        if ($col == "6") { $data6 = htmlentities($data, ENT_QUOTES); }	//Amount		6
        if ($col == "7") { $data7 = htmlentities($data, ENT_QUOTES); }	//Narration		7
        if ($col == "8") { $data8 = htmlentities($data, ENT_QUOTES); }	//Payment Mode	8
        if ($col == "9") { $data9 = htmlentities($data, ENT_QUOTES); }	//Cheque No.	9
        if ($col == "10") { $data10 = htmlentities($data, ENT_QUOTES); }//Cheque Date	10
/*        if ($col == "11") { $data11 = htmlentities($data, ENT_QUOTES); }//Warehouse		11
        if ($col == "12") { $data12 = htmlentities($data, ENT_QUOTES); }//Narration		12
        if ($col == "13") { $data13 = htmlentities($data, ENT_QUOTES); }
       
 */          
          $totalcol = "10";
     
if ($col == $totalcol && $data4 <> "" && $data5 <> "" && $data6 <> "")	//	IF-1
{
 if($data0 == "" && $data1 == "" && $data2 == "" && $data3 == "" )
 {
  $date = $previousdate;
  $bi = $previousbi;
  $mode = $previousmode;
  $cbcode = $previouscbcode;
  $firstrow =0;
 } 
 else
 {
  $date = $data0;
  $bi = $data1;
  $mode = $data2;
  $cbcode = $data3;
  $firstrow = 1;
  $countrows = 1;
  $tid++;
  $pmode = $data8;
  $cheque = $data9;
  if($data10 == "")
   $data10 = date("d.m.Y");
  $cdate = $data10;
 }
 
 $coacode = $data4;
 $alertmsg = "";
  
 $cramount = $dramount = 0;
 if($data5 == 'Cr')
  $cramount += $data6;
 elseif($data5 == 'Dr')
  $dramount += $data6;
  
 if($firstrow == 1)
 {
  //Check Cr Amount and Dr Amount
  for($temp = $row + 1;$temp<=$ee->GetLastRowIndex($sheet);$temp++)
  { 
   $temp2 = $ee->GetCellData($sheet,0,$temp);
   $tempdate = $temp2['string'];
   $tempbi = $ee->GetCellData($sheet,1,$temp);
   $temp2 = $ee->GetCellData($sheet,2,$temp);
   $tempmode = $ee->AsHTML($temp2);
   $temp2 = $ee->GetCellData($sheet,3,$temp);
   $tempcode = $ee->AsHTML($temp2);
   if($tempdate == "" && $tempbi == "" && $tempmode == "" && $tempcode == "")
   {
    $countrows++;
    $temp2 = $ee->GetCellData($sheet,5,$temp);
	$crdr = $ee->AsHTML($temp2);
	if($crdr == 'Cr')
	 $cramount += $ee->GetCellData($sheet,6,$temp);
	elseif($crdr == 'Dr')
	 $dramount += $ee->GetCellData($sheet,6,$temp);
   }
   else
    break;
  }

  if($cramount <> $dramount)
   $alertmsg = "Credit Amount $cramount and Debit Amount $dramount are not equal";

 $query = "SELECT id FROM ac_bankmasters WHERE acno = '$cbcode' AND coacode = '$data4'";
 $result = mysql_query($query,$conn) or die(mysql_error());
 $rows = mysql_num_rows($result);
 if($rows == 0)
  $alertmsg = "Cash/Bank Code: $cbcode and COA Code: $coacode should be mapped in COA Mapping Section";
 
 $query = "SELECT id FROM ac_bankmasters WHERE acno = '$cbcode'";
 $result = mysql_query($query,$conn) or die(mysql_error());
 $rows = mysql_num_rows($result);
 if($rows == 0)
  $alertmsg = "Cash/Bank Code: $cbcode not added into software";  
 }
 
 $query = "SELECT id FROM ac_coa WHERE code = '$coacode'";
 $result = mysql_query($query,$conn) or die(mysql_error());
 $rows = mysql_num_rows($result);
 if($rows == 0)
  $alertmsg = "COA Code: $coacode not added into software";
  
  if($alertmsg == "")
{ 
?>
 <tr>
   <td><?php echo $row; ?></td>
   <td><input type="text" name="date[]" value="<?php echo date("d.m.Y",strtotime($date)); ?>" size="10" readonly style="background:none; border:none" /></td>
   <td><input type="text" name="docno[]" value="<?php echo $bi; ?>" size="5" readonly style="background:none; border:none"/></td>
   <td><input type="text" name="mode[]" value="<?php echo $mode; ?>" size="5" readonly style="background:none; border:none"/></td>
   <td><input type="text" name="cbcode[]" value="<?php echo $cbcode; ?>" size="15" readonly style="background:none; border:none"/></td>
   <td><input type="text" name="code[]" value="<?php echo $data4; ?>" size="5" readonly style="background:none; border:none;"/></td>
   <td><input type="text" name="crdr[]" value="<?php echo $data5; ?>" size="5" readonly style="background:none; border:none; "/></td>
   <td><input type="text" name="amount[]" value="<?php echo $data6; ?>" size="5" readonly style="background:none; border:none; text-align:right"/></td>
   <td><input type="text" name="pmode[]" value="<?php echo $pmode; ?>" size="5" readonly style="background:none; border:none;"/></td>
   <td><input type="text" name="cheque[]" value="<?php echo $cheque; ?>" size="7" readonly style="background:none; border:none"/></td>
   <td><input type="text" name="cdate[]" value="<?php echo date("d.m.Y",strtotime($cdate)); ?>" size="10" readonly style="background:none; border:none"/>
   <input type="hidden" name="narration[]" value="<?php echo $data7; ?>" />
   <input type="hidden" name="cramount[]" value="<?php echo $cramount; ?>" size="5" />
   <input type="hidden" name="noofrows[]" value="<?php echo $countrows; ?>" size="5" />
   <input type="hidden" name="tid[]" value="<?php echo $tid; ?>" size="5" />
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
 $previousmode = $mode;
 $previousdate = $date;
 $previousbi = $bi;
 $previouscbcode = $cbcode; 
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
<input type="button" value="Cancel" onclick="document.location='tally_pvoucher'">
</form>
</body>
</html>