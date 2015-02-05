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
		$type = $_GET['type'];

 if($type == 'Credit') { $mode = 'Vendor Credit'; $mode1 = 'VCN'; }
 else if($type == 'Debit') { $mode = 'Vendor Debit'; $mode1 = 'VDN'; }

$q = "select max(crnum) as cnum from ac_crdrnote WHERE mode = '$mode1' and client = '$client' "; $qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs)) { $tnum = $qr['cnum']; }
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
 <h1><?php echo $mode;?> Note</h1>
<form id="form1" name="form1" method="post" action="pp_savecreditnote_excel.php">
<input type="hidden" name="type" id="type" value="<?php echo $_GET['type']; ?>" />
<input type="hidden" name="mode1" id="mode1" value="<?php echo $mode1; ?>" />
<table border="0"	align="center">
	<tr align="center">
<td align="right"><strong>Transaction No.</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="right"><strong>Date</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="right"><strong>Vendor</strong>&nbsp;&nbsp;&nbsp;</td>
<td align="right"><strong><?php if($type == "Credit") { ?><?php }?>Amount&nbsp;&nbsp;&nbsp;</strong></td>
<th><strong>Code</strong></th>
<th width="10px"></th>
<th><strong>Description</strong></th>
<th width="10px"></th>
<th><strong>Dr/Cr</strong></th>
<th width="10px"></th>
<th><strong>Dr</strong></th>
<th width="10px"></th>
<th><strong>Cr</strong></th>
<th width="10px"></th>
<th><strong>Dr Total</strong></th>
<th width="10px"></th>
<th><strong>Cr Total</strong></th> </tr>
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
      /*  if ($col == "5") { $data5 = htmlentities($data, ENT_QUOTES); }
		if ($col == "6") { $data6 = htmlentities($data, ENT_QUOTES); }
		if ($col == "7") { $data7 = htmlentities($data, ENT_QUOTES); } 
		if ($col == "8") { $data8 = htmlentities($data, ENT_QUOTES); }
        if ($col == "9") { $data9= htmlentities($data, ENT_QUOTES); }
        if ($col == "10") { $data10 = htmlentities($data, ENT_QUOTES); }
        if ($col == "11") { $data11 = htmlentities($data, ENT_QUOTES); }
        if ($col == "12") { $data12 = htmlentities($data, ENT_QUOTES); }
        if ($col == "13") { $data13 = htmlentities($data, ENT_QUOTES); }
		if ($col == "14") { $data14 = htmlentities($data, ENT_QUOTES); }
		if ($col == "15") { $data15 = htmlentities($data, ENT_QUOTES); }
		
		
       
	   if ($col == "16") { $data16 = htmlentities($data, ENT_QUOTES); } 
	   if ($col == "17") { $data17 = htmlentities($data, ENT_QUOTES); }
	   if ($col == "18") { $data18 = htmlentities($data, ENT_QUOTES); }
		if ($col == "19") { $data19 = htmlentities($data, ENT_QUOTES); }
		
		
       
	   if ($col == "20") { $data20 = htmlentities($data, ENT_QUOTES); } 
	   if ($col == "21") { $data21 = htmlentities($data, ENT_QUOTES); }
	   if ($col == "22") { $data22 = htmlentities($data, ENT_QUOTES); }
        if ($col == "18") { $data18 = htmlentities($data, ENT_QUOTES); }
        if ($col == "19") { $data19 = htmlentities($data, ENT_QUOTES); }
        if ($col == "20") { $data20 = htmlentities($data, ENT_QUOTES); }
        if ($col == "21") { $data21 = htmlentities($data, ENT_QUOTES); }
		if ($col == "22") { $data22 = htmlentities($data, ENT_QUOTES); }
		if ($col == "23") { $data23 = htmlentities($data, ENT_QUOTES); }   */
           
          $totalcol = "4";
        
                if ($col == $totalcol)
                {
				 ?>
			<tr>
<td align="left"><input size="3" type="text" id="tno" name="tno[]" value="<?php echo ++$tnum; ?>" readonly />&nbsp;&nbsp;</td>

<td><input type="text" size="11" id="date" class="datepicker" name="date[]" value="<?php echo date("d.m.Y",strtotime($data0)); ?>" /></td>
<td align="left"><select style="width: 170px"  name="vendor[]" id="vendor">
                <option value="">-Select-</option>
<?php $query = "SELECT distinct(name) FROM contactdetails where (type = 'vendor' OR type = 'vendor and party') and client = '$client'  ORDER BY name ASC"; $result = mysql_query($query,$conn);
     while($row1 = mysql_fetch_assoc($result)) {?>
  <option <?php if($row1['name']==strtoupper($data1)) echo 'selected="selected" '; ?> title="<?php echo $row1['name'];?>" value="<?php echo $row1['name'];?>"><?php echo $row1['name']; ?></option>
<?php } ?></select>&nbsp;&nbsp;</td>

<td align="left"><input size="8" type="text" value="<?php  echo $data2; ?>" style="text-align:right;" size="15" id="vendamount" name="vendamount[]" value="" onChange="total();"  /></td>
<td><select id="code1" name="code[]" style="width:80px"><option value="">-Select-</option>
    <?php $q = "select code,description from ac_coa WHERE type = 'Expense' or type = 'Revenue' and client = '$client'  order by code "; $qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs)) { ?>
    <option <?php if($qr['code']==$data3) echo 'selected="selected" '; ?> title="<?php echo $qr['description']; ?>" value="<?php echo $qr['code']; ?>"><?php echo $qr['code']; ?></option>
    <?php } ?></select></td>
<td width="10px"></td>
<td><select id="desc1" name="desc[]" style="width:170px"><option value="">-Select-</option>
    <?php $q = "select code,description from ac_coa WHERE type = 'Expense' or type = 'Revenue' and client = '$client'  order by description "; 
	$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs)) { ?>
    <option <?php if($qr['code']==$data3) echo 'selected="selected" '; ?> title="<?php echo $qr['code']; ?>" value="<?php echo $qr['description']; ?>"><?php echo $qr['description']; ?></option>
    <?php } ?></select></td>
<td width="10px"></td>
<td><select id="drcr1" name="drcr[]" ><option value="">-Select-</option><option <?php if('Cr'==$data4) echo 'selected="selected" '; ?> value="Cr">Cr</option><option <?php if('Dr'==$data4) echo 'selected="selected" '; ?> value="Dr">Dr</option></select></td>
<td width="10px"></td>
<td><input type="text"  value="<?php if('Dr'==$data4) echo $data2; ?>" id="dramount1" name="dramount[]" value="0" style="text-align:right" size="8"  readonly /></td>
<td width="10px"></td>
<td><input type="text" value="<?php  if('Cr'==$data4) echo $data2; ?>"  id="cramount1" name="cramount[]" value="0" style="text-align:right" size="8"  readonly /></td>
<td width="10px"></td>
<td align="right"><input  value="<?php if('Dr'==$data4) echo $data2; ?>"  type="text" id="drtotal" style="text-align:right;background:none;border:none;" name="drtotal[]" value="0" size="8" align="right" readonly  /></td>
<td width="10px"></td>
<td align="right"><input value="<?php if('Cr'==$data4) echo $data2; ?>" type="text" id="crtotal" style="text-align:right;background:none;border:none;" name="crtotal[]" value="0" size="8" align="right" readonly /></td>
</tr>

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
<center>
<input type="submit" value="Save" id="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=';"> </center>
</form> 
</body>
</html>