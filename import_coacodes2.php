<html>
<title>B.I.M.S</title>

<table id="tab1" align="center" cellspacing="0" border="1">

<tr>
 <th>S.No</th>
 <th>COA Code</th>
 <th>Description</th>
 <th>Type</th>
 <th>Control Type</th>
 <th>Schedule</th>
</tr>

<?php
$i = 0;
 ini_set('display_errors', 0);
 ini_set('log_errors', 0);
 ini_set('error_reporting', E_ALL);

include 'ExcelExplorer2.php';
include "getemployee.php";
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
	  
	   
        if ($col == "0") { $data0 = htmlentities($data, ENT_QUOTES); }
        if ($col == "1") { $data1 = htmlentities($data, ENT_QUOTES); }
        if ($col == "2") { $data2 = htmlentities($data, ENT_QUOTES); }
        if ($col == "3") { $data3 = htmlentities($data, ENT_QUOTES); }
        if ($col == "4") { $data4 = htmlentities($data, ENT_QUOTES); }
     
       
           
          $totalcol = "4";
        
                if ($col == $totalcol)
                {

$coacode = strtoupper($data0);
$description = 	ucwords($data1);
$type = $data2;
$ctype = $data3;
$schedule = $data4;		

$query = "SELECT code FROM ac_coa WHERE code = '$coacode'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows1 = mysql_num_rows($result);

$query = "SELECT schedule FROM ac_schedule WHERE schedule = '$schedule'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows2 = mysql_num_rows($result);
$i++;
if($rows1 == 0 && $rows2 == 1 && $coacode <> "" && $description <> "" && $type <> "" && $schedule <> "")
{				
 $query="INSERT INTO ac_coa(id,code,description,type,controltype,schedule,flag,tflag) VALUES (NULL,'$coacode','$description','$type','$ctype','$schedule','0','0')";
 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());

 $query1 = "SELECT flag FROM ac_schedule WHERE schedule = '$schedule'";
 $get_entriess_res2 = mysql_query($query1,$conn) or die(mysql_error());
 while($row1 = mysql_fetch_assoc($get_entriess_res2))
 {
  $fg = $row1['flag'];
 }

 if($fg <> 'Fixed')
 {
   $query1 = "UPDATE ac_schedule SET flag = 'Used' WHERE schedule = '$schedule'" or die(mysql_error());
   $get_entriess_res2 = mysql_query($query1,$conn) or die(mysql_error());
 }
?>
 <tr>
   <td><?php echo $i; ?></td>
   <td><?php echo $coacode; ?></td>
   <td><?php echo $description; ?></td>
   <td><?php echo $type; ?></td>
   <td><?php echo $ctype; ?></td>
   <td><?php echo $schedule; ?></td>
 </tr>  
<?php				
}
else
{
 $errormsg = "";
 if($rows1 <> 0)
  $errormsg = "The COA Coade: $coacode is existing in the software. Please select different COA Code";
 else if($rows2 <> 1)
  $errormsg = "The Schedule: $schedule is not there in the software";
 else if($coacode == "")
  $errormsg = "Please enter COA Code";
 else if($description == "")
  $errormsg = "Please enter Description";
 else if($type == "")
  $errormsg = "Please select Type";
 else if($schedule == "")
  $errormsg = "Please enter Schedule";
?>
	<tr>
		<td><?php echo $i; ?></td>
		<td colspan="5" style="color:#FF0000;"><?php echo $errormsg; ?></td>
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
<center><input type="button" value="Back" onClick="document.location='dashboardsub.php?page=ac_coa'" /></center>
</body>
</html>