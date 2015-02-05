<html>
<title>B.I.M.S</title>

<table id="tab1" align="center" cellspacing="0" cellpadding="2" border="2" width="900px">

<tr>
 <th>S.No</th>
 <th>Code</th>
 <th>Name</th>
 <th>Address</th>
 <th>Place</th>
 <th>Phone</th>
 <th>Mobile</th>
 <th>Contact Type</th>
 <th>PAN/TIN</th>
 <th>Group</th>
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
	  
	   
        if ($col == "0") { $data0 = htmlentities($data, ENT_QUOTES); }
        if ($col == "1") { $data1 = htmlentities($data, ENT_QUOTES); }
        if ($col == "2") { $data2 = htmlentities($data, ENT_QUOTES); }
        if ($col == "3") { $data3 = htmlentities($data, ENT_QUOTES); }
        if ($col == "4") { $data4 = htmlentities($data, ENT_QUOTES); }
        if ($col == "5") { $data5 = htmlentities($data, ENT_QUOTES); }
        if ($col == "6") { $data6 = htmlentities($data, ENT_QUOTES); }
        if ($col == "7") { $data7 = htmlentities($data, ENT_QUOTES); }
		if ($col == "8") { $data7 = htmlentities($data, ENT_QUOTES); }
     
       
           
          $totalcol = "8";
        
                if ($col == $totalcol)
                {
$code = $data0;
$name = strtoupper($data1);
$addr = $data2;
$place = $data3;
$phone = $data4;
$mobile = $data5;		
$contacttype = $data6;
$pan = $data7;
$group = $data8;

if($contacttype == 'Supplier')
{
 $flag = 'V';
 $type = 'vendor';
}
elseif($contacttype == 'Customer')
{
 $flag = 'C';
 $type = 'party';
}
elseif($contacttype == 'Broker')
{
 $flag = '';
 $type = 'broker';
}
else
{
 $flag = 'V';
 $type = 'vendor and party';
}
 
$query = "SELECT name FROM contactdetails WHERE name = '$name'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows1 = mysql_num_rows($result);

$query = "SELECT code FROM contactdetails WHERE name = '$code'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rowscode = mysql_num_rows($result);

$i++;
if($rows1 == 0 && $name <> "" && $contacttype <> "" && $name <> "" && $rowscode == 0)
{				
$cterm = $vgroup = $va = $vppa = $cgroup = $ca = $cac = '';
if($flag <> '')
{
 $query = "SELECT * FROM ac_vgrmap WHERE flag = '$flag'";
 $result = mysql_query($query,$conn) or die(mysql_error());
 $rows = mysql_fetch_assoc($result);
 if($flag == 'V')
 {
  $vgroup = $rows['vgroup'];
  $va = $rows['vca'];
  $vppa = $rows['vppac'];
 }
 elseif($flag == 'C')
 {
  $cgroup = $rows['vgroup'];
  $ca = $rows['vca'];
  $cac = $rows['vppac'];
 }
 if($contacttype == 'Supplier and Customer')
 {
 $q1 = "SELECT * FROM ac_vgrmap WHERE flag = 'C'";
 $r1 = mysql_query($q1,$conn) or die(mysql_error());
 $rows = mysql_fetch_assoc($r1);
  $cgroup = $rows['vgroup'];
  $ca = $rows['vca'];
  $cac = $rows['vppac'];
 }
}


 $query="INSERT INTO contactdetails (id,code,name,address,phone,mobile,type,note,place,pan,cterm,vgroup,va,vppa,cgroup,ca,cac,client)
 VALUES (NULL,'$code','$name','$addr','$phone','$mobile','$type','$note','$place','$pan','$cterm','$vgroup','$va','$vppa','$cgroup','$ca','$cac','$client')";
 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());


?>
 <tr>
   <td><?php echo $i; ?></td>
    <td><?php echo $code; ?></td>
   <td><?php echo $name; ?></td>
   <td><?php echo $addr; ?></td>
   <td><?php echo $place; ?></td>
   <td><?php echo $phone; ?></td>
   <td><?php echo $mobile; ?></td>
   <td><?php echo $contacttype; ?></td>
   <td><?php echo $pan; ?></td>
   <td><?php echo $group; ?></td>
 </tr>  
<?php				
}
else
{
 $errormsg = "";
 if($rows1 <> 0)
  $errormsg = "The Name: $name is existing in the software. Please enter different Name";
 elseif($rowscode <> 0)
  $errormsg = "The Name: $code is existing in the software. Please enter different Code";
 elseif($name == "")
  $errormsg = "Please enter Name";
 elseif($contacttype == "")
  $errormsg = "Please select Contact Type";
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