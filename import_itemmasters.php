<html>
<title>B.I.M.S</title>

<table id="tab1" align="center" cellspacing="0" cellpadding="2" border="2" width="900px">

<tr>
 <th width="20px">S.No</th>
 <th>Item Code</th>
 <th>Description</th>
 <th>Category</th>
 <th>Usage</th>
 <th>Source</th>
 <th>Type</th>
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
        if ($col == "8") { $data8 = htmlentities($data, ENT_QUOTES); }
        if ($col == "9") { $data9 = htmlentities($data, ENT_QUOTES); }
        if ($col == "10") { $data10 = htmlentities($data, ENT_QUOTES); }
        if ($col == "11") { $data11 = htmlentities($data, ENT_QUOTES); }
        if ($col == "12") { $data12 = htmlentities($data, ENT_QUOTES); }
        if ($col == "13") { $data13 = htmlentities($data, ENT_QUOTES); }
       
       
     
       
           
     $totalcol = "13";
        
                if ($col == $totalcol)
                {

$code = strtoupper($data0);
$desc = $data1;
$category = $data2;
//$warehouse = $data3;
$valuationmethod = $data3;		
$stdcost = $data4;
$sunits = $data5;
//$cunits = $data7;
$usage = $data6;
$source = $data7;
$type = $data8;
$iac = $data9;
//$pvac = $data12;
$wpac = $data10;
$cogsac = $data11;
$sac = $data12;
$srac = $data13;
//$lotserial = $data17;



$error = "0";
if($code == "")
 echo $error = "Please enter Item Code";
else
{
$query = "SELECT id FROM ims_itemcodes WHERE code = '$code' AND client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows1 = mysql_num_rows($result);
if($rows1 > 0) echo $error = "The Item Code: $code is existing in the software";
}

if($desc == "" && $error == "0")
 echo $error = "Please enter Description for Item Code: $code";

if($error == "0")
{ 
	$query = "SELECT type FROM ims_itemtypes WHERE type = '$category' AND client = '$client'";
	$result = mysql_query($query,$conn) or die(mysql_error());
	$rows2 = mysql_num_rows($result);
	if($rows2 == 0) echo $error = "The Category: $category is not there in there software";
}

//if($error == "0")
//{ 
//	$query = "select id from tbl_sector WHERE (type1 = 'Warehouse' or type1 = 'Chicken Center') AND sector = '$warehouse' AND client = '$client'";
//	$result = mysql_query($query,$conn) or die(mysql_error());
//	$rows3 = mysql_num_rows($result);
//	if($rows3 == 0) $error = "The Warehouse: $warehouse is not there in the software";
//}

if($valuationmethod == "" && $error == "0")
echo  $error = "Please select Valuation Method for Item Code: $code";
elseif($error == "0" && $valuationmethod == "Standard Costing" && $stdcost == "")
echo  $error = "Please enter Standard Cost Value for Item Code: $code";
elseif($stdcost == "")
 $stdcost = 0;

if($sunits == "" && $error == "0")
 echo $error = "Please enter Storage Units";
elseif($error == "0")
{ 
	$query = "SELECT sunits FROM ims_itemunits WHERE sunits = '$sunits' AND client = '$client'";
	$result = mysql_query($query,$conn) or die(mysql_error());
	$rows4 = mysql_num_rows($result);
	if($rows4 == 0)echo $error = "Storage Units: $sunits is not there in the software";
}

//if($cunits == "" && $error == "0")
// $error = "Please enter Consumption Units";
//elseif($error == "0")
//{ 
//	$query = "SELECT cunits FROM ims_itemunits WHERE cunits = '$cunits' AND client = '$client'";
//	$result = mysql_query($query,$conn) or die(mysql_error());
//	$rows5 = mysql_num_rows($result);
//	if($rows5 == 0) $error = "Consumption Units: $cunits is not there in the software";
//}

if($usage == "" && $error == "0")
echo $error = "Please select Usage for Item Code: $code";
if($source == "" && $error == "0")
 echo $error = "Please select Source for Item Code: $code";
if(type == "" && $error == "0")
echo  $error = "Please select Type for Item Code: $code";

if($iac == "" && $error == "0")
echo  $error = "Please enter Item A/c Code for Item Code: $code";

if($wpac == "" && $error == "0" && ($usage=="General Consumption" || $usage=="General Consumption Or Sale") )
echo $error = "Please enterConsumption A/c Code for Item Code: $code";


if( strlen(strstr($usage,'Sale'))>0 )
{
	if($cogsac == "" && $error == "0")
	echo $error = "Please enter COGS A/c Code for Item Code: $code";
	//elseif($error == "0")
//	{
//	$query = "SELECT id FROM ac_coa WHERE code = '$cogsac' AND client = '$client'";
//	$result = mysql_query($query,$conn) or die(mysql_error());
//	$rows5 = mysql_num_rows($result);
//	if($rows5 == 0) $error = "Please create COGS A/c Code: $cogsac in the software in Chart of Accounts Section";
//	}
	
	if($sac == "" && $error == "0")
	echo $error = "Please enter Sales A/c Code for Item Code: $code";
	//elseif($error == "0")
//	{
//	$query = "SELECT id FROM ac_coa WHERE code = '$sac' AND client = '$client'";
//	$result = mysql_query($query,$conn) or die(mysql_error());
//	$rows5 = mysql_num_rows($result);
//	if($rows5 == 0) $error = "Please create Sales A/c Code: $sac in the software in Chart of Accounts Section";
//	}
	
	if($srac == "" && $error == "0")
	echo $error = "Please enter Sales Return A/c Code for Item Code: $code";
	//elseif($error == "0")
//	{
//	$query = "SELECT id FROM ac_coa WHERE code = '$srac' AND client = '$client'";
//	$result = mysql_query($query,$conn) or die(mysql_error());
//	$rows5 = mysql_num_rows($result);
//	if($rows5 == 0) $error = "Please create Sales Return A/c Code: $srac in the software in Chart of Accounts Section";
//	}
}


if( strlen(strstr($usage,'General Consumption'))>0 )
{
	if($wpac == "" && $error == "0")
	echo $wpac = "Please enter Consumption A/c Code for Item Code: $code";
	 
}

if( strlen(strstr($usage,'General Consumption Or Sale'))>0 )
{
   if($wpac == "" && $error == "0")
	echo $wpac = "Please enter Consumption A/c Code for Item Code: $code";

	if($cogsac == "" && $error == "0")
	echo $error = "Please enter COGS A/c Code for Item Code: $code";
	 
	
	if($sac == "" && $error == "0")
	echo $error = "Please enter Sales A/c Code for Item Code: $code";
	 
	if($srac == "" && $error == "0")
	echo $error = "Please enter Sales Return A/c Code for Item Code: $code";
	
	 
}



//if($lotserial == "") $lotserial = "None";

$i++;
if($error == "0")
{
				
 $q = "INSERT INTO ims_itemcodes (code,description,cat,cm,sunits,iusage,source,stdcost,type,iac,cogsac,sac,srac,wpac,client) VALUES ('$code','$desc','$category','$valuationmethod','$sunits','$usage','$source','$stdcost','$type','$iac','$cogsac','$sac','$srac','$wpac','$client')";

$qrs = mysql_query($q,$conn) or die(mysql_error());

?>
 <tr>
   <td width="20px"><?php echo $i; ?></td>
   <td><?php echo $code; ?></td>
   <td><?php echo $desc; ?></td>
   <td><?php echo $category; ?></td>
   <td><?php echo $usage; ?></td>
   <td><?php echo $source; ?></td>
   <td><?php echo $type; ?></td>
 </tr>  
<?php				
}
else
{
?>
	<tr>
		<td align="center"><?php echo $i; ?></td>
		<td colspan="7" style="color:#FF0000;"><?php echo $error; ?></td>
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