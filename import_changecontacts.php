<html>
<title>B.I.M.S</title>

<table id="tab1" align="center" cellspacing="0" cellpadding="2" border="2" width="900px">

<tr>
 <th>Old Name</th>
 <th>New Name</th>
</tr>

<?php
$i = 0;
 ini_set('display_errors', 0);
 ini_set('log_errors', 0);
 ini_set('error_reporting', E_ALL);

include 'ExcelExplorer2.php';
include "config.php";
$query = "";
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
	 
if ( $row > 0 )
       {  
	  
	   
        if ($col == "0") { $data0 = $data; }//htmlentities($data, ENT_QUOTES); }
        if ($col == "1") { $data1 = $data; } //htmlentities($data, ENT_QUOTES); }
          $totalcol = "1";
        
                if ($col == $totalcol)
                {

$tally_name = strtoupper($data1);
$tally_name = str_replace("&AMP;","&",$tally_name);

$sw_name = strtoupper($data0);
$sw_name = str_replace("&AMP;","&",$sw_name);

$query = "SELECT name FROM contactdetails WHERE name = \"$sw_name\"";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows1 = mysql_num_rows($result);

$i++;
if($rows1 > 0 && $sw_name <> "" && $tally_name <> "")
{				
 if($sw_name <> $tally_name)
 {
$query1="UPDATE ac_financialpostings SET venname = \"$tally_name\" WHERE venname = \"$sw_name\"";
$result1=mysql_query($query1,$conn) or die(mysql_error());

$query2="UPDATE ac_crdrnote SET vcode = \"$tally_name\" WHERE vcode = \"$sw_name\"";
$result2=mysql_query($query2,$conn) or die(mysql_error());

$query3="UPDATE pp_sobi SET vendor = \"$tally_name\" WHERE vendor = \"$sw_name\"";
$result3=mysql_query($query3,$conn) or die(mysql_error());

$query4="UPDATE pp_receipt SET vendor = \"$tally_name\" WHERE vendor = \"$sw_name\"";
$result4=mysql_query($query4,$conn) or die(mysql_error());

$query5="UPDATE pp_payment SET vendor = \"$tally_name\" WHERE vendor = \"$sw_name\"";
$result5=mysql_query($query5,$conn) or die(mysql_error()); 

$query3="UPDATE oc_cobi SET party = \"$tally_name\" WHERE party = \"$sw_name\"";
$result3=mysql_query($query3,$conn) or die(mysql_error());

$query4="UPDATE oc_receipt SET party = \"$tally_name\" WHERE party = \"$sw_name\"";
$result4=mysql_query($query4,$conn) or die(mysql_error());

$query5="UPDATE oc_payment SET party = \"$tally_name\" WHERE party = \"$sw_name\"";
$result5=mysql_query($query5,$conn) or die(mysql_error());

$query6 = "UPDATE contactdetails SET name = \"$tally_name\" WHERE name = \"$sw_name\"";
$result6=mysql_query($query6,$conn) or die(mysql_error());
 }
?>
 <tr>
   <td><?php echo $i; ?></td>
   <td><?php echo $sw_name; ?></td>
   <td><?php echo $tally_name; ?></td>
 </tr>  
<?php				
}
else
{
 $errormsg = "";
 if($rows1 == 0)
  $errormsg = "The Name: $sw_name is not existing in the software.";
 if($rows1 > 1)
  $errormsg = "The Name: $sw_name is existing $rows1 times in the software.";
 elseif($sw_name == "")
  $errormsg = "Please enter Software Name";
 elseif($tally_name == "")
  $errormsg = "Please enter Tally Name";
?>
	<tr>
		<td><?php echo $i; ?></td>
		<td colspan="8" style="color:#FF0000;"><?php echo $errormsg; ?></td>
	</tr>
<?php
}				
				}	// End of if($col == $tocol
}    
          
        }
    }

   }

  }
 }
 else {
 print "Empty sheet<br>\n";
} 
print "<hr>\n";
}

?>
</table><br>
<center><input type="button" value="Back" onClick="javascript: history.go(-2)" /></center>
</body>
</html>