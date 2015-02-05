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
 ?>

     <form class="block-content form" style="height:600px" id="complex_form" method="post" action="Layer/layer_savebookentrydepro.php" >
	 <?php $age=$_POST[age];
	       $house=$_POST[house]; ?>
	  <h1 id="title1">Layer Book Entry</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>
			  
			  (Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
			  <br />
<br />

<table border="0px" id="inputs">
     <tr height="20px"><td></td></tr>
     <tr>
        <th style="text-align:left"><strong></strong></th>
        <th width="10px"></th>
        <th style="text-align:left"><strong></strong></th>
        <th width="10px"></th>
        <th style="text-align:left"><strong></strong></th>
        <th width="10px"></th>
       <th style="text-align:left" colspan="16"><strong style="color:red"><center>Productions</center></strong></th>
     </tr>

     <tr style="height:20px"></tr>

     <tr>
 
        <th style="text-align:left"><strong>House</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
        <th width="10px"></th>
        <th style="text-align:left"><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
        <th width="10px"></th>
        <th style="text-align:left"><strong>Age</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
        <th width="10px"></th>
       <th style="text-align:left"><strong>E.Wt</strong></th>
	   <th width="10px"></th>
        <?php
             
             $query = "SELECT code,description FROM ims_itemcodes where cat = 'Layer Eggs' and client = '$client'  ORDER BY code DESC ";
             $result = mysql_query($query,$conn); 
             while($row1 = mysql_fetch_assoc($result))
             {
        ?>
        <th style="text-align:left" title="<?php echo $row1['description']; ?>"><strong><?php echo substr($row1['code'],3); ?></strong></th>
        <th width="10px"></th>
        <?php } ?>
     </tr>

    
<?php
for( $sheet=0; $sheet<$ee->GetWorksheetsNum(); $sheet++ ) {
  print 'Sheet: '.$ee->AsHTML($ee->GetWorksheetTitle($sheet))."<br>\n";
$bank = $ee->AsHTML($ee->GetWorksheetTitle($sheet));
$bank = substr_replace($bank,"",-4); 
?>
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
        if ($col == "9") { $data9= htmlentities($data, ENT_QUOTES); }
          if ($col == "10") { $data10 = htmlentities($data, ENT_QUOTES); }
        if ($col == "11") { $data11 = htmlentities($data, ENT_QUOTES); }
        if ($col == "12") { $data12 = htmlentities($data, ENT_QUOTES); }
        if ($col == "13") { $data13 = htmlentities($data, ENT_QUOTES); }
	/*	if ($col == "14") { $data14 = htmlentities($data, ENT_QUOTES); }
		if ($col == "15") { $data15 = htmlentities($data, ENT_QUOTES); }
		if ($col == "16") { $data16 = htmlentities($data, ENT_QUOTES); } 
	    if ($col == "17") { $data17 = htmlentities($data, ENT_QUOTES); }
      if ($col == "18") { $data18 = htmlentities($data, ENT_QUOTES); }
        if ($col == "19") { $data19 = htmlentities($data, ENT_QUOTES); }
        if ($col == "20") { $data20 = htmlentities($data, ENT_QUOTES); }
        if ($col == "21") { $data21 = htmlentities($data, ENT_QUOTES); }
		if ($col == "22") { $data22 = htmlentities($data, ENT_QUOTES); }
		if ($col == "23") { $data23 = htmlentities($data, ENT_QUOTES); }   */
           
          $totalcol = "13";
        
                if ($col == $totalcol and $data != '')
                { ?>
				
				 <tr style="height:20px"></tr>

   <tr>
<td style="text-align:left;">
<input type="text" name="flock[]" id="flock0" size="10" value="<?php echo $house; ?>" readonly />
       </td>
     <td width="10px"></td>
       <td style="text-align:left;">
         <input type="text" name="date[]" id="date0" value="<?php echo $data0; ?>" size="10" readonly /> 
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <input type="text" name="age[]" id="age0" value="<?php echo $age++; ?>" size="3" /> 
       </td>
       <td width="10px"></td>
      <td style="text-align:left;">
         <input type="text" name="eggwt[]" id="value0" value="0" size="3" /> 
       </td>
       <td width="10px"></td>
       <?php
             $i=1;
			
             $query = "SELECT code FROM ims_itemcodes where cat = 'Layer Eggs' and client = '$client'  ORDER BY code DESC ";
             $result = mysql_query($query,$conn); 
             while($row1 = mysql_fetch_assoc($result))
             {  $data='data'.$i; $i++;
        ?>
       <td style="text-align:left;">
         <input type="text" name="<?php echo $row1['code']; ?>[]" id="value0" value="<?php echo $$data ?>" size="3" /> 
       </td>
       <td width="10px"></td>
       <?php } ?>
    </tr>

 
</table>
<table>
			<?php	
				}
}

    // print "Column: $col, row: $row, type: \"$type\", value: \"$data\"<br>\n";
     
          
        }
    }

   }

  }
  
  
 }
 else {
 // print "Empty sheet<br>\n";
} 

//End Of Feed Sales Import

// print "<hr>\n";
}
	/*	$fp = fopen ("production/importsales.sql","a");
		fwrite ($fp,$query);
		fclose ($fp); */

?>

</table>
</center>
<br /><br />



<input type="submit" value="Save" id="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=tallysales';">


</center>
</form>
</body>
</html>